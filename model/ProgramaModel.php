<?php
require_once __DIR__ . '/../Conexion.php';

class ProgramaModel
{
    private $prog_id;
    private $prog_codigo;
    private $tit_programa_titpro_id;
    private $prog_tipo;
    private $sede_sede_id;
    private $db;

    public function __construct($prog_id, $prog_codigo, $tit_programa_titpro_id, $prog_tipo, $sede_sede_id = null)
    {
        $this->prog_id = $prog_id;
        $this->prog_codigo = $prog_codigo;
        $this->tit_programa_titpro_id = $tit_programa_titpro_id;
        $this->prog_tipo = $prog_tipo;
        $this->sede_sede_id = $sede_sede_id;
        $this->db = Conexion::getConnect();
    }

    // CRUD
    public function create()
    {
        $query = "INSERT INTO programa (prog_codigo, tit_programa_titpro_id, prog_tipo, sede_sede_id) 
                  VALUES (:prog_codigo, :tit_programa_titpro_id, :prog_tipo, :sede_sede_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':prog_codigo', $this->prog_codigo);
        $stmt->bindParam(':tit_programa_titpro_id', $this->tit_programa_titpro_id);
        $stmt->bindParam(':prog_tipo', $this->prog_tipo);
        $stmt->bindParam(':sede_sede_id', $this->sede_sede_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function read()
    {
        $sql = "SELECT p.prog_id, p.prog_codigo, p.prog_tipo, p.sede_sede_id, 
                       p.tit_programa_titpro_id, tp.titpro_nombre, s.sede_nombre
                FROM programa p
                LEFT JOIN titulo_programa tp ON p.tit_programa_titpro_id = tp.titpro_id
                LEFT JOIN sede s ON p.sede_sede_id = s.sede_id
                WHERE p.prog_id = :prog_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':prog_id' => $this->prog_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT p.prog_id, p.prog_codigo, p.prog_tipo, p.sede_sede_id, 
                       p.tit_programa_titpro_id, tp.titpro_nombre, s.sede_nombre
                FROM programa p
                LEFT JOIN titulo_programa tp ON p.tit_programa_titpro_id = tp.titpro_id
                LEFT JOIN sede s ON p.sede_sede_id = s.sede_id
                ORDER BY p.prog_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE programa 
                  SET prog_codigo = :prog_codigo, 
                      tit_programa_titpro_id = :tit_programa_titpro_id, 
                      prog_tipo = :prog_tipo,
                      sede_sede_id = :sede_sede_id
                  WHERE prog_id = :prog_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':prog_codigo', $this->prog_codigo);
        $stmt->bindParam(':tit_programa_titpro_id', $this->tit_programa_titpro_id);
        $stmt->bindParam(':prog_tipo', $this->prog_tipo);
        $stmt->bindParam(':sede_sede_id', $this->sede_sede_id);
        $stmt->bindParam(':prog_id', $this->prog_id);
        $stmt->execute();
        return $stmt;
    }

    public function delete()
    {
        try {
            // Eliminar fichas asociadas primero
            $queryFichas = "DELETE FROM ficha WHERE programa_prog_id = :prog_id";
            $stmtFichas = $this->db->prepare($queryFichas);
            $stmtFichas->bindParam(':prog_id', $this->prog_id);
            $stmtFichas->execute();
            
            // Eliminar relaciones en competxprograma
            $queryCompet = "DELETE FROM competxprograma WHERE programa_prog_id = :prog_id";
            $stmtCompet = $this->db->prepare($queryCompet);
            $stmtCompet->bindParam(':prog_id', $this->prog_id);
            $stmtCompet->execute();
            
            // Eliminar el programa
            $query = "DELETE FROM programa WHERE prog_id = :prog_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':prog_id', $this->prog_id);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
