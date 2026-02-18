<?php
/**
 * Procesador de acciones CRUD para Ambientes
 */

require_once __DIR__ . '/../../controllers/AmbienteController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'amb_nombre' => trim($_POST['amb_nombre'] ?? ''),
            'amb_capacidad' => intval($_POST['amb_capacidad'] ?? 0),
            'sede_id' => intval($_POST['sede_id'] ?? 0)
        ];
        
        // Si sede_id es 0, convertir a NULL
        if ($datos['sede_id'] === 0) {
            $datos['sede_id'] = null;
        }
        
        if (empty($datos['amb_nombre'])) {
            $_SESSION['error'] = 'El nombre del ambiente es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        $resultado = AmbienteController::crearAmbiente($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        $ambId = intval($_POST['amb_id'] ?? 0);
        $datos = [
            'amb_nombre' => trim($_POST['amb_nombre'] ?? ''),
            'amb_capacidad' => intval($_POST['amb_capacidad'] ?? 0),
            'sede_id' => intval($_POST['sede_id'] ?? 0)
        ];
        
        if ($ambId <= 0) {
            $_SESSION['error'] = 'ID de ambiente inválido';
            header('Location: index.php');
            exit;
        }
        
        if (empty($datos['amb_nombre'])) {
            $_SESSION['error'] = 'El nombre del ambiente es obligatorio';
            header('Location: editar.php?id=' . $ambId);
            exit;
        }
        
        $resultado = AmbienteController::actualizarAmbiente($ambId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $ambId);
        }
        break;
        
    case 'delete':
        $ambId = intval($_POST['amb_id'] ?? 0);
        
        if ($ambId <= 0) {
            $_SESSION['error'] = 'ID de ambiente inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = AmbienteController::eliminarAmbiente($ambId);
        
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
