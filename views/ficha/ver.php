<?php
/**
 * Vista: Detalle de Ficha (ver.php)
 */

$rol = $rol ?? 'coordinador';

// Obtener ID de la ficha desde la URL
$fichaId = $_GET['id'] ?? '2758392';

// Datos de prueba para diferentes fichas
$fichas = [
    '2758392' => [
        'fich_id' => '2758392',
        'fich_nombre' => 'Tecnología en Análisis y Desarrollo de Software',
        'fich_jornada' => 'Diurna',
        'prog_id' => 1,
        'inst_id' => 1,
        'fich_foto' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80'
    ],
    '2758393' => [
        'fich_id' => '2758393',
        'fich_nombre' => 'Técnico en Sistemas',
        'fich_jornada' => 'Nocturna',
        'prog_id' => 2,
        'inst_id' => 2,
        'fich_foto' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80'
    ],
    '2758394' => [
        'fich_id' => '2758394',
        'fich_nombre' => 'Tecnología en Gestión de Redes',
        'fich_jornada' => 'Mixta',
        'prog_id' => 3,
        'inst_id' => 3,
        'fich_foto' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&q=80'
    ]
];

$ficha = $fichas[$fichaId] ?? $fichas['2758392'];

$title = 'Detalle de Ficha';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Fichas', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

<style>
    .ficha-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
    }

    .ficha-image-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .ficha-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .ficha-info-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .ficha-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .ficha-id-badge {
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
        .ficha-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Detalle de Ficha</h1>
</div>

<div style="max-width: 800px;">
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <span class="ficha-id-badge">Ficha: <?= htmlspecialchars($ficha['fich_id']) ?></span>
        <h2 class="ficha-title"><?= htmlspecialchars($ficha['fich_nombre']) ?></h2>

        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Jornada</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($ficha['fich_jornada']) ?></div>
            </div>
            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">ID Programa</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($ficha['prog_id']) ?></div>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">ID Instructor Líder</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($ficha['inst_id']) ?></div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </a>
            <?php if ($rol === 'coordinador'): ?>
                <a href="editar.php?id=<?= $ficha['fich_id'] ?>" class="btn btn-primary">
                    <i data-lucide="pencil"></i>
                    Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
