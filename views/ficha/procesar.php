<?php
/**
 * Procesador de acciones CRUD para Fichas
 */

require_once __DIR__ . '/../../controllers/FichaController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'programa_id' => intval($_POST['programa_id'] ?? 0),
            'instructor_id' => intval($_POST['instructor_id'] ?? 0),
            'fich_jornada' => trim($_POST['fich_jornada'] ?? ''),
            'coordinacion_id' => intval($_POST['coordinacion_id'] ?? 0)
        ];
        
        if ($datos['programa_id'] <= 0) {
            $_SESSION['error'] = 'El programa es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        if ($datos['instructor_id'] <= 0) {
            $_SESSION['error'] = 'El instructor es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        if ($datos['coordinacion_id'] <= 0) {
            $_SESSION['error'] = 'La coordinación es obligatoria';
            header('Location: crear.php');
            exit;
        }
        
        // Verificar si el programa ya está asignado a otro instructor
        $fichas = FichaController::obtenerTodasFichas();
        foreach ($fichas as $f) {
            if ($f['programa_prog_id'] == $datos['programa_id']) {
                $_SESSION['error'] = 'Este programa ya está asignado a otro instructor (' . ($f['inst_nombres'] ?? '') . ' ' . ($f['inst_apellidos'] ?? '') . ')';
                header('Location: crear.php');
                exit;
            }
        }
        
        $resultado = FichaController::crearFicha($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        $fichId = intval($_POST['fich_id'] ?? 0);
        $datos = [
            'programa_id' => intval($_POST['programa_id'] ?? 0),
            'instructor_id' => intval($_POST['instructor_id'] ?? 0),
            'fich_jornada' => trim($_POST['fich_jornada'] ?? ''),
            'coordinacion_id' => intval($_POST['coordinacion_id'] ?? 0)
        ];
        
        // Convertir coordinacion_id = 0 a NULL
        if ($datos['coordinacion_id'] === 0) {
            $datos['coordinacion_id'] = null;
        }
        
        if ($fichId <= 0) {
            $_SESSION['error'] = 'ID de ficha inválido';
            header('Location: index.php');
            exit;
        }
        
        if ($datos['programa_id'] <= 0) {
            $_SESSION['error'] = 'El programa es obligatorio';
            header('Location: editar.php?id=' . $fichId);
            exit;
        }
        
        if ($datos['instructor_id'] <= 0) {
            $_SESSION['error'] = 'El instructor es obligatorio';
            header('Location: editar.php?id=' . $fichId);
            exit;
        }
        
        // Verificar si el programa ya está asignado a otro instructor (excepto esta ficha)
        $fichas = FichaController::obtenerTodasFichas();
        foreach ($fichas as $f) {
            if ($f['programa_prog_id'] == $datos['programa_id'] && $f['fich_id'] != $fichId) {
                $_SESSION['error'] = 'Este programa ya está asignado a otro instructor (' . ($f['inst_nombres'] ?? '') . ' ' . ($f['inst_apellidos'] ?? '') . ')';
                header('Location: editar.php?id=' . $fichId);
                exit;
            }
        }
        
        $resultado = FichaController::actualizarFicha($fichId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $fichId);
        }
        break;
        
    case 'delete':
        $fichId = intval($_POST['fich_id'] ?? 0);
        
        if ($fichId <= 0) {
            $_SESSION['error'] = 'ID de ficha inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = FichaController::eliminarFicha($fichId);
        
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
