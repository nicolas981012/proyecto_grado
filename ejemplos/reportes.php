<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['username']==""){
        header('location:index.php');
    }else{
        if($_SESSION['role']=="111100"){
          include_once'inc/header_all.php';
        }else{
            include_once'inc/header_all_operator.php';
        }
    }
 error_reporting(0);   
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
          <form action="" method="POST" autocomplete="off">
            <div class="box-header with-border">
                <h3 class="box-title">DESDE LA FECHA: <?php echo $_POST['date_1']?>
                </h3>
                <h3 class="box-title">HASTA LA FECHA : <?php echo $_POST['date_2'] ?>
                </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_1" name="date_1" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd HH:MM:SS">
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_2" name="date_2" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd HH:MM:SS">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="date_filter" value="Ver" class="btn btn-primary btn-sm">
                </div>
                <br>
              </div>
                  <?php
                    $select = $pdo->prepare("SELECT sum(Val_man) as total, count(id_man) as mantenimientos FROM mantenimiento
                    WHERE fec_man BETWEEN :fromdate AND :todate");
                    $select->bindParam(':fromdate', $_POST['date_1']);
                    $select->bindParam(':todate', $_POST['date_2']);
                    $select->execute();

                    $row = $select->fetch(PDO::FETCH_OBJ);

                    $total = $row->total;

                    $invoice = $row->mantenimientos;


                  ?>

              <div class="row">
                <div class="col-md-offset-2 col-md-4 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-olive"><i class="fa fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL DE MANTENIMIENTOS</span>
                      <span class="info-box-number"><?php echo $invoice; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-offset-1 col-md-5 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-olive"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL DE INGRESOS</span>
                      <span class="info-box-number">COP.<?php echo number_format($total,0) ; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->


                <!-- /.col -->
              </div>

              <!--- Transaction Table -->
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="mySalesReport">
                      <thead>
                          <tr>
                            <th>USUARIO</th>
                            <th>FECHA</th>
                            <th>INGRESO</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                            $select = $pdo->prepare("SELECT * FROM mantenimiento WHERE fec_man BETWEEN :fromdate AND :todate");
                            $select->bindParam(':fromdate', $_POST['date_1']);
                            $select->bindParam(':todate', $_POST['date_2']);

                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td class="text-uppercase"><?php echo $row->id_usu; ?></td>
                                <td><?php echo $row->fec_man; ?></td>
                                <td>COP. <?php echo number_format($row->val_man); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                      </tbody>
                  </table>
              </div>

              <!-- Transaction Graphic -->
              <?php
                  $select = $pdo->prepare("SELECT fec_man, sum(val_man) as precio FROM mantenimiento WHERE fec_man BETWEEN :fromdate AND :todate
                  GROUP BY fec_man");
                  $select->bindParam(':fromdate', $_POST['date_1']);
                  $select->bindParam(':todate', $_POST['date_2']);
                  $select->execute();
                  $total=[];
                  $date=[];
                  while($row=$select->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      $total[]=$precio;
                      $date[]=$fec_man;

                  }
                  // echo json_encode($total);
              ?>
              <br><br><br>
              <!--
              <div class="chart">
                  <canvas id="myChart" style="height:250px;">

                  </canvas>
              </div>
-->
              <?php
                  $select = $pdo->prepare("SELECT sed_emp_man, sum(val_man) as valor FROM mantenimiento WHERE fec_man BETWEEN :fromdate AND :todate
                  GROUP BY sed_emp_man");
                  $select->bindParam(':fromdate', $_POST['date_1']);
                  $select->bindParam(':todate', $_POST['date_2']);
                  $select->execute();
                  $pname=[];
                  $qty=[];
                  while($row=$select->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      $pname[]=$sed_emp_man;
                      $qty[]=$valor;

                  }
                  // echo json_encode($total);
              ?>
              <br><br><br>
              <div class="chart">
                  <canvas id="myBestSellItem" style="height:250px;">
                  </canvas>
              </div>

          </div>

          </form>
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    include_once'inc/footer_all.php';
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

    $(document).ready( function () {
      $('#mySalesReport').DataTable();
    } );
  </script>

  <script>
      var ctx = document.getElementById('myChart');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: <?php echo json_encode($date); ?>,
              datasets: [{
                  label: 'mantenimientos por fecha',
                  data: <?php echo json_encode($total); ?>,
                  backgroundColor: 'rgb(13, 192, 58)',
                  borderColor: 'rgb(32, 204, 75)',
                  borderWidth: 1
              }]
          },
          options: {}
      });
  </script>

  <style>
      .color{
          backgroundColor: rgb(120,102,102);
      }
  </style>


  <script>
      var ctx = document.getElementById('myBestSellItem');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: <?php echo json_encode($pname); ?>,
              datasets: [{
                  label: 'ventas por sede',
                  data: <?php echo json_encode($qty); ?>,
                  backgroundColor: 'rgb(120,112,175)',
                  borderColor: 'rgb(255,255,255)',
                  borderWidth: 1
              }]
          },
          options: {}
      });
  </script>

