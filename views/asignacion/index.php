<?php
/**
 * Vista: Listado de Asignaciones (index.php)
 */

require_once __DIR__ . '/../../controllers/AsignacionController.php';

session_start();

// Obtener datos reales de la base de datos
$rol = $rol ?? 'coordinador';
$asignaciones = AsignacionController::obtenerTodasAsignaciones();

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

$title = 'Gestión de Asignaciones';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Asignaciones'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Asignación de Ambientes</h1>
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

        <div class="table-container">
            <?php if (!empty($asignaciones)): ?>
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ficha</th>
                            <th>Instructor</th>
                            <th>Ambiente</th>
                            <th>Fechas (Inicio - Fin)</th>
                            <th>Competencia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asignaciones as $asig): ?>
                        <tr>
                            <td><span class="table-id"><?php echo htmlspecialchars($asig['asig_id']); ?></span></td>
                            <td><?php echo htmlspecialchars($asig['fich_id'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($asig['inst_nombres'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($asig['amb_nombre'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($asig['asig_fecha_ini'] . ' / ' . $asig['asig_fecha_fin']); ?></td>
                            <td><?php echo htmlspecialchars($asig['comp_nombre_corto'] ?? 'N/A'); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="ver.php?id=<?php echo $asig['asig_id']; ?>" class="action-btn view-btn" title="Ver detalle">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    <?php if ($rol === 'coordinador'): ?>
                                        <a href="editar.php?id=<?php echo $asig['asig_id']; ?>" class="action-btn edit-btn" title="Editar asignación">
                                            <i data-lucide="pencil-line"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn" title="Eliminar asignación" onclick="confirmDelete(<?php echo $asig['asig_id']; ?>)">
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
                        <i data-lucide="calendar-days"></i>
                    </div>
                    <div class="table-empty-title">No hay asignaciones registradas</div>
                </div>
            <?php
endif; ?>
        </div>

<!-- Delete Confirmation Modal -->
<?php if ($rol === 'coordinador'): ?>
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-body">
            <div class="modal-icon">
                <i data-lucide="alert-triangle"></i>
            </div>
            <h3 class="modal-title">Eliminar Asignación</h3>
            <p class="modal-text">
                ¿Estás seguro de que deseas eliminar la asignación
                <strong id="deleteModalName"></strong>?
            </p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" action="procesar.php" style="flex:1;">
                <input type="hidden" name="asig_id" id="deleteModalId">
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
    function confirmDelete(id) {
        document.getElementById('deleteModalId').value = id;
        document.getElementById('deleteModalName').textContent = '#' + id;
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
<?php
endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
