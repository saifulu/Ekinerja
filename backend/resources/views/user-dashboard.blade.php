<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - e-Kinerja</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: linear-gradient(135deg, #2563eb 0%, #0891b2 100%);
        }
        
        .gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .gradient-orange {
            background: linear-gradient(135deg, #ea580c 0%, #d97706 100%);
        }
        
        .gradient-green {
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%);
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
        
        .dashboard-main {
            min-width: 0;
            width: 100%;
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

        .user-dashboard-theme {
            background: linear-gradient(145deg, #0f172a 0%, #312e81 52%, #172554 100%);
            color: #f8fafc;
        }

        .user-dashboard-theme .glass {
            background: rgba(15, 23, 42, 0.72);
            border-color: rgba(255, 255, 255, 0.24);
            box-shadow: 0 12px 32px rgba(2, 6, 23, 0.24);
        }

        .user-dashboard-theme .morphism-card {
            background: rgba(30, 41, 59, 0.82);
            border-color: rgba(255, 255, 255, 0.22);
            box-shadow: 0 16px 40px rgba(2, 6, 23, 0.3);
        }

        .user-dashboard-theme .text-gray-200 { color: #f1f5f9; }
        .user-dashboard-theme .text-gray-300 { color: #e2e8f0; }
        .user-dashboard-theme .text-gray-400 { color: #cbd5e1; }
        .user-dashboard-theme .text-white { color: #ffffff; }

        .user-dashboard-theme input.glass,
        .user-dashboard-theme select.glass,
        .user-dashboard-theme textarea.glass {
            background: rgba(15, 23, 42, 0.92);
            border: 1px solid rgba(203, 213, 225, 0.55);
            color: #ffffff;
        }

        .user-dashboard-theme input::placeholder,
        .user-dashboard-theme textarea::placeholder {
            color: #cbd5e1;
            opacity: 1;
        }

        .user-dashboard-theme select option {
            background: #0f172a;
            color: #ffffff;
        }

        .profile-form-section {
            background: #111827;
            border: 1px solid #475569;
            box-shadow: 0 10px 24px rgba(2, 6, 23, 0.24);
        }

        .profile-form-section label,
        .profile-form-section h4 {
            color: #f8fafc;
        }

        .profile-password-note {
            background: rgba(146, 64, 14, 0.35);
            border: 1px solid #f59e0b;
            color: #fef3c7;
        }

        .user-dashboard-theme #jenisKegiatanInput {
            background: #0f172a;
            border-color: #64748b;
            color: #ffffff;
        }

        .quick-menu-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.96), rgba(49, 46, 129, 0.82));
            border: 1px solid rgba(226, 232, 240, 0.3);
            box-shadow: 0 12px 28px rgba(2, 6, 23, 0.28);
        }

        .quick-menu-card:hover {
            background: linear-gradient(145deg, rgba(51, 65, 85, 0.98), rgba(67, 56, 202, 0.88));
            border-color: rgba(255, 255, 255, 0.55);
        }

        .quick-card-emerald {
            background: linear-gradient(145deg, rgba(6, 78, 59, 0.75), rgba(15, 23, 42, 0.95)) !important;
            border-color: rgba(16, 185, 129, 0.5) !important;
        }
        .quick-card-emerald:hover {
            background: linear-gradient(145deg, rgba(6, 78, 59, 0.92), rgba(15, 23, 42, 0.98)) !important;
            border-color: rgba(52, 211, 153, 0.8) !important;
            box-shadow: 0 14px 30px rgba(16, 185, 129, 0.3) !important;
        }
        
        @keyframes countUp {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
    @include('partials.mobile-ux')
    <style>
        /* Specific mobile layout optimizations */
        @media (max-width: 767px) {
            #activitiesSection table {
                min-width: 100% !important;
            }
            #activitiesSection th, #activitiesSection td {
                white-space: normal !important;
            }
        }
    </style>
</head>
<body class="user-dashboard-theme min-h-screen">
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
                <button type="button" onclick="showDashboard()" data-section="dashboard" class="nav-item w-full text-left flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-tachometer-alt text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Dashboard</span>
                        <p class="text-xs text-gray-300 truncate">Overview & Stats</p>
                    </div>
                </button>
                
                <button type="button" onclick="showMasterKegiatan()" data-section="master-kegiatan" class="nav-item w-full text-left flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-emerald-400 to-teal-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-clipboard-list text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Input Kegiatan</span>
                        <p class="text-xs text-gray-300 truncate">Catat Kegiatan & Logbook</p>
                    </div>
                </button>

                <button type="button" onclick="showMasterUnit()" data-section="master-unit" class="nav-item w-full text-left flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-teal-400 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-hospital text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Master Unit</span>
                        <p class="text-xs text-gray-300 truncate">Kelola Unit & Ruangan</p>
                    </div>
                </button>
                
                <button type="button" onclick="showProfile()" data-section="profile" class="nav-item w-full text-left flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-green-400 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-cog text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Profil Saya</span>
                        <p class="text-xs text-gray-300 truncate">Personal Info</p>
                    </div>
                </button>
                
                <button type="button" onclick="navigateToLaporan()" class="nav-item w-full text-left flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-orange-400 to-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-bar text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Laporan</span>
                        <p class="text-xs text-gray-300 truncate">Performance Reports</p>
                    </div>
                </button>
                
                <!-- Divider -->
                <div class="border-t border-white border-opacity-20 my-4"></div>
                
                <!-- Logout Menu -->
                <button type="button" onclick="logout()" class="nav-item w-full text-left flex items-center space-x-3 sm:space-x-4 text-white hover:bg-red-500 hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-red-400 to-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-sign-out-alt text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Logout</span>
                        <p class="text-xs text-gray-300 truncate">Sign Out</p>
                    </div>
                </button>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="absolute bottom-6 left-6 right-6">
                <!-- Div waktu kerja dihapus -->
            </div>
        </div>
        
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="dashboard-main flex-1 flex flex-col overflow-hidden relative z-10 lg:w-auto">
            <!-- Top Navigation -->
            <nav class="glass backdrop-blur-xl border-b border-white border-opacity-20 w-full sticky top-0 z-30">
                <div class="w-full px-3 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-14 sm:h-20">
                        <div class="flex items-center space-x-2 sm:space-x-4 min-w-0">
                            <button id="openSidebar" class="lg:hidden p-2 sm:p-3 hover:bg-white hover:bg-opacity-20 rounded-xl transition-all text-white flex-shrink-0" title="Buka Menu">
                                <i class="fas fa-bars text-lg sm:text-xl"></i>
                            </button>
                            <button id="mobileNavBackBtn" type="button" onclick="showDashboard()" class="hidden lg:hidden p-2 sm:p-3 hover:bg-white hover:bg-opacity-20 rounded-xl transition-all text-white items-center justify-center flex-shrink-0" title="Kembali ke Dashboard">
                                <i class="fas fa-arrow-left text-lg sm:text-xl"></i>
                            </button>
                            <div class="min-w-0 flex-1">
                                <h1 id="topNavTitle" class="text-white text-base sm:text-2xl font-bold truncate">e-Kinerja Dashboard</h1>
                                <p class="text-gray-200 text-xs sm:text-sm hidden sm:block">Personal Workspace</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
                            <div class="hidden sm:flex items-center space-x-3">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span id="userWelcome" class="text-white font-medium text-sm sm:text-base"></span>
                            </div>
                            <!-- Mobile User Avatar -->
                            <button type="button" onclick="showProfile()" class="sm:hidden flex items-center justify-center w-9 h-9 rounded-xl gradient-blue text-white font-bold text-xs shadow hover:opacity-90 transition-opacity" title="Profil Saya">
                                <span id="mobileUserAvatarChar">U</span>
                            </button>
                            <button type="button" onclick="logout()" class="p-2 sm:p-3 glass rounded-xl hover:bg-red-500/20 text-red-300 hover:text-red-200 transition-all flex items-center justify-center" title="Keluar">
                                <i class="fas fa-sign-out-alt text-sm sm:text-base"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-3.5 sm:p-6 lg:p-8 w-full">
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

                    <!-- Quick Menu -->
                    <section aria-labelledby="quickMenuTitle" class="mb-4 sm:mb-6 lg:mb-8">
                        <div class="flex items-end justify-between gap-3 mb-3 sm:mb-4">
                            <div>
                                <h3 id="quickMenuTitle" class="text-lg sm:text-xl font-bold text-white">Menu Utama</h3>
                                <p class="text-xs sm:text-sm text-gray-300">Akses cepat layanan e-Kinerja</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                            <button type="button" onclick="showMasterKegiatan()" class="quick-menu-card quick-card-emerald group min-h-36 sm:min-h-40 rounded-2xl p-4 sm:p-5 text-left transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                                <span class="w-12 h-12 sm:w-14 sm:h-14 gradient-green rounded-2xl flex items-center justify-center shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas fa-clipboard-check text-white text-xl sm:text-2xl"></i>
                                </span>
                                <span class="block text-white font-bold text-sm sm:text-base">Input Kegiatan</span>
                                <span class="block text-gray-300 text-xs sm:text-sm mt-1 leading-snug">Catat kegiatan & isi logbook</span>
                            </button>

                            <button type="button" onclick="showMasterUnit()" class="quick-menu-card group min-h-36 sm:min-h-40 rounded-2xl p-4 sm:p-5 text-left transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-80">
                                <span class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-r from-teal-400 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas fa-hospital text-white text-xl sm:text-2xl"></i>
                                </span>
                                <span class="block text-white font-bold text-sm sm:text-base">Master Unit</span>
                                <span class="block text-gray-300 text-xs sm:text-sm mt-1 leading-snug">Kelola unit & ruangan</span>
                            </button>

                            <button type="button" onclick="showProfile()" class="quick-menu-card group min-h-36 sm:min-h-40 rounded-2xl p-4 sm:p-5 text-left transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-80">
                                <span class="w-12 h-12 sm:w-14 sm:h-14 gradient-blue rounded-2xl flex items-center justify-center shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas fa-user-circle text-white text-xl sm:text-2xl"></i>
                                </span>
                                <span class="block text-white font-bold text-sm sm:text-base">Profil Saya</span>
                                <span class="block text-gray-300 text-xs sm:text-sm mt-1 leading-snug">Lengkapi data kepegawaian</span>
                            </button>

                            <button type="button" onclick="navigateToLaporan()" class="quick-menu-card group min-h-36 sm:min-h-40 rounded-2xl p-4 sm:p-5 text-left transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-80">
                                <span class="w-12 h-12 sm:w-14 sm:h-14 gradient-orange rounded-2xl flex items-center justify-center shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas fa-chart-column text-white text-xl sm:text-2xl"></i>
                                </span>
                                <span class="block text-white font-bold text-sm sm:text-base">Laporan</span>
                                <span class="block text-gray-300 text-xs sm:text-sm mt-1 leading-snug">Pantau hasil & status kinerja</span>
                            </button>
                        </div>
                    </section>

                    <!-- Panduan Alur Kerja Pegawai (Interactive Workflow Guide) -->
                    <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-base sm:text-xl font-bold text-white flex items-center gap-2">
                                    <i class="fas fa-route text-emerald-400"></i>
                                    <span>Alur Kerja Harian e-Kinerja</span>
                                </h3>
                                <p class="text-gray-300 text-xs sm:text-sm mt-1">Ikuti 3 langkah mudah berikut untuk mencatat aktivitas kinerja Anda</p>
                            </div>
                            <button type="button" onclick="showMasterKegiatan()" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 transform hover:scale-105 text-xs sm:text-sm flex-shrink-0">
                                <i class="fas fa-pencil-alt"></i>
                                <span>Mulai Isi Logbook Sekarang</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
                            <!-- Step 1 -->
                            <div class="glass rounded-xl p-3.5 sm:p-5 border border-white/10 hover:border-emerald-500/40 transition-all flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-xs border border-emerald-500/30">
                                            1
                                        </div>
                                        <h4 class="text-white font-semibold text-sm">Pilih Kegiatan</h4>
                                    </div>
                                    <p class="text-gray-300 text-xs leading-relaxed mb-3">
                                        Buka menu <strong>Input Kegiatan</strong> di sidebar. Pilih jenis tugas yang Anda laksanakan hari ini.
                                    </p>
                                </div>
                                <button type="button" onclick="showMasterKegiatan()" class="text-emerald-400 hover:text-emerald-300 text-xs font-semibold inline-flex items-center gap-1 group self-start">
                                    <span>Buka Kegiatan</span>
                                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                                </button>
                            </div>

                            <!-- Step 2 -->
                            <div class="glass rounded-xl p-3.5 sm:p-5 border border-white/10 hover:border-blue-500/40 transition-all flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center text-xs border border-blue-500/30">
                                            2
                                        </div>
                                        <h4 class="text-white font-semibold text-sm">Isi Logbook & Bukti</h4>
                                    </div>
                                    <p class="text-gray-300 text-xs leading-relaxed mb-3">
                                        Klik tombol <span class="px-1.5 py-0.5 rounded bg-blue-600 text-white text-[10px] font-bold">Logbook</span> pada kegiatan. Masukkan tanggal, unit/ruangan, uraian temuan, dan foto bukti.
                                    </p>
                                </div>
                                <span class="text-blue-300 text-[11px] font-medium">Tersimpan otomatis</span>
                            </div>

                            <!-- Step 3 -->
                            <div class="glass rounded-xl p-3.5 sm:p-5 border border-white/10 hover:border-amber-500/40 transition-all flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 font-bold flex items-center justify-center text-xs border border-amber-500/30">
                                            3
                                        </div>
                                        <h4 class="text-white font-semibold text-sm">Pantau & Cetak Laporan</h4>
                                    </div>
                                    <p class="text-gray-300 text-xs leading-relaxed mb-3">
                                        Buka menu <strong>Laporan</strong> untuk melihat statistik bulanan, grafik kegiatan per ruangan, dan cetak laporan kinerja.
                                    </p>
                                </div>
                                <button type="button" onclick="navigateToLaporan()" class="text-amber-400 hover:text-amber-300 text-xs font-semibold inline-flex items-center gap-1 group self-start">
                                    <span>Lihat Laporan</span>
                                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Master Kegiatan Content -->
                <div id="masterKegiatanContent" class="content-section hidden fade-in">
                    <!-- Back Button -->
                    <div class="mb-3 sm:mb-4">
                        <button type="button" onclick="showDashboard()" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2.5 glass rounded-xl text-white font-medium hover:bg-white hover:bg-opacity-20 transition-all text-sm group" title="Kembali ke Dashboard">
                            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Kembali ke Dashboard</span>
                        </button>
                    </div>

                    <!-- Jenis Kegiatan Section -->
                    <div id="activitiesSection" tabindex="-1" class="morphism-card rounded-2xl p-3 sm:p-4 lg:p-6 xl:p-8 mb-4 sm:mb-6 lg:mb-8 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-70">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-5 sm:mb-6">
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <div class="w-11 h-11 sm:w-14 sm:h-14 lg:w-16 lg:h-16 gradient-green rounded-2xl flex items-center justify-center neon-glow flex-shrink-0">
                                    <i class="fas fa-clipboard-list text-white text-base sm:text-xl lg:text-2xl"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-base sm:text-xl lg:text-2xl font-bold text-white leading-tight">Input Kegiatan</h3>
                                        <span id="activityCountBadge" class="hidden text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-semibold"></span>
                                    </div>
                                    <p class="text-gray-300 text-xs sm:text-sm mt-0.5">Pilih kegiatan untuk mengisi logbook kinerja harian Anda</p>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto">
                                <button type="button" onclick="openCreateJenisKegiatanModal()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Kegiatan</span>
                                </button>
                            </div>
                        </div>

                        <!-- Search & Filter Bar -->
                        <div class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-search text-sm"></i>
                                </div>
                                <input type="text" id="searchKegiatanInput" oninput="filterJenisKegiatan()" placeholder="Cari kegiatan..." class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>
                        
                        <div id="jenisKegiatanContainer">
                            <div class="glass rounded-xl p-3 sm:p-5">
                                <!-- Desktop / Tablet Table View (Hidden on mobile) -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="border-b border-white border-opacity-20 text-gray-300 text-xs sm:text-sm uppercase tracking-wider font-semibold">
                                                <th class="py-3 px-3 w-12 text-center">No</th>
                                                <th class="py-3 px-3">Nama Kegiatan</th>
                                                <th class="py-3 px-3 w-48 sm:w-56 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="jenisKegiatanTableBody">
                                            <!-- Data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Card View (md:hidden) -->
                                <div id="jenisKegiatanCardList" class="md:hidden space-y-3">
                                    <!-- Mobile cards will be loaded here -->
                                </div>

                                <div id="noDataMessage" class="text-center py-8 hidden">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-400">Tidak ada data kegiatan untuk NIP Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div id="jenisKegiatanLoading" class="text-center py-8">
                            <div class="inline-flex items-center space-x-3">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-400"></div>
                                <span class="text-white">Memuat data kegiatan...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Form Jenis Kegiatan -->
                <div id="jenisKegiatanModal" class="fixed inset-0 bg-black/70 hidden z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 backdrop-blur-sm transition-all duration-300">
                    <div class="glass morphism-card rounded-t-3xl sm:rounded-2xl p-5 sm:p-6 w-full max-w-lg mx-auto shadow-2xl border-t sm:border border-white/20 max-h-[90dvh] overflow-y-auto">
                        <!-- Mobile bottom sheet drag pill -->
                        <div class="w-12 h-1.5 bg-white/30 rounded-full mx-auto mb-3 sm:hidden"></div>
                        
                        <div class="flex justify-between items-center mb-4 sm:mb-5 border-b border-white/10 pb-3 sm:pb-4">
                            <div class="flex items-center space-x-3">
                                <div id="modalIconContainer" class="w-10 h-10 gradient-green rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i id="modalIcon" class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <h3 id="modalTitle" class="text-base sm:text-xl font-bold text-white">Tambah Kegiatan</h3>
                                    <p id="modalSubtitle" class="text-xs text-gray-300">Tambahkan kegiatan baru untuk pencatatan logbook</p>
                                </div>
                            </div>
                            <button type="button" id="closeModal" class="text-gray-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                        
                        <form id="jenisKegiatanForm" class="space-y-4">
                            <input type="hidden" id="jenisKegiatanId" value="">
                            <div>
                                <label for="jenisKegiatanInput" class="block text-sm font-medium text-gray-200 mb-2">Nama Kegiatan <span class="text-red-400">*</span></label>
                                <textarea id="jenisKegiatanInput" rows="3" required class="w-full px-4 py-3 bg-slate-900 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm resize-none" placeholder="Masukkan nama kegiatan..."></textarea>
                                <p class="text-xs text-gray-400 mt-1">Nama kegiatan yang akan muncul pada daftar logbook kinerja.</p>
                            </div>
                            
                            <div class="flex space-x-3 pt-2">
                                <button type="button" id="cancelModal" class="flex-1 bg-gray-700/80 hover:bg-gray-600 text-white py-3 px-4 rounded-xl font-medium transition-all duration-200">
                                    Batal
                                </button>
                                <button type="submit" id="saveJenisKegiatanBtn" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span id="saveBtnText">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Master Unit Content -->
                <div id="masterUnitContent" class="content-section hidden fade-in">
                    <!-- Back Button -->
                    <div class="mb-3 sm:mb-4">
                        <button type="button" onclick="showDashboard()" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2.5 glass rounded-xl text-white font-medium hover:bg-white hover:bg-opacity-20 transition-all text-sm group" title="Kembali ke Dashboard">
                            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Kembali ke Dashboard</span>
                        </button>
                    </div>

                    <!-- Unit Ruangan Card -->
                    <div id="unitRuanganSection" tabindex="-1" class="morphism-card rounded-2xl p-3 sm:p-4 lg:p-6 xl:p-8 mb-4 sm:mb-6 lg:mb-8 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-70">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-5 sm:mb-6">
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <div class="w-11 h-11 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gradient-to-r from-teal-400 to-cyan-600 rounded-2xl flex items-center justify-center neon-glow flex-shrink-0">
                                    <i class="fas fa-hospital text-white text-base sm:text-xl lg:text-2xl"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-base sm:text-xl lg:text-2xl font-bold text-white leading-tight">Master Unit / Ruangan</h3>
                                        <span id="unitCountBadge" class="hidden text-xs px-2.5 py-0.5 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/30 font-semibold"></span>
                                    </div>
                                    <p class="text-gray-300 text-xs sm:text-sm mt-0.5">Kelola daftar unit/ruangan kerja untuk pencatatan logbook Anda</p>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto">
                                <button type="button" onclick="openCreateUnitModal()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-cyan-500/30 transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Unit</span>
                                </button>
                            </div>
                        </div>

                        <!-- Search & Filter Bar -->
                        <div class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-search text-sm"></i>
                                </div>
                                <input type="text" id="searchUnitInput" oninput="filterUnitRuangan()" placeholder="Cari nama unit / ruangan..." class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm">
                            </div>
                        </div>
                        
                        <div id="unitRuanganContainer">
                            <div class="glass rounded-xl p-3 sm:p-5">
                                <!-- Desktop / Tablet Table View (Hidden on mobile) -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="border-b border-white border-opacity-20 text-gray-300 text-xs sm:text-sm uppercase tracking-wider font-semibold">
                                                <th class="py-3 px-3 w-12 text-center">No</th>
                                                <th class="py-3 px-3">Nama Unit / Ruangan</th>
                                                <th class="py-3 px-3 w-40 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="unitRuanganTableBody">
                                            <!-- Data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Card View (md:hidden) -->
                                <div id="unitRuanganCardList" class="md:hidden space-y-3">
                                    <!-- Mobile cards will be loaded here -->
                                </div>

                                <div id="noUnitDataMessage" class="text-center py-8 hidden">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-400">Belum ada data unit/ruangan untuk NIP Anda</p>
                                </div>
                            </div>
                        </div>
                        
                        <div id="unitRuanganLoading" class="text-center py-8">
                            <div class="inline-flex items-center space-x-3">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-cyan-400"></div>
                                <span class="text-white">Memuat data unit ruangan...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Form Unit Ruangan -->
                <div id="unitRuanganModal" class="fixed inset-0 bg-black/70 hidden z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 backdrop-blur-sm transition-all duration-300">
                    <div class="glass morphism-card rounded-t-3xl sm:rounded-2xl p-5 sm:p-6 w-full max-w-lg mx-auto shadow-2xl border-t sm:border border-white/20 max-h-[90dvh] overflow-y-auto">
                        <!-- Mobile bottom sheet drag pill -->
                        <div class="w-12 h-1.5 bg-white/30 rounded-full mx-auto mb-3 sm:hidden"></div>
                        
                        <div class="flex justify-between items-center mb-4 sm:mb-5 border-b border-white/10 pb-3 sm:pb-4">
                            <div class="flex items-center space-x-3">
                                <div id="unitModalIconContainer" class="w-10 h-10 bg-gradient-to-r from-teal-400 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i id="unitModalIcon" class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <h3 id="unitModalTitle" class="text-base sm:text-xl font-bold text-white">Tambah Unit / Ruangan</h3>
                                    <p id="unitModalSubtitle" class="text-xs text-gray-300">Tambahkan nama unit atau ruangan kerja</p>
                                </div>
                            </div>
                            <button type="button" id="closeUnitModal" class="text-gray-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                        
                        <form id="unitRuanganForm" class="space-y-4">
                            <input type="hidden" id="unitRuanganId" value="">
                            <div>
                                <label for="namaRuanganInput" class="block text-sm font-medium text-gray-200 mb-2">Nama Unit / Ruangan <span class="text-red-400">*</span></label>
                                <input type="text" id="namaRuanganInput" required class="w-full px-4 py-3 bg-slate-900 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-sm" placeholder="Contoh: ICU, Ruang Operasi (OK), Melati...">
                                <p class="text-xs text-gray-400 mt-1">Nama unit/ruangan yang akan menjadi pilihan saat mengisi logbook.</p>
                            </div>
                            
                            <div class="flex space-x-3 pt-2">
                                <button type="button" id="cancelUnitModal" class="flex-1 bg-gray-700/80 hover:bg-gray-600 text-white py-3 px-4 rounded-xl font-medium transition-all duration-200">
                                    Batal
                                </button>
                                <button type="submit" id="saveUnitBtn" class="flex-1 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-cyan-500/30 transition-all duration-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span id="saveUnitBtnText">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Profile Content -->
                <div id="profileContent" class="content-section hidden fade-in">
                    <!-- Back Button on Mobile / Sub-page -->
                    <div class="mb-3 sm:mb-4">
                        <button type="button" onclick="showDashboard()" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2.5 glass rounded-xl text-white font-medium hover:bg-white hover:bg-opacity-20 transition-all text-sm group" title="Kembali ke Dashboard">
                            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Kembali ke Dashboard</span>
                        </button>
                    </div>

                    <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 hover-scale">
                        <div class="flex items-center space-x-3 sm:space-x-4 mb-6 sm:mb-8">
                            <button type="button" onclick="showDashboard()" class="p-2.5 sm:p-3 glass rounded-xl hover:bg-white hover:bg-opacity-20 transition-all text-white flex items-center justify-center flex-shrink-0" title="Kembali ke Dashboard">
                                <i class="fas fa-arrow-left text-base sm:text-xl"></i>
                            </button>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 gradient-blue rounded-2xl flex items-center justify-center neon-glow flex-shrink-0">
                                <i class="fas fa-user-cog text-white text-xl sm:text-2xl"></i>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-xl sm:text-3xl font-bold text-white truncate">Profil Saya</h2>
                                <p class="text-xs sm:text-sm text-gray-300 truncate">Kelola informasi personal Anda</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div id="profileView">
                                <!-- Profile view will be loaded here -->
                            </div>
                            
                            <div id="profileEdit" class="hidden lg:col-span-2">
                                <!-- Profile edit form will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Content -->
                <div id="tasksContent" class="content-section hidden fade-in">
                    <!-- Back Button on Mobile / Sub-page -->
                    <div class="mb-3 sm:mb-4">
                        <button type="button" onclick="showDashboard()" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2.5 glass rounded-xl text-white font-medium hover:bg-white hover:bg-opacity-20 transition-all text-sm group" title="Kembali ke Dashboard">
                            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Kembali ke Dashboard</span>
                        </button>
                    </div>

                    <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 hover-scale">
                        <div class="flex items-center justify-between mb-6 sm:mb-8">
                            <div class="flex items-center space-x-3 sm:space-x-4 min-w-0">
                                <button type="button" onclick="showDashboard()" class="p-2.5 sm:p-3 glass rounded-xl hover:bg-white hover:bg-opacity-20 transition-all text-white flex items-center justify-center flex-shrink-0" title="Kembali ke Dashboard">
                                    <i class="fas fa-arrow-left text-base sm:text-xl"></i>
                                </button>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 gradient-purple rounded-2xl flex items-center justify-center neon-glow flex-shrink-0">
                                    <i class="fas fa-tasks text-white text-xl sm:text-2xl"></i>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-xl sm:text-3xl font-bold text-white truncate">Tugas Saya</h2>
                                    <p class="text-xs sm:text-sm text-gray-300 truncate">Kelola dan pantau progress tugas</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 sm:px-6 sm:py-3 gradient-purple rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300 neon-glow text-sm sm:text-base flex-shrink-0">
                                <i class="fas fa-plus mr-1 sm:mr-2"></i><span class="hidden sm:inline">Tugas Baru</span><span class="sm:hidden">Tambah</span>
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
                    <!-- Back Button on Mobile / Sub-page -->
                    <div class="mb-3 sm:mb-4">
                        <button type="button" onclick="showDashboard()" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2.5 glass rounded-xl text-white font-medium hover:bg-white hover:bg-opacity-20 transition-all text-sm group" title="Kembali ke Dashboard">
                            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Kembali ke Dashboard</span>
                        </button>
                    </div>

                    <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 hover-scale">
                        <div class="flex items-center space-x-3 sm:space-x-4 mb-6 sm:mb-8">
                            <button type="button" onclick="showDashboard()" class="p-2.5 sm:p-3 glass rounded-xl hover:bg-white hover:bg-opacity-20 transition-all text-white flex items-center justify-center flex-shrink-0" title="Kembali ke Dashboard">
                                <i class="fas fa-arrow-left text-base sm:text-xl"></i>
                            </button>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 gradient-orange rounded-2xl flex items-center justify-center neon-glow flex-shrink-0">
                                <i class="fas fa-chart-bar text-white text-xl sm:text-2xl"></i>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-xl sm:text-3xl font-bold text-white truncate">Laporan Kinerja</h2>
                                <p class="text-xs sm:text-sm text-gray-300 truncate">Analisis dan statistik performa Anda</p>
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
        const token = localStorage.getItem('token');
        let user = getStoredUser();

        function getStoredUser() {
            try {
                return JSON.parse(localStorage.getItem('user') || '{}');
            } catch (error) {
                console.error('Data sesi lokal tidak valid:', error);
                return {};
            }
        }

        function clearSession() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
        }

        async function initializeDashboard() {
            if (!token) {
                clearSession();
                window.location.replace('/login');
                return;
            }

            try {
                const response = await fetch('/api/auth/me', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const result = await response.json();
                user = result.data || {};
                localStorage.setItem('user', JSON.stringify(user));

                if (user.role === 'admin') {
                    window.location.replace('/dashboard');
                    return;
                }

                const userName = user.name || 'Pengguna';
                const welcomeEl = document.getElementById('userWelcome');
                if (welcomeEl) welcomeEl.textContent = userName;

                const mobileAvatar = document.getElementById('mobileUserAvatarChar');
                if (mobileAvatar) {
                    mobileAvatar.textContent = userName.trim().charAt(0).toUpperCase() || 'U';
                }

                updateDateTime();
                showDashboard();
                await Promise.allSettled([
                    loadJenisKegiatan(),
                    loadUnitRuangan()
                ]);
            } catch (error) {
                console.error('Validasi sesi gagal:', error);
                clearSession();
                window.location.replace('/login');
            }
        }
        
        // Enhanced sidebar toggle - Override Tailwind classes
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (!sidebar || !overlay) {
                console.error('Sidebar or overlay element not found');
                return;
            }
            
            const isVisible = sidebar.classList.contains('show');
            if (isVisible) {
                sidebar.classList.remove('show');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.add('show');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSidebarOnMobile() {
            if (window.innerWidth >= 1024) {
                return;
            }

            document.getElementById('sidebar')?.classList.remove('show');
            document.getElementById('sidebarOverlay')?.classList.add('hidden');
            document.body.style.overflow = '';
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
            const user = getStoredUser();
            
            console.log('Navigating to laporan - Token:', !!token);
            console.log('Navigating to laporan - User NIP:', user.nip);
            
            if (!token) {
                clearSession();
                window.location.replace('/login');
                return;
            }

            if (!user.nip) {
                showProfile();
                alert('Lengkapi NIP pada profil Anda sebelum membuka laporan.');
                return;
            }
            
            // Navigate to laporan with NIP parameter
            window.location.href = `/laporan?nip=${user.nip}`;
        }
        
        // Cached master jenis kegiatan data
        let cachedJenisKegiatan = [];

        // Helper function to escape HTML
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Function to load jenis kegiatan data
        async function loadJenisKegiatan() {
            const token = localStorage.getItem('token');
            const user = getStoredUser();
            
            console.log('Loading jenis kegiatan for user:', user);
            console.log('User NIP:', user.nip);
            console.log('Token exists:', !!token);
            
            if (!token) {
                clearSession();
                window.location.replace('/login');
                return;
            }
            
            if (!user.nip) {
                document.getElementById('jenisKegiatanLoading')?.classList.add('hidden');
                document.getElementById('jenisKegiatanContainer')?.classList.remove('hidden');
                showNoDataMessage('NIP belum diisi. Lengkapi profil untuk menampilkan kegiatan.', true);
                return;
            }
            
            const loadingElement = document.getElementById('jenisKegiatanLoading');
            const containerElement = document.getElementById('jenisKegiatanContainer');
            const noDataMessage = document.getElementById('noDataMessage');
            const countBadge = document.getElementById('activityCountBadge');
            
            // Show loading
            loadingElement?.classList.remove('hidden');
            containerElement?.classList.add('hidden');
            noDataMessage?.classList.add('hidden');
            
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
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('API Error Response:', errorText);
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const result = await response.json();
                
                let data = result;
                if (result.data) {
                    data = result.data;
                } else if (Array.isArray(result)) {
                    data = result;
                } else {
                    throw new Error('Format response tidak valid');
                }
                
                if (!Array.isArray(data)) {
                    throw new Error('Data yang diterima bukan array');
                }
                
                // Filter data by user's NIP
                const userNip = String(user.nip || '').trim();
                cachedJenisKegiatan = data.filter(item => {
                    const itemNip = String(item.nip || '').trim();
                    return itemNip === userNip;
                });
                
                console.log('Filtered master kegiatan:', cachedJenisKegiatan);

                // Update badge
                if (countBadge) {
                    countBadge.textContent = `${cachedJenisKegiatan.length} Kegiatan`;
                    countBadge.classList.remove('hidden');
                }

                // Render table
                const searchInput = document.getElementById('searchKegiatanInput');
                renderJenisKegiatanTable(searchInput ? searchInput.value : '');
                
                containerElement?.classList.remove('hidden');
            } catch (error) {
                console.error('Error loading jenis kegiatan:', error);
                showNoDataMessage(`Error memuat data: ${error.message}`);
                containerElement?.classList.remove('hidden');
            } finally {
                loadingElement?.classList.add('hidden');
            }
        }

        // Function to filter kegiatan based on search input
        function filterJenisKegiatan() {
            const searchInput = document.getElementById('searchKegiatanInput');
            const query = searchInput ? searchInput.value : '';
            renderJenisKegiatanTable(query);
        }

        // Function to render table rows & mobile cards
        function renderJenisKegiatanTable(query = '') {
            const tableBody = document.getElementById('jenisKegiatanTableBody');
            const cardList = document.getElementById('jenisKegiatanCardList');
            const noDataMessage = document.getElementById('noDataMessage');
            if (!tableBody) return;

            tableBody.innerHTML = '';
            if (cardList) cardList.innerHTML = '';

            const trimmedQuery = query.trim().toLowerCase();
            const filteredData = trimmedQuery 
                ? cachedJenisKegiatan.filter(item => (item.jenis_kegiatan || '').toLowerCase().includes(trimmedQuery))
                : cachedJenisKegiatan;

            if (filteredData.length === 0) {
                if (noDataMessage) {
                    if (cachedJenisKegiatan.length === 0) {
                        showNoDataMessage('Belum ada kegiatan untuk NIP Anda. Klik "Tambah Kegiatan" untuk menambahkan kegiatan pertama Anda.');
                    } else {
                        showNoDataMessage(`Tidak ditemukan kegiatan dengan kata kunci "${query}".`);
                    }
                }
                return;
            }

            if (noDataMessage) {
                noDataMessage.classList.add('hidden');
            }

            filteredData.forEach((item, index) => {
                // Render Desktop Table Row
                const row = document.createElement('tr');
                row.className = 'border-b border-white border-opacity-10 hover:bg-white hover:bg-opacity-5 transition-all duration-200 group';

                row.innerHTML = `
                    <td class="py-3.5 px-3 text-center text-gray-300 text-sm font-medium">${index + 1}</td>
                    <td class="py-3.5 px-3">
                        <div class="cursor-pointer group-hover:text-emerald-300 transition-colors" onclick="navigateToDetailById(${item.id})" title="Klik untuk membuka logbook kegiatan ini">
                            <span class="text-white font-medium text-sm sm:text-base">${escapeHtml(item.jenis_kegiatan || '-')}</span>
                        </div>
                    </td>
                    <td class="py-3.5 px-3 text-center">
                        <div class="flex items-center justify-center gap-1.5 sm:gap-2">
                            <button type="button" onclick="navigateToDetailById(${item.id})" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-blue-600/80 hover:bg-blue-600 text-white rounded-lg text-xs font-semibold shadow hover:shadow-blue-500/25 transition-all transform hover:scale-105" title="Buka dan isi logbook">
                                <i class="fas fa-clipboard-check"></i>
                                <span class="hidden sm:inline">Logbook</span>
                            </button>
                            <button type="button" onclick="openEditJenisKegiatanModal(${item.id})" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-amber-500/80 hover:bg-amber-500 text-white rounded-lg text-xs font-semibold shadow hover:shadow-amber-500/25 transition-all transform hover:scale-105" title="Edit nama kegiatan">
                                <i class="fas fa-edit"></i>
                                <span class="hidden sm:inline">Edit</span>
                            </button>
                            <button type="button" onclick="deleteJenisKegiatan(${item.id})" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-red-600/80 hover:bg-red-600 text-white rounded-lg text-xs font-semibold shadow hover:shadow-red-500/25 transition-all transform hover:scale-105" title="Hapus kegiatan">
                                <i class="fas fa-trash-alt"></i>
                                <span class="hidden sm:inline">Hapus</span>
                            </button>
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);

                // Render Mobile Card
                if (cardList) {
                    const card = document.createElement('div');
                    card.className = 'group bg-gradient-to-br from-emerald-950/35 via-slate-900/90 to-slate-900/95 border border-emerald-500/30 hover:border-emerald-400/60 rounded-xl p-2.5 sm:p-3 transition-all duration-200 active:scale-[0.995] relative overflow-hidden shadow-sm';
                    card.innerHTML = `
                        <div class="flex items-start gap-2.5">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-md bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold flex-shrink-0 mt-0.5">${index + 1}</span>
                            <div class="flex-1 min-w-0 cursor-pointer" onclick="navigateToDetailById(${item.id})">
                                <h4 class="text-white font-medium text-xs sm:text-sm leading-snug break-words group-hover:text-emerald-300 transition-colors">${escapeHtml(item.jenis_kegiatan || '-')}</h4>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-2 pt-2 mt-2 border-t border-white/10">
                            <button type="button" onclick="navigateToDetailById(${item.id})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-white border border-emerald-500/40 rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 active:scale-95">
                                <i class="fas fa-clipboard-check text-[11px]"></i>
                                <span>Isi Logbook</span>
                            </button>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="openEditJenisKegiatanModal(${item.id})" class="inline-flex items-center justify-center w-7 h-7 text-gray-400 hover:text-amber-300 hover:bg-amber-400/10 rounded-lg transition-colors" title="Edit kegiatan" aria-label="Edit kegiatan">
                                    <i class="fas fa-pen text-[11px]"></i>
                                </button>
                                <button type="button" onclick="deleteJenisKegiatan(${item.id})" class="inline-flex items-center justify-center w-7 h-7 text-gray-400 hover:text-red-400 hover:bg-red-400/10 rounded-lg transition-colors" title="Hapus kegiatan" aria-label="Hapus kegiatan">
                                    <i class="fas fa-trash-alt text-[11px]"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    cardList.appendChild(card);
                }
            });
        }

        // Navigate to detail logbook page
        function navigateToDetailById(id) {
            const item = cachedJenisKegiatan.find(k => k.id == id);
            if (!item) {
                alert('Data kegiatan tidak ditemukan');
                return;
            }

            const dataToSend = {
                jenis_kegiatan: item.jenis_kegiatan || '',
                golongan: item.golongan || user?.golongan || '',
                nip: item.nip || user?.nip || '',
                nama_pelaksana: user?.name || user?.nama || ''
            };
            
            const jenisKegiatanData = encodeURIComponent(JSON.stringify(dataToSend));
            window.location.href = `/jenis-kegiatan/detail?data=${jenisKegiatanData}`;
        }
        
        // Function to open modal for creating new item
        function openCreateJenisKegiatanModal() {
            const modal = document.getElementById('jenisKegiatanModal');
            const idInput = document.getElementById('jenisKegiatanId');
            const input = document.getElementById('jenisKegiatanInput');
            const title = document.getElementById('modalTitle');
            const subtitle = document.getElementById('modalSubtitle');
            const saveBtnText = document.getElementById('saveBtnText');
            const iconContainer = document.getElementById('modalIconContainer');
            const icon = document.getElementById('modalIcon');
            
            if (!modal) return;

            if (idInput) idInput.value = '';
            if (input) input.value = '';
            if (title) title.textContent = 'Tambah Kegiatan';
            if (subtitle) subtitle.textContent = 'Tambahkan nama kegiatan untuk pencatatan logbook';
            if (saveBtnText) saveBtnText.textContent = 'Simpan';
            if (iconContainer) iconContainer.className = 'w-10 h-10 gradient-green rounded-xl flex items-center justify-center';
            if (icon) icon.className = 'fas fa-plus text-white';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input?.focus(), 150);
        }

        // Function to open modal for editing item
        function openEditJenisKegiatanModal(id) {
            const item = cachedJenisKegiatan.find(k => k.id == id);
            if (!item) {
                alert('Data kegiatan tidak ditemukan');
                return;
            }

            const modal = document.getElementById('jenisKegiatanModal');
            const idInput = document.getElementById('jenisKegiatanId');
            const input = document.getElementById('jenisKegiatanInput');
            const title = document.getElementById('modalTitle');
            const subtitle = document.getElementById('modalSubtitle');
            const saveBtnText = document.getElementById('saveBtnText');
            const iconContainer = document.getElementById('modalIconContainer');
            const icon = document.getElementById('modalIcon');
            
            if (!modal) return;

            if (idInput) idInput.value = item.id;
            if (input) input.value = item.jenis_kegiatan || '';
            if (title) title.textContent = 'Edit Kegiatan';
            if (subtitle) subtitle.textContent = 'Perbarui nama kegiatan';
            if (saveBtnText) saveBtnText.textContent = 'Perbarui';
            if (iconContainer) iconContainer.className = 'w-10 h-10 gradient-blue rounded-xl flex items-center justify-center';
            if (icon) icon.className = 'fas fa-edit text-white';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input?.focus(), 150);
        }
        
        // Function to close modal
        function closeJenisKegiatanModal() {
            const modal = document.getElementById('jenisKegiatanModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Function to delete jenis kegiatan
        async function deleteJenisKegiatan(id) {
            const item = cachedJenisKegiatan.find(k => k.id == id);
            const nama = item ? item.jenis_kegiatan : 'kegiatan ini';

            if (!confirm(`Apakah Anda yakin ingin menghapus kegiatan:\n"${nama}"?\n\nCatatan: Logbook yang terkait dengan kegiatan ini dapat terpengaruh.`)) {
                return;
            }

            const token = localStorage.getItem('token');
            if (!token) {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                window.location.replace('/login');
                return;
            }

            try {
                const response = await fetch(`/api/jenis-kegiatan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    await loadJenisKegiatan();
                } else {
                    alert(result.message || 'Gagal menghapus kegiatan');
                }
            } catch (error) {
                console.error('Error deleting jenis kegiatan:', error);
                alert('Terjadi kesalahan koneksi saat menghapus kegiatan');
            }
        }

        // ==================== MASTER UNIT / RUANGAN ====================
        let cachedUnitRuangan = [];

        async function loadUnitRuangan() {
            const token = localStorage.getItem('token');
            const loadingElement = document.getElementById('unitRuanganLoading');
            const containerElement = document.getElementById('unitRuanganContainer');
            const countBadge = document.getElementById('unitCountBadge');

            if (!token) return;

            try {
                loadingElement?.classList.remove('hidden');
                containerElement?.classList.add('hidden');

                const response = await fetch('/api/unit-ruangan', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                cachedUnitRuangan = result.data || [];

                if (countBadge) {
                    countBadge.textContent = `${cachedUnitRuangan.length} Unit`;
                    countBadge.classList.remove('hidden');
                }

                const searchInput = document.getElementById('searchUnitInput');
                renderUnitRuanganTable(searchInput ? searchInput.value : '');

                containerElement?.classList.remove('hidden');
            } catch (error) {
                console.error('Error loading unit ruangan:', error);
                const noData = document.getElementById('noUnitDataMessage');
                if (noData) {
                    noData.innerHTML = `
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-4"></i>
                        <p class="text-yellow-400 font-medium">Gagal memuat data unit: ${escapeHtml(error.message)}</p>
                    `;
                    noData.classList.remove('hidden');
                }
                containerElement?.classList.remove('hidden');
            } finally {
                loadingElement?.classList.add('hidden');
            }
        }

        function filterUnitRuangan() {
            const searchInput = document.getElementById('searchUnitInput');
            const query = searchInput ? searchInput.value : '';
            renderUnitRuanganTable(query);
        }

        function renderUnitRuanganTable(query = '') {
            const tableBody = document.getElementById('unitRuanganTableBody');
            const cardList = document.getElementById('unitRuanganCardList');
            const noDataMessage = document.getElementById('noUnitDataMessage');
            if (!tableBody) return;

            tableBody.innerHTML = '';
            if (cardList) cardList.innerHTML = '';

            const trimmedQuery = query.trim().toLowerCase();
            const filteredData = trimmedQuery
                ? cachedUnitRuangan.filter(item => (item.nama_ruangan || '').toLowerCase().includes(trimmedQuery))
                : cachedUnitRuangan;

            if (filteredData.length === 0) {
                if (noDataMessage) {
                    noDataMessage.innerHTML = `
                        <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-400">${cachedUnitRuangan.length === 0 ? 'Belum ada data unit/ruangan untuk NIP Anda. Klik "Tambah Unit" untuk menambahkan.' : `Tidak ditemukan unit dengan kata kunci "${escapeHtml(query)}".`}</p>
                    `;
                    noDataMessage.classList.remove('hidden');
                }
                return;
            }

            if (noDataMessage) {
                noDataMessage.classList.add('hidden');
            }

            filteredData.forEach((item, index) => {
                // Desktop row
                const row = document.createElement('tr');
                row.className = 'border-b border-white border-opacity-10 hover:bg-white hover:bg-opacity-5 transition-all duration-200 group';
                row.innerHTML = `
                    <td class="py-3.5 px-3 text-center text-gray-300 text-sm font-medium">${index + 1}</td>
                    <td class="py-3.5 px-3">
                        <span class="text-white font-medium text-sm sm:text-base">${escapeHtml(item.nama_ruangan || '-')}</span>
                    </td>
                    <td class="py-3.5 px-3 text-center">
                        <div class="flex items-center justify-center gap-1.5 sm:gap-2">
                            <button type="button" onclick="openEditUnitModal(${item.id})" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-amber-500/80 hover:bg-amber-500 text-white rounded-lg text-xs font-semibold shadow hover:shadow-amber-500/25 transition-all transform hover:scale-105" title="Edit nama unit">
                                <i class="fas fa-edit"></i>
                                <span class="hidden sm:inline">Edit</span>
                            </button>
                            <button type="button" onclick="deleteUnitRuangan(${item.id})" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-red-600/80 hover:bg-red-600 text-white rounded-lg text-xs font-semibold shadow hover:shadow-red-500/25 transition-all transform hover:scale-105" title="Hapus unit">
                                <i class="fas fa-trash-alt"></i>
                                <span class="hidden sm:inline">Hapus</span>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);

                // Mobile card
                if (cardList) {
                    const card = document.createElement('div');
                    card.className = 'group bg-gradient-to-br from-teal-950/35 via-slate-900/90 to-slate-900/95 border border-teal-500/30 hover:border-teal-400/60 rounded-xl p-2.5 sm:p-3 transition-all duration-200 active:scale-[0.995] relative overflow-hidden shadow-sm';
                    card.innerHTML = `
                        <div class="flex items-start gap-2.5">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-md bg-teal-500/15 text-teal-300 border border-teal-500/30 text-[11px] font-bold flex-shrink-0 mt-0.5">${index + 1}</span>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-medium text-xs sm:text-sm leading-snug break-words group-hover:text-teal-300 transition-colors">${escapeHtml(item.nama_ruangan || '-')}</h4>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-1 pt-2 mt-2 border-t border-white/10">
                            <button type="button" onclick="openEditUnitModal(${item.id})" class="inline-flex items-center gap-1 px-2.5 py-1 text-gray-400 hover:text-amber-300 hover:bg-amber-400/10 rounded-lg text-xs font-medium transition-colors" title="Edit unit" aria-label="Edit unit">
                                <i class="fas fa-pen text-[11px]"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button" onclick="deleteUnitRuangan(${item.id})" class="inline-flex items-center gap-1 px-2.5 py-1 text-gray-400 hover:text-red-400 hover:bg-red-400/10 rounded-lg text-xs font-medium transition-colors" title="Hapus unit" aria-label="Hapus unit">
                                <i class="fas fa-trash-alt text-[11px]"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                    `;
                    cardList.appendChild(card);
                }
            });
        }

        function openCreateUnitModal() {
            const modal = document.getElementById('unitRuanganModal');
            const form = document.getElementById('unitRuanganForm');
            const idInput = document.getElementById('unitRuanganId');
            const input = document.getElementById('namaRuanganInput');
            const title = document.getElementById('unitModalTitle');
            const subtitle = document.getElementById('unitModalSubtitle');
            const saveBtnText = document.getElementById('saveUnitBtnText');
            const iconContainer = document.getElementById('unitModalIconContainer');
            const icon = document.getElementById('unitModalIcon');

            if (!modal) return;
            form?.reset();
            if (idInput) idInput.value = '';
            if (title) title.textContent = 'Tambah Unit / Ruangan';
            if (subtitle) subtitle.textContent = 'Tambahkan nama unit atau ruangan kerja';
            if (saveBtnText) saveBtnText.textContent = 'Simpan';
            if (iconContainer) iconContainer.className = 'w-10 h-10 bg-gradient-to-r from-teal-400 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0';
            if (icon) icon.className = 'fas fa-plus text-white';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input?.focus(), 150);
        }

        function openEditUnitModal(id) {
            const item = cachedUnitRuangan.find(u => u.id == id);
            if (!item) {
                alert('Data unit tidak ditemukan');
                return;
            }

            const modal = document.getElementById('unitRuanganModal');
            const idInput = document.getElementById('unitRuanganId');
            const input = document.getElementById('namaRuanganInput');
            const title = document.getElementById('unitModalTitle');
            const subtitle = document.getElementById('unitModalSubtitle');
            const saveBtnText = document.getElementById('saveUnitBtnText');
            const iconContainer = document.getElementById('unitModalIconContainer');
            const icon = document.getElementById('unitModalIcon');

            if (!modal) return;
            if (idInput) idInput.value = item.id;
            if (input) input.value = item.nama_ruangan || '';
            if (title) title.textContent = 'Edit Unit / Ruangan';
            if (subtitle) subtitle.textContent = 'Perbarui nama unit atau ruangan kerja';
            if (saveBtnText) saveBtnText.textContent = 'Perbarui';
            if (iconContainer) iconContainer.className = 'w-10 h-10 gradient-blue rounded-xl flex items-center justify-center flex-shrink-0';
            if (icon) icon.className = 'fas fa-edit text-white';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input?.focus(), 150);
        }

        function closeUnitModal() {
            const modal = document.getElementById('unitRuanganModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        async function deleteUnitRuangan(id) {
            const item = cachedUnitRuangan.find(u => u.id == id);
            const nama = item ? item.nama_ruangan : 'unit ini';

            if (!confirm(`Apakah Anda yakin ingin menghapus unit/ruangan:\n"${nama}"?\n\nCatatan: Logbook yang menggunakan unit ini dapat terpengaruh.`)) {
                return;
            }

            const token = localStorage.getItem('token');
            if (!token) {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                window.location.replace('/login');
                return;
            }

            try {
                const response = await fetch(`/api/unit-ruangan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    await loadUnitRuangan();
                } else {
                    alert(result.message || 'Gagal menghapus unit/ruangan');
                }
            } catch (error) {
                console.error('Error deleting unit ruangan:', error);
                alert('Terjadi kesalahan koneksi saat menghapus unit');
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
            
            // Form submit event (Create / Update)
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const idInput = document.getElementById('jenisKegiatanId');
                    const input = document.getElementById('jenisKegiatanInput');
                    const saveBtn = document.getElementById('saveJenisKegiatanBtn');
                    const saveBtnText = document.getElementById('saveBtnText');
                    
                    const jenisKegiatan = input ? input.value.trim() : '';
                    if (!jenisKegiatan) {
                        alert('Mohon isi nama kegiatan');
                        input?.focus();
                        return;
                    }

                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert('Sesi Anda telah berakhir. Silakan login kembali.');
                        window.location.replace('/login');
                        return;
                    }

                    const isEdit = idInput && idInput.value;
                    const url = isEdit ? `/api/jenis-kegiatan/${idInput.value}` : '/api/jenis-kegiatan';
                    const method = isEdit ? 'PUT' : 'POST';

                    const originalText = saveBtnText ? saveBtnText.textContent : 'Simpan';
                    if (saveBtn) saveBtn.disabled = true;
                    if (saveBtnText) saveBtnText.textContent = 'Menyimpan...';

                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ jenis_kegiatan: jenisKegiatan })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            closeJenisKegiatanModal();
                            await loadJenisKegiatan();
                        } else {
                            alert(result.message || 'Gagal menyimpan kegiatan');
                        }
                    } catch (error) {
                        console.error('Error saving jenis kegiatan:', error);
                        alert('Terjadi kesalahan koneksi saat menyimpan data');
                    } finally {
                        if (saveBtn) saveBtn.disabled = false;
                        if (saveBtnText) saveBtnText.textContent = originalText;
                    }
                });
            }

            // Unit Ruangan modal events
            const closeUnitModalBtn = document.getElementById('closeUnitModal');
            const cancelUnitModalBtn = document.getElementById('cancelUnitModal');
            const unitModal = document.getElementById('unitRuanganModal');
            const unitForm = document.getElementById('unitRuanganForm');

            if (closeUnitModalBtn) closeUnitModalBtn.addEventListener('click', closeUnitModal);
            if (cancelUnitModalBtn) cancelUnitModalBtn.addEventListener('click', closeUnitModal);
            if (unitModal) {
                unitModal.addEventListener('click', function(e) {
                    if (e.target === unitModal) closeUnitModal();
                });
            }
            if (unitForm) {
                unitForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const token = localStorage.getItem('token');
                    const idInput = document.getElementById('unitRuanganId');
                    const input = document.getElementById('namaRuanganInput');
                    const saveBtn = document.getElementById('saveUnitBtn');
                    const saveBtnText = document.getElementById('saveUnitBtnText');

                    const nama = input ? input.value.trim() : '';
                    if (!nama) {
                        alert('Mohon isi nama unit / ruangan');
                        input?.focus();
                        return;
                    }

                    if (!token) {
                        alert('Sesi Anda telah berakhir. Silakan login kembali.');
                        window.location.replace('/login');
                        return;
                    }

                    const isEdit = idInput && idInput.value;
                    const url = isEdit ? `/api/unit-ruangan/${idInput.value}` : '/api/unit-ruangan';
                    const method = isEdit ? 'PUT' : 'POST';

                    const originalText = saveBtnText ? saveBtnText.textContent : 'Simpan';
                    if (saveBtn) saveBtn.disabled = true;
                    if (saveBtnText) saveBtnText.textContent = 'Menyimpan...';

                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ nama_ruangan: nama })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            closeUnitModal();
                            await loadUnitRuangan();
                        } else {
                            alert(result.message || 'Gagal menyimpan unit / ruangan');
                        }
                    } catch (error) {
                        console.error('Error saving unit ruangan:', error);
                        alert('Terjadi kesalahan koneksi saat menyimpan data');
                    } finally {
                        if (saveBtn) saveBtn.disabled = false;
                        if (saveBtnText) saveBtnText.textContent = originalText;
                    }
                });
            }
        });
        
        // Helper function to show no data message
        function showNoDataMessage(message, showProfileAction = false) {
            const noDataMessage = document.getElementById('noDataMessage');
            if (noDataMessage) {
                noDataMessage.innerHTML = `
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-4"></i>
                    <p class="no-data-text text-yellow-400 font-medium"></p>
                    ${showProfileAction ? '<button type="button" class="mt-4 px-5 py-3 gradient-blue rounded-xl text-white font-semibold" onclick="showProfile()">Lengkapi Profil</button>' : '<p class="text-gray-400 text-sm mt-2">Silakan coba kembali atau hubungi administrator jika masalah berlanjut.</p>'}
                `;
                noDataMessage.querySelector('.no-data-text').textContent = message;
                noDataMessage.classList.remove('hidden');
            }
        }
        
        // Content switching with animations
        function hideAllContent() {
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden');
            });
        }

        function updateMobileNav(sectionName) {
            const mobileBackBtn = document.getElementById('mobileNavBackBtn');
            const openSidebarBtn = document.getElementById('openSidebar');
            const topNavTitle = document.getElementById('topNavTitle');

            if (mobileBackBtn && openSidebarBtn) {
                if (sectionName === 'dashboard') {
                    mobileBackBtn.classList.add('hidden');
                    mobileBackBtn.classList.remove('inline-flex');
                    openSidebarBtn.classList.remove('hidden');
                } else {
                    mobileBackBtn.classList.remove('hidden');
                    mobileBackBtn.classList.add('inline-flex');
                    openSidebarBtn.classList.add('hidden');
                }
            }

            // Update top navigation title
            if (topNavTitle) {
                const titles = {
                    'dashboard': 'e-Kinerja Dashboard',
                    'master-kegiatan': 'Input Kegiatan',
                    'master-unit': 'Master Unit / Ruangan',
                    'profile': 'Profil Saya',
                    'reports': 'Laporan Kinerja',
                    'tasks': 'Daftar Tugas'
                };
                topNavTitle.textContent = titles[sectionName] || 'e-Kinerja';
            }
        }
        
        function showDashboard() {
            hideAllContent();
            const content = document.getElementById('dashboardContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            updateMobileNav('dashboard');
            closeSidebarOnMobile();
        }

        function showMasterKegiatan() {
            hideAllContent();
            const content = document.getElementById('masterKegiatanContent');
            if (content) {
                content.classList.remove('hidden');
                content.classList.add('fade-in');
            }
            loadJenisKegiatan();
            updateMobileNav('master-kegiatan');
            closeSidebarOnMobile();
        }

        function showMasterUnit() {
            hideAllContent();
            const content = document.getElementById('masterUnitContent');
            if (content) {
                content.classList.remove('hidden');
                content.classList.add('fade-in');
            }
            loadUnitRuangan();
            updateMobileNav('master-unit');
            closeSidebarOnMobile();
        }

        function scrollToActivities() {
            showMasterKegiatan();
        }
        
        function showProfile() {
            hideAllContent();
            const content = document.getElementById('profileContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            loadProfile();
            updateMobileNav('profile');
            closeSidebarOnMobile();
        }
        
        function showTasks() {
            hideAllContent();
            const content = document.getElementById('tasksContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            updateMobileNav('tasks');
            closeSidebarOnMobile();
        }
        
        function showReports() {
            hideAllContent();
            const content = document.getElementById('reportsContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            updateMobileNav('reports');
            closeSidebarOnMobile();
        }
        
        // Load profile
        function loadProfile() {
            const user = getStoredUser();
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
            const user = getStoredUser();
            document.getElementById('profileView').classList.add('hidden');
            document.getElementById('profileEdit').classList.remove('hidden');
            
            document.getElementById('profileEdit').innerHTML = `
        <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 w-full">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3 min-w-0">
                    <button type="button" onclick="cancelEditProfile()" class="p-2 sm:p-2.5 glass rounded-xl hover:bg-white hover:bg-opacity-20 transition-all text-white flex items-center justify-center flex-shrink-0" title="Kembali ke Profil">
                        <i class="fas fa-arrow-left text-base sm:text-lg"></i>
                    </button>
                    <h3 class="text-xl sm:text-2xl font-bold text-white truncate">Edit Profil</h3>
                </div>
                <button type="button" onclick="cancelEditProfile()" class="p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-all text-white" title="Tutup">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <form id="editProfileForm" class="space-y-6">
                <!-- Personal Information Section -->
                <div class="profile-form-section rounded-xl p-4 sm:p-6">
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
                <div class="profile-form-section rounded-xl p-4 sm:p-6">
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
                        <div class="profile-form-section rounded-xl p-4 sm:p-6">
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
                            <div class="profile-password-note mt-4 p-3 rounded-lg">
                                <p class="text-xs sm:text-sm flex items-start">
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
        
        async function logout() {
            try {
                if (token) {
                    await fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });
                }
            } catch (error) {
                console.error('Logout API gagal:', error);
            } finally {
                clearSession();
                window.location.replace('/login');
            }
        }
        
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

            initializeDashboard();
        });
    </script>
</body>
</html>
