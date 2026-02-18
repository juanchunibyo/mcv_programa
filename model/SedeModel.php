<?php
require_once __DIR__ . '/../Conexion.php';
class SedeModel
{
    private $sede_id;
    private $sede_nombre;
    private $db;

    public function __construct($sede_id, $sede_nombre)
    {
        $this->setSedeId($sede_id);
        $this->setSedNombre($sede_nombre);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getSedeId()
    {
        return $this->sede_id;
    }
    public function getSedNombre()
    {
        return $this->sede_nombre;
    }

    //setters 
    public function setSedeId($sede_id)
    {
        $this->sede_id = $sede_id;
    }
    public function setSedNombre($sede_nombre)
    {
        $this->sede_nombre = $sede_nombre;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO sede (sede_nombre) 
        VALUES (:sede_nombre)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sede_nombre', $this->sede_nombre);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function read()
    {
        $sql = "SELECT * FROM sede WHERE sede_id = :sede_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede_id' => $this->sede_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM sede";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE sede SET sede_nombre = :sede_nombre WHERE sede_id = :sede_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sede_nombre', $this->sede_nombre);
        $stmt->bindParam(':sede_id', $this->sede_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        try {
            // Primero eliminar ambientes asociados
            $queryAmbientes = "DELETE FROM ambiente WHERE sede_sede_id = :sede_id";
            $stmtAmbientes = $this->db->prepare($queryAmbientes);
            $stmtAmbientes->bindParam(':sede_id', $this->sede_id);
            $stmtAmbientes->execute();
            
            // Eliminar programas asociados (o actualizar a NULL si se permite)
            $queryProgramas = "UPDATE programa SET sede_sede_id = NULL WHERE sede_sede_id = :sede_id";
            $stmtProgramas = $this->db->prepare($queryProgramas);
            $stmtProgramas->bindParam(':sede_id', $this->sede_id);
            $stmtProgramas->execute();
            
            // Luego eliminar la sede
            $query = "DELETE FROM sede WHERE sede_id = :sede_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':sede_id', $this->sede_id);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
