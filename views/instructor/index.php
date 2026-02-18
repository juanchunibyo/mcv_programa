<?php
require_once __DIR__ . '/../../controllers/InstructorController.php';
session_start();

$rol = $rol ?? 'coordinador';
$instructores = InstructorController::obtenerTodosInstructores();
$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

$title = 'Gestión de Instructores';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Instructores'],
];
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Instructores</h1>
    <?php if ($rol === 'coordinador'): ?>
        <a href="crear.php" class="btn btn-primary"><i data-lucide="plus"></i> Registrar Instructor</a>
    <?php endif; ?>
</div>

<?php if ($mensaje): ?>
    <div class="alert alert-success"><i data-lucide="check-circle-2"></i> <?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-error"><i data-lucide="alert-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="table-container">
    <?php if (!empty($instructores)): ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instructores as $inst): ?>
            <tr>
                <td><span class="table-id">#<?= htmlspecialchars($inst['inst_id']) ?></span></td>
                <td><?= htmlspecialchars($inst['inst_nombres']) ?></td>
                <td><?= htmlspecialchars($inst['inst_apellidos']) ?></td>
                <td><?= htmlspecialchars($inst['inst_correo'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($inst['inst_telefono'] ?? 'N/A') ?></td>
                <td>
                    <div class="table-actions">
                        <a href="ver.php?id=<?= $inst['inst_id'] ?>" class="action-btn view-btn" title="Ver"><i data-lucide="eye"></i></a>
                        <?php if ($rol === 'coordinador'): ?>
                            <a href="editar.php?id=<?= $inst['inst_id'] ?>" class="action-btn edit-btn" title="Editar"><i data-lucide="pencil-line"></i></a>
                            <button type="button" class="action-btn delete-btn" title="Eliminar" onclick="confirmDelete(<?= $inst['inst_id'] ?>, '<?= htmlspecialchars(addslashes($inst['inst_nombres'] . ' ' . $inst['inst_apellidos']), ENT_QUOTES) ?>')"><i data-lucide="trash-2"></i></button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="table-empty">
            <div class="table-empty-icon"><i data-lucide="user"></i></div>
            <div class="table-empty-title">No hay instructores registrados</div>
        </div>
    <?php endif; ?>
</div>

<?php if ($rol === 'coordinador'): ?>
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-body">
            <div class="modal-icon"><i data-lucide="alert-triangle"></i></div>
            <h3 class="modal-title">Eliminar Instructor</h3>
            <p class="modal-text">¿Eliminar a <strong id="deleteModalName"></strong>?</p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
            <form id="deleteForm" method="POST" action="procesar.php" style="flex:1;">
                <input type="hidden" name="inst_id" id="deleteModalId">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;"><i data-lucide="trash-2"></i> Eliminar</button>
            </form>
        </div>
    </div>
</div>
<script>
function confirmDelete(id, nombre) {
    document.getElementById('deleteModalId').value = id;
    document.getElementById('deleteModalName').textContent = nombre;
    document.getElementById('deleteModal').classList.add('active');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
