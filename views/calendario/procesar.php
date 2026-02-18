<?php
/**
 * Procesador de asignaciones desde el calendario
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';
require_once __DIR__ . '/../../controllers/DetalleAsignacionController.php';

header('Content-Type: application/json');
session_start();

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$action = $_POST['action'] ?? 'create';

if ($action === 'create') {
    try {
        // Datos de la asignación
        $datos = [
            'instructor_inst_id' => intval($_POST['instructor_id'] ?? 0),
            'ficha_fich_id' => intval($_POST['ficha_id'] ?? 0),
            'ambiente_amb_id' => intval($_POST['ambiente_id'] ?? 0),
            'competencia_comp_id' => intval($_POST['competencia_id'] ?? 0),
            'asig_fecha_ini' => $_POST['fecha'] . ' ' . $_POST['hora_inicio'] . ':00',
            'asig_fecha_fin' => $_POST['fecha'] . ' ' . $_POST['hora_fin'] . ':00'
        ];
        
        // Validación básica
        if ($datos['instructor_inst_id'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'Debe seleccionar un instructor válido']);
            exit;
        }
        
        if ($datos['ficha_fich_id'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'Debe seleccionar una ficha válida']);
            exit;
        }
        
        if ($datos['ambiente_amb_id'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'Debe seleccionar un ambiente válido']);
            exit;
        }
        
        if (empty($_POST['fecha']) || empty($_POST['hora_inicio']) || empty($_POST['hora_fin'])) {
            echo json_encode(['success' => false, 'message' => 'Debe completar fecha y horarios']);
            exit;
        }
        
        // Crear asignación
        $resultado = AsignacionController::crearAsignacion($datos);
        
        if ($resultado['success']) {
            // Crear detalle de asignación
            $asigId = $resultado['asig_id'];
            $datosDetalle = [
                'asignacion_asig_id' => $asigId,
                'detasig_hora_ini' => $_POST['fecha'] . ' ' . $_POST['hora_inicio'] . ':00',
                'detasig_hora_fin' => $_POST['fecha'] . ' ' . $_POST['hora_fin'] . ':00'
            ];
            
            DetalleAsignacionController::crearDetalleAsignacion($datosDetalle);
            
            echo json_encode([
                'success' => true,
                'message' => 'Asignación creada exitosamente',
                'asig_id' => $asigId
            ]);
        } else {
            echo json_encode($resultado);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Error al guardar: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}

exit;
