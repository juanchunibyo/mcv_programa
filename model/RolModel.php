<?php
require_once __DIR__ . '/../Conexion.php';

class RolModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConnect();
    }

    /**
     * Obtiene todos los roles disponibles
     */
    public function obtenerRoles()
    {
        $sql = "SELECT rol_id, rol_nombre FROM rol ORDER BY rol_id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
