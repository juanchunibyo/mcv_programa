<?php
require_once '../Conexion.php';
class TituloProgramaModel
{
    private $tibro_id;
    private $tibro_nombre;
    private $db;

    public function __construct($tibro_id, $tibro_nombre)
    {
        $this->setTibroId($tibro_id);
        $this->setTibroNombre($tibro_nombre);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getTibroId()
    {
        return $this->tibro_id;
    }
    public function getTibroNombre()
    {
        return $this->tibro_nombre;
    }

    //setters 
    public function setTibroId($tibro_id)
    {
        $this->tibro_id = $tibro_id;
    }
    public function setTibroNombre($tibro_nombre)
    {
        $this->tibro_nombre = $tibro_nombre;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO titulo_programa (tibro_nombre) 
        VALUES (:tibro_nombre)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tibro_nombre', $this->tibro_nombre);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    public function read()
    {
        $sql = "SELECT * FROM titulo_programa WHERE tibro_id = :tibro_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tibro_id' => $this->tibro_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM titulo_programa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE titulo_programa SET tibro_nombre = :tibro_nombre WHERE tibro_id = :tibro_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tibro_nombre', $this->tibro_nombre);
        $stmt->bindParam(':tibro_id', $this->tibro_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM titulo_programa WHERE tibro_id = :tibro_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tibro_id', $this->tibro_id);
        $stmt->execute();
        return $stmt;
    }
}
