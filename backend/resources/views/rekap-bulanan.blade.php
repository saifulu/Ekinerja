<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Kinerja & Matriks Tabulasi - e-Kinerja</title>
    @include('partials.pwa-head')
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap 5 CSS for modal compatibility -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- jsPDF & AutoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: radial-gradient(circle at 10% 10%, rgba(20, 184, 166, 0.1) 0%, transparent 40%),
                        radial-gradient(circle at 90% 90%, rgba(6, 182, 212, 0.08) 0%, transparent 40%),
                        linear-gradient(145deg, #090e1a 0%, #0f172a 50%, #031e17 100%);
            min-height: 100vh;
            color: #f8fafc;
            background-attachment: fixed;
        }

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
            border: 1px solid rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.75) 0%, rgba(15, 23, 42, 0.85) 100%);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
        }

        .custom-select, .custom-input {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #f8fafc;
            border-radius: 12px;
            padding: 0.5rem 0.75rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .custom-select:focus, .custom-input:focus {
            border-color: #2dd4bf;
            box-shadow: 0 0 0 2px rgba(45, 212, 191, 0.2);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tab-preset-btn {
            padding: 0.375rem 0.75rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #cbd5e1;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .tab-preset-btn.active {
            background: rgba(20, 184, 166, 0.25);
            color: #2dd4bf;
            border: 1px solid rgba(45, 212, 191, 0.4);
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.2);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(45, 212, 191, 0.3);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(45, 212, 191, 0.5);
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
            .glass-card, .table-responsive {
                background: white !important;
                border: 1px solid #ccc !important;
                box-shadow: none !important;
                color: black !important;
            }
            table th, table td {
                color: black !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</head>
<body class="p-3 sm:p-5 md:p-6 lg:p-8">

    <div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

        <!-- Top Navigation Bar -->
        <div class="flex items-center justify-between gap-3 pb-1 no-print">
            <a href="/user-dashboard{{ isset($currentUser->nip) ? '?nip='.$currentUser->nip : '' }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700/60 text-slate-200 hover:text-teal-400 text-xs sm:text-sm font-medium transition-all shadow-md group">
                <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-1 text-teal-400"></i>
                <span class="hidden xs:inline">Kembali ke </span>Dashboard
            </a>

            <!-- User Info Pill -->
            <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-800/60 border border-slate-700/60 backdrop-blur-md">
                <div class="w-7 h-7 rounded-lg bg-teal-500/20 border border-teal-500/40 flex items-center justify-center text-teal-400 font-bold text-xs">
                    {{ strtoupper(substr($currentUser->name ?? 'User', 0, 2)) }}
                </div>
                <div class="text-left text-xs">
                    <div class="text-white font-semibold flex items-center gap-1 leading-tight">
                        <span class="max-w-[110px] sm:max-w-[180px] truncate">{{ $currentUser->name ?? 'Pegawai' }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                    </div>
                    <div class="text-slate-400 text-[11px] leading-tight">
                        NIP: {{ $currentUser->nip ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Header -->
        <div class="glass-card p-4 sm:p-6 md:p-7 relative overflow-hidden">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 relative z-10">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-teal-500/15 border border-teal-500/30 text-teal-300 text-[11px] font-semibold">
                        <i class="fas fa-table-list text-[10px]"></i>
                        <span>Rekapitulasi Matriks Tabulasi</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 via-cyan-200 to-emerald-400">
                            Matriks Tabulasi Kegiatan Kinerja
                        </span>
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm hidden md:block max-w-xl">
                        Frekuensi pelaksanaan aktivitas kerja harian, bulanan, maupun triwulan (3 bulan) lengkap dengan total akumulasi.
                    </p>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto no-print">
                    <button type="button"
                            onclick="window.print()"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-700/80 hover:bg-slate-600/80 border border-slate-600/60 text-slate-100 font-semibold text-xs sm:text-sm shadow-sm transition-all">
                        <i class="fas fa-print"></i>
                        <span>Cetak Matriks</span>
                    </button>
                    <button type="button"
                            id="exportMatrixPdfBtn"
                            onclick="exportMatrixToPDF()"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 text-white font-semibold text-xs sm:text-sm shadow-md shadow-rose-900/40 transition-all">
                        <i class="fas fa-file-pdf"></i>
                        <span>Pratinjau &amp; Cetak PDF</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Metric Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Total Pelaksanaan</div>
                    <div class="text-2xl font-extrabold text-teal-400 mt-1" id="statGrandTotal">0</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center text-lg">
                    <i class="fas fa-chart-simple"></i>
                </div>
            </div>
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Variasi Kegiatan</div>
                    <div class="text-2xl font-extrabold text-cyan-400 mt-1" id="statTotalKegiatan">0</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-lg">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Kolom / Periode</div>
                    <div class="text-2xl font-extrabold text-emerald-400 mt-1" id="statTotalColumns">0</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Status Pegawai</div>
                    <div class="text-xs font-bold text-slate-200 mt-1 truncate max-w-[110px]">{{ $currentUser->nip ?? '-' }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-700/40 text-slate-300 flex items-center justify-center text-lg">
                    <i class="fas fa-id-badge"></i>
                </div>
            </div>
        </div>

        <!-- Switcher to Laporan Kinerja -->
        <div class="flex items-center justify-between bg-slate-900/80 border border-slate-700/60 p-2.5 sm:p-3 rounded-2xl no-print">
            <div class="flex items-center gap-2 text-xs text-slate-300">
                <i class="fas fa-clipboard-list text-emerald-400"></i>
                <span>Ingin melihat rincian riwayat data kegiatan lengkap dan foto bukti?</span>
            </div>
            <a href="/laporan-kinerja{{ isset($currentUser->nip) ? '?nip='.$currentUser->nip : '' }}" class="px-3 py-1.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 border border-emerald-500/30 text-xs font-bold transition-all inline-flex items-center gap-1.5">
                <span>Buka Laporan Kinerja</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- MATRIX & FILTER CARD CONTAINER -->
        <div class="glass-card p-4 sm:p-5 md:p-6 space-y-4">
            
            <!-- Filter Header & Control Panel -->
            <div class="space-y-4 pb-4 border-b border-slate-700/60 no-print">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/20 border border-teal-500/30 text-teal-400 flex items-center justify-center text-sm">
                            <i class="fas fa-sliders"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-white">Filter & Pengaturan Periode Matriks</h3>
                            <p class="text-[11px] text-slate-400">Sesuaikan rentang waktu harian, bulanan, atau triwulan (3 bulan)</p>
                        </div>
                    </div>

                    <!-- Preset Period Tabs -->
                    <div class="flex items-center bg-slate-900/90 p-1 rounded-xl border border-slate-700/60 overflow-x-auto gap-1 self-start lg:self-auto">
                        <button type="button" onclick="setPeriodPreset('month')" id="btnPresetMonth" class="tab-preset-btn active">
                            <i class="fas fa-calendar-day mr-1"></i> Bulan Ini
                        </button>
                        <button type="button" onclick="setPeriodPreset('quarter')" id="btnPresetQuarter" class="tab-preset-btn">
                            <i class="fas fa-calendar-week mr-1"></i> 3 Bulan (Triwulan)
                        </button>
                        <button type="button" onclick="setPeriodPreset('custom')" id="btnPresetCustom" class="tab-preset-btn">
                            <i class="fas fa-calendar-days mr-1"></i> Kustom Periode
                        </button>
                    </div>
                </div>

                <!-- Comprehensive Filter Drawer Inputs -->
                <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700/60 space-y-3 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2.5">
                        
                        <!-- Filter 1: Jenis Kegiatan -->
                        <div>
                            <label class="text-[11px] text-slate-400 block mb-1 font-medium">Jenis Kegiatan</label>
                            <select id="filterKegiatan" onchange="renderMatrixTable()" class="custom-select w-full py-1.5 text-xs">
                                <option value="">Semua Jenis Kegiatan</option>
                            </select>
                        </div>

                        <!-- Filter 2: Mode Tampilan Kolom -->
                        <div>
                            <label class="text-[11px] text-slate-400 block mb-1 font-medium">Pengelompokan Kolom</label>
                            <select id="filterGrouping" onchange="renderMatrixTable()" class="custom-select w-full py-1.5 text-xs">
                                <option value="daily">Per Tanggal (Harian)</option>
                                <option value="monthly">Per Bulan (Akumulasi)</option>
                            </select>
                        </div>

                        <!-- Filter 3: Dari Tanggal -->
                        <div>
                            <label class="text-[11px] text-slate-400 block mb-1 font-medium">Dari Tanggal</label>
                            <input type="date" id="filterStartDate" onchange="onCustomDateChange()" class="custom-input w-full py-1.5 text-xs">
                        </div>

                        <!-- Filter 4: Sampai Tanggal -->
                        <div>
                            <label class="text-[11px] text-slate-400 block mb-1 font-medium">Sampai Tanggal</label>
                            <input type="date" id="filterEndDate" onchange="onCustomDateChange()" class="custom-input w-full py-1.5 text-xs">
                        </div>

                    </div>

                    <!-- Filter Actions & Active Status Summary -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-2 border-t border-slate-700/50">
                        <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                            <i class="fas fa-info-circle text-teal-400"></i>
                            <span id="activeFilterSummary">Periode: Memuat...</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="resetMatrixFilter()" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 text-xs font-medium transition-all">
                                <i class="fas fa-rotate-left mr-1"></i> Reset
                            </button>
                            <button type="button" onclick="renderMatrixTable()" class="px-3.5 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-500 text-white text-xs font-semibold transition-all shadow">
                                <i class="fas fa-check mr-1"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Table Header Info Bar (clean, no duplicates) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3 px-1">
                <!-- Left: Title + Indicator -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-400 animate-pulse flex-shrink-0"></span>
                        <span class="text-sm font-bold text-slate-100 tracking-tight" id="matrixTitle">Tabel Tabulasi Harian</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 bg-slate-800/90 border border-slate-700/60 px-2.5 py-1 rounded-lg">
                        <i class="fas fa-layer-group text-teal-400 text-[11px]"></i>
                        <span class="text-[11px] text-slate-300 font-medium" id="matrixCountIndicator"><strong class="text-teal-300">0</strong> Jenis Kegiatan</span>
                    </div>
                </div>

                <!-- Right: Action Buttons -->
                <div class="flex items-center gap-2 no-print">
                    <button type="button"
                            id="btnTableExportMatrixPdf"
                            onclick="exportMatrixToPDF()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-700/80 hover:bg-slate-600/80 border border-slate-600/60 text-slate-200 text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-file-pdf text-rose-400 text-[11px]"></i>
                        <span>Cetak PDF</span>
                    </button>
                    <button type="button"
                            id="btnPreviewMatrixPdf"
                            onclick="exportMatrixToPDF()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 text-white text-xs font-semibold shadow-md shadow-rose-900/40 transition-all duration-200 hover:shadow-rose-600/40">
                        <i class="fas fa-eye text-[11px]"></i>
                        <span>Pratinjau &amp; Cetak PDF</span>
                    </button>
                </div>
            </div>

            <!-- Crosstab Matrix Table Container -->
            <div class="table-responsive bg-slate-900/80 rounded-xl border border-slate-700/40 p-1" id="matrixTableWrapper">
                <!-- Dynamically generated via JavaScript -->
            </div>

        </div>

    </div>

    <!-- Application Script for Reactive Matrix Calculations -->
    <script>
        const rawActivities = @json($laporanData ?? []);
        let currentPreset = 'month'; // 'month', 'quarter', 'custom'

        function initMatrix() {
            // Populate Jenis Kegiatan Dropdown
            populateKegiatanDropdown();

            // Set default preset to current month
            setPeriodPreset('month', false);

            // Render table
            renderMatrixTable();
        }

        function populateKegiatanDropdown() {
            const select = document.getElementById('filterKegiatan');
            if (!select) return;

            const kegMap = {};
            rawActivities.forEach(item => {
                const name = item.jenis_kegiatan || 'Tanpa Kegiatan';
                kegMap[name] = (kegMap[name] || 0) + 1;
            });

            const keys = Object.keys(kegMap).sort();
            let options = '<option value="">Semua Jenis Kegiatan (' + rawActivities.length + ' Total)</option>';
            keys.forEach(k => {
                options += `<option value="${escapeHtml(k)}">${escapeHtml(k)} (${kegMap[k]})</option>`;
            });
            select.innerHTML = options;
        }

        function setPeriodPreset(preset, shouldRender = true) {
            currentPreset = preset;

            const btnMonth = document.getElementById('btnPresetMonth');
            const btnQuarter = document.getElementById('btnPresetQuarter');
            const btnCustom = document.getElementById('btnPresetCustom');
            const groupingSelect = document.getElementById('filterGrouping');

            [btnMonth, btnQuarter, btnCustom].forEach(btn => {
                if (btn) btn.classList.remove('active');
            });

            const now = new Date();
            const year = now.getFullYear();
            const month = now.getMonth(); // 0-11

            const startDateInput = document.getElementById('filterStartDate');
            const endDateInput = document.getElementById('filterEndDate');

            if (preset === 'month') {
                if (btnMonth) btnMonth.classList.add('active');
                // First to last day of current month
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                if (startDateInput) startDateInput.value = formatDateToISO(firstDay);
                if (endDateInput) endDateInput.value = formatDateToISO(lastDay);
                if (groupingSelect) groupingSelect.value = 'daily';
            } else if (preset === 'quarter') {
                if (btnQuarter) btnQuarter.classList.add('active');
                // Last 3 months (e.g. 2 months ago first day to today/end of this month)
                const firstDay = new Date(year, month - 2, 1);
                const lastDay = new Date(year, month + 1, 0);
                if (startDateInput) startDateInput.value = formatDateToISO(firstDay);
                if (endDateInput) endDateInput.value = formatDateToISO(lastDay);
                // In quarter view, default to daily or let user choose monthly
            } else if (preset === 'custom') {
                if (btnCustom) btnCustom.classList.add('active');
            }

            if (shouldRender) {
                renderMatrixTable();
            }
        }

        function onCustomDateChange() {
            const btnMonth = document.getElementById('btnPresetMonth');
            const btnQuarter = document.getElementById('btnPresetQuarter');
            const btnCustom = document.getElementById('btnPresetCustom');

            [btnMonth, btnQuarter].forEach(btn => {
                if (btn) btn.classList.remove('active');
            });
            if (btnCustom) btnCustom.classList.add('active');
            currentPreset = 'custom';
            renderMatrixTable();
        }

        function resetMatrixFilter() {
            const selectKegiatan = document.getElementById('filterKegiatan');
            if (selectKegiatan) selectKegiatan.value = '';
            setPeriodPreset('month', true);
        }

        function renderMatrixTable() {
            const startDateVal = document.getElementById('filterStartDate')?.value;
            const endDateVal = document.getElementById('filterEndDate')?.value;
            const selectedKegiatan = document.getElementById('filterKegiatan')?.value || '';
            const grouping = document.getElementById('filterGrouping')?.value || 'daily';

            const startDate = startDateVal ? new Date(startDateVal + 'T00:00:00') : null;
            const endDate = endDateVal ? new Date(endDateVal + 'T23:59:59.999') : null;

            // Update Summary Text
            const summaryEl = document.getElementById('activeFilterSummary');
            if (summaryEl) {
                const sStr = startDate ? formatDateDisplay(startDate) : '-';
                const eStr = endDate ? formatDateDisplay(endDate) : '-';
                const groupText = grouping === 'monthly' ? 'Mode Bulanan' : 'Mode Harian';
                summaryEl.textContent = `Periode: ${sStr} s/d ${eStr} (${groupText})`;
            }

            // Filter data
            const filteredItems = rawActivities.filter(item => {
                if (!item.tanggal_dibuat) return false;
                const d = new Date(item.tanggal_dibuat);
                if (isNaN(d.getTime())) return false;

                if (startDate && d < startDate) return false;
                if (endDate && d > endDate) return false;

                if (selectedKegiatan && (item.jenis_kegiatan || '').toLowerCase() !== selectedKegiatan.toLowerCase()) {
                    return false;
                }

                return true;
            });

            // Build Matrix
            const matrix = {}; // { 'Kegiatan A': { 'colKey': count } }
            const colMap = {};
            const colTotals = {};
            let grandTotal = 0;

            filteredItems.forEach(item => {
                const keg = item.jenis_kegiatan || 'Tanpa Kegiatan';
                const d = new Date(item.tanggal_dibuat);

                let colKey = '';
                let colLabel = '';

                if (grouping === 'monthly') {
                    // YYYY-MM
                    colKey = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                    colLabel = `${monthNames[d.getMonth()]} ${d.getFullYear()}`;
                } else {
                    // Daily: YYYY-MM-DD
                    colKey = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
                    colLabel = `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}`;
                }

                if (!colMap[colKey]) {
                    colMap[colKey] = colLabel;
                    colTotals[colKey] = 0;
                }

                if (!matrix[keg]) {
                    matrix[keg] = {};
                }

                matrix[keg][colKey] = (matrix[keg][colKey] || 0) + 1;
                colTotals[colKey] = (colTotals[colKey] || 0) + 1;
                grandTotal++;
            });

            const colKeys = Object.keys(colMap).sort();
            const kegList = Object.keys(matrix).sort();

            // Update Top Summary Stats
            const statGrand = document.getElementById('statGrandTotal');
            if (statGrand) statGrand.textContent = grandTotal;

            const statKeg = document.getElementById('statTotalKegiatan');
            if (statKeg) statKeg.textContent = kegList.length;

            const statCols = document.getElementById('statTotalColumns');
            if (statCols) statCols.textContent = colKeys.length;

            const countIndicator = document.getElementById('matrixCountIndicator');
            if (countIndicator) {
                countIndicator.innerHTML = `<strong>${kegList.length}</strong> Jenis Kegiatan`;
            }

            const titleEl = document.getElementById('matrixTitle');
            if (titleEl) {
                titleEl.textContent = grouping === 'monthly' ? 'Matriks Agregasi Bulanan' : 'Matriks Tabulasi Harian';
            }

            // Render Table HTML
            const wrapper = document.getElementById('matrixTableWrapper');
            if (!wrapper) return;

            if (kegList.length === 0 || colKeys.length === 0) {
                wrapper.innerHTML = `
                    <div class="text-center py-12 px-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-800 text-slate-500 flex items-center justify-center text-2xl mx-auto mb-3 border border-slate-700">
                            <i class="fas fa-calendar-xmark"></i>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1">Tidak Ada Data Pada Periode Ini</h4>
                        <p class="text-slate-400 text-xs max-w-sm mx-auto mb-3">Tidak ditemukan rekaman aktivitas kegiatan pada rentang filter yang Anda pilih.</p>
                        <button type="button" onclick="resetMatrixFilter()" class="px-3 py-1.5 rounded-xl bg-teal-600/30 text-teal-300 border border-teal-500/30 text-xs font-semibold hover:bg-teal-600/50 transition-all">
                            Tampilkan Bulan Ini
                        </button>
                    </div>
                `;
                return;
            }

            let tableHtml = `
                <table class="w-full min-w-max border-collapse" id="rekapBulananTable">
                    <thead>
                        <tr>
                            <th class="bg-slate-800 text-slate-300 p-3 text-xs font-bold text-left border-b border-slate-700 w-64 uppercase tracking-wider sticky left-0 z-10 bg-slate-800 shadow-md">
                                Jenis Kegiatan
                            </th>
            `;

            colKeys.forEach(ck => {
                tableHtml += `
                    <th class="bg-slate-800 text-slate-300 p-3 text-[11px] font-bold text-center border-b border-slate-700 border-l border-slate-700/50 min-w-[48px]">
                        ${colMap[ck]}
                    </th>
                `;
            });

            tableHtml += `
                            <th class="bg-teal-900/40 text-teal-300 p-3 text-xs font-bold text-center border-b border-slate-700 border-l border-teal-500/30 uppercase tracking-wider min-w-[64px]">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            kegList.forEach(keg => {
                let rowTotal = 0;
                tableHtml += `
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="p-3 text-xs text-slate-200 border-b border-slate-700/50 font-medium sticky left-0 z-10 bg-slate-900/95 border-r border-slate-700/40">
                            ${escapeHtml(keg)}
                        </td>
                `;

                colKeys.forEach(ck => {
                    const count = matrix[keg][ck] || 0;
                    rowTotal += count;
                    const cellClass = count > 0 ? 'text-emerald-400 font-bold bg-emerald-500/5' : 'text-slate-600';
                    const cellText = count > 0 ? count : '-';
                    tableHtml += `
                        <td class="p-2.5 text-xs text-center border-b border-slate-700/50 border-l border-slate-700/30 ${cellClass}">
                            ${cellText}
                        </td>
                    `;
                });

                tableHtml += `
                        <td class="p-2.5 text-xs text-center border-b border-slate-700/50 border-l border-teal-500/30 bg-teal-900/10 text-teal-300 font-bold">
                            ${rowTotal}
                        </td>
                    </tr>
                `;
            });

            // Table Footer for Total
            const footerLabel = grouping === 'monthly' ? 'Total Bulanan' : 'Total Harian';
            tableHtml += `
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-800/90">
                            <td class="p-3 text-xs text-right text-slate-200 font-bold border-t-2 border-teal-500/50 sticky left-0 z-10 bg-slate-800 shadow-md border-r border-slate-700/40">
                                ${footerLabel}
                            </td>
            `;

            colKeys.forEach(ck => {
                const cTotal = colTotals[ck] || 0;
                tableHtml += `
                    <td class="p-2.5 text-xs text-center text-emerald-400 font-bold border-t-2 border-teal-500/50 border-l border-slate-700/50 bg-emerald-500/10">
                        ${cTotal}
                    </td>
                `;
            });

            tableHtml += `
                            <td class="p-3 text-sm text-center text-white bg-teal-600/40 font-extrabold border-t-2 border-teal-500/50 border-l border-teal-500/30 shadow-[inset_0_0_10px_rgba(20,184,166,0.3)]">
                                ${grandTotal}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            `;

            wrapper.innerHTML = tableHtml;
        }

        // Helpers
        function formatDateToISO(d) {
            return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
        }

        function formatDateDisplay(d) {
            return `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()}`;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // ==========================================
        // PROFESSIONAL PDF EXPORT & PREVIEW ENGINE
        // ==========================================
        let currentPdfBlob = null;
        let currentPdfUrl = null;
        let currentPdfFilename = 'Rekap_Matriks_Kinerja.pdf';

        async function exportMatrixToPDF() {
            const btnHero = document.getElementById('exportMatrixPdfBtn');
            const btnTable = document.getElementById('btnTableExportMatrixPdf');
            const origHeroContent = btnHero ? btnHero.innerHTML : '';
            const origTableContent = btnTable ? btnTable.innerHTML : '';

            if (btnHero) {
                btnHero.disabled = true;
                btnHero.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Menyusun PDF...';
            }
            if (btnTable) {
                btnTable.disabled = true;
                btnTable.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Menyusun PDF...';
            }

            try {
                if (!window.jspdf || !window.jspdf.jsPDF) {
                    throw new Error('Pustaka jsPDF belum selesai dimuat. Silakan muat ulang halaman.');
                }

                // 1. Ambil data hasil kalkulasi matriks aktif
                const startDateVal = document.getElementById('filterStartDate')?.value;
                const endDateVal = document.getElementById('filterEndDate')?.value;
                const selectedKegiatan = document.getElementById('filterKegiatan')?.value || '';
                const grouping = document.getElementById('filterGrouping')?.value || 'daily';

                const startDate = startDateVal ? new Date(startDateVal + 'T00:00:00') : null;
                const endDate = endDateVal ? new Date(endDateVal + 'T23:59:59.999') : null;

                const filteredItems = rawActivities.filter(item => {
                    if (!item.tanggal_dibuat) return false;
                    const d = new Date(item.tanggal_dibuat);
                    if (isNaN(d.getTime())) return false;
                    if (startDate && d < startDate) return false;
                    if (endDate && d > endDate) return false;
                    if (selectedKegiatan && (item.jenis_kegiatan || '').toLowerCase() !== selectedKegiatan.toLowerCase()) {
                        return false;
                    }
                    return true;
                });

                const matrix = {};
                const colMap = {};
                const colTotals = {};
                let grandTotal = 0;

                filteredItems.forEach(item => {
                    const keg = item.jenis_kegiatan || 'Tanpa Kegiatan';
                    const d = new Date(item.tanggal_dibuat);
                    let colKey = '';
                    let colLabel = '';

                    if (grouping === 'monthly') {
                        colKey = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                        colLabel = `${monthNames[d.getMonth()]} ${d.getFullYear()}`;
                    } else {
                        colKey = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
                        colLabel = `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}`;
                    }

                    if (!colMap[colKey]) {
                        colMap[colKey] = colLabel;
                        colTotals[colKey] = 0;
                    }

                    if (!matrix[keg]) {
                        matrix[keg] = {};
                    }

                    matrix[keg][colKey] = (matrix[keg][colKey] || 0) + 1;
                    colTotals[colKey] = (colTotals[colKey] || 0) + 1;
                    grandTotal++;
                });

                const colKeys = Object.keys(colMap).sort();
                const kegList = Object.keys(matrix).sort();

                if (kegList.length === 0 || colKeys.length === 0) {
                    alert('Tidak ada data kegiatan pada rentang filter ini untuk dicetak.');
                    return;
                }

                // 2. Inisialisasi jsPDF Dokumen Landscape
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

                // 3. KOP SURAT / HEADER RESMI
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(13);
                doc.setTextColor(15, 23, 42); // slate-900
                doc.text(namaInstansi.toUpperCase(), pageWidth / 2, 12, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(13, 148, 136); // teal-600
                const docTitle = grouping === 'monthly' ? 'REKAPITULASI MATRIKS TABULASI BULANAN KEGIATAN KINERJA' : 'REKAPITULASI MATRIKS TABULASI HARIAN KEGIATAN KINERJA';
                doc.text(docTitle, pageWidth / 2, 17.5, { align: 'center' });

                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(100, 116, 139); // slate-500
                doc.text('Sistem Informasi Manajemen Akuntabilitas & Kinerja Pegawai Terpadu (e-Kinerja)', pageWidth / 2, 22, { align: 'center' });

                // Double Rule Line
                doc.setDrawColor(15, 23, 42);
                doc.setLineWidth(0.65);
                doc.line(marginX, 25, pageWidth - marginX, 25);

                doc.setDrawColor(148, 163, 184);
                doc.setLineWidth(0.25);
                doc.line(marginX, 26.2, pageWidth - marginX, 26.2);

                // 4. KOTAK INFORMASI METADATA PEGAWAI & PERIODE
                const metaBoxY = 28.5;
                const metaBoxH = 16.5;
                doc.setFillColor(248, 250, 252);
                doc.setDrawColor(226, 232, 240);
                doc.setLineWidth(0.3);
                doc.roundedRect(marginX, metaBoxY, contentWidth, metaBoxH, 1.5, 1.5, 'FD');

                const midX = marginX + 135;
                doc.setDrawColor(226, 232, 240);
                doc.setLineWidth(0.25);
                doc.line(midX, metaBoxY + 2, midX, metaBoxY + metaBoxH - 2);

                const sStr = startDate ? formatDateDisplay(startDate) : '-';
                const eStr = endDate ? formatDateDisplay(endDate) : '-';
                const groupText = grouping === 'monthly' ? 'Mode Akumulasi Bulanan' : 'Mode Harian (Per Tanggal)';
                const periodeText = `${sStr} s/d ${eStr}`;

                const printDateStr = new Date().toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Metadata Kiri
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

                // Metadata Kanan
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Periode & Format', midX + 6, metaBoxY + 5);
                doc.text(':', midX + 32, metaBoxY + 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(15, 23, 42);
                doc.text(`${periodeText} (${groupText})`, midX + 35, metaBoxY + 5);

                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Ringkasan Matriks', midX + 6, metaBoxY + 9.5);
                doc.text(':', midX + 32, metaBoxY + 9.5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(13, 148, 136);
                doc.text(`${kegList.length} Jenis Kegiatan | ${grandTotal} Total Frekuensi`, midX + 35, metaBoxY + 9.5);

                doc.setFont('helvetica', 'bold');
                doc.setTextColor(71, 85, 105);
                doc.text('Waktu Cetak', midX + 6, metaBoxY + 14);
                doc.text(':', midX + 32, metaBoxY + 14);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(15, 23, 42);
                doc.text(printDateStr + ' WIB', midX + 35, metaBoxY + 14);

                // 5. PENYIAPAN TABEL AUTOTABLE MATRIX
                const tableHeaders = ['NO', 'JENIS KEGIATAN'];
                colKeys.forEach(ck => {
                    tableHeaders.push(colMap[ck]);
                });
                tableHeaders.push('TOTAL');

                const tableBody = [];
                kegList.forEach((keg, idx) => {
                    let rowSum = 0;
                    const row = [idx + 1, keg];
                    colKeys.forEach(ck => {
                        const count = matrix[keg][ck] || 0;
                        rowSum += count;
                        row.push(count > 0 ? String(count) : '-');
                    });
                    row.push(String(rowSum));
                    tableBody.push(row);
                });

                // Footer Baris Total
                const footerLabel = grouping === 'monthly' ? 'TOTAL BULANAN' : 'TOTAL HARIAN';
                const footerRow = ['', footerLabel];
                colKeys.forEach(ck => {
                    footerRow.push(String(colTotals[ck] || 0));
                });
                footerRow.push(String(grandTotal));

                // Hitung lebar & font size responsif
                const numDateCols = colKeys.length;
                let fontSize = 7.5;
                let cellPadding = { top: 2.8, right: 2, bottom: 2.8, left: 2 };
                if (numDateCols > 22) {
                    fontSize = 5.8;
                    cellPadding = { top: 2, right: 0.8, bottom: 2, left: 0.8 };
                } else if (numDateCols > 14) {
                    fontSize = 6.6;
                    cellPadding = { top: 2.2, right: 1.2, bottom: 2.2, left: 1.2 };
                }

                // Definisi styling kolom
                const colStyles = {
                    0: { halign: 'center', cellWidth: 9, valign: 'middle' },
                    1: { halign: 'left', valign: 'middle', fontStyle: 'normal' }
                };

                // Kolom Total paling akhir
                const totalColIndex = tableHeaders.length - 1;
                colStyles[totalColIndex] = {
                    halign: 'center',
                    valign: 'middle',
                    fontStyle: 'bold',
                    fillColor: [240, 253, 250],
                    textColor: [13, 148, 136]
                };

                // Set auto date col alignment
                for (let c = 2; c < totalColIndex; c++) {
                    colStyles[c] = { halign: 'center', valign: 'middle' };
                }

                doc.autoTable({
                    head: [tableHeaders],
                    body: tableBody,
                    foot: [footerRow],
                    startY: 48,
                    theme: 'grid',
                    styles: {
                        fontSize: fontSize,
                        cellPadding: cellPadding,
                        overflow: 'linebreak',
                        valign: 'middle',
                        lineColor: [203, 213, 225],
                        lineWidth: 0.2
                    },
                    headStyles: {
                        fillColor: [15, 23, 42],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center',
                        fontSize: fontSize + 0.5,
                        valign: 'middle',
                        minCellHeight: 8
                    },
                    footStyles: {
                        fillColor: [241, 245, 249],
                        textColor: [15, 23, 42],
                        fontStyle: 'bold',
                        halign: 'center',
                        fontSize: fontSize + 0.5,
                        valign: 'middle',
                        minCellHeight: 8.5
                    },
                    alternateRowStyles: {
                        fillColor: [252, 253, 254]
                    },
                    columnStyles: colStyles,
                    margin: { left: marginX, right: marginX, top: 14, bottom: 14 },
                    didDrawCell: function(data) {
                        // Highlight angka non-zero pada body
                        if (data.section === 'body' && data.column.index >= 2 && data.column.index < totalColIndex) {
                            if (data.cell.raw !== '-') {
                                doc.setFont('helvetica', 'bold');
                                doc.setTextColor(5, 150, 105); // emerald-600
                            }
                        }
                        // Highlight Grand Total pada Footer
                        if (data.section === 'foot' && data.column.index === totalColIndex) {
                            doc.setFillColor(13, 148, 136); // teal-600
                            doc.rect(data.cell.x, data.cell.y, data.cell.width, data.cell.height, 'F');
                            doc.setFont('helvetica', 'bold');
                            doc.setFontSize(fontSize + 1.5);
                            doc.setTextColor(255, 255, 255);
                            doc.text(String(grandTotal), data.cell.x + (data.cell.width / 2), data.cell.y + (data.cell.height / 2) + 1.2, { align: 'center' });
                        }
                    }
                });

                // 6. BLOK TANDA TANGAN PENGESAHAN
                let finalY = doc.lastAutoTable ? doc.lastAutoTable.finalY + 8 : 120;
                if (finalY + 38 > pageHeight - 15) {
                    doc.addPage();
                    finalY = 18;
                }

                const todayFormatted = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                const sigBoxW = 85;
                const sigLeftX = marginX + 15;
                const sigRightX = pageWidth - marginX - sigBoxW - 15;

                // TTD Pegawai (Kiri)
                doc.setFontSize(8);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(71, 85, 105);
                doc.text('Pegawai yang Bersangkutan,', sigLeftX + (sigBoxW / 2), finalY, { align: 'center' });

                const ttdLineY = finalY + 22;
                doc.setDrawColor(203, 213, 225);
                doc.setLineWidth(0.25);
                doc.line(sigLeftX + 5, ttdLineY, sigLeftX + sigBoxW - 5, ttdLineY);

                doc.setFontSize(8.5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(15, 23, 42);
                doc.text(userName, sigLeftX + (sigBoxW / 2), ttdLineY + 4, { align: 'center' });

                doc.setFontSize(7.5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(100, 116, 139);
                doc.text(`NIP. ${userNip || '-'}`, sigLeftX + (sigBoxW / 2), ttdLineY + 7.5, { align: 'center' });

                // TTD Atasan Langsung (Kanan)
                doc.setFontSize(8);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(71, 85, 105);
                doc.text(`${todayFormatted}`, sigRightX + (sigBoxW / 2), finalY - 3.5, { align: 'center' });
                doc.text('Mengetahui / Menyetujui,', sigRightX + (sigBoxW / 2), finalY, { align: 'center' });
                doc.text('Atasan Langsung / Penilai Kinerja,', sigRightX + (sigBoxW / 2), finalY + 3.5, { align: 'center' });

                doc.line(sigRightX + 5, ttdLineY, sigRightX + sigBoxW - 5, ttdLineY);

                doc.setFontSize(8.5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(15, 23, 42);
                doc.text('( .................................................... )', sigRightX + (sigBoxW / 2), ttdLineY + 4, { align: 'center' });

                doc.setFontSize(7.5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(100, 116, 139);
                doc.text('NIP. ................................................', sigRightX + (sigBoxW / 2), ttdLineY + 7.5, { align: 'center' });

                // 7. RUNNING HEADER & RUNNING FOOTER
                const totalPages = doc.internal.getNumberOfPages();
                for (let i = 1; i <= totalPages; i++) {
                    doc.setPage(i);

                    if (i > 1) {
                        doc.setFontSize(7);
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(148, 163, 184);
                        doc.text(`${namaInstansi} | Rekapitulasi Matriks Tabulasi Kinerja Pegawai`, marginX, 7);
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

                // 8. TAMPILKAN DI MODAL PRATINJAU (TIDAK LANGSUNG DOWNLOAD / CETAK)
                const fileName = `Rekap_Matriks_Kinerja_${userNip || 'Pegawai'}_${new Date().toISOString().split('T')[0]}.pdf`;
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

                // Deteksi perangkat mobile/tablet (iOS & Android)
                // Browser mobile tidak mendukung render PDF di dalam iframe
                const isMobileOrTablet = /Android|iPad|iPhone|iPod|Mobile/i.test(navigator.userAgent) ||
                    (navigator.maxTouchPoints > 1 && /Macintosh/.test(navigator.userAgent)); // iPadOS

                if (isMobileOrTablet) {
                    // Di tablet/mobile: langsung buka di tab baru
                    window.open(currentPdfUrl, '_blank');
                } else {
                    // Di desktop: tampilkan modal pratinjau dengan iframe
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
                }

            } catch (err) {
                console.error('Matrix PDF generation error:', err);
                alert('Terjadi kesalahan saat memproses dokumen PDF: ' + err.message);
            } finally {
                if (btnHero) {
                    btnHero.disabled = false;
                    btnHero.innerHTML = origHeroContent;
                }
                if (btnTable) {
                    btnTable.disabled = false;
                    btnTable.innerHTML = origTableContent;
                }
            }
        }

        function openPdfInNewTab() {
            if (currentPdfUrl) {
                window.open(currentPdfUrl, '_blank');
            }
        }

        function downloadCurrentPdf() {
            if (!currentPdfBlob && !currentPdfUrl) return;
            const a = document.createElement('a');
            a.href = currentPdfUrl;
            a.download = currentPdfFilename || 'Rekap_Matriks_Kinerja.pdf';
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

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', initMatrix);
    </script>

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
                                Pratinjau Dokumen Matriks Tabulasi PDF
                            </h5>
                            <span class="text-[11px] text-slate-400 truncate block" id="pdfPreviewFilename">Rekap_Matriks_Kinerja.pdf</span>
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
                        <p class="text-xs font-medium text-slate-300">Menyusun dan merender pratinjau dokumen PDF...</p>
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

    @include('partials.pwa-prompt')
</body>
</html>
