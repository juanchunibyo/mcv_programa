<?php
/**
 * Vista: Listado de Ambientes (index.php)
 */

require_once __DIR__ . '/../../controllers/AmbienteController.php';
require_once __DIR__ . '/../../controllers/SedeController.php';

session_start();

// Obtener datos reales de la base de datos
$rol = $rol ?? 'coordinador';
$ambientesDB = AmbienteController::obtenerTodosAmbientes();
$sedes = SedeController::obtenerTodasSedes();

// Crear un mapa de sedes para búsqueda rápida
$sedesMap = [];
foreach ($sedes as $sede) {
    $sedesMap[$sede['sede_id']] = $sede['sede_nombre'];
}

// Agregar nombre de sede a cada ambiente
$ambientes = [];
foreach ($ambientesDB as $amb) {
    // Manejar diferentes nombres de columna (mayúsculas/minúsculas)
    $sedeId = $amb['SEDE_sede_id'] ?? $amb['sede_sede_id'] ?? null;
    
    $ambientes[] = [
        'amb_id' => $amb['amb_id'],
        'amb_nombre' => $amb['amb_nombre'],
        'sede_nombre' => $sedeId ? ($sedesMap[$sedeId] ?? 'Sin sede') : 'Sin sede'
    ];
}

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

$title = 'Gestión de Ambientes';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Ambientes'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Ambientes</h1>
            <?php if ($rol === 'coordinador'): ?>
                <a href="crear.php" class="btn btn-primary">
                    <i data-lucide="plus"></i>
                    Registrar Ambiente
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

        <div class="table-container">
            <?php if (!empty($ambientes)): ?>
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Ambiente</th>
                            <th>Sede</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ambientes as $amb): ?>
                        <tr>
                            <td><span class="table-id"><?php echo htmlspecialchars($amb['amb_id']); ?></span></td>
                            <td><?php echo htmlspecialchars($amb['amb_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($amb['sede_nombre']); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="ver.php?id=<?php echo $amb['amb_id']; ?>" class="action-btn view-btn" title="Ver detalle">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    <?php if ($rol === 'coordinador'): ?>
                                        <a href="editar.php?id=<?php echo $amb['amb_id']; ?>" class="action-btn edit-btn" title="Editar ambiente">
                                            <i data-lucide="pencil-line"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn" title="Eliminar ambiente" onclick="confirmDelete(<?php echo $amb['amb_id']; ?>, '<?php echo htmlspecialchars(addslashes($amb['amb_nombre']), ENT_QUOTES); ?>')">
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
                        <i data-lucide="monitor"></i>
                    </div>
                    <div class="table-empty-title">No hay ambientes registrados</div>
                    <div class="table-empty-text">
                        <?php if ($rol === 'coordinador'): ?>
                            Haz clic en "Registrar Ambiente" para agregar el primero.
                        <?php
    else: ?>
                            No se encontraron ambientes en el sistema.
                        <?php
    endif; ?>
                    </div>
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
            <h3 class="modal-title">Eliminar Ambiente</h3>
            <p class="modal-text">
                ¿Estás seguro de que deseas eliminar el ambiente
                <strong id="deleteModalName"></strong>?
                Esta acción no se puede deshacer.
            </p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" action="procesar.php" style="flex:1;">
                <input type="hidden" name="amb_id" id="deleteModalId">
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
