<?php
/**
 * Vista: Asociar Competencia a Programa (crear.php)
 */

require_once __DIR__ . '/../../controllers/ProgramaController.php';
require_once __DIR__ . '/../../controllers/CompetenciaController.php';

session_start();

$rol = $rol ?? 'coordinador';
$errores = [];

// Cargar programas y competencias desde la base de datos
$programasDB = ProgramaController::obtenerTodosProgramas();
$competencias = CompetenciaController::obtenerTodasCompetencias();

// Formatear programas con denominación
$programas = [];
foreach ($programasDB as $p) {
    $programas[] = [
        'prog_id' => $p['prog_id'],
        'prog_codigo' => $p['prog_codigo'],
        'prog_denominacion' => $p['titpro_nombre'] ?? 'Sin nombre'
    ];
}

$title = 'Asociar Competencia';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'CompetenciaPrograma', 'url' => 'index.php'],
    ['label' => 'Asociar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Asociar Competencia a Programa</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formAsociar" method="POST" action="procesar.php" novalidate>
                    <input type="hidden" name="action" value="create">

                    <div class="form-group">
                        <label for="PROGRAMA_prog_id" class="form-label">
                            Programa de Formación <span class="required">*</span>
                        </label>
                        <select
                            id="PROGRAMA_prog_id"
                            name="PROGRAMA_prog_id"
                            class="form-input <?php echo isset($errores['PROGRAMA_prog_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione...</option>
                            <?php foreach ($programas as $p): ?>
                                <option value="<?php echo $p['prog_id']; ?>">
                                    <?php echo htmlspecialchars($p['prog_codigo'] . ' - ' . $p['prog_denominacion']); ?>
                                </option>
                            <?php
endforeach; ?>
                        </select>
                         <div class="form-error <?php echo isset($errores['PROGRAMA_prog_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['PROGRAMA_prog_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="COMPETENCIA_comp_id" class="form-label">
                            Competencia <span class="required">*</span>
                        </label>
                        <select
                            id="COMPETENCIA_comp_id"
                            name="COMPETENCIA_comp_id"
                            class="form-input <?php echo isset($errores['COMPETENCIA_comp_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione...</option>
                            <?php foreach ($competencias as $c): ?>
                                <option value="<?php echo $c['comp_id']; ?>">
                                    <?php echo htmlspecialchars($c['comp_nombre_corto']); ?>
                                </option>
                            <?php
endforeach; ?>
                        </select>
                         <div class="form-error <?php echo isset($errores['COMPETENCIA_comp_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['COMPETENCIA_comp_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="link"></i>
                            Asociar
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
