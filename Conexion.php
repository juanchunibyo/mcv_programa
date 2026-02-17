<?php
require_once __DIR__ . '/EnvLoader.php';

$envLoader = new EnvLoader(__DIR__ . '/.env');
$envLoader->load();

class Conexion
{
    private static $instance = null;

    private function __construct() {}

    public static function getConnect()
    {
        if (!self::$instance) {

            $host = EnvLoader::get('DB_HOST');
            $port = EnvLoader::get('DB_PORT');
            $dbname = EnvLoader::get('DB_NAME');
            $user = EnvLoader::get('DB_USER');
            $password = EnvLoader::get('DB_PASSWORD');

            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

            try {
error_log("Intentando conectar a: " . $dsn);
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
