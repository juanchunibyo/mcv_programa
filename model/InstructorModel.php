<?php
require_once __DIR__ . '/../Conexion.php';
class InstructorModel
{
    private $inst_id;
    private $inst_nombre;
    private $inst_apellidos;
    private $inst_correo;
    private $inst_telefono;
    private $db;

    public function __construct($inst_id, $inst_nombre, $inst_apellidos, $inst_correo, $inst_telefono)
    {
        $this->setInstId($inst_id);
        $this->setInstNombre($inst_nombre);
        $this->setInstApellidos($inst_apellidos);
        $this->setInstCorreo($inst_correo);
        $this->setInstTelefono($inst_telefono);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getInstId()
    {
        return $this->inst_id;
    }
    public function getInstNombre()
    {
        return $this->inst_nombre;
    }
    public function getInstApellidos()
    {
        return $this->inst_apellidos;
    }
    public function getInstCorreo()
    {
        return $this->inst_correo;
    }
    public function getInstTelefono()
    {
        return $this->inst_telefono;
    }

    //setters 
    public function setInstId($inst_id)
    {
        $this->inst_id = $inst_id;
    }
    public function setInstNombre($inst_nombre)
    {
        $this->inst_nombre = $inst_nombre;
    }
    public function setInstApellidos($inst_apellidos)
    {
        $this->inst_apellidos = $inst_apellidos;
    }
    public function setInstCorreo($inst_correo)
    {
        $this->inst_correo = $inst_correo;
    }
    public function setInstTelefono($inst_telefono)
    {
        $this->inst_telefono = $inst_telefono;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO instructor (inst_nombre, inst_apellidos, inst_correo, inst_telefono) 
        VALUES (:inst_nombre, :inst_apellidos, :inst_correo, :inst_telefono)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_nombre', $this->inst_nombre);
        $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
        $stmt->bindParam(':inst_correo', $this->inst_correo);
        $stmt->bindParam(':inst_telefono', $this->inst_telefono);
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
    public function update()
    {
        $query = "UPDATE instructor SET inst_nombre = :inst_nombre, inst_apellidos = :inst_apellidos, inst_correo = :inst_correo, inst_telefono = :inst_telefono WHERE inst_id = :inst_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_nombre', $this->inst_nombre);
        $stmt->bindParam(':inst_apellidos', $this->inst_apellidos);
        $stmt->bindParam(':inst_correo', $this->inst_correo);
        $stmt->bindParam(':inst_telefono', $this->inst_telefono);
        $stmt->bindParam(':inst_id', $this->inst_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM instructor WHERE inst_id = :inst_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':inst_id', $this->inst_id);
        $stmt->execute();
        return $stmt;
    }
}
