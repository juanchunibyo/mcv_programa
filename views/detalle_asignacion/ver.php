<?php
/**
 * Vista: Ver Detalle de Asignación (ver.php)
 */

require_once __DIR__ . '/../../controllers/DetalleAsignacionController.php';

session_start();

$rol = $rol ?? 'coordinador';
$detalleId = intval($_GET['id'] ?? 0);

if ($detalleId <= 0) {
    header('Location: index.php');
    exit;
}

// Obtener datos del detalle
$detalle = DetalleAsignacionController::obtenerDetalle($detalleId);

if (!$detalle) {
    $_SESSION['error'] = 'Horario no encontrado';
    header('Location: index.php');
    exit;
}

$title = 'Detalle de Horario';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Detalles de Asignación', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Horario</h1>
        </div>

        <div style="max-width: 800px;">
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                <div style="display: inline-block; background: #39a935; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.5rem;">
                    ID: <?php echo htmlspecialchars($detalle['detasig_id']); ?>
                </div>
                
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0 0 2rem 0;">
                    Horario - Asignación #<?php echo htmlspecialchars($detalle['asignacion_asig_id']); ?>
                </h2>
                
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">ID Asignación</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($detalle['asignacion_asig_id']); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Ficha</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($detalle['ficha_fich_id'] ?? 'N/A'); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Ambiente</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($detalle['amb_nombre'] ?? 'N/A'); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Hora Inicio</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;">
                            <?php 
                            $horaIni = date('H:i', strtotime($detalle['detasig_hora_ini']));
                            echo htmlspecialchars($horaIni); 
                            ?>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Hora Fin</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;">
                            <?php 
                            $horaFin = date('H:i', strtotime($detalle['detasig_hora_fin']));
                            echo htmlspecialchars($horaFin); 
                            ?>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem;">
                    <a href="index.php" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="arrow-left"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
