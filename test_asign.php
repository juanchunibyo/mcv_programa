<?php
require_once 'Conexion.php';
require_once 'controllers/AsignacionController.php';
try {
    $db = Conexion::getConnect();
    $datos = [
        'instructor_id' => 1,
        'fecha_inicio' => '2024-05-01',
        'fecha_fin' => '2024-05-01',
        'ficha_id' => 1,
        'ambiente_id' => 1,
        'competencia_id' => 1,
        'hora_inicio' => '10:00',
        'hora_fin' => '12:00'
    ];
    $datos['fecha_inicio'] = $datos['fecha_inicio'] . ' 00:00:00';
    $datos['fecha_fin'] = $datos['fecha_fin'] . ' 23:59:59';
    var_dump(AsignacionController::crearAsignacion($datos));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
