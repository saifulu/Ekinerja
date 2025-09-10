<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - e-Kinerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Force sidebar to work on mobile - Enhanced */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 300px !important;
                height: 100vh !important;
                background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;
                z-index: 9999 !important;
                transform: translateX(-100%) !important;
                transition: all 0.3s ease !important;
                /* Override Tailwind classes */
                margin-left: 0 !important;
                display: block !important;
            }
            
            #sidebar.show {
                transform: translateX(0) !important;
            }
            
            /* Remove Tailwind transform classes on mobile */
            #sidebar.transform {
                transform: translateX(-100%) !important;
            }
            
            #sidebar.show.transform {
                transform: translateX(0) !important;
            }
            
            #sidebarOverlay {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
                background: rgba(0, 0, 0, 0.5) !important;
                z-index: 9998 !important;
                display: block !important;
            }
            
            #sidebarOverlay.hidden {
                display: none !important;
            }
        }
        
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #667eea 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .gradient-blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .gradient-orange {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        }
        
        .gradient-green {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .slide-in {
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-scale:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .neon-glow {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }
        
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e40af 0%, #3730a3 50%, #1e1b4b 100%);
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.3); }
            50% { box-shadow: 0 0 30px rgba(102, 126, 234, 0.6); }
        }
        
        /* Extra small mobile screens */
        @media (max-width: 480px) {
            .morphism-card {
                padding: 0.5rem;
                margin-bottom: 0.5rem;
            }
            
            .text-3xl {
                font-size: 1rem;
            }
            
            .text-2xl {
                font-size: 0.875rem;
            }
            
            .text-xl {
                font-size: 0.75rem;
            }
            
            .text-lg {
                font-size: 0.625rem;
            }
            
            .stats-counter {
                font-size: 1.25rem !important;
            }
            
            .w-10, .h-10 {
                width: 1.5rem;
                height: 1.5rem;
            }
            
            .w-12, .h-12 {
                width: 1.75rem;
                height: 1.75rem;
            }
            
            .gap-3 {
                gap: 0.25rem;
            }
            
            .space-x-2 > :not([hidden]) ~ :not([hidden]) {
                margin-left: 0.25rem;
            }
            
            .mb-3 {
                margin-bottom: 0.5rem;
            }
            
            .mb-4 {
                margin-bottom: 0.75rem;
            }
        }
        
        /* Mobile layout */
        @media (max-width: 1024px) {
            .min-h-screen.flex {
                flex-direction: column;
            }
            
            .flex-1 {
                width: 100vw !important;
                max-width: 100vw !important;
            }
        }
        
        @media (max-width: 640px) {
            #sidebar {
                width: 100vw !important;
                max-width: 320px !important;
            }
            
            .morphism-card {
                padding: 0.75rem;
            }
            
            .text-4xl {
                font-size: 1.75rem;
            }
            
            .text-3xl {
                font-size: 1.25rem;
            }
            
            .text-2xl {
                font-size: 1.125rem;
            }
            
            .text-xl {
                font-size: 1rem;
            }
            
            .text-lg {
                font-size: 0.875rem;
            }
            
            .gap-8 {
                gap: 0.75rem;
            }
            
            .gap-6 {
                gap: 0.5rem;
            }
            
            .mb-8 {
                margin-bottom: 1rem;
            }
            
            .mb-6 {
                margin-bottom: 0.75rem;
            }
            
            .p-8 {
                padding: 0.75rem;
            }
            
            .p-6 {
                padding: 0.5rem;
            }
            
            .p-4 {
                padding: 0.5rem;
            }
            
            /* Fix card layout for very small screens */
            .stats-counter {
                font-size: 1.5rem !important;
            }
            
            .w-12 {
                width: 2rem;
            }
            
            .h-12 {
                height: 2rem;
            }
            
            .w-10 {
                width: 1.75rem;
            }
            
            .h-10 {
                height: 1.75rem;
            }
        }
        
        @media (max-width: 768px) {
            .grid-cols-4 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .lg\\:grid-cols-4 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .lg\\:grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .md\\:grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }
        
        /* Touch-friendly improvements */
        @media (max-width: 768px) {
            button, .btn, a[role="button"] {
                min-height: 44px;
                min-width: 44px;
            }
            
            .nav-item {
                min-height: 48px;
            }
            
            .text-sm {
                font-size: 0.875rem;
            }
            
            .text-xs {
                font-size: 0.75rem;
            }
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Sidebar base styles */
        #sidebar {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100vh;
            background: #1e3a8a;
            z-index: 50;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        /* Desktop - sidebar always visible */
        @media (min-width: 1024px) {
            #sidebar {
                position: static;
                transform: translateX(0);
                width: 320px;
            }
        }
        
        /* Mobile - sidebar hidden by default */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 300px !important;
                height: 100vh !important;
                background: #1e3a8a !important;
                z-index: 60 !important; /* Lebih tinggi dari overlay */
                transform: translateX(-100%) !important;
                transition: transform 0.3s ease !important;
            }
            
            #sidebar.show {
                transform: translateX(0) !important;
            }
            
            #sidebarOverlay {
                z-index: 50 !important; /* Lebih rendah dari sidebar */
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
                background: rgba(0, 0, 0, 0.5) !important;
            }
            
            #sidebarOverlay.hidden {
                display: none !important;
            }
        }
        
        .morphism-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .progress-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            animation: progressAnimation 2s ease-in-out;
        }
        
        @keyframes progressAnimation {
            from { width: 0%; }
            to { width: var(--progress-width); }
        }
        
        .notification-badge {
            animation: bounce 1s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        .stats-counter {
            animation: countUp 2s ease-out;
        }
        
        @keyframes countUp {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen flex relative overflow-hidden w-full">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 4s;"></div>
        </div>
        
        <!-- Sidebar - Remove conflicting Tailwind classes -->
        <div id="sidebar" class="sidebar-gradient text-white w-80 min-h-screen p-4 sm:p-6 transition-all duration-500 ease-in-out lg:translate-x-0 lg:static lg:inset-0 glass-dark slide-in relative z-10 lg:block">
            <div class="flex items-center justify-between mb-8 sm:mb-12">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-blue rounded-xl flex items-center justify-center neon-glow">
                        <i class="fas fa-user text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-300">Personal Dashboard</p>
                    </div>
                </div>
                <button id="closeSidebar" class="lg:hidden p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-all">
                    <i class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>
            
            <nav class="space-y-2 sm:space-y-3">
                <a href="#" onclick="showDashboard()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-tachometer-alt text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Dashboard</span>
                        <p class="text-xs text-gray-300 truncate">Overview & Stats</p>
                    </div>
                </a>
                
                <a href="#" onclick="showProfile()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-green-400 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-cog text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Profil Saya</span>
                        <p class="text-xs text-gray-300 truncate">Personal Info</p>
                    </div>
                </a>
                
                <a href="/master-data" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-indigo-400 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-database text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Master Data</span>
                        <p class="text-xs text-gray-300 truncate">Data Management</p>
                    </div>
                </a>
                
                <a href="#" onclick="navigateToLaporan()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-orange-400 to-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-bar text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Laporan</span>
                        <p class="text-xs text-gray-300 truncate">Performance Reports</p>
                    </div>
                </a>
                
                <!-- Divider -->
                <div class="border-t border-white border-opacity-20 my-4"></div>
                
                <!-- Logout Menu -->
                <a href="#" onclick="logout()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-red-500 hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-red-400 to-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-sign-out-alt text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Logout</span>
                        <p class="text-xs text-gray-300 truncate">Sign Out</p>
                    </div>
                </a>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="morphism-card rounded-xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-green rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Waktu Kerja</p>
                            <p class="text-xs text-green-300" id="workTime">08:00 - 17:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative z-10 w-full lg:w-auto">
            <!-- Top Navigation -->
            <nav class="glass backdrop-blur-xl border-b border-white border-opacity-20 w-full">
                <div class="w-full px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 sm:h-20">
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <button id="openSidebar" class="lg:hidden p-2 sm:p-3 hover:bg-white hover:bg-opacity-20 rounded-xl transition-all">
                                <i class="fas fa-bars text-white text-lg sm:text-xl"></i>
                            </button>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-white text-lg sm:text-2xl font-bold truncate">e-Kinerja Dashboard</h1>
                                <p class="text-gray-200 text-xs sm:text-sm hidden sm:block">Personal Workspace</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-6">
                            <div class="hidden sm:flex items-center space-x-4">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span id="userWelcome" class="text-white font-medium text-sm sm:text-base"></span>
                            </div>
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <button class="p-2 sm:p-3 glass rounded-xl hover:bg-white hover:bg-opacity-20 transition-all relative">
                                    <i class="fas fa-bell text-white text-sm sm:text-base"></i>
                                    <span class="absolute -top-1 -right-1 w-3 h-3 sm:w-4 sm:h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">2</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8 w-full">
                <!-- Dashboard Content -->
                <div id="dashboardContent" class="content-section fade-in">
                    <!-- Welcome Section -->
                    <div class="morphism-card rounded-2xl p-3 sm:p-4 lg:p-6 xl:p-8 mb-4 sm:mb-6 lg:mb-8 hover-scale">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                            <div class="flex-1 min-w-0">
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-1 sm:mb-2">Selamat Datang!</h2>
                                <p class="text-gray-200 text-sm sm:text-base lg:text-lg">Kelola aktivitas dan tugas Anda dengan mudah</p>
                                <div id="currentDateTime" class="text-gray-300 mt-1 sm:mt-2 text-xs sm:text-sm lg:text-base"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Kegiatan Section -->
                    <div class="morphism-card rounded-2xl p-3 sm:p-4 lg:p-6 xl:p-8 mb-4 sm:mb-6 lg:mb-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 gradient-green rounded-2xl flex items-center justify-center neon-glow">
                                <i class="fas fa-clipboard-list text-white text-lg sm:text-xl lg:text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white">Jenis Kegiatan</h3>
                                <p class="text-gray-300 text-sm sm:text-base">Daftar kegiatan berdasarkan NIP Anda</p>
                            </div>
                        </div>
                        
                        <div id="jenisKegiatanContainer">
                            <div class="glass rounded-xl p-4 sm:p-6">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <tbody id="jenisKegiatanTableBody">
                                            <!-- Data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="noDataMessage" class="text-center py-8 hidden">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-400">Tidak ada data jenis kegiatan untuk NIP Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div id="jenisKegiatanLoading" class="text-center py-8">
                            <div class="inline-flex items-center space-x-3">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-400"></div>
                                <span class="text-white">Memuat data jenis kegiatan...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Form Jenis Kegiatan -->
                <div id="jenisKegiatanModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
                    <div class="glass rounded-xl p-6 w-full max-w-md mx-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-white">Detail Jenis Kegiatan</h3>
                            <button id="closeModal" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <form id="jenisKegiatanForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Jenis Kegiatan</label>
                                <input type="text" id="jenisKegiatanInput" class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan jenis kegiatan">
                            </div>
                            
                            <div class="flex space-x-3 pt-4">
                                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-save mr-2"></i>Simpan
                                </button>
                                <button type="button" id="cancelModal" class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-700 transition-all duration-300">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Profile Content -->
                <div id="profileContent" class="content-section hidden fade-in">
                    <div class="morphism-card rounded-2xl p-8 hover-scale">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center neon-glow">
                                <i class="fas fa-user-cog text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white">Profil Saya</h2>
                                <p class="text-gray-300">Kelola informasi personal Anda</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div id="profileView">
                                <!-- Profile view will be loaded here -->
                            </div>
                            
                            <div id="profileEdit" class="hidden">
                                <!-- Profile edit form will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Content -->
                <div id="tasksContent" class="content-section hidden fade-in">
                    <div class="morphism-card rounded-2xl p-8 hover-scale">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 gradient-purple rounded-2xl flex items-center justify-center neon-glow">
                                    <i class="fas fa-tasks text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-white">Tugas Saya</h2>
                                    <p class="text-gray-300">Kelola dan pantau progress tugas</p>
                                </div>
                            </div>
                            <button class="px-6 py-3 gradient-purple rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300 neon-glow">
                                <i class="fas fa-plus mr-2"></i>Tugas Baru
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Task cards will be loaded here -->
                            <div class="glass rounded-xl p-6 card-hover">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-blue-500 text-white text-xs rounded-full">In Progress</span>
                                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Laporan Kinerja Q1</h4>
                                <p class="text-gray-300 text-sm mb-4">Menyusun laporan kinerja triwulan pertama</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-xs">Deadline: 15 Mar</span>
                                    <div class="w-16 h-2 bg-gray-600 rounded-full overflow-hidden">
                                        <div class="w-3/4 h-full gradient-blue rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="glass rounded-xl p-6 card-hover">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-orange-500 text-white text-xs rounded-full">Pending</span>
                                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Presentasi Project</h4>
                                <p class="text-gray-300 text-sm mb-4">Persiapan presentasi untuk stakeholder</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-xs">Deadline: 20 Mar</span>
                                    <div class="w-16 h-2 bg-gray-600 rounded-full overflow-hidden">
                                        <div class="w-1/4 h-full gradient-orange rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="glass rounded-xl p-6 card-hover">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs rounded-full">Completed</span>
                                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Review Dokumen</h4>
                                <p class="text-gray-300 text-sm mb-4">Review dan approval dokumen tim</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-xs">Selesai: 10 Mar</span>
                                    <div class="w-16 h-2 bg-gray-600 rounded-full overflow-hidden">
                                        <div class="w-full h-full gradient-green rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reports Content -->
                <div id="reportsContent" class="content-section hidden fade-in">
                    <div class="morphism-card rounded-2xl p-8 hover-scale">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-16 h-16 gradient-orange rounded-2xl flex items-center justify-center neon-glow">
                                <i class="fas fa-chart-bar text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white">Laporan Kinerja</h2>
                                <p class="text-gray-300">Analisis dan statistik performa Anda</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="glass rounded-xl p-6">
                                <h4 class="text-white font-semibold mb-4">Performa Bulanan</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300">Januari</span>
                                        <span class="text-green-400 font-semibold">95%</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300">Februari</span>
                                        <span class="text-blue-400 font-semibold">88%</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300">Maret</span>
                                        <span class="text-purple-400 font-semibold">92%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="glass rounded-xl p-6">
                                <h4 class="text-white font-semibold mb-4">Target vs Realisasi</h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-gray-300">Target Bulanan</span>
                                            <span class="text-white">100%</span>
                                        </div>
                                        <div class="w-full h-3 bg-gray-600 rounded-full overflow-hidden">
                                            <div class="h-full gradient-green rounded-full" style="width: 92%;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-gray-300">Realisasi</span>
                                            <span class="text-white">92%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="morphism-card rounded-2xl p-8 flex items-center space-x-4">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-400"></div>
            <span class="text-white text-lg font-semibold">Memproses...</span>
        </div>
    </div>

    <script>
        // Check if user is logged in
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        
        console.log('Dashboard - Token check:', !!token);
        console.log('Dashboard - User data:', user);
        
        if (!token) {
            console.log('Dashboard - No token, redirecting to login');
            window.location.href = '/login';
        } else if (user.role === 'admin') {
            console.log('Dashboard - Admin user, redirecting to admin dashboard');
            window.location.href = '/dashboard';
        } else {
            console.log('Dashboard - Regular user, loading dashboard');
            document.getElementById('userWelcome').textContent = `${user.name}`;
            updateDateTime();
            loadJenisKegiatan();
        }
        
        // Enhanced sidebar toggle - Override Tailwind classes
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            console.log('Toggle sidebar clicked');
            
            if (!sidebar || !overlay) {
                console.error('Sidebar or overlay element not found');
                return;
            }
            
            const isVisible = sidebar.classList.contains('show');
            console.log('Sidebar currently visible:', isVisible);
            
            if (isVisible) {
                // Hide sidebar
                sidebar.classList.remove('show');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
                console.log('Hiding sidebar');
            } else {
                // Show sidebar - Force override Tailwind
                sidebar.classList.add('show');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Force styles to override Tailwind
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.zIndex = '9999';
                sidebar.style.position = 'fixed';
                sidebar.style.display = 'block';
                
                overlay.style.display = 'block';
                overlay.style.zIndex = '9998';
                
                console.log('Showing sidebar with forced styles');
            }
        }
        
        // Update current date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
        }
        
        // Update time every minute
        setInterval(updateDateTime, 60000);
        
        // Function to navigate to laporan
        function navigateToLaporan() {
            const token = localStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            console.log('Navigating to laporan - Token:', !!token);
            console.log('Navigating to laporan - User NIP:', user.nip);
            
            if (!token || !user.nip) {
                alert('Sesi Anda telah berakhir atau data tidak lengkap. Silakan login kembali.');
                window.location.href = '/login';
                return;
            }
            
            // Navigate to laporan with NIP parameter
            window.location.href = `/laporan?nip=${user.nip}`;
        }
        
        // Function to load jenis kegiatan data
        async function loadJenisKegiatan() {
            const token = localStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            console.log('Loading jenis kegiatan for user:', user);
            console.log('User NIP:', user.nip);
            console.log('Token exists:', !!token);
            
            if (!token) {
                console.log('No token found');
                showNoDataMessage('Token tidak ditemukan. Silakan login ulang.');
                return;
            }
            
            if (!user.nip) {
                console.log('No NIP found for user');
                showNoDataMessage('NIP tidak ditemukan. Silakan lengkapi profil Anda.');
                return;
            }
            
            const loadingElement = document.getElementById('jenisKegiatanLoading');
            const containerElement = document.getElementById('jenisKegiatanContainer');
            const tableBody = document.getElementById('jenisKegiatanTableBody');
            const noDataMessage = document.getElementById('noDataMessage');
            
            // Validate elements exist
            if (!loadingElement || !containerElement || !tableBody || !noDataMessage) {
                console.error('Required DOM elements not found');
                return;
            }
            
            // Show loading
            loadingElement.classList.remove('hidden');
            containerElement.classList.add('hidden');
            noDataMessage.classList.add('hidden');
            
            try {
                console.log('Fetching data from /api/jenis-kegiatan...');
                const response = await fetch('/api/jenis-kegiatan', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                console.log('API Response status:', response.status);
                console.log('API Response headers:', response.headers);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('API Error Response:', errorText);
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const result = await response.json();
                console.log('API Response result:', result);
                
                // Handle different response formats
                let data = result;
                if (result.data) {
                    data = result.data;
                } else if (Array.isArray(result)) {
                    data = result;
                } else {
                    console.error('Unexpected response format:', result);
                    throw new Error('Format response tidak valid');
                }
                
                console.log('Processing data:', data);
                
                if (!Array.isArray(data)) {
                    console.error('Data is not an array:', data);
                    throw new Error('Data yang diterima bukan array');
                }
                
                // Filter data by user's NIP (convert both to string for comparison)
                const userJenisKegiatan = data.filter(item => {
                    const itemNip = String(item.nip || '').trim();
                    const userNip = String(user.nip || '').trim();
                    console.log(`Comparing: "${itemNip}" === "${userNip}"`);
                    return itemNip === userNip;
                });
                
                console.log('Filtered data for user:', userJenisKegiatan);
                console.log('Total items found:', userJenisKegiatan.length);
                
                // Clear table body
                tableBody.innerHTML = '';
                
                if (userJenisKegiatan.length === 0) {
                    console.log('No data found for user NIP:', user.nip);
                    showNoDataMessage('Tidak ada data jenis kegiatan untuk NIP Anda');
                } else {
                    console.log('Displaying', userJenisKegiatan.length, 'items');
                    noDataMessage.classList.add('hidden');
                    
                    userJenisKegiatan.forEach((item, index) => {
                        console.log(`Rendering item ${index + 1}:`, item);
                        
                        const row = document.createElement('tr');
                        row.className = 'border-b border-white border-opacity-10 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 hover:bg-opacity-80 transition-all duration-300 cursor-pointer transform hover:scale-[1.02]';
                        
                        row.innerHTML = `
                            <td class="py-3 px-2 text-white font-medium text-sm sm:text-base hover:text-white transition-colors duration-300">${item.jenis_kegiatan || '-'}</td>
                        `;
                        
                        // Add click event listener to row for page navigation
                        row.addEventListener('click', function() {
                            console.log('Clicked item data:', item);
                            console.log('Jenis Kegiatan:', item.jenis_kegiatan);
                            console.log('Golongan:', item.golongan);
                            console.log('NIP:', item.nip);
                            
                            // Pastikan semua field ada
                            const dataToSend = {
                                jenis_kegiatan: item.jenis_kegiatan || '',
                                golongan: item.golongan || '',
                                nip: item.nip || ''
                            };
                            
                            // Navigate to detail page with jenis kegiatan data
                            const jenisKegiatanData = encodeURIComponent(JSON.stringify(dataToSend));
                            console.log('Encoded data:', jenisKegiatanData);
                            console.log('Full URL:', `/jenis-kegiatan/detail?data=${jenisKegiatanData}`);
                            window.location.href = `/jenis-kegiatan/detail?data=${jenisKegiatanData}`;
                        });
                        
                        tableBody.appendChild(row);
                    });
                }
                
                // Show container
                containerElement.classList.remove('hidden');
                
            } catch (error) {
                console.error('Error loading jenis kegiatan:', error);
                showNoDataMessage(`Error memuat data: ${error.message}`);
                containerElement.classList.remove('hidden');
            } finally {
                // Hide loading
                loadingElement.classList.add('hidden');
            }
        }
        
        // Function to open modal
        function openJenisKegiatanModal(data) {
            const modal = document.getElementById('jenisKegiatanModal');
            const input = document.getElementById('jenisKegiatanInput');
            
            if (modal && input) {
                input.value = data.jenis_kegiatan || '';
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
        
        // Function to close modal
        function closeJenisKegiatanModal() {
            const modal = document.getElementById('jenisKegiatanModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
        
        // Modal event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const closeModalBtn = document.getElementById('closeModal');
            const cancelModalBtn = document.getElementById('cancelModal');
            const modal = document.getElementById('jenisKegiatanModal');
            const form = document.getElementById('jenisKegiatanForm');
            
            // Close modal events
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeJenisKegiatanModal);
            }
            
            if (cancelModalBtn) {
                cancelModalBtn.addEventListener('click', closeJenisKegiatanModal);
            }
            
            // Close modal when clicking outside
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeJenisKegiatanModal();
                    }
                });
            }
            
            // Form submit event
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const jenisKegiatan = document.getElementById('jenisKegiatanInput').value;
                    
                    if (jenisKegiatan.trim()) {
                        // Here you can add logic to save the data
                        console.log('Saving jenis kegiatan:', jenisKegiatan);
                        closeJenisKegiatanModal();
                        // Optionally reload the data
                        loadJenisKegiatan();
                    } else {
                        alert('Mohon isi jenis kegiatan');
                    }
                });
            }
        });
        
        // Helper function to show no data message
        function showNoDataMessage(message) {
            const noDataMessage = document.getElementById('noDataMessage');
            if (noDataMessage) {
                noDataMessage.innerHTML = `
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-4"></i>
                    <p class="text-yellow-400 font-medium">${message}</p>
                    <p class="text-gray-400 text-sm mt-2">Silakan refresh halaman atau hubungi administrator jika masalah berlanjut</p>
                `;
                noDataMessage.classList.remove('hidden');
            }
        }
        
        // Content switching with animations
        function hideAllContent() {
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden');
            });
        }
        
        function showDashboard() {
            hideAllContent();
            const content = document.getElementById('dashboardContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
        }
        
        function showProfile() {
            hideAllContent();
            const content = document.getElementById('profileContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            loadProfile();
        }
        
        function showTasks() {
            hideAllContent();
            const content = document.getElementById('tasksContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
        }
        
        function showReports() {
            hideAllContent();
            const content = document.getElementById('reportsContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
        }
        
        // Load profile
        function loadProfile() {
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            const profileView = document.getElementById('profileView');
            if (!profileView) {
                console.error('Profile view element not found');
                return;
            }
            
            // Check if user data exists
            if (!user || !user.name) {
                profileView.innerHTML = `
                    <div class="glass rounded-xl p-6 mb-6">
                        <div class="text-center py-8">
                            <i class="fas fa-user-slash text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-white font-semibold mb-2">Data Profil Tidak Ditemukan</h3>
                            <p class="text-gray-300 mb-4">Silakan login ulang untuk memuat data profil Anda.</p>
                            <button onclick="window.location.href='/login'" class="px-6 py-3 gradient-blue rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300">
                                Login Ulang
                            </button>
                        </div>
                    </div>
                `;
                return;
            }
            
            profileView.innerHTML = `
                <div class="glass rounded-xl p-6 mb-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-20 h-20 rounded-full gradient-blue flex items-center justify-center text-2xl font-bold text-white">
                            ${user.name ? user.name.charAt(0).toUpperCase() : 'U'}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">${user.name || 'Nama tidak tersedia'}</h3>
                            <p class="text-gray-300">${user.email || 'Email tidak tersedia'}</p>
                            <p class="text-blue-400 text-sm">${user.role === 'admin' ? 'Administrator' : 'User'}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex justify-between items-center p-3 glass rounded-lg">
                            <span class="text-gray-300">NIP</span>
                            <span class="text-white">${user.nip || 'Belum diisi'}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 glass rounded-lg">
                            <span class="text-gray-300">Golongan</span>
                            <span class="text-white">${user.golongan || 'Belum diisi'}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 glass rounded-lg">
                            <span class="text-gray-300">Instansi</span>
                            <span class="text-white">${user.instansi || 'Belum diisi'}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 glass rounded-lg">
                            <span class="text-gray-300">Ruangan</span>
                            <span class="text-white">${user.ruangan || 'Belum diisi'}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 glass rounded-lg">
                            <span class="text-gray-300">Telepon</span>
                            <span class="text-white">${user.phone || 'Belum diisi'}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 glass rounded-lg">
                            <span class="text-gray-300">Bergabung Sejak</span>
                            <span class="text-white">${new Date().toLocaleDateString('id-ID')}</span>
                        </div>
                    </div>
                    
                    <button onclick="showEditProfile()" class="w-full mt-6 px-6 py-3 gradient-blue rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </button>
                </div>
                
                <div class="glass rounded-xl p-6">
                    <h4 class="text-xl font-bold text-white mb-6">Statistik Aktivitas</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Total Login</span>
                            <span class="text-blue-400 font-semibold">24 kali</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Tugas Selesai</span>
                            <span class="text-green-400 font-semibold">12 tugas</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Rata-rata Kinerja</span>
                            <span class="text-purple-400 font-semibold">92%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Status Akun</span>
                            <span class="text-green-400 font-semibold">Aktif</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Show edit profile form
        function showEditProfile() {
            const user = JSON.parse(localStorage.getItem('user'));
            document.getElementById('profileView').classList.add('hidden');
            document.getElementById('profileEdit').classList.remove('hidden');
            
            document.getElementById('profileEdit').innerHTML = `
        <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 w-full">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-white">Edit Profil</h3>
                <button onclick="cancelEditProfile()" class="p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-all">
                    <i class="fas fa-times text-white text-lg"></i>
                </button>
            </div>
            
            <form id="editProfileForm" class="space-y-6">
                <!-- Personal Information Section -->
                <div class="bg-white bg-opacity-5 rounded-xl p-4 sm:p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-400"></i>
                        Informasi Personal
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-white mb-2">Nama Lengkap *</label>
                            <input type="text" id="editName" value="${user.name || ''}" required
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-white mb-2">Email *</label>
                            <input type="email" id="editEmail" value="${user.email || ''}" required
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                        <div class="xl:col-span-2">
                            <label class="block text-sm font-semibold text-white mb-2">Nomor Telepon</label>
                            <input type="text" id="editPhone" value="${user.phone || ''}" placeholder="08xxxxxxxxxx"
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                    </div>
                </div>
                
                <!-- Work Information Section -->
                <div class="bg-white bg-opacity-5 rounded-xl p-4 sm:p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-briefcase mr-2 text-green-400"></i>
                        Informasi Kepegawaian
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">NIP</label>
                            <input type="text" id="editNip" value="${user.nip || ''}" placeholder="Nomor Induk Pegawai"
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Golongan</label>
                            <input type="text" id="editGolongan" value="${user.golongan || ''}" placeholder="Contoh: III/a"
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Instansi</label>
                            <input type="text" id="editInstansi" value="${user.instansi || ''}" placeholder="Nama Instansi"
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Ruangan</label>
                            <input type="text" id="editRuangan" value="${user.ruangan || ''}" placeholder="Nama Ruangan/Unit"
                                   class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm sm:text-base">
                        </div>
                    </div>
                </div>
                        
                        <!-- Password Section -->
                        <div class="bg-white bg-opacity-5 rounded-xl p-4 sm:p-6">
                            <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <i class="fas fa-lock mr-2 text-yellow-400"></i>
                                Ubah Password (Opsional)
                            </h4>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-white mb-2">Password Saat Ini</label>
                                    <input type="password" id="editCurrentPassword" placeholder="Masukkan password saat ini"
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all text-sm sm:text-base">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-white mb-2">Password Baru</label>
                                    <input type="password" id="editNewPassword" placeholder="Masukkan password baru"
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all text-sm sm:text-base">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-white mb-2">Konfirmasi Password Baru</label>
                                    <input type="password" id="editNewPasswordConfirm" placeholder="Ulangi password baru"
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all text-sm sm:text-base">
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-yellow-500 bg-opacity-10 rounded-lg border border-yellow-500 border-opacity-30">
                                <p class="text-yellow-200 text-xs sm:text-sm flex items-start">
                                    <i class="fas fa-info-circle mr-2 mt-0.5 text-yellow-400"></i>
                                    Kosongkan field password jika tidak ingin mengubah password. Password harus minimal 8 karakter.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-6 border-t border-white border-opacity-20">
                            <button type="button" onclick="cancelEditProfile()" 
                                    class="flex-1 px-6 py-3 glass rounded-xl text-white hover:bg-white hover:bg-opacity-20 transition-all duration-300 font-medium text-sm sm:text-base">
                                <i class="fas fa-times mr-2"></i>Batal
                            </button>
                            <button type="submit" 
                                    class="flex-1 px-6 py-3 gradient-blue rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300 neon-glow text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            `;
            
            // Add form submit handler
            document.getElementById('editProfileForm').addEventListener('submit', updateProfile);
        }
        
        // Cancel edit profile
        function cancelEditProfile() {
            document.getElementById('profileEdit').classList.add('hidden');
            document.getElementById('profileView').classList.remove('hidden');
        }
        
        // Update profile
        async function updateProfile(e) {
            e.preventDefault();
            
            const name = document.getElementById('editName').value;
            const email = document.getElementById('editEmail').value;
            const nip = document.getElementById('editNip').value;
            const golongan = document.getElementById('editGolongan').value;
            const instansi = document.getElementById('editInstansi').value;
            const ruangan = document.getElementById('editRuangan').value;
            const phone = document.getElementById('editPhone').value;
            const currentPassword = document.getElementById('editCurrentPassword').value;
            const newPassword = document.getElementById('editNewPassword').value;
            const newPasswordConfirm = document.getElementById('editNewPasswordConfirm').value;
            
            // Validate passwords match if provided
            if (newPassword && newPassword !== newPasswordConfirm) {
                alert('Password baru dan konfirmasi password tidak cocok!');
                return;
            }
            
            // Validate current password if new password is provided
            if (newPassword && !currentPassword) {
                alert('Password saat ini harus diisi untuk mengubah password!');
                return;
            }
            
            showLoading();
            
            const updateData = { name, email, nip, golongan, instansi, ruangan, phone };
            if (newPassword) {
                updateData.current_password = currentPassword;
                updateData.new_password = newPassword;
                updateData.new_password_confirmation = newPasswordConfirm;
            }
            
            try {
                const response = await fetch('/api/auth/profile', {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(updateData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    localStorage.setItem('user', JSON.stringify(result.data));
                    alert('Profil berhasil diperbarui!');
                    cancelEditProfile();
                    loadProfile();
                } else {
                    alert('Error: ' + (result.message || 'Gagal memperbarui profil'));
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                alert('Terjadi kesalahan saat memperbarui profil');
            } finally {
                hideLoading();
            }
        }
        
        // Utility functions
        function showLoading() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }
        
        function hideLoading() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }
        
        function logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }
        
        // Initialize dashboard
        showDashboard();
        
        // Add smooth scrolling and enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add onclick directly to buttons
            document.getElementById('openSidebar').onclick = toggleSidebar;
            document.getElementById('closeSidebar').onclick = toggleSidebar;
            document.getElementById('sidebarOverlay').onclick = toggleSidebar;
            
            // Add hover effects to navigation items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
            
            // Add parallax effect to background elements
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelectorAll('.floating');
                const speed = 0.5;
                
                parallax.forEach(element => {
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
            });
        });
    </script>
</body>
</html>
</html>
</html>
</html>
</html>