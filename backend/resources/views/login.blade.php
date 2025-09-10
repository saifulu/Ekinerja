<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - e-Kinerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full"></div>
        <div class="absolute top-20 left-20 w-32 h-32 bg-white opacity-10 rounded-full floating"></div>
    </div>
    
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Header -->
            <div class="text-center fade-in">
                <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-6">
                    <i class="fas fa-chart-line text-3xl text-indigo-600"></i>
                </div>
                <h2 class="text-4xl font-bold text-white mb-2">
                    e-Kinerja
                </h2>
                <p class="text-indigo-100 text-lg">
                    Sistem Manajemen Kinerja
                </p>
                <div class="mt-4 h-1 w-20 bg-white mx-auto rounded-full opacity-60"></div>
            </div>

            <!-- Login Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 slide-up">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">Selamat Datang</h3>
                    <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
                </div>
                
                <form class="space-y-6" id="loginForm">
                    <div class="space-y-4">
                        <div class="relative">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-indigo-500"></i>Email Address
                            </label>
                            <input id="email" name="email" type="email" required 
                                   class="input-focus appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                                   placeholder="Masukkan email Anda">
                        </div>
                        
                        <div class="relative">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-indigo-500"></i>Password
                            </label>
                            <div class="relative">
                                <input id="password" name="password" type="password" required 
                                       class="input-focus appearance-none relative block w-full px-4 py-3 pr-12 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" 
                                       placeholder="Masukkan password Anda">
                                <button type="button" onclick="togglePassword()" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="passwordIcon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="btn-hover group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt text-indigo-300 group-hover:text-indigo-200"></i>
                            </span>
                            <span id="loginText">Masuk ke Sistem</span>
                            <div id="loginSpinner" class="hidden ml-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Message Area -->
                <div id="message" class="hidden mt-6 p-4 rounded-lg transition-all duration-300"></div>
            </div>

            <!-- Footer -->
            <div class="text-center fade-in">
                <p class="text-indigo-100 text-sm">
                    © 2025 e-Kinerja. Dikembangkan dengan ❤️
                </p>
            </div>
            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-white text-opacity-70">
                    Belum punya akun? 
                    <a href="/register" class="text-white font-semibold hover:text-opacity-80 transition-all duration-200">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash text-gray-400 hover:text-gray-600';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye text-gray-400 hover:text-gray-600';
            }
        }
        
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('message');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');
            const submitButton = e.target.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.disabled = true;
            loginText.textContent = 'Memproses...';
            loginSpinner.classList.remove('hidden');
            
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
                
                if (data.success) {
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    
                    messageDiv.className = 'mt-6 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700 transition-all duration-300';
                    messageDiv.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Login berhasil! Mengarahkan ke dashboard...</span>
                        </div>
                    `;
                    messageDiv.classList.remove('hidden');
                    
                    loginText.textContent = 'Berhasil!';
                    
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Login gagal');
                }
            } catch (error) {
                messageDiv.className = 'mt-6 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700 transition-all duration-300';
                messageDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>Login gagal: ${error.message}</span>
                    </div>
                `;
                messageDiv.classList.remove('hidden');
                
                // Reset button state
                submitButton.disabled = false;
                loginText.textContent = 'Masuk ke Sistem';
                loginSpinner.classList.add('hidden');
            }
        });
        
        // Auto-hide message after 5 seconds
        function hideMessage() {
            const messageDiv = document.getElementById('message');
            if (!messageDiv.classList.contains('hidden')) {
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);
            }
        }
        
        // Add input animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('transform', 'scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('transform', 'scale-105');
            });
        });
    </script>
</body>
</html>