<?php
/**
 * Vista: Editar Programa (editar.php)
 */

require_once __DIR__ . '/../../Conexion.php';
require_once __DIR__ . '/../../controllers/ProgramaController.php';
require_once __DIR__ . '/../../controllers/SedeController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = $errores ?? [];

// Obtener ID del programa desde la URL
$progId = intval($_GET['id'] ?? 0);

if ($progId <= 0) {
    $_SESSION['error'] = 'ID de programa inválido';
    header('Location: index.php');
    exit;
}

// Obtener datos del programa
$programa = ProgramaController::obtenerPrograma($progId);

if (!$programa) {
    $_SESSION['error'] = 'Programa no encontrado';
    header('Location: index.php');
    exit;
}

// Cargar títulos de programa desde la base de datos
$db = Conexion::getConnect();
$stmtTitulos = $db->query("SELECT titpro_id, titpro_nombre FROM titulo_programa ORDER BY titpro_nombre");
$titulos = $stmtTitulos->fetchAll(PDO::FETCH_ASSOC);

// Cargar sedes desde la base de datos
$sedes = SedeController::obtenerTodasSedes();

$title = 'Editar Programa';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Programas', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Programa</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarProg" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="prog_id" value="<?php echo htmlspecialchars($programa['prog_id']); ?>">

                    <div class="form-group">
                        <label for="prog_codigo" class="form-label">
                            Código del Programa <span class="required">*</span>
                        </label>
                        <input
                            type="number"
                            id="prog_codigo"
                            name="prog_codigo"
                            class="form-input <?php echo isset($errores['prog_codigo']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: 228106"
                            value="<?php echo htmlspecialchars($programa['prog_codigo']); ?>"
                            required
                        >
                        <div class="form-error <?php echo isset($errores['prog_codigo']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['prog_codigo'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tit_programa_id" class="form-label">
                            Título del Programa <span class="required">*</span>
                        </label>
                        <select
                            id="tit_programa_id"
                            name="tit_programa_id"
                            class="form-input <?php echo isset($errores['tit_programa_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione un título</option>
                            <?php foreach ($titulos as $titulo): ?>
                                <option
                                    value="<?php echo $titulo['titpro_id']; ?>"
                                    <?php echo ($programa['tit_programa_titpro_id'] == $titulo['titpro_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($titulo['titpro_nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error <?php echo isset($errores['tit_programa_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['tit_programa_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prog_tipo" class="form-label">
                            Tipo de Programa
                        </label>
                        <select
                            id="prog_tipo"
                            name="prog_tipo"
                            class="form-input"
                        >
                            <option value="">Seleccione...</option>
                            <option value="Tecnólogo" <?php echo ($programa['prog_tipo'] == 'Tecnólogo') ? 'selected' : ''; ?>>Tecnólogo</option>
                            <option value="Técnico" <?php echo ($programa['prog_tipo'] == 'Técnico') ? 'selected' : ''; ?>>Técnico</option>
                            <option value="Especialización" <?php echo ($programa['prog_tipo'] == 'Especialización') ? 'selected' : ''; ?>>Especialización</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sede_id" class="form-label">
                            Sede
                        </label>
                        <select
                            id="sede_id"
                            name="sede_id"
                            class="form-input"
                        >
                            <option value="">Seleccione una sede (opcional)</option>
                            <?php foreach ($sedes as $sede): ?>
                                <option
                                    value="<?php echo $sede['sede_id']; ?>"
                                    <?php echo ($programa['sede_sede_id'] == $sede['sede_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($sede['sede_nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Programa
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
