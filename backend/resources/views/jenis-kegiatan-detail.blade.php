<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Jenis Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-label {
            color: white;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .status-draft { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .status-submitted { background: rgba(13, 202, 240, 0.2); color: #0dcaf0; }
        .status-approved { background: rgba(25, 135, 84, 0.2); color: #198754; }
        .status-rejected { background: rgba(220, 53, 69, 0.2); color: #dc3545; }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="glass-card p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <button onclick="goBack()" class="btn btn-secondary me-3">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <div>
                                <h4 class="text-white mb-1">Detail Jenis Kegiatan</h4>
                                <p class="text-white-50 mb-0">Kelola detail kegiatan Anda</p>
                            </div>
                        </div>
                        <div id="statusBadge" class="status-badge status-draft">
                            Draft
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="glass-card p-4">
                    <form id="detailKegiatanForm">
                        <div class="row">
                            <!-- Jenis Kegiatan -->
                            <div class="col-md-6 mb-3">
                                <label for="jenisKegiatan" class="form-label">
                                    <i class="fas fa-tasks me-2"></i>Jenis Kegiatan
                                </label>
                                <input type="text" class="form-control" id="jenisKegiatan" name="jenis_kegiatan" readonly>
                            </div>

                            <!-- NIP -->
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">
                                    <i class="fas fa-id-card me-2"></i>NIP
                                </label>
                                <input type="text" class="form-control" id="nip" name="nip" readonly>
                            </div>

                            <!-- Unit -->
                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">
                                    <i class="fas fa-building me-2"></i>Unit
                                </label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="">Pilih Unit</option>
                                    <option value="Asoka">Asoka</option>
                                    <option value="Flamboyan">Flamboyan</option>
                                </select>
                            </div>

                            <!-- Tanggal Dibuat -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggalDibuat" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Tanggal Dibuat
                                </label>
                                <input type="datetime-local" class="form-control" id="tanggalDibuat" name="tanggal_dibuat" required>
                            </div>

                            <!-- Hasil Temuan -->
                            <div class="col-12 mb-3">
                                <label for="hasilTemuan" class="form-label">
                                    <i class="fas fa-search me-2"></i>Hasil Temuan / Kegiatan
                                </label>
                                <textarea class="form-control" id="hasilTemuan" name="hasil_temuan" rows="4" placeholder="Deskripsikan hasil temuan atau kegiatan yang dilakukan..."></textarea>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-flag me-2"></i>Status
                                </label>
                                <select class="form-select" id="status" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="button" class="btn btn-secondary" onclick="goBack()">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <button type="button" class="btn btn-primary" onclick="saveDraft()">
                                <i class="fas fa-save me-2"></i>Simpan Draft
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentUser = null;
        let detailId = null;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initializePageData();
        });

        async function initializePageData() {
            try {
                // Parse URL parameters for auto-fill
                const urlParams = new URLSearchParams(window.location.search);
                const dataParam = urlParams.get('data');
                const idParam = urlParams.get('id');

                console.log('URL params:', { dataParam, idParam });

                // Auto-fill NIP with current user's NIP (hardcoded for now)
                document.getElementById('nip').value = '1234589';
                console.log('Auto-filled NIP: 1234589');

                // Auto-fill Jenis Kegiatan from dashboard click
                if (dataParam) {
                    try {
                        const data = JSON.parse(decodeURIComponent(dataParam));
                        console.log('Parsed data from URL:', data);
                        
                        if (data.jenis_kegiatan) {
                            document.getElementById('jenisKegiatan').value = data.jenis_kegiatan;
                            console.log('Auto-filled Jenis Kegiatan:', data.jenis_kegiatan);
                        }
                    } catch (error) {
                        console.error('Error parsing URL data:', error);
                    }
                }

                // Set default datetime to now
                if (!idParam) {
                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    document.getElementById('tanggalDibuat').value = now.toISOString().slice(0, 16);
                }

            } catch (error) {
                console.error('Error initializing page data:', error);
            }
        }

        function goBack() {
            window.history.back();
        }

        function saveDraft() {
            const formData = new FormData(document.getElementById('detailKegiatanForm'));
            formData.set('status', 'draft');
            
            console.log('Saving draft...');
            alert('Draft berhasil disimpan!');
        }

        function updateStatusBadge(status) {
            const badge = document.getElementById('statusBadge');
            badge.className = `status-badge status-${status}`;
            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }

        // Form submission
        document.getElementById('detailKegiatanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            console.log('Form submitted:', Object.fromEntries(formData));
            
            alert('Data berhasil disubmit!');
        });
    </script>
</body>
</html>