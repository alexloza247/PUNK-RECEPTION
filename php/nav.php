<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$alumnos = $_SESSION['alumnos'] ?? [];
$idAlumnoActivo = (int) ($_SESSION['id'] ?? 0);
$alumnoActivo = null;

foreach ($alumnos as $alumno) {
    if ((int) $alumno['id_alumno'] === $idAlumnoActivo) {
        $alumnoActivo = $alumno;
        break;
    }
}

$nombreUsuario = $alumnoActivo
    ? trim($alumnoActivo['nombre'] . ' ' . $alumnoActivo['apellidos'])
    : ($_SESSION['usuario']['correo'] ?? 'Iniciar sesión');
?>
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="images/punk.png" class="logo-rp mr-3">PUNK RECEPTION</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
      Menú <i class="fas fa-bars ml-1"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-newspaper mr-1"></i> Avisos</a></li>
        <li class="nav-item"><a class="nav-link" href="reports.php"><i class="fas fa-graduation-cap mr-1"></i> Reportes</a></li>
        <li class="nav-item"><a class="nav-link" href="galery.php"><i class="fas fa-images mr-1"></i> Galería</a></li>
        <li class="nav-item"><a class="nav-link" href="payments.php"><i class="fas fa-file-invoice-dollar mr-1"></i> Pagos</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-chalkboard-teacher mr-1"></i> Contacto</a></li>
        <li class="nav-item ml-lg-2">
          <div class="dropdown mt-1">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" id="activeUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-circle mr-1"></i>
              <span id="userRoleLabel"><?php echo htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8'); ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-3" aria-labelledby="activeUserMenu">
              <?php if (!empty($_SESSION['id_tutor']) && $alumnos): ?>
                <form action="php/cambiar_alumno.php" method="POST">
                  <label for="selectAlumno" class="mb-1">Alumno activo</label>
                  <select class="form-control form-control-sm" id="selectAlumno" name="id_alumno" onchange="this.form.submit()">
                    <?php foreach ($alumnos as $alumno): ?>
                      <?php $nombreAlumno = trim($alumno['nombre'] . ' ' . $alumno['apellidos']); ?>
                      <option value="<?php echo (int) $alumno['id_alumno']; ?>"<?php echo (int) $alumno['id_alumno'] === $idAlumnoActivo ? ' selected' : ''; ?>>
                        <?php echo htmlspecialchars($nombreAlumno, ENT_QUOTES, 'UTF-8'); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <noscript><button class="btn btn-primary btn-sm btn-block mt-2" type="submit">Cambiar alumno</button></noscript>
                </form>
                <div class="dropdown-divider"></div>
              <?php endif; ?>
              <?php if (!empty($_SESSION['usuario'])): ?>
                <a class="dropdown-item" href="php/con_logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión</a>
              <?php else: ?>
                <a class="dropdown-item" href="inicio.html"><i class="fas fa-sign-in-alt mr-2"></i>Iniciar sesión</a>
              <?php endif; ?>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
