<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja Pegawai - e-Kinerja</title>
    @include('partials.pwa-head')
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS for modal compatibility -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jsPDF & Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: radial-gradient(circle at 10% 10%, rgba(16, 185, 129, 0.1) 0%, transparent 40%),
                        radial-gradient(circle at 90% 90%, rgba(6, 182, 212, 0.08) 0%, transparent 40%),
                        linear-gradient(145deg, #090e1a 0%, #0f172a 50%, #031e17 100%);
            min-height: 100vh;
            color: #f8fafc;
            background-attachment: fixed;
        }

        /* Glassmorphism Classes */
        .glass-card {
            background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
            border-radius: 20px;
        }

        .glass-panel {
            background: rgba(30, 41, 59, 0.55);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .stat-card {
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 12px 16px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(16, 185, 129, 0.35);
        }

        .stat-card.active {
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.95) 0%, rgba(6, 78, 59, 0.45) 100%);
            border-color: rgba(16, 185, 129, 0.6);
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.15);
        }

        /* Form Controls */
        .custom-input {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #f8fafc;
            border-radius: 12px;
            padding: 9px 14px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .custom-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(15, 23, 42, 0.95);
        }

        .custom-input::placeholder {
            color: #64748b;
        }

        .custom-select {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #f8fafc;
            border-radius: 12px;
            padding: 9px 14px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .custom-select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .custom-select option {
            background: #0f172a;
            color: #f8fafc;
        }

        /* Custom Desktop Table */
        .table-responsive {
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(11, 18, 33, 0.65);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(16, 185, 129, 0.35) rgba(15, 23, 42, 0.6);
        }

        .table-responsive::-webkit-scrollbar {
            height: 7px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.35);
            border-radius: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.6);
        }

        #dataTable {
            width: 100%;
            min-width: 1340px;
            border-collapse: separate;
            border-spacing: 0;
        }

        #dataTable th {
            background: rgba(22, 32, 51, 0.95);
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 13px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.09);
            white-space: nowrap;
        }

        #dataTable td {
            padding: 13px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            font-size: 0.825rem;
            vertical-align: middle;
        }

        #dataTable tbody tr {
            transition: background-color 0.15s ease;
        }

        #dataTable tbody tr:hover td {
            background: rgba(30, 41, 59, 0.5);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-draft {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        .status-submitted {
            background: rgba(6, 182, 212, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(6, 182, 212, 0.35);
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }

        /* Action Buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            transition: all 0.2s ease;
        }

        .btn-action-view {
            background: rgba(6, 182, 212, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        .btn-action-view:hover {
            background: #0891b2;
            color: white;
        }

        .btn-action-edit {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-action-edit:hover {
            background: #059669;
            color: white;
        }

        /* Thumbnails */
        .signature-box {
            background: #ffffff;
            border-radius: 8px;
            padding: 2px 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            width: 82px;
            height: 38px;
            overflow: hidden;
        }

        .signature-box img {
            max-height: 32px;
            max-width: 74px;
            object-fit: contain;
        }

        .signature-box:hover {
            transform: scale(1.05);
            border-color: #10b981;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
        }

        .doc-thumb {
            width: 38px;
            height: 38px;
            object-fit: cover;
            border-radius: 8px;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .doc-thumb:hover {
            transform: scale(1.08);
            border-color: #10b981;
        }

        /* Pagination Buttons */
        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            transition: all 0.2s ease;
        }

        .page-btn:hover:not(:disabled) {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.4);
            color: #34d399;
        }

        .page-btn.active {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            border-color: #10b981;
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Mobile Segmented Button */
        .seg-tab-btn {
            flex: 1;
            text-align: center;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 600;
            transition: all 0.2s ease;
            color: #94a3b8;
            background: transparent;
        }

        .seg-tab-btn.active {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        /* Modal Customization */
        .modal-content {
            background: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 20px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
            color: #f8fafc !important;
        }

        .modal-backdrop.show {
            opacity: 0.75;
            backdrop-filter: blur(8px);
        }
    </style>
    @include('partials.mobile-ux')
</head>
<body class="p-3 sm:p-5 md:p-6 lg:p-8">

    <div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

        <!-- Top Navigation Bar -->
        <div class="flex items-center justify-between gap-3 pb-1">
            <a href="/user-dashboard{{ isset($currentUser->nip) ? '?nip='.$currentUser->nip : '' }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700/60 text-slate-200 hover:text-emerald-400 text-xs sm:text-sm font-medium transition-all shadow-md group">
                <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-1 text-emerald-400"></i>
                <span class="hidden xs:inline">Kembali ke </span>Dashboard
            </a>

            <!-- User Info Pill -->
            <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-800/60 border border-slate-700/60 backdrop-blur-md">
                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 font-bold text-xs">
                    {{ strtoupper(substr($currentUser->name ?? 'User', 0, 2)) }}
                </div>
                <div class="text-left text-xs">
                    <div class="text-white font-semibold flex items-center gap-1 leading-tight">
                        <span class="max-w-[110px] sm:max-w-[180px] truncate">{{ $currentUser->name ?? 'Pegawai' }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    </div>
                    <div class="text-slate-400 text-[11px] leading-tight">
                        NIP: {{ $currentUser->nip ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Header (Clean & Compact on Mobile) -->
        <div class="glass-card p-4 sm:p-6 md:p-7 relative overflow-hidden">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 relative z-10">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-[11px] font-semibold">
                        <i class="fas fa-file-signature text-[10px]"></i>
                        <span>Monitoring Kinerja</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 via-teal-200 to-cyan-400">
                            Laporan Kinerja Pegawai
                        </span>
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm hidden md:block max-w-xl">
                        Pantau seluruh riwayat pencatatan aktivitas, validasi tanda tangan elektronik, dan arsipkan rekapitulasi data kegiatan kinerja.
                    </p>
                </div>

                <button type="button" 
                        id="exportPdfButton" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 text-white font-semibold text-xs sm:text-sm shadow-md shadow-rose-600/25 transition-all">
                    <i class="fas fa-file-pdf"></i>
                    <span>Pratinjau & Cetak PDF</span>
                </button>
            </div>
        </div>

        @if(isset($error))
            <div class="p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 flex items-center gap-2 text-xs sm:text-sm">
                <i class="fas fa-triangle-exclamation text-base"></i>
                <span>{{ $error }}</span>
            </div>
        @else
            <!-- Mobile Segmented Tab Switcher (Takes minimal vertical space!) -->
            <div class="block md:hidden bg-slate-900/90 p-1.5 rounded-2xl border border-slate-700/60 shadow-md">
                <div class="flex items-center gap-1">
                    <button type="button" 
                            id="mobileTabLaporan" 
                            onclick="showLaporanKegiatan()" 
                            class="seg-tab-btn active flex items-center justify-center gap-1.5">
                        <i class="fas fa-clipboard-list text-xs"></i>
                        <span>Laporan Kinerja</span>
                    </button>
                    <button type="button" 
                            id="mobileTabRekap" 
                            onclick="showRekapLaporan()" 
                            class="seg-tab-btn flex items-center justify-center gap-1.5">
                        <i class="fas fa-table-list text-xs"></i>
                        <span>Rekap Bulanan</span>
                    </button>
                </div>
            </div>

            <!-- Desktop Metric Cards (Hidden on mobile) - 2 Cards Menu -->
            <div class="hidden md:grid grid-cols-2 gap-4">
                <!-- Card 1: Laporan Kinerja -->
                <div class="stat-card active flex flex-col justify-between" id="laporanKegiatanCard" onclick="showLaporanKegiatan()">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-lg shrink-0">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-slate-200 font-bold text-sm leading-tight truncate">Laporan Kinerja</h3>
                                <div class="text-xs text-slate-400 mt-0.5">Daftar rincian log harian</div>
                            </div>
                        </div>
                        <div class="text-2xl font-extrabold text-white leading-none shrink-0">
                            {{ ($statusStats['draft'] ?? 0) + ($statusStats['submitted'] ?? 0) + ($statusStats['approved'] ?? 0) + ($statusStats['rejected'] ?? 0) }}
                        </div>
                    </div>
                </div>

                <!-- Card 2: Rekap Bulanan -->
                <div class="stat-card flex flex-col justify-between" id="rekapLaporanCard" onclick="showRekapLaporan()">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-teal-500/20 border border-teal-500/30 text-teal-400 flex items-center justify-center text-lg shrink-0">
                                <i class="fas fa-table-list"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-slate-200 font-bold text-sm leading-tight truncate">Rekap Bulanan</h3>
                                <div class="text-xs text-slate-400 mt-0.5">Tabulasi jumlah kegiatan per tanggal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Data Table & Card Feed Container -->
            <div class="glass-card p-4 sm:p-5 md:p-6 space-y-4">

                <!-- Table Header & Counter -->
                <div class="flex items-center justify-between gap-3 pb-3 border-b border-slate-700/60" id="tableHeaderContainer">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-sm">
                            <i class="fas fa-table" id="tableIcon"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-white flex items-center gap-1.5" id="tableTitle">
                                <span id="titleText">Data Kegiatan Lengkap</span>
                            </h3>
                            <p class="text-[11px] text-slate-400 hidden sm:block" id="tableSubtitle">
                                Daftar seluruh rekaman aktivitas pekerjaan dengan tanda tangan dan foto dokumentasi
                            </p>
                        </div>
                    </div>

                    <!-- Live Count Indicator -->
                    <div class="text-[11px] text-slate-300 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/60 flex items-center gap-1.5 shrink-0" id="liveCountContainer">
                        <i class="fas fa-list-check text-emerald-400"></i>
                        <span><strong class="text-white font-bold" id="visibleCountIndicator">{{ $laporanData ? $laporanData->count() : 0 }}</strong> data</span>
                    </div>
                </div>

                <!-- Controls Bar: Search & Expandable Filter (Clean & Uncluttered) -->
                <div class="table-controls space-y-3">
                    <div class="flex items-center gap-2">
                        <!-- Search Box -->
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" 
                                   id="searchInput" 
                                   class="custom-input w-full pl-9 pr-3 text-xs sm:text-sm py-2" 
                                   placeholder="Cari kegiatan, nama, unit, hasil temuan...">
                        </div>

                        <!-- Toggle Filter Button (for compact mobile experience) -->
                        <button type="button" 
                                id="toggleFilterBtn" 
                                onclick="toggleMobileFilter()" 
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 hover:text-emerald-400 text-xs font-semibold transition-all shrink-0">
                            <i class="fas fa-sliders text-xs"></i>
                            <span class="hidden xs:inline">Filter</span>
                            <span id="activeFilterBadge" class="hidden w-2 h-2 rounded-full bg-emerald-400"></span>
                        </button>
                    </div>

                    <!-- Expandable Filter Panel (Starts hidden on mobile, clean dropdown) -->
                    <div id="filterDrawer" class="hidden p-3.5 rounded-xl bg-slate-800/80 border border-slate-700/60 space-y-3 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2.5">
                            <!-- Jenis Kegiatan Filter -->
                            <div>
                                <label class="text-[11px] text-slate-400 block mb-1 font-medium">Jenis Kegiatan</label>
                                <select id="jenisKegiatanFilter" class="custom-select w-full py-1.5 text-xs">
                                    <option value="">Semua Kegiatan</option>
                                    @if(isset($jenisKegiatanStats))
                                        @foreach($jenisKegiatanStats as $kegName => $kegCount)
                                            <option value="{{ $kegName }}">{{ $kegName }} ({{ $kegCount }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="text-[11px] text-slate-400 block mb-1 font-medium">Status Laporan</label>
                                <select id="statusFilter" class="custom-select w-full py-1.5 text-xs">
                                    <option value="">Semua Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="text-[11px] text-slate-400 block mb-1 font-medium">Dari Tanggal</label>
                                <input type="date" id="startDate" value="{{ date('Y-m-d') }}" class="custom-input w-full py-1.5 text-xs">
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="text-[11px] text-slate-400 block mb-1 font-medium">Sampai Tanggal</label>
                                <input type="date" id="endDate" value="{{ date('Y-m-d') }}" class="custom-input w-full py-1.5 text-xs">
                            </div>
                        </div>

                        <!-- Filter Action Buttons -->
                        <div class="flex items-center justify-end gap-2 pt-1 border-t border-slate-700/50">
                            <button type="button" 
                                    id="resetButton" 
                                    onclick="resetTable()" 
                                    class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 text-xs font-medium transition-all">
                                Reset Filter
                            </button>
                            <button type="button" 
                                    id="filterButton" 
                                    onclick="applyFilters()" 
                                    class="px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold transition-all shadow">
                                <i class="fas fa-check mr-1"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- View 1: Laporan Kegiatan (Desktop Table + Mobile Cards) -->
                <div id="laporanKegiatanTable">
                    @if($laporanData && $laporanData->count() > 0)
                        
                        <!-- 1. Mobile Feed View (Clean, simple, no horizontal overflow - Shown on < lg) -->
                        <div class="block lg:hidden space-y-3" id="mobileCardsContainer">
                            @foreach($laporanData as $index => $item)
                                @php
                                    $itemStatus = strtolower($item->status ?? 'draft');
                                    $statusLabel = ucfirst($itemStatus);
                                    $creatorName = $item->user ? $item->user->name : ($item->creator ? $item->creator->name : ($currentUser->name ?? '-'));
                                    
                                    $sigPelaksana = $item->signature_pelaksana;
                                    if ($sigPelaksana && !str_starts_with($sigPelaksana, 'data:image/')) {
                                        $sigPelaksana = 'data:image/png;base64,' . $sigPelaksana;
                                    }

                                    $sigPJ = $item->signature_pj;
                                    if ($sigPJ && !str_starts_with($sigPJ, 'data:image/')) {
                                        $sigPJ = 'data:image/png;base64,' . $sigPJ;
                                    }
                                @endphp
                                <div class="mobile-activity-card p-3.5 rounded-2xl bg-slate-900/80 border border-slate-700/60 shadow-sm space-y-2.5 transition-all" 
                                     data-status="{{ $itemStatus }}" 
                                     data-id="{{ $item->id }}">
                                    
                                    <!-- Header Row: No, Title, Status Badge -->
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1.5 mb-1">
                                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-400 border border-slate-700/60">#{{ $index + 1 }}</span>
                                                <span class="status-badge status-{{ $itemStatus }} text-[10px]">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>
                                            <h4 class="text-white font-semibold text-sm leading-snug break-words">
                                                {{ $item->jenis_kegiatan ?? '-' }}
                                            </h4>
                                        </div>
                                    </div>

                                    <!-- Meta Row: Tanggal & Unit -->
                                    <div class="flex flex-wrap items-center gap-1.5 text-[11px] text-slate-300">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-800 text-slate-300 border border-slate-700/40">
                                            <i class="far fa-calendar-alt text-emerald-400 text-[10px]"></i>
                                            {{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('d/m/Y H:i') : '-' }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-teal-500/10 text-teal-300 border border-teal-500/20 font-medium">
                                            <i class="fas fa-door-open text-[10px]"></i>
                                            {{ $item->unit ?? '-' }}
                                        </span>
                                    </div>

                                    <!-- Hasil Temuan Snippet -->
                                    @if($item->hasil_temuan)
                                        <div class="text-xs text-slate-300 bg-slate-800/40 p-2 rounded-xl border border-slate-700/30 leading-relaxed cursor-pointer hover:text-emerald-300" 
                                             onclick="viewDetail({{ $item->id }})">
                                            <span class="text-slate-400 font-medium text-[11px] block mb-0.5">Hasil Temuan:</span>
                                            {{ Str::limit($item->hasil_temuan, 75) }}
                                        </div>
                                    @endif

                                    <!-- Bottom Footer: Signatures, Docs & Actions -->
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-800/80 gap-2">
                                        <!-- Mini Status Tags -->
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            @if($sigPelaksana)
                                                <span class="inline-flex items-center gap-1 text-[10px] text-emerald-400 bg-emerald-500/10 border border-emerald-500/25 px-2 py-0.5 rounded cursor-pointer" 
                                                      onclick="showImageModal('{{ $sigPelaksana }}', 'TTD Pelaksana - {{ $item->nama_pelaksana ?? $creatorName }}')">
                                                    <i class="fas fa-check-circle text-[9px]"></i> Pelaksana
                                                </span>
                                            @else
                                                <span class="text-[10px] text-slate-500 bg-slate-800/80 px-1.5 py-0.5 rounded">Belum TTD</span>
                                            @endif

                                            @if($sigPJ)
                                                <span class="inline-flex items-center gap-1 text-[10px] text-cyan-400 bg-cyan-500/10 border border-cyan-500/25 px-2 py-0.5 rounded cursor-pointer" 
                                                      onclick="showImageModal('{{ $sigPJ }}', 'TTD Penanggung Jawab - {{ $item->nama_pj ?? 'PJ' }}')">
                                                    <i class="fas fa-shield-check text-[9px]"></i> PJ
                                                </span>
                                            @endif

                                            @if($item->dokumentasi && count($item->dokumentasi) > 0)
                                                <span class="text-[10px] text-slate-400 flex items-center gap-1 cursor-pointer" onclick="viewDetail({{ $item->id }})">
                                                    <i class="fas fa-camera text-slate-400 text-[10px]"></i> {{ count($item->dokumentasi) }} foto
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <button type="button" 
                                                    onclick="viewDetail({{ $item->id }})" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-300 border border-emerald-500/30 text-xs font-semibold transition-all">
                                                <i class="fas fa-eye text-[11px]"></i> Detail
                                            </button>
                                            <button type="button" 
                                                    onclick="editItem({{ $item->id }})" 
                                                    class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 text-xs transition-all" 
                                                    title="Edit">
                                                <i class="fas fa-pen-to-square text-[11px]"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- 2. Desktop Table View (Spacious & Executive - Shown on >= lg) -->
                        <div class="table-responsive hidden lg:block">
                            <table id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th style="width: 190px;">Jenis Kegiatan</th>
                                        <th style="width: 220px;">Pegawai &amp; NIP</th>
                                        <th style="width: 130px;">Unit</th>
                                        <th style="width: 135px;">Tanggal Dibuat</th>
                                        <th style="width: 190px;">Hasil Temuan</th>
                                        <th style="width: 130px;" class="text-center">Signature Pelaksana</th>
                                        <th style="width: 130px;" class="text-center">Signature PJ</th>
                                        <th style="width: 110px;" class="text-center">Dokumentasi</th>
                                        <th style="width: 95px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @forelse($laporanData as $index => $item)
                                        @php
                                            $itemStatus = strtolower($item->status ?? 'draft');
                                            $statusLabel = ucfirst($itemStatus);
                                            $creatorName = $item->user ? $item->user->name : ($item->creator ? $item->creator->name : ($currentUser->name ?? '-'));
                                            
                                            $sigPelaksana = $item->signature_pelaksana;
                                            if ($sigPelaksana && !str_starts_with($sigPelaksana, 'data:image/')) {
                                                $sigPelaksana = 'data:image/png;base64,' . $sigPelaksana;
                                            }

                                            $sigPJ = $item->signature_pj;
                                            if ($sigPJ && !str_starts_with($sigPJ, 'data:image/')) {
                                                $sigPJ = 'data:image/png;base64,' . $sigPJ;
                                            }
                                        @endphp
                                        <tr data-status="{{ $itemStatus }}" data-id="{{ $item->id }}">
                                            <!-- Col 0: No -->
                                            <td class="text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>

                                            <!-- Col 1: Jenis Kegiatan -->
                                            <td>
                                                <div class="font-semibold text-white text-xs leading-snug">{{ $item->jenis_kegiatan ?? '-' }}</div>
                                                <div class="mt-1.5">
                                                    <span class="status-badge status-{{ $itemStatus }}">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                        {{ $statusLabel }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Col 2: Pegawai & NIP (Digabung 1 Kolom) -->
                                            <td>
                                                <div class="font-semibold text-slate-100 text-xs leading-snug">{{ $creatorName }}</div>
                                                <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-800/90 text-slate-300 border border-slate-700 font-mono text-[11px] font-semibold tracking-wider whitespace-nowrap">
                                                        {{ $item->nip ?? '-' }}
                                                    </span>
                                                    <span class="text-[11px] text-slate-400 truncate flex items-center gap-1" title="{{ $currentUser->instansi ?? 'RSUD' }}">
                                                        <i class="far fa-hospital text-[10px] text-emerald-400/80 shrink-0"></i>
                                                        {{ $currentUser->instansi ?? 'RSUD' }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Col 3: Unit -->
                                            <td>
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-teal-500/10 text-teal-300 border border-teal-500/20 text-xs font-medium whitespace-nowrap">
                                                    <i class="fas fa-door-open text-[10px]"></i>{{ $item->unit ?? '-' }}
                                                </span>
                                            </td>

                                            <!-- Col 4: Tanggal Dibuat -->
                                            <td>
                                                <div class="text-xs text-slate-200 font-medium flex items-center gap-1.5 whitespace-nowrap">
                                                    <i class="far fa-calendar-alt text-emerald-400 text-[11px]"></i>
                                                    {{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('d/m/Y') : '-' }}
                                                </div>
                                                <div class="text-[11px] text-slate-400 mt-1 flex items-center gap-1.5 whitespace-nowrap">
                                                    <i class="far fa-clock text-slate-500 text-[10px]"></i>
                                                    {{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('H:i') : '' }} WIB
                                                </div>
                                            </td>

                                            <!-- Col 5: Hasil Temuan -->
                                            <td>
                                                @if($item->hasil_temuan)
                                                    <div class="text-xs text-slate-300 leading-relaxed max-w-[180px] break-words line-clamp-2 cursor-pointer hover:text-emerald-300 transition-colors" 
                                                         title="{{ $item->hasil_temuan }}" 
                                                         onclick="viewDetail({{ $item->id }})">
                                                        {{ $item->hasil_temuan }}
                                                    </div>
                                                @else
                                                    <span class="text-slate-500 text-xs italic">Tidak ada catatan</span>
                                                @endif
                                            </td>

                                            <!-- Col 6: Signature Pelaksana -->
                                            <td class="text-center">
                                                @if($sigPelaksana)
                                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                                        <div class="signature-box" 
                                                             onclick="showImageModal('{{ $sigPelaksana }}', 'Tanda Tangan Pelaksana - {{ $item->nama_pelaksana ?? $creatorName }}')"
                                                             title="Klik untuk memperbesar">
                                                            <img src="{{ $sigPelaksana }}" alt="Tanda Tangan Pelaksana">
                                                        </div>
                                                        <span class="text-[11px] font-medium text-slate-300 flex items-center justify-center gap-1 max-w-[120px] truncate" title="{{ $item->nama_pelaksana ?? $creatorName }}">
                                                            <i class="fas fa-user-check text-emerald-400 text-[9px] shrink-0"></i>
                                                            <span class="truncate">{{ $item->nama_pelaksana ?? $creatorName }}</span>
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-500 italic">Belum TTD</span>
                                                @endif
                                            </td>

                                            <!-- Col 7: Signature PJ -->
                                            <td class="text-center">
                                                @if($sigPJ)
                                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                                        <div class="signature-box" 
                                                             onclick="showImageModal('{{ $sigPJ }}', 'Tanda Tangan Penanggung Jawab - {{ $item->nama_pj ?? 'Penanggung Jawab' }}')"
                                                             title="Klik untuk memperbesar">
                                                            <img src="{{ $sigPJ }}" alt="Tanda Tangan PJ">
                                                        </div>
                                                        <span class="text-[11px] font-medium text-slate-300 flex items-center justify-center gap-1 max-w-[120px] truncate" title="{{ $item->nama_pj ?? 'PJ' }}">
                                                            <i class="fas fa-user-shield text-cyan-400 text-[9px] shrink-0"></i>
                                                            <span class="truncate">{{ $item->nama_pj ?? 'PJ' }}</span>
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-500 italic">Belum TTD</span>
                                                @endif
                                            </td>

                                            <!-- Col 8: Dokumentasi -->
                                            <td class="text-center">
                                                @if($item->dokumentasi && is_array($item->dokumentasi) && count($item->dokumentasi) > 0)
                                                    <div class="flex flex-col items-center justify-center gap-1">
                                                        <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                                            @foreach(array_slice($item->dokumentasi, 0, 2) as $docIdx => $doc)
                                                                @php
                                                                    $imgSrc = $doc;
                                                                    if (!str_starts_with($imgSrc, 'http://') && !str_starts_with($imgSrc, 'https://') && !str_starts_with($imgSrc, 'data:')) {
                                                                        $cleanDoc = ltrim($imgSrc, '/');
                                                                        if (!str_starts_with($cleanDoc, 'storage/')) {
                                                                            $cleanDoc = 'storage/' . $cleanDoc;
                                                                        }
                                                                        $imgSrc = asset($cleanDoc);
                                                                    }
                                                                @endphp
                                                                <img src="{{ $imgSrc }}" 
                                                                     alt="Dokumentasi {{ $docIdx + 1 }}" 
                                                                     class="doc-thumb"
                                                                     onclick="showImageModal('{{ $imgSrc }}', 'Dokumentasi {{ $docIdx + 1 }} - {{ $item->jenis_kegiatan }}')"
                                                                     onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'38\' height=\'38\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%2364748b\' stroke-width=\'1.5\'><rect width=\'18\' height=\'18\' x=\'3\' y=\'3\' rx=\'2\'/><circle cx=\'9\' cy=\'9\' r=\'2\'/><path d=\'m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21\'/></svg>';"
                                                                     title="Klik untuk memperbesar">
                                                            @endforeach
                                                            @if(count($item->dokumentasi) > 2)
                                                                <button type="button" 
                                                                        onclick="viewDetail({{ $item->id }})" 
                                                                        class="w-9 h-9 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 hover:text-emerald-400 text-xs font-bold transition-colors"
                                                                        title="Lihat semua foto">
                                                                    +{{ count($item->dokumentasi) - 2 }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                        <div class="text-[10px] text-slate-400 mt-0.5 whitespace-nowrap font-medium">{{ count($item->dokumentasi) }} file(s)</div>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-500 italic">Tidak ada foto</span>
                                                @endif
                                            </td>

                                            <!-- Col 9: Aksi -->
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                                    <button type="button" 
                                                            class="btn-action btn-action-view" 
                                                            onclick="viewDetail({{ $item->id }})" 
                                                            title="Lihat Detail Lengkap">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn-action btn-action-edit" 
                                                            onclick="editItem({{ $item->id }})" 
                                                            title="Input / Edit Kegiatan">
                                                        <i class="fas fa-pen-to-square text-xs"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-12">
                                                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-800/80 border border-slate-700 text-slate-500 flex items-center justify-center text-xl mb-3">
                                                    <i class="fas fa-inbox"></i>
                                                </div>
                                                <h4 class="text-slate-300 font-semibold text-sm">Belum Ada Data Laporan</h4>
                                                <p class="text-slate-500 text-xs mt-1">Lakukan pencatatan kegiatan melalui Dashboard User.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Smart Pagination -->
                        <div class="pagination flex items-center justify-center gap-1.5 pt-3" id="pagination">
                            <!-- Populated dynamically by JavaScript -->
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12 px-4">
                            <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-800/60 border border-slate-700/80 text-emerald-400 flex items-center justify-center text-2xl mb-3 shadow-lg">
                                <i class="fas fa-clipboard-question"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-1">Belum Ada Kegiatan Tercatat</h3>
                            <p class="text-slate-400 text-xs max-w-sm mx-auto mb-5">
                                Anda belum memiliki laporan kegiatan tersimpan untuk akun NIP ini. Silakan mulai entri formulir kinerja di dashboard.
                            </p>
                            <a href="/user-dashboard{{ isset($currentUser->nip) ? '?nip='.$currentUser->nip : '' }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-semibold shadow-md shadow-emerald-600/30 transition-all">
                                <i class="fas fa-plus"></i>
                                <span>Buat Kegiatan Baru</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- View 2: Rekap Bulanan View (Cross Tabular) -->
                <div id="rekapLaporanTable" style="display: none;">
                    @php
                        $rekapData = [];
                        $allDates = [];
                        $totalPerDate = [];
                        $grandTotal = 0;
                        
                        if (isset($laporanData)) {
                            foreach($laporanData as $item) {
                                $kegiatan = $item->jenis_kegiatan ?: 'Tanpa Kegiatan';
                                $dateStr = $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('Y-m-d') : null;
                                
                                if ($dateStr) {
                                    if (!isset($rekapData[$kegiatan])) {
                                        $rekapData[$kegiatan] = [];
                                    }
                                    if (!isset($rekapData[$kegiatan][$dateStr])) {
                                        $rekapData[$kegiatan][$dateStr] = 0;
                                    }
                                    $rekapData[$kegiatan][$dateStr]++;
                                    $allDates[$dateStr] = true;
                                }
                            }
                        }
                        
                        $allDatesList = array_keys($allDates);
                        sort($allDatesList);
                        
                        foreach($allDatesList as $date) {
                            $totalPerDate[$date] = 0;
                        }
                        
                        foreach($rekapData as $kegiatan => $datesCount) {
                            foreach($datesCount as $date => $count) {
                                $totalPerDate[$date] += $count;
                                $grandTotal += $count;
                            }
                        }
                    @endphp

                    <div class="table-responsive bg-slate-900/60 p-1">
                        <table class="w-full min-w-max border-collapse" id="rekapBulananTable">
                            <thead>
                                <tr>
                                    <th class="bg-slate-800 text-slate-300 p-3 text-xs font-bold text-left border-b border-slate-700 w-64 uppercase tracking-wider">Jenis Kegiatan</th>
                                    @foreach($allDatesList as $date)
                                        <th class="bg-slate-800 text-slate-300 p-3 text-[11px] font-bold text-center border-b border-slate-700 border-l border-slate-700/50">
                                            {{ \Carbon\Carbon::parse($date)->format('d/m') }}
                                        </th>
                                    @endforeach
                                    <th class="bg-teal-900/40 text-teal-300 p-3 text-xs font-bold text-center border-b border-slate-700 border-l border-teal-500/30 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapData as $kegiatan => $counts)
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="p-3 text-xs text-slate-200 border-b border-slate-700/50 font-medium">
                                            {{ $kegiatan }}
                                        </td>
                                        @php $rowTotal = 0; @endphp
                                        @foreach($allDatesList as $date)
                                            @php 
                                                $count = $counts[$date] ?? 0; 
                                                $rowTotal += $count;
                                            @endphp
                                            <td class="p-3 text-xs text-center border-b border-slate-700/50 border-l border-slate-700/30 {{ $count > 0 ? 'text-emerald-400 font-bold' : 'text-slate-600' }}">
                                                {{ $count > 0 ? $count : '-' }}
                                            </td>
                                        @endforeach
                                        <td class="p-3 text-xs text-center border-b border-slate-700/50 border-l border-teal-500/30 bg-teal-900/10 text-teal-300 font-bold">
                                            {{ $rowTotal }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($allDatesList) + 2 }}" class="p-8 text-center text-slate-500 text-xs italic">
                                            Belum ada data rekapitulasi kegiatan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if(count($rekapData) > 0)
                            <tfoot>
                                <tr class="bg-slate-800/80">
                                    <td class="p-3 text-xs text-right text-slate-300 font-bold border-t border-slate-600">
                                        Total Harian
                                    </td>
                                    @foreach($allDatesList as $date)
                                        <td class="p-3 text-xs text-center text-emerald-400 font-bold border-t border-slate-600 border-l border-slate-700/50">
                                            {{ $totalPerDate[$date] }}
                                        </td>
                                    @endforeach
                                    <td class="p-3 text-sm text-center text-white bg-teal-600/40 font-bold border-t border-teal-500/50 border-l border-teal-500/30 shadow-[inset_0_0_10px_rgba(20,184,166,0.2)]">
                                        {{ $grandTotal }}
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>


            </div>
        @endif

    </div>

    <!-- Lightbox Modal untuk Tanda Tangan & Dokumentasi -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-b border-slate-700/80 px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-image text-emerald-400 text-sm"></i>
                        <h5 class="modal-title font-semibold text-white text-sm" id="imageModalLabel">Preview Dokumen</h5>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-white transition-colors text-base" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body text-center p-4 bg-slate-950/90">
                    <img id="modalImage" src="" alt="Preview" class="img-fluid rounded-xl mx-auto shadow-xl" style="max-height: 70vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- Executive Detail Modal (Full Info Drill-down) -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-b border-slate-700/80 px-5 py-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-sm">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h5 class="modal-title font-bold text-white text-sm sm:text-base" id="detailModalTitle">Detail Kegiatan</h5>
                            <span class="text-[11px] text-slate-400" id="detailModalSubtitle">Informasi lengkap kegiatan</span>
                        </div>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-white transition-colors text-base" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-4 sm:p-5 space-y-4 bg-slate-900/90 text-xs sm:text-sm">
                    
                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/50">
                            <span class="text-[11px] text-slate-400 block mb-0.5">Jenis Kegiatan</span>
                            <span class="text-white font-semibold" id="modalDetailJenisKegiatan">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/50">
                            <span class="text-[11px] text-slate-400 block mb-0.5">Status Verifikasi</span>
                            <span id="modalDetailStatus" class="status-badge status-draft">Draft</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/50">
                            <span class="text-[11px] text-slate-400 block mb-0.5">Pegawai & NIP</span>
                            <span class="text-white font-semibold" id="modalDetailPegawai">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/50">
                            <span class="text-[11px] text-slate-400 block mb-0.5">Unit / Ruangan & Waktu</span>
                            <span class="text-white font-semibold" id="modalDetailUnitWaktu">-</span>
                        </div>
                    </div>

                    <!-- Hasil Temuan -->
                    <div class="p-3.5 rounded-xl bg-slate-800/60 border border-slate-700/50 space-y-1">
                        <span class="text-[11px] font-semibold text-emerald-400 uppercase tracking-wider block">
                            <i class="fas fa-note-sticky mr-1"></i> Hasil Temuan & Uraian Kegiatan
                        </span>
                        <div class="text-slate-200 whitespace-pre-line leading-relaxed text-xs sm:text-sm" id="modalDetailTemuan">-</div>
                    </div>

                    <!-- Signature Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/50 text-center space-y-1.5">
                            <span class="text-[11px] font-semibold text-slate-300 block">Tanda Tangan Pelaksana</span>
                            <div id="modalDetailSigPelaksanaContainer" class="p-2 bg-white rounded-lg inline-block shadow">
                                <img id="modalDetailSigPelaksana" src="" alt="TTD Pelaksana" style="max-height: 52px;">
                            </div>
                            <div class="text-xs font-semibold text-emerald-400" id="modalDetailNamaPelaksana">-</div>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/50 text-center space-y-1.5">
                            <span class="text-[11px] font-semibold text-slate-300 block">Tanda Tangan Penanggung Jawab</span>
                            <div id="modalDetailSigPJContainer" class="p-2 bg-white rounded-lg inline-block shadow">
                                <img id="modalDetailSigPJ" src="" alt="TTD PJ" style="max-height: 52px;">
                            </div>
                            <div class="text-xs font-semibold text-cyan-400" id="modalDetailNamaPJ">-</div>
                        </div>
                    </div>

                    <!-- Dokumentasi Grid -->
                    <div class="space-y-2">
                        <span class="text-[11px] font-semibold text-slate-300 block flex items-center justify-between">
                            <span><i class="fas fa-camera mr-1 text-emerald-400"></i> Dokumentasi Kegiatan</span>
                            <span class="text-slate-400" id="modalDetailDocCount">0 Foto</span>
                        </span>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5" id="modalDetailDocGrid">
                            <!-- Populated dynamically -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-t border-slate-700/80 px-5 py-3 flex justify-between items-center">
                    <button type="button" id="btnEditFromModal" class="px-4 py-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 border border-emerald-500/40 text-xs font-semibold transition-colors flex items-center gap-1.5" onclick="editCurrentModalItem()">
                        <i class="fas fa-edit"></i> Edit Kegiatan
                    </button>
                    <button type="button" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 96vw;">
            <div class="modal-content border border-slate-700 bg-slate-900 shadow-2xl rounded-2xl overflow-hidden">
                <!-- Header -->
                <div class="modal-header border-b border-slate-700/80 px-4 sm:px-6 py-3.5 flex items-center justify-between bg-slate-900/95 backdrop-blur">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-400 flex items-center justify-center text-base shrink-0">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="min-w-0">
                            <h5 class="modal-title font-bold text-white text-sm sm:text-base truncate" id="pdfPreviewModalLabel">
                                Pratinjau Dokumen Laporan PDF
                            </h5>
                            <span class="text-[11px] text-slate-400 truncate block" id="pdfPreviewFilename">Laporan_Kinerja.pdf</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors flex items-center gap-1.5" onclick="openPdfInNewTab()" title="Buka dokumen di tab baru browser">
                            <i class="fas fa-arrow-up-right-from-square"></i> <span class="hidden md:inline">Buka di Tab Baru</span>
                        </button>
                        <button type="button" class="text-slate-400 hover:text-white transition-colors text-base p-1.5" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Helper Notice -->
                <div class="bg-amber-500/10 border-b border-amber-500/20 px-4 py-2 flex items-center justify-between text-xs text-amber-300 sm:hidden">
                    <span class="truncate"><i class="fas fa-mobile-screen mr-1 text-amber-400"></i> Mode Ponsel: Gunakan tombol Buka Tab Baru jika pratinjau tidak muncul</span>
                    <button type="button" class="text-amber-300 font-bold underline shrink-0 ml-2" onclick="openPdfInNewTab()">Buka Tab</button>
                </div>

                <!-- Body (responsive height PDF container) -->
                <div class="modal-body p-0 bg-slate-950 relative" style="height: 75vh; min-height: 480px;">
                    <!-- Loading Indicator -->
                    <div id="pdfLoadingSkeleton" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-950 text-slate-400 z-10">
                        <i class="fas fa-spinner fa-spin text-3xl text-rose-500 mb-3"></i>
                        <p class="text-xs font-medium text-slate-300">Membuat dan merender pratinjau dokumen PDF...</p>
                    </div>
                    <!-- PDF Iframe -->
                    <iframe id="pdfPreviewFrame" src="" class="w-full h-full border-0" title="Pratinjau Dokumen PDF"></iframe>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-t border-slate-700/80 px-4 sm:px-6 py-3 flex flex-wrap justify-between items-center gap-2 bg-slate-900/95">
                    <button type="button" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors flex items-center gap-1.5" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <div class="flex items-center gap-2">
                        <button type="button" class="px-3.5 sm:px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-600 text-xs font-semibold transition-colors flex items-center gap-1.5" onclick="printPdfFromPreview()">
                            <i class="fas fa-print text-emerald-400"></i> <span class="hidden sm:inline">Cetak Langsung</span><span class="sm:hidden">Cetak</span>
                        </button>
                        <button type="button" class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-semibold shadow-md shadow-emerald-600/30 transition-all flex items-center gap-1.5" onclick="downloadCurrentPdf()">
                            <i class="fas fa-download"></i> Unduh File PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- App Interactive Script -->
    <script>
        const rawItemsData = @json($laporanData ? $laporanData->keyBy('id') : []);
        let currentView = 'laporan'; // 'laporan' or 'rekap'
        let currentPage = 1;
        const pageSize = 10;
        let filteredRowIndices = [];

        // Toggle Filter Drawer on Mobile
        function toggleMobileFilter() {
            const drawer = document.getElementById('filterDrawer');
            if (drawer) {
                drawer.classList.toggle('hidden');
            }
        }

        // Tab Switching
        function showLaporanKegiatan() {
            currentView = 'laporan';
            
            // Desktop Cards
            const cardLaporan = document.getElementById('laporanKegiatanCard');
            const cardRekap = document.getElementById('rekapLaporanCard');
            if (cardLaporan) cardLaporan.classList.add('active');
            if (cardRekap) cardRekap.classList.remove('active');

            // Mobile Segmented Buttons
            const mobLaporan = document.getElementById('mobileTabLaporan');
            const mobRekap = document.getElementById('mobileTabRekap');
            if (mobLaporan) mobLaporan.classList.add('active');
            if (mobRekap) mobRekap.classList.remove('active');
            
            const titleText = document.getElementById('titleText');
            if (titleText) titleText.textContent = 'Data Kegiatan Lengkap';

            const tableSubtitle = document.getElementById('tableSubtitle');
            if (tableSubtitle) tableSubtitle.textContent = 'Daftar seluruh rekaman aktivitas pekerjaan dengan tanda tangan dan foto dokumentasi';

            const tableIcon = document.getElementById('tableIcon');
            if (tableIcon) tableIcon.className = 'fas fa-table';
            
            document.getElementById('laporanKegiatanTable').style.display = 'block';
            document.getElementById('rekapLaporanTable').style.display = 'none';
            document.querySelector('.table-controls').style.display = 'block';
            
            applyFilters();
        }

        function showRekapLaporan() {
            currentView = 'rekap';
            
            // Desktop Cards
            const cardLaporan = document.getElementById('laporanKegiatanCard');
            const cardRekap = document.getElementById('rekapLaporanCard');
            if (cardRekap) cardRekap.classList.add('active');
            if (cardLaporan) cardLaporan.classList.remove('active');

            // Mobile Segmented Buttons
            const mobLaporan = document.getElementById('mobileTabLaporan');
            const mobRekap = document.getElementById('mobileTabRekap');
            if (mobRekap) mobRekap.classList.add('active');
            if (mobLaporan) mobLaporan.classList.remove('active');
            
            const titleText = document.getElementById('titleText');
            if (titleText) titleText.textContent = 'Rekapitulasi Kinerja & Persetujuan';

            const tableSubtitle = document.getElementById('tableSubtitle');
            if (tableSubtitle) tableSubtitle.textContent = 'Analisis statistik berdasarkan status dan distribusi unit kerja pegawai';

            const tableIcon = document.getElementById('tableIcon');
            if (tableIcon) tableIcon.className = 'fas fa-chart-pie';
            
            document.getElementById('laporanKegiatanTable').style.display = 'none';
            document.getElementById('rekapLaporanTable').style.display = 'block';
            document.querySelector('.table-controls').style.display = 'none';
        }

        // Live Search & Multi-criteria Filtering
        function applyFilters() {
            const searchInput = document.getElementById('searchInput');
            const jenisKegiatanFilter = document.getElementById('jenisKegiatanFilter');
            const statusFilter = document.getElementById('statusFilter');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            const query = (searchInput ? searchInput.value.trim().toLowerCase() : '');
            const selectedKegiatan = (jenisKegiatanFilter ? jenisKegiatanFilter.value.trim().toLowerCase() : '');
            const selectedStatus = (statusFilter ? statusFilter.value.trim().toLowerCase() : '');
            const startDate = (startDateInput && startDateInput.value) ? new Date(startDateInput.value + 'T00:00:00') : null;
            const endDate = (endDateInput && endDateInput.value) ? new Date(endDateInput.value + 'T23:59:59.999') : null;

            // Active filter badge indicator
            const activeBadge = document.getElementById('activeFilterBadge');
            if (activeBadge) {
                if (selectedKegiatan || selectedStatus || (startDateInput && startDateInput.value) || (endDateInput && endDateInput.value)) {
                    activeBadge.classList.remove('hidden');
                } else {
                    activeBadge.classList.add('hidden');
                }
            }

            const rows = Array.from(document.querySelectorAll('#tableBody tr[data-id]'));
            filteredRowIndices = [];

            rows.forEach((row, index) => {
                const textContent = row.textContent.toLowerCase();
                const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
                const id = row.getAttribute('data-id');
                const rawItem = (typeof rawItemsData !== 'undefined' && rawItemsData[id]) ? rawItemsData[id] : null;
                const rowKegiatan = rawItem && rawItem.jenis_kegiatan ? rawItem.jenis_kegiatan.toLowerCase() : (row.cells[1] ? row.cells[1].textContent.toLowerCase() : '');
                
                let rowMatchesDate = true;
                const dateCell = row.cells[4];
                if (dateCell && (startDate || endDate)) {
                    const dateText = dateCell.textContent.trim();
                    try {
                        const dateParts = dateText.split(' ')[0].split('/');
                        if (dateParts.length === 3) {
                            const rowDate = new Date(parseInt(dateParts[2]), parseInt(dateParts[1]) - 1, parseInt(dateParts[0]));
                            if (startDate && rowDate < startDate) rowMatchesDate = false;
                            if (endDate && rowDate > endDate) rowMatchesDate = false;
                        }
                    } catch(e) {
                        console.error('Date parse err:', e);
                    }
                }

                const matchesSearch = (!query || textContent.includes(query));
                const matchesKegiatan = (!selectedKegiatan || rowKegiatan.includes(selectedKegiatan));
                const matchesStatus = (!selectedStatus || rowStatus === selectedStatus);

                if (matchesSearch && matchesKegiatan && matchesStatus && rowMatchesDate) {
                    filteredRowIndices.push(index);
                }
            });

            // Update visible indicator
            const visibleIndicator = document.getElementById('visibleCountIndicator');
            if (visibleIndicator) {
                visibleIndicator.textContent = filteredRowIndices.length;
            }

            // Handle empty message
            hideNoDataMessage();
            if (rows.length > 0 && filteredRowIndices.length === 0) {
                showNoDataMessage('Tidak ada data kegiatan yang cocok dengan kriteria pencarian atau filter.');
            }

            // Render Pagination
            currentPage = 1;
            renderPaginatedRows();
        }

        function renderPaginatedRows() {
            const rows = Array.from(document.querySelectorAll('#tableBody tr[data-id]'));
            const mobileCards = Array.from(document.querySelectorAll('.mobile-activity-card[data-id]'));
            const totalFiltered = filteredRowIndices.length;
            const totalPages = Math.ceil(totalFiltered / pageSize) || 1;

            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIndex = (currentPage - 1) * pageSize;
            const endIndex = startIndex + pageSize;

            // Sync Desktop Rows
            rows.forEach((row, idx) => {
                const filteredPos = filteredRowIndices.indexOf(idx);
                if (filteredPos !== -1 && filteredPos >= startIndex && filteredPos < endIndex) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Sync Mobile Cards
            mobileCards.forEach((card, idx) => {
                const filteredPos = filteredRowIndices.indexOf(idx);
                if (filteredPos !== -1 && filteredPos >= startIndex && filteredPos < endIndex) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            renderPaginationControls(totalPages);
        }

        function renderPaginationControls(totalPages) {
            const container = document.getElementById('pagination');
            if (!container) return;
            container.innerHTML = '';

            if (totalPages <= 1) return;

            // Prev Button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'page-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left text-[11px]"></i>';
            prevBtn.disabled = (currentPage === 1);
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderPaginatedRows();
                }
            };
            container.appendChild(prevBtn);

            // Page numbers
            for (let p = 1; p <= totalPages; p++) {
                if (p === 1 || p === totalPages || (p >= currentPage - 1 && p <= currentPage + 1)) {
                    const pBtn = document.createElement('button');
                    pBtn.className = `page-btn ${p === currentPage ? 'active' : ''}`;
                    pBtn.textContent = p;
                    pBtn.onclick = () => {
                        currentPage = p;
                        renderPaginatedRows();
                    };
                    container.appendChild(pBtn);
                } else if (p === currentPage - 2 || p === currentPage + 2) {
                    const dots = document.createElement('span');
                    dots.className = 'px-1 text-slate-500 text-xs';
                    dots.textContent = '...';
                    container.appendChild(dots);
                }
            }

            // Next Button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'page-btn';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right text-[11px]"></i>';
            nextBtn.disabled = (currentPage === totalPages);
            nextBtn.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPaginatedRows();
                }
            };
            container.appendChild(nextBtn);
        }

        function resetTable() {
            const todayStr = new Date().toISOString().split('T')[0];
            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const jenisKegiatanFilter = document.getElementById('jenisKegiatanFilter');

            if (startDate) startDate.value = todayStr;
            if (endDate) endDate.value = todayStr;
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';
            if (jenisKegiatanFilter) jenisKegiatanFilter.value = '';

            applyFilters();
        }

        function showNoDataMessage(message) {
            hideNoDataMessage();
            
            // For Desktop
            const tbody = document.getElementById('tableBody');
            if (tbody) {
                const noDataRow = document.createElement('tr');
                noDataRow.id = 'noDataRow';
                noDataRow.innerHTML = `
                    <td colspan="10" class="text-center py-10">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="text-slate-300 font-semibold text-sm">${message}</div>
                        <div class="text-slate-500 text-xs mt-1">Coba ubah kata kunci atau bersihkan filter tanggal.</div>
                    </td>
                `;
                tbody.appendChild(noDataRow);
            }

            // For Mobile
            const mobileContainer = document.getElementById('mobileCardsContainer');
            if (mobileContainer) {
                const noDataCard = document.createElement('div');
                noDataCard.id = 'noDataMobileCard';
                noDataCard.className = 'p-6 rounded-2xl bg-slate-900/80 border border-slate-700/60 text-center space-y-2';
                noDataCard.innerHTML = `
                    <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-base">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="text-slate-300 font-semibold text-xs">${message}</div>
                    <button type="button" onclick="resetTable()" class="px-3 py-1.5 rounded-lg bg-emerald-600/20 text-emerald-400 text-xs font-medium">Reset Filter</button>
                `;
                mobileContainer.appendChild(noDataCard);
            }
        }

        function hideNoDataMessage() {
            const noDataRow = document.getElementById('noDataRow');
            if (noDataRow) noDataRow.remove();

            const noDataMobile = document.getElementById('noDataMobileCard');
            if (noDataMobile) noDataMobile.remove();
        }

        // Lightbox Modal Display
        function showImageModal(imageSrc, title) {
            const modalImg = document.getElementById('modalImage');
            const modalTitle = document.getElementById('imageModalLabel');
            if (modalImg) modalImg.src = imageSrc;
            if (modalTitle) modalTitle.textContent = title;
            const modalEl = document.getElementById('imageModal');
            if (modalEl && window.bootstrap) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        let currentModalDetailId = null;

        // View Detail Drill-Down Modal
        function viewDetail(id) {
            currentModalDetailId = id;
            const item = rawItemsData[id];
            if (!item) return;

            document.getElementById('modalDetailJenisKegiatan').textContent = item.jenis_kegiatan || '-';
            
            // Status badge
            const statusEl = document.getElementById('modalDetailStatus');
            const st = (item.status || 'draft').toLowerCase();
            statusEl.className = `status-badge status-${st}`;
            statusEl.textContent = st.toUpperCase();

            // Pegawai
            const pegName = (item.user ? item.user.name : (item.creator ? item.creator.name : '{{ $currentUser->name ?? "-" }}'));
            document.getElementById('modalDetailPegawai').textContent = `${pegName} (NIP: ${item.nip || '-'})`;

            // Unit & Waktu
            const dtText = item.tanggal_dibuat ? new Date(item.tanggal_dibuat).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : '-';
            document.getElementById('modalDetailUnitWaktu').textContent = `${item.unit || '-'} • ${dtText}`;

            // Hasil Temuan
            document.getElementById('modalDetailTemuan').textContent = item.hasil_temuan || 'Tidak ada catatan hasil temuan.';

            // Signatures
            let sigPel = item.signature_pelaksana;
            if (sigPel && !sigPel.startsWith('data:image/')) sigPel = 'data:image/png;base64,' + sigPel;
            const pelImg = document.getElementById('modalDetailSigPelaksana');
            if (sigPel) {
                pelImg.src = sigPel;
                pelImg.style.display = 'block';
            } else {
                pelImg.style.display = 'none';
            }
            document.getElementById('modalDetailNamaPelaksana').textContent = item.nama_pelaksana || pegName || 'Pelaksana';

            let sigPJ = item.signature_pj;
            if (sigPJ && !sigPJ.startsWith('data:image/')) sigPJ = 'data:image/png;base64,' + sigPJ;
            const pjImg = document.getElementById('modalDetailSigPJ');
            if (sigPJ) {
                pjImg.src = sigPJ;
                pjImg.style.display = 'block';
            } else {
                pjImg.style.display = 'none';
            }
            document.getElementById('modalDetailNamaPJ').textContent = item.nama_pj || 'Penanggung Jawab';

            // Documentation Gallery
            const docGrid = document.getElementById('modalDetailDocGrid');
            const docCount = document.getElementById('modalDetailDocCount');
            docGrid.innerHTML = '';

            const docs = Array.isArray(item.dokumentasi) ? item.dokumentasi : [];
            docCount.textContent = `${docs.length} Foto Dokumentasi`;

            if (docs.length > 0) {
                docs.forEach((doc, idx) => {
                    let docUrl = doc;
                    if (!docUrl.startsWith('http://') && !docUrl.startsWith('https://') && !docUrl.startsWith('data:')) {
                        let clean = docUrl.replace(/^\/+/, '');
                        if (!clean.startsWith('storage/')) {
                            clean = 'storage/' + clean;
                        }
                        docUrl = '/' + clean;
                    }
                    const thumbWrap = document.createElement('div');
                    thumbWrap.className = 'relative group cursor-pointer overflow-hidden rounded-xl border border-slate-700 bg-slate-800/50';
                    thumbWrap.innerHTML = `
                        <img src="${docUrl}" class="w-full h-20 object-cover transition-transform group-hover:scale-105" alt="Dokumentasi ${idx + 1}" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'40\\' height=\\'40\\' viewBox=\\'0 0 24 24\\' fill=\\'none\\' stroke=\\'%2364748b\\' stroke-width=\\'1.5\\'><rect width=\\'18\\' height=\\'18\\' x=\\'3\\' y=\\'3\\' rx=\\'2\\'/><circle cx=\\'9\\' cy=\\'9\\' r=\\'2\\'/><path d=\\'m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21\\'/></svg>';">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[11px] font-semibold">
                            <i class="fas fa-magnifying-glass-plus mr-1"></i> Perbesar
                        </div>
                    `;
                    thumbWrap.onclick = () => showImageModal(docUrl, `Dokumentasi ${idx + 1} - ${item.jenis_kegiatan}`);
                    docGrid.appendChild(thumbWrap);
                });
            } else {
                docGrid.innerHTML = '<div class="col-span-full text-slate-500 text-xs italic py-3">Tidak ada foto dokumentasi tersimpan untuk kegiatan ini.</div>';
            }

            // Show Detail Modal
            const detailModalEl = document.getElementById('detailModal');
            if (detailModalEl && window.bootstrap) {
                const modal = new bootstrap.Modal(detailModalEl);
                modal.show();
            }
        }

        // Edit Item from inside modal
        function editCurrentModalItem() {
            if (currentModalDetailId) {
                editItem(currentModalDetailId);
            }
        }

        // Edit / Continue Item
        function editItem(id) {
            const item = rawItemsData[id];
            if (!item) return;

            // Store full item in sessionStorage so all fields, signatures, photos, unit, etc are instantly pre-filled
            try {
                sessionStorage.setItem('editDetailData', JSON.stringify(item));
            } catch (e) {
                console.error('Failed to save editDetailData to sessionStorage', e);
            }

            const payload = encodeURIComponent(JSON.stringify({
                id: item.id,
                jenis_kegiatan: item.jenis_kegiatan,
                nip: item.nip,
                unit: item.unit,
                golongan: '{{ $currentUser->golongan ?? "III/a" }}'
            }));

            window.location.href = `/jenis-kegiatan/detail?id=${item.id}&edit=true&data=${payload}`;
        }

        // Image Base64 Converter for PDF Export (Supports Elements, URLs, and DataURIs)
        function getImageAsBase64(srcOrElement) {
            return new Promise((resolve) => {
                if (!srcOrElement) {
                    resolve('');
                    return;
                }
                
                let src = typeof srcOrElement === 'string' ? srcOrElement : (srcOrElement.src || '');
                if (!src) {
                    resolve('');
                    return;
                }

                // If already data URL, resolve directly
                if (src.startsWith('data:image/')) {
                    resolve(src);
                    return;
                }

                try {
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    
                    img.onload = function() {
                        try {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = this.naturalWidth || this.width || 320;
                            canvas.height = this.naturalHeight || this.height || 220;
                            
                            ctx.fillStyle = '#FFFFFF';
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                            ctx.drawImage(this, 0, 0);
                            
                            const dataURL = canvas.toDataURL('image/jpeg', 0.88);
                            resolve(dataURL);
                        } catch (e) {
                            console.warn('Canvas export warning:', e);
                            resolve('');
                        }
                    };
                    
                    img.onerror = function() {
                        console.warn('Image load error for PDF:', src);
                        resolve('');
                    };
                    
                    img.src = src;
                } catch (e) {
                    console.warn('Image process error:', e);
                    resolve('');
                }
            });
        }

        // Professional PDF Export Engine with Official Institutional Layout
        async function exportToPDF() {
            const exportBtn = document.getElementById('exportPdfButton');
            const origContent = exportBtn ? exportBtn.innerHTML : '';
            if (exportBtn) {
                exportBtn.disabled = true;
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Menyusun Dokumen PDF...';
            }

            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4',
                    compress: true
                });
                
                const pageWidth = doc.internal.pageSize.getWidth(); // 297mm
                const pageHeight = doc.internal.pageSize.getHeight(); // 210mm
                const marginX = 14;
                const contentWidth = pageWidth - (marginX * 2); // 269mm
                
                const rawInstansi = '{{ $currentUser->instansi ?? "RUMAH SAKIT UMUM DAERAH" }}';
                const namaInstansi = rawInstansi ? rawInstansi.trim() : 'RUMAH SAKIT UMUM DAERAH';
                const userName = '{{ $currentUser->name ?? "Pegawai" }}';
                const userNip = '{{ $currentUser->nip ?? "" }}';
                
                // 1. KOP SURAT / HEADER RESMI
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(13);
                doc.setTextColor(15, 23, 42); // slate-900
                doc.text(namaInstansi.toUpperCase(), pageWidth / 2, 12, { align: 'center' });
                
                doc.setFontSize(12.5);
                doc.setTextColor(13, 148, 136); // teal-600
                doc.text('LAPORAN CAPAIAN KINERJA HARIAN PEGAWAI', pageWidth / 2, 17.5, { align: 'center' });
                
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(100, 116, 139); // slate-500
                doc.text('Sistem Informasi Manajemen Akuntabilitas & Kinerja Pegawai Terpadu', pageWidth / 2, 22, { align: 'center' });
                
                // Double Rule Line khas Surat/Dokumen Resmi
                doc.setDrawColor(15, 23, 42);
                doc.setLineWidth(0.65);
                doc.line(marginX, 25, pageWidth - marginX, 25);
                
                doc.setDrawColor(148, 163, 184);
                doc.setLineWidth(0.25);
                doc.line(marginX, 26.2, pageWidth - marginX, 26.2);
                
                // 2. KOTAK INFORMASI METADATA PEGAWAI & LAPORAN
                const metaBoxY = 28.5;
                const metaBoxH = 16.5;
                doc.setFillColor(248, 250, 252); // slate-50
                doc.setDrawColor(226, 232, 240); // slate-200
                doc.setLineWidth(0.3);
                doc.roundedRect(marginX, metaBoxY, contentWidth, metaBoxH, 1.5, 1.5, 'FD');
                
                // Pembatas Kolom Kiri & Kanan di dalam Kotak Metadata
                const midX = marginX + 135;
                doc.setDrawColor(226, 232, 240);
                doc.setLineWidth(0.25);
                doc.line(midX, metaBoxY + 2, midX, metaBoxY + metaBoxH - 2);

                // Periode Filter
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                let periodeText = 'Semua Periode / Riwayat Tercatat';
                if (startDateInput && startDateInput.value && endDateInput && endDateInput.value) {
                    periodeText = `${startDateInput.value} s/d ${endDateInput.value}`;
                } else if (startDateInput && startDateInput.value) {
                    periodeText = `Mulai: ${startDateInput.value}`;
                } else if (endDateInput && endDateInput.value) {
                    periodeText = `Sampai: ${endDateInput.value}`;
                }
                const printDateStr = new Date().toLocaleDateString('id-ID', { 
                    day: '2-digit', 
                    month: 'long', 
                    year: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });

                // Metadata Kolom Kiri (Data Pegawai)
                doc.setFontSize(7.5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Nama Pegawai', marginX + 4, metaBoxY + 5);
                doc.text(':', marginX + 28, metaBoxY + 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(15, 23, 42);
                doc.text(userName, marginX + 31, metaBoxY + 5);

                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('NIP Pegawai', marginX + 4, metaBoxY + 9.5);
                doc.text(':', marginX + 28, metaBoxY + 9.5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(15, 23, 42);
                doc.text(userNip || '-', marginX + 31, metaBoxY + 9.5);

                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Instansi / Unit', marginX + 4, metaBoxY + 14);
                doc.text(':', marginX + 28, metaBoxY + 14);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(15, 23, 42);
                doc.text(namaInstansi, marginX + 31, metaBoxY + 14);

                // Metadata Kolom Kanan (Informasi Berkas)
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Periode Laporan', midX + 6, metaBoxY + 5);
                doc.text(':', midX + 32, metaBoxY + 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(15, 23, 42);
                doc.text(periodeText, midX + 35, metaBoxY + 5);

                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Tanggal Cetak', midX + 6, metaBoxY + 9.5);
                doc.text(':', midX + 32, metaBoxY + 9.5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(15, 23, 42);
                doc.text(printDateStr + ' WIB', midX + 35, metaBoxY + 9.5);

                // 3. EKSTRAKSI DATA BARIS YANG RELEVAN
                const allRows = Array.from(document.querySelectorAll('#tableBody tr[data-id]'));
                let targetRows = [];
                
                // Gunakan daftar indeks baris hasil filter aktif jika ada
                if (typeof filteredRowIndices !== 'undefined' && filteredRowIndices.length > 0) {
                    targetRows = filteredRowIndices.map(idx => allRows[idx]).filter(Boolean);
                } else {
                    targetRows = allRows.filter(row => row.getAttribute('data-id'));
                }

                if (targetRows.length === 0) {
                    alert('Tidak ada data kegiatan yang dipilih atau tersedia untuk diekspor.');
                    if (exportBtn) {
                        exportBtn.disabled = false;
                        exportBtn.innerHTML = origContent;
                    }
                    return;
                }

                // Tampilkan total kegiatan tercatat pada metadata
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Total Kegiatan', midX + 6, metaBoxY + 14);
                doc.text(':', midX + 32, metaBoxY + 14);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(13, 148, 136);
                doc.text(`${targetRows.length} Kegiatan Terverifikasi`, midX + 35, metaBoxY + 14);

                let no = 1;
                const processedRows = [];

                for (const row of targetRows) {
                    const rowId = row.getAttribute('data-id');
                    const itemData = (typeof rawItemsData !== 'undefined' && rawItemsData && rawItemsData[rowId]) ? rawItemsData[rowId] : {};
                    const cells = row.cells;
                    if (!cells || cells.length < 9) continue;

                    // Jenis Kegiatan & Status
                    let jenisKegiatan = (itemData.jenis_kegiatan || '').trim();
                    if (!jenisKegiatan) {
                        const jEl = cells[1].querySelector('.font-semibold');
                        jenisKegiatan = jEl ? jEl.textContent.trim() : cells[1].textContent.trim();
                    }
                    const statusKey = (itemData.status || row.getAttribute('data-status') || 'draft').toLowerCase();

                    // Waktu Catat
                    let tanggalStr = '-';
                    let jamStr = '';
                    if (itemData.tanggal_dibuat) {
                        try {
                            const d = new Date(itemData.tanggal_dibuat);
                            if (!isNaN(d.getTime())) {
                                tanggalStr = d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                                jamStr = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
                            }
                        } catch (e) {}
                    }
                    if (tanggalStr === '-') {
                        const tText = cells[4] ? cells[4].textContent.replace(/\s+/g, ' ').trim() : '';
                        const parts = tText.split(' ');
                        tanggalStr = parts[0] || '-';
                        jamStr = parts.slice(1).join(' ') || '';
                    }

                    // Ruang / Unit
                    let unit = (itemData.unit || (cells[3] ? cells[3].textContent.replace(/\s+/g, ' ').trim() : '-'));

                    // Hasil Temuan / Uraian
                    let hasilTemuan = (itemData.hasil_temuan || (cells[5] ? cells[5].textContent.replace(/\s+/g, ' ').trim() : '-'));

                    // Signature Pelaksana
                    let sigPelaksana = itemData.signature_pelaksana || '';
                    if (sigPelaksana && !sigPelaksana.startsWith('data:image/')) {
                        if (/^[A-Za-z0-9+/=]+$/.test(sigPelaksana.trim())) {
                            sigPelaksana = 'data:image/png;base64,' + sigPelaksana.trim();
                        }
                    }
                    if (!sigPelaksana && cells[6]) {
                        const pImg = cells[6].querySelector('img');
                        if (pImg) sigPelaksana = await getImageAsBase64(pImg);
                    }

                    // Signature PJ
                    let sigPJ = itemData.signature_pj || '';
                    if (sigPJ && !sigPJ.startsWith('data:image/')) {
                        if (/^[A-Za-z0-9+/=]+$/.test(sigPJ.trim())) {
                            sigPJ = 'data:image/png;base64,' + sigPJ.trim();
                        }
                    }
                    if (!sigPJ && cells[7]) {
                        const pjImg = cells[7].querySelector('img');
                        if (pjImg) sigPJ = await getImageAsBase64(pjImg);
                    }

                    // Nama Pelaksana
                    let namaPelaksana = (itemData.nama_pelaksana || '').trim();
                    if (!namaPelaksana) {
                        if (itemData.user && itemData.user.name) namaPelaksana = itemData.user.name.trim();
                        else if (itemData.creator && itemData.creator.name) namaPelaksana = itemData.creator.name.trim();
                        else if (cells[6]) {
                            const pSpan = cells[6].querySelector('span.truncate') || cells[6].querySelector('span');
                            const pText = pSpan ? pSpan.textContent.trim() : '';
                            if (pText && !pText.toLowerCase().includes('belum ttd')) namaPelaksana = pText;
                        }
                    }
                    if (!namaPelaksana) namaPelaksana = userName;

                    // Nama PJ
                    let namaPJ = (itemData.nama_pj || '').trim();
                    if (!namaPJ && cells[7]) {
                        const pjSpan = cells[7].querySelector('span.truncate') || cells[7].querySelector('span');
                        const pjText = pjSpan ? pjSpan.textContent.trim() : '';
                        if (pjText && !pjText.toLowerCase().includes('belum ttd')) namaPJ = pjText;
                    }
                    if (!namaPJ) namaPJ = 'Penanggung Jawab';

                    // Dokumentasi Foto
                    let docImagesData = [];
                    if (cells[8]) {
                        const docImgs = cells[8].querySelectorAll('img');
                        for (const img of docImgs) {
                            const dData = await getImageAsBase64(img);
                            if (dData) docImagesData.push(dData);
                        }
                    }
                    if (docImagesData.length === 0 && itemData.dokumentasi && Array.isArray(itemData.dokumentasi)) {
                        for (const dPath of itemData.dokumentasi) {
                            let fullUrl = dPath;
                            if (!fullUrl.startsWith('http') && !fullUrl.startsWith('data:')) {
                                let clean = fullUrl.replace(/^\/+/, '');
                                if (!clean.startsWith('storage/')) clean = 'storage/' + clean;
                                fullUrl = '/' + clean;
                            }
                            const dData = await getImageAsBase64(fullUrl);
                            if (dData) docImagesData.push(dData);
                        }
                    }

                    processedRows.push({
                        no: no++,
                        tanggalStr: tanggalStr,
                        jamStr: jamStr,
                        jenisKegiatan: jenisKegiatan,
                        statusKey: statusKey,
                        unit: unit,
                        hasilTemuan: hasilTemuan,
                        signaturePelaksanaData: sigPelaksana,
                        signaturePJData: sigPJ,
                        namaPelaksana: namaPelaksana,
                        namaPJ: namaPJ,
                        dokumentasiData: docImagesData
                    });
                }

                // 4. STRUKTUR DATA AUTOTABLE
                // Kolom 5 (Pelaksana), Kolom 6 (PJ), dan Kolom 7 (Dokumentasi) dikosongkan teksnya
                // agar dirender secara murni dan presisi via didDrawCell tanpa konflik teks
                const autoTableData = processedRows.map(row => [
                    row.no,
                    `${row.tanggalStr}\n${row.jamStr}`,
                    row.jenisKegiatan,
                    row.unit,
                    row.hasilTemuan,
                    '', // Tanda Tangan Pelaksana (di-render visual di didDrawCell)
                    '', // Tanda Tangan PJ (di-render visual di didDrawCell)
                    ''  // Dokumentasi (di-render visual di didDrawCell)
                ]);

                // 5. GENERATE TABEL KINERJA DENGAN AUTOTABLE
                doc.autoTable({
                    head: [[
                        'No',
                        'Waktu Catat',
                        'Jenis Kegiatan',
                        'Ruang/Unit',
                        'Uraian Hasil Temuan',
                        'Tanda Tangan Pelaksana',
                        'Tanda Tangan PJ',
                        'Dokumentasi'
                    ]],
                    body: autoTableData,
                    startY: 48,
                    theme: 'grid',
                    styles: {
                        fontSize: 7.5,
                        cellPadding: { top: 3, right: 2, bottom: 3, left: 2 },
                        overflow: 'linebreak',
                        valign: 'middle',
                        minCellHeight: 33,
                        lineColor: [226, 232, 240],
                        lineWidth: 0.2
                    },
                    headStyles: {
                        fillColor: [15, 23, 42],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center',
                        fontSize: 8,
                        minCellHeight: 9.5,
                        valign: 'middle'
                    },
                    alternateRowStyles: {
                        fillColor: [252, 253, 254]
                    },
                    columnStyles: {
                        0: { halign: 'center', cellWidth: 10, valign: 'middle' },
                        1: { halign: 'center', cellWidth: 26, valign: 'middle' },
                        2: { halign: 'left', cellWidth: 48, valign: 'top' },
                        3: { halign: 'center', cellWidth: 24, valign: 'middle' },
                        4: { halign: 'left', cellWidth: 53, valign: 'top' },
                        5: { halign: 'center', cellWidth: 37, valign: 'middle' },
                        6: { halign: 'center', cellWidth: 37, valign: 'middle' },
                        7: { halign: 'center', cellWidth: 34, valign: 'middle' }
                    },
                    margin: { left: marginX, right: marginX, top: 14, bottom: 14 },
                    tableWidth: 'wrap',
                    didDrawCell: function(data) {
                        if (data.section !== 'body') return;
                        
                        const rowIndex = data.row.index;
                        if (rowIndex >= processedRows.length) return;
                        const row = processedRows[rowIndex];

                        const cellX = data.cell.x;
                        const cellY = data.cell.y;
                        const cellW = data.cell.width;
                        const cellH = data.cell.height;
                        const centerX = cellX + (cellW / 2);
                        const contentTop = cellY + Math.max(1.5, (cellH - 31) / 2);

                        // --- KOLOM 2: JENIS KEGIATAN & BADGE STATUS ELEGAN ---
                        if (data.column.index === 2) {
                            const statusConfigs = {
                                'approved': { bg: [220, 252, 231], text: [22, 101, 52], label: 'APPROVED / DISETUJUI' },
                                'submitted': { bg: [224, 242, 254], text: [7, 89, 133], label: 'SUBMITTED / DIAJUKAN' },
                                'draft': { bg: [254, 243, 199], text: [146, 64, 14], label: 'DRAFT' },
                                'rejected': { bg: [254, 226, 226], text: [153, 27, 27], label: 'REJECTED / DITOLAK' }
                            };
                            const stConf = statusConfigs[row.statusKey] || statusConfigs['draft'];
                            
                            const badgeW = 38;
                            const badgeH = 4.6;
                            const badgeX = cellX + 2.5;
                            const badgeY = cellY + cellH - badgeH - 2.5;

                            doc.setFillColor(stConf.bg[0], stConf.bg[1], stConf.bg[2]);
                            doc.roundedRect(badgeX, badgeY, badgeW, badgeH, 1, 1, 'F');
                            doc.setFontSize(6);
                            doc.setFont('helvetica', 'bold');
                            doc.setTextColor(stConf.text[0], stConf.text[1], stConf.text[2]);
                            doc.text(stConf.label, badgeX + (badgeW / 2), badgeY + 3.2, { align: 'center' });
                        }

                        // --- KOLOM 5: TANDA TANGAN PELAKSANA & NAMA TERANG JELAS ---
                        if (data.column.index === 5) {
                            // 1. Gambar TTD Pelaksana
                            if (row.signaturePelaksanaData) {
                                try {
                                    const fmt = row.signaturePelaksanaData.startsWith('data:image/png') ? 'PNG' : 'JPEG';
                                    doc.addImage(row.signaturePelaksanaData, fmt, centerX - 13, contentTop + 0.5, 26, 14);
                                } catch (e) {
                                    console.warn('Pelaksana sig error:', e);
                                }
                            } else {
                                // Placeholder jika belum TTD
                                doc.setFillColor(248, 250, 252);
                                doc.setDrawColor(226, 232, 240);
                                doc.setLineWidth(0.2);
                                doc.roundedRect(centerX - 14, contentTop + 4, 28, 8, 1, 1, 'FD');
                                doc.setFontSize(6.5);
                                doc.setFont('helvetica', 'italic');
                                doc.setTextColor(148, 163, 184);
                                doc.text('(Belum Ada TTD)', centerX, contentTop + 9.5, { align: 'center' });
                            }

                            // 2. Garis Batas Tanda Tangan
                            const lineY = contentTop + 17;
                            doc.setDrawColor(203, 213, 225);
                            doc.setLineWidth(0.25);
                            doc.line(cellX + 3.5, lineY, cellX + cellW - 3.5, lineY);

                            // 3. Nama Terang Penanda Tangan (Jelas, Tebal, Terbaca)
                            doc.setFontSize(7.5);
                            doc.setFont('helvetica', 'bold');
                            doc.setTextColor(15, 23, 42); // slate-900 kontras tinggi
                            const splitName = doc.splitTextToSize(row.namaPelaksana, cellW - 4);
                            doc.text(splitName, centerX, lineY + 3.6, { align: 'center' });

                            // 4. Label Jabatan / Peran
                            const roleY = lineY + 3.6 + (splitName.length * 3.1);
                            doc.setFontSize(6.5);
                            doc.setFont('helvetica', 'normal');
                            doc.setTextColor(100, 116, 139);
                            doc.text('Pelaksana Kegiatan', centerX, roleY, { align: 'center' });
                        }

                        // --- KOLOM 6: TANDA TANGAN PJ & NAMA TERANG JELAS ---
                        if (data.column.index === 6) {
                            // 1. Gambar TTD PJ
                            if (row.signaturePJData) {
                                try {
                                    const fmt = row.signaturePJData.startsWith('data:image/png') ? 'PNG' : 'JPEG';
                                    doc.addImage(row.signaturePJData, fmt, centerX - 13, contentTop + 0.5, 26, 14);
                                } catch (e) {
                                    console.warn('PJ sig error:', e);
                                }
                            } else {
                                // Placeholder jika belum TTD
                                doc.setFillColor(248, 250, 252);
                                doc.setDrawColor(226, 232, 240);
                                doc.setLineWidth(0.2);
                                doc.roundedRect(centerX - 14, contentTop + 4, 28, 8, 1, 1, 'FD');
                                doc.setFontSize(6.5);
                                doc.setFont('helvetica', 'italic');
                                doc.setTextColor(148, 163, 184);
                                doc.text('(Belum Ada TTD)', centerX, contentTop + 9.5, { align: 'center' });
                            }

                            // 2. Garis Batas Tanda Tangan
                            const lineY = contentTop + 17;
                            doc.setDrawColor(203, 213, 225);
                            doc.setLineWidth(0.25);
                            doc.line(cellX + 3.5, lineY, cellX + cellW - 3.5, lineY);

                            // 3. Nama Terang Penanggung Jawab (Jelas & Terbaca)
                            doc.setFontSize(7.5);
                            doc.setFont('helvetica', 'bold');
                            doc.setTextColor(15, 23, 42);
                            const splitPjName = doc.splitTextToSize(row.namaPJ, cellW - 4);
                            doc.text(splitPjName, centerX, lineY + 3.6, { align: 'center' });

                            // 4. Label Jabatan / Peran
                            const roleY = lineY + 3.6 + (splitPjName.length * 3.1);
                            doc.setFontSize(6.5);
                            doc.setFont('helvetica', 'normal');
                            doc.setTextColor(100, 116, 139);
                            doc.text('Penanggung Jawab', centerX, roleY, { align: 'center' });
                        }

                        // --- KOLOM 7: DOKUMENTASI KEGIATAN DENGAN BORDER & BADGE ---
                        if (data.column.index === 7) {
                            if (row.dokumentasiData && row.dokumentasiData.length > 0) {
                                try {
                                    const docImg = row.dokumentasiData[0];
                                    const fmt = docImg.startsWith('data:image/png') ? 'PNG' : 'JPEG';
                                    const docW = 24;
                                    const docH = 14;
                                    const docX = centerX - (docW / 2);
                                    const docY = contentTop + 0.5;

                                    doc.addImage(docImg, fmt, docX, docY, docW, docH);
                                    
                                    // Bingkai halus foto
                                    doc.setDrawColor(203, 213, 225);
                                    doc.setLineWidth(0.2);
                                    doc.rect(docX, docY, docW, docH);

                                    // Badge keterangan foto
                                    doc.setFontSize(6.5);
                                    doc.setFont('helvetica', 'bold');
                                    doc.setTextColor(13, 148, 136);
                                    const countText = row.dokumentasiData.length > 1 
                                        ? `${row.dokumentasiData.length} Foto (Ada Lampiran)` 
                                        : '1 Foto Dokumentasi';
                                    doc.text(countText, centerX, contentTop + 19, { align: 'center' });
                                } catch (e) {
                                    console.warn('Doc render error:', e);
                                }
                            } else {
                                doc.setFontSize(6.5);
                                doc.setFont('helvetica', 'italic');
                                doc.setTextColor(148, 163, 184);
                                doc.text('- Tidak Ada Foto -', centerX, cellY + (cellH / 2), { align: 'center' });
                            }
                        }
                    }
                });

                // 6. LAMPIRAN DOKUMENTASI FOTO KEGIATAN (GRID RESMI 2-KOLOM)
                const rowsWithMultiplePhotos = processedRows.filter(r => r.dokumentasiData && r.dokumentasiData.length > 1);
                if (rowsWithMultiplePhotos.length > 0) {
                    doc.addPage();
                    
                    // Header Lampiran
                    doc.setFontSize(13);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(15, 23, 42);
                    doc.text('LAMPIRAN DOKUMENTASI FOTO KEGIATAN', pageWidth / 2, 14, { align: 'center' });
                    
                    doc.setFontSize(8);
                    doc.setFont('helvetica', 'normal');
                    doc.setTextColor(100, 116, 139);
                    doc.text('Bukti fisik & visual pelaksanaan tugas harian pegawai', pageWidth / 2, 19, { align: 'center' });

                    doc.setDrawColor(15, 23, 42);
                    doc.setLineWidth(0.5);
                    doc.line(marginX, 22, pageWidth - marginX, 22);

                    let lampiranY = 27;
                    for (const rItem of rowsWithMultiplePhotos) {
                        if (lampiranY + 65 > pageHeight - 16) {
                            doc.addPage();
                            lampiranY = 18;
                        }

                        // Baris Judul Kegiatan
                        doc.setFillColor(241, 245, 249);
                        doc.roundedRect(marginX, lampiranY, contentWidth, 6.5, 1, 1, 'F');
                        doc.setFontSize(7.5);
                        doc.setFont('helvetica', 'bold');
                        doc.setTextColor(15, 23, 42);
                        doc.text(`Kegiatan: ${rItem.jenisKegiatan}  |  Tanggal: ${rItem.tanggalStr} (${rItem.unit})`, marginX + 3, lampiranY + 4.5);
                        lampiranY += 8.5;

                        // Grid 2 Foto per baris
                        const cardW = 130;
                        const cardH = 50;
                        rItem.dokumentasiData.forEach((dImg, dIdx) => {
                            if (dIdx >= 4) return; // Maksimal 4 foto per lampiran
                            
                            const isOdd = (dIdx % 2 === 1);
                            const photoX = isOdd ? (marginX + 135) : marginX;
                            
                            try {
                                const fmt = dImg.startsWith('data:image/png') ? 'PNG' : 'JPEG';
                                doc.addImage(dImg, fmt, photoX + 5, lampiranY, cardW - 10, cardH - 6);
                                
                                doc.setDrawColor(203, 213, 225);
                                doc.setLineWidth(0.2);
                                doc.rect(photoX + 5, lampiranY, cardW - 10, cardH - 6);

                                doc.setFontSize(6.5);
                                doc.setFont('helvetica', 'normal');
                                doc.setTextColor(100, 116, 139);
                                doc.text(`Foto Dokumentasi ${dIdx + 1} - ${rItem.jenisKegiatan}`, photoX + 5, lampiranY + cardH - 2);
                            } catch (e) {}

                            if (isOdd) {
                                lampiranY += cardH + 2;
                            }
                        });

                        if (rItem.dokumentasiData.length % 2 === 1) {
                            lampiranY += cardH + 2;
                        }
                    }
                }

                // 8. HEADER BERJALAN & FOOTER RESMI DI SEMUA HALAMAN
                const totalPages = doc.internal.getNumberOfPages();
                for (let i = 1; i <= totalPages; i++) {
                    doc.setPage(i);
                    
                    // Running Header (Halaman 2 ke atas)
                    if (i > 1) {
                        doc.setFontSize(7);
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(148, 163, 184);
                        doc.text(`${namaInstansi} | Laporan Kinerja Harian Pegawai`, marginX, 7);
                        doc.setDrawColor(226, 232, 240);
                        doc.setLineWidth(0.2);
                        doc.line(marginX, 8.5, pageWidth - marginX, 8.5);
                    }

                    // Running Footer di setiap halaman
                    doc.setDrawColor(226, 232, 240);
                    doc.setLineWidth(0.2);
                    doc.line(marginX, pageHeight - 9, pageWidth - marginX, pageHeight - 9);

                    doc.setFontSize(7);
                    doc.setFont('helvetica', 'normal');
                    doc.setTextColor(148, 163, 184);
                    doc.text(`Dokumen Resmi e-Kinerja Pegawai | Waktu Cetak: ${printDateStr} WIB`, marginX, pageHeight - 5.5);
                    doc.text(`Halaman ${i} dari ${totalPages}`, pageWidth - marginX, pageHeight - 5.5, { align: 'right' });
                }
                
                const fileName = `Laporan_Kinerja_${userNip || 'Pegawai'}_${new Date().toISOString().split('T')[0]}.pdf`;
                
                // Konversi ke Blob dan Tampilkan di Modal Pratinjau
                const pdfBlob = doc.output('blob');
                currentPdfBlob = pdfBlob;
                currentPdfFilename = fileName;

                if (currentPdfUrl) {
                    URL.revokeObjectURL(currentPdfUrl);
                }
                currentPdfUrl = URL.createObjectURL(pdfBlob);

                const frame = document.getElementById('pdfPreviewFrame');
                const filenameLabel = document.getElementById('pdfPreviewFilename');
                const skeleton = document.getElementById('pdfLoadingSkeleton');

                if (filenameLabel) filenameLabel.textContent = fileName;
                if (skeleton) skeleton.style.display = 'flex';

                if (frame) {
                    frame.onload = function() {
                        if (skeleton) skeleton.style.display = 'none';
                    };
                    frame.src = currentPdfUrl;
                }

                const previewModalEl = document.getElementById('pdfPreviewModal');
                if (previewModalEl && window.bootstrap) {
                    const previewModal = new bootstrap.Modal(previewModalEl);
                    previewModal.show();
                }
            } catch (err) {
                console.error('PDF generation error:', err);
                alert('Terjadi kesalahan saat memproses dokumen PDF. Silakan coba lagi.');
            } finally {
                if (exportBtn) {
                    exportBtn.disabled = false;
                    exportBtn.innerHTML = origContent;
                }
            }
        }

        // PDF Preview Helper Controls
        let currentPdfBlob = null;
        let currentPdfUrl = null;
        let currentPdfFilename = 'Laporan_Kinerja.pdf';

        function openPdfInNewTab() {
            if (currentPdfUrl) {
                window.open(currentPdfUrl, '_blank');
            }
        }

        function downloadCurrentPdf() {
            if (!currentPdfBlob && !currentPdfUrl) return;
            const a = document.createElement('a');
            a.href = currentPdfUrl;
            a.download = currentPdfFilename || 'Laporan_Kinerja.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function printPdfFromPreview() {
            const frame = document.getElementById('pdfPreviewFrame');
            if (frame && frame.contentWindow) {
                try {
                    frame.contentWindow.focus();
                    frame.contentWindow.print();
                    return;
                } catch (e) {
                    console.warn('Frame print failed, opening popup for print:', e);
                }
            }
            if (currentPdfUrl) {
                window.open(currentPdfUrl, '_blank');
            }
        }

        // Setup Event Listeners on Load
        document.addEventListener('DOMContentLoaded', function() {
            showLaporanKegiatan();

            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', applyFilters);
            }

            const jenisKegiatanFilter = document.getElementById('jenisKegiatanFilter');
            if (jenisKegiatanFilter) {
                jenisKegiatanFilter.addEventListener('change', applyFilters);
            }

            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', applyFilters);
            }

            const startDateInput = document.getElementById('startDate');
            if (startDateInput) {
                startDateInput.addEventListener('change', applyFilters);
            }

            const endDateInput = document.getElementById('endDate');
            if (endDateInput) {
                endDateInput.addEventListener('change', applyFilters);
            }

            const filterButton = document.getElementById('filterButton');
            if (filterButton) {
                filterButton.addEventListener('click', applyFilters);
            }

            const resetButton = document.getElementById('resetButton');
            if (resetButton) {
                resetButton.addEventListener('click', resetTable);
            }

            const exportPdfButton = document.getElementById('exportPdfButton');
            if (exportPdfButton) {
                exportPdfButton.addEventListener('click', exportToPDF);
            }

            const pdfModalEl = document.getElementById('pdfPreviewModal');
            if (pdfModalEl) {
                pdfModalEl.addEventListener('hidden.bs.modal', function () {
                    const frame = document.getElementById('pdfPreviewFrame');
                    if (frame) frame.src = 'about:blank';
                });
            }
        });
    </script>
    @include('partials.pwa-prompt')
</body>
</html>
