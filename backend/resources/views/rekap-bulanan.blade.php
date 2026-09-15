<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan Kinerja - e-Kinerja</title>
    @include('partials.pwa-head')
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- jsPDF & Chart.js -->
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

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
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
    </style>
</head>
<body class="p-3 sm:p-5 md:p-6 lg:p-8">

    <div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

        <!-- Top Navigation Bar -->
        <div class="flex items-center justify-between gap-3 pb-1">
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
                        <span>Rekapitulasi Matriks</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 via-cyan-200 to-emerald-400">
                            Rekapitulasi Kegiatan Bulanan
                        </span>
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm hidden md:block max-w-xl">
                        Tabulasi silang frekuensi pelaksanaan kegiatan harian dalam satu bulan kalender dengan total harian dan grand total akumulasi.
                    </p>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="button" 
                            onclick="window.print()" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white font-semibold text-xs sm:text-sm shadow-md shadow-teal-600/25 transition-all">
                        <i class="fas fa-print"></i>
                        <span>Cetak Rekap</span>
                    </button>
                </div>
            </div>
        </div>

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

        <!-- Metric Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Total Pelaksanaan</div>
                    <div class="text-2xl font-extrabold text-teal-400 mt-1">{{ $grandTotal }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center text-lg">
                    <i class="fas fa-chart-simple"></i>
                </div>
            </div>
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Variasi Kegiatan</div>
                    <div class="text-2xl font-extrabold text-cyan-400 mt-1">{{ count($rekapData) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-lg">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <div class="stat-card p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Hari Terisi</div>
                    <div class="text-2xl font-extrabold text-emerald-400 mt-1">{{ count($allDatesList) }}</div>
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
        <div class="flex items-center justify-between bg-slate-900/80 border border-slate-700/60 p-2.5 sm:p-3 rounded-2xl">
            <div class="flex items-center gap-2 text-xs text-slate-300">
                <i class="fas fa-clipboard-list text-emerald-400"></i>
                <span>Ingin melihat rincian riwayat data kegiatan lengkap dan foto bukti?</span>
            </div>
            <a href="/laporan-kinerja{{ isset($currentUser->nip) ? '?nip='.$currentUser->nip : '' }}" class="px-3 py-1.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 border border-emerald-500/30 text-xs font-bold transition-all inline-flex items-center gap-1.5">
                <span>Buka Laporan Kinerja</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- Matrix Crosstab Card Container -->
        <div class="glass-card p-4 sm:p-5 md:p-6 space-y-4">
            
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-slate-700/60">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 border border-teal-500/30 text-teal-400 flex items-center justify-center text-sm">
                        <i class="fas fa-table"></i>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-white">Matriks Tabulasi Kegiatan Harian</h3>
                        <p class="text-[11px] text-slate-400">Rincian frekuensi pelaksanaan tugas per tanggal kalender</p>
                    </div>
                </div>

                <div class="text-[11px] text-slate-300 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/60 flex items-center gap-1.5">
                    <i class="fas fa-chart-pie text-teal-400"></i>
                    <span><strong>{{ count($rekapData) }}</strong> Jenis Kegiatan</span>
                </div>
            </div>

            <!-- Crosstab Matrix Table -->
            <div class="table-responsive bg-slate-900/80 p-1">
                <table class="w-full min-w-max border-collapse" id="rekapBulananTable">
                    <thead>
                        <tr>
                            <th class="bg-slate-800 text-slate-300 p-3 text-xs font-bold text-left border-b border-slate-700 w-64 uppercase tracking-wider sticky left-0 z-10 bg-slate-800 shadow-md">
                                Jenis Kegiatan
                            </th>
                            @foreach($allDatesList as $date)
                                <th class="bg-slate-800 text-slate-300 p-3 text-[11px] font-bold text-center border-b border-slate-700 border-l border-slate-700/50 min-w-[42px]">
                                    {{ \Carbon\Carbon::parse($date)->format('d/m') }}
                                </th>
                            @endforeach
                            <th class="bg-teal-900/40 text-teal-300 p-3 text-xs font-bold text-center border-b border-slate-700 border-l border-teal-500/30 uppercase tracking-wider min-w-[60px]">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapData as $kegiatan => $counts)
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-3 text-xs text-slate-200 border-b border-slate-700/50 font-medium sticky left-0 z-10 bg-slate-900/95 border-r border-slate-700/40">
                                    {{ $kegiatan }}
                                </td>
                                @php $rowTotal = 0; @endphp
                                @foreach($allDatesList as $date)
                                    @php 
                                        $count = $counts[$date] ?? 0; 
                                        $rowTotal += $count;
                                    @endphp
                                    <td class="p-2.5 text-xs text-center border-b border-slate-700/50 border-l border-slate-700/30 {{ $count > 0 ? 'text-emerald-400 font-bold bg-emerald-500/5' : 'text-slate-600' }}">
                                        {{ $count > 0 ? $count : '-' }}
                                    </td>
                                @endforeach
                                <td class="p-2.5 text-xs text-center border-b border-slate-700/50 border-l border-teal-500/30 bg-teal-900/10 text-teal-300 font-bold">
                                    {{ $rowTotal }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($allDatesList) + 2 }}" class="p-10 text-center text-slate-500 text-xs italic">
                                    <i class="fas fa-inbox text-2xl block mb-2 text-slate-600"></i>
                                    Belum ada data rekapitulasi kegiatan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(count($rekapData) > 0)
                    <tfoot>
                        <tr class="bg-slate-800/90">
                            <td class="p-3 text-xs text-right text-slate-200 font-bold border-t-2 border-teal-500/50 sticky left-0 z-10 bg-slate-800 shadow-md border-r border-slate-700/40">
                                Total Harian
                            </td>
                            @foreach($allDatesList as $date)
                                <td class="p-2.5 text-xs text-center text-emerald-400 font-bold border-t-2 border-teal-500/50 border-l border-slate-700/50 bg-emerald-500/10">
                                    {{ $totalPerDate[$date] }}
                                </td>
                            @endforeach
                            <td class="p-3 text-sm text-center text-white bg-teal-600/40 font-extrabold border-t-2 border-teal-500/50 border-l border-teal-500/30 shadow-[inset_0_0_10px_rgba(20,184,166,0.3)]">
                                {{ $grandTotal }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

        </div>

    </div>

    @include('partials.pwa-prompt')
</body>
</html>
