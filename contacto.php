<?php

date_default_timezone_set('America/Bogota');
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
error_reporting(0);
if (isset($_POST['boton_enviar'])) {
    $fecha = date('Y-m-d h:i:s ', time());
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $asunto = $_POST['asunto'];
    $telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];
    $mensaje = $_POST['mensaje'];

    $insert = $pdo->prepare("INSERT INTO contacto(fec_con,non_con,cor_con,asu_con,men_con,tel_con,ciu_con )
                                values(:fecha,:nombre,:correo,:asunto,:mensaje,:telefono,:ciudad)");

    $insert->bindParam(':fecha', $fecha);
    $insert->bindParam(':nombre', $nombre);
    $insert->bindParam(':correo', $correo);
    $insert->bindParam(':asunto', $asunto);
    $insert->bindParam(':telefono', $telefono);
    $insert->bindParam(':ciudad', $ciudad);
    $insert->bindParam(':mensaje', $mensaje);

    if ($insert->execute()) {
        $message = 'success';
    } else {
        $errormsg = 'error';
    }
}



?>
<?php
include_once 'inc/nav.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="shortcut icon" href="img/logo.webp">
    <link rel="shortcut icon" href="img/logo.webp">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="img/logo.webp">
    <script>
  window.callbellSettings = {
    token: "3jfckf6GviwSZHnd8gASnaiL"
  };
</script>
<script>
  (function(){var w=window;var ic=w.callbell;if(typeof ic==="function"){ic('reattach_activator');ic('update',callbellSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Callbell=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://dash.callbell.eu/include/'+window.callbellSettings.token+'.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
</script>
    <!--Sweetalert Plugin --->
    <script src="bower_components/sweetalert/sweetalert.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- bootstrap timepicker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- datepicker js -->
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

    <!-- chart Js -->
    <script src="chartjs/dist/Chart.min.js"></script>
    <!--Sweetalert Plugin --->
    <script src="bower_components/sweetalert/sweetalert.js"></script>
    <title>contacto</title>
</head>
<style>
   html {
        background-color: #E0E0E0;
        background-size: cover;
        min-height: 100%;
    }
    
    body {
        background-color: #E0E0E0;
    }

    #advanced-search-form {
        background-color: white;
        max-width: 900px;
        margin: 60px auto 0;
        padding: 40px;
        color: darkslategray;
        box-shadow: 6px 6px 6px 6px rgba(0, 0, 0, 0.1);
    }

    #advanced-search-form h2 {
        padding-bottom: 40px;
        margin: 10px 20px;
        font-size: 24px;
    }

    #advanced-search-form hr {
        margin-top: 38px;
        margin-bottom: 54px;
        margin-left: 5px;
        border: 3px solid #cccccc;

    }

    #advanced-search-form .form-group {
        margin-bottom: 20px;
        margin-left: 20px;
        width: 30%;
        float: left;
        text-align: left;
    }

    #advanced-search-form .form-control {
        padding: 12px 20px;
        height: auto;
        border-radius: 10px;
    }

    #advanced-search-form .radio-inline {
        margin-left: 10px;
        margin-right: 10px;

    }

    #advanced-search-form .gender {
        width: 30%;
        margin-top: 30px;
        padding-left: 20px;


    }

    #advanced-search-form .btn {
        width: 46%;
        margin: 20px auto 0;
        display: block;
        outline: none;
    }

    @media screen and (max-width: 800px) {
        #advanced-search-form .form-group {
            width: 45%;
        }

        #advanced-search-form {
            margin-top: 0;
        }
    }

    @media screen and (max-width: 560px) {
        #advanced-search-form .form-group {
            width: 100%;
            margin-left: 0;
        }

        #advanced-search-form h2 {
            text-align: center;
        }
    }
</style>

<body>
    <div class="login-box-body" id="advanced-search-form">
        <center>
            <h2>contacto</h2>
        </center>
        <form action="subscribe_newsletter_submit.php" id="newsletterForm"  method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="first-name">NOMBRE</label>
                <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre">
            </div>
            <div class="form-group">
                <label for="last-name">CORREO</label>
                <input type="email" class="form-control" placeholder="correo" id="correo" name="correo">
            </div>
            <div class="form-group">
                <label for="country">ASUNTO</label>
                <input type="text" class="form-control" placeholder="asunto" id="asunto" name="asunto">
            </div>
            <div class="form-group">
                <label for="age">TELEFONO</label>
                <input type="tel" class="form-control" placeholder="Telefono" id="telefono" name="telefono">
            </div>
            <div class="form-group">
                <label for="email">CIUDAD</label>
                <select class="form-control" name="ciudad" required>
                    <option value="Medellin">MEDELLIN</option>
                    <option value="Sangil">SANGIL</option>
                    <option value="Armenia">ARMENIA</option>
                    <option value="otra...">OTRA...</option>
                </select>
            </div>
            <div class="form-group">
                <label for="number">MENSAJE</label>
                <textarea name="mensaje" id="mensaje" cols="25" rows="1" class="form-control" required></textarea>
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary btn-lg btn-responsive" id="boton_enviar" name="boton_enviar"> <span class="glyphicon glyphicon-envelope"></span> ENVIAR</button>
            <?php
            if (!empty($message)) {
                echo '<script type="text/javascript">
              jQuery(function validation(){
              swal("mensaje enviado con exito", "", "success", {
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
              swal("error", "estamos presentando fallas en nuestro sistema", "error", {
              button: "Continue",
                });
              });
          </script>';
            }
            ?>
          
        </form>
    </div>
</body>

</html>
<br><br>

<?php
include_once 'inc/Footerpp.php';
?>