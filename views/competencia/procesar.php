<?php
require_once __DIR__ . '/../../controllers/CompetenciaController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $datos = [
            'comp_nombre_corto' => trim($_POST['comp_nombre_corto'] ?? ''),
            'comp_horas' => intval($_POST['comp_horas'] ?? 0),
            'comp_nombre_unidad_competencia' => trim($_POST['comp_nombre_unidad_competencia'] ?? '')
        ];
        
        if (empty($datos['comp_nombre_corto']) || $datos['comp_horas'] <= 0) {
            $_SESSION['error'] = 'Nombre corto y horas son obligatorios';
            header('Location: crear.php');
            exit;
        }
        
        // Verificar si el nombre corto ya existe
        $competencias = CompetenciaController::obtenerTodasCompetencias();
        foreach ($competencias as $comp) {
            if (strtolower(trim($comp['comp_nombre_corto'])) == strtolower(trim($datos['comp_nombre_corto']))) {
                $_SESSION['error'] = 'Ya existe una competencia con el nombre "' . $datos['comp_nombre_corto'] . '"';
                header('Location: crear.php');
                exit;
            }
        }
        
        $resultado = CompetenciaController::crearCompetencia($datos);
        $_SESSION[$resultado['success'] ? 'mensaje' : 'error'] = $resultado['message'];
        header('Location: ' . ($resultado['success'] ? 'index.php' : 'crear.php'));
        break;
        
    case 'update':
        $compId = intval($_POST['comp_id'] ?? 0);
        $datos = [
            'comp_nombre_corto' => trim($_POST['comp_nombre_corto'] ?? ''),
            'comp_horas' => intval($_POST['comp_horas'] ?? 0),
            'comp_nombre_unidad_competencia' => trim($_POST['comp_nombre_unidad_competencia'] ?? '')
        ];
        
        if ($compId <= 0 || empty($datos['comp_nombre_corto']) || $datos['comp_horas'] <= 0) {
            $_SESSION['error'] = 'Datos inválidos';
            header('Location: ' . ($compId > 0 ? "editar.php?id=$compId" : 'index.php'));
            exit;
        }
        
        // Verificar si el nombre corto ya existe en otra competencia
        $competencias = CompetenciaController::obtenerTodasCompetencias();
        foreach ($competencias as $comp) {
            if (strtolower(trim($comp['comp_nombre_corto'])) == strtolower(trim($datos['comp_nombre_corto'])) && $comp['comp_id'] != $compId) {
                $_SESSION['error'] = 'Ya existe otra competencia con el nombre "' . $datos['comp_nombre_corto'] . '"';
                header('Location: "editar.php?id=$compId"');
                exit;
            }
        }
        
        $resultado = CompetenciaController::actualizarCompetencia($compId, $datos);
        $_SESSION[$resultado['success'] ? 'mensaje' : 'error'] = $resultado['message'];
        header('Location: ' . ($resultado['success'] ? 'index.php' : "editar.php?id=$compId"));
        break;
        
    case 'delete':
        $compId = intval($_POST['comp_id'] ?? 0);
        if ($compId <= 0) {
            $_SESSION['error'] = 'ID inválido';
            header('Location: index.php');
            exit;
        }
        
        $resultado = CompetenciaController::eliminarCompetencia($compId);
        $_SESSION[$resultado['success'] ? 'mensaje' : 'error'] = $resultado['message'];
        header('Location: index.php');
        break;
        
    default:
        $_SESSION['error'] = 'Acción no válida';
        header('Location: index.php');
}
exit;
