<?php
require_once __DIR__ . '/../Conexion.php';

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
                        a.asig_id,
                        a.asig_fecha_ini,
                        a.asig_fecha_fin,
                        i.inst_id as instructor_id,
                        i.inst_nombres,
                        i.inst_apellidos,
                        f.fich_id,
                        amb.amb_id,
                        amb.amb_nombre,
                        amb.sede_sede_id as sede_id,
                        s.sede_nombre,
                        c.comp_nombre_corto,
                        da.detasig_id,
                        da.detasig_hora_ini,
                        da.detasig_hora_fin
                    FROM asignacion a
                    LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
                    LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
                    LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
                    LEFT JOIN sede s ON amb.sede_sede_id = s.sede_id
                    LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
                    LEFT JOIN detalle_asignacion da ON a.asig_id = da.asignacion_asig_id";
            
            // Filtrar por mes y año si se proporcionan
            if ($mes !== null && $anio !== null) {
                $sql .= " WHERE EXTRACT(YEAR FROM a.asig_fecha_ini) = :anio 
                         AND EXTRACT(MONTH FROM a.asig_fecha_ini) = :mes";
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
                // Extraer solo la fecha (YYYY-MM-DD) del timestamp
                $fecha = date('Y-m-d', strtotime($asig['asig_fecha_ini']));
                
                if (!isset($calendario[$fecha])) {
                    $calendario[$fecha] = [];
                }
                
                // Formatear horas si existen
                $horaIni = null;
                $horaFin = null;
                if ($asig['detasig_hora_ini']) {
                    $horaIni = date('H:i', strtotime($asig['detasig_hora_ini']));
                }
                if ($asig['detasig_hora_fin']) {
                    $horaFin = date('H:i', strtotime($asig['detasig_hora_fin']));
                }
                
                $calendario[$fecha][] = [
                    'asig_id' => $asig['asig_id'],
                    'instructor' => trim($asig['inst_nombres'] . ' ' . $asig['inst_apellidos']),
                    'instructor_id' => $asig['instructor_id'],
                    'ficha' => $asig['fich_id'],
                    'ambiente' => $asig['amb_nombre'],
                    'ambiente_id' => $asig['amb_id'],
                    'sede_id' => $asig['sede_id'],
                    'sede_nombre' => $asig['sede_nombre'],
                    'competencia' => $asig['comp_nombre_corto'],
                    'hora_ini' => $horaIni,
                    'hora_fin' => $horaFin,
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
                        INNER JOIN ambiente a ON s.sede_id = a.sede_sede_id
                        ORDER BY s.sede_nombre";
            $stmtSedes = $db->query($sqlSedes);
            $sedes = $stmtSedes->fetchAll(PDO::FETCH_ASSOC);
            
            // Obtener fichas activas
            $sqlFichas = "SELECT DISTINCT f.fich_id 
                         FROM ficha f
                         INNER JOIN asignacion a ON f.fich_id = a.ficha_fich_id
                         ORDER BY f.fich_id";
            $stmtFichas = $db->query($sqlFichas);
            $fichas = $stmtFichas->fetchAll(PDO::FETCH_ASSOC);
            
            // Obtener instructores
            $sqlInstructores = "SELECT DISTINCT i.inst_id, i.inst_nombres, i.inst_apellidos
                               FROM instructor i
                               INNER JOIN asignacion a ON i.inst_id = a.instructor_inst_id
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
