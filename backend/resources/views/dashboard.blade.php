<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - e-Kinerja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.1);
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
        
        .gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .gradient-pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .gradient-orange {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
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
            background: linear-gradient(180deg, #1e3a8a 0%, #312e81 50%, #1e1b4b 100%);
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
        
        /* Mobile-first responsive improvements */
        @media (max-width: 640px) {
            .sidebar-gradient {
                width: 100vw;
                max-width: 320px;
            }
            
            .morphism-card {
                padding: 1rem;
            }
            
            .text-4xl {
                font-size: 2rem;
            }
            
            .text-3xl {
                font-size: 1.5rem;
            }
            
            .text-2xl {
                font-size: 1.25rem;
            }
            
            .gap-8 {
                gap: 1rem;
            }
            
            .mb-8 {
                margin-bottom: 1.5rem;
            }
            
            .p-8 {
                padding: 1rem;
            }
            
            .p-6 {
                padding: 0.75rem;
            }
        }
        
        @media (max-width: 768px) {
            .grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .grid-cols-2 {
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
        
        .morphism-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen flex relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 4s;"></div>
        </div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-gradient text-white w-80 min-h-screen p-4 sm:p-6 transform -translate-x-full transition-all duration-500 ease-in-out lg:translate-x-0 lg:static lg:inset-0 glass-dark slide-in relative z-10">
            <div class="flex items-center justify-between mb-8 sm:mb-12">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-purple rounded-xl flex items-center justify-center neon-glow">
                        <i class="fas fa-crown text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gradient">Admin Panel</h2>
                        <p class="text-xs sm:text-sm text-gray-300">Executive Dashboard</p>
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
                        <p class="text-xs text-gray-300 truncate">Overview & Analytics</p>
                    </div>
                </a>
                
                <a href="#" onclick="showAddUser()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-green-400 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-plus text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Tambah User</span>
                        <p class="text-xs text-gray-300 truncate">Create New Account</p>
                    </div>
                </a>
                
                <a href="#" onclick="showUserList()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-purple-400 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Daftar User</span>
                        <p class="text-xs text-gray-300 truncate">Manage Users</p>
                    </div>
                </a>
                
                <a href="#" onclick="showProfile()" class="nav-item flex items-center space-x-3 sm:space-x-4 text-white hover:bg-white hover:bg-opacity-20 rounded-xl p-3 sm:p-4 transition-all duration-300 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-pink-400 to-pink-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-cog text-white text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="font-semibold text-sm sm:text-base">Profil</span>
                        <p class="text-xs text-gray-300 truncate">Account Settings</p>
                    </div>
                </a>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="morphism-card rounded-xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-purple rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">System Status</p>
                            <p class="text-xs text-green-300">All Systems Operational</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative z-10">
            <!-- Top Navigation -->
            <nav class="glass backdrop-blur-xl border-b border-white border-opacity-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 sm:h-20">
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <button id="openSidebar" class="lg:hidden p-2 sm:p-3 hover:bg-white hover:bg-opacity-20 rounded-xl transition-all">
                                <i class="fas fa-bars text-white text-lg sm:text-xl"></i>
                            </button>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-white text-lg sm:text-2xl font-bold truncate">e-Kinerja Dashboard</h1>
                                <p class="text-gray-200 text-xs sm:text-sm hidden sm:block">Advanced Management System</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-6">
                            <div class="hidden sm:flex items-center space-x-4">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span id="userWelcome" class="text-white font-medium text-sm sm:text-base"></span>
                            </div>
                            <button onclick="logout()" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 sm:px-6 py-2 sm:py-3 rounded-xl transition-all duration-300 hover:scale-105 shadow-lg text-sm sm:text-base">
                                <i class="fas fa-sign-out-alt mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">Logout</span>
                                <span class="sm:hidden">Keluar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Dashboard Content -->
                <div id="dashboardContent" class="content-section fade-in">
                    <!-- Welcome Section -->
                    <div class="morphism-card rounded-2xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 hover-scale">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Selamat Datang di e-Kinerja</h2>
                                <p class="text-gray-200 text-base sm:text-lg">Dashboard admin untuk mengelola sistem e-Kinerja dengan teknologi terdepan</p>
                            </div>
                            <div class="floating flex-shrink-0">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 gradient-purple rounded-2xl flex items-center justify-center neon-glow">
                                    <i class="fas fa-rocket text-white text-2xl sm:text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div id="userInfo" class="mt-4 sm:mt-6 p-4 sm:p-6 glass rounded-xl"></div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 mb-6 sm:mb-8">
                        <div class="morphism-card rounded-2xl p-4 sm:p-6 card-hover pulse-glow">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-blue rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-users text-white text-lg sm:text-xl"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-white font-semibold text-base sm:text-lg">Total Users</h3>
                                            <p class="text-gray-300 text-xs sm:text-sm">Registered Members</p>
                                        </div>
                                    </div>
                                    <p class="text-3xl sm:text-4xl font-bold text-white" id="totalUsers">-</p>
                                </div>
                                <div class="text-green-400 flex-shrink-0 ml-2">
                                    <i class="fas fa-arrow-up text-xl sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="morphism-card rounded-2xl p-4 sm:p-6 card-hover pulse-glow" style="animation-delay: 0.2s;">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-pink rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user-check text-white text-lg sm:text-xl"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-white font-semibold text-base sm:text-lg">Active Users</h3>
                                            <p class="text-gray-300 text-xs sm:text-sm">Currently Online</p>
                                        </div>
                                    </div>
                                    <p class="text-3xl sm:text-4xl font-bold text-white" id="activeUsers">-</p>
                                </div>
                                <div class="text-blue-400 flex-shrink-0 ml-2">
                                    <i class="fas fa-chart-line text-xl sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="morphism-card rounded-2xl p-4 sm:p-6 card-hover pulse-glow" style="animation-delay: 0.4s;">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-orange rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-crown text-white text-lg sm:text-xl"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-white font-semibold text-base sm:text-lg">Admins</h3>
                                            <p class="text-gray-300 text-xs sm:text-sm">System Administrators</p>
                                        </div>
                                    </div>
                                    <p class="text-3xl sm:text-4xl font-bold text-white" id="totalAdmins">-</p>
                                </div>
                                <div class="text-purple-400 flex-shrink-0 ml-2">
                                    <i class="fas fa-shield-alt text-xl sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Advanced Analytics Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="morphism-card rounded-2xl p-6 card-hover">
                            <h3 class="text-white text-xl font-bold mb-4">System Performance</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">CPU Usage</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-32 h-2 bg-gray-600 rounded-full overflow-hidden">
                                            <div class="w-3/4 h-full gradient-blue rounded-full"></div>
                                        </div>
                                        <span class="text-white font-semibold">75%</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Memory</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-32 h-2 bg-gray-600 rounded-full overflow-hidden">
                                            <div class="w-1/2 h-full gradient-pink rounded-full"></div>
                                        </div>
                                        <span class="text-white font-semibold">50%</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Storage</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-32 h-2 bg-gray-600 rounded-full overflow-hidden">
                                            <div class="w-2/3 h-full gradient-orange rounded-full"></div>
                                        </div>
                                        <span class="text-white font-semibold">67%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="morphism-card rounded-2xl p-6 card-hover">
                            <h3 class="text-white text-xl font-bold mb-4">Recent Activities</h3>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3 p-3 glass rounded-lg">
                                    <div class="w-8 h-8 gradient-blue rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-plus text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white text-sm font-medium">New user registered</p>
                                        <p class="text-gray-400 text-xs">2 minutes ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 p-3 glass rounded-lg">
                                    <div class="w-8 h-8 gradient-pink rounded-full flex items-center justify-center">
                                        <i class="fas fa-edit text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white text-sm font-medium">Profile updated</p>
                                        <p class="text-gray-400 text-xs">5 minutes ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 p-3 glass rounded-lg">
                                    <div class="w-8 h-8 gradient-orange rounded-full flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white text-sm font-medium">Security scan completed</p>
                                        <p class="text-gray-400 text-xs">10 minutes ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add User Content -->
                <div id="addUserContent" class="content-section hidden fade-in">
                    <div class="morphism-card rounded-2xl p-8 hover-scale">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-16 h-16 gradient-purple rounded-2xl flex items-center justify-center neon-glow">
                                <i class="fas fa-user-plus text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white">Tambah User Baru</h2>
                                <p class="text-gray-300">Buat akun pengguna baru dengan informasi lengkap</p>
                            </div>
                        </div>
                        
                        <form id="addUserForm" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-semibold text-white">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" required 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-semibold text-white">Email</label>
                                    <input type="email" id="email" name="email" required 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-white">Password</label>
                                    <input type="password" id="password" name="password" required 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label for="role" class="block text-sm font-semibold text-white">Role</label>
                                    <select id="role" name="role" required 
                                            class="w-full px-4 py-3 glass rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                        <option value="">Pilih Role</option>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Additional Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-semibold text-white">Nomor Telepon</label>
                                    <input type="text" id="phone" name="phone" 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label for="nip" class="block text-sm font-semibold text-white">NIP</label>
                                    <input type="text" id="nip" name="nip" 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="golongan" class="block text-sm font-semibold text-white">Golongan</label>
                                    <input type="text" id="golongan" name="golongan" 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label for="instansi" class="block text-sm font-semibold text-white">Instansi</label>
                                    <input type="text" id="instansi" name="instansi" 
                                           class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="ruangan" class="block text-sm font-semibold text-white">Ruangan</label>
                                <input type="text" id="ruangan" name="ruangan" 
                                       class="w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                            
                            <div class="flex justify-end space-x-4 pt-6">
                                <button type="button" onclick="showDashboard()" 
                                        class="px-6 py-3 glass rounded-xl text-white hover:bg-white hover:bg-opacity-20 transition-all duration-300">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="px-8 py-3 gradient-purple rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300 neon-glow">
                                    <i class="fas fa-plus mr-2"></i>Tambah User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- User List Content -->
                <div id="userListContent" class="content-section hidden fade-in">
                    <div class="morphism-card rounded-2xl p-8 hover-scale">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center neon-glow">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-white">Daftar User</h2>
                                    <p class="text-gray-300">Kelola semua pengguna sistem</p>
                                </div>
                            </div>
                            <button onclick="showAddUser()" class="px-6 py-3 gradient-purple rounded-xl text-white font-semibold hover:scale-105 transition-all duration-300 neon-glow">
                                <i class="fas fa-plus mr-2"></i>Tambah User
                            </button>
                        </div>
                        <div id="userTable" class="overflow-x-auto">
                            <!-- User table will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div id="profileContent" class="content-section hidden fade-in">
                    <div class="morphism-card rounded-2xl p-8 hover-scale">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-16 h-16 gradient-pink rounded-2xl flex items-center justify-center neon-glow">
                                <i class="fas fa-user-cog text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white">Profil Admin</h2>
                                <p class="text-gray-300">Kelola informasi akun administrator</p>
                            </div>
                        </div>
                        <div id="profileInfo">
                            <!-- Profile info will be loaded here -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="morphism-card rounded-2xl p-8 flex items-center space-x-4">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-400"></div>
            <span class="text-white text-lg font-semibold">Memproses...</span>
        </div>
    </div>

    <script>
        // Check if user is logged in and is admin
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        
        if (!token) {
            window.location.href = '/login';
        } else if (user.role !== 'admin') {
            // Redirect user biasa ke dashboard user
            window.location.href = '/user-dashboard';
        } else {
            document.getElementById('userInfo').innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass rounded-xl p-4">
                        <h4 class="font-bold text-white mb-2">Administrator</h4>
                        <p class="text-gray-300">${user.name}</p>
                    </div>
                    <div class="glass rounded-xl p-4">
                        <h4 class="font-bold text-white mb-2">Email</h4>
                        <p class="text-gray-300">${user.email}</p>
                    </div>
                    <div class="glass rounded-xl p-4">
                        <h4 class="font-bold text-white mb-2">Role</h4>
                        <span class="px-3 py-1 bg-purple-500 text-white text-sm rounded-full">${user.role}</span>
                    </div>
                </div>
            `;
            document.getElementById('userWelcome').textContent = `${user.name}`;
        }
        
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        
        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });
        
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
        
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
            loadDashboardStats();
        }
        
        function showAddUser() {
            hideAllContent();
            const content = document.getElementById('addUserContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
        }
        
        function showUserList() {
            hideAllContent();
            const content = document.getElementById('userListContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            loadUsers();
        }
        
        function showProfile() {
            hideAllContent();
            const content = document.getElementById('profileContent');
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            loadProfile();
        }
        
        // Load dashboard stats
        async function loadDashboardStats() {
            try {
                const response = await fetch('/api/admin/stats', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const stats = await response.json();
                    document.getElementById('totalUsers').textContent = stats.total_users || '0';
                    document.getElementById('activeUsers').textContent = stats.active_users || '0';
                    document.getElementById('totalAdmins').textContent = stats.total_admins || '0';
                } else if (response.status === 401) {
                    // Token expired atau tidak valid
                    console.error('Token expired, redirecting to login');
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    window.location.href = '/login';
                } else {
                    console.error('Failed to load stats:', response.status, response.statusText);
                    // Set default values
                    document.getElementById('totalUsers').textContent = '0';
                    document.getElementById('activeUsers').textContent = '0';
                    document.getElementById('totalAdmins').textContent = '0';
                }
            } catch (error) {
                console.error('Error loading stats:', error);
                // Set default values on network error
                document.getElementById('totalUsers').textContent = '0';
                document.getElementById('activeUsers').textContent = '0';
                document.getElementById('totalAdmins').textContent = '0';
            }
        }
        
        // Add user form submission
        document.getElementById('addUserForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            showLoading();
            
            const formData = new FormData(e.target);
            const userData = Object.fromEntries(formData);
            
            try {
                const response = await fetch('/api/admin/users', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(userData)
                });
                
                if (response.ok) {
                    alert('User berhasil ditambahkan!');
                    e.target.reset();
                    showUserList();
                } else {
                    const error = await response.json();
                    alert('Error: ' + (error.message || 'Gagal menambah user'));
                }
            } catch (error) {
                console.error('Error adding user:', error);
                alert('Terjadi kesalahan saat menambah user');
            } finally {
                hideLoading();
            }
        });
        
        // Load users
        async function loadUsers() {
            try {
                const response = await fetch('/api/admin/users', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const users = await response.json();
                    displayUsers(users);
                } else {
                    console.error('Failed to load users');
                    document.getElementById('userTable').innerHTML = '<p class="text-white">Gagal memuat data user</p>';
                }
            } catch (error) {
                console.error('Error loading users:', error);
                document.getElementById('userTable').innerHTML = '<p class="text-white">Terjadi kesalahan saat memuat data</p>';
            }
        }
        
        // Display users in table
        function displayUsers(users) {
            document.getElementById('userTable').innerHTML = `
                <div class="glass rounded-xl overflow-hidden">
                    <table class="min-w-full">
                        <thead class="gradient-purple">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NIP</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            ${users.map(user => `
                                <tr class="hover:bg-white hover:bg-opacity-10 transition-all">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">${user.id}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">${user.name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${user.email}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                            user.role === 'admin' ? 'bg-purple-500 text-white' : 'bg-green-500 text-white'
                                        }">
                                            ${user.role}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${user.nip || '-'}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <button onclick="editUser(${user.id})" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        }
        
        // Load profile
        function loadProfile() {
            document.getElementById('profileInfo').innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="glass rounded-xl p-6">
                        <div class="flex items-center space-x-6 mb-6">
                            <div class="w-24 h-24 gradient-purple rounded-2xl flex items-center justify-center neon-glow">
                                <i class="fas fa-user text-white text-3xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">${user.name}</h3>
                                <p class="text-gray-300 text-lg">${user.email}</p>
                                <span class="px-4 py-2 bg-purple-500 text-white text-sm rounded-full font-semibold">${user.role}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 glass rounded-lg">
                                <span class="text-gray-300">Status Akun</span>
                                <span class="text-green-400 font-semibold">Aktif</span>
                            </div>
                            <div class="flex justify-between items-center p-3 glass rounded-lg">
                                <span class="text-gray-300">Terakhir Login</span>
                                <span class="text-white">Hari ini</span>
                            </div>
                            <div class="flex justify-between items-center p-3 glass rounded-lg">
                                <span class="text-gray-300">Hak Akses</span>
                                <span class="text-purple-400 font-semibold">Full Access</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass rounded-xl p-6">
                        <h4 class="text-xl font-bold text-white mb-6">Pengaturan Keamanan</h4>
                        <div class="space-y-4">
                            <button class="w-full p-4 glass rounded-lg text-left hover:bg-white hover:bg-opacity-20 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-key text-blue-400"></i>
                                        <span class="text-white font-medium">Ubah Password</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </button>
                            
                            <button class="w-full p-4 glass rounded-lg text-left hover:bg-white hover:bg-opacity-20 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-shield-alt text-green-400"></i>
                                        <span class="text-white font-medium">Autentikasi 2 Faktor</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </button>
                            
                            <button class="w-full p-4 glass rounded-lg text-left hover:bg-white hover:bg-opacity-20 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-history text-purple-400"></i>
                                        <span class="text-white font-medium">Riwayat Login</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Utility functions
        function showLoading() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }
        
        function hideLoading() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }
        
        function editUser(userId) {
            // Implement edit user functionality
            alert('Edit user functionality will be implemented');
        }
        
        function deleteUser(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                // Implement delete user functionality
                alert('Delete user functionality will be implemented');
            }
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
            // Add hover effects to navigation items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
</body>
</html>