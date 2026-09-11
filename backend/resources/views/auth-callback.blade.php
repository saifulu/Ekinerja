<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticating...</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid white;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .text-center {
            text-align: center;
        }
    </style>
    @include('partials.mobile-ux')
</head>
<body>
    <div class="text-center">
        <div class="loader"></div>
        <h2>Menyelesaikan login...</h2>
        <p>Mohon tunggu sebentar.</p>
    </div>

    <script>
        // Data passed from controller
        const token = "{!! $token !!}";
        const user = {!! json_encode($user) !!};

        // Save to localStorage
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));

        // Redirect to dashboard
        setTimeout(() => {
            window.location.href = '/dashboard';
        }, 500);
    </script>
</body>
</html>
