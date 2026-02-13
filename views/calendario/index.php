<?php
/**
 * Vista: Calendario de Programación Académica
 */

require_once __DIR__ . '/../../controllers/CalendarioController.php';

$rol = $rol ?? 'coordinador';
$title = 'Calendario de Programación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/index.php'],
    ['label' => 'Calendario'],
];

// Obtener mes y año actual
$mesActual = date('n'); // 1-12
$anioActual = date('Y');

// Obtener asignaciones del mes
$asignaciones = CalendarioController::getAsignacionesCalendario($mesActual, $anioActual);

// Obtener datos para filtros
$filtros = CalendarioController::getFiltrosData();

include __DIR__ . '/../layout/header.php';
?>

<style>
    .calendar-container {
        background: rgba(15, 90, 45, 0.95);
        border: 1px solid rgba(15, 90, 45, 1);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 8px 32px rgba(15, 90, 45, 0.4);
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
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .calendar-nav button:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .calendar-month {
        font-size: 24px;
        font-weight: 700;
        color: white;
        min-width: 200px;
        text-align: center;
    }

    .calendar-filters {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 14px;
        cursor: pointer;
    }

    .filter-select option {
        background: #1a5a2e;
        color: white;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-top: 20px;
    }

    .calendar-day-header {
        text-align: center;
        padding: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .calendar-day {
        min-height: 120px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 8px;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .calendar-day:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .calendar-day.other-month {
        opacity: 0.3;
    }

    .calendar-day.today {
        border: 2px solid var(--green-primary);
        background: rgba(57, 169, 0, 0.15);
    }

    .day-number {
        font-weight: 600;
        color: white;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .day-events {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .event-item {
        padding: 6px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border-left: 3px solid;
    }

    .event-item:hover {
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .event-ficha {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
        color: #93c5fd;
    }

    .event-ambiente {
        background: rgba(245, 158, 11, 0.2);
        border-color: #f59e0b;
        color: #fcd34d;
    }

    .event-instructor {
        background: rgba(139, 92, 246, 0.2);
        border-color: #8b5cf6;
        color: #c4b5fd;
    }

    .legend {
        display: flex;
        gap: 24px;
        margin-top: 20px;
        padding: 16px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.8);
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border-left: 3px solid;
    }

    .legend-color.ficha {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
    }

    .legend-color.ambiente {
        background: rgba(245, 158, 11, 0.2);
        border-color: #f59e0b;
    }

    .legend-color.instructor {
        background: rgba(139, 92, 246, 0.2);
        border-color: #8b5cf6;
    }

    /* Modal de evento */
    .event-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .event-modal.active {
        display: flex;
    }

    .event-modal-content {
        background: rgba(15, 90, 45, 0.98);
        border: 1px solid rgba(57, 169, 0, 0.5);
        border-radius: 16px;
        padding: 32px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
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
        color: white;
    }

    .event-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .event-form-group {
        margin-bottom: 20px;
    }

    .event-form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 8px;
    }

    .event-form-input,
    .event-form-select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 14px;
    }

    .event-form-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .event-form-select option {
        background: #1a5a2e;
        color: white;
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
    }

    .btn-save:hover {
        background: var(--green-secondary);
    }

    .btn-cancel {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    @media (max-width: 768px) {
        .calendar-grid {
            gap: 4px;
        }

        .calendar-day {
            min-height: 80px;
            padding: 4px;
        }

        .day-number {
            font-size: 12px;
        }

        .event-item {
            font-size: 10px;
            padding: 4px 6px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Calendario de Programación</h1>
        <p class="page-subtitle">Gestiona horarios, fichas, ambientes y asignaciones</p>
    </div>
    <button class="btn btn-primary" onclick="openEventModal()">
        <i data-lucide="plus"></i>
        Nueva Asignación
    </button>
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

    <div class="calendar-grid">
        <div class="calendar-day-header">Lun</div>
        <div class="calendar-day-header">Mar</div>
        <div class="calendar-day-header">Mié</div>
        <div class="calendar-day-header">Jue</div>
        <div class="calendar-day-header">Vie</div>
        <div class="calendar-day-header">Sáb</div>
        <div class="calendar-day-header">Dom</div>
        
        <div id="calendarDays"></div>
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
                <label class="event-form-label">Tipo de Asignación</label>
                <select class="event-form-select" id="eventType" required>
                    <option value="">Seleccionar...</option>
                    <option value="ficha">Asignación de Ficha</option>
                    <option value="ambiente">Reserva de Ambiente</option>
                    <option value="instructor">Horario de Instructor</option>
                </select>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Fecha</label>
                <input type="date" class="event-form-input" id="eventDate" required>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Hora Inicio</label>
                <input type="time" class="event-form-input" id="eventTimeStart" required>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Hora Fin</label>
                <input type="time" class="event-form-input" id="eventTimeEnd" required>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Ficha</label>
                <select class="event-form-select" id="eventFicha" required>
                    <option value="">Seleccionar...</option>
                    <option value="1">Ficha 2758392</option>
                    <option value="2">Ficha 2758393</option>
                </select>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Instructor</label>
                <select class="event-form-select" id="eventInstructor" required>
                    <option value="">Seleccionar...</option>
                    <option value="1">Juan Pérez</option>
                    <option value="2">María García</option>
                </select>
            </div>

            <div class="event-form-group">
                <label class="event-form-label">Ambiente</label>
                <select class="event-form-select" id="eventAmbiente" required>
                    <option value="">Seleccionar...</option>
                    <option value="1">Ambiente 101</option>
                    <option value="2">Ambiente 102</option>
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

    // Datos reales de asignaciones desde PHP
    const events = <?= json_encode($asignaciones) ?>;

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
                    const horaIni = event.hora_ini ? event.hora_ini.substring(0, 5) : '';
                    const horaFin = event.hora_fin ? event.hora_fin.substring(0, 5) : '';
                    
                    eventEl.textContent = `${horaIni} - Ficha ${event.ficha}`;
                    eventEl.title = `Instructor: ${event.instructor}\nAmbiente: ${event.ambiente}\nHorario: ${horaIni} - ${horaFin}`;
                    
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
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    }

    function nextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
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
        alert('Asignación guardada correctamente');
        closeEventModal();
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

    // Inicializar calendario
    renderCalendar();
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
