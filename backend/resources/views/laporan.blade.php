<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - e-Kinerja Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Tambahkan jsPDF untuk export PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.95;
            font-weight: 500;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: #5a67d8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            min-height: auto;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card.active {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
        }

        .stat-card.active .label {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .stat-card.active .number {
            color: white !important;
        }
        .icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-card .number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-card .label {
            font-size: 0.9rem;
            color: #718096;
            font-weight: 500;
            line-height: 1;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            margin-bottom: 30px;
        }

        .table-container h3 {
            color: #2d3748;
            margin-bottom: 20px;
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-box {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            width: 300px;
            transition: border-color 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: #667eea;
        }

        .filter-select {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        th {
            background: #f7fafc;
            font-weight: 600;
            color: #4a5568;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:hover {
            background: #f7fafc;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-draft { background: #fed7d7; color: #c53030; }
        .status-submitted { background: #bee3f8; color: #2b6cb0; }
        .status-approved { background: #c6f6d5; color: #2f855a; }
        .status-rejected { background: #fbb6ce; color: #b83280; }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-view {
            background: #4299e1;
            color: white;
        }

        .btn-view:hover {
            background: #3182ce;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover {
            background: #667eea;
            color: white;
        }

        .pagination button.active {
            background: #667eea;
            color: white;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #718096;
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                width: 100%;
            }
            
            .date-filter-container {
                flex-wrap: wrap;
            }
            
            #exportPdfButton {
                width: 100%;
                justify-content: center;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/user-dashboard" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <div class="header">
            <h1><i class="fas fa-chart-bar"></i> Laporan Kinerja</h1>
            <p>Data lengkap kegiatan dan analisis performa</p>
        </div>

        @if(isset($error))
            <div class="alert alert-error">
                {{ $error }}
            </div>
        @else
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card" id="laporanKegiatanCard" onclick="showLaporanKegiatan()" style="cursor: pointer;">
                    <div class="d-flex align-items-center">
                        <div class="icon" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); margin-right: 20px; margin-bottom: 0;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="number">{{ ($statusStats['draft'] ?? 0) + ($statusStats['submitted'] ?? 0) + ($statusStats['approved'] ?? 0) + ($statusStats['rejected'] ?? 0) }}</div>
                            <div class="label">Laporan Kegiatan</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" id="rekapLaporanCard" onclick="showRekapLaporan()" style="cursor: pointer;">
                    <div class="d-flex align-items-center">
                        <div class="icon" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); margin-right: 20px; margin-bottom: 0;">
                            <i class="fas fa-file-chart-column"></i>
                        </div>
                        <div>
                            <div class="number">{{ $statusStats['approved'] ?? 0 }}</div>
                            <div class="label">Rekap Laporan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <h3 id="tableTitle">
                    <i class="fas fa-table"></i>
                    <span id="titleText">Data Kegiatan Lengkap</span>
                </h3>
                
                <div class="table-controls">
                    <input type="text" id="searchInput" class="search-box" placeholder="Cari berdasarkan NIP, jenis kegiatan, atau unit...">
                    <select id="statusFilter" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="submitted">Submitted</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <!-- Filter Tanggal -->
                    <div class="date-filter-container" style="display: flex; gap: 10px; align-items: center;">
                        <label style="font-weight: 600; color: #4a5568; white-space: nowrap;">Filter Tanggal:</label>
                        <input type="date" id="startDate" class="filter-select" style="width: auto;" placeholder="Dari Tanggal">
                        <span style="color: #4a5568;">s/d</span>
                        <input type="date" id="endDate" class="filter-select" style="width: auto;" placeholder="Sampai Tanggal">
                        <button type="button" id="filterButton" class="btn" style="background: #667eea; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; white-space: nowrap;">Filter</button>
                        <button type="button" id="resetButton" class="btn" style="background: #e2e8f0; color: #4a5568; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; white-space: nowrap;">Reset</button>
                    </div>
                    <!-- Tombol Export PDF -->
                    <button type="button" id="exportPdfButton" class="btn" style="background: #dc2626; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; white-space: nowrap; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </button>
                </div>

                <!-- Laporan Kegiatan Table -->
                <div id="laporanKegiatanTable">
                    @if($laporanData && $laporanData->count() > 0)
                        <table id="dataTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Hasil Temuan</th>
                                    <th>Signature Pelaksana</th>
                                    <th>Signature PJ</th>
                                    <th>Dokumentasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @forelse($laporanData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->jenis_kegiatan ?? '-' }}</td>
                                    <td>{{ $item->nip ?? '-' }}</td>
                                    <td>{{ $item->user ? $item->user->name : ($item->creator ? $item->creator->name : '-') }}</td>
                                    <td>{{ $item->unit ?? '-' }}</td>
                                    <td>{{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        @if($item->hasil_temuan)
                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $item->hasil_temuan }}">
                                                {{ Str::limit($item->hasil_temuan, 50) }}
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->signature_pelaksana)
                                            @php
                                                $signaturePelaksana = $item->signature_pelaksana;
                                                if (!str_starts_with($signaturePelaksana, 'data:image/')) {
                                                    $signaturePelaksana = 'data:image/png;base64,' . $signaturePelaksana;
                                                }
                                            @endphp
                                            <img src="{{ $signaturePelaksana }}" 
                                                 alt="Signature Pelaksana" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 80px; max-height: 60px; cursor: pointer;"
                                                 onclick="showImageModal('{{ $signaturePelaksana }}', 'Signature Pelaksana')">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->signature_pj)
                                            @php
                                                $signaturePj = $item->signature_pj;
                                                if (!str_starts_with($signaturePj, 'data:image/')) {
                                                    $signaturePj = 'data:image/png;base64,' . $signaturePj;
                                                }
                                            @endphp
                                            <img src="{{ $signaturePj }}" 
                                                 alt="Signature PJ" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 80px; max-height: 60px; cursor: pointer;"
                                                 onclick="showImageModal('{{ $signaturePj }}', 'Signature PJ')">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->dokumentasi && is_array($item->dokumentasi) && count($item->dokumentasi) > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($item->dokumentasi as $index => $doc)
                                                    <img src="{{ asset('storage/' . $doc) }}" 
                                                         alt="Dokumentasi {{ $index + 1 }}" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 50px; max-height: 40px; cursor: pointer;"
                                                         onclick="showImageModal('{{ asset('storage/' . $doc) }}', 'Dokumentasi {{ $index + 1 }}')"
                                                         title="Klik untuk memperbesar">
                                                @endforeach
                                            </div>
                                            <small class="text-muted">{{ count($item->dokumentasi) }} file(s)</small>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewDetail({{ $item->id }})" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success" onclick="editItem({{ $item->id }})" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Tidak ada data laporan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <div class="no-data">
                            <i class="fas fa-inbox"></i>
                            <h3>Belum Ada Data</h3>
                            <p>Belum ada kegiatan yang tercatat dalam sistem.</p>
                        </div>
                    @endif
                </div>

                <!-- Rekap Laporan Table -->
                <div id="rekapLaporanTable" style="display: none;">
                    <div class="no-data">
                        <i class="fas fa-chart-pie"></i>
                        <h3>Rekap Laporan</h3>
                        <p>Fitur rekap laporan sedang dalam pengembangan.</p>
                    </div>
                </div>
                
                <div class="pagination" id="pagination">
                    <!-- Pagination will be generated by JavaScript -->
                </div>
            </div>
        @endif
    </div>

    <script>
        let currentView = 'laporan'; // 'laporan' or 'rekap'

        function showLaporanKegiatan() {
            currentView = 'laporan';
            
            // Update card styles
            document.getElementById('laporanKegiatanCard').style.background = 'linear-gradient(135deg, #4299e1 0%, #3182ce 100%)';
            document.getElementById('laporanKegiatanCard').style.color = 'white';
            document.getElementById('rekapLaporanCard').style.background = 'rgba(255, 255, 255, 0.95)';
            document.getElementById('rekapLaporanCard').style.color = '#333';
            
            // Update title
            document.getElementById('titleText').textContent = 'Data Kegiatan Lengkap';
            
            // Show/hide tables
            document.getElementById('laporanKegiatanTable').style.display = 'block';
            document.getElementById('rekapLaporanTable').style.display = 'none';
            
            // Show/hide controls
            document.querySelector('.table-controls').style.display = 'flex';
        }

        function showRekapLaporan() {
            currentView = 'rekap';
            
            // Update card styles
            document.getElementById('rekapLaporanCard').style.background = 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)';
            document.getElementById('rekapLaporanCard').style.color = 'white';
            document.getElementById('laporanKegiatanCard').style.background = 'rgba(255, 255, 255, 0.95)';
            document.getElementById('laporanKegiatanCard').style.color = '#333';
            
            // Update title
            document.getElementById('titleText').textContent = 'Rekap Laporan';
            
            // Show/hide tables
            document.getElementById('laporanKegiatanTable').style.display = 'none';
            document.getElementById('rekapLaporanTable').style.display = 'block';
            
            // Hide controls for rekap
            document.querySelector('.table-controls').style.display = 'none';
        }

        // Initialize with Laporan Kegiatan active
        document.addEventListener('DOMContentLoaded', function() {
            showLaporanKegiatan();
            
            // Setup filter tanggal
            const filterButton = document.getElementById('filterButton');
            const resetButton = document.getElementById('resetButton');
            const exportPdfButton = document.getElementById('exportPdfButton');
            
            if (filterButton) {
                filterButton.addEventListener('click', function() {
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    
                    if (!startDate && !endDate) {
                        alert('Silakan pilih minimal satu tanggal untuk filter');
                        return;
                    }
                    
                    filterTableByDate(startDate, endDate);
                });
            }
            
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    resetTable();
                });
            }
            
            // Setup Export PDF
            if (exportPdfButton) {
                exportPdfButton.addEventListener('click', function() {
                    exportToPDF();
                });
            }
        });
        
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            
            // Ambil data instansi dari user yang login (dikirim dari controller)
            const instansi = '{{ $currentUser->instansi ?? "Nama Instansi" }}';
            const name = '{{ $currentUser->name ?? "Administrator" }}';
            const userNip = '{{ $currentUser->nip ?? "" }}';
            
            // Periode berdasarkan filter
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            let periode = 'Semua Periode';
            
            if (startDate && endDate) {
                const startFormatted = new Date(startDate).toLocaleDateString('id-ID');
                const endFormatted = new Date(endDate).toLocaleDateString('id-ID');
                periode = `${startFormatted} - ${endFormatted}`;
            } else if (startDate) {
                periode = `Mulai ${new Date(startDate).toLocaleDateString('id-ID')}`;
            } else if (endDate) {
                periode = `Sampai ${new Date(endDate).toLocaleDateString('id-ID')}`;
            }
            
            // Header/Kop Surat
            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            doc.text(instansi, doc.internal.pageSize.getWidth() / 2, 20, { align: 'center' });
            
            doc.setFontSize(14);
            doc.text('LAPORAN DATA KEGIATAN', doc.internal.pageSize.getWidth() / 2, 30, { align: 'center' });
            
            doc.setFontSize(12);
            doc.setFont('helvetica', 'normal');
            doc.text(`Dibuat oleh: ${name} (NIP: ${userNip})`, 20, 45);
            doc.text(`Periode: ${periode}`, 20, 52);
            doc.text(`Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}`, 20, 59);
            
            // Garis pemisah
            doc.setLineWidth(0.5);
            doc.line(20, 65, doc.internal.pageSize.getWidth() - 20, 65);
            
            // Fungsi helper untuk menambahkan gambar ke PDF
            function addImageToPDF(imgElement, x, y, width, height) {
                return new Promise((resolve) => {
                    if (!imgElement || !imgElement.src) {
                        resolve(false);
                        return;
                    }
                    
                    try {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        const img = new Image();
                        
                        img.onload = function() {
                            canvas.width = width * 4; // Higher resolution
                            canvas.height = height * 4;
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                            
                            try {
                                const imgData = canvas.toDataURL('image/jpeg', 0.8);
                                doc.addImage(imgData, 'JPEG', x, y, width, height);
                                resolve(true);
                            } catch (e) {
                                console.error('Error adding image to PDF:', e);
                                resolve(false);
                            }
                        };
                        
                        img.onerror = function() {
                            console.error('Error loading image:', imgElement.src);
                            resolve(false);
                        };
                        
                        img.crossOrigin = 'anonymous';
                        img.src = imgElement.src;
                    } catch (e) {
                        console.error('Error processing image:', e);
                        resolve(false);
                    }
                });
            }
            
            // Ambil data dari tabel yang terlihat
            const tableData = [];
            const rows = document.querySelectorAll('#tableBody tr');
            let no = 1;
            
            // Process rows synchronously first
            const processedRows = [];
            rows.forEach(function(row) {
                // Skip baris yang disembunyikan atau baris "tidak ada data"
                if (row.style.display === 'none' || row.cells.length === 1) {
                    return;
                }
                
                const cells = row.cells;
                if (cells.length >= 10) {
                    // Ambil gambar signature dan dokumentasi
                    const signaturePelaksanaImg = cells[7].querySelector('img');
                    const signaturePJImg = cells[8].querySelector('img');
                    const dokumentasiText = cells[9].textContent.trim();
                    
                    const rowData = {
                        no: no++,
                        tanggalDibuat: cells[5].textContent.trim(),
                        jenisKegiatan: cells[1].textContent.trim(),
                        unit: cells[4].textContent.trim(),
                        hasilTemuan: cells[6].textContent.trim().substring(0, 50) + (cells[6].textContent.trim().length > 50 ? '...' : ''),
                        signaturePelaksanaImg: signaturePelaksanaImg,
                        signaturePJImg: signaturePJImg,
                        dokumentasi: dokumentasiText.includes('file(s)') ? dokumentasiText : 'Tidak ada'
                    };
                    processedRows.push(rowData);
                }
            });
            
            // Create table data for autoTable
            const autoTableData = processedRows.map(row => [
                row.no,
                row.tanggalDibuat,
                row.jenisKegiatan,
                row.unit,
                row.hasilTemuan,
                row.signaturePelaksanaImg ? 'Lihat Gambar' : 'Tidak ada',
                row.signaturePJImg ? 'Lihat Gambar' : 'Tidak ada',
                row.dokumentasi
            ]);
            
            // Buat tabel dengan autoTable - margin diperbaiki
            doc.autoTable({
                head: [[
                    'No',
                    'Tanggal Dibuat',
                    'Jenis Kegiatan',
                    'Unit',
                    'Hasil Temuan',
                    'Signature Pelaksana',
                    'Signature PJ',
                    'Dokumentasi'
                ]],
                body: autoTableData,
                startY: 75,
                styles: {
                    fontSize: 8,
                    cellPadding: 2,
                    overflow: 'linebreak',
                    halign: 'left'
                },
                headStyles: {
                    fillColor: [102, 126, 234],
                    textColor: 255,
                    fontStyle: 'bold',
                    halign: 'center'
                },
                columnStyles: {
                    0: { halign: 'center', cellWidth: 12 }, // No - diperkecil
                    1: { cellWidth: 30 }, // Tanggal - diperkecil
                    2: { cellWidth: 35 }, // Jenis Kegiatan
                    3: { cellWidth: 25 }, // Unit - diperkecil
                    4: { cellWidth: 50 }, // Hasil Temuan
                    5: { halign: 'center', cellWidth: 30 }, // Signature Pelaksana
                    6: { halign: 'center', cellWidth: 30 }, // Signature PJ
                    7: { halign: 'center', cellWidth: 25 } // Dokumentasi
                },
                margin: { left: 15, right: 15 }, // Margin diperbaiki - lebih kecil
                tableWidth: 'auto',
                theme: 'striped',
                didDrawPage: function(data) {
                    // Add images after table is drawn
                    const startY = data.settings.startY;
                    const rowHeight = 8; // Approximate row height
                    
                    processedRows.forEach((row, index) => {
                        const currentY = startY + 10 + (index * rowHeight); // Header height + row position
                        
                        // Add signature pelaksana image
                        if (row.signaturePelaksanaImg) {
                            addImageToPDF(row.signaturePelaksanaImg, 185, currentY - 3, 25, 6);
                        }
                        
                        // Add signature PJ image
                        if (row.signaturePJImg) {
                            addImageToPDF(row.signaturePJImg, 220, currentY - 3, 25, 6);
                        }
                    });
                }
            });
            
            // Footer
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.text(
                    `Halaman ${i} dari ${pageCount}`,
                    doc.internal.pageSize.getWidth() - 20,
                    doc.internal.pageSize.getHeight() - 10,
                    { align: 'right' }
                );
            }
            
            // Simpan PDF
            const fileName = `Laporan_Kegiatan_${userNip}_${new Date().toISOString().split('T')[0]}.pdf`;
            doc.save(fileName);
            
            console.log('PDF berhasil diekspor:', fileName);
        }
        
        function filterTableByDate(startDate, endDate) {
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;
            
            console.log('Filter tanggal:', startDate, 'sampai', endDate);
            
            // Konversi input tanggal ke Date object
            let startDateObj = null;
            let endDateObj = null;
            
            if (startDate) {
                startDateObj = new Date(startDate + 'T00:00:00');
            }
            if (endDate) {
                endDateObj = new Date(endDate + 'T23:59:59.999');
            }
            
            // Validasi tanggal
            if (startDateObj && endDateObj && startDateObj > endDateObj) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return;
            }
            
            rows.forEach(function(row) {
                // Skip baris "tidak ada data"
                if (row.cells.length === 1) {
                    row.style.display = 'none';
                    return;
                }
                
                // Ambil tanggal dari kolom ke-6 (index 5)
                const dateCell = row.cells[5];
                if (!dateCell) {
                    row.style.display = 'none';
                    return;
                }
                
                const dateText = dateCell.textContent.trim();
                
                // Parse tanggal dari format "dd/mm/yyyy hh:mm"
                let rowDate = null;
                try {
                    if (dateText && dateText !== '-') {
                        const dateParts = dateText.split(' ');
                        if (dateParts.length >= 1) {
                            const dateOnly = dateParts[0]; // "dd/mm/yyyy"
                            const parts = dateOnly.split('/');
                            if (parts.length === 3) {
                                const day = parseInt(parts[0]);
                                const month = parseInt(parts[1]) - 1; // Month is 0-indexed
                                const year = parseInt(parts[2]);
                                rowDate = new Date(year, month, day);
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error parsing date:', dateText, error);
                }
                
                // Validasi tanggal
                if (!rowDate || isNaN(rowDate.getTime())) {
                    console.log('Invalid date format:', dateText);
                    row.style.display = 'none';
                    return;
                }
                
                // Logika filter
                let showRow = true;
                
                if (startDateObj && rowDate < startDateObj) {
                    showRow = false;
                }
                
                if (endDateObj && rowDate > endDateObj) {
                    showRow = false;
                }
                
                console.log('Row date:', rowDate, 'Show:', showRow, 'Original text:', dateText);
                
                if (showRow) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Tampilkan pesan jika tidak ada data yang cocok
            if (visibleCount === 0) {
                showNoDataMessage('Tidak ada data yang sesuai dengan filter tanggal');
            } else {
                hideNoDataMessage();
            }
            
            console.log('Visible rows:', visibleCount);
        }
        
        function resetTable() {
            // Reset input tanggal
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            
            // Tampilkan semua baris
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(function(row) {
                row.style.display = '';
            });
            
            // Sembunyikan pesan "tidak ada data"
            hideNoDataMessage();
            
            console.log('Filter tanggal direset');
        }
        
        function showNoDataMessage(message) {
            hideNoDataMessage();
            const tbody = document.getElementById('tableBody');
            const noDataRow = document.createElement('tr');
            noDataRow.id = 'noDataRow';
            noDataRow.innerHTML = `
                <td colspan="11" class="text-center text-muted py-4">
                    <i class="fas fa-search fa-2x mb-2"></i><br>
                    ${message}
                </td>
            `;
            tbody.appendChild(noDataRow);
        }
        
        function hideNoDataMessage() {
            const noDataRow = document.getElementById('noDataRow');
            if (noDataRow) {
                noDataRow.remove();
            }
        }
    </script>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="display: none;">
                    <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="position: relative;">
                    <button type="button" class="btn-close position-absolute" style="top: 10px; right: 10px; z-index: 1000;" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 70vh;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk menampilkan gambar dalam modal
        function showImageModal(imageSrc, title) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = title;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
</body>
</html>