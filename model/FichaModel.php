<?php
require_once __DIR__ . '/../Conexion.php';
class FichaModel
{
    private $fich_id;
    private $programa_prog_id;
    private $instructor_inst_id_lider;
    private $fich_jornada;
    private $db;

    public function __construct($fich_id, $programa_prog_id, $instructor_inst_id_lider, $fich_jornada)
    {
        $this->setFichId($fich_id);
        $this->setProgramaProgId($programa_prog_id);
        $this->setInstructorInstIdLider($instructor_inst_id_lider);
        $this->setFichJornada($fich_jornada);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getFichId()
    {
        return $this->fich_id;
    }
    public function getProgramaProgId()
    {
        return $this->programa_prog_id;
    }
    public function getInstructorInstIdLider()
    {
        return $this->instructor_inst_id_lider;
    }
    public function getFichJornada()
    {
        return $this->fich_jornada;
    }

    //setters 
    public function setFichId($fich_id)
    {
        $this->fich_id = $fich_id;
    }
    public function setProgramaProgId($programa_prog_id)
    {
        $this->programa_prog_id = $programa_prog_id;
    }
    public function setInstructorInstIdLider($instructor_inst_id_lider)
    {
        $this->instructor_inst_id_lider = $instructor_inst_id_lider;
    }
    public function setFichJornada($fich_jornada)
    {
        $this->fich_jornada = $fich_jornada;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO ficha (PROGRAMA_prog_id, INSTRUCTOR_inst_id_lider, fich_jornada) 
        VALUES (:programa_prog_id, :instructor_inst_id_lider, :fich_jornada)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':instructor_inst_id_lider', $this->instructor_inst_id_lider);
        $stmt->bindParam(':fich_jornada', $this->fich_jornada);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function read()
    {
        $sql = "SELECT * FROM ficha WHERE fich_id = :fich_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':fich_id' => $this->fich_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM ficha";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE ficha SET PROGRAMA_prog_id = :programa_prog_id, INSTRUCTOR_inst_id_lider = :instructor_inst_id_lider, fich_jornada = :fich_jornada WHERE fich_id = :fich_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':instructor_inst_id_lider', $this->instructor_inst_id_lider);
        $stmt->bindParam(':fich_jornada', $this->fich_jornada);
        $stmt->bindParam(':fich_id', $this->fich_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM ficha WHERE fich_id = :fich_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fich_id', $this->fich_id);
        $stmt->execute();
        return $stmt;
    }
}
