<?php
/**
 * Procesador de acciones CRUD para Centros de Formación
 * Maneja: crear, actualizar, eliminar
 */

require_once __DIR__ . '/../../controllers/CentroFormacionController.php';

session_start();

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        // Crear nueva centro_formacion
        $datos = [
            'cent_nombre' => trim($_POST['cent_nombre'] ?? '')
        ];
        
        // Validación básica
        if (empty($datos['cent_nombre'])) {
            $_SESSION['error'] = 'El nombre de el centro de formación es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        $resultado = CentroFormacionController::crearCentroFormacion($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        // Actualizar centro_formacion existente
        $centro_formacionId = intval($_POST['cent_id'] ?? 0);
        $datos = [
            'cent_nombre' => trim($_POST['cent_nombre'] ?? '')
        ];
        
        // Validación básica
        if ($centro_formacionId <= 0) {
            $_SESSION['error'] = 'ID de centro_formacion inválido';
            header('Location: index.php');
            exit;
        }
        
        if (empty($datos['cent_nombre'])) {
            $_SESSION['error'] = 'El nombre de el centro de formación es obligatorio';
            header('Location: editar.php?id=' . $centro_formacionId);
            exit;
        }
        
        $resultado = CentroFormacionController::actualizarCentroFormacion($centro_formacionId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $centro_formacionId);
        }
        break;
        
    case 'delete':
        // Eliminar centro_formacion
        $centro_formacionId = intval($_POST['cent_id'] ?? 0);
        
        if ($centro_formacionId <= 0) {
            $_SESSION['error'] = 'ID de centro_formacion inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = CentroFormacionController::eliminarCentroFormacion($centro_formacionId);
        
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
