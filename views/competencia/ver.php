<?php
/**
 * Vista: Detalle de Competencia (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$competencia = $competencia ?? ['comp_id' => 1, 'comp_nombre_corto' => 'Promover salud', 'comp_horas' => 40, 'comp_nombre_unidad_competencia' => 'Promover la salud y seguridad en el trabajo'];
// --- Fin datos de prueba ---

$title = 'Detalle de Competencia';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Competencias', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Competencia</h1>
        </div>

        <div style="max-width: 800px;">
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                <div style="display: inline-block; background: #39a935; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.5rem;">
                    ID: <?php echo htmlspecialchars($competencia['comp_id']); ?>
                </div>
                
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0 0 2rem 0;">
                    <?php echo htmlspecialchars($competencia['comp_nombre_corto']); ?>
                </h2>
                
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Unidad de Competencia</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($competencia['comp_nombre_unidad_competencia']); ?></div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Horas</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($competencia['comp_horas']); ?> horas</div>
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
