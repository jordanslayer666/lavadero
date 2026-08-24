<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — AquaWash ERP</title>
    <meta name="description" content="Accede al sistema de gestión de lavadero AquaWash ERP">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Circles */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
        }

        .bg-circle:nth-child(1) {
            width: 400px; height: 400px;
            background: #667eea;
            top: -100px; left: -100px;
            animation-delay: 0s;
        }

        .bg-circle:nth-child(2) {
            width: 300px; height: 300px;
            background: #764ba2;
            bottom: -80px; right: -80px;
            animation-delay: 2s;
        }

        .bg-circle:nth-child(3) {
            width: 250px; height: 250px;
            background: #00d2ff;
            top: 50%; left: 60%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card .brand-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: white;
            margin: 0 auto 24px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .login-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            margin-bottom: 6px;
        }

        .login-card .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        /* Form Styles */
        .form-floating {
            margin-bottom: 20px;
        }

        .form-floating .form-control {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #ffffff;
            padding: 16px 16px 8px 48px;
            height: 56px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-floating .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            color: #ffffff;
        }

        .form-floating .form-control::placeholder {
            color: transparent;
        }

        .form-floating .form-control:focus::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .form-floating label {
            color: rgba(255, 255, 255, 0.45);
            padding-left: 48px;
        }

        .form-floating > label::after {
            background: transparent !important;
        }

        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            color: #667eea;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            font-size: 1.1rem;
            z-index: 5;
            pointer-events: none;
        }

        .form-floating {
            position: relative;
        }

        /* Checkbox */
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Error Alert */
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            color: #fca5a5;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Toggle Password */
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            z-index: 5;
            background: none;
            border: none;
            font-size: 1.1rem;
        }

        .toggle-password:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                margin: 16px;
                padding: 36px 28px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-circle"></div>
    <div class="bg-circle"></div>
    <div class="bg-circle"></div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="brand-icon">
            <i class="bi bi-droplet-fill"></i>
        </div>

        <h1>AquaWash ERP</h1>
        <p class="subtitle">Ingresa tus credenciales para continuar</p>

        @if ($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" id="loginForm">
            @csrf

            <div class="form-floating">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       placeholder="correo@ejemplo.com"
                       value="{{ old('email') }}"
                       required
                       autofocus>
                <label for="email">Correo electrónico</label>
            </div>

            <div class="form-floating">
                <i class="bi bi-lock input-icon"></i>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="Contraseña"
                       required>
                <label for="password">Contraseña</label>
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login" id="loginBtn">
                <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>
