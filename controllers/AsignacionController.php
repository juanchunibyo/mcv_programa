<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/AsignacionModel.php';
require_once __DIR__ . '/../model/DetalleAsignacionModel.php';

class AsignacionController
{
    /**
     * Crear una nueva asignación desde el calendario
     */
    public static function crearAsignacion($datos)
    {
        try {
            $db = Conexion::getConnect();
            $db->beginTransaction();
            
            // Crear la asignación principal
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
                $detalle = new DetalleAsignacionModel(
                    null, // detasig_id (auto-increment)
                    $datos['hora_inicio'],
                    $datos['hora_fin'],
                    $asigId
                );
                $detalle->create();
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
                        c.comp_nombre_corto
                    FROM asignacion a
                    LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
                    LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
                    LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
                    LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
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
