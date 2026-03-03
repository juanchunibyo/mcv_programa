<?php
/**
 * Vista: Detalle de Centro de Formación (ver.php)
 */

require_once __DIR__ . '/../../controllers/CentroFormacionController.php';

session_start();

$rol = $_SESSION['usuario_rol'] ?? 'Invitado';

// Obtener ID de el centro de formación desde la URL
$centro_formacionId = intval($_GET['id'] ?? 0);

// Obtener datos reales de la base de datos
$centro = null;
if ($centro_formacionId > 0) {
    $centro = CentroFormacionController::obtenerCentroFormacion($centro_formacionId);
}

// Si no se encuentra el centro de formación, redirigir al listado
if (!$centro) {
    $_SESSION['error'] = 'Centro de Formación no encontrada';
    header('Location: index.php');
    exit;
}

$title = 'Detalle de Centro de Formación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Centros de Formación', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

<style>
    .centro_formacion-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
    }

    .centro_formacion-image-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .centro_formacion-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .centro_formacion-info-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .centro_formacion-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .centro_formacion-id-badge {
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
        .centro_formacion-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Detalle de Centro de Formación</h1>
</div>

<div class="centro_formacion-detail-container">
    <!-- Sección de Imagen -->
    <div class="centro_formacion-image-section">
        <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80" alt="<?= htmlspecialchars($centro['cent_nombre']) ?>" class="centro_formacion-image">
    </div>

    <!-- Sección de Información -->
    <div class="centro_formacion-info-section">
        <span class="centro_formacion-id-badge">ID: <?= htmlspecialchars($centro['cent_id']) ?></span>
        <h2 class="centro_formacion-title"><?= htmlspecialchars($centro['cent_nombre']) ?></h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <i data-lucide="building-2"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Nombre de el Centro de Formación</div>
                    <div class="info-value"><?= htmlspecialchars($centro['cent_nombre']) ?></div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </a>
            <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
                <a href="editar.php?id=<?= $centro['cent_id'] ?>" class="btn btn-primary">
                    <i data-lucide="pencil"></i>
                    Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
