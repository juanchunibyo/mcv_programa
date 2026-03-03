<?php
require 'Conexion.php';
$db = Conexion::getConnect();
$stmt = $db->query("DESCRIBE detalle_asignacion");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
