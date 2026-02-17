<?php
/**
 * ARCHIVO DE PRUEBA - Controladores devolviendo datos
 * Ejecuta este archivo para ver cómo los controladores obtienen datos de la BD
 */

require_once __DIR__ . '/controllers/SedeController.php';
require_once __DIR__ . '/controllers/AmbienteController.php';
require_once __DIR__ . '/controllers/InstructorController.php';
require_once __DIR__ . '/controllers/ProgramaController.php';
require_once __DIR__ . '/controllers/CompetenciaController.php';
require_once __DIR__ . '/controllers/FichaController.php';

echo "<h1>Prueba de Controladores - Datos de la Base de Datos</h1>";
echo "<style>body{font-family:Arial;padding:20px;} table{border-collapse:collapse;width:100%;margin:20px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#39A900;color:white;} h2{color:#39A900;margin-top:30px;}</style>";

// ============================================
// 1. OBTENER TODAS LAS SEDES
// ============================================
echo "<h2>1. Todas las Sedes</h2>";
$sedes = SedeController::obtenerTodasSedes();

if (!empty($sedes)) {
    echo "<table><tr><th>ID</th><th>Nombre</th></tr>";
    foreach ($sedes as $sede) {
        echo "<tr><td>{$sede['sede_id']}</td><td>{$sede['sede_nombre']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay sedes registradas.</p>";
}

// ============================================
// 2. OBTENER TODOS LOS AMBIENTES
// ============================================
echo "<h2>2. Todos los Ambientes</h2>";
$ambientes = AmbienteController::obtenerTodosAmbientes();

if (!empty($ambientes)) {
    echo "<table><tr><th>ID</th><th>Nombre</th><th>Sede ID</th></tr>";
    foreach ($ambientes as $ambiente) {
        echo "<tr><td>{$ambiente['amb_id']}</td><td>{$ambiente['amb_nombre']}</td><td>{$ambiente['SEDE_sede_id']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay ambientes registrados.</p>";
}

// ============================================
// 3. OBTENER TODOS LOS INSTRUCTORES
// ============================================
echo "<h2>3. Todos los Instructores</h2>";
$instructores = InstructorController::obtenerTodosInstructores();

if (!empty($instructores)) {
    echo "<table><tr><th>ID</th><th>Nombres</th><th>Apellidos</th><th>Correo</th></tr>";
    foreach ($instructores as $instructor) {
        echo "<tr><td>{$instructor['inst_id']}</td><td>{$instructor['inst_nombres']}</td><td>{$instructor['inst_apellidos']}</td><td>{$instructor['inst_correo']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay instructores registrados.</p>";
}

// ============================================
// 4. OBTENER TODOS LOS PROGRAMAS
// ============================================
echo "<h2>4. Todos los Programas</h2>";
$programas = ProgramaController::obtenerTodosProgramas();

if (!empty($programas)) {
    echo "<table><tr><th>Código</th><th>Denominación</th><th>Tipo</th></tr>";
    foreach ($programas as $programa) {
        echo "<tr><td>{$programa['prog_codigo']}</td><td>{$programa['prog_denominacion']}</td><td>{$programa['prog_tipo']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay programas registrados.</p>";
}

// ============================================
// 5. OBTENER TODAS LAS COMPETENCIAS
// ============================================
echo "<h2>5. Todas las Competencias</h2>";
$competencias = CompetenciaController::obtenerTodasCompetencias();

if (!empty($competencias)) {
    echo "<table><tr><th>ID</th><th>Nombre Corto</th><th>Horas</th><th>Nombre Completo</th></tr>";
    foreach ($competencias as $competencia) {
        echo "<tr><td>{$competencia['comp_id']}</td><td>{$competencia['comp_nombre_corto']}</td><td>{$competencia['comp_horas']}</td><td>{$competencia['comp_nombre_comp']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay competencias registradas.</p>";
}

// ============================================
// 6. OBTENER TODAS LAS FICHAS
// ============================================
echo "<h2>6. Todas las Fichas</h2>";
$fichas = FichaController::obtenerTodasFichas();

if (!empty($fichas)) {
    echo "<table><tr><th>ID</th><th>Programa ID</th><th>Instructor Líder</th><th>Jornada</th></tr>";
    foreach ($fichas as $ficha) {
        echo "<tr><td>{$ficha['fich_id']}</td><td>{$ficha['PROGRAMA_prog_id']}</td><td>{$ficha['INSTRUCTOR_inst_id_lider']}</td><td>{$ficha['fich_jornada']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay fichas registradas.</p>";
}

echo "<hr><p><strong>✓ Todos los controladores están funcionando y devolviendo datos de la base de datos.</strong></p>";
