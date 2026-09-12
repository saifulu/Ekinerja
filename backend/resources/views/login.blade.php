<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - e-Kinerja</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#064e3b">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="e-Kinerja">
    <meta name="description" content="Login ke aplikasi e-Kinerja - Sistem Manajemen Kinerja">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/icons/icon-152x152.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #090e1a;
            color: #f8fafc;
        }
        
        .gradient-bg {
            background: radial-gradient(circle at 85% 15%, rgba(16, 185, 129, 0.16), transparent 35%),
                        radial-gradient(circle at 15% 85%, rgba(13, 148, 136, 0.12), transparent 40%),
                        linear-gradient(150deg, #090e1a 0%, #0f172a 45%, #052e24 100%);
        }
        
        .glass-effect {
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.22);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55), 0 0 30px rgba(16, 185, 129, 0.08);
        }
        
        .input-focus:focus {
            outline: none;
            border-color: #34d399;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        
        .btn-hover {
            transition: all 0.25s ease;
        }
        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
        }
        .btn-hover:active {
            transform: translateY(0);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .slide-up {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(24px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .floating {
            animation: floating 4s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        /* PWA Install Button */
        .pwa-install-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 18px;
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.4);
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            z-index: 1000;
            display: none;
            align-items: center;
            gap: 8px;
        }
        .pwa-install-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(16, 185, 129, 0.55);
        }
        .pwa-install-btn.show {
            display: flex;
        }
    </style>
    @include('partials.mobile-ux')
</head>
<body class="gradient-bg min-h-screen flex flex-col justify-between p-4 sm:p-6 selection:bg-emerald-500 selection:text-white">
    <!-- Subtle Background Glow Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-32 -right-32 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/4 left-10 w-24 h-24 bg-emerald-400/5 rounded-full blur-xl floating"></div>
    </div>
    
    <!-- Top Spacer for centering on mobile -->
    <div class="hidden sm:block"></div>

    <div class="w-full max-w-md mx-auto my-auto py-4">
        <!-- Logo and Header -->
        <div class="text-center mb-6 fade-in">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white shadow-lg shadow-emerald-500/30 mb-3 transition-transform hover:scale-105 duration-300">
                <i class="fas fa-clipboard-check text-2xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                e-Kinerja
            </h1>
            <p class="text-emerald-400/90 text-xs sm:text-sm font-medium mt-0.5">
                Sistem Manajemen Kinerja
            </p>
        </div>

        <!-- Login Form Card -->
        <div class="glass-effect rounded-2xl p-6 sm:p-8 slide-up">
            <div class="text-center mb-6">
                <h2 class="text-lg sm:text-xl font-bold text-white mb-1">Selamat Datang</h2>
                <p class="text-slate-400 text-xs sm:text-sm">Masuk ke akun Anda untuk melanjutkan</p>
            </div>
            
            @if (session('error') || request('error'))
                <div class="mb-4 p-3.5 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-xs sm:text-sm flex items-start gap-2" role="alert">
                    <i class="fas fa-exclamation-circle text-rose-400 text-base flex-shrink-0 mt-0.5"></i>
                    <span>{{ session('error') ?? request('error') }}</span>
                </div>
            @endif

            <form class="space-y-4" id="loginForm">
                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-envelope text-emerald-400 mr-1.5"></i>Email Address
                    </label>
                    <div class="relative">
                        <input id="email" name="email" type="email" required autocomplete="email"
                               class="input-focus w-full px-4 py-3 bg-slate-900/90 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm sm:text-base transition-all duration-200" 
                               placeholder="Masukkan email Anda">
                    </div>
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-lock text-emerald-400 mr-1.5"></i>Password
                    </label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="input-focus w-full px-4 py-3 pr-11 bg-slate-900/90 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm sm:text-base transition-all duration-200" 
                               placeholder="Masukkan password Anda">
                        <button type="button" onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-emerald-400 transition-colors focus:outline-none"
                                title="Tampilkan / Sembunyikan Password">
                            <i id="passwordIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center cursor-pointer select-none">
                        <input id="remember-me" name="remember-me" type="checkbox" 
                               class="h-4 w-4 text-emerald-500 focus:ring-emerald-500/30 border-slate-700 rounded bg-slate-900 transition cursor-pointer">
                        <span class="ml-2 text-xs text-slate-300">Ingat saya</span>
                    </label>
                    <div>
                        <a href="#" class="text-xs font-medium text-emerald-400 hover:text-emerald-300 transition-colors">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="submitBtn"
                            class="btn-hover w-full flex items-center justify-center py-3 px-4 rounded-xl text-white text-sm sm:text-base font-semibold bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/25 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200">
                        <span id="loginBtnIcon" class="mr-2">
                            <i class="fas fa-sign-in-alt text-emerald-200"></i>
                        </span>
                        <span id="loginText">Masuk ke Sistem</span>
                        <div id="loginSpinner" class="hidden ml-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-5">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-700/60"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 py-0.5 bg-slate-900/90 text-slate-400 rounded-full border border-slate-700/60">Atau masuk dengan</span>
                    </div>
                </div>

                <!-- Google Sign In -->
                <div class="mt-4">
                    <a href="/auth/google"
                       class="w-full flex justify-center items-center py-2.5 px-4 border border-slate-700/80 rounded-xl shadow-sm bg-slate-900/80 hover:bg-slate-800 text-xs sm:text-sm font-medium text-slate-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
                        <img class="h-4 w-4 mr-2" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo">
                        <span>Google</span>
                    </a>
                </div>
            </div>

            <!-- Message Notification -->
            <div id="message" class="hidden mt-4 p-3.5 rounded-xl text-xs sm:text-sm transition-all duration-300"></div>
        </div>

        <!-- Register Link -->
        <div class="mt-5 text-center">
            <p class="text-slate-400 text-xs sm:text-sm">
                Belum punya akun? 
                <a href="/register" class="text-emerald-400 font-semibold hover:text-emerald-300 transition-colors">
                    Daftar di sini
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center mt-3">
            <p class="text-slate-500 text-xs">
                © 2025 e-Kinerja. Dikembangkan dengan ❤️
            </p>
        </div>
    </div>

    <!-- Bottom Spacer -->
    <div class="hidden sm:block"></div>

    <!-- PWA Install Button -->
    <button id="pwaInstallBtn" class="pwa-install-btn">
        <i class="fas fa-download"></i>
        <span>Install App</span>
    </button>

    <!-- PWA Install Modal -->
    <div id="pwaInstallModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="glass-effect rounded-2xl p-6 max-w-sm w-full border border-emerald-500/25 text-white shadow-2xl">
            <div class="text-center">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-mobile-alt text-xl"></i>
                </div>
                <h3 class="text-base font-bold mb-1.5 text-white">Install e-Kinerja</h3>
                <p class="text-slate-400 text-xs mb-5">Install aplikasi ini di perangkat Anda untuk akses yang lebih cepat dan mudah.</p>
                <div class="flex space-x-3">
                    <button id="installCancel" class="flex-1 px-4 py-2.5 bg-slate-800 hover:bg-slate-700 border border-white/10 rounded-xl text-slate-300 text-xs font-semibold transition-colors">
                        Batal
                    </button>
                    <button id="installConfirm" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-emerald-500/20 transition-colors flex items-center justify-center gap-1.5">
                        <i class="fas fa-download text-xs"></i>
                        <span>Install</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash text-emerald-400';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye text-slate-400';
            }
        }
        
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('message');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');
            const loginBtnIcon = document.getElementById('loginBtnIcon');
            const submitButton = document.getElementById('submitBtn');
            
            // Show loading state
            submitButton.disabled = true;
            loginText.textContent = 'Memproses...';
            if (loginBtnIcon) loginBtnIcon.classList.add('hidden');
            loginSpinner.classList.remove('hidden');
            messageDiv.classList.add('hidden');
            
            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    
                    messageDiv.className = 'mt-4 p-3.5 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm flex items-center gap-2 transition-all duration-300';
                    messageDiv.innerHTML = `
                        <i class="fas fa-check-circle text-emerald-400 text-base flex-shrink-0"></i>
                        <span>Login berhasil! Mengarahkan ke dashboard...</span>
                    `;
                    messageDiv.classList.remove('hidden');
                    
                    loginText.textContent = 'Berhasil!';
                    loginSpinner.classList.add('hidden');
                    if (loginBtnIcon) {
                        loginBtnIcon.innerHTML = '<i class="fas fa-check text-emerald-200"></i>';
                        loginBtnIcon.classList.remove('hidden');
                    }
                    
                    setTimeout(() => {
                        const user = data.data.user;
                        if (user && user.role === 'admin') {
                            window.location.href = '/dashboard';
                        } else {
                            window.location.href = '/user-dashboard';
                        }
                    }, 800);
                } else {
                    throw new Error(data.message || 'Login gagal, periksa email dan password Anda');
                }
            } catch (error) {
                messageDiv.className = 'mt-4 p-3.5 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-xs sm:text-sm flex items-center gap-2 transition-all duration-300';
                messageDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle text-rose-400 text-base flex-shrink-0"></i>
                    <span>${error.message}</span>
                `;
                messageDiv.classList.remove('hidden');
                
                // Reset button state
                submitButton.disabled = false;
                loginText.textContent = 'Masuk ke Sistem';
                if (loginBtnIcon) loginBtnIcon.classList.remove('hidden');
                loginSpinner.classList.add('hidden');
            }
        });
        
        // PWA Install Functionality
        let deferredPrompt;
        const pwaInstallBtn = document.getElementById('pwaInstallBtn');
        const pwaInstallModal = document.getElementById('pwaInstallModal');
        const installCancel = document.getElementById('installCancel');
        const installConfirm = document.getElementById('installConfirm');
        
        // Register service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => console.log('SW registered:', registration))
                .catch(error => console.log('SW registration failed:', error));
        }
        
        // Listen for beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (pwaInstallBtn) {
                pwaInstallBtn.classList.add('show');
                pwaInstallBtn.style.display = 'flex';
            }
        });
        
        // Check if app is already installed
        window.addEventListener('appinstalled', () => {
            if (pwaInstallBtn) {
                pwaInstallBtn.classList.remove('show');
                pwaInstallBtn.style.display = 'none';
            }
        });
        
        // Handle install button click
        if (pwaInstallBtn) {
            pwaInstallBtn.addEventListener('click', () => {
                if (pwaInstallModal) pwaInstallModal.classList.remove('hidden');
            });
        }
        
        // Handle modal cancel
        if (installCancel) {
            installCancel.addEventListener('click', () => {
                if (pwaInstallModal) pwaInstallModal.classList.add('hidden');
            });
        }
        
        // Handle modal confirm
        if (installConfirm) {
            installConfirm.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    deferredPrompt = null;
                    if (pwaInstallModal) pwaInstallModal.classList.add('hidden');
                    
                    if (outcome === 'accepted' && pwaInstallBtn) {
                        pwaInstallBtn.classList.remove('show');
                        pwaInstallBtn.style.display = 'none';
                    }
                }
            });
        }
        
        // Hide install button if app is in standalone mode
        if (window.matchMedia('(display-mode: standalone)').matches && pwaInstallBtn) {
            pwaInstallBtn.style.display = 'none';
        }
    </script>
</body>
</html>
