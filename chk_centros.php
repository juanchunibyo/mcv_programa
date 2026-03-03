<?php
require 'Conexion.php';
$db = Conexion::getConnect();
$res = $db->query('SELECT * FROM centro_formacion')->fetchAll(PDO::FETCH_ASSOC);
print_r($res);
