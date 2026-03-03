<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/CoordinacionModel.php';

class CoordinacionController
{
    public static function obtenerCoordinacion($coordId)
    {
        try {
            $coord = new CoordinacionModel($coordId, '', '');
            $resultado = $coord->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerCoordinacion: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerTodasCoordinaciones()
    {
        try {
            $coord = new CoordinacionModel(null, '', null);
            return $coord->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodasCoordinaciones: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearCoordinacion($datos)
    {
        try {
            $coord = new CoordinacionModel(null, $datos['coord_nombre'], $datos['centro_formacion_cent_id']);
            $coordId = $coord->create();
            return ['success' => true, 'coord_id' => $coordId, 'message' => 'Coordinación creada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearCoordinacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear la coordinación: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarCoordinacion($coordId, $datos)
    {
        try {
            // Asumiendo que el modelo maneja la actualización
            $coord = new CoordinacionModel($coordId, $datos['coord_nombre'], $datos['centro_formacion_cent_id'] ?? null); // Update might not change center
            $coord->update();
            return ['success' => true, 'message' => 'Coordinación actualizada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarCoordinacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar la coordinación: ' . $e->getMessage()];
        }
    }
    
    public static function eliminarCoordinacion($coordId)
    {
        try {
            $coord = new CoordinacionModel($coordId, '', null);
            $coord->delete();
            return ['success' => true, 'message' => 'Coordinación eliminada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarCoordinacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar la coordinación: ' . $e->getMessage()];
        }
    }
}
