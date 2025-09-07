<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Master Data - e-Kinerja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-dark {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .morphism-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-scale:hover {
            transform: scale(1.02) translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(72, 187, 120, 0.4);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        .modal {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen p-4 sm:p-6 lg:p-8">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 4s;"></div>
        </div>
        <!-- Header -->
        <div class="morphism-card rounded-2xl p-6 mb-8 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Master Data</h1>
                    <p class="text-gray-200">Kelola data master sistem e-Kinerja</p>
                </div>
                <a href="/dashboard" class="btn-primary text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
        
        <!-- Master Data Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Jenis Kegiatan -->
            <div class="morphism-card rounded-xl p-4 hover-scale cursor-pointer" onclick="showJenisKegiatan()">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-pink-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clipboard-list text-white text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-white truncate">Jenis Kegiatan</h3>
                        <p class="text-gray-300 text-xs truncate">Kelola jenis kegiatan</p>
                    </div>
                </div>
            </div>
            
            <!-- Unit/Ruangan -->
            <div class="morphism-card rounded-xl p-4 hover-scale cursor-pointer" onclick="showUnitRuangan()">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-building text-white text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-white truncate">Unit/Ruangan</h3>
                        <p class="text-gray-300 text-xs truncate">Kelola data unit dan ruangan</p>
                    </div>
                </div>
            </div>
            
            <!-- Data Pegawai -->
            <div class="morphism-card rounded-xl p-4 hover-scale cursor-pointer" onclick="showDataPegawai()">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-white truncate">Data Pegawai</h3>
                        <p class="text-gray-300 text-xs truncate">Kelola data pegawai</p>
                    </div>
                </div>
            </div>
            
            <!-- Golongan -->
            <div class="morphism-card rounded-xl p-4 hover-scale cursor-pointer" onclick="showGolongan()">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-layer-group text-white text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-white truncate">Golongan</h3>
                        <p class="text-gray-300 text-xs truncate">Kelola data golongan</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="morphism-card rounded-2xl p-6 fade-in">
            <!-- Data Pegawai Section -->
            <div id="dataPegawaiSection" class="data-section hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Data Pegawai</h2>
                    <button onclick="openAddPegawaiModal()" class="btn-success text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Pegawai
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 px-4">NIK</th>
                                <th class="text-left py-3 px-4">Nama</th>
                                <th class="text-left py-3 px-4">NIP</th>
                                <th class="text-left py-3 px-4">Golongan</th>
                                <th class="text-left py-3 px-4">Instansi</th>
                                <th class="text-left py-3 px-4">Ruangan</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pegawaiTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Data Instansi Section -->
            <div id="dataInstansiSection" class="data-section hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Data Instansi</h2>
                    <button onclick="openAddInstansiModal()" class="btn-success text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Instansi
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 px-4">Kode</th>
                                <th class="text-left py-3 px-4">Nama Instansi</th>
                                <th class="text-left py-3 px-4">Alamat</th>
                                <th class="text-left py-3 px-4">Telepon</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="instansiTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Data Golongan Section -->
            <div id="dataGolonganSection" class="data-section hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Data Golongan</h2>
                    <button onclick="openAddGolonganModal()" class="btn-success text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Golongan
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 px-4">Kode</th>
                                <th class="text-left py-3 px-4">Nama Golongan</th>
                                <th class="text-left py-3 px-4">Deskripsi</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="golonganTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Data Ruangan Section -->
            <div id="dataRuanganSection" class="data-section hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Data Ruangan</h2>
                    <button onclick="openAddRuanganModal()" class="btn-success text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Ruangan
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 px-4">Kode</th>
                                <th class="text-left py-3 px-4">Nama Ruangan</th>
                                <th class="text-left py-3 px-4">Lantai</th>
                                <th class="text-left py-3 px-4">Kapasitas</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="ruanganTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Unit/Ruangan Section -->
            <div id="unitRuanganSection" class="data-section hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Unit/Ruangan</h2>
                    <button onclick="openAddUnitRuanganModal()" class="btn-success text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Unit/Ruangan
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 px-4">ID</th>
                                <th class="text-left py-3 px-4">NIP</th>
                                <th class="text-left py-3 px-4">Nama Pegawai</th>
                                <th class="text-left py-3 px-4">Nama Ruangan</th>
                                <th class="text-left py-3 px-4">Tanggal Dibuat</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="unitRuanganTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Jenis Kegiatan Section -->
            <div id="jenisKegiatanSection" class="data-section hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Jenis Kegiatan</h2>
                    <button onclick="openAddJenisKegiatanModal()" class="btn-success text-white px-6 py-3 rounded-xl hover:scale-105 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Jenis Kegiatan
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 px-4">NIP</th>
                                <th class="text-left py-3 px-4">Nama Pegawai</th>
                                <th class="text-left py-3 px-4">Golongan</th>
                                <th class="text-left py-3 px-4">Jenis Kegiatan</th>
                                <th class="text-left py-3 px-4">Tanggal Dibuat</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="jenisKegiatanTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Default Welcome Section -->
            <div id="welcomeSection" class="data-section text-center py-12">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-database text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-4">Selamat Datang di Master Data</h2>
                <p class="text-gray-300 mb-6">Pilih salah satu menu di atas untuk mengelola data master sistem e-Kinerja</p>
            </div>
        </div>
    </div>
    
    <!-- Modal Jenis Kegiatan -->
    <div id="jenisKegiatanModal" class="modal fixed inset-0 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="modal-content rounded-2xl p-6 w-full max-w-md">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Tambah Jenis Kegiatan</h3>
                    <button onclick="closeJenisKegiatanModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="jenisKegiatanForm" onsubmit="submitJenisKegiatan(event)">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                        <input type="text" id="userNip" name="nip" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" 
                               placeholder="NIP akan diisi otomatis">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Golongan</label>
                        <input type="text" id="userGolongan" name="golongan" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" 
                               placeholder="Golongan akan diisi otomatis">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kegiatan</label>
                        <input type="text" id="jenisKegiatan" name="jenis_kegiatan" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                               placeholder="Masukkan jenis kegiatan">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeJenisKegiatanModal()" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit Jenis Kegiatan -->
    <div id="editJenisKegiatanModal" class="modal fixed inset-0 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="modal-content rounded-2xl p-6 w-full max-w-md">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit Jenis Kegiatan</h3>
                    <button onclick="closeEditJenisKegiatanModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="editJenisKegiatanForm" onsubmit="updateJenisKegiatan(event)">
                    <input type="hidden" id="editJenisKegiatanId" name="id">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                        <input type="text" id="editUserNip" name="nip" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Golongan</label>
                        <input type="text" id="editUserGolongan" name="golongan" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kegiatan</label>
                        <input type="text" id="editJenisKegiatanNama" name="jenis_kegiatan" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                               placeholder="Masukkan jenis kegiatan">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditJenisKegiatanModal()" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Global variables
        let currentUser = null;
        let jenisKegiatanData = [];
        let editingId = null;
        
        // Get current user data - perbaiki untuk menangani response yang benar
        async function getCurrentUser() {
            try {
                const token = getAuthToken();
                if (!token) {
                    console.error('No auth token found');
                    window.location.href = '/login';
                    return null;
                }
        
                // Coba endpoint /api/user terlebih dahulu
                const response = await fetch('/api/user', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        console.error('Token expired or invalid');
                        localStorage.removeItem('token');
                        sessionStorage.removeItem('token');
                        window.location.href = '/login';
                        return null;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const userData = await response.json();
                console.log('User data response:', userData);
                
                // Response dari /api/user langsung berupa user object
                if (userData) {
                    currentUser = userData;
                    console.log('Current user set:', currentUser);
                    return currentUser;
                } else {
                    throw new Error('No user data received');
                }
            } catch (error) {
                console.error('Error getting current user:', error);
                
                // Fallback ke /api/auth/me
                try {
                    const token = getAuthToken();
                    const response = await fetch('/api/auth/me', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        const result = await response.json();
                        if (result.success && result.data) {
                            currentUser = result.data;
                            return currentUser;
                        }
                    }
                } catch (fallbackError) {
                    console.error('Fallback also failed:', fallbackError);
                }
                
                alert('Gagal memuat data user. Silakan login ulang.');
                window.location.href = '/login';
                return null;
            }
        }
        
        // Load Jenis Kegiatan Data
        async function loadJenisKegiatanData() {
            try {
                console.log('Loading jenis kegiatan data...');
                const token = getAuthToken();
                console.log('Token:', token ? 'Available' : 'Not found');
                
                if (!token) {
                    alert('Session expired. Please login again.');
                    window.location.href = '/login';
                    return;
                }

                const response = await fetch('/api/jenis-kegiatan', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
        
                if (!response.ok) {
                    if (response.status === 401) {
                        alert('Session expired. Please login again.');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
                console.log('API Response:', result);
        
                if (result.success) {
                    jenisKegiatanData = result.data;
                    console.log('Data loaded:', jenisKegiatanData);
                    renderJenisKegiatanTable();
                } else {
                    console.error('Error loading data:', result.message);
                    alert('Gagal memuat data jenis kegiatan: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data: ' + error.message);
            }
        }
        
        // Render Jenis Kegiatan Table
        function renderJenisKegiatanTable() {
            const tbody = document.getElementById('jenisKegiatanTableBody');
            if (!tbody) {
                console.error('Table body not found');
                return;
            }
            
            tbody.innerHTML = '';
            
            if (!jenisKegiatanData || jenisKegiatanData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-12">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Belum Ada Data Jenis Kegiatan</h3>
                                    <p class="text-gray-400 mb-4">Mulai dengan menambahkan jenis kegiatan pertama Anda</p>
                                    <button onclick="openAddJenisKegiatanModal()" class="btn-success text-white px-6 py-2 rounded-lg hover:scale-105 transition-all">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Jenis Kegiatan
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            jenisKegiatanData.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-600 hover:bg-gray-700/50';
                
                const createdAt = new Date(item.created_at).toLocaleDateString('id-ID');
                
                row.innerHTML = `
                    <td class="py-3 px-4">${item.user?.nip || item.nip || '-'}</td>
                    <td class="py-3 px-4">${item.user?.name || item.nama || '-'}</td>
                    <td class="py-3 px-4">${item.user?.golongan || item.golongan || '-'}</td>
                    <td class="py-3 px-4">${item.jenis_kegiatan}</td>
                    <td class="py-3 px-4">${createdAt}</td>
                    <td class="py-3 px-4">
                        <button onclick="editJenisKegiatan(${item.id})" class="btn-warning text-white px-3 py-1 rounded-lg mr-2 hover:scale-105 transition-all">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteJenisKegiatan(${item.id})" class="btn-danger text-white px-3 py-1 rounded-lg hover:scale-105 transition-all">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }
        
        // Open Add Jenis Kegiatan Modal
        async function openAddJenisKegiatanModal() {
            editingId = null;
            
            // Get current user data
            const user = await getCurrentUser();
            if (!user) {
                alert('Gagal mendapatkan data user. Silakan login ulang.');
                return;
            }
            
            // Fill user data in form
            const nipInput = document.getElementById('userNip');
            const golonganInput = document.getElementById('userGolongan');
            const jenisKegiatanInput = document.getElementById('jenisKegiatan');
            
            if (nipInput) nipInput.value = user.nip || '';
            if (golonganInput) golonganInput.value = user.golongan || '';
            if (jenisKegiatanInput) jenisKegiatanInput.value = '';
            
            const modal = document.getElementById('jenisKegiatanModal');
            if (modal) modal.classList.remove('hidden');
        }
        
        // Close Add Jenis Kegiatan Modal
        function closeJenisKegiatanModal() {
            const modal = document.getElementById('jenisKegiatanModal');
            if (modal) modal.classList.add('hidden');
            
            const form = document.getElementById('jenisKegiatanForm');
            if (form) form.reset();
        }
        
        // Close Edit Jenis Kegiatan Modal
        function closeEditJenisKegiatanModal() {
            const modal = document.getElementById('editJenisKegiatanModal');
            if (modal) modal.classList.add('hidden');
            
            const form = document.getElementById('editJenisKegiatanForm');
            if (form) form.reset();
        }
        
        // Submit Jenis Kegiatan
        async function submitJenisKegiatan(event) {
            event.preventDefault();
            
            const jenisKegiatanInput = document.getElementById('jenisKegiatan');
            
            if (!jenisKegiatanInput) {
                showNotification('Form input tidak ditemukan', 'error');
                return;
            }
            
            const jenisKegiatan = jenisKegiatanInput.value.trim();
            
            if (!jenisKegiatan) {
                showNotification('Jenis kegiatan harus diisi', 'error');
                return;
            }
        
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch('/api/jenis-kegiatan', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        jenis_kegiatan: jenisKegiatan
                    })
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        showNotification('Session expired. Please login again.', 'error');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
        
                if (result.success) {
                    closeJenisKegiatanModal();
                    showNotification(result.message || 'Jenis kegiatan berhasil ditambahkan!', 'success');
                    
                    // Kembali ke list Jenis Kegiatan dan reload data setelah berhasil simpan
                    setTimeout(() => {
                        showJenisKegiatan();
                        loadJenisKegiatanData();
                    }, 1000);
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menyimpan data: ' + error.message, 'error');
            }
        }
        
        // Edit Jenis Kegiatan
        function editJenisKegiatan(id) {
            const item = jenisKegiatanData.find(item => item.id === id);
            if (item) {
                editingId = id;
                
                // Fill form with existing data
                const idInput = document.getElementById('editJenisKegiatanId');
                const nipInput = document.getElementById('editUserNip');
                const golonganInput = document.getElementById('editUserGolongan');
                const jenisKegiatanInput = document.getElementById('editJenisKegiatanNama');
                
                if (idInput) idInput.value = item.id;
                if (nipInput) nipInput.value = item.nip;
                if (golonganInput) golonganInput.value = item.golongan;
                if (jenisKegiatanInput) jenisKegiatanInput.value = item.jenis_kegiatan;
                
                const modal = document.getElementById('editJenisKegiatanModal');
                if (modal) modal.classList.remove('hidden');
            }
        }
        
        // Update Jenis Kegiatan
        async function updateJenisKegiatan(event) {
            event.preventDefault();
            
            const idInput = document.getElementById('editJenisKegiatanId');
            const jenisKegiatanInput = document.getElementById('editJenisKegiatanNama');
            
            if (!idInput || !jenisKegiatanInput) {
                showNotification('Form input tidak ditemukan', 'error');
                return;
            }
            
            const id = idInput.value;
            const jenisKegiatan = jenisKegiatanInput.value.trim();
            
            if (!jenisKegiatan) {
                showNotification('Jenis kegiatan harus diisi', 'error');
                return;
            }
        
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch(`/api/jenis-kegiatan/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        jenis_kegiatan: jenisKegiatan
                    })
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        showNotification('Session expired. Please login again.', 'error');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
        
                if (result.success) {
                    closeEditJenisKegiatanModal();
                    showNotification(result.message || 'Jenis kegiatan berhasil diupdate!', 'success');
                    
                    // Kembali ke list Jenis Kegiatan dan reload data setelah berhasil update
                    setTimeout(() => {
                        showJenisKegiatan();
                        loadJenisKegiatanData();
                    }, 1000);
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengupdate data: ' + error.message, 'error');
            }
        }
        
        // Delete Jenis Kegiatan
        async function deleteJenisKegiatan(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus jenis kegiatan ini?')) {
                return;
            }
        
            try {
                const token = getAuthToken();
                
                if (!token) {
                    alert('Session expired. Please login again.');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch(`/api/jenis-kegiatan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        alert('Session expired. Please login again.');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
        
                if (result.success) {
                    showNotification(result.message || 'Jenis kegiatan berhasil dihapus!', 'success');
                    loadJenisKegiatanData();
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menghapus data: ' + error.message, 'error');
            }
        }
        
        // Hide all sections
        function hideAllSections() {
            const sections = document.querySelectorAll('.data-section');
            sections.forEach(section => section.classList.add('hidden'));
        }
        
        // Show Jenis Kegiatan Section
        function showJenisKegiatan() {
            hideAllSections();
            document.getElementById('jenisKegiatanSection').classList.remove('hidden');
            loadJenisKegiatanData();
        }
        
        // Show Welcome Section
        function showWelcomeSection() {
            hideAllSections();
            document.getElementById('welcomeSection').classList.remove('hidden');
        }
        
        // Show Unit/Ruangan Section
        function showUnitRuangan() {
            hideAllSections();
            document.getElementById('unitRuanganSection').classList.remove('hidden');
            loadUnitRuanganData();
        }
        
        // Load Unit/Ruangan Data
        async function loadUnitRuanganData() {
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch('/api/unit-ruangan', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        showNotification('Session expired. Please login again.', 'error');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
                renderUnitRuanganTable(result.data || []);
            } catch (error) {
                console.error('Error loading unit ruangan data:', error);
                showNotification('Terjadi kesalahan saat memuat data: ' + error.message, 'error');
            }
        }
        
        // Render Unit/Ruangan Table
        function renderUnitRuanganTable(unitRuanganData) {
            const tbody = document.getElementById('unitRuanganTableBody');
            
            if (!unitRuanganData || unitRuanganData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-building text-2xl text-gray-400"></i>
                                </div>
                                <div class="text-gray-400">
                                    <p class="text-lg font-medium">Belum ada data unit/ruangan</p>
                                    <p class="text-sm">Klik tombol "Tambah Unit/Ruangan" untuk menambah data</p>
                                </div>
                                <button onclick="openAddUnitRuanganModal()" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Unit/Ruangan
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
        
            tbody.innerHTML = unitRuanganData.map(item => `
                <tr class="border-b border-gray-600 hover:bg-gray-700/30 transition-all">
                    <td class="py-3 px-4">${item.id}</td>
                    <td class="py-3 px-4">${item.nip}</td>
                    <td class="py-3 px-4">${item.user ? item.user.name : 'N/A'}</td>
                    <td class="py-3 px-4">${item.nama_ruangan}</td>
                    <td class="py-3 px-4">${new Date(item.created_at).toLocaleDateString('id-ID')}</td>
                    <td class="py-3 px-4">
                        <div class="flex space-x-2">
                            <button onclick="editUnitRuangan(${item.id})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg transition-all">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteUnitRuangan(${item.id})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }
        
        // Load Users for Dropdown
        async function loadUsersForDropdown() {
            try {
                const token = getAuthToken();
                const response = await fetch('/api/admin/users', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    return result.data || [];
                } else {
                    console.error('Failed to load users');
                    return [];
                }
            } catch (error) {
                console.error('Error loading users:', error);
                return [];
            }
        }

        // Open Add Unit/Ruangan Modal
        async function openAddUnitRuanganModal() {
            const user = await getCurrentUser();
            if (user) {
                document.getElementById('userNipRuangan').value = user.nip || '';
                document.getElementById('userNamaRuangan').value = user.name || '';
            }
            document.getElementById('unitRuanganModal').classList.remove('hidden');
        }
        
        // Handle user selection change
        function onUserSelectChange() {
            const userSelect = document.getElementById('userSelectRuangan');
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            
            if (selectedOption.value) {
                document.getElementById('userNipRuangan').value = selectedOption.value;
                document.getElementById('userNamaRuangan').value = selectedOption.dataset.name || '';
            } else {
                document.getElementById('userNipRuangan').value = '';
                document.getElementById('userNamaRuangan').value = '';
            }
        }
        
        // Close Unit/Ruangan Modal
        function closeUnitRuanganModal() {
            document.getElementById('unitRuanganModal').classList.add('hidden');
            document.getElementById('unitRuanganForm').reset();
        }
        
        // Submit Unit/Ruangan
        async function submitUnitRuangan(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const namaRuangan = formData.get('nama_ruangan');
            
            if (!namaRuangan.trim()) {
                showNotification('Nama ruangan harus diisi!', 'error');
                return;
            }
            
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch('/api/unit-ruangan', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nama_ruangan: namaRuangan
                    })
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        showNotification('Session expired. Please login again.', 'error');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
        
                if (result.success) {
                    closeUnitRuanganModal();
                    showNotification(result.message || 'Unit/Ruangan berhasil ditambahkan!', 'success');
                    loadUnitRuanganData();
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menyimpan data: ' + error.message, 'error');
            }
        }
        
        // Edit Unit/Ruangan
        async function editUnitRuangan(id) {
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch(`/api/unit-ruangan/${id}`, {
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
                
                if (result.success) {
                    const data = result.data;
                    document.getElementById('editUnitRuanganId').value = data.id;
                    document.getElementById('editUserNipRuangan').value = data.nip;
                    document.getElementById('editNamaRuangan').value = data.nama_ruangan;
                    document.getElementById('editUnitRuanganModal').classList.remove('hidden');
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengambil data: ' + error.message, 'error');
            }
        }
        
        // Close Edit Unit/Ruangan Modal
        function closeEditUnitRuanganModal() {
            document.getElementById('editUnitRuanganModal').classList.add('hidden');
            document.getElementById('editUnitRuanganForm').reset();
        }
        
        // Update Unit/Ruangan
        async function updateUnitRuangan(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const id = formData.get('id');
            const namaRuangan = formData.get('nama_ruangan');
            
            if (!namaRuangan.trim()) {
                showNotification('Nama ruangan harus diisi!', 'error');
                return;
            }
            
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch(`/api/unit-ruangan/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nama_ruangan: namaRuangan
                    })
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        showNotification('Session expired. Please login again.', 'error');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
        
                if (result.success) {
                    closeEditUnitRuanganModal();
                    showNotification(result.message || 'Unit/Ruangan berhasil diupdate!', 'success');
                    loadUnitRuanganData();
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengupdate data: ' + error.message, 'error');
            }
        }
        
        // Delete Unit/Ruangan
        async function deleteUnitRuangan(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus unit/ruangan ini?')) {
                return;
            }
        
            try {
                const token = getAuthToken();
                
                if (!token) {
                    showNotification('Session expired. Please login again.', 'error');
                    window.location.href = '/login';
                    return;
                }
        
                const response = await fetch(`/api/unit-ruangan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
        
                if (!response.ok) {
                    if (response.status === 401) {
                        showNotification('Session expired. Please login again.', 'error');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
        
                const result = await response.json();
        
                if (result.success) {
                    showNotification(result.message || 'Unit/Ruangan berhasil dihapus!', 'success');
                    loadUnitRuanganData();
                } else {
                    showNotification(result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menghapus data: ' + error.message, 'error');
            }
        }
        
        // Get auth token
        function getAuthToken() {
            return localStorage.getItem('token') || sessionStorage.getItem('token');
        }
        
        // Show notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
                notification.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle"></i>
                        <span>${message}</span>
                    </div>
                `;
            } else if (type === 'error') {
                notification.className += ' bg-red-500 text-white';
                notification.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>${message}</span>
                    </div>
                `;
            }
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', async function() {
            await getCurrentUser();
            showWelcomeSection();
        });
    </script>
</body>
</html>

<!-- Modal Add Unit/Ruangan -->
<div id="unitRuanganModal" class="modal fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-content rounded-2xl p-6 w-full max-w-md">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Tambah Unit/Ruangan</h3>
                <button onclick="closeUnitRuanganModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="unitRuanganForm" onsubmit="submitUnitRuangan(event)">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                    <input type="text" id="userNipRuangan" name="nip" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pegawai</label>
                    <input type="text" id="userNamaRuangan" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Ruangan</label>
                    <input type="text" id="namaRuangan" name="nama_ruangan" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                           placeholder="Masukkan nama ruangan">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUnitRuanganModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Unit/Ruangan -->
<div id="editUnitRuanganModal" class="modal fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-content rounded-2xl p-6 w-full max-w-md">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Edit Unit/Ruangan</h3>
                <button onclick="closeEditUnitRuanganModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editUnitRuanganForm" onsubmit="updateUnitRuangan(event)">
                <input type="hidden" id="editUnitRuanganId" name="id">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                    <input type="text" id="editUserNipRuangan" name="nip" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Ruangan</label>
                    <input type="text" id="editNamaRuangan" name="nama_ruangan" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                           placeholder="Masukkan nama ruangan">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditUnitRuanganModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>