<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/ProgramaModel.php';

class ProgramaController
{
    public static function obtenerPrograma($progId)
    {
        try {
            $programa = new ProgramaModel($progId, null, null, null);
            $resultado = $programa->read();
            return !empty($resultado) ? $resultado[0] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerPrograma: " . $e->getMessage());
            return null;
        }
    }
    
    public static function obtenerTodosProgramas()
    {
        try {
            $programa = new ProgramaModel(null, null, null, null);
            return $programa->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodosProgramas: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearPrograma($datos)
    {
        try {
            $programa = new ProgramaModel(
                null,
                $datos['prog_codigo'],
                $datos['tit_programa_id'],
                $datos['prog_tipo'],
                $datos['sede_id'] ?? null
            );
            $progId = $programa->create();
            return ['success' => true, 'prog_id' => $progId, 'message' => 'Programa creado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear el programa: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarPrograma($progId, $datos)
    {
        try {
            $programa = new ProgramaModel(
                $progId,
                $datos['prog_codigo'],
                $datos['tit_programa_id'],
                $datos['prog_tipo'],
                $datos['sede_id'] ?? null
            );
            $programa->update();
            return ['success' => true, 'message' => 'Programa actualizado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el programa: ' . $e->getMessage()];
        }
    }
    
    public static function eliminarPrograma($progId)
    {
        try {
            $programa = new ProgramaModel($progId, null, null, null);
            $programa->delete();
            return ['success' => true, 'message' => 'Programa eliminado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar el programa: ' . $e->getMessage()];
        }
    }
}
