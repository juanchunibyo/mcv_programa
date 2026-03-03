<?php
/**
 * Procesador de acciones CRUD para Asignaciones
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'instructor_id' => intval($_POST['INSTRUCTOR_inst_id'] ?? 0),
            'fecha_inicio' => trim($_POST['asig_fecha_ini'] ?? ''),
            'fecha_fin' => trim($_POST['asig_fecha_fin'] ?? ''),
            'ficha_id' => intval($_POST['FICHA_fich_id'] ?? 0),
            'ambiente_id' => intval($_POST['AMBIENTE_id_ambiente'] ?? 0),
            'competencia_id' => intval($_POST['COMPETENCIA_comp_id'] ?? 0),
            'hora_inicio' => trim($_POST['detasig_hora_ini'] ?? ''),
            'hora_fin' => trim($_POST['detasig_hora_fin'] ?? '')
        ];
        
        if ($datos['instructor_id'] <= 0 || $datos['ficha_id'] <= 0 || $datos['ambiente_id'] <= 0) {
            $_SESSION['error'] = 'Debe completar todos los campos obligatorios';
            $_SESSION['form_data'] = $_POST;
            header('Location: crear.php');
            exit;
        }
        
        // Convertir fechas a formato timestamp para PostgreSQL
        if (!empty($datos['fecha_inicio'])) {
            $datos['fecha_inicio'] = $datos['fecha_inicio'] . ' 00:00:00';
        }
        if (!empty($datos['fecha_fin'])) {
            $datos['fecha_fin'] = $datos['fecha_fin'] . ' 23:59:59';
        }
        
        // La validación de conflictos se realiza en el Controller mediante AsignacionModel::verificarConflicto
        
        $resultado = AsignacionController::crearAsignacion($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            $_SESSION['form_data'] = $_POST;
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        $asigId = intval($_POST['asig_id'] ?? 0);
        $datos = [
            'instructor_id' => intval($_POST['INSTRUCTOR_inst_id'] ?? 0),
            'fecha_inicio' => trim($_POST['asig_fecha_ini'] ?? ''),
            'fecha_fin' => trim($_POST['asig_fecha_fin'] ?? ''),
            'ficha_id' => intval($_POST['FICHA_fich_id'] ?? 0),
            'ambiente_id' => intval($_POST['AMBIENTE_id_ambiente'] ?? 0),
            'competencia_id' => intval($_POST['COMPETENCIA_comp_id'] ?? 0),
            'hora_inicio' => trim($_POST['detasig_hora_ini'] ?? ''),
            'hora_fin' => trim($_POST['detasig_hora_fin'] ?? '')
        ];
        
        if ($asigId <= 0 || $datos['instructor_id'] <= 0 || $datos['ficha_id'] <= 0 || $datos['ambiente_id'] <= 0) {
            $_SESSION['error'] = 'Datos inválidos';
            if ($asigId > 0) {
                $_SESSION['form_data'] = $_POST;
                header('Location: editar.php?id=' . $asigId);
            } else {
                header('Location: index.php');
            }
            exit;
        }
        
        // Convertir fechas a formato timestamp para PostgreSQL
        if (!empty($datos['fecha_inicio'])) {
            $datos['fecha_inicio'] = $datos['fecha_inicio'] . ' 00:00:00';
        }
        if (!empty($datos['fecha_fin'])) {
            $datos['fecha_fin'] = $datos['fecha_fin'] . ' 23:59:59';
        }
        
        $resultado = AsignacionController::actualizarAsignacion($asigId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            $_SESSION['form_data'] = $_POST;
            header('Location: editar.php?id=' . $asigId);
        }
        break;
        
    case 'delete':
        $asigId = intval($_POST['asig_id'] ?? 0);
        
        if ($asigId <= 0) {
            $_SESSION['error'] = 'ID de asignación inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = AsignacionController::eliminarAsignacion($asigId);
        
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
