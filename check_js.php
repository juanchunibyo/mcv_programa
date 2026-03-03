<?php
require 'Conexion.php';
require 'controllers/AsignacionController.php';

$asignaciones = AsignacionController::obtenerTodasAsignaciones();
$eventos = [];
foreach ($asignaciones as $asig) {
    $colors = ['#39A900', '#007832', '#4CAF50', '#8BC34A', '#2E7D32'];
    $colorIndex = (isset($asig['fich_id']) ? intval($asig['fich_id']) : 0) % count($colors);
    
    $baseEvent = [
        'id' => $asig['asig_id'],
        'title' => "Ficha: " . ($asig['fich_id'] ?? 'N/A') . " | " . ($asig['amb_nombre'] ?? 'N/A'),
        'color' => $colors[$colorIndex],
        'extendedProps' => [
            'instructor' => $asig['inst_nombres'] ?? 'N/A',
            'competencia' => $asig['comp_nombre_corto'] ?? 'N/A',
            'ambiente' => $asig['amb_nombre'] ?? 'N/A',
            'ficha' => $asig['fich_id'] ?? 'N/A'
        ]
    ];

    $fechaIni = date('Y-m-d', strtotime($asig['asig_fecha_ini']));
    $fechaFin = date('Y-m-d', strtotime($asig['asig_fecha_fin']));

    // Evento de INICIO
    $eventoInicio = $baseEvent;
    
    // Evento de FIN (Solo si la fecha de fin es diferente a la de inicio)
    $eventoFin = null;
    if ($fechaIni !== $fechaFin) {
        $eventoFin = $baseEvent;
        $eventoFin['color'] = '#ef4444'; // Rojo para la fecha fin
    }

    if (!empty($asig['detasig_hora_ini']) && !empty($asig['detasig_hora_fin'])) {
        // Tiene horas específicas
        $horaIni = date('H:i:s', strtotime($asig['detasig_hora_ini']));
        $horaFin = date('H:i:s', strtotime($asig['detasig_hora_fin']));
        
        $eventoInicio['title'] = "Inicio: " . $baseEvent['title'];
        $eventoInicio['start'] = $fechaIni . 'T' . $horaIni;
        $eventoInicio['end'] = $fechaIni . 'T' . $horaFin;
        $eventos[] = $eventoInicio;
        
        if ($eventoFin) {
            $eventoFin['title'] = "Fin: " . $baseEvent['title'];
            $eventoFin['start'] = $fechaFin . 'T' . $horaIni;
            $eventoFin['end'] = $fechaFin . 'T' . $horaFin;
            $eventos[] = $eventoFin;
        }
    } else {
        // Asignación de "Día Completo" o flotante (sin hora definida)
        $eventoInicio['title'] = "Inicio: " . $baseEvent['title'];
        $eventoInicio['start'] = $fechaIni;
        $eventoInicio['allDay'] = true;
        $eventos[] = $eventoInicio;
        
        if ($eventoFin) {
            $eventoFin['title'] = "Fin: " . $baseEvent['title'];
            $eventoFin['start'] = $fechaFin;
            $eventoFin['allDay'] = true;
            $eventos[] = $eventoFin;
        }
    }
}
header('Content-Type: application/json');
echo json_encode($eventos);
