<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/DetalleAsignacionModel.php';

class DetalleAsignacionController
{
    public static function obtenerDetallesPorAsignacion($asigId)
    {
        try {
            $detalle = new DetalleAsignacionModel($asigId, '', '', null);
            return $detalle->read();
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
            $detalle = new DetalleAsignacionModel($datos['asignacion_id'], $datos['hora_inicio'], $datos['hora_fin'], null);
            $detalleId = $detalle->create();
            return ['success' => true, 'detalle_id' => $detalleId, 'message' => 'Detalle de asignación creado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearDetalleAsignacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear el detalle: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarDetalleAsignacion($detalleId, $datos)
    {
        try {
            $detalle = new DetalleAsignacionModel($datos['asignacion_id'], $datos['hora_inicio'], $datos['hora_fin'], $detalleId);
            $detalle->update();
            return ['success' => true, 'message' => 'Detalle actualizado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarDetalleAsignacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el detalle'];
        }
    }
    
    public static function eliminarDetalleAsignacion($detalleId)
    {
        try {
            $detalle = new DetalleAsignacionModel(null, '', '', $detalleId);
            $detalle->delete();
            return ['success' => true, 'message' => 'Detalle eliminado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarDetalleAsignacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar el detalle'];
        }
    }
}
