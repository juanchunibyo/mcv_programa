<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/ProgramaModel.php';

class ProgramaController
{
    public static function obtenerPrograma($progCodigo)
    {
        try {
            $programa = new ProgramaModel($progCodigo, '', null, '');
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
            $programa = new ProgramaModel(null, '', null, '');
            return $programa->readAll();
        } catch (Exception $e) {
            error_log("Error en obtenerTodosProgramas: " . $e->getMessage());
            return [];
        }
    }
    
    public static function crearPrograma($datos)
    {
        try {
            $programa = new ProgramaModel(null, $datos['prog_denominacion'], $datos['tit_programa_id'], $datos['prog_tipo']);
            $progCodigo = $programa->create();
            return ['success' => true, 'prog_codigo' => $progCodigo, 'message' => 'Programa creado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en crearPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear el programa: ' . $e->getMessage()];
        }
    }
    
    public static function actualizarPrograma($progCodigo, $datos)
    {
        try {
            $programa = new ProgramaModel($progCodigo, $datos['prog_denominacion'], $datos['tit_programa_id'], $datos['prog_tipo']);
            $programa->update();
            return ['success' => true, 'message' => 'Programa actualizado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en actualizarPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el programa'];
        }
    }
    
    public static function eliminarPrograma($progCodigo)
    {
        try {
            $programa = new ProgramaModel($progCodigo, '', null, '');
            $programa->delete();
            return ['success' => true, 'message' => 'Programa eliminado exitosamente'];
        } catch (Exception $e) {
            error_log("Error en eliminarPrograma: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar el programa'];
        }
    }
}
