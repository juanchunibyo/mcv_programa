<?php
/**
 * Front Controller (Enrutador Principal)
 * 
 * Este archivo actúa como el punto de entrada único para la aplicación web.
 * Todas las peticiones web deberían caer aquí, y este archivo determina 
 * a qué controlador llamar.
 */

require_once __DIR__ . '/controllers/DashboardController.php';

// Sistema básico de enrutamiento
// Por ahora, como es nuestro punto de refactorización inicial,
// cargamos el DashboardController por defecto.

$controller = new DashboardController();
$controller->index();

// NOTA: A futuro, aquí podemos atrapar parámetros GET/POST (como '?url=sede/index')
// y hacer un require dinámico del controlador correspondiente.
