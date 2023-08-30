<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function oauthLogin($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
            
            $name = $socialiteUser->getName();
            $email = $socialiteUser->getEmail();
            $providerId = $socialiteUser->getId();
            
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'provider_id' => $providerId]
            );
            
            Auth::login($user, true);
            
            return redirect('/home');
            
        } catch (\Exception $e) {
            return redirect('/login');
        }
    }
}