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
  
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
          <form action="" method="POST" autocomplete="off">
            <div class="box-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-cogs"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_1" name="date_1" placeholder="ORDEN">
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-address-book-o"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_2" name="date_2" placeholder="CEDULA">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="date_filter" value="Ver" class="btn btn-primary btn-sm">
                </div>
                <br>
              </div>
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="mySalesReport">
                      <thead>
                          <tr>
                                <th>ID</th>
                                <th>DOCUMENTO</th>
                                <th>NOMBRE</th>
                                <th>FECHA</th>
                                <th>EQUIPO</th>
                                <th>VALOR</th>
                                <th>ESTADO</th>
                                <th>OPCION</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                            $sede = $_SESSION['sede'];
                            $select = $pdo->prepare("SELECT A.id_man AS ID,A.fec_man AS FECHA,A.equ_man AS EQUIPO,A.val_man AS VALOR,A.est_man AS ESTADO, B.doc_per AS CEDULA,
                            B.nom_per AS NOMBRE,B.ape_per AS APELLIDO 
                            FROM mantenimiento A 
                            JOIN personas B 
                            ON A.doc_cli = B.doc_per WHERE (A.sed_emp_man = '$sede') and (A.id_man=:fromdate OR b.doc_per =:todate) ORDER by a.fec_man DESC; ");
                            $select->bindParam(':fromdate', $_POST['date_1']);
                            $select->bindParam(':todate',$_POST['date_2']);
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td class="text-uppercase"><?php echo $row->ID; ?></td>
                                <td><?php echo $row->CEDULA; ?></td>
                                <td><?php echo $row->NOMBRE.$row->APELLIDO; ?></td>
                                <td class="text-uppercase"><?php echo $row->FECHA; ?></td>
                                <td><?php echo $row->EQUIPO; ?></td>
                                <td>COP. <?php echo number_format($row->VALOR); ?></td>
                                <td class="text-uppercase"><?php echo $row->ESTADO; ?></td>
                                <td>
                                        <?php if ($_SESSION['role'] == "111100") { ?>
                                            <a href="eliminar_orden.php?id=<?php echo $row->ID; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i><span>ELIMINAR</span></a>
                                            
                                        <?php
                                        }
                                        ?>
                                        <a href="editar_orden.php?id=<?php echo $row->ID; ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> <span>EDITAR</span></a>
                                        <a href="ver_orden.php?id=<?php echo $row->ID; ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i><span>VER ORDEN</span></a>
                                        <a href="agregar_garantia.php?id=<?php echo $row->ID; ?>" class="btn btn-success"><i class="glyphicon glyphicon-check"></i><span>AÑADIR A GARANTIA</span></a>
                                        <a href="Observacion.php?id=<?php echo $row->ID; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-paperclip"></i><span>AÑADIR HISTORIAL</span></a>
                                        <a href="misc/nota.php?id=<?php echo $row->ID; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i><span>IMPRIMIR</span></a>
                                        <a href="ver_historial.php?id=<?php echo $row->ID; ?>" target="_blank" class="btn btn-danger"><i class="glyphicon glyphicon-info-sign"></i><span>VER HISTORIAL</span></a>
                                    </td>
                                </tr>
                            <?php
                            }
                          
                            ?>
                      </tbody>
                  </table>
              </div>
          </div>

          </form>
        </div>


    </section>
    <!-- /.content -->
  </div>
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

