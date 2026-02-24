<?php
/**
 * Vista: Calendario de Programación Académica
 */

require_once __DIR__ . '/../../controllers/CalendarioController.php';
require_once __DIR__ . '/../../controllers/SedeController.php';
require_once __DIR__ . '/../../controllers/FichaController.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';
require_once __DIR__ . '/../../controllers/AmbienteController.php';
require_once __DIR__ . '/../../controllers/CompetenciaController.php';

$rol = $rol ?? 'coordinador';
$title = 'Calendario de Programación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/index.php'],
    ['label' => 'Calendario'],
];

// Obtener mes y año actual
$mesActual = date('n'); // 1-12
$anioActual = date('Y');

// Obtener asignaciones reales de la base de datos
$asignaciones = CalendarioController::obtenerAsignacionesPorMes($mesActual, $anioActual);

// Obtener datos para filtros
$filtros = [
    'sedes' => SedeController::obtenerTodasSedes(),
    'fichas' => FichaController::obtenerTodasFichas(),
    'instructores' => InstructorController::obtenerTodosInstructores()
];

// Datos para el formulario
$fichas = FichaController::obtenerTodasFichas();
$instructores = InstructorController::obtenerTodosInstructores();
$ambientes = AmbienteController::obtenerTodosAmbientes();
$competencias = CompetenciaController::obtenerTodasCompetencias();

// Si no hay datos en la BD, usar datos de prueba
if (empty($fichas)) {
    $fichas = [
        ['fich_id' => '2758392'],
        ['fich_id' => '2758393'],
        ['fich_id' => '2758394']
    ];
}

if (empty($instructores)) {
    $instructores = [
        ['inst_id' => 1, 'inst_nombres' => 'Juan', 'inst_apellidos' => 'Pérez'],
        ['inst_id' => 2, 'inst_nombres' => 'María', 'inst_apellidos' => 'García'],
        ['inst_id' => 3, 'inst_nombres' => 'Carlos', 'inst_apellidos' => 'López']
    ];
}

if (empty($ambientes)) {
    $ambientes = [
        ['amb_id' => 1, 'amb_nombre' => 'Laboratorio 101'],
        ['amb_id' => 2, 'amb_nombre' => 'Aula 202'],
        ['amb_id' => 3, 'amb_nombre' => 'Sala 303']
    ];
}

if (empty($competencias)) {
    $competencias = [
        ['comp_id' => 1, 'comp_nombre_corto' => 'Programación'],
        ['comp_id' => 2, 'comp_nombre_corto' => 'Bases de Datos'],
        ['comp_id' => 3, 'comp_nombre_corto' => 'Redes']
    ];
}

include __DIR__ . '/../layout/header.php';
?>

<style>
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

<div class="page-header">
    <div>
        <h1 class="page-title">Calendario de Programación</h1>
        <p class="page-subtitle">Gestiona horarios, fichas, ambientes y asignaciones</p>
    </div>
</div>

<div class="calendar-container">
    <div class="calendar-header">
        <div class="calendar-nav">
            <button onclick="previousMonth()">
                <i data-lucide="chevron-left" style="width: 20px; height: 20px;"></i>
            </button>
            <div class="calendar-month" id="currentMonth">Febrero 2026</div>
            <button onclick="nextMonth()">
                <i data-lucide="chevron-right" style="width: 20px; height: 20px;"></i>
            </button>
        </div>

        <div class="view-buttons">
            <button class="view-btn active" data-view="month" onclick="changeView('month')">Mes</button>
            <button class="view-btn" data-view="week" onclick="changeView('week')">Semana</button>
            <button class="view-btn" data-view="day" onclick="changeView('day')">Día</button>
        </div>

        <div class="calendar-filters">
            <select class="filter-select" id="filterSede">
                <option value="">Todas las Sedes</option>
                <?php foreach ($filtros['sedes'] as $sede): ?>
                    <option value="<?= $sede['sede_id'] ?>"><?= htmlspecialchars($sede['sede_nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <select class="filter-select" id="filterFicha">
                <option value="">Todas las Fichas</option>
                <?php foreach ($filtros['fichas'] as $ficha): ?>
                    <option value="<?= $ficha['fich_id'] ?>">Ficha <?= htmlspecialchars($ficha['fich_id']) ?></option>
                <?php endforeach; ?>
            </select>

            <select class="filter-select" id="filterInstructor">
                <option value="">Todos los Instructores</option>
                <?php foreach ($filtros['instructores'] as $instructor): ?>
                    <option value="<?= $instructor['inst_id'] ?>">
                        <?= htmlspecialchars($instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Vista Mensual -->
    <div id="monthView" class="calendar-view">
        <div class="calendar-grid">
            <div class="calendar-day-header">Lun</div>
            <div class="calendar-day-header">Mar</div>
            <div class="calendar-day-header">Mié</div>
            <div class="calendar-day-header">Jue</div>
            <div class="calendar-day-header">Vie</div>
            <div class="calendar-day-header">Sáb</div>
            <div class="calendar-day-header">Dom</div>
        </div>
        <div id="calendarDays" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background: rgba(0, 0, 0, 0.08); margin-top: 1px;"></div>
    </div>

    <!-- Vista Semanal -->
    <div id="weekView" class="calendar-view" style="display: none;">
        <div class="week-view" id="weekGrid"></div>
    </div>

    <!-- Vista Diaria -->
    <div id="dayView" class="calendar-view" style="display: none;">
        <div class="day-view" id="dayGrid"></div>
    </div>

    <div class="legend">
        <div class="legend-item">
            <div class="legend-color ficha"></div>
            <span>Asignación de Ficha</span>
        </div>
        <div class="legend-item">
            <div class="legend-color ambiente"></div>
            <span>Reserva de Ambiente</span>
        </div>
        <div class="legend-item">
            <div class="legend-color instructor"></div>
            <span>Horario de Instructor</span>
        </div>
    </div>
</div>

<!-- Modal para crear/editar evento -->
<div class="event-modal" id="eventModal">
    <div class="event-modal-content">
        <div class="event-modal-header">
            <h3 class="event-modal-title">Nueva Asignación</h3>
            <button class="event-modal-close" onclick="closeEventModal()">
                <i data-lucide="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>

        <form id="eventForm">
            <div class="event-form-group">
                <label class="event-form-label">Fecha <span style="color: red;">*</span></label>
                <input type="date" class="event-form-input" id="eventDate" name="fecha" required>
            </div>

            <div class="time-inputs-row">
                <div class="event-form-group time-input-group">
                    <label class="event-form-label">
                        <i data-lucide="clock" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;"></i>
                        Hora Inicio <span style="color: red;">*</span>
                    </label>
                    <input type="time" class="event-form-input time-input" id="eventTimeStart" name="hora_inicio" required>
                </div>

                <div class="time-separator">
                    <i data-lucide="arrow-right" style="width: 20px; height: 20px; color: #a0aec0;"></i>
                </div>

                <div class="event-form-group time-input-group">
                    <label class="event-form-label">
                        <i data-lucide="clock" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;"></i>
                        Hora Fin <span style="color: red;">*</span>
                    </label>
                    <input type="time" class="event-form-input time-input" id="eventTimeEnd" name="hora_fin" required>
                </div>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Ficha <span style="color: red;">*</span></label>
                <select class="event-form-select" id="eventFicha" name="ficha_id" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?= htmlspecialchars($ficha['fich_id']) ?>">
                            Ficha <?= htmlspecialchars($ficha['fich_id']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Instructor <span style="color: red;">*</span></label>
                <select class="event-form-select" id="eventInstructor" name="instructor_id" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($instructores as $instructor): ?>
                        <option value="<?= htmlspecialchars($instructor['inst_id']) ?>">
                            <?= htmlspecialchars($instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Ambiente <span style="color: red;">*</span></label>
                <select class="event-form-select" id="eventAmbiente" name="ambiente_id" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($ambientes as $ambiente): ?>
                        <option value="<?= htmlspecialchars($ambiente['amb_id']) ?>">
                            <?= htmlspecialchars($ambiente['amb_nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Competencia (Opcional)</label>
                <select class="event-form-select" id="eventCompetencia" name="competencia_id">
                    <option value="">Seleccionar...</option>
                    <?php foreach ($competencias as $competencia): ?>
                        <option value="<?= htmlspecialchars($competencia['comp_id']) ?>">
                            <?= htmlspecialchars($competencia['comp_nombre_corto']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="event-form-actions">
                <button type="button" class="btn-cancel" onclick="closeEventModal()">Cancelar</button>
                <button type="submit" class="btn-save">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentDate = new Date();
    let currentView = 'month';

    // Datos reales de asignaciones desde PHP
    const events = <?= json_encode($asignaciones) ?>;
    
    // Debug: Ver estructura de eventos
    console.log('Eventos cargados:', events);
    if (Object.keys(events).length > 0) {
        const primeraFecha = Object.keys(events)[0];
        console.log('Ejemplo de evento:', events[primeraFecha][0]);
    }

    // Cambiar vista
    function changeView(view) {
        currentView = view;
        
        // Actualizar botones activos
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.view === view) {
                btn.classList.add('active');
            }
        });
        
        // Mostrar/ocultar vistas
        document.getElementById('monthView').style.display = view === 'month' ? 'block' : 'none';
        document.getElementById('weekView').style.display = view === 'week' ? 'block' : 'none';
        document.getElementById('dayView').style.display = view === 'day' ? 'block' : 'none';
        
        // Renderizar vista correspondiente
        if (view === 'month') {
            renderCalendar();
        } else if (view === 'week') {
            renderWeekView();
        } else if (view === 'day') {
            renderDayView();
        }
    }

    // Renderizar vista semanal
    function renderWeekView() {
        const weekGrid = document.getElementById('weekGrid');
        weekGrid.innerHTML = '';
        
        // Obtener inicio de la semana (lunes)
        const startOfWeek = new Date(currentDate);
        const day = startOfWeek.getDay();
        const diff = startOfWeek.getDate() - day + (day === 0 ? -6 : 1);
        startOfWeek.setDate(diff);
        
        // Crear encabezados de días
        const dayNames = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        weekGrid.appendChild(createEmptyCell()); // Esquina superior izquierda
        
        for (let i = 0; i < 7; i++) {
            const date = new Date(startOfWeek);
            date.setDate(startOfWeek.getDate() + i);
            const header = document.createElement('div');
            header.className = 'day-header';
            if (isToday(date)) header.classList.add('today');
            header.innerHTML = `
                <div>${dayNames[i]}</div>
                <div class="day-date">${date.getDate()}/${date.getMonth() + 1}</div>
            `;
            weekGrid.appendChild(header);
        }
        
        // Crear franjas horarias (6:00 AM - 10:00 PM)
        for (let hour = 6; hour <= 22; hour++) {
            // Columna de hora
            const timeSlot = document.createElement('div');
            timeSlot.className = 'time-slot';
            timeSlot.textContent = `${hour.toString().padStart(2, '0')}:00`;
            weekGrid.appendChild(timeSlot);
            
            // Celdas para cada día
            for (let i = 0; i < 7; i++) {
                const date = new Date(startOfWeek);
                date.setDate(startOfWeek.getDate() + i);
                const cell = createEventCell(date, hour);
                weekGrid.appendChild(cell);
            }
        }
        
        lucide.createIcons();
    }

    // Renderizar vista diaria
    function renderDayView() {
        const dayGrid = document.getElementById('dayGrid');
        dayGrid.innerHTML = '';
        
        // Encabezado del día
        const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        
        dayGrid.appendChild(createEmptyCell());
        const header = document.createElement('div');
        header.className = 'day-header';
        if (isToday(currentDate)) header.classList.add('today');
        header.innerHTML = `
            <div>${dayNames[currentDate.getDay()]}</div>
            <div class="day-date">${currentDate.getDate()} ${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}</div>
        `;
        dayGrid.appendChild(header);
        
        // Crear franjas horarias (6:00 AM - 10:00 PM)
        for (let hour = 6; hour <= 22; hour++) {
            const timeSlot = document.createElement('div');
            timeSlot.className = 'time-slot';
            timeSlot.textContent = `${hour.toString().padStart(2, '0')}:00`;
            dayGrid.appendChild(timeSlot);
            
            const cell = createEventCell(currentDate, hour);
            dayGrid.appendChild(cell);
        }
        
        lucide.createIcons();
    }

    // Crear celda de evento
    function createEventCell(date, hour) {
        const cell = document.createElement('div');
        cell.className = 'event-cell';
        
        const dateKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        
        if (events[dateKey]) {
            events[dateKey].forEach(event => {
                // Verificar si el evento tiene hora de inicio
                if (event.hora_ini && event.hora_ini !== null) {
                    // Extraer la hora del formato HH:MM o HH:MM:SS
                    const eventHour = parseInt(event.hora_ini.split(':')[0]);
                    
                    if (eventHour === hour) {
                        const eventBlock = document.createElement('div');
                        eventBlock.className = 'event-block ficha';
                        
                        // Formatear horas
                        const horaIni = event.hora_ini.substring(0, 5);
                        const horaFin = event.hora_fin ? event.hora_fin.substring(0, 5) : 'N/A';
                        
                        eventBlock.innerHTML = `
                            <div class="event-time">${horaIni} - ${horaFin}</div>
                            <div class="event-title">Ficha ${event.ficha}</div>
                        `;
                        eventBlock.title = `Instructor: ${event.instructor}\nAmbiente: ${event.ambiente}\nHorario: ${horaIni} - ${horaFin}`;
                        eventBlock.onclick = (e) => {
                            e.stopPropagation();
                            mostrarDetalleEvento(event);
                        };
                        cell.appendChild(eventBlock);
                    }
                }
            });
        }
        
        cell.onclick = () => {
            openEventModal(date.getFullYear(), date.getMonth(), date.getDate());
        };
        
        return cell;
    }

    // Crear celda vacía
    function createEmptyCell() {
        const cell = document.createElement('div');
        cell.className = 'time-slot';
        return cell;
    }

    // Verificar si es hoy
    function isToday(date) {
        const today = new Date();
        return date.getDate() === today.getDate() &&
               date.getMonth() === today.getMonth() &&
               date.getFullYear() === today.getFullYear();
    }

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Actualizar título
        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                           'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

        // Obtener primer y último día del mes
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        
        // Obtener día de la semana del primer día (0 = domingo, ajustar a lunes = 0)
        let startDay = firstDay.getDay() - 1;
        if (startDay === -1) startDay = 6;

        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

        // Días del mes anterior
        const prevMonthDays = new Date(year, month, 0).getDate();
        for (let i = startDay - 1; i >= 0; i--) {
            const day = prevMonthDays - i;
            const dayEl = createDayElement(day, true);
            calendarDays.appendChild(dayEl);
        }

        // Días del mes actual
        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const isToday = day === today.getDate() && 
                           month === today.getMonth() && 
                           year === today.getFullYear();
            const dayEl = createDayElement(day, false, isToday, year, month);
            calendarDays.appendChild(dayEl);
        }

        // Días del siguiente mes
        const remainingDays = 42 - (startDay + daysInMonth);
        for (let day = 1; day <= remainingDays; day++) {
            const dayEl = createDayElement(day, true);
            calendarDays.appendChild(dayEl);
        }

        lucide.createIcons();
    }

    function createDayElement(day, otherMonth, isToday = false, year, month) {
        const dayEl = document.createElement('div');
        dayEl.className = 'calendar-day';
        if (otherMonth) dayEl.classList.add('other-month');
        if (isToday) dayEl.classList.add('today');

        const dayNumber = document.createElement('div');
        dayNumber.className = 'day-number';
        dayNumber.textContent = day;
        dayEl.appendChild(dayNumber);

        // Agregar eventos si existen
        if (!otherMonth && year && month !== undefined) {
            const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            if (events[dateKey]) {
                const eventsContainer = document.createElement('div');
                eventsContainer.className = 'day-events';
                
                events[dateKey].forEach(event => {
                    const eventEl = document.createElement('div');
                    eventEl.className = 'event-item event-ficha';
                    
                    // Formatear hora
                    const horaIni = event.hora_ini ? event.hora_ini.substring(0, 5) : 'Sin hora';
                    const horaFin = event.hora_fin ? event.hora_fin.substring(0, 5) : '';
                    
                    // Mostrar rango de horas si existe hora fin
                    const horario = horaFin ? `${horaIni}-${horaFin}` : horaIni;
                    
                    eventEl.textContent = `${horario} Ficha ${event.ficha}`;
                    eventEl.title = `Instructor: ${event.instructor}\nAmbiente: ${event.ambiente}\nHorario: ${horaIni} - ${horaFin || 'N/A'}`;
                    
                    eventEl.onclick = (e) => {
                        e.stopPropagation();
                        mostrarDetalleEvento(event);
                    };
                    eventsContainer.appendChild(eventEl);
                });
                
                dayEl.appendChild(eventsContainer);
            }
        }

        dayEl.onclick = () => {
            if (!otherMonth) {
                openEventModal(year, month, day);
            }
        };

        return dayEl;
    }

    function previousMonth() {
        if (currentView === 'month') {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        } else if (currentView === 'week') {
            currentDate.setDate(currentDate.getDate() - 7);
            renderWeekView();
        } else if (currentView === 'day') {
            currentDate.setDate(currentDate.getDate() - 1);
            renderDayView();
        }
        updateMonthDisplay();
    }

    function nextMonth() {
        if (currentView === 'month') {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        } else if (currentView === 'week') {
            currentDate.setDate(currentDate.getDate() + 7);
            renderWeekView();
        } else if (currentView === 'day') {
            currentDate.setDate(currentDate.getDate() + 1);
            renderDayView();
        }
        updateMonthDisplay();
    }

    function updateMonthDisplay() {
        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                           'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        if (currentView === 'month') {
            document.getElementById('currentMonth').textContent = 
                `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        } else if (currentView === 'week') {
            const startOfWeek = new Date(currentDate);
            const day = startOfWeek.getDay();
            const diff = startOfWeek.getDate() - day + (day === 0 ? -6 : 1);
            startOfWeek.setDate(diff);
            
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            
            document.getElementById('currentMonth').textContent = 
                `${startOfWeek.getDate()} ${monthNames[startOfWeek.getMonth()]} - ${endOfWeek.getDate()} ${monthNames[endOfWeek.getMonth()]} ${currentDate.getFullYear()}`;
        } else if (currentView === 'day') {
            const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            document.getElementById('currentMonth').textContent = 
                `${dayNames[currentDate.getDay()]}, ${currentDate.getDate()} ${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        }
    }

    function openEventModal(year, month, day) {
        document.getElementById('eventModal').classList.add('active');
        if (year && month !== undefined && day) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            document.getElementById('eventDate').value = dateStr;
        }
        lucide.createIcons();
    }

    function closeEventModal() {
        document.getElementById('eventModal').classList.remove('active');
        document.getElementById('eventForm').reset();
    }

    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'create');
        
        const btnSave = this.querySelector('.btn-save');
        const originalText = btnSave.textContent;
        
        btnSave.disabled = true;
        btnSave.textContent = 'Guardando...';
        
        fetch('procesar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✓ Asignación creada exitosamente');
                closeEventModal();
                window.location.reload();
            } else {
                alert('✗ Error: ' + data.message);
                btnSave.disabled = false;
                btnSave.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('✗ Error al guardar la asignación');
            btnSave.disabled = false;
            btnSave.textContent = originalText;
        });
    });

    // Cerrar modal al hacer click fuera
    document.getElementById('eventModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEventModal();
        }
    });

    // Mostrar detalle de evento
    function mostrarDetalleEvento(event) {
        const horaIni = event.hora_ini ? event.hora_ini.substring(0, 5) : 'N/A';
        const horaFin = event.hora_fin ? event.hora_fin.substring(0, 5) : 'N/A';
        
        const mensaje = `
DETALLE DE ASIGNACIÓN

Instructor: ${event.instructor}
Ficha: ${event.ficha}
Ambiente: ${event.ambiente}
Competencia: ${event.competencia || 'N/A'}
Horario: ${horaIni} - ${horaFin}
        `;
        
        alert(mensaje.trim());
    }

    // Variables de filtro
    let filtroSede = '';
    let filtroFicha = '';
    let filtroInstructor = '';

    // Obtener opciones únicas de fichas e instructores por sede
    function obtenerOpcionesPorSede(sedeId) {
        const fichas = new Set();
        const instructores = new Map();
        
        // Restaurar eventos originales para obtener todas las opciones
        const eventosParaAnalizar = window.eventosOriginales || events;
        
        for (const fecha in eventosParaAnalizar) {
            eventosParaAnalizar[fecha].forEach(event => {
                // Si hay filtro de sede, solo incluir eventos de esa sede
                if (!sedeId || (event.sede_id && parseInt(event.sede_id) === parseInt(sedeId))) {
                    if (event.ficha) {
                        fichas.add(event.ficha);
                    }
                    if (event.instructor_id && event.instructor) {
                        instructores.set(event.instructor_id, event.instructor);
                    }
                }
            });
        }
        
        return {
            fichas: Array.from(fichas).sort(),
            instructores: Array.from(instructores.entries()).sort((a, b) => a[1].localeCompare(b[1]))
        };
    }

    // Actualizar opciones de filtros en cascada
    function actualizarOpcionesFiltros() {
        const opciones = obtenerOpcionesPorSede(filtroSede);
        
        // Actualizar dropdown de fichas
        const selectFicha = document.getElementById('filterFicha');
        const fichaActual = selectFicha.value;
        selectFicha.innerHTML = '<option value="">Todas las Fichas</option>';
        
        opciones.fichas.forEach(ficha => {
            const option = document.createElement('option');
            option.value = ficha;
            option.textContent = `Ficha ${ficha}`;
            if (ficha == fichaActual) option.selected = true;
            selectFicha.appendChild(option);
        });
        
        // Si la ficha actual no está en las opciones, resetear
        if (fichaActual && !opciones.fichas.includes(fichaActual)) {
            filtroFicha = '';
        }
        
        // Actualizar dropdown de instructores
        const selectInstructor = document.getElementById('filterInstructor');
        const instructorActual = selectInstructor.value;
        selectInstructor.innerHTML = '<option value="">Todos los Instructores</option>';
        
        opciones.instructores.forEach(([id, nombre]) => {
            const option = document.createElement('option');
            option.value = id;
            option.textContent = nombre;
            if (id == instructorActual) option.selected = true;
            selectInstructor.appendChild(option);
        });
        
        // Si el instructor actual no está en las opciones, resetear
        if (instructorActual && !opciones.instructores.find(([id]) => id == instructorActual)) {
            filtroInstructor = '';
        }
    }

    // Función para filtrar eventos
    function filtrarEventos() {
        const eventosFiltrados = {};
        
        for (const fecha in events) {
            const eventosDia = events[fecha].filter(event => {
                // Filtrar por sede (comparación numérica)
                if (filtroSede && event.sede_id && parseInt(event.sede_id) !== parseInt(filtroSede)) {
                    return false;
                }
                
                // Filtrar por ficha (comparación de string)
                if (filtroFicha && event.ficha && String(event.ficha) !== String(filtroFicha)) {
                    return false;
                }
                
                // Filtrar por instructor (comparación numérica)
                if (filtroInstructor && event.instructor_id && parseInt(event.instructor_id) !== parseInt(filtroInstructor)) {
                    return false;
                }
                
                return true;
            });
            
            if (eventosDia.length > 0) {
                eventosFiltrados[fecha] = eventosDia;
            }
        }
        
        return eventosFiltrados;
    }

    // Event listeners para los filtros
    document.getElementById('filterSede').addEventListener('change', function() {
        filtroSede = this.value;
        console.log('Filtro Sede:', filtroSede);
        
        // Actualizar opciones de fichas e instructores según la sede
        actualizarOpcionesFiltros();
        
        actualizarVista();
    });

    document.getElementById('filterFicha').addEventListener('change', function() {
        filtroFicha = this.value;
        console.log('Filtro Ficha:', filtroFicha);
        actualizarVista();
    });

    document.getElementById('filterInstructor').addEventListener('change', function() {
        filtroInstructor = this.value;
        console.log('Filtro Instructor:', filtroInstructor);
        actualizarVista();
    });

    // Función para actualizar la vista con filtros
    function actualizarVista() {
        // Guardar eventos originales si no están guardados
        if (!window.eventosOriginales) {
            window.eventosOriginales = JSON.parse(JSON.stringify(events));
        }
        
        // Restaurar eventos originales
        Object.keys(events).forEach(key => delete events[key]);
        Object.assign(events, window.eventosOriginales);
        
        // Aplicar filtros
        const eventosFiltrados = filtrarEventos();
        
        // Reemplazar events con los filtrados
        Object.keys(events).forEach(key => delete events[key]);
        Object.assign(events, eventosFiltrados);
        
        // Re-renderizar la vista actual
        if (currentView === 'month') {
            renderCalendar();
        } else if (currentView === 'week') {
            renderWeekView();
        } else if (currentView === 'day') {
            renderDayView();
        }
    }

    // Inicializar calendario
    renderCalendar();
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
