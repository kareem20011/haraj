<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Generate a reset token and expiration
        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);

        // Save reset token to the database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Send the reset link via email
        $resetLink = route('password.reset', ['token' => $token]);

        // Send an email to the user (optional, depends on your email setup)
        Mail::send('auth.passwords.email', ['resetLink' => $resetLink], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset Request');
        });

        return response()->json(['message' => 'Password reset link sent!'], 200);
    }

    public function resetPassword(Request $request)
    {
        // Validate the reset request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if token is valid and not expired
        $resetRecord = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$resetRecord) {
            return response()->json(['message' => 'This reset link is invalid or expired.'], 400);
        }

        // Check if the email matches the token
        if ($resetRecord->email !== $request->email) {
            return response()->json(['message' => 'Email does not match the token.'], 400);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset record after successful password reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully.'], 200);
    }
}
