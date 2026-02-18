<?php
/**
 * Vista: Editar Competencia (editar.php)
 */

require_once __DIR__ . '/../../controllers/CompetenciaController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = [];

// Obtener ID de la competencia desde la URL
$compId = intval($_GET['id'] ?? 0);

if ($compId <= 0) {
    $_SESSION['error'] = 'ID de competencia inválido';
    header('Location: index.php');
    exit;
}

// Obtener datos de la competencia
$competencia = CompetenciaController::obtenerCompetencia($compId);

if (!$competencia) {
    $_SESSION['error'] = 'Competencia no encontrada';
    header('Location: index.php');
    exit;
}

$title = 'Editar Competencia';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Competencias', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Competencia</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarComp" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="comp_id" value="<?php echo htmlspecialchars($competencia['comp_id']); ?>">

                    <div class="form-group">
                        <label for="comp_nombre_corto" class="form-label">
                            Nombre Corto <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="comp_nombre_corto"
                            name="comp_nombre_corto"
                            class="form-input <?php echo isset($errores['comp_nombre_corto']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($competencia['comp_nombre_corto']); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['comp_nombre_corto']) ? 'visible' : ''; ?>" id="errorNombre">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['comp_nombre_corto'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comp_nombre_unidad_competencia" class="form-label">
                            Nombre Unidad de Competencia <span class="required">*</span>
                        </label>
                        <textarea
                            id="comp_nombre_unidad_competencia"
                            name="comp_nombre_unidad_competencia"
                            class="form-input <?php echo isset($errores['comp_nombre_unidad_competencia']) ? 'input-error' : ''; ?>"
                            required
                            rows="3"
                        ><?php echo htmlspecialchars($competencia['comp_nombre_unidad_competencia']); ?></textarea>
                        <div class="form-error <?php echo isset($errores['comp_nombre_unidad_competencia']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['comp_nombre_unidad_competencia'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="comp_horas" class="form-label">
                            Horas <span class="required">*</span>
                        </label>
                        <input
                            type="number"
                            id="comp_horas"
                            name="comp_horas"
                            class="form-input <?php echo isset($errores['comp_horas']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($competencia['comp_horas']); ?>"
                            required
                            min="1"
                        >
                        <div class="form-error <?php echo isset($errores['comp_horas']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['comp_horas'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Competencia
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
