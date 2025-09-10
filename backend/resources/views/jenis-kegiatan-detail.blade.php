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
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .media-section {
            position: relative;
            width: 100%;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .photo-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
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
            flex-direction: column;
            gap: 10px;
            align-items: center;
            z-index: 10;
        }
        
        .primary-controls {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
        }
        
        .secondary-controls {
            display: flex;
            gap: 8px;
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
        .camera-status {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.6);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            z-index: 10;
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
            padding: 20px;
            box-sizing: border-box;
        }
        .signature-modal-content {
            background: white;
            border-radius: 15px;
            padding: 24px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease-out;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .signature-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f0f0f0;
            flex-wrap: wrap;
            gap: 12px;
        }
        .signature-modal-header h5 {
            margin: 0;
            color: #333;
            font-size: 18px;
            font-weight: 600;
            flex: 1;
            min-width: 200px;
        }
        .btn-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }
        .btn-close:hover {
            background: #f5f5f5;
            color: #333;
        }
        
        .signature-modal-body {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        #signatureCanvas {
            width: 100%;
            height: auto;
            min-height: 200px;
            max-height: 300px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            background: white;
            cursor: crosshair;
            touch-action: none;
        }
        
        .signature-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .signature-modal-actions .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            min-width: 100px;
        }
        
        .signature-modal-actions .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .signature-modal-actions .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        
        .signature-modal-actions .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .signature-modal-actions .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }
        
        .signature-modal-actions .btn-outline-secondary {
            background: transparent;
            color: #6c757d;
            border: 2px solid #6c757d;
        }
        
        .signature-modal-actions .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-1px);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .signature-modal {
                padding: 16px;
            }
            
            .signature-modal-content {
                padding: 20px;
                max-height: 95vh;
            }
            
            .signature-modal-header {
                margin-bottom: 20px;
                padding-bottom: 12px;
            }
            
            .signature-modal-header h5 {
                font-size: 16px;
                min-width: auto;
            }
            
            #signatureCanvas {
                min-height: 180px;
                max-height: 250px;
            }
            
            .signature-modal-actions {
                gap: 8px;
            }
            
            .signature-modal-actions .btn {
                padding: 10px 16px;
                font-size: 14px;
                min-width: 80px;
                flex: 1;
            }
        }
        
        @media (max-width: 480px) {
            .signature-modal {
                padding: 12px;
            }
            
            .signature-modal-content {
                padding: 16px;
            }
            
            .signature-modal-header h5 {
                font-size: 15px;
            }
            
            #signatureCanvas {
                min-height: 160px;
                max-height: 200px;
            }
            
            .signature-modal-actions {
                flex-direction: column;
                gap: 8px;
            }
            
            .signature-modal-actions .btn {
                width: 100%;
                min-width: auto;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn-close {
                width: 44px;
                height: 44px;
                font-size: 20px;
            }
            
            .signature-modal-actions .btn {
                padding: 14px 20px;
                min-height: 44px;
            }
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
                                    <option value="">Memuat unit...</option>
                                    <!-- Options akan dimuat dari API berdasarkan NIP -->
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih unit yang tersedia untuk NIP Anda
                                </div>
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
                                        <!-- Media Elements -->
                                        <div class="media-section">
                                            <video id="cameraVideo" autoplay playsinline style="display: none;"></video>
                                            <canvas id="photoCanvas" style="display: none;"></canvas>
                                            <img id="photoPreview" class="photo-preview" alt="Photo Preview" style="display: none;">
                                            
                                            <!-- Camera Placeholder -->
                                            <div id="cameraPlaceholder" class="camera-placeholder">
                                                <i class="fas fa-camera fa-3x text-white-50 mb-3"></i>
                                                <p class="text-white-50 mb-0">Klik tombol kamera untuk mengambil foto</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Status Information -->
                                        <div id="cameraStatus" class="camera-status">
                                            <small class="text-white-50">Siap mengambil foto</small>
                                        </div>
                                        
                                        <!-- Control Buttons -->
                                        <div class="camera-controls">
                                            <!-- Primary Actions -->
                                            <div class="primary-controls">
                                                <button type="button" id="startCameraBtn" class="capture-btn" title="Mulai Kamera">
                                                    <i class="fas fa-camera text-dark"></i>
                                                </button>
                                                <button type="button" id="capturePhoto" class="capture-btn" style="display: none;" title="Ambil Foto">
                                                    <i class="fas fa-circle text-dark"></i>
                                                </button>
                                                <button type="button" id="uploadPhoto" class="capture-btn" onclick="document.getElementById('fileInput').click()" title="Upload Foto">
                                                    <i class="fas fa-upload text-dark"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Secondary Actions -->
                                            <div class="secondary-controls">
                                                <button type="button" id="retakePhoto" class="btn btn-secondary btn-sm" style="display: none;" title="Ambil Ulang">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                                <button type="button" id="switchCamera" class="btn btn-primary btn-sm" style="display: none;" title="Ganti Kamera">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                                <button type="button" id="stopCamera" class="btn btn-danger btn-sm" style="display: none;" title="Stop Kamera">
                                                    <i class="fas fa-stop"></i>
                                                </button>
                                            </div>
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
            
            // Set canvas responsive size
            function resizeCanvas() {
                const container = canvas.parentElement;
                const containerWidth = container.clientWidth;
                const aspectRatio = 2; // width:height ratio
                
                canvas.width = Math.min(containerWidth - 40, 500);
                canvas.height = canvas.width / aspectRatio;
                
                // Ensure minimum height
                if (canvas.height < 160) {
                    canvas.height = 160;
                    canvas.width = canvas.height * aspectRatio;
                }
                
                canvas.style.width = canvas.width + 'px';
                canvas.style.height = canvas.height + 'px';
            }
            
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);
            
            canvas.style.border = '2px solid #e0e0e0';
            canvas.style.borderRadius = '12px';
            canvas.style.background = 'white';
            canvas.style.cursor = 'crosshair';
            canvas.style.touchAction = 'none';
            
            // Mouse events
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);
            
            // Touch events for mobile
            canvas.addEventListener('touchstart', handleTouch);
            canvas.addEventListener('touchmove', handleTouch);
            canvas.addEventListener('touchend', stopDrawing);
            
            function handleTouch(e) {
                e.preventDefault();
                const touch = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                const x = touch.clientX - rect.left;
                const y = touch.clientY - rect.top;
                
                if (e.type === 'touchstart') {
                    isDrawing = true;
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                } else if (e.type === 'touchmove' && isDrawing) {
                    ctx.lineTo(x, y);
                    ctx.stroke();
                }
            }
            
            function startDrawing(e) {
                isDrawing = true;
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                ctx.beginPath();
                ctx.moveTo(x, y);
            }
            
            function draw(e) {
                if (!isDrawing) return;
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                ctx.lineTo(x, y);
                ctx.stroke();
            }
            
            function stopDrawing() {
                isDrawing = false;
            }
            
            // Set drawing style
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
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

        // Fungsi untuk memuat unit berdasarkan NIP user
        async function loadUserUnits() {
            try {
                const token = localStorage.getItem('token') || sessionStorage.getItem('token');
                const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
                
                if (!token || !user.nip) {
                    console.error('Token atau NIP user tidak ditemukan');
                    return;
                }

                console.log('Loading units for NIP:', user.nip);

                const response = await fetch('/api/unit-ruangan', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('API Response:', result);
                
                const unitSelect = document.getElementById('unit');
                
                // Bersihkan options yang ada
                unitSelect.innerHTML = '<option value="">Pilih Unit</option>';
                
                // Tambahkan options dari data API
                if (result.success && result.data && result.data.length > 0) {
                    // Gunakan Set untuk menghindari duplikasi nama_ruangan
                    const uniqueUnits = [...new Set(result.data.map(item => item.nama_ruangan))];
                    
                    uniqueUnits.forEach(namaRuangan => {
                        const option = document.createElement('option');
                        option.value = namaRuangan;
                        option.textContent = namaRuangan;
                        unitSelect.appendChild(option);
                    });
                    
                    console.log('Units loaded successfully:', uniqueUnits);
                } else {
                    // Jika tidak ada data unit untuk user ini
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Tidak ada unit tersedia untuk NIP Anda';
                    option.disabled = true;
                    unitSelect.appendChild(option);
                    
                    console.log('No units found for user NIP:', user.nip);
                }
                
            } catch (error) {
                console.error('Error loading units:', error);
                const unitSelect = document.getElementById('unit');
                unitSelect.innerHTML = '<option value="">Error memuat data unit</option>';
                
                // Show notification to user
                if (typeof showNotification === 'function') {
                    showNotification('Gagal memuat data unit: ' + error.message, 'error');
                }
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', async function() {
            console.log('🚀 DOM Content Loaded - Starting initialization...');
            
            // Periksa autentikasi terlebih dahulu
            const token = localStorage.getItem('token') || sessionStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
            
            if (!token || !user.nip) {
                console.log('No valid session found, redirecting to login...');
                alert('Session expired. Please login again.');
                window.location.href = '/login';
                return;
            }
            
            console.log('User authenticated:', { nip: user.nip, name: user.name });
            
            // Inisialisasi data halaman
            await initializePageData();
            initializeCamera();
            initializeFileUpload();
            loadUserUnits();
            
            // Setup form submission handler
            const form = document.getElementById('detailKegiatanForm');
            if (form) {
                console.log('✅ Form found, setting up submission handler...');
                
                // Remove form action and method to prevent default submission
                form.removeAttribute('action');
                form.removeAttribute('method');
                form.onsubmit = null;
                console.log('🧹 Removed form action and method attributes');
                
                form.addEventListener('submit', async function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                    
                    console.log('📝 Form submission started...');
                    
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    
                    try {
                        // Disable button and show loading
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                        
                        // Validate required fields before sending
                        const jenisKegiatan = document.getElementById('jenisKegiatan').value;
                        const nip = document.getElementById('nip').value;
                        const unit = document.getElementById('unit').value;
                        const tanggalDibuat = document.getElementById('tanggalDibuat').value;
                        
                        if (!jenisKegiatan || !nip || !unit || !tanggalDibuat) {
                            throw new Error('Semua field wajib harus diisi');
                        }
                        
                        const formData = new FormData();
                        
                        // Add basic fields with proper validation
                        formData.append('jenis_kegiatan', jenisKegiatan);
                        formData.append('nip', nip);
                        formData.append('unit', unit);
                        
                        // Fix date format - ensure it's in Y-m-d H:i:s format
                        let formattedDate;
                        if (tanggalDibuat) {
                            const date = new Date(tanggalDibuat);
                            if (isNaN(date.getTime())) {
                                throw new Error('Format tanggal tidak valid');
                            }
                            formattedDate = date.getFullYear() + '-' + 
                                String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(date.getDate()).padStart(2, '0') + ' ' +
                                String(date.getHours()).padStart(2, '0') + ':' +
                                String(date.getMinutes()).padStart(2, '0') + ':' +
                                String(date.getSeconds()).padStart(2, '0');
                        } else {
                            // Use current datetime if not provided
                            const now = new Date();
                            formattedDate = now.getFullYear() + '-' + 
                                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(now.getDate()).padStart(2, '0') + ' ' +
                                String(now.getHours()).padStart(2, '0') + ':' +
                                String(now.getMinutes()).padStart(2, '0') + ':' +
                                String(now.getSeconds()).padStart(2, '0');
                        }
                        formData.append('tanggal_dibuat', formattedDate);
                        
                        // Add optional fields
                        const hasilTemuan = document.getElementById('hasilTemuan')?.value || '';
                        if (hasilTemuan) {
                            formData.append('hasil_temuan', hasilTemuan);
                        }
                        
                        // Add signatures if available
                        if (signatures.petugas) {
                            formData.append('signature_pelaksana', signatures.petugas);
                        }
                        if (signatures.kaUnit) {
                            formData.append('signature_pj', signatures.kaUnit);
                        }
                        
                        // Add captured photos
                        if (capturedPhotos && capturedPhotos.length > 0) {
                            capturedPhotos.forEach((photo, index) => {
                                if (photo.data) {
                                    formData.append(`captured_photos[${index}]`, photo.data);
                                }
                            });
                        }
                        
                        // Add uploaded files
                        if (uploadedFiles && uploadedFiles.length > 0) {
                            uploadedFiles.forEach((fileData, index) => {
                                if (fileData.file) {
                                    formData.append(`uploaded_files[${index}]`, fileData.file);
                                }
                            });
                        }
                        
                        // Set status
                        formData.append('status', 'submitted');
                        
                        console.log('📤 Sending data to API...');
                        console.log('📋 Form data entries:');
                        for (let [key, value] of formData.entries()) {
                            console.log(`  ${key}:`, typeof value === 'string' ? value.substring(0, 100) : value);
                        }
                        
                        // Check token
                        if (!token) {
                            throw new Error('Token tidak ditemukan. Silakan login ulang.');
                        }
                        
                        const response = await fetch('/api/detail-jenis-kegiatan', {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });
                        
                        console.log('📥 Response status:', response.status);
                        
                        const result = await response.json();
                        console.log('📥 Response data:', result);
                        
                        if (response.ok && result.success) {
                            showNotification('Data berhasil disimpan!', 'success');
                            updateStatusBadge('submitted');
                            
                            // Optional: redirect after success
                            setTimeout(() => {
                                if (confirm('Data berhasil disimpan! Kembali ke dashboard?')) {
                                    window.location.href = '/user-dashboard';
                                }
                            }, 2000);
                        } else {
                            console.error('❌ API Error:', result);
                            
                            let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                            if (result.message) {
                                errorMessage = result.message;
                            }
                            if (result.errors) {
                                console.error('Validation errors:', result.errors);
                                const errorDetails = Object.entries(result.errors)
                                    .map(([field, messages]) => `${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}`)
                                    .join('\n');
                                errorMessage += ':\n' + errorDetails;
                            }
                            
                            showNotification(errorMessage, 'error');
                        }
                        
                    } catch (error) {
                        console.error('❌ Submit Error:', error);
                        showNotification('Error: ' + error.message, 'error');
                    } finally {
                        // Reset button
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                    
                    return false;
                }, true);
                
                console.log('✅ Event listener successfully attached with stronger prevention');
            } else {
                console.error('❌ Form with ID "detailKegiatanForm" not found!');
            }
        });

        async function initializePageData() {
            try {
                // Parse URL parameters for auto-fill
                const urlParams = new URLSearchParams(window.location.search);
                const dataParam = urlParams.get('data');
                const idParam = urlParams.get('id');

                console.log('URL params:', { dataParam, idParam });

                // Ambil data user dari localStorage/sessionStorage
                const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
                
                if (user.nip) {
                    // Auto-fill NIP dengan NIP user yang login
                    document.getElementById('nip').value = user.nip;
                    console.log('Auto-filled NIP:', user.nip);
                    
                    // Muat unit berdasarkan NIP user
                    await loadUserUnits();
                } else {
                    console.error('NIP user tidak ditemukan dalam session');
                    // Redirect ke login jika tidak ada data user
                    if (confirm('Session expired. Redirect to login?')) {
                        window.location.href = '/login';
                    }
                    return;
                }

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
                if (typeof showNotification === 'function') {
                    showNotification('Error initializing page: ' + error.message, 'error');
                }
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
                preview.classList.add('show'); // Add this line
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
            
            // Show compression info for uploaded files
            const sizeInfo = imageData.originalSize && imageData.compressedSize ? 
                `<small class="text-muted">Ukuran: ${formatFileSize(imageData.originalSize)} → ${formatFileSize(imageData.compressedSize)}</small>` : '';
            
            imageItem.innerHTML = `
                <img src="${imageData.data}" alt="${imageData.name || 'Captured Photo'}">
                <div class="image-type">${type === 'capture' ? 'Camera' : 'Upload'}</div>
                ${sizeInfo}
                <button type="button" class="remove-image" onclick="removeImage('${type}', ${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            allImagesContainer.appendChild(imageItem);
        }
        
        // Format file size helper function
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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
            
            // Redirect to main dashboard
            window.location.href = '/dashboard';
        }

        async function saveDraft() {
            const formData = new FormData(document.getElementById('detailKegiatanForm'));
            formData.set('status', 'draft');
            
            // Add captured photos with validation
            console.log('Captured photos count:', capturedPhotos.length);
            capturedPhotos.forEach((photo, index) => {
                console.log(`Adding captured photo ${index}:`, {
                    hasData: !!photo.data,
                    dataLength: photo.data ? photo.data.length : 0,
                    timestamp: photo.timestamp
                });
                formData.append(`captured_photos[${index}]`, photo.data);
            });
            
            // Add uploaded files with validation
            console.log('Uploaded files count:', uploadedFiles.length);
            uploadedFiles.forEach((fileData, index) => {
                console.log(`Adding uploaded file ${index}:`, {
                    hasFile: !!fileData.file,
                    fileName: fileData.file ? fileData.file.name : 'unknown',
                    fileSize: fileData.file ? fileData.file.size : 0
                });
                formData.append(`uploaded_files[${index}]`, fileData.file);
            });
            
            try {
                const token = localStorage.getItem('token') || sessionStorage.getItem('token');
                
                if (!token) {
                    alert('Session expired. Please login again.');
                    window.location.href = '/login';
                    return;
                }
                
                console.log('Sending request to save draft...');
                const response = await fetch('/api/detail-jenis-kegiatan', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const result = await response.json();
                console.log('Server response:', result);
                
                if (response.ok && result.success) {
                    alert('Draft berhasil disimpan!');
                    updateStatusBadge('draft');
                } else {
                    console.error('Save failed:', result);
                    alert('Gagal menyimpan draft: ' + (result.message || 'Terjadi kesalahan'));
                }
            } catch (error) {
                console.error('Network error:', error);
                alert('Terjadi kesalahan jaringan: ' + error.message);
            }
        }

        async function saveDraft() {
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
            
            try {
                const token = localStorage.getItem('token') || sessionStorage.getItem('token');
                
                if (!token) {
                    alert('Session expired. Please login again.');
                    window.location.href = '/login';
                    return;
                }
                
                const response = await fetch('/api/detail-jenis-kegiatan', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    alert('Draft berhasil disimpan!');
                    updateStatusBadge('draft');
                } else {
                    alert('Gagal menyimpan draft: ' + (result.message || 'Terjadi kesalahan'));
                }
            } catch (error) {
                console.error('Error saving draft:', error);
                alert('Terjadi kesalahan saat menyimpan draft: ' + error.message);
            }
        }

        function updateStatusBadge(status) {
            const badge = document.getElementById('statusBadge');
            badge.className = `status-badge status-${status}`;
            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }

        // Form submission is now handled in the DOMContentLoaded event
        
        // Add notification function
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notif => notif.remove());
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-md transition-all duration-300 transform translate-x-full`;
            
            // Set notification style based on type
            switch(type) {
                case 'success':
                    notification.classList.add('bg-green-500', 'text-white');
                    break;
                case 'error':
                    notification.classList.add('bg-red-500', 'text-white');
                    break;
                case 'warning':
                    notification.classList.add('bg-yellow-500', 'text-black');
                    break;
                default:
                    notification.classList.add('bg-blue-500', 'text-white');
            }
            
            notification.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-1">
                        <p class="text-sm font-medium whitespace-pre-line">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>