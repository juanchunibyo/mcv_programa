<?php
/**
 * Procesador de acciones CRUD para Competencia-Programa
 */

require_once __DIR__ . '/../../controllers/CompetenciaProgramaController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'programa_id' => intval($_POST['PROGRAMA_prog_id'] ?? 0),
            'competencia_id' => intval($_POST['COMPETENCIA_comp_id'] ?? 0)
        ];
        
        if ($datos['programa_id'] <= 0 || $datos['competencia_id'] <= 0) {
            $_SESSION['error'] = 'Debe seleccionar un programa y una competencia';
            header('Location: crear.php');
            exit;
        }
        
        // Verificar si la relación ya existe
        $relaciones = CompetenciaProgramaController::obtenerTodasRelaciones();
        foreach ($relaciones as $rel) {
            if ($rel['programa_prog_id'] == $datos['programa_id'] && $rel['competencia_comp_id'] == $datos['competencia_id']) {
                $_SESSION['error'] = 'Esta competencia ya está asociada a este programa';
                header('Location: crear.php');
                exit;
            }
        }
        
        $resultado = CompetenciaProgramaController::asignarCompetenciaAPrograma($datos);
        
        if ($resultado['success']) {
            $_SESSION['mensaje'] = $resultado['message'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = $resultado['message'];
            header('Location: crear.php');
        }
        break;
        
    case 'delete':
        $programaId = intval($_POST['PROGRAMA_prog_id'] ?? 0);
        $competenciaId = intval($_POST['COMPETENCIA_comp_id'] ?? 0);
        
        if ($programaId <= 0 || $competenciaId <= 0) {
            $_SESSION['error'] = 'IDs inválidos';
            header('Location: index.php');
            exit;
        }
        
        $resultado = CompetenciaProgramaController::eliminarRelacion($programaId, $competenciaId);
        
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
