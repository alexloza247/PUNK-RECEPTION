<?php
require_once 'conexion.php';

class Evento
{
        private $titulo;
        private $descripcion;
        private $fecha_programada;

    public function __construct($titulo, $descripcion, $fecha_programada)
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha_programada = $fecha_programada;
    }

    public function guardar()
    {
        $pdo = Conexion::conectar();

        $sql = "INSERT INTO Evento (titulo, descripcion, fecha_programada)
                VALUES (:titulo, :descripcion, :fecha_programada)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'   => $this->titulo,
            ':descripcion'   => $this->descripcion,
            ':fecha_programada' => $this->fecha_programada
        ]);
    }

    public static function listar()
    {
        $pdo = Conexion::conectar();
        $sql = "SELECT id_evento, titulo, descripcion, fecha_programada FROM Evento WHERE fecha_programada > CURDATE() ORDER BY fecha_programada DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>
