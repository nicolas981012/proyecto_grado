<?php
include_once 'db/connect_db.php';
session_start();
error_reporting(0);
if ($_SESSION['username'] == "") {
  header('location:index.php');
} else {
  if ($_SESSION['role'] == "alumno") {
    include_once 'inc/header_alumno.php';
  } else {
    if ($_SESSION['role'] == "docente") {
      include_once 'inc/header_docente.php';
    } else {
      if ($_SESSION['role'] == "administrador") {
        include_once 'inc/header_admin.php';
      }
    }
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<style>
    .card {
      border: 1px solid #d1d1d1;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin: 10px;
    }

    /* Estilo del encabezado de la tarjeta */
    .card-header {
      background-color: #007bff;
      color: #fff;
      border-bottom: none;
    }

    /* Estilo del título en el encabezado */
    .card-title {
      font-size: 1.25rem;
      margin: 0;
    }

    /* Estilo del cuerpo de la tarjeta */
    .card-body {
      padding: 10px;
    }

    /* Estilo del pie de la tarjeta */
    .card-footer {
      background-color: #f8f9fa;
      text-align: right;
      padding: 5px 10px;
    }

    /* Estilo del enlace en el pie de la tarjeta */
    .card-footer a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    /* Cambia el color del enlace al pasar el cursor */
    .card-footer a:hover {
      color: #0056b3;
    }
  </style>
  <?php
  $docente = $_SESSION['Cedula'];
  if ($_SESSION['role'] == "alumno") {
    echo '<section class="content">';
    echo '<center>';
    echo '<h1>' . "MIS CLASES" . '</h1>';
    echo '</center>';
    echo '<br>';
    echo '<div class="row">';
    // Itera sobre los cursos inscritos y muéstralos en el dashboard

    $select = $pdo->prepare("SELECT c.Nombre as clase,c.Descripcion as descripcion
    FROM alumno a
    join grado b
    ON a.Grado = b.id_grado
    join clase c
    ON b.id_grado=c.grado
    WHERE a.id_Alumno = $docente");
    $select->execute();
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
      $cursosinscritos[] = $row;
    }
    foreach ($cursosinscritos as $curso) {
      echo '<div class="col-lg-3 col-6">';
      echo '<div class="small-box bg-primary">';
      echo '<div class="inner">';
      echo '<h3>' . $curso['clase'] . '</h3>';
      echo '<p>' . $curso['descripcion'] . '</p>';
      echo '</div>';
      echo '<div class="icon">';
      echo '<i class=""></i>';
      echo '</div>';
      echo '<a href="#" class="small-box-footer">contenido <i class="fas fa-arrow-circle-right"></i></a>';
      echo '<a href="#" class="small-box-footer">actividades <i class="fas fa-arrow-circle-right"></i></a>';
      echo '</div>';
      echo '</div>';
    }
    echo '</div>';
    echo '</section>';
  }
  ?>
  <?php
  if ($_SESSION['role'] == "alumno") {
    echo '<section class="content">';
    echo '<center>';
    echo '<h1>' . "NOTIFICACIONES" . '</h1>';
    echo '</center>';
    echo '<div class="row">';

    // Itera sobre las notificaciones de clases del estudiante

    $select = $pdo->prepare("SELECT d.Asunto as asunto,d.Mensaje as mensaje,c.Nombre as clase
    FROM alumno a
    join grado b
    ON a.Grado = b.id_grado
    join clase c
    ON b.id_grado=c.grado
    join notificaciones d
    ON d.Clase_idClase=c.idClase
    WHERE a.id_Alumno = $docente");
    $select->execute();
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
      $notificacionesClases[] = $row;
    }
    foreach ($notificacionesClases as $notificacion) {
      echo '<div class="col-lg-4 col-md-6">';
      echo '<div class="card card-info">';
      echo '<div class="card-header">';
      echo '<center>';
      echo '<h3 class="card-title">' . $notificacion['clase'] . '</h3>';
      echo '</div>';
      echo '<div class="card-body">';
      echo '<p>' . $notificacion['asunto'] . '</p>';
      echo '<p>' . $notificacion['mensaje'] . '</p>';
      echo '</div>';
      echo '<div class="card-footer">';
      echo '<a href="">Más información</a>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
    echo '</div>';
    echo '</section>';
  }
  ?>
</div>

<!-- Calendar -->

<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $('#myBestProduct').DataTable();
    $('.carousel').carousel();
  });
</script>


<?php
include_once 'inc/footer_all.php';
?>