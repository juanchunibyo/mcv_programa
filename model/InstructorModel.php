<?php
require_once __DIR__ . '/../Conexion.php';
class InstructorModel
{
    private $inst_id;
    private $inst_nombres;
    private $inst_apellidos;
    private $inst_correo;
    private $inst_telefono;
    private $centro_formacion_cent_id;
    private $db;

    public function __construct($inst_id, $inst_nombres, $inst_apellidos, $inst_correo, $inst_telefono, $centro_formacion_cent_id = null)
    {
        $this->setInstId($inst_id);
        $this->setInstNombres($inst_nombres);
        $this->setInstApellidos($inst_apellidos);
        $this->setInstCorreo($inst_correo);
        $this->setInstTelefono($inst_telefono);
        $this->setCentroFormacionCentId($centro_formacion_cent_id);
        $this->db = Conexion::getConnect();
    }

    public function getInstId() { return $this->inst_id; }
    public function getInstNombres() { return $this->inst_nombres; }
    public function getInstApellidos() { return $this->inst_apellidos; }
    public function getInstCorreo() { return $this->inst_correo; }
    public function getInstTelefono() { return $this->inst_telefono; }
    public function getCentroFormacionCentId() { return $this->centro_formacion_cent_id; }

    public function setInstId($inst_id) { $this->inst_id = $inst_id; }
    public function setInstNombres($inst_nombres) { $this->inst_nombres = $inst_nombres; }
    public function setInstApellidos($inst_apellidos) { $this->inst_apellidos = $inst_apellidos; }
    public function setInstCorreo($inst_correo) { $this->inst_correo = $inst_correo; }
    public function setInstTelefono($inst_telefono) { $this->inst_telefono = $inst_telefono; }
    public function setCentroFormacionCentId($centro_formacion_cent_id) { $this->centro_formacion_cent_id = $centro_formacion_cent_id; }

    public function create()
    {
        $query = "INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id) 
        VALUES (:inst_nombres, :inst_apellidos, :inst_correo, :inst_telefono, :centro_formacion_cent_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_nombres', $this->inst_nombres);
        $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
        $stmt->bindParam(':inst_correo', $this->inst_correo);
        $stmt->bindParam(':inst_telefono', $this->inst_telefono);
        $stmt->bindParam(':centro_formacion_cent_id', $this->centro_formacion_cent_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    
    public function read()
    {
        $sql = "SELECT * FROM instructor WHERE inst_id = :inst_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':inst_id' => $this->inst_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM instructor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retorna los instructores asociados a una ficha
     * (El titular de la ficha y cualquier otro que ya le haya dado clases a dicha ficha en el pasado)
     * Si no encuentra a nadie específico, o queremos ser amplios, retorna todos.
     */
    public function readInstructoresPorFicha($ficha_id)
    {
        // 1. Obtener instructor titular de la Ficha
        // 2. Obtener instructores de asignaciones previas en la misma ficha
        $sql = "
            SELECT DISTINCT i.inst_id, i.inst_nombres, i.inst_apellidos 
            FROM instructor i
            WHERE i.inst_id IN (
                SELECT instructor_inst_id FROM ficha WHERE fich_id = :fich_id
                UNION
                SELECT instructor_inst_id FROM asignacion WHERE ficha_fich_id = :fich_id
            )
            ORDER BY i.inst_nombres, i.inst_apellidos
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':fich_id' => $ficha_id]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Si por alguna razón la ficha no tiene NINGÚN instructor relacionado aún,
        // devolvemos todos los instructores como fallback, para que el usuario pueda
        // asignarle su PRIMER instructor.
        if (empty($resultados)) {
            $sqlTodos = "SELECT inst_id, inst_nombres, inst_apellidos FROM instructor ORDER BY inst_nombres, inst_apellidos";
            $stmtTodos = $this->db->prepare($sqlTodos);
            $stmtTodos->execute();
            return $stmtTodos->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $resultados;
    }
    
    public function update()
    {
        $query = "UPDATE instructor SET inst_nombres = :inst_nombres, inst_apellidos = :inst_apellidos, inst_correo = :inst_correo, inst_telefono = :inst_telefono, centro_formacion_cent_id = :centro_formacion_cent_id WHERE inst_id = :inst_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_nombres', $this->inst_nombres);
        $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
        $stmt->bindParam(':inst_correo', $this->inst_correo);
        $stmt->bindParam(':inst_telefono', $this->inst_telefono);
        $stmt->bindParam(':centro_formacion_cent_id', $this->centro_formacion_cent_id);
        $stmt->bindParam(':inst_id', $this->inst_id);
        $stmt->execute();
        return $stmt;
    }
    
    public function delete()
    {
        try {
            $this->db->beginTransaction();

            // 1. Eliminar la cuenta de usuario vinculada a este instructor (si existe)
            $queryUsuario = "DELETE FROM usuario WHERE inst_id = :inst_id";
            $stmtUsuario = $this->db->prepare($queryUsuario);
            $stmtUsuario->bindParam(':inst_id', $this->inst_id);
            $stmtUsuario->execute();

            // 2. Quitar al instructor como Titular de cualquier Ficha que tuviera asignada
            $queryFichas = "UPDATE ficha SET instructor_inst_id = NULL WHERE instructor_inst_id = :inst_id";
            $stmtFichas = $this->db->prepare($queryFichas);
            $stmtFichas->bindParam(':inst_id', $this->inst_id);
            $stmtFichas->execute();

            // 3. Eliminar al Instructor (Solo pasará si no tiene clases en Asignacion)
            $query = "DELETE FROM instructor WHERE inst_id = :inst_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':inst_id', $this->inst_id);
            $stmt->execute();
            
            $this->db->commit();
            return $stmt;

        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            // Código 23503: Violación de Restricción de Llave Foránea (Queda atrapado por la tabla asignacion)
            if ($e->getCode() == '23503') {
                throw new Exception("PROTECCIÓN DE DATOS: No puedes eliminar a este Instructor debido a que ya impartió clases en el Calendario. Debes eliminar primero sus clases registradas.");
            }
            throw new Exception("Error interno SQL: " . $e->getMessage());
        } catch (Exception $e) {
            if (isset($this->db) && $this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}
