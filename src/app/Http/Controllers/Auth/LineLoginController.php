<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Socialite;

class LineLoginController extends Controller
{
    public function redirectToLine()
    {
        return Socialite::driver('line')->redirect();
    }

    public function handleLineCallback()
    {
        try {
            $line_user = Socialite::driver('line')->user();

            $user = User::updateOrCreate(
                ['line_user_id' => $line_user->id],
                ['name' => $line_user->name]
            );

            Auth::login($user, true);

            return redirect('/?line_login=success');

        } catch (\Exception $e) {
            Log::error('LINE login error: '.$e->getMessage());

            return redirect('/?line_login=failed');
        }
    }
}
