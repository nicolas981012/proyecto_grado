<?php
include_once 'inc/nav.php';
include_once 'db/connect_db.php';
error_reporting(0);





?>
<title>OKLAM</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="shortcut icon" href="img/logo.webp">
<!-- Start of Async Callbell Code -->
<!-- Start of Async Callbell Code -->
<script>
  window.callbellSettings = {
    token: "3jfckf6GviwSZHnd8gASnaiL"
  };
</script>
<script>
  (function(){var w=window;var ic=w.callbell;if(typeof ic==="function"){ic('reattach_activator');ic('update',callbellSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Callbell=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://dash.callbell.eu/include/'+window.callbellSettings.token+'.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
</script>
<!-- End of Async Callbell Code -->

<!-- End of Async Callbell Code -->

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
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->

<!-- Main content -->
<section class="content container-fluid">
  <div class="box box-success">
    <form action="" method="POST" autocomplete="off">
      <div class="box-header with-border">
        <h1 class="box-title">EL ESTADO DE SU ORDEN ES:<span class="label label-success pull-right">
          <?php
          
        if (isset($_POST['filter'])) {
          $idorden = $_POST['orden'];
          $cedula = $_POST['cedula'];
          $select = $pdo->prepare("SELECT MIN(A.obs_pre) FROM observaciones A JOIN mantenimiento B ON A.id_man_obs = B.id_man WHERE A.id_man_obs = '$idorden' AND B.doc_cli='$cedula'");
          $select->execute();
          $row = $select->fetchColumn();
          
        }
        echo obs($row);
        function obs($observacion)
              {

                try {
                  $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
                } catch (PDOException $error) {
                  echo $error->getmessage();
                }
                $select = $pdo->prepare("SELECT obs_pre FROM observaciones_predis WHERE id_obs='$observacion'");
                $select->execute();
                $row = $select->fetchColumn();
                return $row;
              }
          ?>
          </span>
        </h1>

      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-cogs"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker_1" name="orden" placeholder="Id Orden">
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-address-book-o"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker_2" name="cedula" placeholder="Documento">
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <input type="submit" name="filter" value="Consultar" class="btn btn-primary btn-sm">
          </div>
          <br><br><br><br>
        </div>
        <?php

        if (isset($_POST['filter'])) {
          $idorden = $_POST['orden'];
          $cedula = $_POST['cedula'];

          $select = $pdo->prepare("SELECT A.fec_obs AS FECHA ,A.obs_pre AS OBSERVACIONP ,A.obs_obs AS OBSERVACION,B.doc_cli AS CLIENTE,
          B.equ_man AS EQUIPO,B.val_man AS VALOR
                    FROM observaciones A
                    JOIN mantenimiento B
                    ON A.id_man_obs = B.id_man
                    WHERE A.id_man_obs = '$idorden' AND B.doc_cli='$cedula' ORDER BY FECHA DESC");
          $select->execute();
          $row = $select->fetch(PDO::FETCH_OBJ);
          $total = $row->CLIENTE;
          $invoice = $row->EQUIPO;
          if ($row ?? null) {
            echo '<script type="text/javascript">
                                    jQuery(function validation(){
                                    swal("Correcto", "consulta exitosa", "success", {
                                    button: "Continuar",
                                        });
                                    });
                                    </script>';
            $hola = 1;
          } else {
            echo '<script type="text/javascript">
                                    jQuery(function validation(){
                                    swal("Error", "Orden o cedula invalida", "error", {
                                    button: "Continuar",
                                        });
                                    });
                                    </script>';;
            $hola = 2;
          }
        }
        ?>


        <div class="row">
          <div class="col-md-offset-0 col-md-3 col-xs-6">
            <div class="info-box">
              <span class="info-box-icon bg-darken-1">
                <center><i class="fa fa-user-plus"></i></center>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">CLIENTE </span>
                <span class="info-box-number"><?php echo $total; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

          <div class="col-md-offset-2 col-md-3 col-xs-6">
            <div class="info-box">
              <center>
                <span class="info-box-icon bg-darken-1">

                  <i class="fa fa-laptop"></i>

                </span>

                <div class="info-box-content">
                  <span class="info-box-text">EQUIPO</span>
                  <span class="info-box-number"><?php echo $invoice; ?></span>
                </div>
                <!-- /.info-box-content -->
              </center>
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


          <!-- /.col -->
        </div>
        <br><br><br>
        <!--- Transaction Table -->
        <div style="overflow-x:auto;">
          <table class="table table-striped" id="mySalesReport">
            <thead>
              <tr>
                <th>No</th>
                <th>FECHA</th>
                <th>ESTADO</th>
                <th>OBSERVACION</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $select = $pdo->prepare("SELECT A.fec_obs AS FECHA ,A.obs_pre AS OBSERVACIONP ,A.obs_obs AS OBSERVACION,B.doc_cli AS CLIENTE,B.equ_man AS EQUIPO,B.val_man AS VALOR
                            FROM observaciones A
                            JOIN mantenimiento B
                            ON A.id_man_obs = B.id_man
                            WHERE A.id_man_obs = '$idorden' AND B.doc_cli='$cedula' ORDER BY FECHA desc");
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_OBJ)) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $row->FECHA; ?></td>
                  <td><?php echo observacionp($row->OBSERVACIONP); ?></td>
                  <td><?php echo $row->OBSERVACION; ?></td>
                </tr>
              <?php
              }
              function observacionp($observacion)
              {

                try {
                  $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
                } catch (PDOException $error) {
                  echo $error->getmessage();
                }
                $select = $pdo->prepare("SELECT obs_pre FROM observaciones_predis WHERE id_obs='$observacion'");
                $select->execute();
                $row = $select->fetchColumn();
                return $row;
              }
              ?>
            </tbody>
          </table>
        </div>


        <br><br><br><br><br><br>


      </div>

    </form>
  </div>


</section>
<!-- /.content -->

<!-- /.content-wrapper -->
<?php
include_once 'inc/Footerpp.php';
?>
<script>
  //Date picker
  $('#datepicker_1').datepicker({
    autoclose: true
  });
  //Date picker
  $('#datepicker_2').datepicker({
    autoclose: true
  });

  $(document).ready(function() {
    $('#mySalesReport').DataTable();
  });
</script>