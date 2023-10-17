<?php
include_once 'db/connect_db.php';
session_start();
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "111100") {
        include_once 'inc/header_all.php';
    } else {
        include_once 'inc/header_all_operator.php';
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
function sacarnombre($documento)
{

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT nom_per,ape_per FROM personas WHERE doc_per='$documento'");
    $select->execute();
    $row = $select->fetchAll();
    foreach ($row as $registro) {
        return $registro[0].' '.$registro[1];
        
    }
   
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
                <h3 class="box-title">LISTA DE ORDENES</h3>
                <a href="agregar_orden.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-bars"></i>AGREGAR ORDEN</a>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DOCUMENTO</th>
                                <th>NOMBRE</th>
                                <th>FECHA</th>
                                <th>EQUIPO</th>
                                <th >VALOR</th>
                                <th>ESTADO</th>
                                <th >OPCION</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sede = $_SESSION['sede'];
                            date_default_timezone_set('America/Bogota');
                            $date_now = date('Y-m-d H:m:s');
                            $date_past2 = strtotime('+2 day', strtotime($date_now));
                            $date_past = strtotime('-14 day', strtotime($date_now));
                            $date_past = date('Y-m-d H:m:s', $date_past);
                            $date_past2 = date('Y-m-d H:m:s', $date_past2);
                            
                            $select = $pdo->prepare("SELECT A.id_man AS ID,A.fec_man AS FECHA,A.equ_man AS EQUIPO,A.val_man AS VALOR,
                            B.doc_per AS CEDULA,B.nom_per AS NOMBRE,B.ape_per AS APELLIDO,C.des_est AS ESTADO 
                            FROM mantenimiento A
                            JOIN personas B
                            ON A.doc_cli = B.doc_per
                            JOIN estados_equipo C 
                            ON A.est_man = C.id_est
                            WHERE (A.sed_emp_man = $sede and A.fec_man BETWEEN '$date_past' AND '$date_past2') 
                            AND (A.est_man = 2 OR A.est_man=3 OR A.est_man=4 OR A.est_man=6) order by A.fec_man DESC;");
                            //$select->bindParam(':fromdate', $date_past);
                            //$select->bindParam(':todate', $date_past2);
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                            ?>
                                <tr>
                                    <td><?php echo $row->ID; ?></td>
                                    <td><?php echo $row->CEDULA; ?></td>
                                    <td><?php echo $row->NOMBRE.$row->APELLIDO; ?></td>
                                    <td><?php 
                                    $date = date_create("2020-03-29");
                                    echo date_format(new DateTime($row->FECHA),'Y-m-d'); 
                                    ?></td>
                                    <td><?php echo $row->EQUIPO; ?></td>
                                    <td>COP <?php echo number_format($row->VALOR); ?></td>
                                    <td><?php 
                                    echo $row->ESTADO; ?></td>
                                    <td>
                                        <?php if ($_SESSION['role'] == "111100") { ?>
                                            <a href="eliminar_orden.php?id=<?php echo $row->ID; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i><span>ELIMINAR</span></a>
                                            
                                        <?php
                                        }
                                        ?>
                                        <a href="editar_orden.php?id=<?php echo $row->ID; ?>" class="btn bg-navy btn-sm" title="EDITAR"><i class="fa fa-pencil"></i> <span>EDITAR</span></a>
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
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(document).ready(function() {
        $('#myProduct').DataTable();
    });
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
include_once 'inc/footer_all.php';
?>