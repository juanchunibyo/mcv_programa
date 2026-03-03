<?php
// views/auth/login.php

$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SENA - Iniciar Sesión | Confianza Digital</title>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Lucide Icons (CDN) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style data-purpose="custom-layout">
        body {
          font-family: 'Montserrat', sans-serif;
          background-color: #F4F7F5;
        }

        /* Background image with overlay */
        .bg-pattern {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          z-index: -1;
          background-image: 
            linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)),
            url('assets/img/login-bg.jpg');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
        }

        .geometric-circle {
          display: none;
        }

        .focus-sena-green:focus {
          border-color: #39A900 !important;
          ring-color: #39A900 !important;
          outline: none;
        }

        /* Custom shadow for the card */
        .sena-card-shadow {
          box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between items-center p-5">
    <!-- BEGIN: Background Elements -->
    <div aria-hidden="true" class="bg-pattern">
    </div>
    <!-- END: Background Elements -->

    <!-- BEGIN: Main Content Wrapper -->
    <main class="w-full max-w-md flex-grow flex flex-col justify-center py-8">
        <!-- BEGIN: Logo Section -->
        <div class="flex justify-center mb-10" data-purpose="brand-logo-container">
            <img alt="Logo SENA" class="h-24 w-auto object-contain rounded-full shadow-lg" src="https://bogota.gov.co/sites/default/files/inline-images/logosena.png"/>
        </div>
        <!-- END: Logo Section -->

        <!-- BEGIN: Login Card -->
        <section class="bg-white sena-card-shadow rounded-[12px] p-8 w-full" data-purpose="login-form-card">
            <div class="text-center mb-8">
                <h1 class="text-[#2F2F2F] text-2xl font-bold mb-2">Iniciar Sesión</h1>
                <p class="text-gray-500 text-sm">Sistema de Gestión Académica</p>
            </div>

            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span class="block sm:inline text-sm"><?php echo htmlspecialchars($error); ?></span>
            </div>
            <?php endif; ?>

            <form action="index.php?action=login" class="space-y-5" method="POST">
                
                <!-- Correo Input -->
                <div class="relative">
                    <label class="sr-only" for="correo">Correo electrónico</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="h-5 w-5 text-gray-400" data-lucide="mail"></i>
                    </div>
                    <input 
                        class="block w-full h-[48px] pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus-sena-green transition-all" 
                        id="correo" 
                        name="correo" 
                        placeholder="Correo electrónico institucional" 
                        value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>"
                        required="" 
                        type="email"
                    />
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <label class="sr-only" for="password">Contraseña</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="h-5 w-5 text-gray-400" data-lucide="lock"></i>
                    </div>
                    <input 
                        class="block w-full h-[48px] pl-10 pr-12 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus-sena-green transition-all" 
                        id="password" 
                        name="password" 
                        placeholder="Contraseña" 
                        required="" 
                        type="password"
                    />
                    <button class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()" type="button">
                        <i class="h-5 w-5 text-gray-400" data-lucide="eye" id="eye-icon"></i>
                    </button>
                </div>

                <!-- Footer Links -->
                <div class="flex items-center justify-between text-[13px]">
                    <a class="text-[#39A900] hover:underline font-medium" href="#">¿Olvidaste tu contraseña?</a>
                </div>

                <!-- Submit Button -->
                <button class="w-full h-[48px] bg-[#39A900] text-white font-semibold rounded-lg shadow-md hover:bg-[#2e8800] active:scale-[0.98] transition-all flex items-center justify-center mt-2" type="submit">
                    <i data-lucide="log-in" class="w-5 h-5 mr-2"></i> Iniciar Sesión
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600">
                ¿No tienes una cuenta? 
                <a href="index.php?action=registro" class="text-[#39A900] font-semibold hover:underline">Registrarse</a>
            </div>
        </section>
        <!-- END: Login Card -->
    </main>
    <!-- END: Main Content Wrapper -->

    <!-- BEGIN: Footer Section -->
    <footer class="w-full max-w-md pb-6 flex flex-col items-center gap-6 relative z-10" data-purpose="page-footer">
        <!-- Institutional Logos -->
        <div class="flex flex-col items-center justify-center gap-2 opacity-80 hover:opacity-100 transition-all">
            <img alt="Escudo de Colombia" class="h-12 w-auto" src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Coat_of_arms_of_Colombia.svg"/>
            <span class="text-white text-[11px] font-semibold tracking-widest uppercase shadow-sm">Ministerio de Trabajo</span>
        </div>
        <!-- Version Info -->
        <div class="w-full flex justify-between items-center text-[11px] text-gray-300 px-4">
            <p>© 2024 Servicio Nacional de Aprendizaje SENA</p>
            <p class="font-mono">v4.2.0</p>
        </div>
    </footer>
    <!-- END: Footer Section -->

    <!-- JavaScript for interactivity -->
    <script data-purpose="icon-initialization">
        lucide.createIcons();
    </script>
    <script data-purpose="ui-logic">
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
