<?php
require_once __DIR__ . '/../Conexion.php';
class DetalleAsignacionModel
{
    private $asignacion_asig_id;
    private $detasig_hora_ini;
    private $detasig_hora_fin;
    private $detasig_id;
    private $db;

    public function __construct($asignacion_asig_id, $detasig_hora_ini, $detasig_hora_fin, $detasig_id)
    {
        $this->asignacion_asig_id = $asignacion_asig_id;
        $this->detasig_hora_ini = $detasig_hora_ini;
        $this->detasig_hora_fin = $detasig_hora_fin;
        $this->detasig_id = $detasig_id;
        $this->db = Conexion::getConnect();
    }

    public function create()
    {
        $query = "INSERT INTO detalle_asignacion (asignacion_asig_id, detasig_hora_ini, detasig_hora_fin) 
        VALUES (:asignacion_asig_id, :detasig_hora_ini, :detasig_hora_fin)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':asignacion_asig_id', $this->asignacion_asig_id);
        $stmt->bindParam(':detasig_hora_ini', $this->detasig_hora_ini);
        $stmt->bindParam(':detasig_hora_fin', $this->detasig_hora_fin);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function read()
    {
        $sql = "SELECT d.*, a.ficha_fich_id, a.ambiente_amb_id
                FROM detalle_asignacion d
                LEFT JOIN asignacion a ON d.asignacion_asig_id = a.asig_id
                WHERE d.detasig_id = :detasig_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':detasig_id' => $this->detasig_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT d.*, a.ficha_fich_id, a.ambiente_amb_id, amb.amb_nombre
                FROM detalle_asignacion d
                LEFT JOIN asignacion a ON d.asignacion_asig_id = a.asig_id
                LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
                ORDER BY d.detasig_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE detalle_asignacion 
                  SET asignacion_asig_id = :asignacion_asig_id, 
                      detasig_hora_ini = :detasig_hora_ini, 
                      detasig_hora_fin = :detasig_hora_fin 
                  WHERE detasig_id = :detasig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':asignacion_asig_id', $this->asignacion_asig_id);
        $stmt->bindParam(':detasig_hora_ini', $this->detasig_hora_ini);
        $stmt->bindParam(':detasig_hora_fin', $this->detasig_hora_fin);
        $stmt->bindParam(':detasig_id', $this->detasig_id);
        $stmt->execute();
        return $stmt;
    }

    public function delete()
    {
        $query = "DELETE FROM detalle_asignacion WHERE detasig_id = :detasig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':detasig_id', $this->detasig_id);
        $stmt->execute();
        return $stmt;
    }
}
