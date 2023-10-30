<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
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
  <!-- Content Header (Page header) -->

  <!-- Main content -->
  
  <section class="content container-fluid">
  
    <div class="box box-success">
      
        <div class="col-md-8">
          <div class="box box-success">

            <!-- /.box-header -->
            <?php
            $id = $_GET["id"];
            $select = $pdo->prepare("SELECT * FROM clase WHERE idClase='$id'");
            $select->execute();
            $row = $select->fetch(PDO::FETCH_OBJ) ?>

            <div class="box box-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-black" style="background: url('upload/<?php echo $row->Imagen ?>'); background-size: 540px 120px;">

              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="box-header with-border">
                    <center>
                      <h3 class="widget-user-username"><?php echo $row->Nombre ?></h3>
                      <h5 class="widget-user-desc">class</h5>
                    </center>
                  </div>
                  <!-- /.col -->

                  <!-- /.col -->

                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <div class="box-body">
              <div class='detail-text'>
                <label for="name"><strong>ID:</strong></label>
                <span class='text-data'>
                  <?php echo $row->idClase; ?>
                </span><br>
                <label for="name"><strong>DOCENTE:</strong></label>
                <span class='text-data'>
                  <?php echo $row->Docente_idDocente ?>
                </span><br>
                <label for="name"><strong>NIVEL:</strong></label>
                <span class='text-data'>
                  <?php echo $row->Nivel; ?>
                </span><br>
                <label for="name"><strong>FECHA INICIAL:</strong></label>
                <span class='text-data'>
                  <?php echo $row->Fecha_inicial; ?>
                </span><br>
                <label for="name"><strong>FECHA FINAL:</strong></label>
                <span class='text-data'>
                  <?php echo $row->Fecha_final; ?>
                </span><br>
                <label for="name"><strong>DESCRIPCION:</strong></label>
                <span class='text-data'>
                  <?php echo $row->Descripcion; ?>
                </span><br>
                <label for="name"><strong>ALUMNOS GRADO:</strong></label>
                <span class='text-data'>
                  <?php echo $row->grado; ?>
                </span><br>
              </div>
            </div>

          </div>
          <center>
            <div class="box-footer">
              <a href="clases.php" class="btn btn-warning">VOLVER</a>
            </div>
          </center>
        
        </div>

    </div>

    
  </section>
 
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'inc/footer_all.php';
?>