<?php
require 'Conexion.php';
$db = Conexion::getConnect();
$stmt = $db->query('SELECT * FROM rol');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
