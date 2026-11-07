<?php
session_start();
require_once 'php/proyecto.php';

$idAlumnoActivo = (int) ($_SESSION['id'] ?? 0);
$lista = $idAlumnoActivo > 0 ? Proyecto::listar($idAlumnoActivo) : [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Galería de Proyectos - Punk Reception</title>

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
    <section id="galeria">
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
        <h2><i class="fas fa-cubes text-primary mr-2"></i>Portafolio digital de proyectos</h2>
      </div>

      <div class="row">
        <!-- Proyectos -->
        <?php if (count($lista) === 0): ?>
          <p>No hay proyectos registrados.</p>
        <?php else: ?>
        <?php foreach ($lista as $prod): ?>
        <div class="col-md-4 mb-4">
          <div class="card card-project h-100">
            <img src="<?php echo htmlspecialchars($prod['archivo_multimedia']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prod['titulo']); ?>">
            <div class="card-body">
              <span class="badge badge-primary mb-2"><?php echo htmlspecialchars($prod['clase']); ?></span>
              <h5 class="card-title"><?php echo htmlspecialchars($prod['titulo']); ?></h5>
              <p class="card-text text-muted"><?php echo htmlspecialchars($prod['descripcion']); ?></p>
              <p class="card-text"><small class="text-muted">Fecha: <?php echo htmlspecialchars($prod['fecha']); ?></small></p>
            </div>
          </div>
        </div>
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