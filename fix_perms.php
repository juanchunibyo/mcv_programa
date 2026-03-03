<?php
$viewsDir = __DIR__ . '/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$count = 0;

// Determinar qué módulos son de qué rol según el sidebar:
// Centro + Admin: sede, ambiente, programa, instructor, competencia, centro_formacion, titulo_programa
// Coord + Admin: ficha, competencia_programa
// Global: asignacion

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        // Let's replace `$rol === 'coordinador'` with a broader check depending on the folder
        $folder = basename(dirname($path));
        
        $centroModules = ['sede', 'ambiente', 'programa', 'instructor', 'competencia', 'centro_formacion', 'titulo_programa'];
        $coordModules = ['ficha', 'competencia_programa'];
        $globalModules = ['asignacion'];
        
        $newContent = $content;
        
        if (in_array($folder, $centroModules)) {
            $newContent = str_replace(
                ['$rol === \'coordinador\'', '$rol === "coordinador"'],
                'in_array($rol, [\'coordinador\', \'admin\', \'centro de formacion\'])',
                $newContent
            );
        } elseif (in_array($folder, $coordModules)) {
            $newContent = str_replace(
                ['$rol === \'coordinador\'', '$rol === "coordinador"'],
                'in_array($rol, [\'coordinador\', \'admin\'])',
                $newContent
            );
        } elseif (in_array($folder, $globalModules)) {
            $newContent = str_replace(
                ['$rol === \'coordinador\'', '$rol === "coordinador"'],
                'in_array($rol, [\'coordinador\', \'admin\', \'centro de formacion\'])',
                $newContent
            );
        }

        if ($newContent !== $content) {
            file_put_contents($path, $newContent);
            echo "Modificado permisos: " . $folder . '/' . basename($path) . "\n";
            $count++;
        }
    }
}
echo "Total archivos comprobados/modificados: $count\n";
