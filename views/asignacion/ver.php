<?php
/**
 * Vista: Detalle de Asignación (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$asignacion = $asignacion ?? [
    'asig_id' => 1,
    'fich_id' => '228106-1',
    'inst_nombre' => 'Juan Pérez',
    'amb_nombre' => 'Laboratorio 1',
    'comp_nombre_corto' => 'Promover salud',
    'asig_fecha_ini' => '2023-01-20',
    'asig_fecha_fin' => '2023-06-20'
];
// --- Fin datos de prueba ---

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

        <div class="detail-card" style="display: grid; grid-template-columns: 400px 1fr; gap: 2rem; align-items: start;">
            <div style="width: 400px; height: 400px; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=400&fit=crop" 
                     alt="Asignación" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div style="padding: 2rem 0;">
                <div style="display: inline-block; background: #39a935; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.5rem;">
                    ID: <?php echo htmlspecialchars($asignacion['asig_id']); ?>
                </div>
                
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0 0 2rem 0;">
                    Asignación - Ficha <?php echo htmlspecialchars($asignacion['fich_id']); ?>
                </h2>
                
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Instructor</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['inst_nombre']); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Ambiente</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['amb_nombre']); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Competencia</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['comp_nombre_corto']); ?></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Fecha Inicio</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['asig_fecha_ini']); ?></div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Fecha Fin</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($asignacion['asig_fecha_fin']); ?></div>
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
