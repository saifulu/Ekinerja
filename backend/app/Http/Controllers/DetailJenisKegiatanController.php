<?php

namespace App\Http\Controllers;

use App\Models\DetailJenisKegiatan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DetailJenisKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $query = DetailJenisKegiatan::with(['creator', 'user']);

        // Filter berdasarkan NIP user yang login (hanya data milik user)
        if ($user->role !== 'admin') {
            $query->where('nip', $user->nip);
        }

        // Filter berdasarkan parameter
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        if ($request->has('jenis_kegiatan')) {
            $query->byJenisKegiatan($request->jenis_kegiatan);
        }

        $detailKegiatan = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $detailKegiatan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'jenis_kegiatan' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
            'hasil_temuan' => 'nullable|string',
            'signature_pelaksana' => 'nullable|string',
            'signature_pj' => 'nullable|string',
            'dokumentasi' => 'nullable|array',
            'status' => 'nullable|in:draft,submitted,approved,rejected'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        $detailKegiatan = DetailJenisKegiatan::create([
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'nip' => $request->nip,
            'unit' => $request->unit,
            'tanggal_dibuat' => $request->tanggal_dibuat,
            'hasil_temuan' => $request->hasil_temuan,
            'signature_pelaksana' => $request->signature_pelaksana,
            'signature_pj' => $request->signature_pj,
            'dokumentasi' => $request->dokumentasi,
            'status' => $request->status ?? 'draft',
            'created_by' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail kegiatan berhasil dibuat',
            'data' => $detailKegiatan->load(['creator', 'user'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = Auth::user();
        $query = DetailJenisKegiatan::with(['creator', 'user']);

        // Jika bukan admin, hanya bisa melihat data milik sendiri
        if ($user->role !== 'admin') {
            $query->where('nip', $user->nip);
        }

        $detailKegiatan = $query->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $detailKegiatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'jenis_kegiatan' => 'sometimes|required|string|max:255',
            'nip' => 'sometimes|required|string|max:255',
            'unit' => 'sometimes|required|string|max:255',
            'tanggal_dibuat' => 'sometimes|required|date',
            'hasil_temuan' => 'nullable|string',
            'signature_pelaksana' => 'nullable|string',
            'signature_pj' => 'nullable|string',
            'dokumentasi' => 'nullable|array',
            'status' => 'nullable|in:draft,submitted,approved,rejected'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $query = DetailJenisKegiatan::query();

        // Jika bukan admin, hanya bisa update data milik sendiri
        if ($user->role !== 'admin') {
            $query->where('nip', $user->nip);
        }

        $detailKegiatan = $query->findOrFail($id);
        $detailKegiatan->update($request->only([
            'jenis_kegiatan', 'nip', 'unit', 'tanggal_dibuat',
            'hasil_temuan', 'signature_pelaksana', 'signature_pj',
            'dokumentasi', 'status'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Detail kegiatan berhasil diupdate',
            'data' => $detailKegiatan->load(['creator', 'user'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = Auth::user();
        $query = DetailJenisKegiatan::query();

        // Jika bukan admin, hanya bisa delete data milik sendiri
        if ($user->role !== 'admin') {
            $query->where('nip', $user->nip);
        }

        $detailKegiatan = $query->findOrFail($id);
        $detailKegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Detail kegiatan berhasil dihapus'
        ]);
    }

    /**
     * Get units/ruangan for current user
     */
    public function getUnits(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Debug logging
            \Log::info('User NIP: ' . $user->nip);
            
            $units = UnitRuangan::getRuanganByNip($user->nip);
            
            // Debug logging
            \Log::info('Units found: ' . json_encode($units));
            
            return response()->json([
                'success' => true,
                'data' => $units,
                'debug' => [
                    'user_nip' => $user->nip,
                    'units_count' => count($units)
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getUnits: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}