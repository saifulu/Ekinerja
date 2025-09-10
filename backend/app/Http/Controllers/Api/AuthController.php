<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s]+$/',
            'nip' => 'nullable|string|max:50|regex:/^[0-9]+$/',
            'golongan' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\/\s]+$/',
            'instansi' => 'nullable|string|max:255',
            'ruangan' => 'nullable|string|max:255',
            'role' => 'sometimes|in:admin,user'
        ], [
            'password.regex' => 'Password harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka, dan 1 karakter khusus',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi',
            'phone.regex' => 'Nomor telepon hanya boleh mengandung angka, +, -, dan spasi',
            'nip.regex' => 'NIP hanya boleh mengandung angka'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Sanitasi input
        $sanitizedData = [
            'name' => strip_tags(trim($request->name)),
            'email' => filter_var(trim($request->email), FILTER_SANITIZE_EMAIL),
            'password' => Hash::make($request->password),
            'phone' => $request->phone ? preg_replace('/[^0-9+\-\s]/', '', $request->phone) : null,
            'nip' => $request->nip ? preg_replace('/[^0-9]/', '', $request->nip) : null,
            'golongan' => $request->golongan ? strip_tags(trim($request->golongan)) : null,
            'instansi' => $request->instansi ? strip_tags(trim($request->instansi)) : null,
            'ruangan' => $request->ruangan ? strip_tags(trim($request->ruangan)) : null,
            'role' => $request->role ?? 'user'
        ];
    
        $user = User::create($sanitizedData);
    
        $token = $user->createToken('auth_token', ['*'], now()->addHours(24))->plainTextToken;
    
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user->makeHidden(['password']),
                'token' => $token
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Sanitasi input
        $email = filter_var(trim($request->email), FILTER_SANITIZE_EMAIL);
        $password = $request->password;
    
        // Rate limiting untuk login attempts
        $key = 'login_attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many login attempts. Please try again in ' . RateLimiter::availableIn($key) . ' seconds.'
            ], 429);
        }
    
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            RateLimiter::hit($key, 900); // 15 minutes lockout
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
    
        RateLimiter::clear($key);
        
        $user = Auth::user();
        $token = $user->createToken('auth_token', ['*'], now()->addHours(24))->plainTextToken;
    
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user->makeHidden(['password']),
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'nip' => 'nullable|string|max:50',
            'golongan' => 'nullable|string|max:100',
            'instansi' => 'nullable|string|max:255',
            'ruangan' => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Jika user ingin mengubah password
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is required to change password'
                ], 422);
            }
    
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 422);
            }
    
            $user->password = Hash::make($request->new_password);
        }
    
        // Update data profil termasuk field baru
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->nip = $request->nip;
        $user->golongan = $request->golongan;
        $user->instansi = $request->instansi;
        $user->ruangan = $request->ruangan;
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}
