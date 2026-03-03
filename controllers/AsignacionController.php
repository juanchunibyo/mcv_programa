<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/AsignacionModel.php';

class AsignacionController
{
    /**
     * Crear una nueva asignación desde el calendario
     */
    public static function crearAsignacion($datos)
    {
        try {
            // 1. CAPA DE VALIDACIÓN DE COHERENCIA (Fechas y Horas Lógicas)
            if (strtotime($datos['fecha_fin']) < strtotime($datos['fecha_inicio'])) {
                return ['success' => false, 'message' => 'La fecha de fin no puede ser menor a la fecha de inicio.'];
            }
            if (!empty($datos['hora_inicio']) && !empty($datos['hora_fin'])) {
                if (strtotime($datos['hora_fin']) <= strtotime($datos['hora_inicio'])) {
                    return ['success' => false, 'message' => 'La hora de fin debe ser estrictamente posterior a la hora de inicio (Ej: 08:00 a 10:00).'];
                }
            } else {
                return ['success' => false, 'message' => 'Se requieren las horas de la asignación. Verifique los campos de hora.'];
            }

            // 2. CAPA DE VALIDACIÓN DE DISPONIBILIDAD (El Cruce de 3 Vías)
            $conflicto = AsignacionModel::verificarConflicto(
                $datos['instructor_id'],
                $datos['ambiente_id'],
                $datos['ficha_id'],
                $datos['fecha_inicio'],
                $datos['fecha_fin'],
                $datos['hora_inicio'],
                $datos['hora_fin']
            );

            if ($conflicto) {
                return ['success' => false, 'message' => $conflicto]; // Corta ejecución y devuelve error.
            }

            $db = Conexion::getConnect();
            $db->beginTransaction();
            
            // 3. Crear la asignación principal
            $asignacion = new AsignacionModel(
                null, // asig_id (auto-increment)
                $datos['instructor_id'],
                $datos['fecha_inicio'],
                $datos['fecha_fin'],
                $datos['ficha_id'],
                $datos['ambiente_id'],
                $datos['competencia_id'] ?? null
            );
            
            $asigId = $asignacion->create();
            
            // Crear el detalle de asignación con horarios
            if (isset($datos['hora_inicio']) && isset($datos['hora_fin'])) {
                $hora_ini_full = '2000-01-01 ' . $datos['hora_inicio'] . ':00';
                $hora_fin_full = '2000-01-01 ' . $datos['hora_fin'] . ':00';

                $sqlDetalle = "INSERT INTO detalle_asignacion (asignacion_asig_id, detasig_hora_ini, detasig_hora_fin) VALUES (:asig, :ini, :fin)";
                $stmtDetalle = $db->prepare($sqlDetalle);
                $stmtDetalle->execute([
                    ':asig' => $asigId,
                    ':ini' => $hora_ini_full,
                    ':fin' => $hora_fin_full
                ]);
            }
            
            $db->commit();
            
            return [
                'success' => true,
                'asig_id' => $asigId,
                'message' => 'Asignación creada exitosamente'
            ];
            
        } catch (Exception $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            error_log("Error en crearAsignacion: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al crear la asignación: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Obtener todas las asignaciones con información completa
     */
    public static function obtenerTodasAsignaciones()
    {
        try {
            $db = Conexion::getConnect();
            
            $sql = "SELECT 
                        a.asig_id,
                        a.asig_fecha_ini,
                        a.asig_fecha_fin,
                        a.ambiente_amb_id,
                        f.fich_id,
                        i.inst_nombres,
                        i.inst_apellidos,
                        amb.amb_nombre,
                        c.comp_nombre_corto,
                        d.detasig_hora_ini,
                        d.detasig_hora_fin
                    FROM asignacion a
                    LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
                    LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
                    LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
                    LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
                    LEFT JOIN detalle_asignacion d ON a.asig_id = d.asignacion_asig_id
                    ORDER BY a.asig_fecha_ini DESC";
            
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en obtenerTodasAsignaciones: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Actualizar una asignación existente
     */
    public static function actualizarAsignacion($asigId, $datos)
    {
        try {
            // 1. CAPA DE VALIDACIÓN DE COHERENCIA
            if (strtotime($datos['fecha_fin']) < strtotime($datos['fecha_inicio'])) {
                return ['success' => false, 'message' => 'La fecha de fin no puede ser menor a la fecha de inicio.'];
            }
            if (!empty($datos['hora_inicio']) && !empty($datos['hora_fin'])) {
                if (strtotime($datos['hora_fin']) <= strtotime($datos['hora_inicio'])) {
                    return ['success' => false, 'message' => 'La hora de fin debe ser posterior a la hora de inicio.'];
                }
            } else {
                return ['success' => false, 'message' => 'Se requieren las horas de la asignación.'];
            }

            // 2. CAPA DE VALIDACIÓN DE DISPONIBILIDAD (Ignorando sí mismo)
            if (isset($datos['hora_inicio']) && isset($datos['hora_fin'])) {
                $conflicto = AsignacionModel::verificarConflicto(
                    $datos['instructor_id'],
                    $datos['ambiente_id'],
                    $datos['ficha_id'],
                    $datos['fecha_inicio'],
                    $datos['fecha_fin'],
                    $datos['hora_inicio'],
                    $datos['hora_fin'],
                    $asigId // Parámetro extra para que no choque consigo mismo al editar
                );

                if ($conflicto) {
                    return ['success' => false, 'message' => $conflicto];
                }
            }

            $db = Conexion::getConnect();
            $db->beginTransaction();
            
            $asignacion = new AsignacionModel(
                $asigId,
                $datos['instructor_id'],
                $datos['fecha_inicio'],
                $datos['fecha_fin'],
                $datos['ficha_id'],
                $datos['ambiente_id'],
                $datos['competencia_id'] ?? null
            );
            $asignacion->update();

            // Actualizar detalle de asignación con horarios
            if (isset($datos['hora_inicio']) && isset($datos['hora_fin'])) {
                $hora_ini_full = '2000-01-01 ' . $datos['hora_inicio'] . ':00';
                $hora_fin_full = '2000-01-01 ' . $datos['hora_fin'] . ':00';

                $stmtCheck = $db->prepare("SELECT detasig_id FROM detalle_asignacion WHERE asignacion_asig_id = :asig_id");
                $stmtCheck->execute([':asig_id' => $asigId]);
                if ($stmtCheck->fetch()) {
                    $stmtUpd = $db->prepare("UPDATE detalle_asignacion SET detasig_hora_ini = :ini, detasig_hora_fin = :fin WHERE asignacion_asig_id = :asig_id");
                    $stmtUpd->execute([':ini' => $hora_ini_full, ':fin' => $hora_fin_full, ':asig_id' => $asigId]);
                } else {
                    $stmtIns = $db->prepare("INSERT INTO detalle_asignacion (asignacion_asig_id, detasig_hora_ini, detasig_hora_fin) VALUES (:asig_id, :ini, :fin)");
                    $stmtIns->execute([':asig_id' => $asigId, ':ini' => $hora_ini_full, ':fin' => $hora_fin_full]);
                }
            }
            
            $db->commit();
            
            return [
                'success' => true,
                'message' => 'Asignación actualizada exitosamente'
            ];
            
        } catch (Exception $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            error_log("Error en actualizarAsignacion: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar la asignación: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Eliminar una asignación
     */
    public static function eliminarAsignacion($asigId)
    {
        try {
            $db = Conexion::getConnect();
            $db->beginTransaction();
            
            // Eliminar detalles primero (para evitar violación de foreign key)
            $sqlDetalle = "DELETE FROM detalle_asignacion WHERE asignacion_asig_id = :asig_id";
            $stmtDetalle = $db->prepare($sqlDetalle);
            $stmtDetalle->execute([':asig_id' => $asigId]);
            
            // Eliminar asignación
            $asignacion = new AsignacionModel($asigId, null, null, null, null, null, null);
            $asignacion->delete();
            
            $db->commit();
            
            return [
                'success' => true,
                'message' => 'Asignación eliminada exitosamente'
            ];
            
        } catch (Exception $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            error_log("Error en eliminarAsignacion: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al eliminar la asignación: ' . $e->getMessage()
            ];
        }
    }
}
