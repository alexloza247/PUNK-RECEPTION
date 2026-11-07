<?php
class Conexion
{
    public static function conectar()
    {
        try {
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]; //manejo de errores

            $pdo = new PDO("mysql:host=localhost;dbname=PUNK_RECEPTION;charset=utf8","root", "", $opciones);

            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
