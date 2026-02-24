<?php
/**
 * Vista: Detalle de Asignación (ver.php)
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';

session_start();

$rol = $rol ?? 'coordinador';
$asigId = intval($_GET['id'] ?? 0);

if ($asigId <= 0) {
    header('Location: index.php');
    exit;
}

// Obtener datos de la asignación
$asignaciones = AsignacionController::obtenerTodasAsignaciones();
$asignacion = null;

foreach ($asignaciones as $asig) {
    if ($asig['asig_id'] == $asigId) {
        $asignacion = $asig;
        break;
    }
}

if (!$asignacion) {
    $_SESSION['error'] = 'Asignación no encontrada';
    header('Location: index.php');
    exit;
}

$title = 'Detalle de Asignación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Asignaciones', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Asignación</h1>
        </div>

        <div style="max-width: 800px;">
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                <div style="display: inline-block; background: #39a935; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.5rem;">
                    ID: <?php echo htmlspecialchars($asignacion['asig_id']); ?>
                </div>
                
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0 0 2rem 0;">
                    Asignación - Ficha <?php echo htmlspecialchars($asignacion['fich_id'] ?? 'N/A'); ?>
                </h2>
                
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Instructor</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['inst_nombres'] . ' ' . $asignacion['inst_apellidos']); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Ambiente</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['amb_nombre'] ?? 'N/A'); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Competencia</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['comp_nombre_corto'] ?? 'N/A'); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Fecha Inicio</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;">
                            <?php echo htmlspecialchars(date('d/m/Y', strtotime($asignacion['asig_fecha_ini']))); ?>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Fecha Fin</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;">
                            <?php echo htmlspecialchars(date('d/m/Y', strtotime($asignacion['asig_fecha_fin']))); ?>
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
