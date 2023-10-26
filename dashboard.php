<?php
include_once 'db/connect_db.php';
session_start();

if ($_SESSION['username'] == "") {
  header('location:index.php');
} else {
  if ($_SESSION['role'] == "alumno") {
    include_once 'inc/header_estudiante.php';
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

  <!-- Preloader -->

  <BR></BR>
  <?php
  if ($_SESSION['role'] == "docente") { ?>
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>150</h3>

              <p>MIS CLASES</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>NOTIFICACIONES</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>
              <p>ACTIVIDADES</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>CONTENIDO</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </section>
  <?php
  }
  ?>
  <?php
  if ($_SESSION['role'] == "administrador") { ?>
    <!-- Main content -->
    <section>
      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">NOTIFICACIONES</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                <table class="table table-striped" id="myBestProduct">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>FECHA</th>
                      <th>NOMBRE</th>
                      <th>COREO</th>
                      <th>ASUNTO</th>
                      <th>MENSAJE</th>
                      <th>TELEFONO</th>
                      <th>CIUDAD</th>
                    </tr>

                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php
  }

  ?>

</div>
<!-- Calendar -->

<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      defaultView: 'month'
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#myBestProduct').DataTable();
  });
</script>


<?php
include_once 'inc/footer_all.php';
?>