<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/CompetenciaModel.php';

class CompetenciaController
{
    public static function obtenerCompetencia($compId)
    {
        try {
            $competencia = new CompetenciaModel($compId, '', null, '');
            $resultado = $competencia->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerCompetencia: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerTodasCompetencias()
    {
        try {
            $competencia = new CompetenciaModel(null, '', null, '');
            return $competencia->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodasCompetencias: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearCompetencia($datos)
    {
        try {
            $competencia = new CompetenciaModel(null, $datos['comp_nombre_corto'], $datos['comp_horas'], $datos['comp_nombre_unidad_competencia']);
            $compId = $competencia->create();
            return ['success' => true, 'comp_id' => $compId, 'message' => 'Competencia creada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearCompetencia: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear la competencia: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarCompetencia($compId, $datos)
    {
        try {
            $competencia = new CompetenciaModel($compId, $datos['comp_nombre_corto'], $datos['comp_horas'], $datos['comp_nombre_unidad_competencia']);
            $competencia->update();
            return ['success' => true, 'message' => 'Competencia actualizada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarCompetencia: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar la competencia'];
        }
    }
    
    public static function eliminarCompetencia($compId)
    {
        try {
            $competencia = new CompetenciaModel($compId, '', null, '');
            $competencia->delete();
            return ['success' => true, 'message' => 'Competencia eliminada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarCompetencia: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar la competencia'];
        }
    }
}
