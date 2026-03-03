<?php
require_once __DIR__ . '/../Conexion.php';
class AsignacionModel
{
    private $asig_id;
    private $instructor_inst_id;
    private $asig_fecha_ini;
    private $asig_fecha_fin;
    private $ficha_fich_id;
    private $ambiente_amb_id;
    private $competencia_comp_id;
    private $db;

    public function __construct($asig_id, $instructor_inst_id, $asig_fecha_ini, $asig_fecha_fin, $ficha_fich_id, $ambiente_amb_id, $competencia_comp_id)
    {
        $this->setAsigId($asig_id);
        $this->setInstructorInstId($instructor_inst_id);
        $this->setAsigFechaIni($asig_fecha_ini);
        $this->setAsigFechaFin($asig_fecha_fin);
        $this->setFichaFichId($ficha_fich_id);
        $this->setAmbienteAmbId($ambiente_amb_id);
        $this->setCompetenciaCompId($competencia_comp_id);
        $this->db = Conexion::getConnect();
    }
    //getters 

    public function getAsigId()
    {
        return $this->asig_id;
    }
    public function getInstructorInstId()
    {
        return $this->instructor_inst_id;
    }
    public function getAsigFechaIni()
    {
        return $this->asig_fecha_ini;
    }
    public function getAsigFechaFin()
    {
        return $this->asig_fecha_fin;
    }
    public function getFichaFichId()
    {
        return $this->ficha_fich_id;
    }
    public function getAmbienteAmbId()
    {
        return $this->ambiente_amb_id;
    }
    public function getCompetenciaCompId()
    {
        return $this->competencia_comp_id;
    }

    //setters 
    public function setAsigId($asig_id)
    {
        $this->asig_id = $asig_id;
    }
    public function setInstructorInstId($instructor_inst_id)
    {
        $this->instructor_inst_id = $instructor_inst_id;
    }
    public function setAsigFechaIni($asig_fecha_ini)
    {
        $this->asig_fecha_ini = $asig_fecha_ini;
    }
    public function setAsigFechaFin($asig_fecha_fin)
    {
        $this->asig_fecha_fin = $asig_fecha_fin;
    }
    public function setFichaFichId($ficha_fich_id)
    {
        $this->ficha_fich_id = $ficha_fich_id;
    }
    public function setAmbienteAmbId($ambiente_amb_id)
    {
        $this->ambiente_amb_id = $ambiente_amb_id;
    }
    public function setCompetenciaCompId($competencia_comp_id)
    {
        $this->competencia_comp_id = $competencia_comp_id;
    }
    //crud
    public function create()
    {
        $query = "INSERT INTO asignacion (instructor_inst_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id) 
        VALUES (:instructor_inst_id, :asig_fecha_ini, :asig_fecha_fin, :ficha_fich_id, :ambiente_amb_id, :competencia_comp_id) RETURNING asig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':instructor_inst_id', $this->instructor_inst_id);
        $stmt->bindParam(':asig_fecha_ini', $this->asig_fecha_ini);
        $stmt->bindParam(':asig_fecha_fin', $this->asig_fecha_fin);
        $stmt->bindParam(':ficha_fich_id', $this->ficha_fich_id);
        $stmt->bindParam(':ambiente_amb_id', $this->ambiente_amb_id);
        $stmt->bindParam(':competencia_comp_id', $this->competencia_comp_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['asig_id'] ?? 0;
    }
    public function read()
    {
        $sql = "SELECT * FROM asignacion WHERE instructor_inst_id = :instructor_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':instructor_id' => $this->instructor_inst_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM asignacion";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update()
    {
        $query = "UPDATE asignacion SET instructor_inst_id = :instructor_inst_id, asig_fecha_ini = :asig_fecha_ini, asig_fecha_fin = :asig_fecha_fin, ficha_fich_id = :ficha_fich_id, ambiente_amb_id = :ambiente_amb_id, competencia_comp_id = :competencia_comp_id WHERE asig_id = :asig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':instructor_inst_id', $this->instructor_inst_id);
        $stmt->bindParam(':asig_fecha_ini', $this->asig_fecha_ini);
        $stmt->bindParam(':asig_fecha_fin', $this->asig_fecha_fin);
        $stmt->bindParam(':ficha_fich_id', $this->ficha_fich_id);
        $stmt->bindParam(':ambiente_amb_id', $this->ambiente_amb_id);
        $stmt->bindParam(':competencia_comp_id', $this->competencia_comp_id);
        $stmt->bindParam(':asig_id', $this->asig_id);
        $stmt->execute();
        return $stmt;
    }
    public function delete()
    {
        $query = "DELETE FROM asignacion WHERE asig_id = :asig_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':asig_id', $this->asig_id);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Validación de Disponibilidad (Cruce de 3 Vías)
     * Retorna un string con el error si hay choque, o false si está todo libre.
     */
    public static function verificarConflicto($instructor_id, $ambiente_id, $ficha_id, $fecha_ini, $fecha_fin, $hora_ini, $hora_fin, $ignorar_asig_id = null)
    {
        $db = Conexion::getConnect();
        
        // La fórmula de solapamiento clásico: (InicioA < FinB) y (FinA > InicioB)
        // Se aplica tanto para fechas como para horas.
        $sql = "
            SELECT a.asig_id, a.instructor_inst_id, a.ambiente_amb_id, a.ficha_fich_id
            FROM asignacion a
            INNER JOIN detalle_asignacion da ON a.asig_id = da.asignacion_asig_id
            WHERE (a.asig_fecha_ini <= :fecha_fin AND a.asig_fecha_fin >= :fecha_ini)
              AND (da.detasig_hora_ini::time < :hora_fin::time AND da.detasig_hora_fin::time > :hora_ini::time)
              AND (
                  a.instructor_inst_id = :instructor_id 
                  OR a.ambiente_amb_id = :ambiente_id 
                  OR a.ficha_fich_id = :ficha_id
              )
        ";

        if ($ignorar_asig_id) {
            $sql .= " AND a.asig_id != :ignorar_asig_id";
        }

        $stmt = $db->prepare($sql);
        $params = [
            ':fecha_fin' => $fecha_fin,
            ':fecha_ini' => $fecha_ini,
            ':hora_fin' => $hora_fin,
            ':hora_ini' => $hora_ini,
            ':instructor_id' => $instructor_id,
            ':ambiente_id' => $ambiente_id,
            ':ficha_id' => $ficha_id
        ];

        if ($ignorar_asig_id) {
            $params[':ignorar_asig_id'] = $ignorar_asig_id;
        }

        $stmt->execute($params);
        $conflictos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($conflictos) > 0) {
            // Analizar el tipo de conflicto para dar un mensaje exacto
            foreach ($conflictos as $c) {
                if ($c['instructor_inst_id'] == $instructor_id) {
                    return "El Instructor ya tiene una clase asignada en ese bloque de fecha y hora.";
                }
                if ($c['ambiente_amb_id'] == $ambiente_id) {
                    return "El Ambiente (Salón/Laboratorio) ya está ocupado en ese horario.";
                }
                if ($c['ficha_fich_id'] == $ficha_id) {
                    return "La Ficha ya tiene programación asignada en ese bloque horario.";
                }
            }
            return "Existe un conflicto de horario (cruce detectado).";
        }

        return false; // No hay conflictos, vía libre.
    }
}
