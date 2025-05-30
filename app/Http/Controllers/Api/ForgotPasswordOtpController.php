<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordOtpController extends Controller
{
    public function showRequestForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan ke database
        DB::table('password_resets_otp')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'created_at' => now()]
        );

        try {
            Mail::to($request->email)->send(new SendOtpMail($otp));
            Log::info("Email berhasil dikirim ke: {$request->email}");
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email: " . $e->getMessage());
            return back()->with('error', 'Gagal mengirim OTP: ' . $e->getMessage());
        }


        session(['email' => $request->email]);

        return redirect()->route('forgot.otp.input')->with('status', 'OTP berhasil dikirim.');
    }


    public function showOtpForm()
    {
        return view('pages.auth.input-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpData = DB::table('password_resets_otp')->where('email', $request->email)->first();

        if (!$otpData || $otpData->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'OTP tidak valid']);
        }

        if (Carbon::parse($otpData->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors(['otp' => 'OTP sudah kadaluarsa']);
        }

        session([
            'email' => $request->email,
            'otp' => $request->otp
        ]);

        return redirect()->route('forgot.password.form');
    }

    public function showResetForm()
    {
        return view('pages.auth.reset-password', [
            'email' => session('email'),
            'otp' => session('otp')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        // Verifikasi OTP secara langsung
        $otpData = DB::table('password_resets_otp')->where('email', $request->email)->first();

        if (!$otpData || $otpData->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'OTP tidak valid']);
        }

        if (Carbon::parse($otpData->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors(['otp' => 'OTP sudah kadaluarsa']);
        }

        // Update password user
        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus OTP setelah digunakan
        DB::table('password_resets_otp')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password berhasil direset.');
    }
}
