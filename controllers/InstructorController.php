<?php
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../model/InstructorModel.php';

class InstructorController
{
    /**
     * Obtener un instructor por ID
     */
    public static function obtenerInstructor($instId)
    {
        try {
            $instructor = new InstructorModel($instId, '', '', '', '', null);
            $resultado = $instructor->read();
            
            if (!empty($resultado)) {
                return $resultado[0];
            }
            
            return null;
            
        } catch (Exception $e) {
            error_log("Error en obtenerInstructor: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtener todos los instructores
     */
    public static function obtenerTodosInstructores()
    {
        try {
            $instructor = new InstructorModel(null, '', '', '', '', null);
            return $instructor->readAll();
            
        } catch (Exception $e) {
            error_log("Error en obtenerTodosInstructores: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Crear un nuevo instructor
     */
    public static function crearInstructor($datos)
    {
        try {
            $instructor = new InstructorModel(
                null,
                $datos['inst_nombres'],
                $datos['inst_apellidos'],
                $datos['inst_correo'],
                $datos['inst_telefono'],
                $datos['centro_formacion_id'] ?? null
            );
            
            $instId = $instructor->create();
            
            return [
                'success' => true,
                'inst_id' => $instId,
                'message' => 'Instructor creado exitosamente'
            ];
            
        } catch (Exception $e) {
            error_log("Error en crearInstructor: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al crear el instructor: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Actualizar un instructor
     */
    public static function actualizarInstructor($instId, $datos)
    {
        try {
            $instructor = new InstructorModel(
                $instId,
                $datos['inst_nombres'],
                $datos['inst_apellidos'],
                $datos['inst_correo'],
                $datos['inst_telefono'],
                $datos['centro_formacion_id'] ?? null
            );
            
            $instructor->update();
            
            return [
                'success' => true,
                'message' => 'Instructor actualizado exitosamente'
            ];
            
        } catch (Exception $e) {
            error_log("Error en actualizarInstructor: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar el instructor'
            ];
        }
    }
    
    /**
     * Eliminar un instructor
     */
    public static function eliminarInstructor($instId)
    {
        try {
            $instructor = new InstructorModel($instId, '', '', '', '', null);
            $instructor->delete();
            
            return [
                'success' => true,
                'message' => 'Instructor eliminado exitosamente'
            ];
            
        } catch (Exception $e) {
            error_log("Error en eliminarInstructor: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al eliminar el instructor'
            ];
        }
    }
}
