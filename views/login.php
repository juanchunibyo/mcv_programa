<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — SENA</title>
    <link rel="stylesheet" href="/mvccc/mvc_programa/assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0f1e;
            background-image: 
                radial-gradient(at 20% 30%, rgba(57, 169, 0, 0.15) 0px, transparent 50%),
                radial-gradient(at 80% 70%, rgba(0, 120, 50, 0.12) 0px, transparent 50%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .login-page::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(57, 169, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(57, 169, 0, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .login-container {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(57, 169, 0, 0.2);
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(57, 169, 0, 0.1);
            max-width: 460px;
            width: 100%;
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
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

        .login-header {
            padding: 48px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--green-primary) 50%, transparent 100%);
        }

        .login-logo {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 12px 40px rgba(57, 169, 0, 0.4), inset 0 1px 0 rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }

        .login-logo::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.2), transparent 30%);
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }

        .login-logo-text {
            font-size: 42px;
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
            color: white;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            font-size: 28px;
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            color: #ffffff;
            text-shadow: 0 2px 20px rgba(57, 169, 0, 0.3);
        }

        .login-subtitle {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        .login-body {
            padding: 0 40px 40px;
        }

        .login-form .form-group {
            margin-bottom: 24px;
        }

        .login-form .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 10px;
            font-family: 'Outfit', sans-serif;
        }

        .login-form .form-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(57, 169, 0, 0.2);
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .login-form .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .login-form .form-input:focus {
            border-color: #39A900;
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.15);
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 6px 20px rgba(57, 169, 0, 0.4), 0 0 0 0 rgba(57, 169, 0, 0.5);
            position: relative;
            overflow: hidden;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 6px 20px rgba(57, 169, 0, 0.4), 0 0 0 0 rgba(57, 169, 0, 0.5);
            }
            50% {
                box-shadow: 0 6px 20px rgba(57, 169, 0, 0.4), 0 0 0 8px rgba(57, 169, 0, 0);
            }
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .login-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(57, 169, 0, 0.6);
            animation: none;
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .login-footer {
            text-align: center;
            padding: 24px 40px 32px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            border-top: 1px solid rgba(57, 169, 0, 0.1);
        }

        .login-footer a {
            color: #39A900;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: #007832;
            text-decoration: underline;
        }

        .login-alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-alert.error {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .login-alert.success {
            background: rgba(57, 169, 0, 0.1);
            color: #86efac;
            border: 2px solid rgba(57, 169, 0, 0.3);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .remember-me input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #39A900;
            border-radius: 4px;
        }

        .remember-me label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .login-container {
                border-radius: 16px;
            }
            
            .login-header {
                padding: 36px 24px 28px;
            }
            
            .login-body {
                padding: 0 24px 28px;
            }
            
            .login-logo {
                width: 75px;
                height: 75px;
            }
            
            .login-logo-text {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-header">
                <div class="login-logo">
                    <div class="login-logo-text">S</div>
                </div>
                <h1 class="login-title">Sistema Académico</h1>
                <p class="login-subtitle">SENA - Servicio Nacional de Aprendizaje</p>
            </div>

            <div class="login-body">
                <?php if (isset($_GET['error'])): ?>
                <div class="login-alert error">
                    <i data-lucide="alert-circle"></i>
                    <span>Usuario o contraseña incorrectos</span>
                </div>
                <?php endif; ?>

                <?php if (isset($_GET['success'])): ?>
                <div class="login-alert success">
                    <i data-lucide="check-circle-2"></i>
                    <span>Sesión cerrada correctamente</span>
                </div>
                <?php endif; ?>

                <form class="login-form" method="POST" action="">
                    <div class="form-group">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input 
                            type="text" 
                            id="usuario" 
                            name="usuario" 
                            class="form-input" 
                            placeholder="Ingresa tu usuario"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Ingresa tu contraseña"
                            required
                        >
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recordar mi sesión</label>
                    </div>

                    <button type="submit" class="login-btn">
                        Iniciar Sesión
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <p>¿Olvidaste tu contraseña? <a href="#">Recuperar</a></p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
