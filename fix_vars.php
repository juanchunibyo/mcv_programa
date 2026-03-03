<?php
$d = __DIR__ . '/views/centro_formacion';
foreach(glob($d . '/*.php') as $f) {
    if (!is_file($f)) continue;
    $c = file_get_contents($f);
    $c = str_replace('$centros de formación', '$centros_formacion', $c);
    $c = str_replace('$centro de formaciónId', '$centro_formacionId', $c);
    $c = str_replace('el Centro de FormaciónId', '$centro_formacionId', $c);
    
    file_put_contents($f, $c);
}
echo 'Fixed variables in centro_formacion';
