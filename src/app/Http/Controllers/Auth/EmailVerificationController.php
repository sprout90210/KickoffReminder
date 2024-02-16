<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationEmailRequest;
use App\Mail\VerifyEmail;
use App\Models\PendingUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(SendVerificationEmailRequest $request)
    {
        PendingUser::where('email', $request->email)->delete();

        $pendingUser = PendingUser::create([
            'email' => $request->email,
            'token' => Str::random(60),
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::send(new VerifyEmail($pendingUser));

        return response()->noContent();
    }

    public function verify($token)
    {
        $pendingUser = PendingUser::where('token', $token)
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();

        if (!$pendingUser) {
            return redirect('/?token=invalid');
        }
        return redirect('/registration?email=' . urlencode($pendingUser->email) . '&token=' . $token);
    }
}
