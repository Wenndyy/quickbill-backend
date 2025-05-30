<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response([
                'message' => ['Email not found'],
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Password is wrong'],
            ], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_resets_otp')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'created_at' => now()]
        );

        try {
            Mail::to($request->email)->send(new SendOtpMail($otp));
            Log::info("Email berhasil dikirim ke: {$request->email}");
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email: " . $e->getMessage());

            // Tambahkan ini untuk API error
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Gagal mengirim email OTP'], 500);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'OTP berhasil dikirim ke email Anda.'
            ], 200);
        }

        // default untuk browser (web)
        session(['email' => $request->email]);
        return redirect()->route('forgot.otp.input')->with('status', 'OTP berhasil dikirim ke email.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpData = DB::table('password_resets_otp')->where('email', $request->email)->first();

        if (!$otpData || $otpData->otp !== $request->otp) {
            return response()->json(['message' => 'OTP tidak valid'], 422);
        }

        if (Carbon::parse($otpData->created_at)->addMinutes(15)->isPast()) {
            return response()->json(['message' => 'OTP sudah kadaluarsa'], 422);
        }

        return response()->json(['message' => 'OTP valid']);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $otpData = DB::table('password_resets_otp')->where('email', $request->email)->first();

        if (!$otpData || $otpData->otp !== $request->otp) {
            return response()->json(['message' => 'OTP tidak valid'], 422);
        }

        if (Carbon::parse($otpData->created_at)->addMinutes(15)->isPast()) {
            return response()->json(['message' => 'OTP sudah kadaluarsa'], 422);
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets_otp')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password berhasil direset']);
    }

}
