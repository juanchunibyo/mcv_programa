<?php
/**
 * Vista: Detalle de Programa (ver.php)
 */

$rol = $rol ?? 'coordinador';

// Obtener ID del programa desde la URL
$progId = $_GET['id'] ?? 1;

// Datos de prueba para diferentes programas
$programas = [
    1 => [
        'prog_codigo' => 1,
        'prog_denominacion' => 'Tecnología en Análisis y Desarrollo de Software',
        'prog_tipo' => 'Tecnología',
        'tibro_id' => 1,
        'prog_foto' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&q=80'
    ],
    2 => [
        'prog_codigo' => 2,
        'prog_denominacion' => 'Técnico en Sistemas',
        'prog_tipo' => 'Técnico',
        'tibro_id' => 2,
        'prog_foto' => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=800&q=80'
    ],
    3 => [
        'prog_codigo' => 3,
        'prog_denominacion' => 'Tecnología en Gestión de Redes de Datos',
        'prog_tipo' => 'Tecnología',
        'tibro_id' => 1,
        'prog_foto' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80'
    ]
];

$programa = $programas[$progId] ?? $programas[1];

$title = 'Detalle de Programa';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Programas', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

<style>
    .programa-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
    }

    .programa-image-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .programa-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .programa-info-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .programa-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .programa-id-badge {
        display: inline-block;
        padding: 6px 12px;
        background: linear-gradient(135deg, #39A900, #007832);
        color: white;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 24px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .programa-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Detalle de Programa</h1>
</div>

<div style="max-width: 800px;">
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <span class="programa-id-badge">Código: <?= htmlspecialchars($programa['prog_codigo']) ?></span>
        <h2 class="programa-title"><?= htmlspecialchars($programa['prog_denominacion']) ?></h2>

        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Tipo de Programa</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($programa['prog_tipo']) ?></div>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">ID Título</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($programa['tibro_id']) ?></div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </a>
            <?php if ($rol === 'coordinador'): ?>
                <a href="editar.php?id=<?= $programa['prog_codigo'] ?>" class="btn btn-primary">
                    <i data-lucide="pencil"></i>
                    Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
