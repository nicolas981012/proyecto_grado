
<?php
error_reporting(0);
include_once 'db/connect_db.php';
session_start();
if (isset($_POST['btn_login'])) {

  $username = $_POST['usuario'];
  $password = $_POST['contraseña'];
  $rol = $_POST['rol'];

  $select = $pdo->prepare("select * from $rol where Usuario='$username' AND Contrasena='$password'");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);
  if ($row['Usuario'] == $username and $row['Contrasena'] == $password and $row['estado'] == 1) {
    if ($rol == "administrador") {
      $_SESSION['role'] = $rol;
      $_SESSION['username'] = $row['Nombre'];
      $_SESSION['Cedula'] = $row['Cedula'];
    }elseif ($rol == "alumno") {
      $_SESSION['role'] = $rol;
      $_SESSION['username'] = $row['Nombre'];
      $_SESSION['apellido'] = $row['Apellido'];
      $_SESSION['Cedula'] = $row['id_Alumno'];
    }elseif ($rol == "docente") {
      $_SESSION['role'] = $rol;
      $_SESSION['username'] = $row['Nombre'];
      $_SESSION['Cedula'] = $row['idDocente'];
    }
  
   

    $message = 'success';
    header('refresh:2;dashboard.php');

  } else {
    $errormsg = 'error';
  }
}

?>
<?php 


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <title>IEAR| Log in</title>
  <link rel="shortcut icon" href="img/escudito.png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <link rel="shortcut icon" href="img/logo1.jpg">
  <link rel="shortcut icon" href="img/logo.webp">
  <script>
  window.callbellSettings = {
    token: "3jfckf6GviwSZHnd8gASnaiL"
  };
</script>
<script>
  (function(){var w=window;var ic=w.callbell;if(typeof ic==="function"){ic('reattach_activator');ic('update',callbellSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Callbell=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://dash.callbell.eu/include/'+window.callbellSettings.token+'.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
</script>

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <!--Sweetalert Plugin --->
  <script src="bower_components/sweetalert/sweetalert.js"></script>
  <style>
  body{
    
  }
  .login-box-body {
    border-radius: 10px; /* Ajusta el valor según tu preferencia */
    box-shadow: 0 0 10px rgba(15, 15, 15, 0.2);
    height: 450px;
     /* Opcional: agrega una sombra al formulario */
  }

  .form-control {
    border-radius: 5px;
    font-size: 16px;
     /* Ajusta el valor según tu preferencia */
  }
  .login-page{
    background-image: url("img/img6.jpg");
     /* Establece el color de fondo blanco */
    background-size: 1800px 900px;
    background-position: center;
  }
  .login-box-msg {
      font-size: 24px; /* Increase the font size for the login message */
    }
    
</style>


  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">

  <div class="login-box">
   
   
     
    <center>
    <div class="login-box-body">
    <div class="login-logo">
    <center>
  <img src="img/esc.png" class="user-image" >
  </center>
      
    </div>
      <p class="login-box-msg">INICIO DE SESION</p>

      <form action="" method="post" autocomplete="off">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="USUARIO" name="usuario" required>
          
        </div>
        <div class="input-group">
          <input type="password" class="form-control" placeholder="CONTRASEÑA" name="contraseña" id="contraseña"required>
          <Br>
          <div class="input-group-btn">
            <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
          </div>
         
        </div>
        <br>
        <div class="form-group has-feedback">
                <select class="form-control" name="rol" required>
                    <option  class="form-control" value="TIPO USUARIO...">TIPO USUARIO...</option>
                    <option  class="form-control" value="alumno">ESTUDIANTE</option>
                    <option  class="form-control" value="docente">DOCENTE</option>
                    <option  class="form-control" value="administrador">ADMINISTRADOR</option>
                </select>
          
        </div>
        <center>
        <div class="row">
          <!-- /.col -->
          
          <div class="col-xs-6">
            <Br>
           
            <button type="submit" class="text-muted btn-block btn btn-primary btn-rect"
              name="btn_login">INGRESAR</button>
              
              
          </div>
          
        </div>
        </center>
        <?php
        if (!empty($message)) {
          echo '<script type="text/javascript">
              jQuery(function validation(){
              swal("Login aceptado", "Bienvenido", "success", {
              button: "Continue",
                });
              });
              </script>';
        } else {
        }
        if (empty($errormsg)) {
        } else {
          echo '<script type="text/javascript">
              jQuery(function validation(){
              swal("Login Fallido", " Acceso denegado,ponte en contacto con el adminstrador!", "error", {
              button: "Continue",
                });
              });
          </script>';
        }
        ?>
      </form>
    </div>
    </center>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
  <script type="text/javascript">
function mostrarPassword(){
		var cambio = document.getElementById("contraseña");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>


</body>

</html>