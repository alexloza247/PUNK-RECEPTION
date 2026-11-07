<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../inicio.html');
    exit;
}

$correo = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$contrasena = $_POST['password'] ?? '';
$rol = $_POST['rol'] ?? '';

$roles = [
    'Padre/Tutor' => ['tabla' => 'Tutor', 'id' => 'id_tutor'],
    'Profesor/Docente' => ['tabla' => 'Profesor', 'id' => 'id_profesor']
];

if (!$correo || !is_string($contrasena) || $contrasena === '' || !isset($roles[$rol])) {
    header('Location: ../inicio.html?error=login#modalLogin');
    exit;
}

require_once __DIR__ . '/conexion.php';
$pdo = Conexion::conectar();
$usuario = $roles[$rol];

$consulta = $pdo->prepare(
    "SELECT {$usuario['id']} AS id, correo, contrasena
     FROM {$usuario['tabla']}
     WHERE correo = :correo
     LIMIT 1"
);
$consulta->execute([':correo' => $correo]);
$datos = $consulta->fetch();

if (!$datos) {
    header('Location: ../inicio.html?error=login#modalLogin');
    exit;
}

$contrasenaGuardada = (string) $datos['contrasena'];
if (!password_verify($contrasena, $contrasenaGuardada)) {
    if (!hash_equals($contrasenaGuardada, $contrasena)) {
        header('Location: ../inicio.html?error=login#modalLogin');
        exit;
    }

    // Migra contraseñas heredadas en texto plano al hash al iniciar sesión.
    $actualizar = $pdo->prepare(
        "UPDATE {$usuario['tabla']}
         SET contrasena = :contrasena
         WHERE {$usuario['id']} = :id"
    );
    $actualizar->execute([
        ':contrasena' => password_hash($contrasena, PASSWORD_DEFAULT),
        ':id' => $datos['id']
    ]);
}

session_regenerate_id(true);
$_SESSION['usuario'] = [
    'id' => (int) $datos['id'],
    'correo' => $datos['correo'],
    'rol' => $rol
];

if ($rol === 'Padre/Tutor') {
    $consultaAlumnos = $pdo->prepare(
        'SELECT id_alumno, nombre, apellidos
         FROM Alumno
         WHERE id_tutor = :id_tutor
         ORDER BY apellidos, nombre'
    );
    $consultaAlumnos->execute([':id_tutor' => $datos['id']]);
    $alumnos = $consultaAlumnos->fetchAll();

    if (!$alumnos) {
        $_SESSION = [];
        session_destroy();
        header('Location: ../inicio.html?error=sin_alumnos#modalLogin');
        exit;
    }

    $_SESSION['id_tutor'] = (int) $datos['id'];
    $_SESSION['alumnos'] = $alumnos;
    $_SESSION['id'] = (int) $alumnos[0]['id_alumno'];
    $_SESSION['nombre'] = $alumnos[0]['nombre'];
    $_SESSION['apellido'] = $alumnos[0]['apellidos'];
} else {
    unset($_SESSION['id_tutor'], $_SESSION['alumnos'], $_SESSION['id'], $_SESSION['nombre'], $_SESSION['apellido']);
}

header('Location: ../index.php');
exit;