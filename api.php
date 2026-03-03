<?php
/**
 * API (Punto de Entrada AJAX)
 * 
 * Este archivo recibe peticiones AJAX/Fetch desde Javascript y retorna datos en Json.
 */
session_start();

// Verificar autenticación básica para la API
if (!isset($_SESSION['usuario_logueado'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Desactivar impresión de errores en pantalla para no romper el JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Configurar encabezados para respuestas tipo JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener la acción requerida
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'instructores_por_ficha':
        require_once __DIR__ . '/controllers/InstructorController.php';
        $ficha_id = $_GET['ficha_id'] ?? '';
        
        if (empty($ficha_id)) {
            echo json_encode(['success' => false, 'message' => 'Ficha ID no proporcionado']);
            exit;
        }
        
        // Llamar al nuevo método que crearemos en InstructorController
        $instructores = InstructorController::obtenerInstructoresPorFicha($ficha_id);
        
        // Limpiamos buffer por si algún archivo incluyó saltos de línea extra o warnings
        if (ob_get_length()) ob_clean();
        
        echo json_encode([
            'success' => true,
            'data' => $instructores
        ]);
        break;

    case 'ambientes_por_sede':
        require_once __DIR__ . '/controllers/AmbienteController.php';
        $sede_id = $_GET['sede_id'] ?? '';
        
        if (empty($sede_id)) {
            echo json_encode(['success' => false, 'message' => 'Sede ID no proporcionado']);
            exit;
        }
        
        $ambientes = AmbienteController::obtenerAmbientesPorSede($sede_id);
        
        if (ob_get_length()) ob_clean();
        
        echo json_encode([
            'success' => true,
            'data' => $ambientes
        ]);
        break;

    case 'guardar_asignacion':
        require_once __DIR__ . '/controllers/AsignacionController.php';
        
        // Recibir los datos enviados por Fetch (JSON)
        $rawData = file_get_contents("php://input");
        $datos = json_decode($rawData, true);
        
        // Fallback genérico por si envían formData tradicional
        if (!$datos) {
            $datos = $_POST;
        }

        // Validación básica de campos vacíos
        if (empty($datos['ficha_id']) || empty($datos['instructor_id']) || empty($datos['ambiente_id']) || empty($datos['fecha_inicio']) || empty($datos['fecha_fin'])) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios en el formulario.']);
            exit;
        }

        // Derivar al Controlador para Validación Compleja e Inserción
        $resultado = AsignacionController::crearAsignacion($datos);
        
        if (ob_get_length()) ob_clean();
        echo json_encode($resultado);
        break;

    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Acción no encontrada']);
        break;
}
