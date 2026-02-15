<?php
/**
 * Vista: Detalle de Título (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$titulo = $titulo ?? ['tibro_id' => 1, 'tibro_nombre' => 'Tecnólogo'];
// --- Fin datos de prueba ---

$title = 'Detalle de Título';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Títulos', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Título</h1>
        </div>

        <div class="detail-card" style="display: grid; grid-template-columns: 400px 1fr; gap: 2rem; align-items: start;">
            <div style="width: 400px; height: 400px; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=400&fit=crop" 
                     alt="Título" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div style="padding: 2rem 0;">
                <div style="display: inline-block; background: #39a935; color: white; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.5rem;">
                    ID: <?php echo htmlspecialchars($titulo['tibro_id']); ?>
                </div>
                
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0 0 2rem 0;">
                    <?php echo htmlspecialchars($titulo['tibro_nombre']); ?>
                </h2>
                
                <div style="margin-top: 2rem;">
                    <a href="index.php" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="arrow-left"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
