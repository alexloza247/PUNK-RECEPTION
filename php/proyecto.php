<?php
require_once 'conexion.php';

class Proyecto
{
        private $titulo;
        private $clase;
        private $descripcion;
        private $archivo_multimedia;
        private $fecha;
        private $id_alumno;

    public function __construct($titulo, $clase, $descripcion, $archivo_multimedia, $fecha, $id_alumno)
    {
        $this->titulo = $titulo;
        $this->clase = $clase;
        $this->descripcion = $descripcion;
        $this->archivo_multimedia = $archivo_multimedia;
        $this->fecha = $fecha;
        $this->id_alumno = $id_alumno;
    }

    public function guardar()
    {
        $pdo = Conexion::conectar();

        $sql = "INSERT INTO Proyecto (titulo, clase, descripcion,archivo_multimedia, fecha, id_alumno)
                VALUES (:titulo, :clase, :descripcion, :archivo_multimedia, :fecha, :id_alumno)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'   => $this->titulo,
            ':clase'   => $this->clase,
            ':descripcion' => $this->descripcion,
            ':archivo_multimedia' => $this->archivo_multimedia,
            ':fecha' => $this->fecha,
            ':id_alumno' => $this->id_alumno
        ]);
    }

    public static function listar($id_alumno)
    {
        $pdo = Conexion::conectar();
        $sql = "SELECT id_proyecto, titulo, clase, descripcion, archivo_multimedia, fecha, id_alumno FROM Proyecto WHERE id_alumno = :id_alumno ORDER BY fecha DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_alumno' => (int) $id_alumno]);
        return $stmt->fetchAll();
    }
}
?>
