<?php
$d = __DIR__ . '/views/centro_formacion';
foreach(glob($d . '/*.php') as $f) {
    $c = file_get_contents($f);
    $c = str_replace('la centro_formacion', 'el centro de formación', $c);
    $c = str_replace('la Centro de Formación', 'el Centro de Formación', $c);
    $c = str_replace('centros_formacion', 'centros de formación', $c);
    $c = str_replace('formCrearCentro de Formación', 'formCrearCentroFormacion', $c);
    file_put_contents($f, $c);
}
echo "Ok";
