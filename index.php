<?php
session_start();

require_once 'php/noticia.php';
require_once 'php/evento.php';

$listaN = Noticia::listar();
$listaE = Evento::listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Avisos y Calendario - Punk Reception</title>

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
    <?php if (isset($_GET['error']) && $_GET['error'] === 'alumno'): ?>
      <div class="alert alert-danger" role="alert">No se pudo cambiar el alumno. Inténtalo de nuevo.</div>
    <?php endif; ?>
    <section id="noticias">
      <div class="row">
        <!-- Muro de Noticias -->
        <div class="col-lg-7 mb-4">
          <h3 class="border-bottom pb-2 mb-3"><i class="fas fa-bullhorn text-primary mr-2"></i>Muro de noticias y anuncios</h3>
          
          <?php if (count($listaN) === 0): ?>
          <p>No hay proyectos registrados.</p>
          <?php else: ?>
          <?php foreach ($listaN as $noticia): ?>
          <div class="card mb-3 shadow-sm">
            <div class="card-body">
              <span class="badge badge-info float-right"><?php echo htmlspecialchars($noticia['categoria']); ?></span>
              <h5 class="card-title"><?php echo htmlspecialchars($noticia['titulo']); ?></h5>
              <p class="card-text text-muted mb-2"><small><i class="far fa-clock"></i> Publicado el <?php echo date('d \d\e F, Y', strtotime($noticia['fecha_publicacion'])); ?></small></p>
              <p class="card-text"><?php echo nl2br(htmlspecialchars($noticia['contenido'])); ?></p>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Calendario Interactivo -->
        <div class="col-lg-5 mb-4">
          <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <h3><i class="far fa-calendar-alt text-primary mr-2"></i>Calendario</h3>
          </div>
          <ul class="list-group" id="listaEventos">
            <?php if (count($listaE) === 0): ?>
              <li class="list-group-item">No hay eventos programados.</li>
            <?php else: ?>
            <?php foreach ($listaE as $evento): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong><?php echo htmlspecialchars(date('d M', strtotime($evento['fecha_programada']))); ?> - <?php echo htmlspecialchars($evento['titulo']); ?></strong>
                  <br><small class="text-muted"><?php echo htmlspecialchars($evento['descripcion']); ?></small>
                </div>
                <span class="badge badge-primary badge-pill"><?php echo htmlspecialchars(date('h:i A', strtotime($evento['fecha_programada']))); ?></span>
              </li>
            <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
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
