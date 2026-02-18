<?php
require_once __DIR__ . '/../../controllers/InstructorController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'inst_nombres' => trim($_POST['inst_nombres'] ?? ''),
            'inst_apellidos' => trim($_POST['inst_apellidos'] ?? ''),
            'inst_correo' => trim($_POST['inst_correo'] ?? ''),
            'inst_telefono' => trim($_POST['inst_telefono'] ?? ''),
            'centro_formacion_id' => intval($_POST['centro_formacion_id'] ?? 0)
        ];
        
        if (empty($datos['inst_nombres']) || empty($datos['inst_apellidos'])) {
            $_SESSION['error'] = 'Nombres y apellidos son obligatorios';
            header('Location: crear.php');
            exit;
        }
        
        if ($datos['centro_formacion_id'] === 0) $datos['centro_formacion_id'] = null;
        
        $resultado = InstructorController::crearInstructor($datos);
        $_SESSION[$resultado['success'] ? 'mensaje' : 'error'] = $resultado['message'];
        header('Location: ' . ($resultado['success'] ? 'index.php' : 'crear.php'));
        break;
        
    case 'update':
        $instId = intval($_POST['inst_id'] ?? 0);
        $datos = [
            'inst_nombres' => trim($_POST['inst_nombres'] ?? ''),
            'inst_apellidos' => trim($_POST['inst_apellidos'] ?? ''),
            'inst_correo' => trim($_POST['inst_correo'] ?? ''),
            'inst_telefono' => trim($_POST['inst_telefono'] ?? ''),
            'centro_formacion_id' => intval($_POST['centro_formacion_id'] ?? 0)
        ];
        
        if ($instId <= 0 || empty($datos['inst_nombres']) || empty($datos['inst_apellidos'])) {
            $_SESSION['error'] = 'Datos inválidos';
            header('Location: ' . ($instId > 0 ? "editar.php?id=$instId" : 'index.php'));
            exit;
        }
        
        if ($datos['centro_formacion_id'] === 0) $datos['centro_formacion_id'] = null;
        
        $resultado = InstructorController::actualizarInstructor($instId, $datos);
        $_SESSION[$resultado['success'] ? 'mensaje' : 'error'] = $resultado['message'];
        header('Location: ' . ($resultado['success'] ? 'index.php' : "editar.php?id=$instId"));
        break;
        
    case 'delete':
        $instId = intval($_POST['inst_id'] ?? 0);
        if ($instId <= 0) {
            $_SESSION['error'] = 'ID inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = InstructorController::eliminarInstructor($instId);
        $_SESSION[$resultado['success'] ? 'mensaje' : 'error'] = $resultado['message'];
        header('Location: index.php');
        break;
        
    default:
        $_SESSION['error'] = 'Acción no válida';
        header('Location: index.php');
}
exit;
