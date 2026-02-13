<?php
/**
 * Layout Header — SENA Academic System
 *
 * Variables expected:
 *   $title       — Page title (e.g. "Gestión de Sedes")
 *   $breadcrumb  — Array of breadcrumb items: [['label' => 'Inicio', 'url' => '/'], ...]
 *   $rol         — User role: 'coordinador' | 'instructor'
 */

$title = $title ?? 'Panel Académico';
$breadcrumb = $breadcrumb ?? [];
$rol = $rol ?? 'instructor';

// Detectar la sección actual para aplicar fondos específicos
$currentSection = '';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if (strpos($requestUri, '/sede/') !== false) {
    $currentSection = 'sede';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> — SENA</title>
    <link rel="stylesheet" href="/mvccc/mvc_programa/assets/css/styles.css?v=99">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        // FORZAR MODO CLARO - Eliminar tema oscuro
        localStorage.removeItem('theme');
        document.documentElement.removeAttribute('data-theme');
    </script>
</head>
<body class="<?php echo $currentSection ? 'section-' . $currentSection : ''; ?>">

<!-- Mobile sidebar toggle -->
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menú">
    <i data-lucide="menu"></i>
</button>

<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="app-layout">
    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="/mvccc/mvc_programa/" class="sidebar-logo" style="text-decoration: none; color: inherit; cursor: pointer;">
                <img src="https://bogota.gov.co/sites/default/files/inline-images/logosena.png" alt="Logo SENA" style="width: 50px; height: 50px; object-fit: contain;">
                <div>
                    <div class="sidebar-logo-text">SENA</div>
                    <div class="sidebar-logo-subtitle">Sistema Académico</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-title">Principal</div>
            <a href="/mvccc/mvc_programa/" class="sidebar-link">
                <i data-lucide="layout-dashboard"></i>
                Inicio
            </a>
            <a href="/mvccc/mvc_programa/views/calendario/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/calendario/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="calendar"></i>
                Calendario
            </a>

            <div class="sidebar-section-title">Módulos</div>
            <a href="/mvccc/mvc_programa/views/sede/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/sede/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="building-2"></i>
                Sedes
            </a>
            <a href="/mvccc/mvc_programa/views/ambiente/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/ambiente/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="monitor"></i>
                Ambientes
            </a>
            <a href="/mvccc/mvc_programa/views/programa/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/programa/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="graduation-cap"></i>
                Programas
            </a>
            <a href="/mvccc/mvc_programa/views/ficha/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/ficha/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="book-open"></i>
                Fichas
            </a>
            <a href="/mvccc/mvc_programa/views/instructor/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/instructor/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="users"></i>
                Instructores
            </a>
            <a href="/mvccc/mvc_programa/views/asignacion/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/asignacion/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="clipboard-list"></i>
                Asignaciones
            </a>
            <a href="/mvccc/mvc_programa/views/detalle_asignacion/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/detalle_asignacion/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="clock"></i>
                Detalles Asign.
            </a>
            <a href="/mvccc/mvc_programa/views/competencia/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/competencia/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="award"></i>
                Competencias
            </a>
            <a href="/mvccc/mvc_programa/views/competencia_programa/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/competencia_programa/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="link"></i>
                Comp. x Prog.
            </a>
            <a href="/mvccc/mvc_programa/views/titulo_programa/index.php" class="sidebar-link <?php echo(strpos($_SERVER['REQUEST_URI'] ?? '', '/titulo_programa/') !== false) ? 'active' : ''; ?>">
                <i data-lucide="scroll"></i>
                Títulos
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar" style="background: none; padding: 0;">
                    <img src="https://ui-avatars.com/api/?name=Juan+Diego+Rubio&background=39A900&color=fff&size=128" alt="Juan Diego Rubio" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        Juan Diego Rubio
                    </div>
                    <div class="sidebar-user-role">
                        <?php echo($rol === 'coordinador') ? 'Coordinador Académico' : 'Instructor'; ?>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <?php if (!empty($breadcrumb)): ?>
        <nav class="breadcrumb">
            <?php foreach ($breadcrumb as $i => $item): ?>
                <?php if ($i > 0): ?>
                    <span class="breadcrumb-separator">/</span>
                <?php
        endif; ?>
                <?php if (isset($item['url'])): ?>
                    <a href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['label']); ?></a>
                <?php
        else: ?>
                    <span class="breadcrumb-current"><?php echo htmlspecialchars($item['label']); ?></span>
                <?php
        endif; ?>
            <?php
    endforeach; ?>
        </nav>
        <?php
endif; ?>
