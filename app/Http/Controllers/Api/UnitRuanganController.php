<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnitRuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UnitRuanganController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Filter data berdasarkan NIP user yang login
            $unitRuangan = UnitRuangan::with('user')
                ->where('nip', $user->nip)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $unitRuangan,
                'message' => 'Data unit ruangan berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $unitRuangan = UnitRuangan::create([
                'nip' => $user->nip,
                'nama_ruangan' => $request->nama_ruangan
            ]);

            $unitRuangan->load('user');

            return response()->json([
                'success' => true,
                'data' => $unitRuangan,
                'message' => 'Unit ruangan berhasil ditambahkan'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = Auth::user();
            
            $unitRuangan = UnitRuangan::with('user')
                ->where('id', $id)
                ->where('nip', $user->nip)
                ->first();

            if (!$unitRuangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unit ruangan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $unitRuangan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            $unitRuangan = UnitRuangan::where('id', $id)
                ->where('nip', $user->nip)
                ->first();

            if (!$unitRuangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unit ruangan tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $unitRuangan->update([
                'nama_ruangan' => $request->nama_ruangan
            ]);

            $unitRuangan->load('user');

            return response()->json([
                'success' => true,
                'data' => $unitRuangan,
                'message' => 'Unit ruangan berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            
            $unitRuangan = UnitRuangan::where('id', $id)
                ->where('nip', $user->nip)
                ->first();

            if (!$unitRuangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unit ruangan tidak ditemukan'
                ], 404);
            }

            $unitRuangan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Unit ruangan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}