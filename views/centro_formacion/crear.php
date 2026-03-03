<?php
/**
 * Vista: Registrar Centro de Formación (crear.php)
 *
 * Variables esperadas del controlador:
 *   $rol      — 'coordinador' | 'instructor'
 *   $errores  — (Opcional) Array de errores ['cent_nombre' => 'El nombre es requerido']
 *   $old      — (Opcional) Datos anteriores para repoblar el formulario
 */

session_start();

$rol = $_SESSION['usuario_rol'] ?? 'Invitado';
$errores = [];
$old = [];

$title = 'Registrar Centro de Formación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Centros de Formación', 'url' => 'index.php'],
    ['label' => 'Registrar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Registrar Centro de Formación</h1>
        </div>

        <!-- Form -->
        <div class="form-container">
            <div class="form-card">
                <form id="formCrearCentroFormacion" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="create">

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
                            value="<?php echo htmlspecialchars($old['cent_nombre'] ?? ''); ?>"
                            required
                            maxlength="200"
                            autocomplete="off"
                        >
                        <div class="form-error <?php echo isset($errores['cent_nombre']) ? 'visible' : ''; ?>" id="errorNombre">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['cent_nombre'] ?? 'Este campo es obligatorio.'); ?></span>
                        </div>
                        <div class="form-hint">Ingrese el nombre completo de el centro de formación académica.</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Guardar Centro de Formación
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
    document.getElementById('formCrearCentroFormacion').addEventListener('submit', function(e) {
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
