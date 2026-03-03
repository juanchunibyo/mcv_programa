<?php
require_once __DIR__ . '/../model/UsuarioModel.php';
require_once __DIR__ . '/../model/RolModel.php';

class AuthController
{
    private $usuarioModel;
    private $rolModel;

    public function __construct()
    {
        // Instancia del modelo para interactuar con la BDD
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
    }

    /**
     * Muestra la vista del formulario de login
     */
    public function mostrarLogin()
    {
        // Si ya hay sesión activa, mandarlo al panel
        if (isset($_SESSION['usuario_logueado'])) {
            header('Location: index.php');
            exit;
        }

        // Variable de error que pasaremos a la vista si algo sale mal
        $error = '';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Procesa los datos del formulario (POST)
     */
    public function procesarLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = trim($_POST['correo'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($correo) || empty($password)) {
                $error = 'Por favor ingrese correo y contraseña';
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }

            // Verificar en base de datos usando nuestro UsuarioModel
            $usuario = $this->usuarioModel->verificarCredenciales($correo, $password);

            if ($usuario) {
                // login exitoso: guardar datos en sesión
                $_SESSION['usuario_logueado'] = true;
                $_SESSION['usuario_id'] = $usuario['usu_id'];
                $_SESSION['usuario_nombre'] = $usuario['usu_nombre'];
                $_SESSION['usuario_correo'] = $usuario['usu_correo'];
                $_SESSION['usuario_rol'] = $usuario['rol_nombre']; // 'coordinador', 'instructor', etc.
                
                if (!empty($usuario['inst_id'])) {
                    $_SESSION['instructor_id'] = $usuario['inst_id'];
                }

                header('Location: index.php');
                exit;
            } else {
                // Credenciales incorrectas
                $error = 'Correo o contraseña incorrectos';
                require_once __DIR__ . '/../views/auth/login.php';
            }
        } else {
            // Si no es POST, lo regresamos a ver el formulario
            $this->mostrarLogin();
        }
    }

    /**
     * Muestra la vista de registro (que en nuestro caso es la misma que login)
     */
    public function mostrarRegistro()
    {
        // Si ya hay sesión activa, mandarlo al panel
        if (isset($_SESSION['usuario_logueado'])) {
            header('Location: index.php');
            exit;
        }

        $error = '';
        $success = '';
        $roles = $this->rolModel->obtenerRoles();
        require_once __DIR__ . '/../views/auth/registro.php';
    }

    /**
     * Procesa los datos del formulario de registro (POST)
     */
    public function procesarRegistro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $rol_id = $_POST['rol_id'] ?? null;

            if (empty($nombre) || empty($correo) || empty($password) || empty($rol_id)) {
                $error = 'Todos los campos son obligatorios para el registro.';
                $roles = $this->rolModel->obtenerRoles();
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            if (strlen($password) < 6) {
                $error = 'La contraseña debe tener al menos 6 caracteres.';
                $roles = $this->rolModel->obtenerRoles();
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            // Encriptar la contraseña usando bcrypt
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Llamar al modelo
            $resultado = $this->usuarioModel->registrarUsuario($nombre, $correo, $password_hash, $rol_id);

            if ($resultado['success']) {
                $success = '¡Registro exitoso! Ya puede iniciar sesión.';
                $error = '';
                // Limpiar el POST para que los campos no queden llenos si no se quiere
                $_POST = [];
            } else {
                $error = $resultado['message'];
            }

            $roles = $this->rolModel->obtenerRoles();
            require_once __DIR__ . '/../views/auth/registro.php';
        } else {
            $this->mostrarRegistro();
        }
    }

    /**
     * Cierra la sesión
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
