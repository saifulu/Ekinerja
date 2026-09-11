<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f172a">
    <title>Laporan Kinerja Pegawai - e-Kinerja</title>
    
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
            border-radius: 18px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(16, 185, 129, 0.35);
        }

        .stat-card.active {
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.95) 0%, rgba(6, 78, 59, 0.45) 100%);
            border-color: rgba(16, 185, 129, 0.6);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
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
            border-radius: 16px;
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(16, 185, 129, 0.3) rgba(15, 23, 42, 0.5);
        }

        #dataTable {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        #dataTable th {
            background: rgba(30, 41, 59, 0.85);
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 13px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            white-space: nowrap;
        }

        #dataTable td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        #dataTable tr:hover td {
            background: rgba(30, 41, 59, 0.45);
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
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            padding: 3px 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .signature-box:hover {
            transform: scale(1.04);
            border-color: #10b981;
        }

        .doc-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 7px;
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

                <!-- Export PDF Button -->
                <button type="button" 
                        id="exportPdfButton" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 text-white font-semibold text-xs sm:text-sm shadow-md shadow-rose-600/25 transition-all">
                    <i class="fas fa-file-pdf"></i>
                    <span>Export PDF</span>
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
                        <span>Semua Laporan ({{ ($statusStats['draft'] ?? 0) + ($statusStats['submitted'] ?? 0) + ($statusStats['approved'] ?? 0) + ($statusStats['rejected'] ?? 0) }})</span>
                    </button>
                    <button type="button" 
                            id="mobileTabRekap" 
                            onclick="showRekapLaporan()" 
                            class="seg-tab-btn flex items-center justify-center gap-1.5">
                        <i class="fas fa-file-circle-check text-xs"></i>
                        <span>Disetujui ({{ $statusStats['approved'] ?? 0 }})</span>
                    </button>
                </div>
            </div>

            <!-- Desktop Metric Cards (Hidden on mobile) -->
            <div class="hidden md:grid grid-cols-3 gap-4">
                <!-- Card 1: Laporan Kegiatan -->
                <div class="stat-card active" id="laporanKegiatanCard" onclick="showLaporanKegiatan()">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs font-semibold text-emerald-400 tracking-wider uppercase">Tab Tampilan</span>
                            <h3 class="text-slate-300 font-bold text-base mt-1">Laporan Kegiatan</h3>
                            <div class="text-2xl font-extrabold text-white mt-1">
                                {{ ($statusStats['draft'] ?? 0) + ($statusStats['submitted'] ?? 0) + ($statusStats['approved'] ?? 0) + ($statusStats['rejected'] ?? 0) }}
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Total seluruh kegiatan tercatat</div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-lg">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-700/60 flex flex-wrap gap-1.5 text-[11px]">
                        <span class="px-2 py-0.5 rounded bg-emerald-500/15 text-emerald-300 border border-emerald-500/20">
                            {{ $statusStats['approved'] ?? 0 }} Approved
                        </span>
                        <span class="px-2 py-0.5 rounded bg-cyan-500/15 text-cyan-300 border border-cyan-500/20">
                            {{ $statusStats['submitted'] ?? 0 }} Submitted
                        </span>
                        <span class="px-2 py-0.5 rounded bg-amber-500/15 text-amber-300 border border-amber-500/20">
                            {{ $statusStats['draft'] ?? 0 }} Draft
                        </span>
                    </div>
                </div>

                <!-- Card 2: Rekap Laporan -->
                <div class="stat-card" id="rekapLaporanCard" onclick="showRekapLaporan()">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs font-semibold text-teal-400 tracking-wider uppercase">Tab Tampilan</span>
                            <h3 class="text-slate-300 font-bold text-base mt-1">Rekap Disetujui</h3>
                            <div class="text-2xl font-extrabold text-white mt-1">
                                {{ $statusStats['approved'] ?? 0 }}
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Kegiatan tervalidasi & disetujui</div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-teal-500/20 border border-teal-500/30 text-teal-400 flex items-center justify-center text-lg">
                            <i class="fas fa-file-circle-check"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-700/60 flex items-center justify-between text-xs text-slate-400">
                        <span>Persetujuan:</span>
                        <span class="font-bold text-emerald-400">
                            @php
                                $total = ($statusStats['draft'] ?? 0) + ($statusStats['submitted'] ?? 0) + ($statusStats['approved'] ?? 0) + ($statusStats['rejected'] ?? 0);
                                $percent = $total > 0 ? round((($statusStats['approved'] ?? 0) / $total) * 100, 1) : 0;
                            @endphp
                            {{ $percent }}%
                        </span>
                    </div>
                </div>

                <!-- Card 3: Ringkasan Unit -->
                <div class="stat-card" onclick="showLaporanKegiatan()">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs font-semibold text-cyan-400 tracking-wider uppercase">Distribusi</span>
                            <h3 class="text-slate-300 font-bold text-base mt-1">Unit & Lingkup</h3>
                            <div class="text-2xl font-extrabold text-white mt-1">
                                {{ isset($unitStats) ? $unitStats->count() : 0 }} <span class="text-xs font-medium text-slate-400">Unit</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                {{ isset($jenisKegiatanStats) ? $jenisKegiatanStats->count() : 0 }} variasi kegiatan
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/20 border border-cyan-500/30 text-cyan-400 flex items-center justify-center text-lg">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-700/60 flex items-center justify-between text-xs text-slate-400">
                        <span>Status PJ:</span>
                        <span class="font-semibold text-slate-200">Validasi Digital</span>
                    </div>
                </div>
            </div>

            <!-- Main Data Table & Card Feed Container -->
            <div class="glass-card p-4 sm:p-5 md:p-6 space-y-4">

                <!-- Table Header & Counter -->
                <div class="flex items-center justify-between gap-3 pb-3 border-b border-slate-700/60">
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
                    <div class="text-[11px] text-slate-300 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/60 flex items-center gap-1.5 shrink-0">
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
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
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
                                <input type="date" id="startDate" class="custom-input w-full py-1.5 text-xs">
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="text-[11px] text-slate-400 block mb-1 font-medium">Sampai Tanggal</label>
                                <input type="date" id="endDate" class="custom-input w-full py-1.5 text-xs">
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
                                        <th style="width: 45px;" class="text-center">No</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <th>Unit</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Hasil Temuan</th>
                                        <th class="text-center">Signature Pelaksana</th>
                                        <th class="text-center">Signature PJ</th>
                                        <th class="text-center">Dokumentasi</th>
                                        <th class="text-center" style="width: 85px;">Aksi</th>
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
                                            <td class="text-center font-semibold text-slate-400">{{ $index + 1 }}</td>

                                            <!-- Col 1: Jenis Kegiatan -->
                                            <td>
                                                <div class="font-semibold text-white mb-1.5">{{ $item->jenis_kegiatan ?? '-' }}</div>
                                                <span class="status-badge status-{{ $itemStatus }}">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>

                                            <!-- Col 2: NIP -->
                                            <td>
                                                <span class="font-mono text-xs px-2 py-1 rounded bg-slate-800 text-slate-300 border border-slate-700">
                                                    {{ $item->nip ?? '-' }}
                                                </span>
                                            </td>

                                            <!-- Col 3: Nama -->
                                            <td>
                                                <div class="font-medium text-slate-200">{{ $creatorName }}</div>
                                                <div class="text-xs text-slate-400">{{ $currentUser->instansi ?? 'RSUD' }}</div>
                                            </td>

                                            <!-- Col 4: Unit -->
                                            <td>
                                                <span class="px-2.5 py-1 rounded-lg bg-teal-500/10 text-teal-300 border border-teal-500/20 text-xs font-medium">
                                                    <i class="fas fa-door-open mr-1 text-[10px]"></i>{{ $item->unit ?? '-' }}
                                                </span>
                                            </td>

                                            <!-- Col 5: Tanggal Dibuat -->
                                            <td>
                                                <div class="text-xs text-slate-300 flex items-center gap-1.5">
                                                    <i class="far fa-calendar-alt text-emerald-400"></i>
                                                    {{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('d/m/Y') : '-' }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1.5">
                                                    <i class="far fa-clock"></i>
                                                    {{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('H:i') : '' }} WIB
                                                </div>
                                            </td>

                                            <!-- Col 6: Hasil Temuan -->
                                            <td>
                                                @if($item->hasil_temuan)
                                                    <div class="max-w-[180px] truncate text-slate-300 text-xs cursor-pointer hover:text-emerald-300 transition-colors" 
                                                         title="{{ $item->hasil_temuan }}"
                                                         onclick="viewDetail({{ $item->id }})">
                                                        {{ Str::limit($item->hasil_temuan, 45) }}
                                                    </div>
                                                @else
                                                    <span class="text-slate-500 text-xs italic">Tidak ada catatan</span>
                                                @endif
                                            </td>

                                            <!-- Col 7: Signature Pelaksana -->
                                            <td class="text-center">
                                                @if($sigPelaksana)
                                                    <div class="flex flex-col items-center gap-1">
                                                        <div class="signature-box" 
                                                             onclick="showImageModal('{{ $sigPelaksana }}', 'Tanda Tangan Pelaksana - {{ $item->nama_pelaksana ?? $creatorName }}')">
                                                            <img src="{{ $sigPelaksana }}" alt="Tanda Tangan Pelaksana" style="max-height: 42px; max-width: 80px;">
                                                        </div>
                                                        <span class="text-[11px] font-medium text-slate-300 flex items-center gap-1">
                                                            <i class="fas fa-user-check text-emerald-400 text-[10px]"></i>
                                                            {{ $item->nama_pelaksana ?? $creatorName }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-500 italic">Belum TTD</span>
                                                @endif
                                            </td>

                                            <!-- Col 8: Signature PJ -->
                                            <td class="text-center">
                                                @if($sigPJ)
                                                    <div class="flex flex-col items-center gap-1">
                                                        <div class="signature-box" 
                                                             onclick="showImageModal('{{ $sigPJ }}', 'Tanda Tangan Penanggung Jawab - {{ $item->nama_pj ?? 'Penanggung Jawab' }}')">
                                                            <img src="{{ $sigPJ }}" alt="Tanda Tangan PJ" style="max-height: 42px; max-width: 80px;">
                                                        </div>
                                                        <span class="text-[11px] font-medium text-slate-300 flex items-center gap-1">
                                                            <i class="fas fa-user-shield text-cyan-400 text-[10px]"></i>
                                                            {{ $item->nama_pj ?? 'PJ' }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-500 italic">Belum TTD</span>
                                                @endif
                                            </td>

                                            <!-- Col 9: Dokumentasi -->
                                            <td class="text-center">
                                                @if($item->dokumentasi && is_array($item->dokumentasi) && count($item->dokumentasi) > 0)
                                                    <div class="flex items-center justify-center gap-1.5 flex-wrap max-w-[120px] mx-auto">
                                                        @foreach(array_slice($item->dokumentasi, 0, 2) as $docIdx => $doc)
                                                            <img src="{{ asset('storage/' . $doc) }}" 
                                                                 alt="Dokumentasi {{ $docIdx + 1 }}" 
                                                                 class="doc-thumb"
                                                                 onclick="showImageModal('{{ asset('storage/' . $doc) }}', 'Dokumentasi {{ $docIdx + 1 }} - {{ $item->jenis_kegiatan }}')"
                                                                 title="Klik untuk memperbesar">
                                                        @endforeach
                                                        @if(count($item->dokumentasi) > 2)
                                                            <button type="button" 
                                                                    onclick="viewDetail({{ $item->id }})" 
                                                                    class="w-10 h-10 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 hover:text-emerald-400 text-xs font-bold transition-colors"
                                                                    title="Lihat semua foto">
                                                                +{{ count($item->dokumentasi) - 2 }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="text-[10px] text-slate-400 mt-1">{{ count($item->dokumentasi) }} file(s)</div>
                                                @else
                                                    <span class="text-xs text-slate-500 italic">Tidak ada foto</span>
                                                @endif
                                            </td>

                                            <!-- Col 10: Aksi -->
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-1.5">
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
                                            <td colspan="11" class="text-center py-12">
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

                <!-- View 2: Rekap Laporan View (Summary Breakdown) -->
                <div id="rekapLaporanTable" style="display: none;" class="space-y-4">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Breakdown per Status -->
                        <div class="glass-panel p-4 rounded-2xl space-y-3">
                            <h4 class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fas fa-chart-pie"></i>
                                <span>Distribusi Status Laporan</span>
                            </h4>
                            <div class="space-y-2.5">
                                @php
                                    $tot = ($statusStats['draft'] ?? 0) + ($statusStats['submitted'] ?? 0) + ($statusStats['approved'] ?? 0) + ($statusStats['rejected'] ?? 0);
                                @endphp
                                <!-- Approved -->
                                <div>
                                    <div class="flex justify-between text-xs mb-1 font-medium">
                                        <span class="text-emerald-400">Approved</span>
                                        <span class="text-slate-300">{{ $statusStats['approved'] ?? 0 }} ({{ $tot > 0 ? round(($statusStats['approved'] ?? 0)/$tot*100) : 0 }}%)</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $tot > 0 ? (($statusStats['approved'] ?? 0)/$tot*100) : 0 }}%"></div>
                                    </div>
                                </div>
                                <!-- Submitted -->
                                <div>
                                    <div class="flex justify-between text-xs mb-1 font-medium">
                                        <span class="text-cyan-400">Submitted</span>
                                        <span class="text-slate-300">{{ $statusStats['submitted'] ?? 0 }} ({{ $tot > 0 ? round(($statusStats['submitted'] ?? 0)/$tot*100) : 0 }}%)</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-cyan-500 rounded-full" style="width: {{ $tot > 0 ? (($statusStats['submitted'] ?? 0)/$tot*100) : 0 }}%"></div>
                                    </div>
                                </div>
                                <!-- Draft -->
                                <div>
                                    <div class="flex justify-between text-xs mb-1 font-medium">
                                        <span class="text-amber-400">Draft</span>
                                        <span class="text-slate-300">{{ $statusStats['draft'] ?? 0 }} ({{ $tot > 0 ? round(($statusStats['draft'] ?? 0)/$tot*100) : 0 }}%)</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $tot > 0 ? (($statusStats['draft'] ?? 0)/$tot*100) : 0 }}%"></div>
                                    </div>
                                </div>
                                <!-- Rejected -->
                                <div>
                                    <div class="flex justify-between text-xs mb-1 font-medium">
                                        <span class="text-rose-400">Rejected</span>
                                        <span class="text-slate-300">{{ $statusStats['rejected'] ?? 0 }} ({{ $tot > 0 ? round(($statusStats['rejected'] ?? 0)/$tot*100) : 0 }}%)</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-rose-500 rounded-full" style="width: {{ $tot > 0 ? (($statusStats['rejected'] ?? 0)/$tot*100) : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rekap per Unit Kerja -->
                        <div class="glass-panel p-4 rounded-2xl space-y-3">
                            <h4 class="text-xs font-bold text-teal-400 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fas fa-hospital-user"></i>
                                <span>Rekap per Ruangan / Unit</span>
                            </h4>
                            <div class="space-y-2 max-h-[190px] overflow-y-auto pr-1 text-xs">
                                @if(isset($unitStats) && $unitStats->count() > 0)
                                    @foreach($unitStats as $unitName => $unitCount)
                                        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/60 border border-slate-700/50">
                                            <div class="flex items-center gap-2 text-slate-200">
                                                <i class="fas fa-door-closed text-emerald-400 text-xs"></i>
                                                <span class="font-medium truncate max-w-[170px]">{{ $unitName ?: 'Tidak Ada Unit' }}</span>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 text-[11px] font-bold">
                                                {{ $unitCount }}
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-xs text-slate-500 italic py-3 text-center">Belum ada data unit</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rekap Laporan Approved List -->
                    <div class="glass-panel p-4 rounded-2xl space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-white flex items-center gap-1.5">
                                <i class="fas fa-stamp text-emerald-400"></i>
                                <span>Laporan yang Disetujui (Approved)</span>
                            </h4>
                            <span class="text-[11px] text-slate-400">Tervalidasi</span>
                        </div>

                        @php
                            $approvedItems = $laporanData ? $laporanData->where('status', 'approved') : collect();
                        @endphp

                        @if($approvedItems->count() > 0)
                            <div class="space-y-2">
                                @foreach($approvedItems as $appItem)
                                    <div class="p-3 rounded-xl bg-slate-800/50 border border-slate-700/40 flex items-center justify-between gap-2 text-xs">
                                        <div class="space-y-0.5 min-w-0 flex-1">
                                            <div class="font-semibold text-white truncate">{{ $appItem->jenis_kegiatan }}</div>
                                            <div class="text-slate-400 text-[11px] flex items-center gap-2">
                                                <span><i class="far fa-calendar-alt mr-1 text-emerald-400"></i>{{ $appItem->tanggal_dibuat ? \Carbon\Carbon::parse($appItem->tanggal_dibuat)->format('d/m/Y') : '-' }}</span>
                                                <span>•</span>
                                                <span class="text-teal-300">{{ $appItem->unit ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                class="btn-action btn-action-view shrink-0" 
                                                onclick="viewDetail({{ $appItem->id }})" 
                                                title="Lihat Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-slate-500 text-xs italic">
                                Belum ada laporan dengan status Approved.
                            </div>
                        @endif
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
                <div class="modal-footer border-t border-slate-700/80 px-5 py-3 flex justify-end">
                    <button type="button" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors" data-bs-dismiss="modal">
                        Tutup
                    </button>
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
            const statusFilter = document.getElementById('statusFilter');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            const query = (searchInput ? searchInput.value.trim().toLowerCase() : '');
            const selectedStatus = (statusFilter ? statusFilter.value.trim().toLowerCase() : '');
            const startDate = (startDateInput && startDateInput.value) ? new Date(startDateInput.value + 'T00:00:00') : null;
            const endDate = (endDateInput && endDateInput.value) ? new Date(endDateInput.value + 'T23:59:59.999') : null;

            // Active filter badge indicator
            const activeBadge = document.getElementById('activeFilterBadge');
            if (activeBadge) {
                if (selectedStatus || startDate || endDate) {
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
                
                let rowMatchesDate = true;
                const dateCell = row.cells[5];
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
                const matchesStatus = (!selectedStatus || rowStatus === selectedStatus);

                if (matchesSearch && matchesStatus && rowMatchesDate) {
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
            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');

            if (startDate) startDate.value = '';
            if (endDate) endDate.value = '';
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';

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
                    <td colspan="11" class="text-center py-10">
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

        // View Detail Drill-Down Modal
        function viewDetail(id) {
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
                    const docUrl = `/storage/${doc}`;
                    const thumbWrap = document.createElement('div');
                    thumbWrap.className = 'relative group cursor-pointer overflow-hidden rounded-xl border border-slate-700';
                    thumbWrap.innerHTML = `
                        <img src="${docUrl}" class="w-full h-20 object-cover transition-transform group-hover:scale-105" alt="Dokumentasi ${idx + 1}">
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

        // Edit / Continue Item
        function editItem(id) {
            const item = rawItemsData[id];
            if (!item) return;

            const payload = encodeURIComponent(JSON.stringify({
                id: item.id,
                jenis_kegiatan: item.jenis_kegiatan,
                nip: item.nip,
                golongan: '{{ $currentUser->golongan ?? "III/a" }}'
            }));

            window.location.href = `/jenis-kegiatan/detail?data=${payload}`;
        }

        // Image Base64 Converter for PDF Export
        function getImageAsBase64(imgElement) {
            return new Promise((resolve) => {
                if (!imgElement || !imgElement.src) {
                    resolve('');
                    return;
                }
                
                try {
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    
                    img.onload = function() {
                        try {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = this.naturalWidth || this.width;
                            canvas.height = this.naturalHeight || this.height;
                            
                            ctx.fillStyle = '#FFFFFF';
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                            ctx.drawImage(this, 0, 0);
                            
                            const dataURL = canvas.toDataURL('image/jpeg', 0.88);
                            resolve(dataURL);
                        } catch (e) {
                            console.error('Canvas export error:', e);
                            resolve('');
                        }
                    };
                    
                    img.onerror = function() {
                        console.error('Image load error:', imgElement.src);
                        resolve('');
                    };
                    
                    if (imgElement.complete && imgElement.naturalWidth > 0) {
                        img.onload.call(imgElement);
                    } else {
                        img.src = imgElement.src;
                    }
                } catch (e) {
                    console.error('Image process error:', e);
                    resolve('');
                }
            });
        }

        // Professional PDF Export Engine
        async function exportToPDF() {
            const exportBtn = document.getElementById('exportPdfButton');
            const origContent = exportBtn ? exportBtn.innerHTML : '';
            if (exportBtn) {
                exportBtn.disabled = true;
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Menyiapkan Dokumen...';
            }

            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });
                
                const namaInstansi = '{{ $currentUser->instansi ?? "RUMAH SAKIT UMUM DAERAH" }}';
                const userName = '{{ $currentUser->name ?? "Pegawai" }}';
                const userNip = '{{ $currentUser->nip ?? "" }}';
                
                // Header / Kop Surat
                doc.setFontSize(15);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(15, 23, 42);
                doc.text(namaInstansi.toUpperCase(), doc.internal.pageSize.getWidth() / 2, 18, { align: 'center' });
                
                doc.setFontSize(12);
                doc.setTextColor(16, 185, 129);
                doc.text('LAPORAN DATA CAPAIAN KINERJA HARIAN PEGAWAI', doc.internal.pageSize.getWidth() / 2, 26, { align: 'center' });
                
                // Info Metatag
                doc.setFontSize(9);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(71, 85, 105);
                doc.text(`Nama Pegawai: ${userName}  |  NIP: ${userNip}`, 15, 36);
                
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                let periodeText = 'Semua Periode';
                if (startDateInput && startDateInput.value && endDateInput && endDateInput.value) {
                    periodeText = `${startDateInput.value} s/d ${endDateInput.value}`;
                } else if (startDateInput && startDateInput.value) {
                    periodeText = `Mulai: ${startDateInput.value}`;
                } else if (endDateInput && endDateInput.value) {
                    periodeText = `Sampai: ${endDateInput.value}`;
                }
                
                doc.text(`Periode Laporan: ${periodeText}`, 15, 41);
                doc.text(`Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })} WIB`, 15, 46);
                
                // Garis Pembatas
                doc.setDrawColor(16, 185, 129);
                doc.setLineWidth(0.6);
                doc.line(15, 50, doc.internal.pageSize.getWidth() - 15, 50);
                
                // Ambil data baris yang sedang terlihat
                const rows = document.querySelectorAll('#tableBody tr');
                let no = 1;
                const processedRows = [];
                
                for (const row of rows) {
                    if (row.style.display === 'none' || row.cells.length === 1 || !row.getAttribute('data-id')) {
                        continue;
                    }
                    
                    const cells = row.cells;
                    if (cells.length >= 10) {
                        const signaturePelaksanaImg = cells[7].querySelector('img');
                        const signaturePJImg = cells[8].querySelector('img');
                        const dokumentasiImgs = cells[9].querySelectorAll('img');
                        
                        const sigPelaksanaData = signaturePelaksanaImg ? await getImageAsBase64(signaturePelaksanaImg) : '';
                        const sigPJData = signaturePJImg ? await getImageAsBase64(signaturePJImg) : '';
                        
                        const docImagesData = [];
                        for (const img of dokumentasiImgs) {
                            const dData = await getImageAsBase64(img);
                            if (dData) docImagesData.push(dData);
                        }
                        
                        const jenisKegiatanText = cells[1].querySelector('.font-semibold') ? cells[1].querySelector('.font-semibold').textContent.trim() : cells[1].textContent.trim();
                        const statusText = cells[1].querySelector('.status-badge') ? cells[1].querySelector('.status-badge').textContent.trim() : '';

                        processedRows.push({
                            no: no++,
                            tanggalDibuat: cells[5].textContent.replace(/\s+/g, ' ').trim(),
                            jenisKegiatan: `${jenisKegiatanText} [${statusText}]`,
                            unit: cells[4].textContent.replace(/\s+/g, ' ').trim(),
                            hasilTemuan: cells[6].textContent.replace(/\s+/g, ' ').trim(),
                            signaturePelaksanaData: sigPelaksanaData,
                            signaturePJData: sigPJData,
                            dokumentasiData: docImagesData,
                            namaPelaksana: cells[7].querySelector('span') ? cells[7].querySelector('span').textContent.trim() : '',
                            namaPJ: cells[8].querySelector('span') ? cells[8].querySelector('span').textContent.trim() : ''
                        });
                    }
                }
                
                const autoTableData = processedRows.map(row => [
                    row.no,
                    row.tanggalDibuat,
                    row.jenisKegiatan,
                    row.unit,
                    row.hasilTemuan,
                    row.namaPelaksana ? `${row.namaPelaksana}\n(TTD)` : (row.signaturePelaksanaData ? 'Ada TTD' : 'Belum TTD'),
                    row.namaPJ ? `${row.namaPJ}\n(TTD)` : (row.signaturePJData ? 'Ada TTD' : 'Belum TTD'),
                    row.dokumentasiData.length > 0 ? `${row.dokumentasiData.length} Foto` : 'Tidak ada'
                ]);
                
                doc.autoTable({
                    head: [[
                        'No',
                        'Waktu Catat',
                        'Jenis Kegiatan & Status',
                        'Unit',
                        'Hasil Temuan & Uraian',
                        'Pelaksana (TTD)',
                        'PJ (TTD)',
                        'Dokumentasi'
                    ]],
                    body: autoTableData,
                    startY: 55,
                    styles: {
                        fontSize: 8,
                        cellPadding: 3,
                        overflow: 'linebreak',
                        halign: 'left',
                        minCellHeight: 22,
                        lineColor: [226, 232, 240],
                        lineWidth: 0.2
                    },
                    headStyles: {
                        fillColor: [15, 23, 42],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center',
                        fontSize: 8.5,
                        minCellHeight: 10
                    },
                    columnStyles: {
                        0: { halign: 'center', cellWidth: 12 },
                        1: { cellWidth: 28 },
                        2: { cellWidth: 44 },
                        3: { cellWidth: 26 },
                        4: { cellWidth: 62 },
                        5: { halign: 'center', cellWidth: 32 },
                        6: { halign: 'center', cellWidth: 32 },
                        7: { halign: 'center', cellWidth: 31 }
                    },
                    margin: { left: 15, right: 15 },
                    tableWidth: 'wrap',
                    theme: 'grid',
                    didDrawCell: function(data) {
                        if (data.section === 'body' && (data.column.index === 5 || data.column.index === 6 || data.column.index === 7)) {
                            const rowIndex = data.row.index;
                            if (rowIndex < processedRows.length) {
                                const row = processedRows[rowIndex];
                                let imgData = '';
                                
                                if (data.column.index === 5 && row.signaturePelaksanaData) {
                                    imgData = row.signaturePelaksanaData;
                                } else if (data.column.index === 6 && row.signaturePJData) {
                                    imgData = row.signaturePJData;
                                } else if (data.column.index === 7 && row.dokumentasiData.length > 0) {
                                    imgData = row.dokumentasiData[0];
                                }
                                
                                if (imgData) {
                                    try {
                                        const cellX = data.cell.x + 2;
                                        const cellY = data.cell.y + 2;
                                        const cellWidth = data.cell.width - 4;
                                        const cellHeight = data.cell.height - 4;
                                        const size = Math.min(cellWidth, cellHeight);
                                        const xPos = cellX + (cellWidth - size) / 2;
                                        const yPos = cellY + (cellHeight - size) / 2;
                                        
                                        doc.addImage(imgData, 'JPEG', xPos, yPos, size, size);
                                    } catch (e) {
                                        console.error('Error drawing image into table cell:', e);
                                    }
                                }
                            }
                        }
                    }
                });
                
                // Extra pages for documentation photos
                let hasExtraDocs = false;
                processedRows.forEach((row, idx) => {
                    if (row.dokumentasiData.length > 1) {
                        if (!hasExtraDocs) {
                            doc.addPage();
                            doc.setFontSize(13);
                            doc.setFont('helvetica', 'bold');
                            doc.setTextColor(15, 23, 42);
                            doc.text('LAMPIRAN DOKUMENTASI KEGIATAN', doc.internal.pageSize.getWidth() / 2, 18, { align: 'center' });
                            hasExtraDocs = true;
                        }
                        
                        let yPos = 30;
                        doc.setFontSize(9);
                        doc.setFont('helvetica', 'bold');
                        doc.setTextColor(16, 185, 129);
                        doc.text(`${idx + 1}. ${row.jenisKegiatan} - ${row.tanggalDibuat} (${row.unit})`, 15, yPos);
                        yPos += 8;
                        
                        row.dokumentasiData.forEach((img, imgIdx) => {
                            if (yPos > 160) {
                                doc.addPage();
                                yPos = 20;
                            }
                            try {
                                doc.addImage(img, 'JPEG', 15, yPos, 70, 50);
                                doc.setFontSize(8);
                                doc.setTextColor(100, 116, 139);
                                doc.text(`Foto Dokumentasi ${imgIdx + 1}`, 15, yPos + 54);
                                yPos += 62;
                            } catch (e) {
                                console.error('Error embedding doc photo:', e);
                            }
                        });
                    }
                });
                
                // Page numbering footer
                const totalPages = doc.internal.getNumberOfPages();
                for (let i = 1; i <= totalPages; i++) {
                    doc.setPage(i);
                    doc.setFontSize(8);
                    doc.setTextColor(148, 163, 184);
                    doc.text(
                        `Dokumen Resmi e-Kinerja Pegawai | Halaman ${i} dari ${totalPages}`,
                        doc.internal.pageSize.getWidth() - 15,
                        doc.internal.pageSize.getHeight() - 8,
                        { align: 'right' }
                    );
                }
                
                const fileName = `Laporan_Kinerja_${userNip || 'Pegawai'}_${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);
            } catch (err) {
                console.error('PDF generation error:', err);
                alert('Terjadi kesalahan saat memproses PDF. Silakan coba lagi.');
            } finally {
                if (exportBtn) {
                    exportBtn.disabled = false;
                    exportBtn.innerHTML = origContent;
                }
            }
        }

        // Setup Event Listeners on Load
        document.addEventListener('DOMContentLoaded', function() {
            showLaporanKegiatan();

            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', applyFilters);
            }

            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', applyFilters);
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
        });
    </script>
</body>
</html>
