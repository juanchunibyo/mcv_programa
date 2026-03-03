<?php
require_once __DIR__ . '/model/RolModel.php';
$rm = new RolModel();
$roles = $rm->obtenerRoles();
var_dump($roles);
