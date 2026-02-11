<?php
/**
 * Vista: Listado de Instructores - DISEÑO ÉPICO 🔥
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$instructores = $instructores ?? [
    ['inst_id' => 1, 'inst_nombre' => 'Juan', 'inst_apellidos' => 'Pérez', 'inst_correo' => 'juan@sena.edu.co', 'inst_telefono' => '3001234567'],
    ['inst_id' => 2, 'inst_nombre' => 'María', 'inst_apellidos' => 'Gómez', 'inst_correo' => 'maria@sena.edu.co', 'inst_telefono' => '3109876543'],
];
$mensaje = $mensaje ?? null;
$error = $error ?? null;
// --- Fin datos de prueba ---

$title = 'Gestión de Instructores';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/index-nuevo.php'],
    ['label' => 'Instructores'],
];

include __DIR__ . '/../layout/header-nuevo.php';
?>

<div class="page-header-creative">
    <div>
        <h1 class="page-title-creative">INSTRUCTORES</h1>
        <p style="color: var(--text-secondary); margin-top: 8px; font-weight: 600;">Gestión de instructores del sistema</p>
    </div>
    <?php if ($rol === 'coordinador'): ?>
        <a href="crear-nuevo.php" class="btn-creative btn-primary-creative">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nuevo Instructor
        </a>
    <?php endif; ?>
</div>

<!-- Alerts -->
<?php if ($mensaje): ?>
    <div class="alert-creative alert-success-creative">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert-creative alert-error-creative">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="table-creative">
    <?php if (!empty($instructores)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE COMPLETO</th>
                <th>CORREO</th>
                <th>TELÉFONO</th>
                <th style="text-align: center;">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instructores as $inst): ?>
            <tr>
                <td>
                    <span style="color: var(--neon-green); font-weight: 700; font-family: 'Orbitron', sans-serif;">
                        #<?php echo htmlspecialchars($inst['inst_id']); ?>
                    </span>
                </td>
                <td style="font-weight: 600;">
                    <?php echo htmlspecialchars($inst['inst_nombre'] . ' ' . $inst['inst_apellidos']); ?>
                </td>
                <td style="color: var(--cyber-blue);">
                    <?php echo htmlspecialchars($inst['inst_correo']); ?>
                </td>
                <td><?php echo htmlspecialchars($inst['inst_telefono']); ?></td>
                <td>
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <a href="ver-nuevo.php?id=<?php echo $inst['inst_id']; ?>" 
                           style="padding: 8px 12px; background: rgba(0, 217, 255, 0.1); border: 1px solid rgba(0, 217, 255, 0.3); border-radius: 6px; color: var(--cyber-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; transition: all 0.3s;"
                           onmouseover="this.style.background='rgba(0, 217, 255, 0.2)'; this.style.boxShadow='0 0 15px rgba(0, 217, 255, 0.4)';"
                           onmouseout="this.style.background='rgba(0, 217, 255, 0.1)'; this.style.boxShadow='none';"
                           title="Ver detalle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Ver
                        </a>
                        <?php if ($rol === 'coordinador'): ?>
                            <a href="editar-nuevo.php?id=<?php echo $inst['inst_id']; ?>" 
                               style="padding: 8px 12px; background: rgba(57, 255, 20, 0.1); border: 1px solid rgba(57, 255, 20, 0.3); border-radius: 6px; color: var(--neon-green); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; transition: all 0.3s;"
                               onmouseover="this.style.background='rgba(57, 255, 20, 0.2)'; this.style.boxShadow='0 0 15px rgba(57, 255, 20, 0.4)';"
                               onmouseout="this.style.background='rgba(57, 255, 20, 0.1)'; this.style.boxShadow='none';"
                               title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Editar
                            </a>
                            <button type="button" 
                                    onclick="confirmDelete(<?php echo $inst['inst_id']; ?>, '<?php echo htmlspecialchars(addslashes($inst['inst_nombre'] . ' ' . $inst['inst_apellidos']), ENT_QUOTES); ?>')"
                                    style="padding: 8px 12px; background: rgba(255, 20, 57, 0.1); border: 1px solid rgba(255, 20, 57, 0.3); border-radius: 6px; color: #ff6b85; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; transition: all 0.3s;"
                                    onmouseover="this.style.background='rgba(255, 20, 57, 0.2)'; this.style.boxShadow='0 0 15px rgba(255, 20, 57, 0.4)';"
                                    onmouseout="this.style.background='rgba(255, 20, 57, 0.1)'; this.style.boxShadow='none';"
                                    title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                                Eliminar
                            </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div style="text-align: center; padding: 60px 20px;">
            <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: rgba(57, 255, 20, 0.1); border: 2px solid var(--border-glow); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--neon-green)" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h3 style="font-family: 'Orbitron', sans-serif; font-size: 18px; font-weight: 700; color: var(--neon-green); margin-bottom: 8px;">
                NO HAY INSTRUCTORES
            </h3>
            <p style="color: var(--text-secondary); font-size: 14px;">
                <?php if ($rol === 'coordinador'): ?>
                    Haz clic en "Nuevo Instructor" para agregar el primero.
                <?php else: ?>
                    No se encontraron instructores en el sistema.
                <?php endif; ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de Confirmación -->
<?php if ($rol === 'coordinador'): ?>
<div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(10px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: rgba(13, 21, 32, 0.95); border: 2px solid var(--border-glow); border-radius: 16px; max-width: 500px; width: 100%; box-shadow: 0 0 50px rgba(57, 255, 20, 0.3); animation: modalIn 0.3s ease;">
        <div style="padding: 32px; text-align: center;">
            <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: rgba(255, 20, 57, 0.1); border: 2px solid #ff1439; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ff6b85" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <h3 style="font-family: 'Orbitron', sans-serif; font-size: 20px; font-weight: 700; color: #ff6b85; margin-bottom: 12px;">
                ELIMINAR INSTRUCTOR
            </h3>
            <p style="color: var(--text-secondary); font-size: 15px; margin-bottom: 8px;">
                ¿Estás seguro de que deseas eliminar a
            </p>
            <p style="color: var(--neon-green); font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                <span id="deleteModalName"></span>?
            </p>
            <p style="color: var(--text-secondary); font-size: 13px;">
                Esta acción no se puede deshacer.
            </p>
        </div>
        <div style="display: flex; gap: 12px; padding: 0 32px 32px;">
            <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 14px 28px; border-radius: 8px; font-family: 'Orbitron', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; border: 2px solid rgba(139, 157, 195, 0.4); background: rgba(139, 157, 195, 0.15); color: var(--text-primary); text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s; box-shadow: 0 0 15px rgba(139, 157, 195, 0.2);">
                Cancelar
            </button>
            <form id="deleteForm" method="POST" action="" style="flex: 1;">
                <input type="hidden" name="inst_id" id="deleteModalId">
                <input type="hidden" name="action" value="delete">
                <button type="submit" style="width: 100%; padding: 14px 28px; border-radius: 8px; font-family: 'Orbitron', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; border: 2px solid #ff1439; background: rgba(255, 20, 57, 0.2); color: #ff6b85; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s; box-shadow: 0 0 20px rgba(255, 20, 57, 0.3);">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<script>
    function confirmDelete(id, nombre) {
        document.getElementById('deleteModalId').value = id;
        document.getElementById('deleteModalName').textContent = nombre;
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer-nuevo.php'; ?>
