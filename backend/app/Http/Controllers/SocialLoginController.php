<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

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
            $msg = 'Fitur Login Google belum aktif: GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env masih bernilai default/kosong. Harap daftarkan kredensial di Google Cloud Console.';
            return redirect('/login?error=' . urlencode($msg))->with('error', $msg);
        }

        try {
            return Socialite::driver('google')->stateless()->redirect();
        } catch (Throwable $exception) {
            Log::error('Google redirect failed.', ['exception' => $exception]);

            $msg = 'Gagal menghubungi layanan Google: ' . $exception->getMessage();
            return redirect('/login?error=' . urlencode($msg))->with('error', $msg);
        }
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            // Gunakan stateless() agar tidak terpengaruh cookie/session state drop di production (HTTPS/proxy/SameSite)
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (! $googleUser || empty($googleUser->email)) {
                $msg = 'Gagal mengambil data akun Google Anda.';
                return redirect('/login?error=' . urlencode($msg))->with('error', $msg);
            }

            // Cari apakah user dengan email atau google_id tersebut sudah terdaftar
            $email = mb_strtolower(trim($googleUser->email));

            $user = User::whereRaw('LOWER(email) = ?', [$email])
                ->orWhere('google_id', $googleUser->id)
                ->first();

            if ($user) {
                // KASUS 1: USER SUDAH TERDAFTAR SEBELUMNYA
                // Hubungkan google_id jika belum terisi
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->id]);
                }

                // Buat token autentikasi Sanctum (24 jam)
                $token = $user->createToken('auth_token', ['*'], now()->addHours(24))->plainTextToken;

                // Tampilkan halaman callback untuk menyimpan session ke localStorage dan redirect ke dashboard
                return view('auth-callback', [
                    'token' => $token,
                    'user' => $user,
                ]);
            } else {
                // KASUS 2: USER BARU (BELUM ADA DI DATABASE)
                // Arahkan ke form registrasi untuk melengkapi NIP, Golongan, Instansi, dll.
                // Data Nama & Email otomatis terisi (pre-filled) dari akun Google
                $queryParams = http_build_query([
                    'from_google' => 1,
                    'name' => $googleUser->name ?? $googleUser->nickname ?? '',
                    'email' => $email,
                    'google_id' => $googleUser->id,
                ]);

                return redirect('/register?'.$queryParams);
            }

        } catch (InvalidStateException $exception) {
            Log::warning('Google callback state did not match the login session.', [
                'exception' => $exception,
            ]);

            $msg = 'Sesi login Google kedaluwarsa atau cookie browser tidak terbaca. Silakan coba lagi.';
            return redirect('/login?error=' . urlencode($msg))->with('error', $msg);
        } catch (Throwable $exception) {
            Log::error('Google callback failed.', ['exception' => $exception]);

            $errorMsg = 'Login Google gagal: ' . $exception->getMessage();
            return redirect('/login?error=' . urlencode($errorMsg))->with('error', $errorMsg);
        }
    }
}
