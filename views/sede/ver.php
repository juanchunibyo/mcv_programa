<?php
/**
 * Vista: Detalle de Sede (ver.php)
 */

$rol = $rol ?? 'coordinador';

// Obtener ID de la sede desde la URL
$sedeId = $_GET['id'] ?? 1;

// Datos de prueba para diferentes sedes de Cúcuta
$sedes = [
    1 => [
        'sede_id' => 1,
        'sede_nombre' => 'SENA – Centro Principal / Sede Cúcuta',
        'sede_direccion' => 'Av. 5, Barrio Pescadero, Cúcuta, Norte de Santander',
        'sede_telefono' => '(607) 5831150',
        'sede_capacidad' => '1000 estudiantes',
        'sede_descripcion' => 'Sede principal donde se ofrecen múltiples programas de formación y atención al público',
        'sede_foto' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80'
    ],
    2 => [
        'sede_id' => 2,
        'sede_nombre' => 'SENA CIES – Centro de la Industria, la Empresa y los Servicios',
        'sede_direccion' => 'Cl. 2 Nte. #Avenida 4 y 5, Pescadero, Cúcuta',
        'sede_telefono' => '(607) 5831151',
        'sede_capacidad' => '600 estudiantes',
        'sede_descripcion' => 'Centro especializado en formación enfocada en industria, empresa y servicios',
        'sede_foto' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80'
    ],
    3 => [
        'sede_id' => 3,
        'sede_nombre' => 'SENA CEDRUM – Centro de Formación para el Desarrollo Rural y Minero',
        'sede_direccion' => 'Cl. 2 Nte. #4a-21, Pescadero, Cúcuta',
        'sede_telefono' => '(607) 5831152',
        'sede_capacidad' => '400 estudiantes',
        'sede_descripcion' => 'Centro cuyo enfoque es capacitación en áreas rurales, mineras y afines',
        'sede_foto' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&q=80'
    ],
    4 => [
        'sede_id' => 4,
        'sede_nombre' => 'SENA Tecno Parque, Tecno Academia',
        'sede_direccion' => 'Canal de Bogotá #1N-30, Pescadero, Cúcuta',
        'sede_telefono' => '(607) 5831153',
        'sede_capacidad' => '350 estudiantes',
        'sede_descripcion' => 'Espacio dedicado al trabajo en tecnologías y emprendimiento',
        'sede_foto' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800&q=80'
    ],
    5 => [
        'sede_id' => 5,
        'sede_nombre' => 'SENA - Calzado y Marroquinería',
        'sede_direccion' => 'Urbanización Prados del Norte, Cúcuta',
        'sede_telefono' => '(607) 5831154',
        'sede_capacidad' => '300 estudiantes',
        'sede_descripcion' => 'Sede enfocada en formación técnica en calzado, cuero y marroquinería',
        'sede_foto' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&q=80'
    ]
];

// Obtener la sede específica o usar la primera por defecto
$sede = $sedes[$sedeId] ?? $sedes[1];

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
        <img src="<?= htmlspecialchars($sede['sede_foto']) ?>" alt="<?= htmlspecialchars($sede['sede_nombre']) ?>" class="sede-image">
    </div>

    <!-- Sección de Información -->
    <div class="sede-info-section">
        <span class="sede-id-badge">ID: <?= htmlspecialchars($sede['sede_id']) ?></span>
        <h2 class="sede-title"><?= htmlspecialchars($sede['sede_nombre']) ?></h2>

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
