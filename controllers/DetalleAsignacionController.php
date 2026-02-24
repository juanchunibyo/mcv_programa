<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/DetalleAsignacionModel.php';

class DetalleAsignacionController
{
    public static function obtenerDetalle($detalleId)
    {
        try {
            $detalle = new DetalleAsignacionModel(null, '', '', $detalleId);
            $resultado = $detalle->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerDetalle: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerDetallesPorAsignacion($asigId)
    {
        try {
            $db = Conexion::getConnect();
            $sql = "SELECT * FROM detalle_asignacion WHERE asignacion_asig_id = :asig_id ORDER BY detasig_hora_ini";
            $stmt = $db->prepare($sql);
            $stmt->execute([':asig_id' => $asigId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en obtenerDetallesPorAsignacion: " . $e->getMessage());
            return [];
        }
    }
    
    public static function obtenerTodosDetalles()
    {
        try {
            $detalle = new DetalleAsignacionModel(null, '', '', null);
            return $detalle->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodosDetalles: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearDetalleAsignacion($datos)
    {
        try {
            $detalle = new DetalleAsignacionModel(
                $datos['asignacion_id'], 
                $datos['hora_inicio'], 
                $datos['hora_fin'], 
                null
            );
            $detalleId = $detalle->create();
            return ['success' => true, 'detalle_id' => $detalleId, 'message' => 'Horario creado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearDetalleAsignacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear el horario: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarDetalleAsignacion($detalleId, $datos)
    {
        try {
            $detalle = new DetalleAsignacionModel(
                $datos['asignacion_id'], 
                $datos['hora_inicio'], 
                $datos['hora_fin'], 
                $detalleId
            );
            $detalle->update();
            return ['success' => true, 'message' => 'Horario actualizado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarDetalleAsignacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el horario: ' . $e->getMessage()];
        }
    }
    
    public static function eliminarDetalleAsignacion($detalleId)
    {
        try {
            $detalle = new DetalleAsignacionModel(null, '', '', $detalleId);
            $detalle->delete();
            return ['success' => true, 'message' => 'Horario eliminado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarDetalleAsignacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar el horario: ' . $e->getMessage()];
        }
    }
}
