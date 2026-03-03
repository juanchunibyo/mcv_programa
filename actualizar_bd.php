<?php
/**
 * Script rápido para añadir el rol "centro de formacion" a la base de datos
 */

// Configuración de visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Actualización BD</title><style>body { font-family: Arial; padding: 20px; text-align: center; } .success { color: green; font-weight: bold; } .error { color: red; font-weight: bold; }</style></head><body>";
echo "<h1>Actualizando Roles en la Base de Datos...</h1>";

try {
    // Requerir el archivo de conexión
    require_once __DIR__ . '/Conexion.php';
    
    // Obtener conexión
    $pdo = Conexion::getConnect();
    
    // Verificar si el rol ya existe
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM rol WHERE rol_nombre = 'centro de formacion'");
    $stmtCheck->execute();
    $existe = $stmtCheck->fetchColumn();

    if ($existe > 0) {
        echo "<p class='success'>¡Todo listo! El rol 'centro de formacion' ya existe en la base de datos.</p>";
    } else {
        // Ejecutar el INSERT
        $sql = "INSERT INTO rol (rol_nombre) VALUES ('centro de formacion')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        echo "<p class='success'>¡Éxito! Se ha creado el rol 'centro de formacion' en la tabla 'rol'.</p>";
    }
    
    echo "<br><a href='index.php?action=login' style='display:inline-block; padding:10px 20px; background:#39A900; color:white; text-decoration:none; border-radius:5px;'>Volver al Login / Registro</a>";
    
} catch (PDOException $e) {
    echo "<p class='error'>Error de la Base de Datos: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p class='error'>Error General: " . $e->getMessage() . "</p>";
}
echo "</body></html>";
?>
