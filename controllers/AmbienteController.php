<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/AmbienteModel.php';

class AmbienteController
{
    public static function obtenerAmbientesPorSede($sedeId)
    {
        try {
            $ambiente = new AmbienteModel(null, '', $sedeId);
            return $ambiente->read();
        } catch (Exception $e) {
            error_log("Error en obtenerAmbientesPorSede: " . $e->getMessage());
            return [];
        }
    }
    
    public static function obtenerTodosAmbientes()
    {
        try {
            $ambiente = new AmbienteModel(null, '', null);
            return $ambiente->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodosAmbientes: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearAmbiente($datos)
    {
        try {
            $ambiente = new AmbienteModel(null, $datos['amb_nombre'], $datos['sede_id']);
            $ambienteId = $ambiente->create();
            return ['success' => true, 'ambiente_id' => $ambienteId, 'message' => 'Ambiente creado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearAmbiente: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear el ambiente: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarAmbiente($ambienteId, $datos)
    {
        try {
            $ambiente = new AmbienteModel($ambienteId, $datos['amb_nombre'], $datos['sede_id']);
            $ambiente->update();
            return ['success' => true, 'message' => 'Ambiente actualizado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarAmbiente: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el ambiente'];
        }
    }
    
    public static function eliminarAmbiente($ambienteId)
    {
        try {
            $ambiente = new AmbienteModel($ambienteId, '', null);
            $ambiente->delete();
            return ['success' => true, 'message' => 'Ambiente eliminado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarAmbiente: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar el ambiente'];
        }
    }
}
