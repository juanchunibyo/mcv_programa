<?php
require_once __DIR__ . '/Conexion.php';
$db = Conexion::getConnect();

// Limpiar asignaciones sin detalle válido
$db->query("DELETE FROM asignacion WHERE asig_id NOT IN (SELECT asignacion_asig_id FROM detalle_asignacion)");

// Limpiar detalles huérfanos
$db->query("DELETE FROM detalle_asignacion WHERE asignacion_asig_id = 0 OR asignacion_asig_id NOT IN (SELECT asig_id FROM asignacion)");

echo "Limpieza completada.";
