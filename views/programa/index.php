<?php
/**
 * Vista: Listado de Programas
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$programas = $programas ?? [
    ['prog_id' => 1, 'prog_nombre' => 'Análisis y Desarrollo de Software', 'prog_duracion' => '24 meses', 'prog_nivel' => 'Tecnólogo'],
    ['prog_id' => 2, 'prog_nombre' => 'Gestión Administrativa', 'prog_duracion' => '18 meses', 'prog_nivel' => 'Técnico'],
    ['prog_id' => 3, 'prog_nombre' => 'Diseño Gráfico', 'prog_duracion' => '12 meses', 'prog_nivel' => 'Técnico'],
];
$mensaje = $mensaje ?? null;
$error = $error ?? null;
// --- Fin datos de prueba ---

$title = 'Gestión de Programas';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Programas'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <div>
                <h1 class="page-title">Programas</h1>
                <p class="page-subtitle">Gestiona los programas de formación académica</p>
            </div>
            <?php if ($rol === 'coordinador'): ?>
                <a href="crear.php" class="btn btn-primary">
                    <i data-lucide="plus"></i>
                    Nuevo Programa
                </a>
            <?php endif; ?>
        </div>

        <!-- Alerts -->
        <?php if ($mensaje): ?>
            <div class="alert alert-success">
                <i data-lucide="check-circle-2"></i>
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i data-lucide="alert-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Barra de búsqueda y filtros -->
        <div class="table-toolbar">
            <div class="search-box">
                <i data-lucide="search"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o nivel..." onkeyup="filterTable()">
            </div>
            <div class="toolbar-actions">
                <span class="results-count">
                    <i data-lucide="graduation-cap"></i>
                    <span id="resultsCount"><?php echo count($programas); ?></span> programa(s)
                </span>
            </div>
        </div>

        <div class="table-container">
            <?php if (!empty($programas)): ?>
            <div class="table-scroll">
                <table class="data-table" id="programasTable">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nombre del Programa</th>
                            <th style="width: 140px;">Duración</th>
                            <th style="width: 140px;">Nivel</th>
                            <th style="width: 140px; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programas as $prog): ?>
                        <tr>
                            <td>
                                <span class="table-id">#<?php echo htmlspecialchars($prog['prog_id']); ?></span>
                            </td>
                            <td>
                                <div class="program-cell">
                                    <div class="program-icon">
                                        <i data-lucide="graduation-cap"></i>
                                    </div>
                                    <span class="program-name"><?php echo htmlspecialchars($prog['prog_nombre']); ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="duration-badge">
                                    <i data-lucide="clock"></i>
                                    <?php echo htmlspecialchars($prog['prog_duracion']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="level-badge <?php echo strtolower($prog['prog_nivel']); ?>">
                                    <?php echo htmlspecialchars($prog['prog_nivel']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="ver.php?id=<?php echo $prog['prog_id']; ?>" class="action-btn view-btn" title="Ver detalle">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    <?php if ($rol === 'coordinador'): ?>
                                        <a href="editar.php?id=<?php echo $prog['prog_id']; ?>" class="action-btn edit-btn" title="Editar">
                                            <i data-lucide="pencil-line"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn" title="Eliminar" onclick="confirmDelete(<?php echo $prog['prog_id']; ?>, '<?php echo htmlspecialchars(addslashes($prog['prog_nombre']), ENT_QUOTES); ?>')">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="table-empty">
                    <div class="table-empty-icon">
                        <i data-lucide="graduation-cap"></i>
                    </div>
                    <div class="table-empty-title">No hay programas registrados</div>
                    <div class="table-empty-text">
                        <?php if ($rol === 'coordinador'): ?>
                            Haz clic en "Nuevo Programa" para agregar el primero.
                        <?php else: ?>
                            No se encontraron programas en el sistema.
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('programasTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    let visibleCount = 0;

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent || row.innerText;
        
        if (text.toLowerCase().indexOf(filter) > -1) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    }
    
    document.getElementById('resultsCount').textContent = visibleCount;
}
</script>

<!-- Delete Confirmation Modal -->
<?php if ($rol === 'coordinador'): ?>
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-body">
            <div class="modal-icon">
                <i data-lucide="alert-triangle"></i>
            </div>
            <h3 class="modal-title">Eliminar Programa</h3>
            <p class="modal-text">
                ¿Estás seguro de que deseas eliminar el programa
                <strong id="deleteModalName"></strong>?
                Esta acción no se puede deshacer.
            </p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" action="" style="flex:1;">
                <input type="hidden" name="prog_id" id="deleteModalId">
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
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
