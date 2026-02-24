<?php
/**
 * Vista: Registrar Asignación (crear.php)
 */

require_once __DIR__ . '/../../controllers/FichaController.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';
require_once __DIR__ . '/../../controllers/AmbienteController.php';
require_once __DIR__ . '/../../controllers/CompetenciaController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = [];
$old = [];

// Cargar datos desde la base de datos
$fichas = FichaController::obtenerTodasFichas();
$instructores = InstructorController::obtenerTodosInstructores();
$ambientes = AmbienteController::obtenerTodosAmbientes();
$competencias = CompetenciaController::obtenerTodasCompetencias();

$title = 'Nueva Asignación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Asignaciones', 'url' => 'index.php'],
    ['label' => 'Nueva'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Nueva Asignación</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formCrearAsig" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="create">

                    <div class="form-grid">
                        <!-- Ficha -->
                        <div class="form-group">
                            <label for="FICHA_fich_id" class="form-label">
                                Ficha <span class="required">*</span>
                            </label>
                            <select
                                id="FICHA_fich_id"
                                name="FICHA_fich_id"
                                class="form-input <?php echo isset($errores['FICHA_fich_id']) ? 'input-error' : ''; ?>"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <?php foreach ($fichas as $f): ?>
                                    <option
                                        value="<?php echo $f['fich_id']; ?>"
                                        <?php echo(isset($old['FICHA_fich_id']) && $old['FICHA_fich_id'] == $f['fich_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars($f['fich_id']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                            <div class="form-error <?php echo isset($errores['FICHA_fich_id']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['FICHA_fich_id'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <!-- Instructor -->
                        <div class="form-group">
                            <label for="INSTRUCTOR_inst_id" class="form-label">
                                Instructor <span class="required">*</span>
                            </label>
                            <select
                                id="INSTRUCTOR_inst_id"
                                name="INSTRUCTOR_inst_id"
                                class="form-input <?php echo isset($errores['INSTRUCTOR_inst_id']) ? 'input-error' : ''; ?>"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <?php foreach ($instructores as $inst): ?>
                                    <option
                                        value="<?php echo $inst['inst_id']; ?>"
                                        <?php echo(isset($old['INSTRUCTOR_inst_id']) && $old['INSTRUCTOR_inst_id'] == $inst['inst_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars($inst['inst_nombres'] . ' ' . $inst['inst_apellidos']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                            <div class="form-error <?php echo isset($errores['INSTRUCTOR_inst_id']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['INSTRUCTOR_inst_id'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <!-- Ambiente -->
                        <div class="form-group">
                            <label for="AMBIENTE_id_ambiente" class="form-label">
                                Ambiente <span class="required">*</span>
                            </label>
                            <select
                                id="AMBIENTE_id_ambiente"
                                name="AMBIENTE_id_ambiente"
                                class="form-input <?php echo isset($errores['AMBIENTE_id_ambiente']) ? 'input-error' : ''; ?>"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <?php foreach ($ambientes as $amb): ?>
                                    <option
                                        value="<?php echo $amb['amb_id']; ?>"
                                        <?php echo(isset($old['AMBIENTE_id_ambiente']) && $old['AMBIENTE_id_ambiente'] == $amb['amb_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars($amb['amb_nombre']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                            <div class="form-error <?php echo isset($errores['AMBIENTE_id_ambiente']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['AMBIENTE_id_ambiente'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <!-- Competencia -->
                        <div class="form-group">
                            <label for="COMPETENCIA_comp_id" class="form-label">
                                Competencia <span class="required">*</span>
                            </label>
                            <select
                                id="COMPETENCIA_comp_id"
                                name="COMPETENCIA_comp_id"
                                class="form-input <?php echo isset($errores['COMPETENCIA_comp_id']) ? 'input-error' : ''; ?>"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <?php foreach ($competencias as $comp): ?>
                                    <option
                                        value="<?php echo $comp['comp_id']; ?>"
                                        <?php echo(isset($old['COMPETENCIA_comp_id']) && $old['COMPETENCIA_comp_id'] == $comp['comp_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars($comp['comp_nombre_corto']); ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                            <div class="form-error <?php echo isset($errores['COMPETENCIA_comp_id']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['COMPETENCIA_comp_id'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="form-group">
                            <label for="asig_fecha_ini" class="form-label">
                                Fecha Inicio <span class="required">*</span>
                            </label>
                            <input
                                type="date"
                                id="asig_fecha_ini"
                                name="asig_fecha_ini"
                                class="form-input <?php echo isset($errores['asig_fecha_ini']) ? 'input-error' : ''; ?>"
                                value="<?php echo htmlspecialchars($old['asig_fecha_ini'] ?? ''); ?>"
                                required
                            >
                            <div class="form-error <?php echo isset($errores['asig_fecha_ini']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['asig_fecha_ini'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="asig_fecha_fin" class="form-label">
                                Fecha Fin <span class="required">*</span>
                            </label>
                            <input
                                type="date"
                                id="asig_fecha_fin"
                                name="asig_fecha_fin"
                                class="form-input <?php echo isset($errores['asig_fecha_fin']) ? 'input-error' : ''; ?>"
                                value="<?php echo htmlspecialchars($old['asig_fecha_fin'] ?? ''); ?>"
                                required
                            >
                             <div class="form-error <?php echo isset($errores['asig_fecha_fin']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['asig_fecha_fin'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Guardar Asignación
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

// Guardar todas las opciones de instructores
const instructorSelect = document.getElementById('INSTRUCTOR_inst_id');
const allInstructorOptions = Array.from(instructorSelect.options);

// Cuando se selecciona una ficha, filtrar y autoseleccionar el instructor
document.getElementById('FICHA_fich_id').addEventListener('change', function() {
    const fichaId = parseInt(this.value);
    
    // Limpiar el select
    instructorSelect.innerHTML = '<option value="">Seleccione...</option>';
    
    if (fichaId && fichaInstructorMap[fichaId]) {
        const instructorId = fichaInstructorMap[fichaId];
        
        // Solo agregar la opción del instructor correspondiente
        allInstructorOptions.forEach(option => {
            if (parseInt(option.value) === instructorId) {
                instructorSelect.appendChild(option.cloneNode(true));
            }
        });
        
        // Autoseleccionar el instructor
        instructorSelect.value = instructorId;
        
        // Hacer el campo readonly visualmente
        instructorSelect.style.backgroundColor = '#f3f4f6';
        instructorSelect.disabled = false;
    } else {
        // Si no hay ficha seleccionada, mostrar todos los instructores
        allInstructorOptions.forEach(option => {
            if (option.value !== '') {
                instructorSelect.appendChild(option.cloneNode(true));
            }
        });
        instructorSelect.style.backgroundColor = '';
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
