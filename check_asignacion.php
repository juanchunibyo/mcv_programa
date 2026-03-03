<?php
require_once __DIR__ . '/Conexion.php';
$db = Conexion::getConnect();
$stmt = $db->query('SELECT asig_id, instructor_inst_id, ficha_fich_id FROM asignacion');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
