<?php
/**
 * Archivo de diagnóstico para Sede
 */

echo "<h1>Diagnóstico de Sede</h1>";
echo "<pre>";

// Test 1: Verificar que el archivo existe
echo "1. Verificando archivos...\n";
echo "   - Conexion.php existe: " . (file_exists(__DIR__ . '/Conexion.php') ? "SÍ" : "NO") . "\n";
echo "   - EnvLoader.php existe: " . (file_exists(__DIR__ . '/EnvLoader.php') ? "SÍ" : "NO") . "\n";
echo "   - SedeController.php existe: " . (file_exists(__DIR__ . '/controllers/SedeController.php') ? "SÍ" : "NO") . "\n";
echo "   - SedeModel.php existe: " . (file_exists(__DIR__ . '/model/SedeModel.php') ? "SÍ" : "NO") . "\n\n";

// Test 2: Verificar drivers PDO
echo "2. Drivers PDO disponibles:\n";
$drivers = PDO::getAvailableDrivers();
foreach ($drivers as $driver) {
    echo "   - $driver\n";
}
echo "\n";

// Test 3: Intentar cargar Conexion
echo "3. Cargando Conexion.php...\n";
try {
    require_once __DIR__ . '/Conexion.php';
    echo "   ✓ Conexion.php cargado correctamente\n\n";
} catch (Exception $e) {
    echo "   ✗ Error al cargar Conexion.php: " . $e->getMessage() . "\n\n";
    die();
}

// Test 4: Intentar obtener conexión
echo "4. Intentando conectar a la base de datos...\n";
try {
    $db = Conexion::getConnect();
    echo "   ✓ Conexión exitosa\n";
    echo "   - Tipo de conexión: " . get_class($db) . "\n\n";
} catch (Exception $e) {
    echo "   ✗ Error de conexión: " . $e->getMessage() . "\n\n";
    die();
}

// Test 5: Intentar cargar SedeModel
echo "5. Cargando SedeModel.php...\n";
try {
    require_once __DIR__ . '/model/SedeModel.php';
    echo "   ✓ SedeModel.php cargado correctamente\n\n";
} catch (Exception $e) {
    echo "   ✗ Error al cargar SedeModel.php: " . $e->getMessage() . "\n\n";
    die();
}

// Test 6: Intentar crear instancia de SedeModel
echo "6. Creando instancia de SedeModel...\n";
try {
    $sedeModel = new SedeModel(null, '');
    echo "   ✓ SedeModel instanciado correctamente\n\n";
} catch (Exception $e) {
    echo "   ✗ Error al instanciar SedeModel: " . $e->getMessage() . "\n\n";
    die();
}

// Test 7: Intentar obtener todas las sedes
echo "7. Obteniendo todas las sedes...\n";
try {
    $sedes = $sedeModel->readAll();
    echo "   ✓ Consulta exitosa\n";
    echo "   - Número de sedes: " . count($sedes) . "\n";
    if (count($sedes) > 0) {
        echo "   - Primera sede: " . print_r($sedes[0], true) . "\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "   ✗ Error en consulta: " . $e->getMessage() . "\n\n";
    die();
}

// Test 8: Intentar cargar SedeController
echo "8. Cargando SedeController.php...\n";
try {
    require_once __DIR__ . '/controllers/SedeController.php';
    echo "   ✓ SedeController.php cargado correctamente\n\n";
} catch (Exception $e) {
    echo "   ✗ Error al cargar SedeController.php: " . $e->getMessage() . "\n\n";
    die();
}

// Test 9: Intentar usar SedeController
echo "9. Usando SedeController::obtenerTodasSedes()...\n";
try {
    $sedes = SedeController::obtenerTodasSedes();
    echo "   ✓ Método ejecutado correctamente\n";
    echo "   - Número de sedes: " . count($sedes) . "\n";
    if (count($sedes) > 0) {
        echo "   - Primera sede: " . print_r($sedes[0], true) . "\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "   ✗ Error en método: " . $e->getMessage() . "\n\n";
    die();
}

echo "</pre>";
echo "<h2 style='color: green;'>✓ TODOS LOS TESTS PASARON CORRECTAMENTE</h2>";
echo "<p><a href='views/sede/index.php'>Ir a Gestión de Sedes</a></p>";
?>
