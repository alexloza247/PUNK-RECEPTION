<?php
require_once __DIR__ . '/conexion.php';

class Reporte
{
        private $fecha;
        private $desempeno;
        private $conducta;
        private $id_profesor;
        private $id_alumno;

    public function __construct($fecha, $desempeno, $conducta, $id_profesor, $id_alumno)
    {
        $this->fecha = $fecha;
        $this->desempeno = $desempeno;
        $this->conducta = $conducta;
        $this->id_profesor = $id_profesor;
        $this->id_alumno = $id_alumno;
    }

    public function guardar()
    {
        $pdo = Conexion::conectar();

        $sql = "INSERT INTO Reporte (fecha, desempeno, conducta, id_profesor, id_alumno)
                VALUES (:fecha, :desempeno, :conducta, :id_profesor, :id_alumno)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fecha' => $this->fecha,
            ':desempeno' => $this->desempeno,
            ':conducta' => $this->conducta,
            ':id_profesor' => $this->id_profesor,
            ':id_alumno' => $this->id_alumno
        ]);
    }

    public static function listar($id_alumno)
    {
        $pdo = Conexion::conectar();
        $sql = "SELECT r.id_reporte, r.fecha, r.desempeno, r.conducta, r.id_profesor, r.id_alumno,
                       p.nombre AS profesor_nombre, p.apellidos AS profesor_apellidos
                FROM Reporte r
                INNER JOIN Profesor p ON r.id_profesor = p.id_profesor
                WHERE r.id_alumno = :id_alumno
                ORDER BY r.fecha DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_alumno' => $id_alumno]);
        return $stmt->fetchAll();
    }
}
?>
