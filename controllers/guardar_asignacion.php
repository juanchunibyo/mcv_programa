<?php
/**
 * Procesar creación de asignación desde el calendario
 */

header('Content-Type: application/json');

require_once __DIR__ . '/AsignacionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validar datos requeridos
    $required = ['ficha_id', 'instructor_id', 'ambiente_id', 'fecha', 'hora_inicio', 'hora_fin'];
    $missing = [];
    
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos requeridos: ' . implode(', ', $missing)
        ]);
        exit;
    }
    
    // Preparar datos
    $datos = [
        'ficha_id' => $_POST['ficha_id'],
        'instructor_id' => $_POST['instructor_id'],
        'ambiente_id' => $_POST['ambiente_id'],
        'fecha_inicio' => $_POST['fecha'],
        'fecha_fin' => $_POST['fecha'], // Por ahora la misma fecha
        'hora_inicio' => $_POST['hora_inicio'],
        'hora_fin' => $_POST['hora_fin'],
        'competencia_id' => $_POST['competencia_id'] ?? null
    ];
    
    // Crear asignación
    $resultado = AsignacionController::crearAsignacion($datos);
    
    echo json_encode($resultado);
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
