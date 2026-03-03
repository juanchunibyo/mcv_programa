<?php
require_once __DIR__ . '/../../Conexion.php';
session_start();

$rol = $_SESSION['usuario_rol'] ?? 'Invitado';

$title = 'Registrar Instructor';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Instructores', 'url' => 'index.php'],
    ['label' => 'Registrar'],
];
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header"><h1 class="page-title">Registrar Instructor</h1></div>

<div class="form-container">
    <div class="form-card">
        <form method="POST" action="procesar.php">
            <input type="hidden" name="action" value="create">
            
            <div class="form-group">
                <label class="form-label">Nombres <span class="required">*</span></label>
                <input type="text" name="inst_nombres" class="form-input" required maxlength="45">
            </div>
            
            <div class="form-group">
                <label class="form-label">Apellidos <span class="required">*</span></label>
                <input type="text" name="inst_apellidos" class="form-input" required maxlength="45">
            </div>
            
            <div class="form-group">
                <label class="form-label">Correo</label>
                <input type="email" name="inst_correo" class="form-input" maxlength="45">
            </div>
            
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="inst_telefono" class="form-input">
            </div>
            

            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
