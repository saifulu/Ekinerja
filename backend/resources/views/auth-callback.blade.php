<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menyelesaikan Autentikasi... - e-Kinerja</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at 85% 15%, rgba(16, 185, 129, 0.16), transparent 35%),
                        radial-gradient(circle at 15% 85%, rgba(13, 148, 136, 0.12), transparent 40%),
                        linear-gradient(150deg, #090e1a 0%, #0f172a 45%, #052e24 100%);
            color: #f8fafc;
        }
        .auth-box {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.22);
            border-radius: 20px;
            padding: 36px 32px;
            text-align: center;
            max-width: 360px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.55), 0 0 35px rgba(16, 185, 129, 0.1);
        }
        .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(16, 185, 129, 0.2);
            border-top: 4px solid #10b981;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    @include('partials.mobile-ux')
</head>
<body>
    <div class="auth-box">
        <div class="spinner"></div>
        <h2 style="font-size: 18px; font-weight: 700; margin: 0 0 8px 0; color: #ffffff;">Menyelesaikan Login Google...</h2>
        <p style="font-size: 13px; color: #94a3b8; margin: 0;">Mohon tunggu, sedang menyiapkan sesi dashboard Anda.</p>
    </div>

    <script>
        try {
            // Data passed from controller
            const token = @json($token);
            const user = @json($user);

            // Save token and user into localStorage
            localStorage.setItem('token', token);
            localStorage.setItem('user', JSON.stringify(user));

            // Redirect smoothly to respective dashboard
            setTimeout(() => {
                if (user && user.role === 'admin') {
                    window.location.href = '/dashboard';
                } else {
                    window.location.href = '/user-dashboard';
                }
            }, 600);
        } catch (e) {
            console.error('Failed to process auth callback:', e);
            window.location.href = '/login';
        }
    </script>
</body>
</html>
