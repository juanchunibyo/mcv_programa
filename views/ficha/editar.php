<?php
/**
 * Vista: Editar Ficha (editar.php)
 */

require_once __DIR__ . '/../../Conexion.php';
require_once __DIR__ . '/../../controllers/FichaController.php';
require_once __DIR__ . '/../../controllers/ProgramaController.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = [];

// Obtener ID de la ficha desde la URL
$fichId = intval($_GET['id'] ?? 0);

if ($fichId <= 0) {
    $_SESSION['error'] = 'ID de ficha inválido';
    header('Location: index.php');
    exit;
}

// Obtener datos de la ficha
$ficha = FichaController::obtenerFicha($fichId);

if (!$ficha) {
    $_SESSION['error'] = 'Ficha no encontrada';
    header('Location: index.php');
    exit;
}

// Cargar programas desde la base de datos
$programas = ProgramaController::obtenerTodosProgramas();

// Cargar instructores desde la base de datos
$instructores = InstructorController::obtenerTodosInstructores();

// Cargar coordinaciones desde la base de datos
$db = Conexion::getConnect();
$stmtCoord = $db->query("SELECT coord_id, coord_nombre FROM coordinacion ORDER BY coord_nombre");
$coordinaciones = $stmtCoord->fetchAll(PDO::FETCH_ASSOC);

$title = 'Editar Ficha';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Fichas', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Ficha</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarFicha" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="fich_id" value="<?php echo htmlspecialchars($ficha['fich_id']); ?>">

                    <div class="form-group">
                        <label for="programa_id" class="form-label">
                            Programa de Formación <span class="required">*</span>
                        </label>
                        <select
                            id="programa_id"
                            name="programa_id"
                            class="form-input <?php echo isset($errores['programa_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione un programa</option>
                            <?php foreach ($programas as $p): ?>
                                <option
                                    value="<?php echo $p['prog_id']; ?>"
                                    <?php echo ($ficha['programa_prog_id'] == $p['prog_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars(($p['titpro_nombre'] ?? 'Sin nombre') . ' - Código: ' . $p['prog_codigo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error <?php echo isset($errores['programa_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['programa_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="instructor_id" class="form-label">
                            Instructor Líder <span class="required">*</span>
                        </label>
                        <select
                            id="instructor_id"
                            name="instructor_id"
                            class="form-input <?php echo isset($errores['instructor_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione un instructor</option>
                            <?php foreach ($instructores as $inst): ?>
                                <option
                                    value="<?php echo $inst['inst_id']; ?>"
                                    <?php echo ($ficha['instructor_inst_id'] == $inst['inst_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars(($inst['inst_nombres'] ?? '') . ' ' . ($inst['inst_apellidos'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error <?php echo isset($errores['instructor_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['instructor_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fich_jornada" class="form-label">
                            Jornada
                        </label>
                        <select
                            id="fich_jornada"
                            name="fich_jornada"
                            class="form-input"
                        >
                            <option value="">Seleccione...</option>
                            <option value="Mañana" <?php echo ($ficha['fich_jornada'] == 'Mañana') ? 'selected' : ''; ?>>Mañana</option>
                            <option value="Tarde" <?php echo ($ficha['fich_jornada'] == 'Tarde') ? 'selected' : ''; ?>>Tarde</option>
                            <option value="Noche" <?php echo ($ficha['fich_jornada'] == 'Noche') ? 'selected' : ''; ?>>Noche</option>
                            <option value="Mixta" <?php echo ($ficha['fich_jornada'] == 'Mixta') ? 'selected' : ''; ?>>Mixta</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="coordinacion_id" class="form-label">
                            Coordinación <span class="required">*</span>
                        </label>
                        <select
                            id="coordinacion_id"
                            name="coordinacion_id"
                            class="form-input <?php echo isset($errores['coordinacion_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione una coordinación</option>
                            <?php foreach ($coordinaciones as $coord): ?>
                                <option
                                    value="<?php echo $coord['coord_id']; ?>"
                                    <?php echo ($ficha['coordinacion_coord_id'] == $coord['coord_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($coord['coord_nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error <?php echo isset($errores['coordinacion_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['coordinacion_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Ficha
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
