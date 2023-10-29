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

    <!-- chart Js -->
    <script src="chartjs/dist/Chart.min.js"></script>

  </head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>IEAR</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>INGLES</b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
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
                <li class="user-header">
                  <img src="img/estudiante.png" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['username']; ?> - <?php echo $_SESSION['role']; ?>
                    <small class="text-capitalize"><?php echo $_SESSION['username']; ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="profile.php" class="btn btn-default btn-flat">Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="misc/logout.php" class="btn btn-default btn-flat" onclick="return confirm('Esta seguro de salir?')" class="btn btn-danger">Cerrar sesion</a>
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
    <aside class="main-sidebar">

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

          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>PAGINA DE INICIO</span></a></li>

          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-wrench"></i> <span>CLASES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="agregar_clase.php"><i class="fa fa-circle-o"></i> CREAR CLASE</a></li>
              <li><a href="clases.php"><i class="fa fa-circle-o"></i> MIS CLASES</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-wrench"></i> <span>NOTIFICACIONES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="agregar_notificacion.php"><i class="fa fa-circle-o"></i> AÑADIR NOTIFICACION</a></li>
              <li><a href="Notificaciones.php"><i class="fa fa-circle-o"></i> LISTADO NOTIFICACIONES</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-wrench"></i> <span>ACTIVIDADES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="agregar_actividad.php"><i class="fa fa-circle-o"></i> AÑADIR ACTIVIDAD</a></li>
              <li><a href="actividad.php"><i class="fa fa-circle-o"></i> LISTADO ACTIVIDADES</a></li>
              <li><a href=""><i class="fa fa-circle-o"></i> CALIFICAR ACTIVIDADES</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-wrench"></i> <span>CONTENIDO</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="agregar_contenido.php"><i class="fa fa-circle-o"></i> AÑADIR CONTENIDO</a></li>
              <li><a href="contenido.php"><i class="fa fa-circle-o"></i> LISTADO CONTENIDO</a></li>
            </ul>
          </li>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>