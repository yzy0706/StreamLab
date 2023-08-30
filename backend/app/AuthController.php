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
        // 1. Redirect to OAuth provider (GitHub in this example)
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            // 2. Receive OAuth callback
            $socialiteUser = Socialite::driver($provider)->user();
            
            // 3. Fetch user details from the provider
            $name = $socialiteUser->getName();
            $email = $socialiteUser->getEmail();
            $providerId = $socialiteUser->getId();
            
            // 4. Create or update user in the local database
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'provider_id' => $providerId]
            );
            
            // 5. Issue a JWT or session for the logged-in user
            Auth::login($user, true);
            
            return redirect('/home'); // Redirect to the home page or wherever you want
            
        } catch (\Exception $e) {
            // Handle exceptions (e.g., token expiry, user cancellation, etc.)
            return redirect('/login'); // Redirect back to login page
        }
    }
}
    