<?php
/**
 * Procesador de acciones CRUD para Detalle de Asignación
 */

require_once __DIR__ . '/../../controllers/DetalleAsignacionController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'asignacion_id' => intval($_POST['ASIGNACION_asig_id'] ?? 0),
            'hora_inicio' => trim($_POST['detasig_hora_ini'] ?? ''),
            'hora_fin' => trim($_POST['detasig_hora_fin'] ?? '')
        ];
        
        if ($datos['asignacion_id'] <= 0) {
            $_SESSION['error'] = 'Debe seleccionar una asignación';
            header('Location: crear.php');
            exit;
        }
        
        // Verificar si ya existe un detalle con las mismas horas para esta asignación
        $detalles = DetalleAsignacionController::obtenerTodosDetalles();
        foreach ($detalles as $det) {
            if ($det['asignacion_asig_id'] == $datos['asignacion_id'] && 
                $det['detasig_hora_ini'] == $datos['hora_inicio'] && 
                $det['detasig_hora_fin'] == $datos['hora_fin']) {
                $_SESSION['error'] = 'Ya existe un horario idéntico para esta asignación';
                header('Location: crear.php');
                exit;
            }
        }
        
        $resultado = DetalleAsignacionController::crearDetalleAsignacion($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        $detalleId = intval($_POST['detasig_id'] ?? 0);
        $datos = [
            'asignacion_id' => intval($_POST['ASIGNACION_asig_id'] ?? 0),
            'hora_inicio' => trim($_POST['detasig_hora_ini'] ?? ''),
            'hora_fin' => trim($_POST['detasig_hora_fin'] ?? '')
        ];
        
        if ($detalleId <= 0) {
            $_SESSION['error'] = 'ID de detalle inválido';
            header('Location: index.php');
            exit;
        }
        
        if ($datos['asignacion_id'] <= 0) {
            $_SESSION['error'] = 'Debe seleccionar una asignación';
            header('Location: editar.php?id=' . $detalleId);
            exit;
        }
        
        $resultado = DetalleAsignacionController::actualizarDetalleAsignacion($detalleId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $detalleId);
        }
        break;
        
    case 'delete':
        $detalleId = intval($_POST['detasig_id'] ?? 0);
        
        if ($detalleId <= 0) {
            $_SESSION['error'] = 'ID de detalle inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = DetalleAsignacionController::eliminarDetalleAsignacion($detalleId);
        
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
