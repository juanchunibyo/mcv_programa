<?php
require_once __DIR__ . '/../Conexion.php';

class UsuarioModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConnect();
    }

    /**
     * Busca un usuario por su correo electrónico
     */
    public function getUsuarioPorCorreo($correo)
    {
        $sql = "SELECT u.usu_id, u.usu_nombre, u.usu_correo, u.usu_password, u.inst_id, r.rol_nombre 
                FROM usuario u
                INNER JOIN rol r ON u.rol_rol_id = r.rol_id
                WHERE u.usu_correo = :correo";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si un correo y contraseña son válidos
     */
    public function verificarCredenciales($correo, $password_plano)
    {
        $usuario = $this->getUsuarioPorCorreo($correo);
        
        // Si el usuario existe y la contraseña encriptada coincide
        if ($usuario && password_verify($password_plano, $usuario['usu_password'])) {
            return $usuario;
        }
        
        return false;
    }

    /**
     * Registra un nuevo administrador o instructor.
     */
    public function registrarUsuario($nombre, $correo, $password_hash, $rol_id)
    {
        // Verificar si el correo ya existe
        $usuarioExistente = $this->getUsuarioPorCorreo($correo);
        if ($usuarioExistente) {
            return ['success' => false, 'message' => 'El correo electrónico ya está registrado.'];
        }

        // Determinar si debemos crear un registro en instructor
        // Para esto necesitamos el nombre del rol
        $sqlRol = "SELECT rol_nombre FROM rol WHERE rol_id = :rol_id";
        $stmtRol = $this->pdo->prepare($sqlRol);
        $stmtRol->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
        $stmtRol->execute();
        $rol = $stmtRol->fetch(PDO::FETCH_ASSOC);

        $inst_id = null;
        
        try {
            // Empezar una transacción
            $this->pdo->beginTransaction();

            if ($rol && strtolower($rol['rol_nombre']) === 'instructor') {
                // Si es instructor, creamos un registro básico en la tabla instructor
                // Asumiendo que centro_formacion_cent_id = 1 por defecto al registrarse (puede requerir ser dinámico luego)
                // Separamos el nombre en nombres y apellidos para la tabla instructor
                $partes_nombre = explode(' ', trim($nombre), 2);
                $nombres = $partes_nombre[0];
                $apellidos = isset($partes_nombre[1]) ? $partes_nombre[1] : '';

                $sqlInst = "INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, centro_formacion_cent_id) 
                            VALUES (:nombres, :apellidos, :correo, 1)";
                $stmtInst = $this->pdo->prepare($sqlInst);
                $stmtInst->bindParam(':nombres', $nombres, PDO::PARAM_STR);
                $stmtInst->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
                $stmtInst->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmtInst->execute();
                
                // Obtener el ID del instructor recién creado
                $inst_id = $this->pdo->lastInsertId();
            }

            // Insertar en la tabla usuario
            $sqlUsu = "INSERT INTO usuario (usu_nombre, usu_correo, usu_password, rol_rol_id, inst_id) 
                       VALUES (:nombre, :correo, :password, :rol_id, :inst_id)";
            $stmtUsu = $this->pdo->prepare($sqlUsu);
            $stmtUsu->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmtUsu->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmtUsu->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $stmtUsu->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
            // PDO soporta null en bindParam pero a veces es truculento, mejor usar bindValue para NULL
            if ($inst_id === null) {
                $stmtUsu->bindValue(':inst_id', null, PDO::PARAM_NULL);
            } else {
                $stmtUsu->bindParam(':inst_id', $inst_id, PDO::PARAM_INT);
            }
            
            $stmtUsu->execute();

            $this->pdo->commit();
            return ['success' => true, 'message' => 'Usuario registrado exitosamente.'];

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => 'Error al registrar el usuario: ' . $e->getMessage()];
        }
    }
}
