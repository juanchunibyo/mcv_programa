<?php
/**
 * Vista: Editar Detalle de Asignación (editar.php)
 */

require_once __DIR__ . '/../../controllers/DetalleAsignacionController.php';
require_once __DIR__ . '/../../controllers/AsignacionController.php';

session_start();

$rol = $rol ?? 'coordinador';
$detalleId = intval($_GET['id'] ?? 0);

if ($detalleId <= 0) {
    header('Location: index.php');
    exit;
}

// Obtener datos del detalle
$detalle = DetalleAsignacionController::obtenerDetalle($detalleId);

if (!$detalle) {
    $_SESSION['error'] = 'Horario no encontrado';
    header('Location: index.php');
    exit;
}

// Cargar asignaciones
$asignaciones = AsignacionController::obtenerTodasAsignaciones();

$title = 'Editar Horario';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Detalles de Asignación', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Horario</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarDetalle" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="detasig_id" value="<?php echo htmlspecialchars($detalle['detasig_id']); ?>">

                    <div class="form-grid">
                        <!-- Asignación -->
                        <div class="form-group">
                            <label for="asignacion_asig_id" class="form-label">
                                Asignación <span class="required">*</span>
                            </label>
                            <select
                                id="asignacion_asig_id"
                                name="asignacion_asig_id"
                                class="form-input"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <?php foreach ($asignaciones as $asig): ?>
                                    <option
                                        value="<?php echo $asig['asig_id']; ?>"
                                        <?php echo($detalle['asignacion_asig_id'] == $asig['asig_id']) ? 'selected' : ''; ?>
                                    >
                                        Asignación #<?php echo htmlspecialchars($asig['asig_id']); ?> - Ficha <?php echo htmlspecialchars($asig['fich_id']); ?> - <?php echo htmlspecialchars($asig['amb_nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                                class="form-input"
                                value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($detalle['detasig_hora_ini']))); ?>"
                                required
                            >
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
                                class="form-input"
                                value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($detalle['detasig_hora_fin']))); ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Horario
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
