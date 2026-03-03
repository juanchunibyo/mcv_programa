<?php
// views/auth/registro.php
// Esta vista utiliza el mismo diseño UI que login.php pero adaptado para registro

$error = $error ?? '';
$success = $success ?? '';

// Los roles provienen del controlador para llenar el select
$roles = $roles ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SENA - Registro de Administrador o Instructor | Confianza Digital</title>
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

        <!-- BEGIN: Register Card -->
        <section class="bg-white sena-card-shadow rounded-[12px] p-8 w-full" data-purpose="login-form-card">
            <div class="text-center mb-8">
                <h1 class="text-[#2F2F2F] text-2xl font-bold mb-2">Crear Cuenta</h1>
                <p class="text-gray-500 text-sm">Registro de Administradores e Instructores</p>
            </div>

            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span class="block sm:inline text-sm"><?php echo htmlspecialchars($error); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex flex-col gap-1 text-center">
                <div class="flex items-center justify-center gap-2 mb-1">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <strong class="font-bold">¡Registro exitoso!</strong>
                </div>
                <span class="block sm:inline text-sm"><?php echo htmlspecialchars($success); ?></span>
                <a href="index.php?action=login" class="mt-2 text-[#39A900] font-semibold hover:underline">Ir a iniciar sesión</a>
            </div>
            <?php endif; ?>

            <?php if (!$success): ?>
            <form action="index.php?action=registro" class="space-y-5" method="POST">
                
                <!-- Nombre Input -->
                <div class="relative">
                    <label class="sr-only" for="nombre">Nombre Completo</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="h-5 w-5 text-gray-400" data-lucide="user"></i>
                    </div>
                    <input 
                        class="block w-full h-[48px] pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus-sena-green transition-all" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Nombre Completo" 
                        value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"
                        required="" 
                        type="text"
                    />
                </div>

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

                <!-- Role Selector -->
                <div class="relative">
                    <label class="sr-only" for="rol_id">Rol</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="h-5 w-5 text-gray-400" data-lucide="briefcase"></i>
                    </div>
                    <!-- Se eliminó 'appearance-none' por compatibilidad de visualización -->
                    <select 
                        class="block w-full h-[48px] pl-10 pr-10 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 focus-sena-green transition-all" 
                        id="rol_id" 
                        name="rol_id" 
                        required
                    >
                        <option value="" disabled <?php echo empty($_POST['rol_id']) ? 'selected' : ''; ?>>Seleccione su rol...</option>
                        <?php if(!empty($roles)): ?>
                            <?php foreach($roles as $rol): ?>
                                <?php if (strtolower($rol['rol_nombre']) !== 'admin'): ?>
                                    <option value="<?php echo htmlspecialchars($rol['rol_id']); ?>" 
                                        <?php echo (isset($_POST['rol_id']) && $_POST['rol_id'] == $rol['rol_id']) ? 'selected' : ''; ?>>
                                        <?php echo ucfirst(htmlspecialchars($rol['rol_nombre'])); ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Error: No se pudieron cargar los roles.</option>
                        <?php endif; ?>
                    </select>
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
                        placeholder="Contraseña segura" 
                        required="" 
                        type="password"
                        minlength="6"
                    />
                    <button class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()" type="button">
                        <i class="h-5 w-5 text-gray-400" data-lucide="eye" id="eye-icon"></i>
                    </button>
                </div>

                <!-- Footer Links -->
                <div class="flex items-center justify-between text-[13px]">
                    <a class="text-gray-500 hover:text-[#39A900] font-medium transition-colors" href="index.php?action=login">
                        <i data-lucide="arrow-left" class="inline w-3 h-3 mr-1"></i>Volver al inicio
                    </a>
                </div>

                <!-- Submit Button -->
                <button class="w-full h-[48px] bg-[#39A900] text-white font-semibold rounded-lg shadow-md hover:bg-[#2e8800] active:scale-[0.98] transition-all flex items-center justify-center mt-2" type="submit">
                    Registrarse
                </button>
            </form>
            <?php endif; ?>
        </section>
        <!-- END: Register Card -->
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
