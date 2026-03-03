<?php
/**
 * Vista: Detalle de Coordinación (ver.php)
 */

require_once __DIR__ . '/../../controllers/CoordinacionController.php';

session_start();

$rol = $_SESSION['usuario_rol'] ?? 'Invitado';

// Obtener ID de la coordinación desde la URL
$coordinacionId = intval($_GET['id'] ?? 0);

// Obtener datos reales de la base de datos
$coord = null;
if ($coordinacionId > 0) {
    $coord = CoordinacionController::obtenerCoordinacion($coordinacionId);
}

// Si no se encuentra la coordinación, redirigir al listado
if (!$coord) {
    $_SESSION['error'] = 'Coordinación no encontrada';
    header('Location: index.php');
    exit;
}

$title = 'Detalle de Coordinación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Coordinaciones', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

<style>
    .coordinacion-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
    }

    .coordinacion-image-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .coordinacion-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .coordinacion-info-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .coordinacion-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .coordinacion-id-badge {
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
        .coordinacion-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Detalle de Coordinación</h1>
</div>

<div class="coordinacion-detail-container">
    <!-- Sección de Imagen -->
    <div class="coordinacion-image-section">
        <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80" alt="<?= htmlspecialchars($coord['coord_nombre']) ?>" class="coordinacion-image">
    </div>

    <!-- Sección de Información -->
    <div class="coordinacion-info-section">
        <span class="coordinacion-id-badge">ID: <?= htmlspecialchars($coord['coord_id']) ?></span>
        <h2 class="coordinacion-title"><?= htmlspecialchars($coord['coord_nombre']) ?></h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <i data-lucide="building-2"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Nombre de la Coordinación</div>
                    <div class="info-value"><?= htmlspecialchars($coord['coord_nombre']) ?></div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </a>
            <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
                <a href="editar.php?id=<?= $coord['coord_id'] ?>" class="btn btn-primary">
                    <i data-lucide="pencil"></i>
                    Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
