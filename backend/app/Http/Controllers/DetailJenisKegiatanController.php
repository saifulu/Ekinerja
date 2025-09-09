<?php

namespace App\Http\Controllers;

use App\Models\DetailJenisKegiatan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        // Add debugging
        \Log::info('Store request received', [
            'all_data' => $request->all(),
            'files' => $request->allFiles()
        ]);
        
        $validator = Validator::make($request->all(), [
            'jenis_kegiatan' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
            'hasil_temuan' => 'nullable|string',
            'signature_pelaksana' => 'nullable|string',
            'signature_pj' => 'nullable|string',
            'captured_photos.*' => 'nullable|string',
            'uploaded_files.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240',
            'status' => 'nullable|in:draft,submitted,approved,rejected'
        ]);
    
        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            \Log::info('Authenticated user', ['user_id' => $user->id, 'nip' => $user->nip]);
            
            $dokumentasiPaths = [];
            
            // Process captured photos (base64)
            if ($request->has('captured_photos')) {
                foreach ($request->captured_photos as $index => $base64Image) {
                    if (!empty($base64Image)) {
                        try {
                            // Remove data:image/jpeg;base64, prefix if exists
                            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
                            $imageData = base64_decode($imageData);
                            
                            if ($imageData === false) {
                                \Log::warning('Failed to decode base64 image', ['index' => $index]);
                                continue;
                            }
                            
                            $fileName = 'captured_' . time() . '_' . $index . '.jpg';
                            $filePath = 'dokumentasi/' . $user->nip . '/' . date('Y/m') . '/' . $fileName;
                            
                            // Ensure directory exists
                            Storage::disk('public')->makeDirectory(dirname($filePath));
                            Storage::disk('public')->put($filePath, $imageData);
                            $dokumentasiPaths[] = $filePath;
                            
                            \Log::info('Captured photo saved', ['path' => $filePath]);
                        } catch (\Exception $e) {
                            \Log::error('Error processing captured photo', [
                                'index' => $index,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
            }
            
            // Process uploaded files
            if ($request->hasFile('uploaded_files')) {
                foreach ($request->file('uploaded_files') as $file) {
                    try {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs(
                            'dokumentasi/' . $user->nip . '/' . date('Y/m'),
                            $fileName,
                            'public'
                        );
                        $dokumentasiPaths[] = $filePath;
                        
                        \Log::info('Uploaded file saved', ['path' => $filePath]);
                    } catch (\Exception $e) {
                        \Log::error('Error processing uploaded file', [
                            'file' => $file->getClientOriginalName(),
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }
            
            $detailKegiatan = DetailJenisKegiatan::create([
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'nip' => $request->nip,
                'unit' => $request->unit,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'hasil_temuan' => $request->hasil_temuan,
                'signature_pelaksana' => $request->signature_pelaksana,
                'signature_pj' => $request->signature_pj,
                'dokumentasi' => $dokumentasiPaths,
                'status' => $request->status ?? 'draft',
                'created_by' => $user->id
            ]);
            
            \Log::info('Data created successfully', ['id' => $detailKegiatan->id]);
        
            return response()->json([
                'success' => true,
                'message' => 'Detail kegiatan berhasil dibuat',
                'data' => $detailKegiatan->load(['creator'])
            ], 201);
            
        } catch (\Exception $e) {
            \Log::error('Error creating detail kegiatan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
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
     * Show laporan page with data from detail_jenis_kegiatan table
     */
    public function showLaporan(Request $request)
    {
        try {
            $userNip = $request->get('nip');
            
            // Pastikan NIP selalu ada, jika tidak redirect ke login
            if (!$userNip) {
                return redirect('/login')->with('error', 'NIP tidak ditemukan dalam parameter.');
            }
            
            // Filter data berdasarkan NIP yang diberikan
            $laporanData = DetailJenisKegiatan::with(['creator', 'user'])
                ->where('nip', $userNip)
                ->orderBy('created_at', 'desc')
                ->get();
    
            // Group data by status for statistics
            $statusStats = [
                'draft' => $laporanData->where('status', 'draft')->count(),
                'submitted' => $laporanData->where('status', 'submitted')->count(),
                'approved' => $laporanData->where('status', 'approved')->count(),
                'rejected' => $laporanData->where('status', 'rejected')->count(),
            ];
    
            // Group data by unit
            $unitStats = $laporanData->groupBy('unit')->map(function ($items) {
                return $items->count();
            });
    
            // Group data by jenis_kegiatan
            $jenisKegiatanStats = $laporanData->groupBy('jenis_kegiatan')->map(function ($items) {
                return $items->count();
            });
    
            // Recent activities (last 10)
            $recentActivities = $laporanData->take(10);
    
            return view('laporan', compact(
                'laporanData',
                'statusStats', 
                'unitStats',
                'jenisKegiatanStats',
                'recentActivities'
            ));
    
        } catch (\Exception $e) {
            \Log::error('Error in showLaporan: ' . $e->getMessage());
            return view('laporan')->with('error', 'Terjadi kesalahan saat memuat data laporan.');
        }
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