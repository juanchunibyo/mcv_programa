<?php
require_once __DIR__ . '/../Conexion.php';

class FichaModel
{
    private $fich_id;
    private $programa_prog_id;
    private $instructor_inst_id;
    private $fich_jornada;
    private $coordinacion_coord_id;
    private $db;

    public function __construct($fich_id, $programa_prog_id, $instructor_inst_id, $fich_jornada, $coordinacion_coord_id = null)
    {
        $this->fich_id = $fich_id;
        $this->programa_prog_id = $programa_prog_id;
        $this->instructor_inst_id = $instructor_inst_id;
        $this->fich_jornada = $fich_jornada;
        $this->coordinacion_coord_id = $coordinacion_coord_id;
        $this->db = Conexion::getConnect();
    }

    // CRUD
    public function create()
    {
        $query = "INSERT INTO ficha (programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) 
                  VALUES (:programa_prog_id, :instructor_inst_id, :fich_jornada, :coordinacion_coord_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':instructor_inst_id', $this->instructor_inst_id);
        $stmt->bindParam(':fich_jornada', $this->fich_jornada);
        $stmt->bindParam(':coordinacion_coord_id', $this->coordinacion_coord_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function read()
    {
        $sql = "SELECT f.fich_id, f.programa_prog_id, f.instructor_inst_id, f.fich_jornada, f.coordinacion_coord_id,
                       p.prog_codigo, tp.titpro_nombre,
                       i.inst_nombres, i.inst_apellidos,
                       c.coord_nombre
                FROM ficha f
                LEFT JOIN programa p ON f.programa_prog_id = p.prog_id
                LEFT JOIN titulo_programa tp ON p.tit_programa_titpro_id = tp.titpro_id
                LEFT JOIN instructor i ON f.instructor_inst_id = i.inst_id
                LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
                WHERE f.fich_id = :fich_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':fich_id' => $this->fich_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT f.fich_id, f.programa_prog_id, f.instructor_inst_id, f.fich_jornada, f.coordinacion_coord_id,
                       p.prog_codigo, tp.titpro_nombre,
                       i.inst_nombres, i.inst_apellidos,
                       c.coord_nombre
                FROM ficha f
                LEFT JOIN programa p ON f.programa_prog_id = p.prog_id
                LEFT JOIN titulo_programa tp ON p.tit_programa_titpro_id = tp.titpro_id
                LEFT JOIN instructor i ON f.instructor_inst_id = i.inst_id
                LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
                ORDER BY f.fich_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE ficha 
                  SET programa_prog_id = :programa_prog_id, 
                      instructor_inst_id = :instructor_inst_id, 
                      fich_jornada = :fich_jornada,
                      coordinacion_coord_id = :coordinacion_coord_id
                  WHERE fich_id = :fich_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':programa_prog_id', $this->programa_prog_id);
        $stmt->bindParam(':instructor_inst_id', $this->instructor_inst_id);
        $stmt->bindParam(':fich_jornada', $this->fich_jornada);
        $stmt->bindParam(':coordinacion_coord_id', $this->coordinacion_coord_id);
        $stmt->bindParam(':fich_id', $this->fich_id);
        $stmt->execute();
        return $stmt;
    }

    public function delete()
    {
        try {
            // Eliminar asignaciones asociadas primero
            $queryAsig = "DELETE FROM asignacion WHERE ficha_fich_id = :fich_id";
            $stmtAsig = $this->db->prepare($queryAsig);
            $stmtAsig->bindParam(':fich_id', $this->fich_id);
            $stmtAsig->execute();
            
            // Eliminar la ficha
            $query = "DELETE FROM ficha WHERE fich_id = :fich_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fich_id', $this->fich_id);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
