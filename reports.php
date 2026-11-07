<?php
session_start();

$nombreAlumnoReporte = isset($_SESSION['nombre'])
    ? trim($_SESSION['nombre'] . ' ' . ($_SESSION['apellido'] ?? ''))
    : ' Alumno desconocido';
$idAlumnoReporte = !empty($_SESSION['id_tutor']) ? (int) ($_SESSION['id'] ?? 0) : 0;

require_once 'php/reporte.php';

$lista = $idAlumnoReporte > 0 ? Reporte::listar($idAlumnoReporte) : [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Reportes Académicos - Punk Reception</title>

  <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
  <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- Barra de navegación -->
  <?php require 'php/nav.php'; ?>

  <!-- Header Estilo Clean Blog -->
  <header class="masthead">
    <div class="container">
      <div class="site-heading">
        <h1>Punk Reception</h1>
        <span class="subheading">Portal académico y seguimiento para padres - Robot Punk</span>
      </div>
    </div>
  </header>

  <!-- Contenido Principal -->
  <div class="container mb-5">
    <section id="academico" class="printable-area">
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
        <h2><i class="fas fa-chart-line text-primary mr-2"></i>Reportes de desempeño y conducta</h2>
        <div class="no-print">
          <button class="btn btn-dark btn-sm" onclick="window.print()"><i class="fas fa-print"></i> Imprimir Reporte</button>
        </div>
      </div>

      <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
          <span><i class="fas fa-child mr-2"></i> Alumno: <strong id="reportStudentName"><?php echo htmlspecialchars($nombreAlumnoReporte, ENT_QUOTES, 'UTF-8'); ?></strong></span>
        </div>

        <?php if (count($lista) === 0): ?>
          <div class="card-body">
            <p>No hay reportes registrados para este alumno.</p>
          </div>
        <?php else: ?>
        <?php foreach ($lista as $reporte): ?>
          <article class="card-body border-top">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
              <h5 class="card-title mb-md-0">
                <i class="far fa-calendar-alt text-primary mr-2"></i>
                Reporte del <?php echo htmlspecialchars(date('d/m/Y', strtotime($reporte['fecha'])), ENT_QUOTES, 'UTF-8'); ?>
              </h5>
              <small class="text-muted">
                <i class="fas fa-user-edit mr-1"></i>Profesor: 
                <?php echo htmlspecialchars($reporte['profesor_nombre'] . ' ' . $reporte['profesor_apellidos'], ENT_QUOTES, 'UTF-8'); ?>
              </small>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3 mb-md-0">
                <div class="h-100 p-3 border rounded bg-light">
                  <h6 class="text-success font-weight-bold mb-2">
                    <i class="fas fa-chart-line mr-1"></i> Desempeño académico
                  </h6>
                  <p class="mb-0"><?php echo nl2br(htmlspecialchars($reporte['desempeno'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="h-100 p-3 border rounded bg-light">
                  <h6 class="text-info font-weight-bold mb-2">
                    <i class="fas fa-clipboard-check mr-1"></i> Conducta
                  </h6>
                  <p class="mb-0"><?php echo nl2br(htmlspecialchars($reporte['conducta'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
      <p class="mb-1">&copy; 2026 <strong>Punk Reception</strong> - Robot Punk</p>
      <small class="text-muted">Sistema para Gestión Académica, Administrativa y de Comunicación para Padres de Familia</small>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>