<?php
/**
 * Vista: Registrar Ambiente (crear.php)
 */

require_once __DIR__ . '/../../controllers/SedeController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = $errores ?? [];
$old = $old ?? [];

// Cargar sedes reales de la base de datos
$sedes = SedeController::obtenerTodasSedes();

// Si no hay sedes, mostrar advertencia pero permitir continuar
$advertencia = null;
if (empty($sedes)) {
    $advertencia = 'No hay sedes disponibles. Crea una sede primero o selecciona "Sin sede" temporalmente.';
    // Agregar opción "Sin sede"
    $sedes = [['sede_id' => 0, 'sede_nombre' => 'Sin sede (temporal)']];
}

$title = 'Registrar Ambiente';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Ambientes', 'url' => 'index.php'],
    ['label' => 'Registrar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Registrar Ambiente</h1>
        </div>

        <?php if ($advertencia): ?>
            <div class="alert alert-warning">
                <i data-lucide="alert-triangle"></i>
                <?php echo htmlspecialchars($advertencia); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <div class="form-card">
                <form id="formCrearAmb" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="create">

                    <div class="form-group">
                        <label for="amb_nombre" class="form-label">
                            Nombre del Ambiente <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="amb_nombre"
                            name="amb_nombre"
                            class="form-input <?php echo isset($errores['amb_nombre']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: Laboratorio de Software"
                            value="<?php echo htmlspecialchars($old['amb_nombre'] ?? ''); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['amb_nombre']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['amb_nombre'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="amb_capacidad" class="form-label">
                            Capacidad
                        </label>
                        <input
                            type="number"
                            id="amb_capacidad"
                            name="amb_capacidad"
                            class="form-input"
                            placeholder="Ej: 30"
                            value="<?php echo htmlspecialchars($old['amb_capacidad'] ?? ''); ?>"
                            min="0"
                        >
                    </div>

                    <div class="form-group">
                        <label for="sede_id" class="form-label">
                            Sede <span class="required">*</span>
                        </label>
                        <select
                            id="sede_id"
                            name="sede_id"
                            class="form-input <?php echo isset($errores['sede_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione una Sede</option>
                            <?php foreach ($sedes as $sede): ?>
                                <option
                                    value="<?php echo $sede['sede_id']; ?>"
                                    <?php echo(isset($old['sede_id']) && $old['sede_id'] == $sede['sede_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($sede['sede_nombre']); ?>
                                </option>
                            <?php
endforeach; ?>
                        </select>
                         <div class="form-error <?php echo isset($errores['sede_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['sede_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Guardar Ambiente
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
