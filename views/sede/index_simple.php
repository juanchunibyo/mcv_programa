<?php
/**
 * Vista SIMPLE de Sedes - Sin sesiones para debugging
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Gestión de Sedes (Versión Simple)</h1>";
echo "<style>body{font-family:Arial;padding:20px;} table{border-collapse:collapse;width:100%;margin:20px 0;} th,td{border:1px solid #ddd;padding:8px;} th{background:#39A900;color:white;}</style>";

echo "<p>Cargando controlador...</p>";

try {
    require_once __DIR__ . '/../../controllers/SedeController.php';
    echo "<p style='color:green;'>✓ Controlador cargado</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>✗ Error al cargar controlador: " . $e->getMessage() . "</p>";
    die();
}

echo "<p>Obteniendo sedes...</p>";

try {
    $sedes = SedeController::obtenerTodasSedes();
    echo "<p style='color:green;'>✓ Sedes obtenidas: " . count($sedes) . "</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>✗ Error al obtener sedes: " . $e->getMessage() . "</p>";
    die();
}

if (!empty($sedes)) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>";
    foreach ($sedes as $sede) {
        echo "<tr>";
        echo "<td>{$sede['sede_id']}</td>";
        echo "<td>{$sede['sede_nombre']}</td>";
        echo "<td>";
        echo "<a href='ver.php?id={$sede['sede_id']}'>Ver</a> | ";
        echo "<a href='editar.php?id={$sede['sede_id']}'>Editar</a> | ";
        echo "<a href='#' onclick='return confirm(\"¿Eliminar?\")'>Eliminar</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay sedes registradas.</p>";
}

echo "<p><a href='crear.php'>Crear Nueva Sede</a></p>";
?>
