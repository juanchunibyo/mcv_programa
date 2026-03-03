<?php
/**
 * Front Controller (Enrutador Principal con Middleware de Autenticación)
 */
session_start();

require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/AuthController.php';

// Obtener la acción solicitada por URL (?action=loquesea)
$action = $_GET['action'] ?? 'dashboard';

// ===== MIDDLEWARE DE AUTENTICACIÓN =====
// Si el usuario no está logueado y la acción NO es 'login' ni 'registro', forzar redirección
if (!isset($_SESSION['usuario_logueado']) && !in_array($action, ['login', 'registro'])) {
    header('Location: index.php?action=login');
    exit;
}

// ===== ENRUTADOR BASICO =====
switch ($action) {
    case 'login':
        $authController = new AuthController();
        // Si el formulario fue enviado será POST, si no, es GET y mostrará la vista
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->procesarLogin();
        } else {
            $authController->mostrarLogin();
        }
        break;

    case 'registro':
        $authController = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->procesarRegistro();
        } else {
            // Como usamos la misma vista para login y registro, podemos llamar a mostrarRegistro 
            // que configurará la vista para mostrar el formulario de registro por defecto
            $authController->mostrarRegistro();
        }
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    case 'dashboard':
    default:
        $controller = new DashboardController();
        $controller->index();
        break;
}
