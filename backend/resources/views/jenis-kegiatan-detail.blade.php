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
        
        /* Documentation Styles */
        .documentation-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .camera-container {
            position: relative;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .camera-placeholder {
            text-align: center;
            padding: 40px 20px;
        }
        .camera-placeholder i {
            margin-bottom: 15px;
            opacity: 0.6;
        }
        .camera-placeholder p {
            font-size: 14px;
            margin: 0;
        }
        #cameraVideo {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .camera-controls {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
        .capture-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            border: 3px solid rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .capture-btn:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        .capture-btn i {
            font-size: 18px;
            color: #333;
        }
        .btn-sm {
            padding: 8px 12px;
            font-size: 12px;
            border-radius: 20px;
            min-width: 40px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #cameraStatus {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.6);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        #cameraStatus small {
            font-size: 12px;
            font-weight: 500;
        }
        
        /* Signature Styles */
        .signature-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .signature-box {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .signature-label {
            color: white;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }
        .signature-area {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px dashed rgba(0, 0, 0, 0.2);
        }
        .signature-area:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(0, 0, 0, 0.3);
        }
        .signature-placeholder {
            text-align: center;
            color: #666;
        }
        .signature-placeholder i {
            opacity: 0.6;
        }
        .signature-placeholder p {
            font-size: 12px;
            margin: 0;
        }
        .signature-info {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            padding: 8px 12px;
        }
        .signature-actions {
            display: flex;
            gap: 8px;
        }
        .signature-canvas {
            width: 100%;
            height: 100%;
            border-radius: 6px;
        }
        .signature-signed {
            background: rgba(76, 175, 80, 0.1);
            border-color: rgba(76, 175, 80, 0.3);
        }
        
        /* Signature Modal */
        .signature-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .signature-modal-content {
            background: white;
            border-radius: 15px;
            padding: 20px;
            max-width: 500px;
            width: 90%;
            max-height: 90%;
        }
        .signature-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .signature-modal-header h5 {
            margin: 0;
            color: #333;
        }
        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }
        .signature-modal-actions {
            text-align: center;
        }
        
        #allImagesPreview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        .image-item {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-item .image-type {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
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

                            <!-- Dokumentasi Section -->
                            <div class="col-12 mb-3">
                                <div class="documentation-section">
                                    <h5 class="text-white mb-3">
                                        <i class="fas fa-camera me-2"></i>Dokumentasi
                                    </h5>
                                    
                                    <!-- Unified Camera and Upload Section -->
                                    <div class="camera-container">
                                        <video id="cameraVideo" autoplay playsinline style="display: none;"></video>
                                        <canvas id="photoCanvas" style="display: none;"></canvas>
                                        <img id="photoPreview" class="photo-preview" alt="Photo Preview">
                                        
                                        <!-- Camera Placeholder -->
                                        <div id="cameraPlaceholder" class="camera-placeholder">
                                            <i class="fas fa-camera fa-3x text-white-50 mb-3"></i>
                                            <p class="text-white-50 mb-0">Klik tombol kamera untuk mengambil foto</p>
                                        </div>
                                        
                                        <!-- Unified Controls -->
                                        <div class="camera-controls">
                                            <button type="button" id="startCameraBtn" class="capture-btn">
                                                <i class="fas fa-camera text-dark"></i>
                                            </button>
                                            <button type="button" id="capturePhoto" class="capture-btn" style="display: none;">
                                                <i class="fas fa-circle text-dark"></i>
                                            </button>
                                            <button type="button" id="uploadPhoto" class="capture-btn" onclick="document.getElementById('fileInput').click()">
                                                <i class="fas fa-upload text-dark"></i>
                                            </button>
                                            <button type="button" id="retakePhoto" class="btn btn-secondary btn-sm" style="display: none;">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                            <button type="button" id="switchCamera" class="btn btn-primary btn-sm" style="display: none;">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button type="button" id="stopCamera" class="btn btn-danger btn-sm" style="display: none;">
                                                <i class="fas fa-stop"></i>
                                            </button>
                                        </div>
                                        
                                        <div id="cameraStatus" class="text-center mt-2">
                                            <small class="text-white-50">Siap mengambil foto</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden file input -->
                                    <input type="file" id="fileInput" accept="image/*" multiple style="display: none;">
                                    
                                    <!-- All Images Preview -->
                                    <div id="allImagesPreview" class="uploaded-images mt-3"></div>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="col-12 mb-4">
                                <div class="signature-section">
                                    <h5 class="text-white mb-4">
                                        <i class="fas fa-signature me-2"></i>Tanda Tangan
                                    </h5>
                                    
                                    <div class="row">
                                        <!-- Petugas Signature -->
                                        <div class="col-md-6 mb-3">
                                            <div class="signature-box">
                                                <label class="signature-label">
                                                    <i class="fas fa-user me-2"></i>Petugas
                                                </label>
                                                <div class="signature-area" id="petugasSignature">
                                                    <div class="signature-placeholder">
                                                        <i class="fas fa-pen-nib fa-2x text-white-50 mb-2"></i>
                                                        <p class="text-white-50 mb-0">Klik untuk tanda tangan</p>
                                                    </div>
                                                </div>
                                                <div class="signature-info mt-2">
                                                    <small class="text-white-50">Nama: <span id="petugasName">-</span></small><br>
                                                    <small class="text-white-50">Tanggal: <span id="petugasDate">-</span></small>
                                                </div>
                                                <div class="signature-actions mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-light me-2" onclick="openSignaturePad('petugas')">
                                                        <i class="fas fa-pen"></i> Tanda Tangan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearSignature('petugas')" style="display: none;" id="clearPetugasBtn">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ka. Unit/Ka. Ruangan Signature -->
                                        <div class="col-md-6 mb-3">
                                            <div class="signature-box">
                                                <label class="signature-label">
                                                    <i class="fas fa-user-tie me-2"></i>Ka. Unit/Ka. Ruangan
                                                </label>
                                                <div class="signature-area" id="kaUnitSignature">
                                                    <div class="signature-placeholder">
                                                        <i class="fas fa-pen-nib fa-2x text-white-50 mb-2"></i>
                                                        <p class="text-white-50 mb-0">Klik untuk tanda tangan</p>
                                                    </div>
                                                </div>
                                                <div class="signature-info mt-2">
                                                    <small class="text-white-50">Nama: <span id="kaUnitName">-</span></small><br>
                                                    <small class="text-white-50">Tanggal: <span id="kaUnitDate">-</span></small>
                                                </div>
                                                <div class="signature-actions mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-light me-2" onclick="openSignaturePad('kaUnit')">
                                                        <i class="fas fa-pen"></i> Tanda Tangan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearSignature('kaUnit')" style="display: none;" id="clearKaUnitBtn">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        let stream = null;
        let capturedPhotos = [];
        let uploadedFiles = [];
        let signatures = {
            petugas: null,
            kaUnit: null
        };

        // Signature functions
        function openSignaturePad(type) {
            // Create modal for signature pad
            const modal = document.createElement('div');
            modal.className = 'signature-modal';
            modal.innerHTML = `
                <div class="signature-modal-content">
                    <div class="signature-modal-header">
                        <h5>Tanda Tangan ${type === 'petugas' ? 'Petugas' : 'Ka. Unit/Ka. Ruangan'}</h5>
                        <button type="button" class="btn-close" onclick="closeSignatureModal()"></button>
                    </div>
                    <div class="signature-modal-body">
                        <canvas id="signatureCanvas" width="400" height="200"></canvas>
                        <div class="signature-modal-actions mt-3">
                            <button type="button" class="btn btn-secondary me-2" onclick="clearCanvas()">Hapus</button>
                            <button type="button" class="btn btn-primary me-2" onclick="saveSignature('${type}')">Simpan</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="closeSignatureModal()">Batal</button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            initializeSignatureCanvas();
        }

        function initializeSignatureCanvas() {
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            
            canvas.style.border = '1px solid #ddd';
            canvas.style.borderRadius = '8px';
            canvas.style.background = 'white';
            
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);
            
            // Touch events for mobile
            canvas.addEventListener('touchstart', handleTouch);
            canvas.addEventListener('touchmove', handleTouch);
            canvas.addEventListener('touchend', stopDrawing);
            
            function startDrawing(e) {
                isDrawing = true;
                draw(e);
            }
            
            function draw(e) {
                if (!isDrawing) return;
                
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#000';
                
                ctx.lineTo(x, y);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(x, y);
            }
            
            function stopDrawing() {
                if (isDrawing) {
                    isDrawing = false;
                    ctx.beginPath();
                }
            }
            
            function handleTouch(e) {
                e.preventDefault();
                const touch = e.touches[0];
                const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 
                                                 e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }
        }

        function clearCanvas() {
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function saveSignature(type) {
            const canvas = document.getElementById('signatureCanvas');
            const dataURL = canvas.toDataURL();
            
            signatures[type] = dataURL;
            
            // Update UI
            const signatureArea = document.getElementById(type + 'Signature');
            signatureArea.innerHTML = `<img src="${dataURL}" class="signature-canvas" alt="Signature">`;
            signatureArea.classList.add('signature-signed');
            
            // Update info
            const now = new Date();
            document.getElementById(type + 'Name').textContent = type === 'petugas' ? 'Petugas' : 'Ka. Unit/Ka. Ruangan';
            document.getElementById(type + 'Date').textContent = now.toLocaleDateString('id-ID');
            
            // Show clear button
            document.getElementById('clear' + (type === 'petugas' ? 'Petugas' : 'KaUnit') + 'Btn').style.display = 'inline-block';
            
            closeSignatureModal();
        }

        function clearSignature(type) {
            signatures[type] = null;
            
            const signatureArea = document.getElementById(type + 'Signature');
            signatureArea.innerHTML = `
                <div class="signature-placeholder">
                    <i class="fas fa-pen-nib fa-2x text-white-50 mb-2"></i>
                    <p class="text-white-50 mb-0">Klik untuk tanda tangan</p>
                </div>
            `;
            signatureArea.classList.remove('signature-signed');
            
            document.getElementById(type + 'Name').textContent = '-';
            document.getElementById(type + 'Date').textContent = '-';
            document.getElementById('clear' + (type === 'petugas' ? 'Petugas' : 'KaUnit') + 'Btn').style.display = 'none';
        }

        function closeSignatureModal() {
            const modal = document.querySelector('.signature-modal');
            if (modal) {
                modal.remove();
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initializePageData();
            initializeCamera();
            initializeFileUpload();
            // Remove auto-start camera
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

        // Camera functionality
        function initializeCamera() {
            const startCameraBtn = document.getElementById('startCameraBtn');
            const captureBtn = document.getElementById('capturePhoto');
            const retakeBtn = document.getElementById('retakePhoto');
            const switchBtn = document.getElementById('switchCamera');
            const stopBtn = document.getElementById('stopCamera');
            const video = document.getElementById('cameraVideo');
            const canvas = document.getElementById('photoCanvas');
            const preview = document.getElementById('photoPreview');
            const status = document.getElementById('cameraStatus');
            const placeholder = document.getElementById('cameraPlaceholder');
            
            let currentFacingMode = 'environment'; // Start with back camera
            let cameraStarted = false;

            // Start camera when button is clicked
            startCameraBtn.addEventListener('click', async () => {
                await startCamera();
            });

            async function startCamera() {
                try {
                    status.innerHTML = '<small class="text-white-50">Memuat kamera...</small>';
                    
                    // Stop existing stream if any
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                    
                    stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { 
                            facingMode: currentFacingMode,
                            width: { ideal: 1280 },
                            height: { ideal: 720 }
                        } 
                    });
                    
                    video.srcObject = stream;
                    video.style.display = 'block';
                    placeholder.style.display = 'none';
                    preview.style.display = 'none';
                    
                    // Update button visibility
                    startCameraBtn.style.display = 'none';
                    captureBtn.style.display = 'block';
                    switchBtn.style.display = 'block';
                    stopBtn.style.display = 'block';
                    retakeBtn.style.display = 'none';
                    
                    cameraStarted = true;
                    
                    status.innerHTML = '<small class="text-success"><i class="fas fa-circle"></i> Kamera aktif - Tekan lingkaran untuk foto</small>';
                    
                } catch (error) {
                    console.error('Error accessing camera:', error);
                    status.innerHTML = '<small class="text-danger">Kamera tidak dapat diakses</small>';
                    
                    // Reset button visibility
                    startCameraBtn.style.display = 'block';
                    captureBtn.style.display = 'none';
                    switchBtn.style.display = 'none';
                    stopBtn.style.display = 'none';
                }
            }
            
            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
                
                video.style.display = 'none';
                placeholder.style.display = 'flex';
                preview.style.display = 'none';
                
                // Reset button visibility
                startCameraBtn.style.display = 'block';
                captureBtn.style.display = 'none';
                switchBtn.style.display = 'none';
                stopBtn.style.display = 'none';
                retakeBtn.style.display = 'none';
                
                cameraStarted = false;
                status.innerHTML = '<small class="text-white-50">Siap mengambil foto</small>';
            }

            captureBtn.addEventListener('click', () => {
                if (!cameraStarted) return;
                
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0);
                
                const dataURL = canvas.toDataURL('image/jpeg', 0.9);
                preview.src = dataURL;
                preview.style.display = 'block';
                video.style.display = 'none';
                placeholder.style.display = 'none';
                
                // Update button visibility
                captureBtn.style.display = 'none';
                retakeBtn.style.display = 'block';
                switchBtn.style.display = 'none';
                stopBtn.style.display = 'none';
                
                // Store captured photo with metadata
                const photoData = {
                    data: dataURL,
                    timestamp: new Date().toISOString(),
                    camera: currentFacingMode,
                    size: dataURL.length,
                    type: 'capture'
                };
                capturedPhotos.push(photoData);
                
                // Display in unified preview
                displayImage(photoData, 'capture');
                
                status.innerHTML = '<small class="text-success">Foto berhasil diambil</small>';
                
                // Stop camera to save battery
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    cameraStarted = false;
                }
            });

            retakeBtn.addEventListener('click', () => {
                // Remove last captured photo
                capturedPhotos.pop();
                refreshImageDisplay();
                
                // Restart camera
                startCamera();
            });
            
            switchBtn.addEventListener('click', () => {
                currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
                if (cameraStarted) {
                    startCamera();
                }
            });
            
            stopBtn.addEventListener('click', () => {
                stopCamera();
            });
        }

        // File upload functionality
        function initializeFileUpload() {
            const fileInput = document.getElementById('fileInput');
            const allImagesContainer = document.getElementById('allImagesPreview');

            fileInput.addEventListener('change', (event) => {
                const files = Array.from(event.target.files);
                
                files.forEach(file => {
                    if (file.type.startsWith('image/') && file.size <= 5 * 1024 * 1024) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const imageData = {
                                file: file,
                                data: e.target.result,
                                name: file.name,
                                type: 'upload',
                                timestamp: new Date().toISOString()
                            };
                            uploadedFiles.push(imageData);
                            displayImage(imageData, 'upload');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        alert(`File ${file.name} tidak valid. Pastikan ukuran file kurang dari 5MB dan format gambar.`);
                    }
                });
                
                // Reset file input
                fileInput.value = '';
            });
        }
        
        function displayImage(imageData, type) {
            const allImagesContainer = document.getElementById('allImagesPreview');
            const imageItem = document.createElement('div');
            imageItem.className = 'image-item';
            
            const index = type === 'capture' ? capturedPhotos.length - 1 : uploadedFiles.length - 1;
            
            imageItem.innerHTML = `
                <img src="${imageData.data}" alt="${imageData.name || 'Captured Photo'}">
                <div class="image-type">${type === 'capture' ? 'Camera' : 'Upload'}</div>
                <button type="button" class="remove-image" onclick="removeImage('${type}', ${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            allImagesContainer.appendChild(imageItem);
        }
        
        function removeImage(type, index) {
            if (type === 'capture') {
                capturedPhotos.splice(index, 1);
            } else {
                uploadedFiles.splice(index, 1);
            }
            refreshImageDisplay();
        }
        
        function refreshImageDisplay() {
            const allImagesContainer = document.getElementById('allImagesPreview');
            allImagesContainer.innerHTML = '';
            
            // Display captured photos
            capturedPhotos.forEach((photo, index) => {
                displayImage(photo, 'capture');
            });
            
            // Display uploaded files
            uploadedFiles.forEach((file, index) => {
                displayImage(file, 'upload');
            });
        }

        function goBack() {
            // Stop camera if running
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            window.history.back();
        }

        function saveDraft() {
            const formData = new FormData(document.getElementById('detailKegiatanForm'));
            formData.set('status', 'draft');
            
            // Add captured photos
            capturedPhotos.forEach((photo, index) => {
                formData.append(`captured_photos[${index}]`, photo.data);
            });
            
            // Add uploaded files
            uploadedFiles.forEach((fileData, index) => {
                formData.append(`uploaded_files[${index}]`, fileData.file);
            });
            
            console.log('Saving draft with documentation...');
            console.log('Captured photos:', capturedPhotos.length);
            console.log('Uploaded files:', uploadedFiles.length);
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
            
            // Add captured photos
            capturedPhotos.forEach((photo, index) => {
                formData.append(`captured_photos[${index}]`, photo.data);
            });
            
            // Add uploaded files
            uploadedFiles.forEach((fileData, index) => {
                formData.append(`uploaded_files[${index}]`, fileData.file);
            });
            
            console.log('Form submitted with documentation:');
            console.log('Form data:', Object.fromEntries(formData));
            console.log('Captured photos:', capturedPhotos.length);
            console.log('Uploaded files:', uploadedFiles.length);
            
            alert('Data berhasil disubmit!');
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>