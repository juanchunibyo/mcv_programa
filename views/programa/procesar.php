<?php
/**
 * Procesador de acciones CRUD para Programas
 */

require_once __DIR__ . '/../../controllers/ProgramaController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'prog_codigo' => intval($_POST['prog_codigo'] ?? 0),
            'tit_programa_id' => intval($_POST['tit_programa_id'] ?? 0),
            'prog_tipo' => trim($_POST['prog_tipo'] ?? ''),
            'sede_id' => intval($_POST['sede_id'] ?? 0)
        ];
        
        // Convertir sede_id = 0 a NULL
        if ($datos['sede_id'] === 0) {
            $datos['sede_id'] = null;
        }
        
        if ($datos['prog_codigo'] <= 0) {
            $_SESSION['error'] = 'El código del programa es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        if ($datos['tit_programa_id'] <= 0) {
            $_SESSION['error'] = 'El título del programa es obligatorio';
            header('Location: crear.php');
            exit;
        }
        
        // Verificar si el código ya existe
        $programas = ProgramaController::obtenerTodosProgramas();
        foreach ($programas as $prog) {
            if ($prog['prog_codigo'] == $datos['prog_codigo']) {
                $_SESSION['error'] = 'El código de programa ' . $datos['prog_codigo'] . ' ya existe';
                header('Location: crear.php');
                exit;
            }
        }
        
        $resultado = ProgramaController::crearPrograma($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'update':
        $progId = intval($_POST['prog_id'] ?? 0);
        $datos = [
            'prog_codigo' => intval($_POST['prog_codigo'] ?? 0),
            'tit_programa_id' => intval($_POST['tit_programa_id'] ?? 0),
            'prog_tipo' => trim($_POST['prog_tipo'] ?? ''),
            'sede_id' => intval($_POST['sede_id'] ?? 0)
        ];
        
        // Convertir sede_id = 0 a NULL
        if ($datos['sede_id'] === 0) {
            $datos['sede_id'] = null;
        }
        
        if ($progId <= 0) {
            $_SESSION['error'] = 'ID de programa inválido';
            header('Location: index.php');
            exit;
        }
        
        if ($datos['prog_codigo'] <= 0) {
            $_SESSION['error'] = 'El código del programa es obligatorio';
            header('Location: editar.php?id=' . $progId);
            exit;
        }
        
        if ($datos['tit_programa_id'] <= 0) {
            $_SESSION['error'] = 'El título del programa es obligatorio';
            header('Location: editar.php?id=' . $progId);
            exit;
        }
        
        // Verificar si el código ya existe en otro programa
        $programas = ProgramaController::obtenerTodosProgramas();
        foreach ($programas as $prog) {
            if ($prog['prog_codigo'] == $datos['prog_codigo'] && $prog['prog_id'] != $progId) {
                $_SESSION['error'] = 'El código de programa ' . $datos['prog_codigo'] . ' ya existe en otro programa';
                header('Location: editar.php?id=' . $progId);
                exit;
            }
        }
        
        $resultado = ProgramaController::actualizarPrograma($progId, $datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: editar.php?id=' . $progId);
        }
        break;
        
    case 'delete':
        $progId = intval($_POST['prog_id'] ?? 0);
        
        if ($progId <= 0) {
            $_SESSION['error'] = 'ID de programa inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = ProgramaController::eliminarPrograma($progId);
        
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
