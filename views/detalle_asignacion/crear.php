<?php
/**
 * Vista: Crear Detalle de Asignación (crear.php)
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = [];
$old = [];

// Cargar asignaciones desde la base de datos
$asignaciones = AsignacionController::obtenerTodasAsignaciones();

$title = 'Nuevo Horario';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Detalles de Asignación', 'url' => 'index.php'],
    ['label' => 'Nuevo'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Nuevo Horario</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formCrearDetalle" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="create">

                    <div class="form-grid">
                        <!-- Asignación -->
                        <div class="form-group">
                            <label for="asignacion_asig_id" class="form-label">
                                Asignación <span class="required">*</span>
                            </label>
                            <select
                                id="asignacion_asig_id"
                                name="asignacion_asig_id"
                                class="form-input <?php echo isset($errores['asignacion_asig_id']) ? 'input-error' : ''; ?>"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <?php foreach ($asignaciones as $asig): ?>
                                    <option
                                        value="<?php echo $asig['asig_id']; ?>"
                                        <?php echo(isset($old['asignacion_asig_id']) && $old['asignacion_asig_id'] == $asig['asig_id']) ? 'selected' : ''; ?>
                                    >
                                        Asignación #<?php echo htmlspecialchars($asig['asig_id']); ?> - Ficha <?php echo htmlspecialchars($asig['fich_id']); ?> - <?php echo htmlspecialchars($asig['amb_nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-error <?php echo isset($errores['asignacion_asig_id']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['asignacion_asig_id'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <!-- Hora Inicio -->
                        <div class="form-group">
                            <label for="detasig_hora_ini" class="form-label">
                                Hora Inicio <span class="required">*</span>
                            </label>
                            <input
                                type="datetime-local"
                                id="detasig_hora_ini"
                                name="detasig_hora_ini"
                                class="form-input <?php echo isset($errores['detasig_hora_ini']) ? 'input-error' : ''; ?>"
                                value="<?php echo htmlspecialchars($old['detasig_hora_ini'] ?? ''); ?>"
                                required
                            >
                            <div class="form-error <?php echo isset($errores['detasig_hora_ini']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['detasig_hora_ini'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>

                        <!-- Hora Fin -->
                        <div class="form-group">
                            <label for="detasig_hora_fin" class="form-label">
                                Hora Fin <span class="required">*</span>
                            </label>
                            <input
                                type="datetime-local"
                                id="detasig_hora_fin"
                                name="detasig_hora_fin"
                                class="form-input <?php echo isset($errores['detasig_hora_fin']) ? 'input-error' : ''; ?>"
                                value="<?php echo htmlspecialchars($old['detasig_hora_fin'] ?? ''); ?>"
                                required
                            >
                            <div class="form-error <?php echo isset($errores['detasig_hora_fin']) ? 'visible' : ''; ?>">
                                <i data-lucide="alert-circle"></i>
                                <span><?php echo htmlspecialchars($errores['detasig_hora_fin'] ?? 'Requerido.'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Guardar Horario
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
