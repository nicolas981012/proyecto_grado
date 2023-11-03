<?php


?>
<html>

<head>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>IEAR| INGLES</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="img/escudito.png">
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

    <link rel="stylesheet" href="dist/css/skins/skin-red.min.css">

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
    <script>
      window.callbellSettings = {
        token: "3jfckf6GviwSZHnd8gASnaiL"
      };
    </script>
    <script>
      (function() {
        var w = window;
        var ic = w.callbell;
        if (typeof ic === "function") {
          ic('reattach_activator');
          ic('update', callbellSettings);
        } else {
          var d = document;
          var i = function() {
            i.c(arguments)
          };
          i.q = [];
          i.c = function(args) {
            i.q.push(args)
          };
          w.Callbell = i;
          var l = function() {
            var s = d.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://dash.callbell.eu/include/' + window.callbellSettings.token + '.js';
            var x = d.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
          };
          if (w.attachEvent) {
            w.attachEvent('onload', l);
          } else {
            w.addEventListener('load', l, false);
          }
        }
      })()
    </script>
    <!-- chart Js -->
    <script src="chartjs/dist/Chart.min.js"></script>

  </head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo" style="background-color: darkred;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>IEAR</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>INGLES</b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation" style="background-color: darkred;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="img/estudiante.png" class="user-image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"></span>
              </a>
              <ul class="dropdown-menu">

                <!-- The user image in the menu -->
                <li class="user-header" style="background-color:MidnightBlue;border-radius: 10px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);padding: 10px;margin: 3px;">
                  <img src="img/estudiante.png" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['username']; ?> - <?php echo $_SESSION['role']; ?>
                    <small class="text-capitalize"><?php echo $_SESSION['username']; ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer" style="border-radius: 10px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);padding: 10px;margin: 3px;">
                  <div class="pull-left">
                    <a href="profile.php" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-user"></i>Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="misc/logout.php" class="btn btn-default btn-flat" onclick="return confirm('Esta seguro de salir?')" class="btn btn-danger"><i class="glyphicon glyphicon-off"></i> Cerrar sesion</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar" style="border-radius: 10px;">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="img/estudiante2.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['username']; ?></p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU PRINCIPAL</li>

          <li><a href="dashboard.php"><i class="glyphicon glyphicon-home"></i> <span>PAGINA DE INICIO</span></a></li>
          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-tasks"></i> <span>CALIFICACIONES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="calificaciones.php"><i class="glyphicon glyphicon-ok-sign"></i> ACTIVIDADES CALIFICADAS</a></li>
            </ul>
          </li>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>