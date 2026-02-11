<?php
/**
 * Vista: Listado de Programas - DISEÑO ÉPICO 🔥
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
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/index-nuevo.php'],
    ['label' => 'Programas'],
];

include __DIR__ . '/../layout/header-nuevo.php';
?>

<div class="page-header-creative">
    <div>
        <h1 class="page-title-creative">PROGRAMAS</h1>
        <p style="color: var(--text-secondary); margin-top: 8px; font-weight: 600;">Gestión de programas académicos</p>
    </div>
    <?php if ($rol === 'coordinador'): ?>
        <a href="crear-nuevo.php" class="btn-creative btn-primary-creative">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nuevo Programa
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

<!-- Grid de Programas -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
    <?php if (!empty($programas)): ?>
        <?php foreach ($programas as $prog): ?>
        <div class="card-creative" style="position: relative;">
            <div style="position: absolute; top: 16px; right: 16px;">
                <span style="padding: 6px 12px; background: rgba(57, 255, 20, 0.15); border: 1px solid var(--neon-green); border-radius: 6px; color: var(--neon-green); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                    <?php echo htmlspecialchars($prog['prog_nivel']); ?>
                </span>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--neon-green), var(--green-primary)); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 30px rgba(57, 255, 20, 0.4); margin-bottom: 16px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#050a14" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                
                <h3 style="font-family: 'Orbitron', sans-serif; font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; line-height: 1.3;">
                    <?php echo htmlspecialchars($prog['prog_nombre']); ?>
                </h3>
                
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cyber-blue)" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span style="color: var(--text-secondary); font-size: 14px; font-weight: 600;">
                            <?php echo htmlspecialchars($prog['prog_duracion']); ?>
                        </span>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(57, 255, 20, 0.1);">
                    <span style="color: var(--neon-green); font-family: 'Orbitron', sans-serif; font-weight: 700; font-size: 14px;">
                        ID: #<?php echo htmlspecialchars($prog['prog_id']); ?>
                    </span>
                </div>
            </div>
            
            <div style="display: flex; gap: 8px; margin-top: 16px;">
                <a href="ver-nuevo.php?id=<?php echo $prog['prog_id']; ?>" 
                   style="flex: 1; padding: 10px; background: rgba(0, 217, 255, 0.1); border: 1px solid rgba(0, 217, 255, 0.3); border-radius: 8px; color: var(--cyber-blue); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 13px; font-weight: 700; transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px;"
                   onmouseover="this.style.background='rgba(0, 217, 255, 0.2)'; this.style.boxShadow='0 0 20px rgba(0, 217, 255, 0.4)';"
                   onmouseout="this.style.background='rgba(0, 217, 255, 0.1)'; this.style.boxShadow='none';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    Ver
                </a>
                <?php if ($rol === 'coordinador'): ?>
                    <a href="editar-nuevo.php?id=<?php echo $prog['prog_id']; ?>" 
                       style="flex: 1; padding: 10px; background: rgba(57, 255, 20, 0.1); border: 1px solid rgba(57, 255, 20, 0.3); border-radius: 8px; color: var(--neon-green); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 13px; font-weight: 700; transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px;"
                       onmouseover="this.style.background='rgba(57, 255, 20, 0.2)'; this.style.boxShadow='0 0 20px rgba(57, 255, 20, 0.4)';"
                       onmouseout="this.style.background='rgba(57, 255, 20, 0.1)'; this.style.boxShadow='none';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1;">
            <div class="card-creative" style="text-align: center; padding: 60px 20px;">
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: rgba(57, 255, 20, 0.1); border: 2px solid var(--border-glow); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--neon-green)" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <h3 style="font-family: 'Orbitron', sans-serif; font-size: 18px; font-weight: 700; color: var(--neon-green); margin-bottom: 8px;">
                    NO HAY PROGRAMAS
                </h3>
                <p style="color: var(--text-secondary); font-size: 14px;">
                    <?php if ($rol === 'coordinador'): ?>
                        Haz clic en "Nuevo Programa" para agregar el primero.
                    <?php else: ?>
                        No se encontraron programas en el sistema.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer-nuevo.php'; ?>
