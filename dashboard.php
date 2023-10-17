<?php
include_once 'db/connect_db.php';
session_start();
error_reporting(0);
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
<section class="content">
        <section></section>
  <?php  
  if ($_SESSION['role'] == "administrador")  {?>
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



  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $('#myBestProduct').DataTable();
  });
</script>


<?php
include_once 'inc/footer_all.php';
?>