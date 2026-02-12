<?php
/**
 * Vista: Listado de Fichas (index.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$fichas = $fichas ?? [
    ['fich_id' => '228106-1', 'prog_denominacion' => 'Análisis y Desarrollo de Software', 'instructor_nombre' => 'Juan Pérez', 'fich_jornada' => 'Diurna'],
    ['fich_id' => '233104-2', 'prog_denominacion' => 'Gestión Contable', 'instructor_nombre' => 'María Gómez', 'fich_jornada' => 'Mixta'],
];
$mensaje = $mensaje ?? null;
$error = $error ?? null;
// --- Fin datos de prueba ---

$title = 'Gestión de Fichas';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Fichas'],
];

include __DIR__ . '/../layout/header.php';
?>

        <div class="page-header">
            <div>
                <h1 class="page-title">Fichas de Caracterización</h1>
                <p class="page-subtitle">Gestiona las fichas de formación y sus grupos</p>
            </div>
            <?php if ($rol === 'coordinador'): ?>
                <a href="crear.php" class="btn btn-primary">
                    <i data-lucide="plus"></i>
                    Registrar Ficha
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
                <input type="text" id="searchInput" placeholder="Buscar por ID, programa o instructor..." onkeyup="filterTable()">
            </div>
            <div class="toolbar-actions">
                <span class="results-count">
                    <i data-lucide="book-open"></i>
                    <span id="resultsCount"><?php echo count($fichas); ?></span> ficha(s)
                </span>
            </div>
        </div>

        <div class="table-container">
            <?php if (!empty($fichas)): ?>
            <div class="table-scroll">
                <table class="data-table" id="fichasTable">
                    <thead>
                        <tr>
                            <th style="width: 140px;">ID Ficha</th>
                            <th>Programa</th>
                            <th style="width: 200px;">Instructor Líder</th>
                            <th style="width: 120px;">Jornada</th>
                            <th style="width: 140px; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fichas as $ficha): ?>
                        <tr>
                            <td>
                                <span class="ficha-id"><?php echo htmlspecialchars($ficha['fich_id']); ?></span>
                            </td>
                            <td>
                                <div class="program-cell">
                                    <div class="program-icon">
                                        <i data-lucide="book-open"></i>
                                    </div>
                                    <span class="program-name"><?php echo htmlspecialchars($ficha['prog_denominacion']); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="instructor-cell">
                                    <i data-lucide="user"></i>
                                    <?php echo htmlspecialchars($ficha['instructor_nombre']); ?>
                                </div>
                            </td>
                            <td>
                                <span class="jornada-badge <?php echo strtolower($ficha['fich_jornada']); ?>">
                                    <?php echo htmlspecialchars($ficha['fich_jornada']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="ver.php?id=<?php echo $ficha['fich_id']; ?>" class="action-btn view-btn" title="Ver detalle">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    <?php if ($rol === 'coordinador'): ?>
                                        <a href="editar.php?id=<?php echo $ficha['fich_id']; ?>" class="action-btn edit-btn" title="Editar">
                                            <i data-lucide="pencil-line"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn" title="Eliminar" onclick="confirmDelete('<?php echo $ficha['fich_id']; ?>', '<?php echo htmlspecialchars(addslashes($ficha['fich_id']), ENT_QUOTES); ?>')">
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
                        <i data-lucide="book-open"></i>
                    </div>
                    <div class="table-empty-title">No hay fichas registradas</div>
                    <div class="table-empty-text">
                        <?php if ($rol === 'coordinador'): ?>
                            Haz clic en "Registrar Ficha" para agregar la primera.
                        <?php else: ?>
                            No se encontraron fichas en el sistema.
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('fichasTable');
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
            <h3 class="modal-title">Eliminar Ficha</h3>
            <p class="modal-text">
                ¿Estás seguro de que deseas eliminar la ficha
                <strong id="deleteModalName"></strong>?
                Esta acción no se puede deshacer.
            </p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" action="" style="flex:1;">
                <input type="hidden" name="fich_id" id="deleteModalId">
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
