<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/SedeModel.php';

class SedeController
{
    public static function obtenerSede($sedeId)
    {
        try {
            $sede = new SedeModel($sedeId, '');
            $resultado = $sede->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerSede: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerTodasSedes()
    {
        try {
            $sede = new SedeModel(null, '');
            return $sede->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodasSedes: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearSede($datos)
    {
        try {
            $sede = new SedeModel(null, $datos['sede_nombre']);
            $sedeId = $sede->create();
            return ['success' => true, 'sede_id' => $sedeId, 'message' => 'Sede creada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearSede: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear la sede: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarSede($sedeId, $datos)
    {
        try {
            $sede = new SedeModel($sedeId, $datos['sede_nombre']);
            $sede->update();
            return ['success' => true, 'message' => 'Sede actualizada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarSede: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar la sede'];
        }
    }
    
    public static function eliminarSede($sedeId)
    {
        try {
            $sede = new SedeModel($sedeId, '');
            $sede->delete();
            return ['success' => true, 'message' => 'Sede eliminada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarSede: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar la sede: ' . $e->getMessage()];
        }
    }
}
