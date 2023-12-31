<?php
include_once 'db/connect_db.php';
error_reporting(0);
session_start();
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-repeat:no-repeat;background-size:cover;">
  <style>
    .card {
      border: 1px solid #d1d1d1;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin: 10px;
    }

    /* Estilo del encabezado de la tarjeta */
    .card-header {
      background-color: green;
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
    echo '<section class="content" >';
    echo '<h3 style="font-family:lobster;background-color:#f5f5f5;padding-left:20px;margin:0">' . "MIS CLASES" . '</h3>';
    echo '<br>';
    echo '<div class="row">';
    // Itera sobre los cursos inscritos y muéstralos en el dashboard

    $select = $pdo->prepare("SELECT c.Nombre as clase,c.Descripcion as descripcion,c.idClase as id,c.Fecha_inicial as inicial,c.Fecha_final as final
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
      echo '<div class="col-lg-3 col-6" style="">';
      echo '<div class="small-box bg-primary" style="background-color:rgba(0,0,0,0); border:1px solid #d1d1d1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);padding: 10px;margin: 10px;">';
      echo '<div class="inner">';
      echo '<center>';
      echo '<h4 style="color:black"><strong>' . $curso['clase'] . '</strong></h4>';
      echo '</center>';
      echo '<br>';
      echo '<p style="color:black">' . $curso['descripcion'] . '</p>';
      echo '<p style="color:black">' . $curso['inicial'] . '' . ' / ' . '' . $curso['final'] . '</p>';
      echo '</div>';
      echo '<div class="icon">';
      echo '<i class=""></i>';
      echo '</div>';
      echo '<a href="contenido_clase.php?clase_id=' . $curso['id'] . '" class="small-box-footer" style="background-color:red">contenido <i class="glyphicon glyphicon-duplicate"></i></a>';
      echo '<a href="actividad_clase.php?clase_id=' . $curso['id'] . '" class="small-box-footer" style="background-color:blue">actividades <i class="glyphicon glyphicon-calendar"></i></a>';
      echo '<a href="./misc/diploma.php?id=' . $curso['clase'] .'" target="_blank" class="small-box-footer" style="background-color:#d9ad26">diploma <i class="glyphicon glyphicon-calendar"></i></a>';
      echo '</div>';
      echo '</div>';
    }
    echo '</div>';
    echo '</section>';
  }
  ?>
  <?php
  if ($_SESSION['role'] == "alumno") {
    echo '<section class="content" >';

    echo '<h3 style="font-family:lobster;background-color:#f5f5f5;padding-left:20px;margin:0">' . "NOTIFICACIONES" . '</h3>';
    echo '<br>';
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

  <?php
  if ($_SESSION['role'] == "administrador") {
    $select = $pdo->prepare("SELECT b.Grado_numerico as grado,count(a.id_Alumno) as alumnos
      FROM alumno a
      join grado b
      ON a.Grado = b.id_grado
      group by b.Grado_numerico;");
    $select->execute();
    $total = [];
    $date = [];
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $total[] = $alumnos;
      $date[] = $grado;
    }
  ?>
    <section class="content">
      <br>
      <div class="row">
        <div class="chart">
          <canvas id="nn" style="height:250px;">
          </canvas>
        </div>
      </div>
    </section>

  <?php
  }
  ?>
</div>

<script>
 document.addEventListener("DOMContentLoaded",
 function(){
  var ctx = document.getElementById('nn');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($date); ?>,
      datasets: [{
        label: 'estudiantes por grado',
        data: <?php echo json_encode($total); ?>,
        backgroundColor: 'rgb(13, 192, 58)',
        borderColor: 'rgb(32, 204, 75)',
        borderWidth: 1
      }]
    },
    options: {}
  });
});
</script>
<?php
include_once 'inc/footer_all.php';
?>