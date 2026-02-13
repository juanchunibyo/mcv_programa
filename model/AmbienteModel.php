<?php
require_once __DIR__ . '/../Conexion.php';
class AmbienteModel
{
    private $id_ambiente;
    private $amb_nombre;
    private $Sede_sede_id;

    private $db;

    public function __construct($id_ambiente, $amb_nombre, $Sede_sede_id)
    {
        $this->setIdAmbiente($id_ambiente);
        $this->setAmbnombre($amb_nombre);
        $this->setSedeSedeId($Sede_sede_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getIdAmbiente()
    {
        return $this->id_ambiente;
    }
    public function getAmbnombre()
    {
        return $this->amb_nombre;
    }
    public function getSedeSedeId()
    {
        return $this->Sede_sede_id;
    }

    //setters 
    public function setIdAmbiente($id_ambiente)
    {
        $this->id_ambiente = $id_ambiente;
    }
    public function setAmbnombre($amb_nombre)
    {
        $this->amb_nombre = $amb_nombre;
    }
    public function setSedeSedeId($Sede_sede_id)
    {
        $this->Sede_sede_id = $Sede_sede_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO ambiente (amb_nombre, Sede_sede_id) 
        VALUES (:amb_nombre, :Sede_sede_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':amb_nombre', $this->amb_nombre);
        $stmt->bindParam(':Sede_sede_id', $this->Sede_sede_id);
        $stmt->execute();
        return $this->db->lastInsertId();

    }
    public function read()
    {
        $sql = "SELECT * FROM ambiente WHERE sede_sede_id = :sede";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sede' => $this->Sede_sede_id]);
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
        $query = "UPDATE ambiente SET amb_nombre = :amb_nombre, Sede_sede_id = :Sede_sede_id WHERE id_ambiente = :id_ambiente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':amb_nombre', $this->amb_nombre);
        $stmt->bindParam(':Sede_sede_id', $this->Sede_sede_id);
        $stmt->bindParam(':id_ambiente', $this->id_ambiente);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM ambiente WHERE id_ambiente = :id_ambiente";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_ambiente', $this->id_ambiente);
        $stmt->execute();
        return $stmt;
    }



}
