<?php
/**
 * Vista: Detalle de Sede (ver.php)
 */

require_once __DIR__ . '/../../controllers/SedeController.php';

session_start();

$rol = $rol ?? 'coordinador';

// Obtener ID de la sede desde la URL
$sedeId = intval($_GET['id'] ?? 0);

// Obtener datos reales de la base de datos
$sede = null;
if ($sedeId > 0) {
    $sede = SedeController::obtenerSede($sedeId);
}

// Si no se encuentra la sede, redirigir al listado
if (!$sede) {
    $_SESSION['error'] = 'Sede no encontrada';
    header('Location: index.php');
    exit;
}

$title = 'Detalle de Sede';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Sedes', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

<style>
    .sede-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
    }

    .sede-image-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .sede-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .sede-info-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .sede-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .sede-id-badge {
        display: inline-block;
        padding: 6px 12px;
        background: linear-gradient(135deg, #39A900, #007832);
        color: white;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 24px;
    }

    .info-grid {
        display: grid;
        gap: 20px;
        margin-top: 24px;
    }

    .info-item {
        display: flex;
        align-items: start;
        gap: 16px;
        padding: 16px;
        background: #f9fafb;
        border-radius: 12px;
        border-left: 4px solid #39A900;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #39A900, #007832);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .sede-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Detalle de Sede</h1>
</div>

<div class="sede-detail-container">
    <!-- Sección de Imagen -->
    <div class="sede-image-section">
        <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80" alt="<?= htmlspecialchars($sede['sede_nombre']) ?>" class="sede-image">
    </div>

    <!-- Sección de Información -->
    <div class="sede-info-section">
        <span class="sede-id-badge">ID: <?= htmlspecialchars($sede['sede_id']) ?></span>
        <h2 class="sede-title"><?= htmlspecialchars($sede['sede_nombre']) ?></h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <i data-lucide="building-2"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Nombre de la Sede</div>
                    <div class="info-value"><?= htmlspecialchars($sede['sede_nombre']) ?></div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </a>
            <?php if ($rol === 'coordinador'): ?>
                <a href="editar.php?id=<?= $sede['sede_id'] ?>" class="btn btn-primary">
                    <i data-lucide="pencil"></i>
                    Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
