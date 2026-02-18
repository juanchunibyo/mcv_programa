<?php
/**
 * Vista: Editar Ambiente (editar.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$ambiente = $ambiente ?? ['id_ambiente' => 1, 'amb_nombre' => 'Laboratorio de Software 1', 'Sede_sede_id' => 1];
$sedes = $sedes ?? [
    ['sede_id' => 1, 'sede_nombre' => 'Centro de Gestión Industrial'],
    ['sede_id' => 2, 'sede_nombre' => 'Centro de Tecnologías del Transporte'],
];
$errores = $errores ?? [];
// --- Fin datos de prueba ---

$title = 'Editar Ambiente';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Ambientes', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Ambiente</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarAmb" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="amb_id" value="<?php echo htmlspecialchars($ambiente['amb_id'] ?? $ambiente['id_ambiente']); ?>">

                    <div class="form-group">
                        <label for="amb_nombre" class="form-label">
                            Nombre del Ambiente <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="amb_nombre"
                            name="amb_nombre"
                            class="form-input <?php echo isset($errores['amb_nombre']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($ambiente['amb_nombre']); ?>"
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
                            value="<?php echo htmlspecialchars($ambiente['amb_capacidad'] ?? ''); ?>"
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
                                    <?php echo(($ambiente['sede_id'] ?? $ambiente['Sede_sede_id']) == $sede['sede_id']) ? 'selected' : ''; ?>
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
                            Actualizar Ambiente
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
