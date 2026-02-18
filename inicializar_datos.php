<?php
/**
 * Script para inicializar datos básicos en la base de datos
 * Ejecuta este archivo una vez para crear sedes, títulos de programa, etc.
 */

require_once __DIR__ . '/Conexion.php';

try {
    $db = Conexion::getConnect();
    
    echo "<h2>Inicializando datos básicos...</h2>";
    
    // 1. Insertar sedes si no existen
    echo "<h3>1. Verificando sedes...</h3>";
    $checkSedes = $db->query("SELECT COUNT(*) as total FROM sede")->fetch(PDO::FETCH_ASSOC);
    
    if ($checkSedes['total'] == 0) {
        echo "No hay sedes. Insertando sedes de prueba...<br>";
        $db->exec("
            INSERT INTO sede (sede_nombre) VALUES
            ('SENA – Centro Principal / Sede Cúcuta'),
            ('SENA CIES – Centro de la Industria'),
            ('SENA CEDRUM – Centro Rural y Minero')
        ");
        echo "✓ 3 sedes insertadas correctamente<br>";
    } else {
        echo "✓ Ya existen {$checkSedes['total']} sede(s)<br>";
    }
    
    // 2. Insertar títulos de programa si no existen
    echo "<h3>2. Verificando títulos de programa...</h3>";
    $checkTitulos = $db->query("SELECT COUNT(*) as total FROM titulo_programa")->fetch(PDO::FETCH_ASSOC);
    
    if ($checkTitulos['total'] == 0) {
        echo "No hay títulos. Insertando títulos de prueba...<br>";
        $db->exec("
            INSERT INTO titulo_programa (titpro_nombre) VALUES
            ('Tecnólogo en Análisis y Desarrollo de Software'),
            ('Técnico en Sistemas'),
            ('Especialización Tecnológica en Desarrollo de Aplicaciones Móviles')
        ");
        echo "✓ 3 títulos insertados correctamente<br>";
    } else {
        echo "✓ Ya existen {$checkTitulos['total']} título(s)<br>";
    }
    
    // 3. Insertar centros de formación si no existen
    echo "<h3>3. Verificando centros de formación...</h3>";
    $checkCentros = $db->query("SELECT COUNT(*) as total FROM centro_formacion")->fetch(PDO::FETCH_ASSOC);
    
    if ($checkCentros['total'] == 0) {
        echo "No hay centros. Insertando centros de prueba...<br>";
        $db->exec("
            INSERT INTO centro_formacion (cent_nombre) VALUES
            ('Centro de Gestión Industrial'),
            ('Centro de Servicios Empresariales')
        ");
        echo "✓ 2 centros insertados correctamente<br>";
    } else {
        echo "✓ Ya existen {$checkCentros['total']} centro(s)<br>";
    }
    
    // 4. Insertar coordinaciones si no existen
    echo "<h3>4. Verificando coordinaciones...</h3>";
    $checkCoord = $db->query("SELECT COUNT(*) as total FROM coordinacion")->fetch(PDO::FETCH_ASSOC);
    
    if ($checkCoord['total'] == 0) {
        echo "No hay coordinaciones. Insertando coordinaciones de prueba...<br>";
        $db->exec("
            INSERT INTO coordinacion (coord_nombre, centro_formacion_cent_id) VALUES
            ('Coordinación Académica TI', 1),
            ('Coordinación Administrativa', 2)
        ");
        echo "✓ 2 coordinaciones insertadas correctamente<br>";
    } else {
        echo "✓ Ya existen {$checkCoord['total']} coordinación(es)<br>";
    }
    
    echo "<h2 style='color: green;'>✓ Inicialización completada exitosamente</h2>";
    echo "<p><a href='index.php'>Ir al inicio</a></p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>✗ Error durante la inicialización</h2>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
