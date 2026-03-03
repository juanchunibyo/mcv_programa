<?php
require_once __DIR__ . '/Conexion.php';
require_once __DIR__ . '/controllers/AsignacionController.php';

$res = AsignacionController::eliminarAsignacion(1); // Try deleting an ID that might or might not exist
print_r($res);
