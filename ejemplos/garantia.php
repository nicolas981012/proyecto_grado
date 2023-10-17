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

    //error_reporting(0);
/*
    $id = $_GET['id'];

    $delete = $pdo->prepare("DELETE FROM tbl_product WHERE product_id=".$id);

    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "El producto ha sido eliminado satisfactoriamente", "info", {
            button: "Continuar",
                });
            });
            </script>';
    }
*/
function sacarestado($estadoman)
{

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT des_est FROM estados_equipo WHERE id_est='$estadoman'");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;

}
?>

<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="text-center" id="spinner">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
    </div>
    <style>
        #spinner {
            display: none;
        }
    </style>
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">LISTA DE GARANTIAS</h3>
                
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>DOCUMENTO</th>
                                <th>CLIENTE</th>
                                <th>EQUIPO</th>
                                <th>SERIAL</th>
                                <th>OPCION</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sede=$_SESSION['sede'];
                            date_default_timezone_set('America/Bogota');
                            $date_now = date('Y-m-d H:m:s');
                            $date_past2 = strtotime('+1 day', strtotime($date_now));
                            $date_past = strtotime('-30 day', strtotime($date_now));
                            $date_past = date('Y-m-d H:m:s', $date_past);
                            $date_past2 = date('Y-m-d H:m:s', $date_past2);
                            $idman="";
                            if ($sede == 1) {
                                $idman = "S";
                            } elseif ($sede == 3) {
                                $idman =  "M";
                            } elseif ($sede == 4) {
                                $idman =  "A" ;
                            } elseif ($sede == 6) {
                                $idman =  "Y" ;
                             }
                            
                            $select = $pdo->prepare("SELECT b.id_gar as CODE,b.id_man_gar as ID ,a.doc_cli as CEDULA,c.nom_per as NOMBRE,c.ape_per AS APELLIDO,a.equ_man as EQUIPO,a.ser_equ as SERIAL
                            FROM mantenimiento a
                            join garantia b
                            ON a.id_man = b.id_man_gar
                            join personas c
                            ON a.doc_cli=c.doc_per
                            WHERE (b.id_man_gar like '$idman%' and b.fec_gar BETWEEN :todate AND :fromdate)
                            AND (b.est_equ_gar= 2 OR b.est_equ_gar=3 OR b.est_equ_gar=4 OR b.est_equ_gar=6) order by b.id_man_gar desc ");
                            $select->bindParam(':fromdate', $date_past2);
                            $select->bindParam(':todate', $date_past);
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $row ->CODE ;?></td>
                                <td><?php echo $row ->ID ;?></td>
                                <td><?php echo $row->CEDULA; ?></td>
                                <td><?php echo $row->NOMBRE . ' ' . $row->APELLIDO; ?></td>
                                <td><?php echo $row->EQUIPO; ?></td>
                                <td><?php echo $row->SERIAL;?></td>
                                
                                <td>
                                    <a href="editar_garantia.php?id=<?php echo $row->ID; ?>" class="btn btn-info btn-sm" title="EDITAR GARANTIA"><i class="fa fa-pencil" ></i></a>
                                    <a href="ver_garantia.php?id=<?php echo $row->ID; ?>" class="btn btn-default btn-sm" title="VER GARANTIA"><i class="fa fa-eye" ></i></a>
                                    <?php if($_SESSION['role']=="111100"){ ?>
                                    <a href=""class="btn btn-danger btn-sm" title="CANCELAR GARANTIA"><i class="fa fa-trash" ></i></a>
                                    
                                    <?php
                                    }
                                    ?>
                                </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#myProduct').DataTable();
  } );
  </script>
  <script>
  $.ajax({
   url: "cliente.php",
   method: "GET",
   beforeSend: function() {
      $("#spinner").show();
   },
   success: function(data) {
      
      // do something with the data
   },
   complete: function() {
      $("#spinner").hide();
   }
});
</script>

 <?php
    include_once'inc/footer_all.php';
 ?>