<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/CentroFormacionModel.php';

class CentroFormacionController
{
    public static function obtenerCentroFormacion($centId)
    {
        try {
            $centro = new CentroFormacionModel($centId, '');
            $resultado = $centro->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerCentroFormacion: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerTodosCentros()
    {
        try {
            $centro = new CentroFormacionModel(null, '');
            return $centro->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodosCentros: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearCentroFormacion($datos)
    {
        try {
            $centro = new CentroFormacionModel(null, $datos['cent_nombre']);
            $centId = $centro->create();
            return ['success' => true, 'cent_id' => $centId, 'message' => 'Centro de Formación creado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearCentroFormacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear el centro de formación: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarCentroFormacion($centId, $datos)
    {
        try {
            $centro = new CentroFormacionModel($centId, $datos['cent_nombre']);
            $centro->update();
            return ['success' => true, 'message' => 'Centro de Formación actualizado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarCentroFormacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el centro de formación'];
        }
    }
    
    public static function eliminarCentroFormacion($centId)
    {
        try {
            $centro = new CentroFormacionModel($centId, '');
            $centro->delete();
            return ['success' => true, 'message' => 'Centro de Formación eliminado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarCentroFormacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar el centro de formación: ' . $e->getMessage()];
        }
    }
}
