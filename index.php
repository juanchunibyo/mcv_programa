<?php
/**
 * Vista: Dashboard Principal
 */

$rol = $rol ?? 'coordinador';
$title = 'Panel Principal';
$breadcrumb = [
    ['label' => 'Inicio'],
];

include __DIR__ . '/views/layout/header.php';
?>

<style>
    .dashboard-welcome {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(57, 169, 0, 0.3);
        border-radius: 20px;
        padding: 48px 40px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    }

    .dashboard-welcome h2 {
        font-size: 36px;
        font-weight: 900;
        margin-bottom: 12px;
    }

    .dashboard-welcome p {
        font-size: 18px;
        opacity: 0.8;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(57, 169, 0, 0.2);
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transition: all 0.4s;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(57, 169, 0, 0.3);
        border-color: rgba(57, 169, 0, 0.4);
    }

    .stat-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-bottom: 20px;
    }

    .stat-card-icon.green {
        background: linear-gradient(135deg, #39A900 0%, #007832 100%);
    }

    .stat-card-icon.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .stat-card-icon.orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-card-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .stat-card-value {
        font-size: 40px;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .stat-card-label {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 600;
    }

    .section-title {
        font-size: 24px;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 24px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .action-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(57, 169, 0, 0.2);
        border-radius: 16px;
        padding: 28px 24px;
        text-align: center;
        transition: all 0.4s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .action-card:hover {
        border-color: var(--green-primary);
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(57, 169, 0, 0.3);
    }

    .action-card-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: linear-gradient(135deg, #39A900 0%, #007832 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 8px 24px rgba(57, 169, 0, 0.4);
        transition: all 0.4s;
    }

    .action-card:hover .action-card-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .action-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #ffffff;
    }
</style>

<div class="dashboard-welcome">
    <h2>¡Bienvenido al Sistema Académico SENA!</h2>
    <p>Gestiona programas, instructores, fichas y asignaciones de manera eficiente</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon green">
            <i data-lucide="users" style="width: 24px; height: 24px;"></i>
        </div>
        <div class="stat-card-value">24</div>
        <div class="stat-card-label">Instructores Activos</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon blue">
            <i data-lucide="book-open" style="width: 24px; height: 24px;"></i>
        </div>
        <div class="stat-card-value">12</div>
        <div class="stat-card-label">Fichas en Curso</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon orange">
            <i data-lucide="graduation-cap" style="width: 24px; height: 24px;"></i>
        </div>
        <div class="stat-card-value">8</div>
        <div class="stat-card-label">Programas Activos</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon purple">
            <i data-lucide="clipboard-list" style="width: 24px; height: 24px;"></i>
        </div>
        <div class="stat-card-value">156</div>
        <div class="stat-card-label">Asignaciones</div>
    </div>
</div>

<div class="quick-actions">
    <h3 class="section-title">Accesos Rápidos</h3>
    <div class="actions-grid">
        <a href="/mvccc/mvc_programa/views/instructor/index.php" class="action-card">
            <div class="action-card-icon">
                <i data-lucide="users" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="action-card-title">Instructores</div>
        </a>

        <a href="/mvccc/mvc_programa/views/ficha/index.php" class="action-card">
            <div class="action-card-icon">
                <i data-lucide="book-open" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="action-card-title">Fichas</div>
        </a>

        <a href="/mvccc/mvc_programa/views/programa/index.php" class="action-card">
            <div class="action-card-icon">
                <i data-lucide="graduation-cap" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="action-card-title">Programas</div>
        </a>

        <a href="/mvccc/mvc_programa/views/asignacion/index.php" class="action-card">
            <div class="action-card-icon">
                <i data-lucide="clipboard-list" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="action-card-title">Asignaciones</div>
        </a>

        <a href="/mvccc/mvc_programa/views/ambiente/index.php" class="action-card">
            <div class="action-card-icon">
                <i data-lucide="monitor" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="action-card-title">Ambientes</div>
        </a>

        <a href="/mvccc/mvc_programa/views/sede/index.php" class="action-card">
            <div class="action-card-icon">
                <i data-lucide="building-2" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="action-card-title">Sedes</div>
        </a>
    </div>
</div>

<?php include __DIR__ . '/views/layout/footer.php'; ?>
