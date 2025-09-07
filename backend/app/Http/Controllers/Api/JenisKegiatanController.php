<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisKegiatan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class JenisKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $user = auth()->user();
            $jenisKegiatan = JenisKegiatan::where('nip', $user->nip)
                ->with('user:nip,name')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $jenisKegiatan
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
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'jenis_kegiatan' => 'required|string|max:255'
            ]);

            // Ambil data user yang sedang login
            $user = auth()->user();
            
            $jenisKegiatan = JenisKegiatan::create([
                'nip' => $user->nip,
                'golongan' => $user->golongan,
                'jenis_kegiatan' => $validated['jenis_kegiatan']
            ]);

            // Load relationship
            $jenisKegiatan->load('user:nip,name');

            return response()->json([
                'success' => true,
                'message' => 'Jenis kegiatan berhasil ditambahkan',
                'data' => $jenisKegiatan
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
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
    public function show(string $id): JsonResponse
    {
        try {
            $jenisKegiatan = JenisKegiatan::with('user:nip,name')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $jenisKegiatan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis kegiatan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'jenis_kegiatan' => 'required|string|max:255'
            ]);

            $jenisKegiatan = JenisKegiatan::findOrFail($id);
            
            // Check if user owns this record
            if ($jenisKegiatan->nip !== auth()->user()->nip) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengubah data ini'
                ], 403);
            }

            $jenisKegiatan->update($validated);
            $jenisKegiatan->load('user:nip,name');

            return response()->json([
                'success' => true,
                'message' => 'Jenis kegiatan berhasil diperbarui',
                'data' => $jenisKegiatan
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
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
    public function destroy(string $id): JsonResponse
    {
        try {
            $jenisKegiatan = JenisKegiatan::findOrFail($id);
            
            // Check if user owns this record
            if ($jenisKegiatan->nip !== auth()->user()->nip) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus data ini'
                ], 403);
            }

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