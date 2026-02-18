<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/FichaModel.php';

class FichaController
{
    public static function obtenerFicha($fichId)
    {
        try {
            $ficha = new FichaModel($fichId, null, null, null);
            $resultado = $ficha->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerFicha: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerTodasFichas()
    {
        try {
            $ficha = new FichaModel(null, null, null, null);
            return $ficha->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodasFichas: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearFicha($datos)
    {
        try {
            $ficha = new FichaModel(
                null,
                $datos['programa_id'],
                $datos['instructor_id'],
                $datos['fich_jornada'],
                $datos['coordinacion_id'] ?? null
            );
            $fichId = $ficha->create();
            return ['success' => true, 'fich_id' => $fichId, 'message' => 'Ficha creada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearFicha: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear la ficha: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarFicha($fichId, $datos)
    {
        try {
            $ficha = new FichaModel(
                $fichId,
                $datos['programa_id'],
                $datos['instructor_id'],
                $datos['fich_jornada'],
                $datos['coordinacion_id'] ?? null
            );
            $ficha->update();
            return ['success' => true, 'message' => 'Ficha actualizada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarFicha: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar la ficha: ' . $e->getMessage()];
        }
    }
    
    public static function eliminarFicha($fichId)
    {
        try {
            $ficha = new FichaModel($fichId, null, null, null);
            $ficha->delete();
            return ['success' => true, 'message' => 'Ficha eliminada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarFicha: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar la ficha: ' . $e->getMessage()];
        }
    }
}
