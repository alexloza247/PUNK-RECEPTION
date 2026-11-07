<?php
session_start();

$paginasPermitidas = ['index.html', 'reports.html', 'galery.html', 'payments.html', 'contact.html'];
$paginaVolver = $_GET['volver'] ?? 'index.html';
if (!in_array($paginaVolver, $paginasPermitidas, true)) {
    $paginaVolver = 'index.html';
}

function volverAPagina(string $pagina, string $estado = ''): void
{
    $sufijo = $estado === '' ? '' : '?alumno=' . urlencode($estado);
    header('Location: ../' . $pagina . $sufijo, true, 303);
    exit;
}

if (empty($_SESSION['id_tutor'])) {
    volverAPagina('inicio.html', 'sesion');
}

$idAlumno = filter_input(INPUT_GET, 'id_alumno', FILTER_VALIDATE_INT);
if (!$idAlumno) {
    volverAPagina($paginaVolver, 'invalido');
}

try {
    require_once __DIR__ . '/conexion.php';

    $idTutor = (int) $_SESSION['id_tutor'];
    $consulta = $conexion->prepare(
        'SELECT id_alumno, nombre, apellidos FROM Alumno WHERE id_alumno = ? AND id_tutor = ? LIMIT 1'
    );
    $consulta->bind_param('ii', $idAlumno, $idTutor);
    $consulta->execute();
    $alumno = $consulta->get_result()->fetch_assoc();

    if (!$alumno) {
        volverAPagina($paginaVolver, 'invalido');
    }

    $_SESSION['id'] = (int) $alumno['id_alumno'];
    $_SESSION['nombre'] = $alumno['nombre'];
    $_SESSION['apellido'] = $alumno['apellidos'];

    volverAPagina($paginaVolver);
} catch (Throwable $error) {
    error_log($error->getMessage());
    volverAPagina($paginaVolver, 'error');
}
