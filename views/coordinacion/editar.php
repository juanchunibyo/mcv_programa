<?php
/**
 * Vista: Editar Coordinación (editar.php)
 *
 * Variables esperadas del controlador:
 *   $coord     — Array con datos de la coordinación ['coord_id' => 1, 'coord_nombre' => '...']
 *   $rol      — 'coordinador' | 'instructor'
 *   $errores  — (Opcional) Array de errores ['coord_nombre' => 'El nombre es requerido']
 */

// Obtener datos reales del controlador
require_once __DIR__ . '/../../controllers/CoordinacionController.php';
session_start();

$rol = $_SESSION['usuario_rol'] ?? 'Invitado';
$coordinacionId = intval($_GET['id'] ?? 0);

if ($coordinacionId <= 0) {
    $_SESSION['error'] = 'ID de coordinacion inválido';
    header('Location: index.php');
    exit;
}

$coord = CoordinacionController::obtenerCoordinacion($coordinacionId);

if (!$coord) {
    $_SESSION['error'] = 'Coordinación no encontrada';
    header('Location: index.php');
    exit;
}

$errores = [];

$title = 'Editar Coordinación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Coordinaciones', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Editar Coordinación</h1>
        </div>

        <!-- Form -->
        <div class="form-container">
            <div class="form-card">
                <form id="formEditarCoordinación" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="coord_id" value="<?php echo htmlspecialchars($coord['coord_id']); ?>">

                    <div class="form-group">
                        <label for="coord_nombre" class="form-label">
                            Nombre de la Coordinación <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="coord_nombre"
                            name="coord_nombre"
                            class="form-input <?php echo isset($errores['coord_nombre']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: Centro de Gestión Industrial"
                            value="<?php echo htmlspecialchars($coord['coord_nombre']); ?>"
                            required
                            maxlength="200"
                            autocomplete="off"
                        >
                        <div class="form-error <?php echo isset($errores['coord_nombre']) ? 'visible' : ''; ?>" id="errorNombre">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['coord_nombre'] ?? 'Este campo es obligatorio.'); ?></span>
                        </div>
                        <div class="form-hint">Modifique el nombre de la coordinación académica.</div>
                    </div>

                    <div class="form-group">
                        <label for="centro_formacion_cent_id" class="form-label">
                            Centro de Formación <span class="required">*</span>
                        </label>
                        <select
                            id="centro_formacion_cent_id"
                            name="centro_formacion_cent_id"
                            class="form-select <?php echo isset($errores['centro_formacion_cent_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="" disabled>Seleccione un Centro de Formación</option>
                            <?php 
                                require_once __DIR__ . '/../../controllers/CentroFormacionController.php';
                                $centros = CentroFormacionController::obtenerTodosCentros();
                                foreach($centros as $centro): 
                            ?>
                                <option value="<?php echo htmlspecialchars($centro['cent_id']); ?>" <?php echo ($coord['centro_formacion_cent_id'] == $centro['cent_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($centro['cent_nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error <?php echo isset($errores['centro_formacion_cent_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span>Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Coordinación
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<script>
    // Client-side visual validation (real validation in controller)
    document.getElementById('formEditarCoordinación').addEventListener('submit', function(e) {
        var input = document.getElementById('coord_nombre');
        var errorDiv = document.getElementById('errorNombre');
        var value = input.value.trim();

        if (!value) {
            e.preventDefault();
            input.classList.add('input-error');
            errorDiv.classList.add('visible');
            input.focus();
        } else {
            input.classList.remove('input-error');
            errorDiv.classList.remove('visible');
        }
    });

    // Remove error state on input
    document.getElementById('coord_nombre').addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('input-error');
            document.getElementById('errorNombre').classList.remove('visible');
        }
    });
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
