<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If user exists, update their google_id if it's empty
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null,
                    'role' => 'user', // default role
                ]);
            }

            // Generate a token for the user using Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return a view that will save the token to localStorage and redirect
            return view('auth-callback', [
                'token' => $token,
                'user' => $user
            ]);

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}
