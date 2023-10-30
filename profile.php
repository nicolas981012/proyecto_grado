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


//if button updated clicked
if (isset($_POST['btn_update'])) {

  $oldpass = $_POST['oldpass'];
  $newpass = $_POST['newpass'];
  $confpass = $_POST['confpass'];
  $tabla= $_SESSION['role'];
  $id = $_SESSION['Cedula'];

  $select = $pdo->prepare("SELECT * FROM $tabla where Cedula='$id'");

  $select->execute();

  $row = $select->fetch(PDO::FETCH_ASSOC);

  $useremail_db = $row['Cedula'];
  $password_db = $row['Contrasena'];

  if ($oldpass == $password_db) {

    if ($newpass == $confpass) {

      $campo=sacarcampo();

      $update = $pdo->prepare("UPDATE $tabla SET Contrasena=:pass WHERE $campo=:email");

      $update->bindParam(':pass', $confpass);
      $update->bindParam(':email', $id);

      if ($update->execute()) {
        echo '<script type="text/javascript">
              jQuery(function validation(){
                swal("Correcto", "contraseña actualizada", "success", {
                  button: "Continue",
                });
              });
              </script>';
      } else {
        echo '<script type="text/javascript">
              jQuery(function validation(){
                swal("Oops", "contraseña no editada", "error", {
                  button: "Continue",
                });
              });
              </script>';
      }
    } else {
      echo '<script type="text/javascript">
            jQuery(function validation(){
              swal("Warning", "Confirma tu contraseña está mal ingresada", "warning", {
                button: "Continue",
              });
            });
            </script>';
    }
  } else {
    echo '<script type="text/javascript">
          jQuery(function validation(){
            swal("Warning", "Tu contraseña está mal ingresada", "warning", {
              button: "Continue",
            });
          });
          </script>';
  }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
   
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="col-md-4">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">CAMBIAR CONTRASEÑA</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="" method="POST">
          <div class="box-body">
            <div class="form-group">
              <label for="oldpassword">CONTRASEÑA ANTERIOR</label>
              <input type="text" class="form-control" id="oldpassword" name="oldpass" required>
            </div>
            <div class="form-group">
              <label for="newpassword">NUEVA CONTRASEÑA</label>
              <input type="password" class="form-control" id="newpassword" name="newpass" required>
            </div>
            <div class="form-group">
              <label for="confirmpassword">CONFIRMAR CONTRASEÑA</label>
              <input type="password" class="form-control" id="confirmpassword" name="confpass" required>
            </div>
          </div>
          <!-- /.box-body -->
          <center>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" name="btn_update">ACTUALIZAR CONTRASEÑA</button>
            </div>
          </center>
          <br>
        </form>
      </div>
    </div>
    <!-- /.box -->
    <div class="col-md-8">
      <div class="box box-success">
        
        <!-- /.box-header -->
        <?php
        function sacarcampo(){
          $a= $_SESSION['role'];
          if ($a=="administrador") {
            return "Cedula";
          }elseif ($a=="docente") {
            return "idDocente";
          }
        }
        $id = $_SESSION['Cedula'];
        $tabla= $_SESSION['role'];
        $campo=sacarcampo();
        $select = $pdo->prepare("SELECT * FROM $tabla WHERE $campo='$id'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_OBJ) ?>
        
        <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-black" style="background: url('img/background.jpg') center center;">
            <h3 class="widget-user-username"><?php echo $row->Nombre, $row->Apellido; ?></h3>
            <h5 class="widget-user-desc"><?php $tabla= $_SESSION['role']; echo $tabla ?></h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="img/escudito.png" alt="User Avatar">
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="box-header with-border">
                <center>
                  <h3 class="box-title">PERFIL</h3>
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
            <label for="name"><strong>DOCUMENTO:</strong></label>
            <span class='text-data'>
              <?php 
              $a= $_SESSION['role'];
              if ($a=="administrador") {
                echo $row->Cedula;
              }elseif ($a=="docente") {
                echo $row->idDocente;
              }
               ?>
            </span><br><br>
            <label for="name"><strong>NOMBRE DE USUARIO:</strong></label>
            <span class='text-data'>
              <?php echo $row->Nombre, " ",$row->Apellido; ?>
            </span><br><br>
            <label for="name"><strong>USUARIO:</strong></label>
            <span class='text-data'>
              <?php echo $row->Usuario; ?>
            </span><br><br>
            <label for="name"><strong>TELEFONO:</strong></label>
            <span class='text-data'>
              <?php echo $row->Telefono; ?>
            </span><br>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'inc/footer_all.php';
?>