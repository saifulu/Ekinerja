<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'nip' => 'nullable|string|max:50',
            'golongan' => 'nullable|string|max:100',
            'instansi' => 'nullable|string|max:255',
            'ruangan' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->nip = $request->nip;
        $user->golongan = $request->golongan;
        $user->instansi = $request->instansi;
        $user->ruangan = $request->ruangan;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }
}
