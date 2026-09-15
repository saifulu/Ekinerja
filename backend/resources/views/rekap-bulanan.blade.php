<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Kinerja & Matriks Tabulasi - e-Kinerja</title>
    @include('partials.pwa-head')
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white font-semibold text-xs sm:text-sm shadow-md shadow-teal-600/25 transition-all">
                        <i class="fas fa-print"></i>
                        <span>Cetak Matriks</span>
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

            <!-- Table Header Info Bar -->
            <div class="flex items-center justify-between gap-3 pb-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-200" id="matrixTitle">Tabel Tabulasi Harian</span>
                </div>
                <div class="text-[11px] text-slate-300 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/60 flex items-center gap-1.5">
                    <i class="fas fa-chart-pie text-teal-400"></i>
                    <span id="matrixCountIndicator"><strong>0</strong> Jenis Kegiatan</span>
                </div>
            </div>

            <!-- Crosstab Matrix Table Container -->
            <div class="table-responsive bg-slate-900/80 p-1" id="matrixTableWrapper">
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

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', initMatrix);
    </script>

    @include('partials.pwa-prompt')
</body>
</html>
