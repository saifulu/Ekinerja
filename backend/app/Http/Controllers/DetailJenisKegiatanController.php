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

        if ($request->boolean('all') || $request->get('all') == '1' || $request->get('all') == 'true') {
            $detailKegiatan = $query->orderBy('created_at', 'desc')->get();
        } else {
            $perPage = (int) $request->get('per_page', 10);
            $detailKegiatan = $query->orderBy('created_at', 'desc')->paginate($perPage);
        }

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
        $user = Auth::user() ?: $request->user() ?: Auth::guard('web')->user();
        if (!$user && $request->filled('nip')) {
            $user = \App\Models\User::where('nip', $request->nip)->first();
        }

        if ($user && !$request->filled('nip')) {
            $request->merge(['nip' => $user->nip ?: ($user->username ?: (string)$user->id)]);
        }

        $isDraft = ($request->status === 'draft');

        $validator = Validator::make($request->all(), [
            'jenis_kegiatan' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'unit' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'tanggal_dibuat' => $isDraft ? 'nullable|date' : 'required|date',
            'hasil_temuan' => 'nullable|string',
            'signature_pelaksana' => 'nullable|string',
            'signature_pj' => 'nullable|string',
            'nama_pelaksana' => 'nullable|string|max:255',
            'nama_pj' => 'nullable|string|max:255',
            'nama_petugas' => 'nullable|string|max:255',
            'nama_ka_unit' => 'nullable|string|max:255',
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
                            
                            // Ensure directory exists with proper permissions
                            $directory = dirname($filePath);
                            if (!Storage::disk('public')->exists($directory)) {
                                Storage::disk('public')->makeDirectory($directory, 0755, true);
                            }
                            
                            // Save the file
                            $saved = Storage::disk('public')->put($filePath, $imageData);
                            
                            if ($saved) {
                                $dokumentasiPaths[] = $filePath;
                                \Log::info('Captured photo saved successfully', [
                                    'path' => $filePath,
                                    'size' => strlen($imageData),
                                    'full_path' => Storage::disk('public')->path($filePath)
                                ]);
                            } else {
                                \Log::error('Failed to save captured photo', ['path' => $filePath]);
                            }
                            
                        } catch (\Exception $e) {
                            \Log::error('Error processing captured photo', [
                                'index' => $index,
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                        }
                    }
                }
            }
            
            // Process uploaded files
            if ($request->hasFile('uploaded_files')) {
                foreach ($request->file('uploaded_files') as $file) {
                    try {
                        // Validate file
                        if (!$file->isValid()) {
                            \Log::error('Invalid uploaded file', ['original_name' => $file->getClientOriginalName()]);
                            continue;
                        }
                        
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $directory = 'dokumentasi/' . $user->nip . '/' . date('Y/m');
                        
                        // Ensure directory exists
                        if (!Storage::disk('public')->exists($directory)) {
                            Storage::disk('public')->makeDirectory($directory, 0755, true);
                        }
                        
                        $filePath = $file->storeAs($directory, $fileName, 'public');
                        
                        if ($filePath) {
                            $dokumentasiPaths[] = $filePath;
                            \Log::info('Uploaded file saved successfully', [
                                'path' => $filePath,
                                'original_name' => $file->getClientOriginalName(),
                                'size' => $file->getSize(),
                                'full_path' => Storage::disk('public')->path($filePath)
                            ]);
                        } else {
                            \Log::error('Failed to save uploaded file', ['original_name' => $file->getClientOriginalName()]);
                        }
                        
                    } catch (\Exception $e) {
                        \Log::error('Error processing uploaded file', [
                            'file' => $file->getClientOriginalName(),
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }
            
            $unit = $request->unit;
            if (empty($unit)) {
                $unit = $user->ruangan ?: '-';
            }
            $tanggalDibuat = $request->tanggal_dibuat ?: now()->toDateTimeString();

            $dataToCreate = [
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'nip' => $request->nip,
                'unit' => $request->unit,
                'tanggal_dibuat' => $request->tanggal_dibuat,
                'unit' => $unit,
                'tanggal_dibuat' => $tanggalDibuat,
                'hasil_temuan' => $request->hasil_temuan,
                'signature_pelaksana' => $request->signature_pelaksana,
                'signature_pj' => $request->signature_pj,
                'dokumentasi' => $dokumentasiPaths,
                'status' => $request->status ?? 'draft',
                'created_by' => $user->id
            ];

            if (\Illuminate\Support\Facades\Schema::hasColumn('detail_jenis_kegiatan', 'nama_pelaksana')) {
                $dataToCreate['nama_pelaksana'] = $request->nama_pelaksana ?? $request->nama_petugas;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('detail_jenis_kegiatan', 'nama_pj')) {
                $dataToCreate['nama_pj'] = $request->nama_pj ?? $request->nama_ka_unit;
            }

            $detailKegiatan = DetailJenisKegiatan::create($dataToCreate);
            
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
    public function show(Request $request, string $id): JsonResponse
    {
        $user = Auth::user() ?: $request->user() ?: Auth::guard('web')->user();
        if (!$user && $request->nip) {
            $user = \App\Models\User::where('nip', $request->nip)->first();
        }

        $query = DetailJenisKegiatan::with(['creator', 'user']);

        // Jika bukan admin, hanya bisa melihat data milik sendiri
        if ($user && $user->role !== 'admin') {
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
        \Log::info('Update request received', [
            'id' => $id,
            'all_data' => $request->all(),
            'files' => $request->allFiles()
        ]);

        $user = Auth::user() ?: $request->user() ?: Auth::guard('web')->user();
        if (!$user && $request->filled('nip')) {
            $user = \App\Models\User::where('nip', $request->nip)->first();
        }

        if ($user && !$request->filled('nip')) {
            $request->merge(['nip' => $user->nip ?: ($user->username ?: (string)$user->id)]);
        }

        $isDraft = ($request->status === 'draft');

        $validator = Validator::make($request->all(), [
            'jenis_kegiatan' => 'sometimes|required|string|max:255',
            'nip' => 'sometimes|required|string|max:255',
            'unit' => $isDraft ? 'nullable|string|max:255' : 'sometimes|required|string|max:255',
            'tanggal_dibuat' => 'sometimes|nullable|date',
            'hasil_temuan' => 'nullable|string',
            'signature_pelaksana' => 'nullable|string',
            'signature_pj' => 'nullable|string',
            'nama_pelaksana' => 'nullable|string|max:255',
            'nama_pj' => 'nullable|string|max:255',
            'nama_petugas' => 'nullable|string|max:255',
            'nama_ka_unit' => 'nullable|string|max:255',
            'captured_photos.*' => 'nullable|string',
            'uploaded_files.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240',
            'existing_dokumentasi' => 'nullable|array',
            'existing_dokumentasi.*' => 'nullable|string',
            'status' => 'nullable|in:draft,submitted,approved,rejected'
        ]);

        if ($validator->fails()) {
            \Log::error('Update validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $detailKegiatan = DetailJenisKegiatan::findOrFail($id);

        // Jika bukan admin, hanya bisa update data milik sendiri
        if ($user->role !== 'admin' && $detailKegiatan->nip !== $user->nip && $detailKegiatan->created_by !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki hak untuk mengubah data ini'
            ], 403);
        }

        $updateFields = [
            'jenis_kegiatan', 'nip', 'unit', 'tanggal_dibuat',
            'hasil_temuan', 'signature_pelaksana', 'signature_pj', 'status'
        ];
        
        $updateData = [];
        foreach ($updateFields as $field) {
            if ($request->has($field)) {
                $updateData[$field] = $request->input($field);
            }
        }

        if ($request->has('unit')) {
            $unitVal = $request->input('unit');
            if (empty($unitVal)) {
                $unitVal = $detailKegiatan->unit ?: ($user->ruangan ?: '-');
            }
            $updateData['unit'] = $unitVal;
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('detail_jenis_kegiatan', 'nama_pelaksana')) {
            if ($request->has('nama_pelaksana')) {
                $updateData['nama_pelaksana'] = $request->input('nama_pelaksana');
            } elseif ($request->has('nama_petugas')) {
                $updateData['nama_pelaksana'] = $request->input('nama_petugas');
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('detail_jenis_kegiatan', 'nama_pj')) {
            if ($request->has('nama_pj')) {
                $updateData['nama_pj'] = $request->input('nama_pj');
            } elseif ($request->has('nama_ka_unit')) {
                $updateData['nama_pj'] = $request->input('nama_ka_unit');
            }
        }

        // Handle Documentation (Existing + New Captured + New Uploaded)
        $dokumentasiPaths = [];
        if ($request->has('existing_dokumentasi')) {
            $existing = $request->input('existing_dokumentasi');
            if (is_array($existing)) {
                $dokumentasiPaths = array_values(array_filter($existing));
            }
        } elseif (!$request->has('captured_photos') && !$request->hasFile('uploaded_files')) {
            $dokumentasiPaths = $detailKegiatan->dokumentasi ?? [];
        } else {
            $dokumentasiPaths = $detailKegiatan->dokumentasi ?? [];
        }

        $nipFolder = $detailKegiatan->nip ?: ($user->nip ?? 'unknown');

        // Process captured photos (base64)
        if ($request->has('captured_photos')) {
            foreach ($request->captured_photos as $index => $base64Image) {
                if (!empty($base64Image)) {
                    try {
                        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
                        $imageData = base64_decode($imageData);
                        
                        if ($imageData === false) {
                            \Log::warning('Failed to decode base64 image on update', ['index' => $index]);
                            continue;
                        }
                        
                        $fileName = 'captured_' . time() . '_' . $index . '.jpg';
                        $filePath = 'dokumentasi/' . $nipFolder . '/' . date('Y/m') . '/' . $fileName;
                        
                        $directory = dirname($filePath);
                        if (!Storage::disk('public')->exists($directory)) {
                            Storage::disk('public')->makeDirectory($directory, 0755, true);
                        }
                        
                        $saved = Storage::disk('public')->put($filePath, $imageData);
                        if ($saved) {
                            $dokumentasiPaths[] = $filePath;
                            \Log::info('Captured photo saved on update', ['path' => $filePath]);
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error processing captured photo on update', ['error' => $e->getMessage()]);
                    }
                }
            }
        }

        // Process uploaded files
        if ($request->hasFile('uploaded_files')) {
            foreach ($request->file('uploaded_files') as $file) {
                try {
                    if (!$file->isValid()) continue;
                    
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $directory = 'dokumentasi/' . $nipFolder . '/' . date('Y/m');
                    
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory, 0755, true);
                    }
                    
                    $filePath = $file->storeAs($directory, $fileName, 'public');
                    if ($filePath) {
                        $dokumentasiPaths[] = $filePath;
                        \Log::info('Uploaded file saved on update', ['path' => $filePath]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error processing uploaded file on update', ['error' => $e->getMessage()]);
                }
            }
        }

        $updateData['dokumentasi'] = $dokumentasiPaths;

        $detailKegiatan->update($updateData);

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
        return $this->showLaporanKinerja($request);
    }

    /**
     * Display Laporan Kinerja page
     */
    public function showLaporanKinerja(Request $request)
    {
        try {
            $userNip = $request->get('nip');
            
            // Pastikan NIP selalu ada, jika tidak redirect ke login
            if (!$userNip) {
                return redirect('/login')->with('error', 'NIP tidak ditemukan dalam parameter.');
            }
            
            // Ambil data user berdasarkan NIP untuk mendapatkan instansi
            $currentUser = \App\Models\User::where('nip', $userNip)->first();
            
            if (!$currentUser) {
                return redirect('/login')->with('error', 'User tidak ditemukan.');
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
    
            return view('laporan-kinerja', compact(
                'laporanData',
                'statusStats', 
                'unitStats',
                'jenisKegiatanStats',
                'recentActivities',
                'currentUser'
            ));
    
        } catch (\Exception $e) {
            \Log::error('Error in showLaporanKinerja: ' . $e->getMessage());
            return view('laporan-kinerja')->with('error', 'Terjadi kesalahan saat memuat data laporan kinerja.');
        }
    }

    /**
     * Display Rekap Bulanan Crosstab page
     */
    public function showRekapBulanan(Request $request)
    {
        try {
            $userNip = $request->get('nip');
            
            // Pastikan NIP selalu ada, jika tidak redirect ke login
            if (!$userNip) {
                return redirect('/login')->with('error', 'NIP tidak ditemukan dalam parameter.');
            }
            
            // Ambil data user berdasarkan NIP untuk mendapatkan instansi
            $currentUser = \App\Models\User::where('nip', $userNip)->first();
            
            if (!$currentUser) {
                return redirect('/login')->with('error', 'User tidak ditemukan.');
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
    
            return view('rekap-bulanan', compact(
                'laporanData',
                'statusStats',
                'currentUser'
            ));
    
        } catch (\Exception $e) {
            \Log::error('Error in showRekapBulanan: ' . $e->getMessage());
            return view('rekap-bulanan')->with('error', 'Terjadi kesalahan saat memuat data rekap bulanan.');
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
            if (empty($units)) {
                $units = UnitRuangan::select('nama_ruangan')->distinct()->pluck('nama_ruangan')->toArray();
            }
            
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