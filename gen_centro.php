<?php
$sourceDir = __DIR__ . '/views/sede';
$destDir = __DIR__ . '/views/centro_formacion';

if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}

$files = ['index.php', 'crear.php', 'editar.php', 'ver.php', 'procesar.php'];

foreach ($files as $file) {
    if (file_exists("$sourceDir/$file")) {
        $content = file_get_contents("$sourceDir/$file");
        
        // General replacements
        $content = str_replace('SedeController', 'CentroFormacionController', $content);
        $content = str_replace('sede_id', 'cent_id', $content);
        $content = str_replace('sede_nombre', 'cent_nombre', $content);
        $content = str_replace('sede', 'centro_formacion', $content);
        $content = str_replace('Sede', 'Centro de Formación', $content);
        $content = str_replace('sedes', 'centros', $content);
        $content = str_replace('Sedes', 'Centros de Formación', $content);
        $content = str_replace('centro_formacions', 'centros_formacion', $content); // in case of plural mess up
        $content = str_replace('Centro de Formacións', 'Centros de Formación', $content);
        
        // Controller function replacements
        $content = str_replace('obtenerTodasCentros de Formación', 'obtenerTodosCentros', $content);
        $content = str_replace('obtenerCentro de Formación', 'obtenerCentroFormacion', $content);
        $content = str_replace('crearCentro de Formación', 'crearCentroFormacion', $content);
        $content = str_replace('actualizarCentro de Formación', 'actualizarCentroFormacion', $content);
        $content = str_replace('eliminarCentro de Formación', 'eliminarCentroFormacion', $content);
        $content = str_replace('CentroFormacionController::obtenerTodasCentros', 'CentroFormacionController::obtenerTodosCentros', $content);
        
        // Remove lines that might have 'centro_formacion_id_cent' from the cloned code
        $content = preg_replace('/<div class="form-group">.*?for="centro_formacion_id_cent".*?<\/div>/s', '', $content);
        
        // Replace variable names
        $content = preg_replace('/\$centro_formacion(?![a-zA-Z_])/', '$centro', $content);
        $content = preg_replace('/\$centros(?![a-zA-Z_])/', '$centros', $content);

        file_put_contents("$destDir/$file", $content);
    }
}
echo "Vistas creadas exitosamente.";
