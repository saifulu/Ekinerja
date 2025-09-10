<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - e-Kinerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full floating-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white opacity-10 rounded-full floating-animation" style="animation-delay: -1s;"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-8 fade-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                <i class="fas fa-chart-line text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">e-Kinerja</h1>
            <p class="text-white text-opacity-80">Sistem Manajemen Kinerja</p>
        </div>

        <!-- Registration Form -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl fade-in">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">Daftar Akun Baru</h2>
                <p class="text-white text-opacity-70">Buat akun Anda untuk melanjutkan</p>
            </div>

            <form id="registerForm" class="space-y-6">
                <!-- Name Field -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                    </label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Masukkan nama lengkap Anda">
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <input type="email" id="email" name="email" required 
                           class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Masukkan email Anda">
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 pr-12 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="Masukkan password Anda">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-white text-opacity-60 hover:text-opacity-100 transition-all duration-200"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-lock mr-2"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               class="w-full px-4 py-3 pr-12 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="Konfirmasi password Anda">
                        <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-600 hover:text-gray-800 transition-all duration-200"></i>
                        </button>
                    </div>
                </div>

                <!-- Phone Field -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-phone mr-2"></i>No. Telepon
                    </label>
                    <input type="tel" id="phone" name="phone" required
                           class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Masukkan nomor telepon"
                           pattern="[0-9]*"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <!-- NIP Field -->
                <div class="space-y-2">
                    <label for="nip" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-id-card mr-2"></i>NIP
                    </label>
                    <input type="text" id="nip" name="nip" required
                           class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Masukkan NIP">
                </div>

                <!-- Golongan Field -->
                <div class="space-y-2">
                    <label for="golongan" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-star mr-2"></i>Golongan
                    </label>
                    <select id="golongan" name="golongan" required
                            class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="" class="text-gray-800">Pilih Golongan</option>
                        <optgroup label="Golongan I (Juru)" class="text-gray-800">
                            <option value="Ia" class="text-gray-800">Ia - Juru Muda</option>
                            <option value="Ib" class="text-gray-800">Ib - Juru Muda Tingkat I</option>
                            <option value="Ic" class="text-gray-800">Ic - Juru</option>
                            <option value="Id" class="text-gray-800">Id - Juru Tingkat I</option>
                        </optgroup>
                        <optgroup label="Golongan II (Pengatur)" class="text-gray-800">
                            <option value="IIa" class="text-gray-800">IIa - Pengatur Muda</option>
                            <option value="IIb" class="text-gray-800">IIb - Pengatur Muda Tingkat I</option>
                            <option value="IIc" class="text-gray-800">IIc - Pengatur</option>
                            <option value="IId" class="text-gray-800">IId - Pengatur Tingkat I</option>
                        </optgroup>
                        <optgroup label="Golongan III (Penata)" class="text-gray-800">
                            <option value="IIIa" class="text-gray-800">IIIa - Penata Muda</option>
                            <option value="IIIb" class="text-gray-800">IIIb - Penata Muda Tingkat I</option>
                            <option value="IIIc" class="text-gray-800">IIIc - Penata</option>
                            <option value="IIId" class="text-gray-800">IIId - Penata Tingkat I</option>
                        </optgroup>
                        <optgroup label="Golongan IV (Pembina)" class="text-gray-800">
                            <option value="IVa" class="text-gray-800">IVa - Pembina</option>
                            <option value="IVb" class="text-gray-800">IVb - Pembina Tingkat I</option>
                            <option value="IVc" class="text-gray-800">IVc - Pembina Utama Muda</option>
                            <option value="IVd" class="text-gray-800">IVd - Pembina Utama Madya</option>
                            <option value="IVe" class="text-gray-800">IVe - Pembina Utama</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Instansi Field -->
                <div class="space-y-2">
                    <label for="instansi" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-building mr-2"></i>Instansi
                    </label>
                    <input type="text" id="instansi" name="instansi" required
                           class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 uppercase"
                           placeholder="Masukkan nama instansi"
                           style="text-transform: uppercase;"
                           oninput="this.value = this.value.toUpperCase()">
                </div>

                <!-- Ruangan Field -->
                <div class="space-y-2">
                    <label for="ruangan" class="block text-sm font-medium text-white text-opacity-90">
                        <i class="fas fa-door-open mr-2"></i>Ruangan
                    </label>
                    <input type="text" id="ruangan" name="ruangan" required
                           class="w-full px-4 py-3 bg-white bg-opacity-90 border border-white border-opacity-30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 uppercase"
                           placeholder="Masukkan nama ruangan"
                           style="text-transform: uppercase;"
                           oninput="this.value = this.value.toUpperCase()">
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" required 
                           class="w-4 h-4 text-white bg-white bg-opacity-20 border-white border-opacity-30 rounded focus:ring-white focus:ring-opacity-50">
                    <label for="terms" class="ml-2 text-sm text-white text-opacity-90">
                        Saya setuju dengan <a href="#" class="text-white underline hover:text-opacity-80">Syarat dan Ketentuan</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="registerBtn" 
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 shadow-lg">
                    <span id="registerBtnText">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </span>
                    <span id="registerBtnLoading" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Mendaftar...
                    </span>
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-white text-opacity-70">
                    Sudah punya akun? 
                    <a href="/login" class="text-white font-semibold hover:text-opacity-80 transition-all duration-200">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <!-- Error/Success Messages -->
            <div id="message" class="mt-4 p-3 rounded-lg hidden"></div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 fade-in">
            <p class="text-white text-opacity-60 text-sm">
                © 2025 e-Kinerja. Dikembangkan dengan <i class="fas fa-heart text-red-400"></i>
            </p>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const password = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form submission
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation'),
                phone: formData.get('phone'),
                nip: formData.get('nip'),
                golongan: formData.get('golongan'),
                instansi: formData.get('instansi'),
                ruangan: formData.get('ruangan')
            };
            
            // Validate password confirmation
            if (data.password !== data.password_confirmation) {
                showMessage('Password dan konfirmasi password tidak cocok!', 'error');
                return;
            }
            
            // Validate terms
            if (!document.getElementById('terms').checked) {
                showMessage('Anda harus menyetujui syarat dan ketentuan!', 'error');
                return;
            }
            
            try {
                showLoading(true);
                
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    showMessage('Registrasi berhasil! Silakan login dengan akun Anda.', 'success');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                } else {
                    // Debug: tampilkan detail error validation
                    console.log('Full error response:', result);
                    
                    let errorMessage = result.message || 'Terjadi kesalahan saat registrasi';
                    
                    // Jika ada detail errors, tampilkan
                    if (result.errors) {
                        const errorDetails = Object.entries(result.errors)
                            .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                            .join('\n');
                        console.log('Validation errors:', result.errors);
                        errorMessage = 'Validation errors:\n' + errorDetails;
                    }
                    
                    showMessage(errorMessage, 'error');
                }
            } catch (error) {
                console.error('Network error:', error);
                showMessage('Terjadi kesalahan koneksi. Silakan coba lagi.', 'error');
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
            messageDiv.className = `mt-4 p-3 rounded-lg ${type === 'success' ? 'bg-green-500 bg-opacity-20 border border-green-400 text-green-100' : 'bg-red-500 bg-opacity-20 border border-red-400 text-red-100'}`;
            messageDiv.textContent = message;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        }
        
        // Real-time password validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = 'rgba(239, 68, 68, 0.5)';
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.3)';
            }
        });
    </script>
</body>
</html>