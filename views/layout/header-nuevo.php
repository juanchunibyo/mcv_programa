<?php
/**
 * Layout Header Creativo — SENA Academic System
 */

$title = $title ?? 'Panel Académico';
$breadcrumb = $breadcrumb ?? [];
$rol = $rol ?? 'instructor';
$currentPage = $_SERVER['REQUEST_URI'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> — SENA</title>
    <link rel="stylesheet" href="/mvccc/mvc_programa/assets/css/nuevo-styles.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

<div class="app-container">
    <!-- Sidebar Vertical Moderno -->
    <aside class="sidebar-modern" id="sidebar">
        <!-- Logo Creativo -->
        <div class="logo-creative">
            <div class="logo-creative-inner">
                <div class="logo-icon-creative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div class="logo-text-creative">
                    <div class="logo-title-creative">SENA</div>
                    <div class="logo-subtitle-creative">Sistema Académico</div>
                </div>
            </div>
        </div>

        <!-- Navegación Creativa -->
        <nav class="nav-creative">
            <!-- Sección Principal -->
            <div class="nav-section-creative">
                <div class="nav-section-title">Principal</div>
                <a href="/mvccc/mvc_programa/" class="nav-link-creative <?php echo($currentPage === '/mvccc/mvc_programa/' || $currentPage === '/mvccc/mvc_programa/index.php') ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Sección Gestión -->
            <div class="nav-section-creative">
                <div class="nav-section-title">Gestión</div>
                
                <a href="/mvccc/mvc_programa/views/instructor/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/instructor/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Instructores
                </a>

                <a href="/mvccc/mvc_programa/views/ficha/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/ficha/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    Fichas
                </a>

                <a href="/mvccc/mvc_programa/views/programa/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/programa/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                    Programas
                </a>

                <a href="/mvccc/mvc_programa/views/asignacion/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/asignacion/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H2v7h7V5z"/>
                        <path d="M9 14H2v5h7v-5z"/>
                        <path d="M22 5h-7v5h7V5z"/>
                        <path d="M22 14h-7v5h7v-5z"/>
                    </svg>
                    Asignaciones
                </a>
            </div>

            <!-- Sección Configuración -->
            <div class="nav-section-creative">
                <div class="nav-section-title">Configuración</div>
                
                <a href="/mvccc/mvc_programa/views/sede/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/sede/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Sedes
                </a>

                <a href="/mvccc/mvc_programa/views/ambiente/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/ambiente/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                    Ambientes
                </a>

                <a href="/mvccc/mvc_programa/views/competencia/index.php" class="nav-link-creative <?php echo(strpos($currentPage, '/competencia/') !== false) ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="7"/>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                    </svg>
                    Competencias
                </a>
            </div>
        </nav>

        <!-- Usuario en Sidebar -->
        <div class="sidebar-user-creative">
            <div class="sidebar-user-inner">
                <div class="user-avatar-creative">
                    <?php echo strtoupper(substr($rol, 0, 1)); ?>
                </div>
                <div class="user-info-creative">
                    <div class="user-name-creative">
                        <?php echo($rol === 'coordinador') ? 'Coordinador' : 'Instructor'; ?>
                    </div>
                    <div class="user-role-creative">
                        <?php echo ucfirst($rol); ?>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="main-creative">
        <?php if (!empty($breadcrumb)): ?>
        <nav class="breadcrumb-creative">
            <?php foreach ($breadcrumb as $i => $item): ?>
                <?php if ($i > 0): ?>
                    <span class="breadcrumb-separator">/</span>
                <?php endif; ?>
                <?php if (isset($item['url'])): ?>
                    <a href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['label']); ?></a>
                <?php else: ?>
                    <span><?php echo htmlspecialchars($item['label']); ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>
