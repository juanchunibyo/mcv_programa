<?php
/**
 * Vista: Dashboard Principal
 */

// Leer de la sesión segura (ya no está 'hardcoded')
$rol = $_SESSION['usuario_rol'] ?? 'Invitado';
$nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';

$title = 'Panel Principal - ' . ucfirst($rol);
$breadcrumb = [
    ['label' => 'Inicio'],
];

include __DIR__ . '/../layout/header.php';
?>

<!-- Fuentes Premium -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Diseño Premium Dashboard */
    .main-content {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
        padding-bottom: 50px;
    }

    /* Banner de Bienvenida Moderno */
    .dashboard-welcome {
        background: linear-gradient(135deg, #047857 0%, #10b981 100%);
        border-radius: 24px;
        padding: 48px 50px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2);
        position: relative;
        overflow: hidden;
    }

    /* Decoración de fondo del banner */
    .dashboard-welcome::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .dashboard-welcome h2 {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
        position: relative;
        z-index: 2;
    }

    .dashboard-welcome p {
        font-size: 18px;
        opacity: 0.9;
        font-weight: 400;
        position: relative;
        z-index: 2;
        max-width: 600px;
        line-height: 1.6;
    }

    .dashboard-welcome strong {
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Grid de Estadísticas Premium */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
    }

    .stat-card {
        background: white;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--card-color);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: transparent;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .stat-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 8px 16px var(--icon-shadow);
    }

    /* Colores Personalizados para las tarjetas */
    .card-green { --card-color: #10b981; --icon-shadow: rgba(16, 185, 129, 0.3); }
    .card-green .stat-card-icon { background: linear-gradient(135deg, #34d399 0%, #059669 100%); }

    .card-blue { --card-color: #3b82f6; --icon-shadow: rgba(59, 130, 246, 0.3); }
    .card-blue .stat-card-icon { background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%); }

    .card-orange { --card-color: #f59e0b; --icon-shadow: rgba(245, 158, 11, 0.3); }
    .card-orange .stat-card-icon { background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); }

    .card-purple { --card-color: #8b5cf6; --icon-shadow: rgba(139, 92, 246, 0.3); }
    .card-purple .stat-card-icon { background: linear-gradient(135deg, #a78bfa 0%, #6d28d9 100%); }

    .stat-card-value {
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .stat-card-label {
        font-size: 15px;
        color: #64748b;
        font-weight: 500;
    }

    /* Sección de Accesos Rápidos */
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 24px;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .action-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .action-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05);
    }

    .action-card-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: #f1f5f9;
        color: #0f5a2d;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-card-icon-wrapper {
        background: #0f5a2d;
        color: white;
        transform: scale(1.05);
    }

    .action-card-title {
        font-size: 15px;
        font-weight: 600;
        color: #334155;
    }

    .action-card:hover .action-card-title {
        color: #0f5a2d;
    }


    .calendar-container {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    }

    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .calendar-nav {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .calendar-nav button {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        background: white;
        color: #2d3748;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .calendar-nav button:hover {
        background: rgba(57, 169, 0, 0.1);
        border-color: var(--green-primary);
        color: var(--green-secondary);
        box-shadow: 0 4px 8px rgba(57, 169, 0, 0.2);
    }

    .calendar-month {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .view-buttons {
        display: flex;
        gap: 8px;
        background: rgba(0, 0, 0, 0.05);
        padding: 4px;
        border-radius: 8px;
    }

    .view-btn {
        padding: 6px 12px;
        border: none;
        background: transparent;
        color: #4a5568;
        cursor: pointer;
        border-radius: 6px;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.2s;
    }

    .view-btn.active {
        background: white;
        color: var(--green-primary);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .calendar-filters {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        background: white;
        color: #2d3748;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .filter-select:hover {
        border-color: var(--green-primary);
        box-shadow: 0 4px 8px rgba(57, 169, 0, 0.15);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--green-primary);
        box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
    }

    /* Vista Semanal */
    .week-view {
        display: grid;
        grid-template-columns: 80px repeat(7, 1fr);
        gap: 1px;
        background: rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    /* Vista Diaria */
    .day-view {
        display: grid;
        grid-template-columns: 80px 1fr;
        gap: 1px;
        background: rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        max-height: 600px;
        overflow-y: auto;
    }

    .time-slot,
    .day-header,
    .event-cell {
        background: white;
        padding: 12px;
    }

    .time-slot {
        font-size: 12px;
        color: #666;
        text-align: right;
        padding-right: 16px;
        font-weight: 500;
    }

    .day-header {
        text-align: center;
        font-weight: 600;
        color: #1a1a1a;
        padding: 16px 12px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    }

    .day-header.today {
        background: rgba(57, 169, 0, 0.1);
        color: var(--green-primary);
    }

    .day-date {
        font-size: 11px;
        color: #666;
        font-weight: 400;
        margin-top: 4px;
    }

    .event-cell {
        min-height: 60px;
        position: relative;
        cursor: pointer;
        transition: background 0.2s;
    }

    .event-cell:hover {
        background: rgba(57, 169, 0, 0.05);
    }

    .event-block {
        background: #3b82f6;
        color: white;
        padding: 8px;
        border-radius: 4px;
        font-size: 12px;
        margin: 2px 0;
        cursor: pointer;
        transition: all 0.2s;
    }

    .event-block:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .event-block.ficha {
        background: #3b82f6;
    }

    .event-block.ambiente {
        background: #f59e0b;
    }

    .event-block.instructor {
        background: #8b5cf6;
    }

    .event-time {
        font-size: 10px;
        opacity: 0.9;
        font-weight: 600;
    }

    .event-title {
        font-weight: 500;
        margin-top: 2px;
    }

    .legend {
        display: flex;
        gap: 24px;
        margin-top: 20px;
        padding: 16px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 8px;
        flex-wrap: wrap;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
        margin-top: 20px;
    }

    #calendarDays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: rgba(0, 0, 0, 0.08);
        margin-top: 1px;
    }

    .calendar-day-header {
        background: var(--green-secondary);
        color: white;
        text-align: center;
        padding: 16px 12px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .calendar-day {
        background: white;
        min-height: 120px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .calendar-day:hover {
        background: rgba(57, 169, 0, 0.05);
        transform: scale(1.02);
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .calendar-day.other-month {
        background: rgba(0, 0, 0, 0.02);
        opacity: 0.5;
    }

    .calendar-day.today {
        background: rgba(57, 169, 0, 0.1);
        border: 2px solid var(--green-primary);
    }

    .day-number {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .calendar-day.today .day-number {
        color: var(--green-primary);
    }

    .day-events {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .event-item {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        color: white;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        transition: all 0.2s;
    }

    .event-item:hover {
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .event-item.event-ficha {
        background: #3b82f6;
    }

    .event-item.event-ambiente {
        background: #f59e0b;
    }

    .event-item.event-instructor {
        background: #8b5cf6;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #4a5568;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    .legend-color.ficha {
        background: #3b82f6;
    }

    .legend-color.ambiente {
        background: #f59e0b;
    }

    .legend-color.instructor {
        background: #8b5cf6;
    }

    /* Modal */
    .event-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .event-modal.active {
        display: flex;
    }

    .event-modal-content {
        background: white;
        border-radius: 16px;
        padding: 32px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .event-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .event-modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .event-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(0, 0, 0, 0.05);
        color: #4a5568;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-modal-close:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    .event-form-group {
        margin-bottom: 20px;
    }

    .time-inputs-row {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 20px;
    }

    .time-input-group {
        flex: 1;
        margin-bottom: 0;
    }

    .time-separator {
        display: flex;
        align-items: center;
        padding-bottom: 10px;
    }

    .time-input {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 15px;
        letter-spacing: 0.5px;
    }

    .event-form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .event-form-input,
    .event-form-select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        background: white;
        color: #1a1a1a;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .event-form-input:focus,
    .event-form-select:focus {
        outline: none;
        border-color: var(--green-primary);
        box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
    }

    .event-form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .event-form-actions button {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-save {
        background: var(--green-primary);
        color: white;
        box-shadow: 0 2px 8px rgba(57, 169, 0, 0.3);
    }

    .btn-save:hover {
        background: var(--green-secondary);
        box-shadow: 0 4px 12px rgba(0, 120, 50, 0.4);
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: white;
        color: #4a5568;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .btn-cancel:hover {
        background: rgba(0, 0, 0, 0.05);
        border-color: rgba(0, 0, 0, 0.25);
    }

    @media (max-width: 768px) {
        .week-view {
            overflow-x: auto;
        }
    }

</style>

<div class="dashboard-welcome">
    <h2>¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h2>
    <p>Has iniciado sesión en el sistema como <strong><?php echo ucfirst(htmlspecialchars($rol)); ?></strong></p>
</div>

<div class="stats-grid">
    <?php if ($rol === 'centro de formacion' || $rol === 'admin'): ?>
        <div class="stat-card card-green">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="building-2" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $countSedes ?? 0; ?></div>
            <div class="stat-card-label">Sedes Registradas</div>
        </div>

        <div class="stat-card card-blue">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="monitor" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $countAmbientes ?? 0; ?></div>
            <div class="stat-card-label">Ambientes Disponibles</div>
        </div>

        <div class="stat-card card-orange">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="users" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $countInstructores ?? 0; ?></div>
            <div class="stat-card-label">Instructores Activos</div>
        </div>

        <div class="stat-card card-purple">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="graduation-cap" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $countProgramas ?? 0; ?></div>
            <div class="stat-card-label">Programas Formativos</div>
        </div>
    <?php endif; ?>

    <?php if ($rol === 'coordinador' || $rol === 'admin'): ?>
        <!-- STATS DE COORDINADOR -->
        <div class="stat-card card-green">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="users" style="width: 26px; height: 26px;"></i>
                </div>
                <i data-lucide="trending-up" style="color: #10b981; width: 20px;"></i>
            </div>
            <div class="stat-card-value"><?php echo $countInstructores ?? 0; ?></div>
            <div class="stat-card-label">Instructores Activos</div>
        </div>

        <div class="stat-card card-blue">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="book-open" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $countFichas ?? 0; ?></div>
            <div class="stat-card-label">Fichas en Curso</div>
        </div>

        <div class="stat-card card-orange">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="graduation-cap" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $countProgramas ?? 0; ?></div>
            <div class="stat-card-label">Programas Activos</div>
        </div>

        <div class="stat-card card-purple">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="clipboard-list" style="width: 26px; height: 26px;"></i>
                </div>
                <i data-lucide="activity" style="color: #8b5cf6; width: 20px;"></i>
            </div>
            <div class="stat-card-value"><?php echo $countAsignaciones ?? 0; ?></div>
            <div class="stat-card-label">Asignaciones Vigentes</div>
        </div>
    <?php endif; ?>

    <?php if ($rol === 'instructor' || $rol === 'admin'): ?>
        <!-- STATS DE INSTRUCTOR -->
        <div class="stat-card card-green">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="book-open" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $misFichasCount ?? 0; ?></div>
            <div class="stat-card-label">Mis Fichas Asignadas</div>
        </div>

        <div class="stat-card card-blue">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i data-lucide="calendar" style="width: 26px; height: 26px;"></i>
                </div>
            </div>
            <div class="stat-card-value"><?php echo $misAsignacionesCount ?? 0; ?></div>
            <div class="stat-card-label">Clases Programadas</div>
        </div>

    <?php endif; ?>
</div>

<!-- VISTA ESPECÍFICA POR ROL -->
<?php if ($rol === 'coordinador' || $rol === 'admin'): ?>
    <div class="section-title">
        <i data-lucide="zap" style="color: #f59e0b;"></i> Accesos Rápidos (Coordinación)
    </div>
    <div class="actions-grid mb-8">
        <a href="views/asignacion/crear.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#dcfce7; color:#16a34a;">
                <i data-lucide="plus" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Programar Clase</div>
        </a>
        <a href="views/ficha/crear.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#dbeafe; color:#2563eb;">
                <i data-lucide="users" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Nueva Ficha</div>
        </a>
        <a href="views/reporte/index.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#f3e8ff; color:#9333ea;">
                <i data-lucide="pie-chart" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Reportes</div>
        </a>
    </div>
<?php endif; ?>

<?php if ($rol === 'centro de formacion' || $rol === 'admin'): ?>
    <div class="section-title">
        <i data-lucide="settings" style="color: #64748b;"></i> Gestión Administrativa
    </div>
    <div class="actions-grid mb-8">
        <a href="views/sede/index.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#dbeafe; color:#2563eb;">
                <i data-lucide="building" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Gestionar Sedes</div>
        </a>
        <a href="views/ambiente/index.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#fef3c7; color:#d97706;">
                <i data-lucide="monitor" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Gestionar Ambientes</div>
        </a>
        <a href="views/instructor/index.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#f3e8ff; color:#9333ea;">
                <i data-lucide="users-round" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Gestionar Instructores</div>
        </a>
    </div>
<?php endif; ?>

<?php if ($rol === 'instructor' || $rol === 'admin'): ?>
    <div class="section-title">
        <i data-lucide="calendar-check" style="color: #10b981;"></i> Mi Actividad
    </div>
    <div class="actions-grid mb-8">
        <a href="views/asignacion/index.php?view=week" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#dcfce7; color:#16a34a;">
                <i data-lucide="calendar-days" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Mi Horario</div>
        </a>
        <a href="views/ficha/index.php" class="action-card">
            <div class="action-card-icon-wrapper" style="background:#dbeafe; color:#2563eb;">
                <i data-lucide="users" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Mis Fichas</div>
        </a>
        <a href="#" class="action-card" onclick="alert('Funcionalidad en desarrollo')">
            <div class="action-card-icon-wrapper" style="background:#fef3c7; color:#d97706;">
                <i data-lucide="clipboard-check" style="width:28px; height:28px;"></i>
            </div>
            <div class="action-card-title">Asistencia</div>
        </a>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
