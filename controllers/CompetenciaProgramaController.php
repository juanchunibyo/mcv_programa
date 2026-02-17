<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/CompetenciaProgramaModel.php';

class CompetenciaProgramaController
{
    public static function obtenerCompetenciasPorPrograma($programaId)
    {
        try {
            $competenciaPrograma = new CompetenciaProgramaModel($programaId, null);
            return $competenciaPrograma->read();
        } catch (Exception $e) {
            error_log("Error en obtenerCompetenciasPorPrograma: " . $e->getMessage());
            return [];
        }
    }
    
    public static function obtenerTodasRelaciones()
    {
        try {
            $competenciaPrograma = new CompetenciaProgramaModel(null, null);
            return $competenciaPrograma->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodasRelaciones: " . $e->getMessage());
            return [];
        }
    }
    
    public static function asignarCompetenciaAPrograma($datos)
    {
        try {
            $competenciaPrograma = new CompetenciaProgramaModel($datos['programa_id'], $datos['competencia_id']);
            $competenciaPrograma->create();
            return ['success' => true, 'message' => 'Competencia asignada al programa exitosamente'];
        } catch (Exception $e) {
            error_log("Error en asignarCompetenciaAPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al asignar la competencia: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarRelacion($programaId, $datos)
    {
        try {
            $competenciaPrograma = new CompetenciaProgramaModel($programaId, $datos['competencia_id']);
            $competenciaPrograma->update();
            return ['success' => true, 'message' => 'Relación actualizada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarRelacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar la relación'];
        }
    }
    
    public static function eliminarRelacion($programaId, $competenciaId)
    {
        try {
            $competenciaPrograma = new CompetenciaProgramaModel($programaId, $competenciaId);
            $competenciaPrograma->delete();
            return ['success' => true, 'message' => 'Relación eliminada exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarRelacion: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar la relación'];
        }
    }
}
