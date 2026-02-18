<?php
require_once __DIR__ . '/../Conexion.php';
class DetalleAsignacionModel
{
    private $ASIGNACION_ASIG_ID;
    private $detaseg_hora_ini;
    private $detaseg_hora_fin;
    private $detaseg_id;
    private $db;

    public function __construct($ASIGNACION_ASIG_ID, $detaseg_hora_ini, $detaseg_hora_fin, $detaseg_id)
    {
        $this->setAsignacionAsigId($ASIGNACION_ASIG_ID);
        $this->setDetasegHoraIni($detaseg_hora_ini);
        $this->setDetasegHoraFin($detaseg_hora_fin);
        $this->setDetasegId($detaseg_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getAsignacionAsigId()
    {
        return $this->ASIGNACION_ASIG_ID;
    }
    public function getDetasegHoraIni()
    {
        return $this->detaseg_hora_ini;
    }
    public function getDetasegHoraFin()
    {
        return $this->detaseg_hora_fin;
    }
    public function getDetasegId()
    {
        return $this->detaseg_id;
    }

    //setters 
    public function setAsignacionAsigId($ASIGNACION_ASIG_ID)
    {
        $this->ASIGNACION_ASIG_ID = $ASIGNACION_ASIG_ID;
    }
    public function setDetasegHoraIni($detaseg_hora_ini)
    {
        $this->detaseg_hora_ini = $detaseg_hora_ini;
    }
    public function setDetasegHoraFin($detaseg_hora_fin)
    {
        $this->detaseg_hora_fin = $detaseg_hora_fin;
    }
    public function setDetasegId($detaseg_id)
    {
        $this->detaseg_id = $detaseg_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO detallexasignacion (ASIGNACION_ASIG_ID, detaseg_hora_ini, detaseg_hora_fin) 
        VALUES (:ASIGNACION_ASIG_ID, :detaseg_hora_ini, :detaseg_hora_fin)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ASIGNACION_ASIG_ID', $this->ASIGNACION_ASIG_ID);
        $stmt->bindParam(':detaseg_hora_ini', $this->detaseg_hora_ini);
        $stmt->bindParam(':detaseg_hora_fin', $this->detaseg_hora_fin);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function read()
    {
        $sql = "SELECT * FROM detallexasignacion WHERE ASIGNACION_ASIG_ID = :ASIGNACION_ASIG_ID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':ASIGNACION_ASIG_ID' => $this->ASIGNACION_ASIG_ID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM detallexasignacion";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE detallexasignacion SET ASIGNACION_ASIG_ID = :ASIGNACION_ASIG_ID, detaseg_hora_ini = :detaseg_hora_ini, detaseg_hora_fin = :detaseg_hora_fin WHERE detaseg_id = :detaseg_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ASIGNACION_ASIG_ID', $this->ASIGNACION_ASIG_ID);
        $stmt->bindParam(':detaseg_hora_ini', $this->detaseg_hora_ini);
        $stmt->bindParam(':detaseg_hora_fin', $this->detaseg_hora_fin);
        $stmt->bindParam(':detaseg_id', $this->detaseg_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM detallexasignacion WHERE detaseg_id = :detaseg_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':detaseg_id', $this->detaseg_id);
        $stmt->execute();
        return $stmt;
    }
}
