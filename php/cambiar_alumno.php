<?php
session_start();

if (empty($_SESSION['id_tutor'])) {
    header('Location: ../inicio.html');
    exit;
}

$idAlumno = filter_input(INPUT_POST, 'id_alumno', FILTER_VALIDATE_INT);
if (!$idAlumno) {
    header('Location: ../index.php?error=alumno');
    exit;
}

require_once __DIR__ . '/conexion.php';
$pdo = Conexion::conectar();
$consulta = $pdo->prepare(
    'SELECT id_alumno, nombre, apellidos
     FROM Alumno
     WHERE id_alumno = :id_alumno AND id_tutor = :id_tutor
     LIMIT 1'
);
$consulta->execute([
    ':id_alumno' => $idAlumno,
    ':id_tutor' => (int) $_SESSION['id_tutor']
]);
$alumno = $consulta->fetch();

if (!$alumno) {
    header('Location: ../index.php?error=alumno');
    exit;
}

$_SESSION['id'] = (int) $alumno['id_alumno'];
$_SESSION['nombre'] = $alumno['nombre'];
$_SESSION['apellido'] = $alumno['apellidos'];

header('Location: ../index.php');
exit;
