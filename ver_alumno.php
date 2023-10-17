<?php
  include_once 'db/connect_db.php';
  include_once 'misc/plugin.php';
  session_start();
  error_reporting(0);
  if ($_SESSION['username'] == "") {
      header('location:index.php');
  } else {
      if ($_SESSION['role'] == "ESTUDIANTE") {
          include_once 'inc/header_estudiante.php';
      } else {
          if ($_SESSION['role'] == "DOCENTE") {
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
    <section class="content-header">
      <h1>
        ESTUDIANTES
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-body">
              <?php
                $id = $_GET["id"];

                $select = $pdo->prepare("SELECT * FROM alumno WHERE id_Alumno='$id'");
                $select->execute();
                while($row = $select->fetch(PDO::FETCH_OBJ)){ ?>

                <div class="col-md-6">
                  <ul class="list-group">

                    <center><p class="list-group-item list-group-item-success">ESTUDIANTE</p></center>
                    <li class="list-group-item"> <b>CEDULA</b>     :<span class="label badge pull-right"><?php echo $row->id_Alumno; ?></span></li>
                    <li class="list-group-item"><b>NOMBRES</b>    :<span class="label label-info pull-right"><?php echo $row->Nombre; ?></span></li>
                    <li class="list-group-item"><b>APELLIDOS</b>        :<span class="label label-primary pull-right"><?php echo $row->Apellido; ?></span></li>
                    <li class="list-group-item"><b>TELEFONO</b>  :<span class="label label-warning pull-right"><?php echo $row->Telefono; ?></span></li>
                    <li class="list-group-item"><b>GRADO</b>     :<span class="label label-warning pull-right"><?php echo $row->Grado; ?></span></li>
                    <li class="list-group-item"><b>ESTADO</b>           :<span class="label label-success pull-right"><?php echo $row->estado; ?></span></li>
                    <li class="list-group-item"><b>CORREO</b>     :<span class="label label-warning pull-right"><?php echo $row->Correo; ?></span></li>
                    <li class="list-group-item"><b>CONTRASEÑA</b>     :<span class="label label-warning pull-right"><?php echo $row->Contrasena; ?></span></li>
                    <li class="list-group-item"><b>USUARIO</b>           :<span class="label label-success pull-right"><?php echo $row->Usuario; ?></span></li>
                  </ul>
                </div>
              <?php
                }
              ?>
            </div>
            <div class="box-footer">
                <a href="alumnos.php" class="btn btn-warning">VOLVER</a>
            </div>

        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php
    include_once'inc/footer_all.php';
 ?>