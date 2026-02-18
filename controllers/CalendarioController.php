<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/AsignacionModel.php';
require_once __DIR__ . '/../model/DetalleAsignacionModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/FichaModel.php';
require_once __DIR__ . '/../model/AmbienteModel.php';
require_once __DIR__ . '/../model/CompetenciaModel.php';

class CalendarioController
{
    /**
     * Obtiene asignaciones por mes para el calendario
     */
    public static function obtenerAsignacionesPorMes($mes, $anio)
    {
        try {
            return self::getAsignacionesCalendario($mes, $anio);
        } catch (Exception $e) {
            error_log("Error en obtenerAsignacionesPorMes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene todas las asignaciones con sus detalles para el calendario
     */
    public static function getAsignacionesCalendario($mes = null, $anio = null)
    {
        try {
            $db = Conexion::getConnect();
            
            // Query para obtener asignaciones con todos los datos relacionados
            $sql = "SELECT 
                        a.ASIG_ID,
                        a.asig_fecha_ini,
                        a.asig_fecha_fin,
                        i.inst_nombres,
                        i.inst_apellidos,
                        f.fich_id,
                        amb.amb_nombre,
                        c.comp_nombre_comp,
                        da.detasig_id,
                        da.detasig_hora_ini,
                        da.detasig_hora_fin
                    FROM asignacion a
                    LEFT JOIN instructor i ON a.INSTRUCTOR_inst_id = i.inst_id
                    LEFT JOIN ficha f ON a.FICHA_fich_id = f.fich_id
                    LEFT JOIN ambiente amb ON a.AMBIENTE_amb_id = amb.amb_id
                    LEFT JOIN competencia c ON a.COMPETENCIA_comp_id = c.comp_id
                    LEFT JOIN detallexasgnacion da ON a.ASIG_ID = da.ASIGNACION_asig_id";
            
            // Filtrar por mes y año si se proporcionan
            if ($mes !== null && $anio !== null) {
                $sql .= " WHERE YEAR(a.asig_fecha_ini) = :anio 
                         AND MONTH(a.asig_fecha_ini) = :mes";
            }
            
            $sql .= " ORDER BY a.asig_fecha_ini, da.detasig_hora_ini";
            
            $stmt = $db->prepare($sql);
            
            if ($mes !== null && $anio !== null) {
                $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
                $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Organizar por fecha
            $calendario = [];
            foreach ($asignaciones as $asig) {
                $fecha = $asig['asig_fecha_ini'];
                
                if (!isset($calendario[$fecha])) {
                    $calendario[$fecha] = [];
                }
                
                $calendario[$fecha][] = [
                    'asig_id' => $asig['ASIG_ID'],
                    'instructor' => $asig['inst_nombres'] . ' ' . $asig['inst_apellidos'],
                    'ficha' => $asig['fich_id'],
                    'ambiente' => $asig['amb_nombre'],
                    'competencia' => $asig['comp_nombre_comp'],
                    'hora_ini' => $asig['detasig_hora_ini'],
                    'hora_fin' => $asig['detasig_hora_fin'],
                    'detalle_id' => $asig['detasig_id']
                ];
            }
            
            return $calendario;
            
        } catch (PDOException $e) {
            error_log("Error en getAsignacionesCalendario: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtiene los datos para los filtros del calendario
     */
    public static function getFiltrosData()
    {
        try {
            $db = Conexion::getConnect();
            
            // Obtener sedes
            $sqlSedes = "SELECT DISTINCT s.sede_id, s.sede_nombre 
                        FROM sede s
                        INNER JOIN ambiente a ON s.sede_id = a.SEDE_sede_id
                        ORDER BY s.sede_nombre";
            $stmtSedes = $db->query($sqlSedes);
            $sedes = $stmtSedes->fetchAll(PDO::FETCH_ASSOC);
            
            // Obtener fichas activas
            $sqlFichas = "SELECT DISTINCT f.fich_id 
                         FROM ficha f
                         INNER JOIN asignacion a ON f.fich_id = a.FICHA_fich_id
                         ORDER BY f.fich_id";
            $stmtFichas = $db->query($sqlFichas);
            $fichas = $stmtFichas->fetchAll(PDO::FETCH_ASSOC);
            
            // Obtener instructores
            $sqlInstructores = "SELECT DISTINCT i.inst_id, i.inst_nombres, i.inst_apellidos
                               FROM instructor i
                               INNER JOIN asignacion a ON i.inst_id = a.INSTRUCTOR_inst_id
                               ORDER BY i.inst_apellidos, i.inst_nombres";
            $stmtInstructores = $db->query($sqlInstructores);
            $instructores = $stmtInstructores->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'sedes' => $sedes,
                'fichas' => $fichas,
                'instructores' => $instructores
            ];
            
        } catch (PDOException $e) {
            error_log("Error en getFiltrosData: " . $e->getMessage());
            return [
                'sedes' => [],
                'fichas' => [],
                'instructores' => []
            ];
        }
    }
}
