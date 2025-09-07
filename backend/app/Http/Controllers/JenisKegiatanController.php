<?php

namespace App\Http\Controllers;

use App\Models\JenisKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JenisKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $jenisKegiatan = JenisKegiatan::forUser($user->nip)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $jenisKegiatan,
                'message' => 'Data jenis kegiatan berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data jenis kegiatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jenis_kegiatan' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            
            $jenisKegiatan = JenisKegiatan::create([
                'nip' => $user->nip,
                'golongan' => $user->golongan,
                'jenis_kegiatan' => $request->jenis_kegiatan
            ]);

            return response()->json([
                'success' => true,
                'data' => $jenisKegiatan,
                'message' => 'Jenis kegiatan berhasil ditambahkan'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan jenis kegiatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $jenisKegiatan = JenisKegiatan::forUser($user->nip)->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $jenisKegiatan,
                'message' => 'Data jenis kegiatan berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data jenis kegiatan tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jenis_kegiatan' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $jenisKegiatan = JenisKegiatan::forUser($user->nip)->findOrFail($id);
            
            $jenisKegiatan->update([
                'jenis_kegiatan' => $request->jenis_kegiatan
            ]);

            return response()->json([
                'success' => true,
                'data' => $jenisKegiatan,
                'message' => 'Jenis kegiatan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui jenis kegiatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $jenisKegiatan = JenisKegiatan::forUser($user->nip)->findOrFail($id);
            
            $jenisKegiatan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Jenis kegiatan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jenis kegiatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}