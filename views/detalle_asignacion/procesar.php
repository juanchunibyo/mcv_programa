<?php
/**
 * Procesador de acciones CRUD para Detalles de Asignación
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
            'asignacion_id' => intval($_POST['asignacion_asig_id'] ?? 0),
            'hora_inicio' => trim($_POST['detasig_hora_ini'] ?? ''),
            'hora_fin' => trim($_POST['detasig_hora_fin'] ?? '')
        ];
        
        if ($datos['asignacion_id'] <= 0 || empty($datos['hora_inicio']) || empty($datos['hora_fin'])) {
            $_SESSION['error'] = 'Debe completar todos los campos obligatorios';
            header('Location: crear.php');
            exit;
        }
        
        // Convertir formato datetime-local a timestamp PostgreSQL
        $datos['hora_inicio'] = str_replace('T', ' ', $datos['hora_inicio']) . ':00';
        $datos['hora_fin'] = str_replace('T', ' ', $datos['hora_fin']) . ':00';
        
        // Validar que hora_fin sea mayor que hora_inicio
        if (strtotime($datos['hora_fin']) <= strtotime($datos['hora_inicio'])) {
            $_SESSION['error'] = 'La hora de fin debe ser posterior a la hora de inicio';
            header('Location: crear.php');
            exit;
        }
        
        // Verificar conflictos de horario
        $detalles = DetalleAsignacionController::obtenerDetallesPorAsignacion($datos['asignacion_id']);
        foreach ($detalles as $det) {
            if (($datos['hora_inicio'] >= $det['detasig_hora_ini'] && $datos['hora_inicio'] < $det['detasig_hora_fin']) ||
                ($datos['hora_fin'] > $det['detasig_hora_ini'] && $datos['hora_fin'] <= $det['detasig_hora_fin']) ||
                ($datos['hora_inicio'] <= $det['detasig_hora_ini'] && $datos['hora_fin'] >= $det['detasig_hora_fin'])) {
                $_SESSION['error'] = 'Ya existe un horario en ese rango de tiempo para esta asignación';
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
            'asignacion_id' => intval($_POST['asignacion_asig_id'] ?? 0),
            'hora_inicio' => trim($_POST['detasig_hora_ini'] ?? ''),
            'hora_fin' => trim($_POST['detasig_hora_fin'] ?? '')
        ];
        
        if ($detalleId <= 0 || $datos['asignacion_id'] <= 0 || empty($datos['hora_inicio']) || empty($datos['hora_fin'])) {
            $_SESSION['error'] = 'Datos inválidos';
            header('Location: index.php');
            exit;
        }
        
        // Convertir formato datetime-local a timestamp PostgreSQL
        $datos['hora_inicio'] = str_replace('T', ' ', $datos['hora_inicio']) . ':00';
        $datos['hora_fin'] = str_replace('T', ' ', $datos['hora_fin']) . ':00';
        
        // Validar que hora_fin sea mayor que hora_inicio
        if (strtotime($datos['hora_fin']) <= strtotime($datos['hora_inicio'])) {
            $_SESSION['error'] = 'La hora de fin debe ser posterior a la hora de inicio';
            header('Location: editar.php?id=' . $detalleId);
            exit;
        }
        
        $resultado = DetalleAsignacionController::actualizarDetalleAsignacion($detalleId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
        } else {
            $_SESSION['error'] = $resultado['message'];
        }
        
        header('Location: index.php');
        break;
        
    case 'delete':
        $detalleId = intval($_POST['detasig_id'] ?? 0);
        
        if ($detalleId <= 0) {
            $_SESSION['error'] = 'ID de horario inválido';
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
