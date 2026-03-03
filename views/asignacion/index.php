<?php
/**
 * Vista: Listado y Calendario de Asignaciones (index.php)
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';

session_start();

// Obtener datos reales de la base de datos
$rol = $_SESSION['usuario_rol'] ?? 'instructor';
$asignaciones = AsignacionController::obtenerTodasAsignaciones();

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

$title = 'Gestión de Asignaciones';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Asignaciones'],
];

// Preparamos los eventos para FullCalendar
$eventos = [];
foreach ($asignaciones as $asig) {
    $colors = ['#39A900', '#007832', '#4CAF50', '#8BC34A', '#2E7D32'];
    $colorIndex = (isset($asig['fich_id']) ? intval($asig['fich_id']) : 0) % count($colors);
    
    $baseEvent = [
        'id' => $asig['asig_id'],
        'title' => "Ficha: " . ($asig['fich_id'] ?? 'N/A') . " | " . ($asig['amb_nombre'] ?? 'N/A'),
        'color' => $colors[$colorIndex],
        'extendedProps' => [
            'instructor' => $asig['inst_nombres'] ?? 'N/A',
            'competencia' => $asig['comp_nombre_corto'] ?? 'N/A',
            'ambiente' => $asig['amb_nombre'] ?? 'N/A',
            'ficha' => $asig['fich_id'] ?? 'N/A'
        ]
    ];

    $fechaIni = date('Y-m-d', strtotime($asig['asig_fecha_ini']));
    $fechaFin = date('Y-m-d', strtotime($asig['asig_fecha_fin']));

    // En lugar de repetirlo todos los días (lo cual llena mucho el calendario), 
    // mostraremos solo el día de Inicio y el día de Fin (en rojo, como acordamos).
    
    // Evento de INICIO
    $eventoInicio = $baseEvent;
    
    // Evento de FIN (Solo si la fecha de fin es diferente a la de inicio)
    $eventoFin = null;
    if ($fechaIni !== $fechaFin) {
        $eventoFin = $baseEvent;
        $eventoFin['color'] = '#ef4444'; // Rojo para la fecha fin
    }

    if (!empty($asig['detasig_hora_ini']) && !empty($asig['detasig_hora_fin'])) {
        // Tiene horas específicas
        $horaIni = date('H:i:s', strtotime($asig['detasig_hora_ini']));
        $horaFin = date('H:i:s', strtotime($asig['detasig_hora_fin']));
        
        $eventoInicio['title'] = "Inicio: " . $baseEvent['title'];
        $eventoInicio['start'] = $fechaIni . 'T' . $horaIni;
        $eventoInicio['end'] = $fechaIni . 'T' . $horaFin;
        $eventos[] = $eventoInicio;
        
        if ($eventoFin) {
            $eventoFin['title'] = "Fin: " . $baseEvent['title'];
            $eventoFin['start'] = $fechaFin . 'T' . $horaIni;
            $eventoFin['end'] = $fechaFin . 'T' . $horaFin;
            $eventos[] = $eventoFin;
        }
    } else {
        // Asignación de "Día Completo" o flotante (sin hora definida)
        $eventoInicio['title'] = "Inicio: " . $baseEvent['title'];
        $eventoInicio['start'] = $fechaIni;
        $eventoInicio['allDay'] = true;
        $eventos[] = $eventoInicio;
        
        if ($eventoFin) {
            $eventoFin['title'] = "Fin: " . $baseEvent['title'];
            $eventoFin['start'] = $fechaFin;
            $eventoFin['allDay'] = true;
            $eventos[] = $eventoFin;
        }
    }
}

include __DIR__ . '/../layout/header.php';
?>

<!-- FullCalendar Core and Plugins -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>

<style>
    /* FullCalendar Premium Styles */
    .fc { font-family: 'Montserrat', 'Segoe UI', sans-serif; background: white; padding: 24px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
    .fc-theme-standard th { border: none; padding: 12px 0; text-transform: capitalize; font-weight: 600; color: #4b5563; font-size: 0.95rem; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f3f4f6; }
    .fc .fc-button-primary { background-color: #39A900; border-color: #39A900; text-transform: capitalize; border-radius: 8px; font-weight: 600; padding: 8px 16px; transition: all 0.3s; }
    .fc .fc-button-primary:hover { background-color: #2e8800; border-color: #2e8800; transform: translateY(-1px); }
    .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #1e5c00; border-color: #1e5c00; }
    .fc-event { border: none !important; border-radius: 4px; padding: 2px 4px; font-size: 0.8rem; cursor: pointer; transition: transform 0.2s; }
    .fc-event:hover { transform: scale(1.02); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .fc-day-today { background-color: rgba(57, 169, 0, 0.05) !important; }
    .fc-toolbar-title { font-weight: 700 !important; color: #1f2937; font-size: 1.5rem !important; text-transform: capitalize; }
    
    /* Modal Styling */
    .event-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
    .event-modal.active { display: flex; opacity: 1; }
    .event-modal-content { background: white; border-radius: 16px; padding: 32px; width: 100%; max-width: 450px; transform: translateY(20px); transition: transform 0.3s ease; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .event-modal.active .event-modal-content { transform: translateY(0); }
    .modal-header-event { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f3f4f6; padding-bottom: 12px; }
    .modal-header-event h2 { font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0; }
    .modal-close-btn { background: none; border: none; color: #9ca3af; cursor: pointer; transition: color 0.2s; }
    .modal-close-btn:hover { color: #ef4444; }
    .event-detail-row { margin-bottom: 16px; }
    .event-detail-label { font-size: 0.85rem; color: #6b7280; display: block; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; font-weight: 600; }
    .event-detail-value { font-size: 1rem; color: #1f2937; font-weight: 500; }
    .event-actions { margin-top: 24px; display: flex; gap: 12px; }
    .btn-detalle { flex: 1; display: flex; justify-content: center; align-items: center; gap: 8px; padding: 10px; background: #f3f4f6; color: #374151; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s; }
    .btn-detalle:hover { background: #e5e7eb; }
</style>

<div class="page-header">
    <h1 class="page-title">Asignación de Ambientes</h1>
    <div style="display: flex; gap: 10px;">
        <button id="toggleViewBtn" class="btn btn-secondary" style="background: white; border: 1px solid #d1d5db; color: #374151; cursor: pointer;">
            <i data-lucide="calendar"></i>
            <span id="toggleViewText">Ver Calendario</span>
        </button>
        <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
            <a href="crear.php" class="btn btn-primary">
                <i data-lucide="plus"></i>
                Nueva Asignación
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Alerts -->
<?php if ($mensaje): ?>
    <div class="alert alert-success">
        <i data-lucide="check-circle-2"></i>
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error">
        <i data-lucide="alert-circle"></i>
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<!-- CONTENEDOR VISTA TABLA -->
<div id="tableView" class="table-container">
    <?php if (!empty($asignaciones)): ?>
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ficha</th>
                    <th>Instructor</th>
                    <th>Ambiente</th>
                    <th>Fechas (Inicio - Fin)</th>
                    <th>Competencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asignaciones as $asig): ?>
                <tr>
                    <td><span class="table-id"><?php echo htmlspecialchars($asig['asig_id']); ?></span></td>
                    <td><?php echo htmlspecialchars($asig['fich_id'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($asig['inst_nombres'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($asig['amb_nombre'] ?? 'N/A'); ?></td>
                    <td>
                        <?php 
                        $fechaIni = date('d/m/Y', strtotime($asig['asig_fecha_ini']));
                        $fechaFin = date('d/m/Y', strtotime($asig['asig_fecha_fin']));
                        echo htmlspecialchars($fechaIni . ' - ' . $fechaFin); 
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($asig['comp_nombre_corto'] ?? 'N/A'); ?></td>
                    <td>
                        <div class="table-actions">
                            <a href="ver.php?id=<?php echo $asig['asig_id']; ?>" class="action-btn view-btn" title="Ver detalle">
                                <i data-lucide="eye"></i>
                            </a>
                            <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
                                <a href="editar.php?id=<?php echo $asig['asig_id']; ?>" class="action-btn edit-btn" title="Editar asignación">
                                    <i data-lucide="pencil-line"></i>
                                </a>
                                <button type="button" class="action-btn delete-btn" title="Eliminar asignación" onclick="confirmDelete(<?php echo $asig['asig_id']; ?>)">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="table-empty">
            <div class="table-empty-icon">
                <i data-lucide="calendar-days"></i>
            </div>
            <div class="table-empty-title">No hay asignaciones registradas</div>
        </div>
    <?php endif; ?>
</div>

<!-- CONTENEDOR VISTA CALENDARIO -->
<div id="calendarView" style="display: none;">
    <div id='calendar'></div>
</div>

<!-- Modal Detalles del Evento (FullCalendar) -->
<div class="event-modal" id="eventModal">
    <div class="event-modal-content">
        <div class="modal-header-event">
            <h2 id="modalTitle">Detalle de Asignación</h2>
            <button class="modal-close-btn" onclick="closeEventModal()">
                <i data-lucide="x"></i>
            </button>
        </div>
        <div class="event-detail-row">
            <span class="event-detail-label">Instructor y Competencia</span>
            <div class="event-detail-value" id="modalProfComp"></div>
        </div>
        <div class="event-detail-row">
            <span class="event-detail-label">Ficha y Ambiente</span>
            <div class="event-detail-value" id="modalFichAmb"></div>
        </div>
        <div class="event-detail-row">
            <span class="event-detail-label">Período</span>
            <div class="event-detail-value" id="modalPeriod"></div>
        </div>
        <div class="event-actions">
            <a href="#" id="viewMoreBtn" class="btn-detalle" style="background:#39A900; color:white;">
                <i data-lucide="eye" style="width:18px;"></i> Ver Completo
            </a>
            <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
            <a href="#" id="editBtnCalendar" class="btn-detalle">
                <i data-lucide="pencil" style="width:18px;"></i> Editar
            </a>
            <button type="button" id="deleteBtnCalendar" class="btn-detalle" style="background:#fecaca; color:#dc2626; border:1px solid #f87171; cursor:pointer;">
                <i data-lucide="trash-2" style="width:18px;"></i> Eliminar
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-body">
            <div class="modal-icon">
                <i data-lucide="alert-triangle"></i>
            </div>
            <h3 class="modal-title">Eliminar Asignación</h3>
            <p class="modal-text">
                ¿Estás seguro de que deseas eliminar la asignación
                <strong id="deleteModalName"></strong>?
            </p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
            <form id="deleteForm" method="POST" action="procesar.php" style="flex:1;">
                <input type="hidden" name="asig_id" id="deleteModalId">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">
                    <i data-lucide="trash-2"></i>
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Tab switching logic
    const toggleBtn = document.getElementById('toggleViewBtn');
    const toggleText = document.getElementById('toggleViewText');
    const toggleIcon = toggleBtn.querySelector('i');
    const tableView = document.getElementById('tableView');
    const calendarView = document.getElementById('calendarView');
    let calendarRendered = false;
    let calendar;

    toggleBtn.addEventListener('click', function() {
        if (tableView.style.display !== 'none') {
            // Cambiar a vista calendario
            tableView.style.display = 'none';
            calendarView.style.display = 'block';
            toggleText.textContent = 'Ver en Lista';
            toggleIcon.setAttribute('data-lucide', 'list');
            
            // Renderizar calendario solo la primera vez o forzar actualización
            if (!calendarRendered) {
                renderCalendar();
                calendarRendered = true;
            } else {
                calendar.render();
            }
        } else {
            // Cambiar a vista tabla
            calendarView.style.display = 'none';
            tableView.style.display = 'block';
            toggleText.textContent = 'Ver Calendario';
            toggleIcon.setAttribute('data-lucide', 'calendar');
        }
        lucide.createIcons();
    });

    // Calendar rendering function
    function renderCalendar() {
        var calendarEl = document.getElementById('calendar');
        var evtData = <?php echo json_encode($eventos); ?>;
        
        // Obtener la vista inicial dependiendo si viene por parámetro GET
        var initView = new URLSearchParams(window.location.search).get('view') === 'week' ? 'timeGridWeek' : 'dayGridMonth';

        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: initView,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                list: 'Lista'
            },
            allDaySlot: false, // Oculta la fila superior "todo el día" en la vista semanal (así se ocultan las clases sin horas)
            slotMinTime: '06:00:00', // Empieza la vista de la semana a las 6am
            slotMaxTime: '23:00:00', // Termina a las 11pm
            events: evtData,
            eventClick: function(info) {
                var props = info.event.extendedProps;
                var startOptions = { day: 'numeric', month: 'short', year: 'numeric' };
                var startStr = info.event.start.toLocaleDateString('es-ES', startOptions);
                var endStr = "Fecha indefinida";
                
                // Si es un evento recurrente con horas, FullCalendar en evento de click devuelve las fechas de ESE DIA en específico
                if (!info.event.allDay && info.event.start && info.event.end) {
                    var timeOptions = { hour: '2-digit', minute: '2-digit' };
                    var startTimeStr = info.event.start.toLocaleTimeString('es-ES', timeOptions);
                    var endTimeStr = info.event.end.toLocaleTimeString('es-ES', timeOptions);
                    
                    document.getElementById('modalPeriod').innerHTML = 
                        '<strong>' + startStr + '</strong><br>' + 
                        '<span style="font-size: 0.9em; color:#666;">' + startTimeStr + ' - ' + endTimeStr + ' hs</span>';
                } else {
                    // Si es evento de "todo el día" (rango de fechas)
                    if (info.event.end) {
                        var d = new Date(info.event.end);
                        d.setDate(d.getDate() - 1); // Restamos el día que FullCalendar añade como límite
                        endStr = d.toLocaleDateString('es-ES', startOptions);
                    }
                    document.getElementById('modalPeriod').innerHTML = 
                        startStr + ' - ' + endStr + '<br><span style="font-size: 0.9em; color:#666;">(Horas por definir)</span>';
                }
                
                document.getElementById('modalTitle').textContent = 'Asignación #' + info.event.id;
                document.getElementById('modalProfComp').innerHTML = '<strong>' + props.instructor + '</strong><br><span style="font-size:0.9rem;color:#666;">' + props.competencia + '</span>';
                document.getElementById('modalFichAmb').innerHTML = 'Ficha: ' + props.ficha + '<br>Ambiente: ' + props.ambiente;
                
                document.getElementById('viewMoreBtn').href = 'ver.php?id=' + info.event.id;
                
                var editBtn = document.getElementById('editBtnCalendar');
                if (editBtn) { editBtn.href = 'editar.php?id=' + info.event.id; }

                var deleteBtn = document.getElementById('deleteBtnCalendar');
                if (deleteBtn) { 
                    deleteBtn.onclick = function() { 
                        closeEventModal(); 
                        confirmDelete(info.event.id); 
                    }; 
                }

                document.getElementById('eventModal').classList.add('active');
                lucide.createIcons();
            }
        });
        calendar.render();
    }

    // Modal Functions
    function closeEventModal() { document.getElementById('eventModal').classList.remove('active'); }
    document.getElementById('eventModal').addEventListener('click', function(e) { if (e.target === this) { closeEventModal(); }});

    <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
    function confirmDelete(id) {
        document.getElementById('deleteModalId').value = id;
        document.getElementById('deleteModalName').textContent = '#' + id;
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('active'); }
    document.getElementById('deleteModal').addEventListener('click', function(e) { if (e.target === this) closeDeleteModal(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDeleteModal(); closeEventModal(); } });
    <?php endif; ?>

    // Autocargar calendario semanal si viene de Mi Horario
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('view') === 'week') {
            tableView.style.display = 'none';
            calendarView.style.display = 'block';
            toggleText.textContent = 'Ver en Lista';
            if(toggleIcon) toggleIcon.setAttribute('data-lucide', 'list');
            
            if (!calendarRendered) {
                renderCalendar();
                calendarRendered = true;
            }
            lucide.createIcons();
        }
    });

</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
