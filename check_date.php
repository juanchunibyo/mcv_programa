<?php
require 'Conexion.php';
$db = Conexion::getConnect();
$stmt = $db->query("SELECT asig_fecha_ini FROM asignacion LIMIT 1");
print_r($stmt->fetch(PDO::FETCH_ASSOC));
