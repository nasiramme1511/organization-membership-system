<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'User not found')->withInput();
        }

        $otp = sprintf('%06d', random_int(0, 999999));
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Log OTP for testing (simulate SMS/Email)
        Log::info("OTP for {$user->email}: {$otp}");

        // In production, integrate with SMS/Email service
        // Mail::to($user->email)->send(new OTPEmail($otp));

        return back()->with('status', 'OTP sent! Check logs or your email.');
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'User not found')->withInput();
        }

        if ($user->otp_code !== $request->otp_code) {
            return back()->with('error', 'Invalid OTP')->withInput();
        }

        if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'OTP expired')->withInput();
        }

        // Mark as verified
        $user->is_verified = true;
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect('/login')->with('status', 'Account verified! Please login.');
    }
}
