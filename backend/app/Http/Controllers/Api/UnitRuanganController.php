<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnitRuangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UnitRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Ambil data unit ruangan berdasarkan NIP user yang login
            $unitRuangan = UnitRuangan::with('user')
                ->where('nip', $user->nip)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data unit ruangan berhasil diambil',
                'data' => $unitRuangan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $unitRuangan = UnitRuangan::create([
                'nip' => $user->nip,
                'nama_pegawai' => $user->name, // Tambahkan ini
                'nama_ruangan' => $request->nama_ruangan,
            ]);
    
            // Load relationship
            $unitRuangan->load('user');
    
            return response()->json([
                'success' => true,
                'message' => 'Unit ruangan berhasil ditambahkan',
                'data' => $unitRuangan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
                    'message' => 'Data unit ruangan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data unit ruangan berhasil diambil',
                'data' => $unitRuangan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Auth::user();
            
            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $unitRuangan = UnitRuangan::where('id', $id)
                ->where('nip', $user->nip)
                ->first();

            if (!$unitRuangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data unit ruangan tidak ditemukan'
                ], 404);
            }

            $unitRuangan->update([
                'nama_ruangan' => $request->nama_ruangan,
            ]);

            // Load relationship
            $unitRuangan->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Unit ruangan berhasil diupdate',
                'data' => $unitRuangan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();
            
            $unitRuangan = UnitRuangan::where('id', $id)
                ->where('nip', $user->nip)
                ->first();

            if (!$unitRuangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data unit ruangan tidak ditemukan'
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
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unit ruangan by NIP
     */
    public function getByNip($nip)
    {
        try {
            $unitRuangan = UnitRuangan::where('nip', $nip)
                ->select('id', 'nama_ruangan')
                ->distinct('nama_ruangan')
                ->get();

            return response()->json($unitRuangan);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }
}
