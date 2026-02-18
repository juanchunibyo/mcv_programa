<?php
require_once __DIR__ . '/../Conexion.php';
class AmbienteModel
{
    private $amb_id;
    private $amb_nombre;
    private $SEDE_sede_id;

    private $db;

    public function __construct($amb_id, $amb_nombre, $SEDE_sede_id)
    {
        $this->setAmbId($amb_id);
        $this->setAmbnombre($amb_nombre);
        $this->setSedeSedeId($SEDE_sede_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getAmbId()
    {
        return $this->amb_id;
    }
    public function getAmbnombre()
    {
        return $this->amb_nombre;
    }
    public function getSedeSedeId()
    {
        return $this->SEDE_sede_id;
    }

    //setters 
    public function setAmbId($amb_id)
    {
        $this->amb_id = $amb_id;
    }
    public function setAmbnombre($amb_nombre)
    {
        $this->amb_nombre = $amb_nombre;
    }
    public function setSedeSedeId($SEDE_sede_id)
    {
        $this->SEDE_sede_id = $SEDE_sede_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO ambiente (amb_nombre, sede_sede_id) 
        VALUES (:amb_nombre, :SEDE_sede_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':amb_nombre', $this->amb_nombre);
        $stmt->bindParam(':SEDE_sede_id', $this->SEDE_sede_id);
        $stmt->execute();
        return $this->db->lastInsertId();

    }
    public function read()
    {
        $sql = "SELECT * FROM ambiente WHERE sede_sede_id = :sede";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede' => $this->SEDE_sede_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM ambiente";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE ambiente SET amb_nombre = :amb_nombre, sede_sede_id = :SEDE_sede_id WHERE amb_id = :amb_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':amb_nombre', $this->amb_nombre);
        $stmt->bindParam(':SEDE_sede_id', $this->SEDE_sede_id);
        $stmt->bindParam(':amb_id', $this->amb_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM ambiente WHERE amb_id = :amb_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':amb_id', $this->amb_id);
        $stmt->execute();
        return $stmt;
    }



}
