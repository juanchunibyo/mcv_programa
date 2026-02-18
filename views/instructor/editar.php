<?php
require_once __DIR__ . '/../../Conexion.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';
session_start();

$instId = intval($_GET['id'] ?? 0);
if ($instId <= 0) {
    $_SESSION['error'] = 'ID inválido';
    header('Location: index.php');
    exit;
}

$instructor = InstructorController::obtenerInstructor($instId);
if (!$instructor) {
    $_SESSION['error'] = 'Instructor no encontrado';
    header('Location: index.php');
    exit;
}

$db = Conexion::getConnect();
$centros = $db->query("SELECT cent_id, cent_nombre FROM centro_formacion ORDER BY cent_nombre")->fetchAll(PDO::FETCH_ASSOC);

$title = 'Editar Instructor';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Instructores', 'url' => 'index.php'],
    ['label' => 'Editar'],
];
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header"><h1 class="page-title">Editar Instructor</h1></div>

<div class="form-container">
    <div class="form-card">
        <form method="POST" action="procesar.php">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="inst_id" value="<?= $instructor['inst_id'] ?>">
            
            <div class="form-group">
                <label class="form-label">Nombres <span class="required">*</span></label>
                <input type="text" name="inst_nombres" class="form-input" value="<?= htmlspecialchars($instructor['inst_nombres']) ?>" required maxlength="45">
            </div>
            
            <div class="form-group">
                <label class="form-label">Apellidos <span class="required">*</span></label>
                <input type="text" name="inst_apellidos" class="form-input" value="<?= htmlspecialchars($instructor['inst_apellidos']) ?>" required maxlength="45">
            </div>
            
            <div class="form-group">
                <label class="form-label">Correo</label>
                <input type="email" name="inst_correo" class="form-input" value="<?= htmlspecialchars($instructor['inst_correo'] ?? '') ?>" maxlength="45">
            </div>
            
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="inst_telefono" class="form-input" value="<?= htmlspecialchars($instructor['inst_telefono'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Centro de Formación</label>
                <select name="centro_formacion_id" class="form-input">
                    <option value="">Seleccione (opcional)</option>
                    <?php foreach ($centros as $c): ?>
                        <option value="<?= $c['cent_id'] ?>" <?= ($instructor['centro_formacion_cent_id'] == $c['cent_id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['cent_nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
