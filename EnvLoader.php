<?php

class EnvLoader
{
    protected $path;

    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new Exception("El archivo .env no existe en: {$path}");
        }
        $this->path = $path;
    }

    public function load()
    {
        if (!is_readable($this->path)) {
            throw new Exception("El archivo .env no es legible");
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignorar comentarios
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parsear línea
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                // Remover comillas si existen
                $value = trim($value, '"\'');

                // Establecer variable de entorno
                if (!array_key_exists($name, $_ENV)) {
                    putenv("{$name}={$value}");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }

    public static function get($key, $default = null)
    {
        $value = getenv($key);
        
        if ($value === false) {
            return $default;
        }

        // Convertir valores booleanos
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'null':
            case '(null)':
                return null;
        }

        return $value;
    }
}
