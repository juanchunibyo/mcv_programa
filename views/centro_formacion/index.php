<?php
/**
 * Vista: Listado de Centros de Formación (index.php)
 */

require_once __DIR__ . '/../../controllers/CentroFormacionController.php';

session_start();

// Obtener datos reales de la base de datos
$rol = $_SESSION['usuario_rol'] ?? 'Invitado';
$centros_formacion = CentroFormacionController::obtenerTodosCentros();
$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

$title = 'Gestión de Centros de Formación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Centros de Formación'],
];

include __DIR__ . '/../layout/header.php';
?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Gestión de Centros de Formación</h1>
            <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
                <a href="crear.php" class="btn btn-primary">
                    <i data-lucide="plus"></i>
                    Registrar Centro de Formación
                </a>
            <?php
endif; ?>
        </div>

        <!-- Alerts -->
        <?php if ($mensaje): ?>
            <div class="alert alert-success">
                <i data-lucide="check-circle-2"></i>
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php
endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i data-lucide="alert-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php
endif; ?>

        <!-- Data Table -->
        <div class="table-container">
            <?php if (!empty($centros_formacion)): ?>
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de el Centro de Formación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($centros_formacion as $centro): ?>
                        <tr>
                            <td><span class="table-id"><?php echo htmlspecialchars($centro['cent_id']); ?></span></td>
                            <td><?php echo htmlspecialchars($centro['cent_nombre']); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="ver.php?id=<?php echo $centro['cent_id']; ?>" class="action-btn view-btn" title="Ver detalle">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
                                        <a href="editar.php?id=<?php echo $centro['cent_id']; ?>" class="action-btn edit-btn" title="Editar centro_formacion">
                                            <i data-lucide="pencil-line"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn" title="Eliminar centro_formacion" onclick="confirmDelete(<?php echo $centro['cent_id']; ?>, '<?php echo htmlspecialchars(addslashes($centro['cent_nombre']), ENT_QUOTES); ?>')">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    <?php
        endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php
    endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
else: ?>
                <div class="table-empty">
                    <div class="table-empty-icon">
                        <i data-lucide="building-2"></i>
                    </div>
                    <div class="table-empty-title">No hay centros de formación registradas</div>
                    <div class="table-empty-text">
                        <?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
                            Haz clic en "Registrar Centro de Formación" para agregar la primera centro_formacion.
                        <?php
    else: ?>
                            No se encontraron centros de formación en el sistema.
                        <?php
    endif; ?>
                    </div>
                </div>
            <?php
endif; ?>
        </div>

<!-- Delete Confirmation Modal -->
<?php if (in_array($rol, ['coordinador', 'admin', 'centro de formacion'])): ?>
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-body">
            <div class="modal-icon">
                <i data-lucide="alert-triangle"></i>
            </div>
            <h3 class="modal-title">Eliminar Centro de Formación</h3>
            <p class="modal-text">
                ¿Estás seguro de que deseas eliminar el centro de formación
                <strong id="deleteModalName"></strong>?
                Esta acción no se puede deshacer.
            </p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" action="procesar.php" style="flex:1;">
                <input type="hidden" name="cent_id" id="deleteModalId">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">
                    <i data-lucide="trash-2"></i>
                    Eliminar
                </button>
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

    // Close modal on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
<?php
endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
