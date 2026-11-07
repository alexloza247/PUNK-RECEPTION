<?php
require_once 'conexion.php';

class Noticia
{
        private $titulo; 
        private $contenido;
        private $categoria;
        private $fecha_publicacion;

    public function __construct($titulo, $contenido, $categoria, $fecha_publicacion)
    {
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->categoria = $categoria;
        $this->fecha_publicacion = $fecha_publicacion;
    }

    public function guardar()
    {
        $pdo = Conexion::conectar();

        $sql = "INSERT INTO Noticia (titulo, contenido, categoria, fecha_publicacion)
                VALUES (:titulo, :contenido, :categoria, :fecha_publicacion)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'   => $this->titulo,
            ':contenido'   => $this->contenido,
            ':categoria' => $this->categoria,
            ':fecha_publicacion' => $this->fecha_publicacion
        ]);
    }

    public static function listar()
    {
        $pdo = Conexion::conectar();
        $sql = "SELECT id_noticia, titulo, contenido, categoria, fecha_publicacion FROM Noticia ORDER BY fecha_publicacion DESC LIMIT 10";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>
