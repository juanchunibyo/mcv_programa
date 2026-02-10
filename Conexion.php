<?php

class Conexion
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    public static function getConnect()
    {
        if (!isset(self::$instance)) {
            $pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            self::$instance = new PDO('pgsql:host=localhost;dbname=transversal', 'root', '', $pdo_options);
        }
        return self::$instance;
    }
}

?>