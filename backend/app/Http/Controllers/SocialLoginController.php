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
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        // Check if Google credentials are configured in .env
        if (empty($clientId) || $clientId === 'your-google-client-id' || empty($clientSecret) || $clientSecret === 'your-google-client-secret') {
            return redirect('/login')->with('error', 'Fitur Login Google belum aktif: GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env masih bernilai default/kosong. Harap daftarkan kredensial di Google Cloud Console.');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            \Log::error('Google Redirect Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal menghubungi server autentikasi Google: ' . $e->getMessage());
        }
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser || empty($googleUser->email)) {
                return redirect('/login')->with('error', 'Gagal mengambil data akun Google Anda.');
            }

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If user exists, update their google_id if it's empty
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                // Create a new user from Google
                $user = User::create([
                    'name' => $googleUser->name ?? $googleUser->nickname ?? 'Pengguna Google',
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null,
                    'role' => 'user', // default role
                ]);
            }

            // Generate a Sanctum token for API authentication
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return a view that will save the token to localStorage and redirect
            return view('auth-callback', [
                'token' => $token,
                'user' => $user
            ]);

        } catch (Exception $e) {
            \Log::error('Google Callback Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Autentikasi Google dibatalkan atau gagal: ' . $e->getMessage());
        }
    }
}
