<?php
/**
 * Vista: Detalle de Instructor (ver.php)
 */

$rol = $rol ?? 'coordinador';

// Obtener ID del instructor desde la URL
$instId = $_GET['id'] ?? 1;

// Datos de prueba para diferentes instructores
$instructores = [
    1 => [
        'inst_id' => 1,
        'inst_nombres' => 'Juan Carlos',
        'inst_apellidos' => 'Pérez García',
        'inst_correo' => 'jcperez@sena.edu.co',
        'inst_telefono' => '3001234567',
        'inst_foto' => 'https://ui-avatars.com/api/?name=Juan+Carlos+Perez&background=39A900&color=fff&size=400'
    ],
    2 => [
        'inst_id' => 2,
        'inst_nombres' => 'María Fernanda',
        'inst_apellidos' => 'García López',
        'inst_correo' => 'mfgarcia@sena.edu.co',
        'inst_telefono' => '3109876543',
        'inst_foto' => 'https://ui-avatars.com/api/?name=Maria+Fernanda+Garcia&background=007832&color=fff&size=400'
    ],
    3 => [
        'inst_id' => 3,
        'inst_nombres' => 'Carlos Alberto',
        'inst_apellidos' => 'López Martínez',
        'inst_correo' => 'calopez@sena.edu.co',
        'inst_telefono' => '3205551234',
        'inst_foto' => 'https://ui-avatars.com/api/?name=Carlos+Alberto+Lopez&background=39A900&color=fff&size=400'
    ]
];

$instructor = $instructores[$instId] ?? $instructores[1];

$title = 'Detalle de Instructor';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Instructores', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

<style>
    .instructor-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
    }

    .instructor-image-section {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .instructor-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .instructor-info-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .instructor-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .instructor-id-badge {
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
        .instructor-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Detalle de Instructor</h1>
</div>

<div class="instructor-detail-container">
    <!-- Sección de Imagen -->
    <div class="instructor-image-section">
        <img src="<?= htmlspecialchars($instructor['inst_foto']) ?>" alt="<?= htmlspecialchars($instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos']) ?>" class="instructor-image">
    </div>

    <!-- Sección de Información -->
    <div class="instructor-info-section">
        <span class="instructor-id-badge">ID: <?= htmlspecialchars($instructor['inst_id']) ?></span>
        <h2 class="instructor-title"><?= htmlspecialchars($instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos']) ?></h2>

        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Correo Electrónico</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($instructor['inst_correo']) ?></div>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Teléfono</div>
                <div style="font-size: 1rem; color: #1a1a1a; font-weight: 500;"><?= htmlspecialchars($instructor['inst_telefono']) ?></div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </a>
            <?php if ($rol === 'coordinador'): ?>
                <a href="editar.php?id=<?= $instructor['inst_id'] ?>" class="btn btn-primary">
                    <i data-lucide="pencil"></i>
                    Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
