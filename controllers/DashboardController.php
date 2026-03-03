<?php

require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/CalendarioController.php';
require_once __DIR__ . '/SedeController.php';
require_once __DIR__ . '/FichaController.php';
require_once __DIR__ . '/InstructorController.php';
require_once __DIR__ . '/AmbienteController.php';
require_once __DIR__ . '/CompetenciaController.php';

class DashboardController
{
    public function index()
    {
        $db = Conexion::getConnect();

        $countInstructores = $db->query("SELECT COUNT(*) FROM instructor")->fetchColumn();
        $countFichas = $db->query("SELECT COUNT(*) FROM ficha")->fetchColumn();
        $countProgramas = $db->query("SELECT COUNT(*) FROM programa")->fetchColumn();
        $countAsignaciones = $db->query("SELECT COUNT(*) FROM asignacion")->fetchColumn();
        // Nuevos conteos para centro de formación
        $countSedes = $db->query("SELECT COUNT(*) FROM sede")->fetchColumn();
        $countAmbientes = $db->query("SELECT COUNT(*) FROM ambiente")->fetchColumn();

        // Estadísticas específicas para el Instructor
        $usuario_rol = $_SESSION['usuario_rol'] ?? '';
        $instructor_id = $_SESSION['instructor_id'] ?? null;
        
        $misFichasCount = 0;
        $misAsignacionesCount = 0;

        if ($usuario_rol === 'instructor' && $instructor_id) {
            $stmtFichas = $db->prepare("SELECT COUNT(DISTINCT ficha_fich_id) FROM asignacion WHERE instructor_inst_id = ?");
            $stmtFichas->execute([$instructor_id]);
            $misFichasCount = $stmtFichas->fetchColumn();

            $stmtAsig = $db->prepare("SELECT COUNT(*) FROM asignacion WHERE instructor_inst_id = ?");
            $stmtAsig->execute([$instructor_id]);
            $misAsignacionesCount = $stmtAsig->fetchColumn();
        }

        // Datos para el calendario en el Dashboard
        $mesActual = date('n');
        $anioActual = date('Y');
        $asignaciones = CalendarioController::obtenerAsignacionesPorMes($mesActual, $anioActual);
        
        $filtros = [
            'sedes' => SedeController::obtenerTodasSedes(),
            'fichas' => FichaController::obtenerTodasFichas(),
            'instructores' => InstructorController::obtenerTodosInstructores()
        ];
        
        $sedesForm = SedeController::obtenerTodasSedes();
        $fichas = FichaController::obtenerTodasFichas();
        $instructores = InstructorController::obtenerTodosInstructores();
        $ambientes = AmbienteController::obtenerTodosAmbientes();
        $competencias = CompetenciaController::obtenerTodasCompetencias();

        if (empty($sedesForm)) {
            $sedesForm = [['sede_id' => 1, 'sede_nombre' => 'Principal'], ['sede_id' => 2, 'sede_nombre' => 'Norte']];
        }
        if (empty($fichas)) {
            $fichas = [['fich_id' => '2758392'], ['fich_id' => '2758393'], ['fich_id' => '2758394']];
        }
        if (empty($instructores)) {
            $instructores = [
                ['inst_id' => 1, 'inst_nombres' => 'Juan', 'inst_apellidos' => 'Pérez'],
                ['inst_id' => 2, 'inst_nombres' => 'María', 'inst_apellidos' => 'García'],
                ['inst_id' => 3, 'inst_nombres' => 'Carlos', 'inst_apellidos' => 'López']
            ];
        }
        if (empty($ambientes)) {
            $ambientes = [
                ['amb_id' => 1, 'amb_nombre' => 'Laboratorio 101'],
                ['amb_id' => 2, 'amb_nombre' => 'Aula 202'],
                ['amb_id' => 3, 'amb_nombre' => 'Sala 303']
            ];
        }
        if (empty($competencias)) {
            $competencias = [
                ['comp_id' => 1, 'comp_nombre_corto' => 'Programación'],
                ['comp_id' => 2, 'comp_nombre_corto' => 'Bases de Datos']
            ];
        }

        // Require the view file for the dashboard
        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
