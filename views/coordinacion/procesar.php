<?php
/**
 * Procesador de acciones CRUD para Coordinaciones
 * Maneja: crear, actualizar, eliminar
 */

require_once __DIR__ . '/../../controllers/CoordinacionController.php';

session_start();

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        // Crear nueva coordinacion
        $datos = [
            'coord_nombre' => trim($_POST['coord_nombre'] ?? ''),
            'centro_formacion_cent_id' => intval($_POST['centro_formacion_cent_id'] ?? 0)
        ];
        
        // Validación básica
        if (empty($datos['coord_nombre'])) {
            $_SESSION['error'] = 'El nombre de la coordinación es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        $resultado = CoordinacionController::crearCoordinacion($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        // Actualizar coordinacion existente
        $coordinacionId = intval($_POST['coord_id'] ?? 0);
        $datos = [
            'coord_nombre' => trim($_POST['coord_nombre'] ?? ''),
            'centro_formacion_cent_id' => intval($_POST['centro_formacion_cent_id'] ?? 0)
        ];
        
        // Validación básica
        if ($coordinacionId <= 0) {
            $_SESSION['error'] = 'ID de coordinacion inválido';
            header('Location: index.php');
            exit;
        }
        
        if (empty($datos['coord_nombre'])) {
            $_SESSION['error'] = 'El nombre de la coordinación es obligatorio';
            header('Location: editar.php?id=' . $coordinacionId);
            exit;
        }
        
        $resultado = CoordinacionController::actualizarCoordinacion($coordinacionId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $coordinacionId);
        }
        break;
        
    case 'delete':
        // Eliminar coordinacion
        $coordinacionId = intval($_POST['coord_id'] ?? 0);
        
        if ($coordinacionId <= 0) {
            $_SESSION['error'] = 'ID de coordinacion inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = CoordinacionController::eliminarCoordinacion($coordinacionId);
        
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
