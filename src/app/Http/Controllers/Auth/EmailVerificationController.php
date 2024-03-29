<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationEmailRequest;
use App\Mail\VerifyEmail;
use App\Models\PendingUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(SendVerificationEmailRequest $request)
    {
        $pendingUser = PendingUser::updateOrCreate(
            ['email' => $request->email],
            ['token' => Str::random(60)]
        );

        Mail::send(new VerifyEmail($pendingUser));

        return response()->noContent();
    }

    public function verify($token)
    {
        $pendingUser = PendingUser::where('token', $token)
            ->where('updated_at', '>', now()->subMinutes(60))
            ->first();

        if (! $pendingUser) {
            return redirect(URL::to('/?token=invalid'));
        }

        Auth::guard('web')->logout();

        return redirect(URL::to('/registration?email='.urlencode($pendingUser->email).'&token='.$token));
    }
}
