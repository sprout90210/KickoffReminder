<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LineMessagingService;
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
            $user = User::firstOrCreate(
                ['line_user_id' => $line_user->id],
                ['name' => $line_user->name]
            );
            
            Auth::login($user, true);
            
            return redirect('/?line_login=success');

        } catch (Exception $e) {
            return redirect('/?line_login=failed');
        }
    }
}
