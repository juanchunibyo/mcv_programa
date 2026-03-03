<?php
require 'Conexion.php';
$db = Conexion::getConnect();
$stmt = $db->query("DESCRIBE instructor");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
