<?php
require_once __DIR__ . '/../../Conexion.php';
require_once __DIR__ . '/../../controllers/SedeController.php';
session_start();

$rol = $rol ?? 'coordinador';
$db = Conexion::getConnect();
$titulos = $db->query("SELECT titpro_id, titpro_nombre FROM titulo_programa ORDER BY titpro_nombre")->fetchAll(PDO::FETCH_ASSOC);
$sedes = SedeController::obtenerTodasSedes();

$title = 'Registrar Programa';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Programas', 'url' => 'index.php'],
    ['label' => 'Registrar'],
];
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header"><h1 class="page-title">Registrar Programa</h1></div>

<div class="form-container">
    <div class="form-card">
        <form method="POST" action="procesar.php">
            <input type="hidden" name="action" value="create">
            
            <div class="form-group">
                <label class="form-label">Código del Programa <span class="required">*</span></label>
                <input type="number" name="prog_codigo" class="form-input" placeholder="Ej: 228106" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Nivel de Formación <span class="required">*</span></label>
                <select name="tit_programa_id" class="form-input" required>
                    <option value="">Seleccione un nivel</option>
                    <?php foreach ($titulos as $t): ?>
                        <option value="<?= $t['titpro_id'] ?>"><?= htmlspecialchars($t['titpro_nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small style="color: #6b7280; font-size: 13px; margin-top: 4px; display: block;">
                    La denominación del programa será el nombre del nivel seleccionado
                </small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Duración</label>
                <select name="prog_tipo" class="form-input">
                    <option value="">Seleccione...</option>
                    <option value="Tecnólogo">Tecnólogo</option>
                    <option value="Técnico">Técnico</option>
                    <option value="Especialización">Especialización</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Sede</label>
                <select name="sede_id" class="form-input">
                    <option value="">Seleccione (opcional)</option>
                    <?php foreach ($sedes as $s): ?>
                        <option value="<?= $s['sede_id'] ?>"><?= htmlspecialchars($s['sede_nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Guardar Programa</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
