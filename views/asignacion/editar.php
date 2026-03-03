<?php
/**
 * Vista: Editar Asignación (editar.php)
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';
require_once __DIR__ . '/../../controllers/FichaController.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';
require_once __DIR__ . '/../../controllers/AmbienteController.php';
require_once __DIR__ . '/../../controllers/CompetenciaController.php';

session_start();

$rol = $_SESSION['usuario_rol'] ?? 'coordinador';
$asigId = intval($_GET['id'] ?? 0);

if ($asigId <= 0) {
    header('Location: index.php');
    exit;
}

$errores = [];
$error_global = $_SESSION['error'] ?? null;
$old = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data'], $_SESSION['error']);

// Obtener datos iniciales de la base de datos
$asignaciones = AsignacionController::obtenerTodasAsignaciones();
$asignacionOriginal = null;
foreach ($asignaciones as $asig) {
    if ($asig['asig_id'] == $asigId) {
        $asignacionOriginal = $asig;
        break;
    }
}

if (!$asignacionOriginal) {
    $_SESSION['error'] = 'Asignación no encontrada';
    header('Location: index.php');
    exit;
}

// Convertir datos de la DB al formato del formulario o usar 'old' si hubo error 
$asignacion = [
    'asig_id' => $asigId,
    'FICHA_fich_id' => $old['FICHA_fich_id'] ?? $asignacionOriginal['fich_id'],
    'INSTRUCTOR_inst_id' => $old['INSTRUCTOR_inst_id'] ?? $asignacionOriginal['instructor_id'] ?? $asignacionOriginal['instructor_inst_id'] ?? '', 
    // ^ Nota: obtenerTodasAsignaciones devuelve el id vacio a veces debido a aliases si no esta mapeado bien. 
    // Usaremos FichaController para cargar el select igualmente.
    'AMBIENTE_id_ambiente' => $old['AMBIENTE_id_ambiente'] ?? $asignacionOriginal['ambiente_amb_id'],
    'COMPETENCIA_comp_id' => $old['COMPETENCIA_comp_id'] ?? $asignacionOriginal['competencia_comp_id'] ?? '',
    'asig_fecha_ini' => $old['asig_fecha_ini'] ?? date('Y-m-d', strtotime($asignacionOriginal['asig_fecha_ini'])),
    'asig_fecha_fin' => $old['asig_fecha_fin'] ?? date('Y-m-d', strtotime($asignacionOriginal['asig_fecha_fin'])),
    'detasig_hora_ini' => $old['detasig_hora_ini'] ?? (isset($asignacionOriginal['detasig_hora_ini']) ? date('H:i', strtotime($asignacionOriginal['detasig_hora_ini'])) : ''),
    'detasig_hora_fin' => $old['detasig_hora_fin'] ?? (isset($asignacionOriginal['detasig_hora_fin']) ? date('H:i', strtotime($asignacionOriginal['detasig_hora_fin'])) : '')
];

// Arreglando el instructor ID para edición porque en el select de obtenerTodasAsignaciones puede no venir el ID puro del instructor si no es devuelto.
// Revisando AsignacionController::obtenerTodasAsignaciones el join trae inst_nombres, pero falta recuperar el inst_id o está bajo a.instructor_inst_id. 
// Para ser seguros lo recargamos o asumimos que lo tenemos si re-ejecutamos una query, pero para el alias de obtenerTodasAsignaciones usamos getConnect directo si es necesario.
// Como no sabemos si getInstructorInstId está mapeado:
// La mejor forma es ver AsignacionController.php : 
// Selecciona `i.inst_nombres` pero no incluyó `a.instructor_inst_id`. Voy a buscar eso.
$db = Conexion::getConnect();
$stmtInst = $db->prepare("SELECT instructor_inst_id, competencia_comp_id FROM asignacion WHERE asig_id = ?");
$stmtInst->execute([$asigId]);
$baseData = $stmtInst->fetch(PDO::FETCH_ASSOC);

if (!$old) {
    if(isset($baseData['instructor_inst_id'])) $asignacion['INSTRUCTOR_inst_id'] = $baseData['instructor_inst_id'];
    if(isset($baseData['competencia_comp_id'])) $asignacion['COMPETENCIA_comp_id'] = $baseData['competencia_comp_id'];
}

$fichas = FichaController::obtenerTodasFichas();
$instructores = InstructorController::obtenerTodosInstructores();
$ambientes = AmbienteController::obtenerTodosAmbientes();
$competencias = CompetenciaController::obtenerTodasCompetencias();

$title = 'Editar Asignación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Asignaciones', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Asignación</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarAsig" method="POST" action="" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="asig_id" value="<?php echo htmlspecialchars($asignacion['asig_id']); ?>">

                    <?php if ($error_global): ?>
                        <div class="alert alert-error" style="margin-bottom: 20px;">
                            <i data-lucide="alert-circle"></i>
                            <?php echo htmlspecialchars($error_global); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="FICHA_fich_id" class="form-label">Ficha <span class="required">*</span></label>
                            <select id="FICHA_fich_id" name="FICHA_fich_id" class="form-input" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($fichas as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f['fich_id']); ?>" <?php echo($asignacion['FICHA_fich_id'] == $f['fich_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f['fich_id']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="INSTRUCTOR_inst_id" class="form-label">Instructor <span class="required">*</span></label>
                            <select id="INSTRUCTOR_inst_id" name="INSTRUCTOR_inst_id" class="form-input" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($instructores as $inst): ?>
                                    <option value="<?php echo htmlspecialchars($inst['inst_id']); ?>" <?php echo($asignacion['INSTRUCTOR_inst_id'] == $inst['inst_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($inst['inst_nombres'] . ' ' . $inst['inst_apellidos']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="AMBIENTE_id_ambiente" class="form-label">Ambiente <span class="required">*</span></label>
                            <select id="AMBIENTE_id_ambiente" name="AMBIENTE_id_ambiente" class="form-input" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($ambientes as $amb): ?>
                                    <option value="<?php echo htmlspecialchars($amb['amb_id']); ?>" <?php echo($asignacion['AMBIENTE_id_ambiente'] == $amb['amb_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($amb['amb_nombre']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="COMPETENCIA_comp_id" class="form-label">Competencia <span class="required">*</span></label>
                            <select id="COMPETENCIA_comp_id" name="COMPETENCIA_comp_id" class="form-input" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($competencias as $comp): ?>
                                    <option value="<?php echo $comp['comp_id']; ?>" <?php echo($asignacion['COMPETENCIA_comp_id'] == $comp['comp_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($comp['comp_nombre_corto']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asig_fecha_ini" class="form-label">Fecha Inicio <span class="required">*</span></label>
                            <input type="date" id="asig_fecha_ini" name="asig_fecha_ini" class="form-input" value="<?php echo htmlspecialchars($asignacion['asig_fecha_ini']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="asig_fecha_fin" class="form-label">Fecha Fin <span class="required">*</span></label>
                            <input type="date" id="asig_fecha_fin" name="asig_fecha_fin" class="form-input" value="<?php echo htmlspecialchars($asignacion['asig_fecha_fin'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="detasig_hora_ini" class="form-label">Hora Inicio <span class="required">*</span></label>
                            <input type="time" id="detasig_hora_ini" name="detasig_hora_ini" class="form-input" value="<?php echo htmlspecialchars($asignacion['detasig_hora_ini'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="detasig_hora_fin" class="form-label">Hora Fin <span class="required">*</span></label>
                            <input type="time" id="detasig_hora_fin" name="detasig_hora_fin" class="form-input" value="<?php echo htmlspecialchars($asignacion['detasig_hora_fin'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Asignación
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<script>
// Mapeo de fichas a instructores
const fichaInstructorMap = {
    <?php foreach ($fichas as $f): ?>
        <?php echo $f['fich_id']; ?>: <?php echo $f['instructor_inst_id']; ?>,
    <?php endforeach; ?>
};

const instructorSelect = document.getElementById('INSTRUCTOR_inst_id');
const allInstructorOptions = Array.from(instructorSelect.options);

function updateInstructor() {
    const fichaId = parseInt(document.getElementById('FICHA_fich_id').value);
    const selectedInstId = instructorSelect.value;
    
    instructorSelect.innerHTML = '<option value="">Seleccione...</option>';
    
    if (fichaId && fichaInstructorMap[fichaId]) {
        const instructorId = fichaInstructorMap[fichaId];
        
        allInstructorOptions.forEach(option => {
            if (parseInt(option.value) === instructorId) {
                instructorSelect.appendChild(option.cloneNode(true));
            }
        });
        
        instructorSelect.value = instructorId;
        instructorSelect.style.backgroundColor = '#f3f4f6';
        instructorSelect.disabled = false;
    } else {
        allInstructorOptions.forEach(option => {
            if (option.value !== '') {
                instructorSelect.appendChild(option.cloneNode(true));
            }
        });
        if(selectedInstId) instructorSelect.value = selectedInstId;
        instructorSelect.style.backgroundColor = '';
    }
}

document.getElementById('FICHA_fich_id').addEventListener('change', updateInstructor);
// Ejecutar al cargar la página para reflejar mapeo del form_data
window.addEventListener('load', updateInstructor);
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
