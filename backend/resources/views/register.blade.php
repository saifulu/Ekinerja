<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Baru - e-Kinerja</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#064e3b">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="e-Kinerja">
    <meta name="description" content="Pendaftaran Akun Baru Pegawai - Sistem Manajemen Kinerja">
    
    <!-- PWA Manifest & Icons -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-152x152.png">
    
    <!-- Tailwind CSS & Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
            box-sizing: border-box;
        }
        
        body {
            background-color: #090e1a;
            color: #f8fafc;
            min-height: 100vh;
        }
        
        .gradient-bg {
            background: radial-gradient(circle at 85% 15%, rgba(16, 185, 129, 0.16), transparent 35%),
                        radial-gradient(circle at 15% 85%, rgba(13, 148, 136, 0.12), transparent 40%),
                        linear-gradient(150deg, #090e1a 0%, #0f172a 45%, #052e24 100%);
        }
        
        .glass-effect {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.22);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.55), 0 0 35px rgba(16, 185, 129, 0.08);
        }
        
        .form-control-pro {
            display: block;
            width: 100%;
            height: 48px;
            padding: 0 16px;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid #334155;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .form-control-pro:focus {
            outline: none;
            border-color: #34d399;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(15, 23, 42, 0.95);
        }
        
        .form-control-pro::placeholder {
            color: #64748b;
        }

        .form-control-pro.has-toggle {
            padding-right: 48px;
        }
        
        .input-icon-btn {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s;
            z-index: 2;
        }
        .input-icon-btn:hover {
            color: #34d399;
        }
        
        .btn-register-pro {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 50px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.35);
            transition: all 0.25s ease;
        }
        .btn-register-pro:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%);
        }
        .btn-register-pro:active {
            transform: translateY(0);
        }
        .btn-register-pro:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 14px 0;
        }
        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(51, 65, 85, 0.6);
        }
        .section-divider span {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }
        
        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .floating {
            animation: floating 4s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @include('partials.mobile-ux')
</head>
<body class="gradient-bg min-h-screen flex flex-col justify-between py-6 px-4 sm:px-6 selection:bg-emerald-500 selection:text-white">

    <!-- Background Subtle Glows -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 left-12 w-28 h-28 bg-emerald-400/5 rounded-full blur-xl floating"></div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-2xl mx-auto my-auto py-2">
        
        <!-- Logo & Header -->
        <div class="text-center mb-6 fade-in">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white shadow-lg shadow-emerald-500/30 mb-3 transition-transform hover:scale-105 duration-300">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Pendaftaran e-Kinerja
            </h1>
            <p class="text-emerald-400/90 text-xs sm:text-sm font-medium mt-1">
                Sistem Manajemen Kinerja & Logbook Pegawai
            </p>
        </div>

        <!-- Registration Card -->
        <div class="glass-effect rounded-2xl p-5 sm:p-8 fade-in">
            <div class="text-center mb-5">
                <h2 class="text-lg sm:text-xl font-bold text-white mb-1">Buat Akun Baru</h2>
                <p class="text-slate-400 text-xs sm:text-sm">Lengkapi data pribadi dan kepegawaian Anda di bawah ini</p>
            </div>

            <!-- Google Connected Alert -->
            <div id="googleConnectedAlert" class="hidden mb-5 p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-xs flex items-start gap-3 shadow-lg">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center flex-shrink-0 mt-0.5 border border-emerald-500/30">
                    <i class="fab fa-google text-emerald-400 text-base"></i>
                </div>
                <div>
                    <strong class="font-bold text-white text-sm block">Akun Google Terhubung!</strong>
                    <p class="text-slate-300 text-xs mt-0.5 leading-relaxed">
                        Nama dan Email Anda telah diambil dari akun Google. Silakan buat password dan lengkapi data kepegawaian Anda untuk menyelesaikan pendaftaran.
                    </p>
                </div>
            </div>

            <!-- Form -->
            <form id="registerForm" class="space-y-4">
                <input type="hidden" name="google_id" id="google_id">
                
                <!-- SECTION 1: DATA KEPEGAWAIAN -->
                <div class="section-divider">
                    <span><i class="fas fa-id-badge me-1"></i> Data Kepegawaian</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-user text-emerald-400 mr-1.5"></i>Nama Lengkap <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="name" name="name" required 
                               class="form-control-pro"
                               placeholder="Nama lengkap tanpa gelar"
                               autocomplete="name">
                    </div>

                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-id-card text-emerald-400 mr-1.5"></i>NIP Pegawai <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="nip" name="nip" required
                               class="form-control-pro"
                               placeholder="Contoh: 198501012010011001"
                               pattern="[0-9]*"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <!-- No. Telepon / WhatsApp -->
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-phone text-emerald-400 mr-1.5"></i>No. Telepon / WA <span class="text-rose-400">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" required
                               class="form-control-pro"
                               placeholder="Contoh: 081234567890"
                               pattern="[0-9]*"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <!-- Golongan -->
                    <div>
                        <label for="golongan" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-star text-emerald-400 mr-1.5"></i>Golongan / Pangkat <span class="text-rose-400">*</span>
                        </label>
                        <select id="golongan" name="golongan" required class="form-control-pro custom-select">
                            <option value="" class="bg-slate-900 text-slate-400">Pilih Golongan...</option>
                            <optgroup label="Golongan I (Juru)" class="bg-slate-900 text-slate-200">
                                <option value="Ia">Ia - Juru Muda</option>
                                <option value="Ib">Ib - Juru Muda Tingkat I</option>
                                <option value="Ic">Ic - Juru</option>
                                <option value="Id">Id - Juru Tingkat I</option>
                            </optgroup>
                            <optgroup label="Golongan II (Pengatur)" class="bg-slate-900 text-slate-200">
                                <option value="IIa">IIa - Pengatur Muda</option>
                                <option value="IIb">IIb - Pengatur Muda Tingkat I</option>
                                <option value="IIc">IIc - Pengatur</option>
                                <option value="IId">IId - Pengatur Tingkat I</option>
                            </optgroup>
                            <optgroup label="Golongan III (Penata)" class="bg-slate-900 text-slate-200">
                                <option value="IIIa">IIIa - Penata Muda</option>
                                <option value="IIIb">IIIb - Penata Muda Tingkat I</option>
                                <option value="IIIc">IIIc - Penata</option>
                                <option value="IIId">IIId - Penata Tingkat I</option>
                            </optgroup>
                            <optgroup label="Golongan IV (Pembina)" class="bg-slate-900 text-slate-200">
                                <option value="IVa">IVa - Pembina</option>
                                <option value="IVb">IVb - Pembina Tingkat I</option>
                                <option value="IVc">IVc - Pembina Utama Muda</option>
                                <option value="IVd">IVd - Pembina Utama Madya</option>
                                <option value="IVe">IVe - Pembina Utama</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Instansi -->
                    <div>
                        <label for="instansi" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-building text-emerald-400 mr-1.5"></i>Instansi / Rumah Sakit <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="instansi" name="instansi" required
                               class="form-control-pro uppercase"
                               placeholder="Nama rumah sakit / dinas"
                               oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <!-- Ruangan / Unit Kerja -->
                    <div>
                        <label for="ruangan" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-door-open text-emerald-400 mr-1.5"></i>Ruangan / Unit Kerja <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="ruangan" name="ruangan" required
                               class="form-control-pro uppercase"
                               placeholder="Contoh: IGD, ICU, RAWAT INAP"
                               oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>

                <!-- SECTION 2: INFORMASI AKUN & KEAMANAN -->
                <div class="section-divider">
                    <span><i class="fas fa-shield-alt me-1"></i> Informasi Akun & Keamanan</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email Address (Full Width on 2 columns) -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-envelope text-emerald-400 mr-1.5"></i>Email Aktif <span class="text-rose-400">*</span>
                        </label>
                        <input type="email" id="email" name="email" required 
                               class="form-control-pro"
                               placeholder="nama@email.com"
                               autocomplete="email">
                        <small class="text-slate-400 text-xs mt-1 block">Email akan digunakan untuk masuk ke dalam aplikasi.</small>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-lock text-emerald-400 mr-1.5"></i>Password <span class="text-rose-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required 
                                   class="form-control-pro has-toggle"
                                   placeholder="Min. 8 karakter"
                                   autocomplete="new-password">
                            <button type="button" id="togglePassword" class="input-icon-btn" title="Lihat password">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-lock-check text-emerald-400 mr-1.5"></i>Konfirmasi Password <span class="text-rose-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required 
                                   class="form-control-pro has-toggle"
                                   placeholder="Ulangi password"
                                   autocomplete="new-password">
                            <button type="button" id="togglePasswordConfirm" class="input-icon-btn" title="Lihat konfirmasi password">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password Requirements Checklist -->
                <div class="p-3.5 bg-slate-900/80 border border-slate-700/60 rounded-xl mt-2 text-xs text-slate-400 space-y-1.5">
                    <div class="flex items-center gap-1.5 font-medium text-slate-300">
                        <i class="fas fa-shield-halved text-emerald-400"></i>
                        <span>Ketentuan Keamanan Password:</span>
                    </div>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-1 pl-5 list-disc text-slate-400">
                        <li id="reqLength">Minimal 8 karakter</li>
                        <li id="reqUpperLower">Huruf besar & huruf kecil</li>
                        <li id="reqNumber">Minimal 1 angka</li>
                        <li id="reqSymbol">Minimal 1 simbol (@$!%*?&)</li>
                    </ul>
                </div>

                <!-- Terms & Agreement -->
                <div class="pt-2">
                    <label class="flex items-start gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" id="terms" name="terms" required 
                               class="h-4 w-4 mt-0.5 text-emerald-500 focus:ring-emerald-500/30 border-slate-700 rounded bg-slate-900 transition cursor-pointer flex-shrink-0">
                        <span class="text-xs sm:text-sm text-slate-300 leading-snug">
                            Saya menyatakan bahwa data yang diisikan adalah benar dan menyetujui 
                            <a href="#" class="text-emerald-400 hover:text-emerald-300 underline font-medium">Syarat & Ketentuan Layanan e-Kinerja</a>.
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="registerBtn" class="btn-register-pro">
                        <span id="registerBtnText" class="flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            <span>Daftar Akun Sekarang</span>
                        </span>
                        <span id="registerBtnLoading" class="hidden flex items-center justify-center gap-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                            <span>Memproses Pendaftaran...</span>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Message Alert Area -->
            <div id="message" class="hidden mt-4 p-4 rounded-xl text-xs sm:text-sm transition-all duration-300"></div>

            <!-- Login Link -->
            <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                <p class="text-slate-400 text-xs sm:text-sm">
                    Sudah memiliki akun terdaftar? 
                    <a href="/login" class="text-emerald-400 font-semibold hover:text-emerald-300 transition-colors ml-1 inline-flex items-center gap-1">
                        <span>Masuk di sini</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-5 mb-2">
            <p class="text-slate-500 text-xs">
                © 2025 e-Kinerja. Dikembangkan dengan ❤️ untuk Tenaga Medis & Pegawai
            </p>
        </div>
    </div>

    <script>
        // Setup Password Visibility Toggles
        function setupToggle(buttonId, inputId) {
            const btn = document.getElementById(buttonId);
            const input = document.getElementById(inputId);
            if (!btn || !input) return;

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash text-sm text-emerald-400';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye text-sm text-slate-400';
                }
            });
        }

        setupToggle('togglePassword', 'password');
        setupToggle('togglePasswordConfirm', 'password_confirmation');

        // Handle Google OAuth Redirect Auto-fill
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('from_google') === '1') {
            const gName = urlParams.get('name');
            const gEmail = urlParams.get('email');
            const gId = urlParams.get('google_id');

            if (gName) {
                const nameEl = document.getElementById('name');
                if (nameEl) nameEl.value = decodeURIComponent(gName);
            }
            if (gEmail) {
                const emailEl = document.getElementById('email');
                if (emailEl) {
                    emailEl.value = decodeURIComponent(gEmail);
                    emailEl.readOnly = true;
                    emailEl.classList.add('opacity-75', 'cursor-not-allowed', 'bg-slate-900/60');
                }
            }
            if (gId) {
                const gIdEl = document.getElementById('google_id');
                if (gIdEl) gIdEl.value = gId;
            }
            const alertBox = document.getElementById('googleConnectedAlert');
            if (alertBox) {
                alertBox.classList.remove('hidden');
            }
        }

        // Live Password Match & Validation Helper
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        function checkPasswordRules() {
            const val = passwordInput.value;
            const confirmVal = confirmPasswordInput.value;

            // Rules indicators
            const reqLength = document.getElementById('reqLength');
            const reqUpperLower = document.getElementById('reqUpperLower');
            const reqNumber = document.getElementById('reqNumber');
            const reqSymbol = document.getElementById('reqSymbol');

            if (reqLength) reqLength.className = val.length >= 8 ? 'text-emerald-400 font-medium' : 'text-slate-400';
            if (reqUpperLower) reqUpperLower.className = (/[a-z]/.test(val) && /[A-Z]/.test(val)) ? 'text-emerald-400 font-medium' : 'text-slate-400';
            if (reqNumber) reqNumber.className = /\d/.test(val) ? 'text-emerald-400 font-medium' : 'text-slate-400';
            if (reqSymbol) reqSymbol.className = /[@$!%*?&]/.test(val) ? 'text-emerald-400 font-medium' : 'text-slate-400';

            // Confirm password matching
            if (confirmVal.length > 0) {
                if (val === confirmVal) {
                    confirmPasswordInput.style.borderColor = '#10b981';
                } else {
                    confirmPasswordInput.style.borderColor = '#f43f5e';
                }
            } else {
                confirmPasswordInput.style.borderColor = '#334155';
            }
        }

        passwordInput.addEventListener('input', checkPasswordRules);
        confirmPasswordInput.addEventListener('input', checkPasswordRules);

        // Form Submission Handler
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                name: formData.get('name')?.trim(),
                email: formData.get('email')?.trim(),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation'),
                phone: formData.get('phone')?.trim(),
                nip: formData.get('nip')?.trim(),
                golongan: formData.get('golongan'),
                instansi: formData.get('instansi')?.trim(),
                ruangan: formData.get('ruangan')?.trim(),
                google_id: formData.get('google_id') || null
            };
            
            // Validate password match
            if (data.password !== data.password_confirmation) {
                showMessage('Password dan konfirmasi password tidak cocok!', 'error');
                confirmPasswordInput.focus();
                return;
            }
            
            // Validate terms
            if (!document.getElementById('terms').checked) {
                showMessage('Anda harus menyetujui syarat dan ketentuan untuk mendaftar.', 'error');
                return;
            }
            
            try {
                showLoading(true);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showMessage('Pendaftaran berhasil! Mengalihkan ke dashboard...', 'success');
                    
                    if (result.data && result.data.token) {
                        localStorage.setItem('token', result.data.token);
                        localStorage.setItem('user', JSON.stringify(result.data.user));
                    }
                    
                    setTimeout(() => {
                        window.location.href = '/user-dashboard';
                    }, 1200);
                } else {
                    console.log('Registration error:', result);
                    
                    let errorMessage = result.message || 'Terjadi kesalahan saat registrasi';
                    
                    if (result.errors) {
                        const errorDetails = Object.entries(result.errors)
                            .map(([field, messages]) => Array.isArray(messages) ? messages.join(', ') : messages)
                            .join('<br>• ');
                        errorMessage = '• ' + errorDetails;
                    }
                    
                    showMessage(errorMessage, 'error');
                }
            } catch (error) {
                console.error('Network error:', error);
                showMessage('Terjadi kesalahan koneksi jaringan. Periksa koneksi internet Anda.', 'error');
            } finally {
                showLoading(false);
            }
        });
        
        function showLoading(loading) {
            const btn = document.getElementById('registerBtn');
            const btnText = document.getElementById('registerBtnText');
            const btnLoading = document.getElementById('registerBtnLoading');
            
            if (loading) {
                btn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');
            } else {
                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        }
        
        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.className = `mt-4 p-4 rounded-xl text-xs sm:text-sm transition-all duration-300 ${
                type === 'success' 
                    ? 'bg-emerald-950/90 border border-emerald-500/40 text-emerald-300' 
                    : 'bg-rose-950/90 border border-rose-500/40 text-rose-300'
            }`;
            
            const icon = type === 'success' 
                ? '<i class="fas fa-check-circle text-emerald-400 text-base me-2 flex-shrink-0"></i>' 
                : '<i class="fas fa-exclamation-triangle text-rose-400 text-base me-2 flex-shrink-0"></i>';
                
            messageDiv.innerHTML = `
                <div class="flex items-start">
                    ${icon}
                    <div class="flex-1 leading-relaxed">${message}</div>
                </div>
            `;
            messageDiv.classList.remove('hidden');
            
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 7000);
            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    </script>
</body>
</html>

