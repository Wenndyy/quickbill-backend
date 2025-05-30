#!/usr/bin/env python3
import sys
import os

# Remove the problematic path that causes version conflicts
# DO NOT mix Python 3.11 with Python 3.13 packages

import json
from datetime import datetime, timedelta

# Test import first
try:
    import google.generativeai as genai
    print("✅ Berhasil mengimpor google-generativeai", file=sys.stderr)
    print(f"Versi: {genai.__version__}", file=sys.stderr)
except Exception as e:
    print(f"❌ Gagal mengimpor: {str(e)}", file=sys.stderr)
    # Show Python info for debugging
    print(f"Python executable: {sys.executable}", file=sys.stderr)
    print(f"Python version: {sys.version}", file=sys.stderr)
    print(f"Python path: {sys.path[:3]}", file=sys.stderr)
    sys.exit(1)

def configure_gemini(api_key):
    """Configure Gemini AI with API key"""
    try:
        genai.configure(api_key=api_key)
        return True
    except Exception as e:
        print(f"Error configuring Gemini: {str(e)}", file=sys.stderr)
        return False

def generate_prediction(model, sales_data):
    """Generate sales prediction using Gemini"""
    # Convert sales_data to JSON string first
    sales_data_json = json.dumps(sales_data, indent=2)

    prompt = f"""Anda adalah sistem prediksi penjualan. Berdasarkan data historis berikut:
{sales_data_json}

Tugas:
1. Hitung rata-rata penjualan harian per produk
2. Prediksi total penjualan 7 hari ke depan (rata-rata harian x 7)
3. Berikan hasil dalam format JSON berikut:

[{{
    "product_id": 1,
    "product_name": "Nama Produk",
    "predicted_next_7_days": 100
}}]

Jangan sertakan teks penjelasan!"""

    try:
        response = model.generate_content(prompt)

        print(f"Debug - Response type: {type(response)}", file=sys.stderr)
        print(f"Debug - Has parts: {hasattr(response, 'parts')}", file=sys.stderr)

        if not hasattr(response, 'parts') or not response.parts:
            raise ValueError("Empty response from Gemini")

        # Extract clean JSON from response
        response_text = response.text.replace("```json", "").replace("```", "").strip()
        print(f"Debug - Response text: {response_text[:200]}...", file=sys.stderr)

        # Try to parse JSON
        try:
            parsed_result = json.loads(response_text)
            return parsed_result
        except json.JSONDecodeError as json_err:
            print(f"JSON parsing error: {json_err}", file=sys.stderr)
            print(f"Raw response: {response_text}", file=sys.stderr)

            # Try to extract JSON from response if it's wrapped in other text
            import re
            json_match = re.search(r'\[.*\]', response_text, re.DOTALL)
            if json_match:
                try:
                    return json.loads(json_match.group())
                except:
                    pass

            # Return empty result if can't parse
            return []

    except Exception as e:
        print(f"Prediction error: {str(e)}", file=sys.stderr)
        return []

def main(file_path):
    try:
        # Check if file exists
        if not os.path.exists(file_path):
            print(f"Error: File '{file_path}' not found", file=sys.stderr)
            print(json.dumps([]))
            return

        # Load sales data
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                sales_data = json.load(f)
            print(f"Debug - Loaded data: {type(sales_data)}, length: {len(sales_data) if isinstance(sales_data, (list, dict)) else 'N/A'}", file=sys.stderr)
        except json.JSONDecodeError as e:
            print(f"Error: Invalid JSON in file '{file_path}': {e}", file=sys.stderr)
            print(json.dumps([]))
            return
        except Exception as e:
            print(f"Error reading file '{file_path}': {e}", file=sys.stderr)
            print(json.dumps([]))
            return

        # Initialize Gemini
        API_KEY = "AIzaSyAzW3O17sUNN1VwcG0cNRGHzYMU4gMWtdY"  # Replace with real API key
        if not configure_gemini(API_KEY):
            print(json.dumps([]))
            return

        # Initialize model
        try:
            model = genai.GenerativeModel('gemini-2.0-flash-exp')  # Try experimental first
        except:
            try:
                model = genai.GenerativeModel('gemini-pro')  # Fallback to pro
            except Exception as e:
                print(f"Error initializing model: {e}", file=sys.stderr)
                print(json.dumps([]))
                return

        # Generate prediction
        prediction = generate_prediction(model, sales_data)

        # Ensure output is valid
        if not isinstance(prediction, list):
            prediction = []

        print(json.dumps(prediction, ensure_ascii=False, indent=2))

    except Exception as e:
        print(f"System error: {str(e)}", file=sys.stderr)
        print(json.dumps([]))

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python gemini_predict.py <data_file_path>", file=sys.stderr)
        sys.exit(1)

    main(sys.argv[1])
