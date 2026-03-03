<?php
$viewsDir = __DIR__ . '/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$count = 0;

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        // Exact replacements to avoid messing up logic
        $replacements = [
            '$rol = $rol ?? \'coordinador\';' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = $rol ?? "coordinador";' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = \'coordinador\';' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = "coordinador";' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = $rol ?? \'instructor\';' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = $rol ?? "instructor";' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = \'instructor\';' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
            '$rol = "instructor";' => '$rol = $_SESSION[\'usuario_rol\'] ?? \'Invitado\';',
        ];

        $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
        
        if ($newContent !== $content) {
            file_put_contents($path, $newContent);
            echo "Modificado: " . basename($path) . "\n";
            $count++;
        }
    }
}
echo "Total archivos modificados: $count\n";
