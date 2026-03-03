<?php
/**
 * Vista: Editar Centro de Formación (editar.php)
 *
 * Variables esperadas del controlador:
 *   $centro     — Array con datos de el centro de formación ['cent_id' => 1, 'cent_nombre' => '...']
 *   $rol      — 'coordinador' | 'instructor'
 *   $errores  — (Opcional) Array de errores ['cent_nombre' => 'El nombre es requerido']
 */

// Obtener datos reales del controlador
require_once __DIR__ . '/../../controllers/CentroFormacionController.php';
session_start();

$rol = $_SESSION['usuario_rol'] ?? 'Invitado';
$centro_formacionId = intval($_GET['id'] ?? 0);

if ($centro_formacionId <= 0) {
    $_SESSION['error'] = 'ID de centro_formacion inválido';
    header('Location: index.php');
    exit;
}

$centro = CentroFormacionController::obtenerCentroFormacion($centro_formacionId);

if (!$centro) {
    $_SESSION['error'] = 'Centro de Formación no encontrada';
    header('Location: index.php');
    exit;
}

$errores = [];

$title = 'Editar Centro de Formación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Centros de Formación', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Editar Centro de Formación</h1>
        </div>

        <!-- Form -->
        <div class="form-container">
            <div class="form-card">
                <form id="formEditarCentro de Formación" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="cent_id" value="<?php echo htmlspecialchars($centro['cent_id']); ?>">

                    <div class="form-group">
                        <label for="cent_nombre" class="form-label">
                            Nombre de el Centro de Formación <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="cent_nombre"
                            name="cent_nombre"
                            class="form-input <?php echo isset($errores['cent_nombre']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: Centro de Gestión Industrial"
                            value="<?php echo htmlspecialchars($centro['cent_nombre']); ?>"
                            required
                            maxlength="200"
                            autocomplete="off"
                        >
                        <div class="form-error <?php echo isset($errores['cent_nombre']) ? 'visible' : ''; ?>" id="errorNombre">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['cent_nombre'] ?? 'Este campo es obligatorio.'); ?></span>
                        </div>
                        <div class="form-hint">Modifique el nombre de el centro de formación académica.</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Centro de Formación
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
    document.getElementById('formEditarCentro de Formación').addEventListener('submit', function(e) {
        var input = document.getElementById('cent_nombre');
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
    document.getElementById('cent_nombre').addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('input-error');
            document.getElementById('errorNombre').classList.remove('visible');
        }
    });
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
