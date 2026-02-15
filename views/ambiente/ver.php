<?php
/**
 * Vista: Detalle de Ambiente (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$ambiente = $ambiente ?? ['id_ambiente' => 1, 'amb_nombre' => 'Laboratorio de Software 1', 'sede_nombre' => 'Centro de Gestión Industrial'];
// --- Fin datos de prueba ---

$title = 'Detalle de Ambiente';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Ambientes', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Ambiente</h1>
        </div>

        <div class="detail-card" style="display: grid; grid-template-columns: 400px 1fr; gap: 2rem; align-items: start;">
            <div style="width: 400px; height: 400px; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=400&fit=crop" 
                     alt="Ambiente" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div style="padding: 2rem 0;">
                <div style="display: inline-block; background: #39a935; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.5rem;">
                    ID: <?php echo htmlspecialchars($ambiente['id_ambiente']); ?>
                </div>
                
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0 0 2rem 0;">
                    <?php echo htmlspecialchars($ambiente['amb_nombre']); ?>
                </h2>
                
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Sede</div>
                        <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?php echo htmlspecialchars($ambiente['sede_nombre']); ?></div>
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
