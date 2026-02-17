<?php
/**
 * Procesador de acciones CRUD para Sedes
 * Maneja: crear, actualizar, eliminar
 */

require_once __DIR__ . '/../../controllers/SedeController.php';

session_start();

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        // Crear nueva sede
        $datos = [
            'sede_nombre' => trim($_POST['sede_nombre'] ?? '')
        ];
        
        // Validación básica
        if (empty($datos['sede_nombre'])) {
            $_SESSION['error'] = 'El nombre de la sede es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        $resultado = SedeController::crearSede($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        // Actualizar sede existente
        $sedeId = intval($_POST['sede_id'] ?? 0);
        $datos = [
            'sede_nombre' => trim($_POST['sede_nombre'] ?? '')
        ];
        
        // Validación básica
        if ($sedeId <= 0) {
            $_SESSION['error'] = 'ID de sede inválido';
            header('Location: index.php');
            exit;
        }
        
        if (empty($datos['sede_nombre'])) {
            $_SESSION['error'] = 'El nombre de la sede es obligatorio';
            header('Location: editar.php?id=' . $sedeId);
            exit;
        }
        
        $resultado = SedeController::actualizarSede($sedeId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $sedeId);
        }
        break;
        
    case 'delete':
        // Eliminar sede
        $sedeId = intval($_POST['sede_id'] ?? 0);
        
        if ($sedeId <= 0) {
            $_SESSION['error'] = 'ID de sede inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = SedeController::eliminarSede($sedeId);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        
        header('Location: index.php');
        break;
        
    default:
        $_SESSION['error'] = 'Acción no válida';
        header('Location: index.php');
        break;
}

exit;
