<?php
include_once 'db/connect_db.php';

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

/*
$id = $_GET['id'];
$delete = $pdo->prepare("DELETE FROM personas WHERE doc_per='.$id'");
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
?>
<html>

<head>
    <meta http-equiv="refresh" content="60">
</head>

</html>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-repeat:no-repeat;background-size:cover;">
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
                <h3 class="box-title">LISTA DE ACTIVIDADES</h3>
                
            </div>
            <div class="box-body">

                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CLASE</th>
                                <th>TITULO </th>
                                <th>TIPO ACTIVIDAD </th>
                                <th>ESTADO</th>
                                <th>OPCION</th>
                            </tr>

                        </thead>
                        <tbody>
                            
                            <?php
                            
                            $docente =$_SESSION['Cedula'];
                            $select = $pdo->prepare("SELECT b.idActividad as ID,b.titulo as titulo ,
                            b.estado as estado,b.tipo_actividad as act,a.Nombre as nombre
                            FROM clase a
                            join actividad b
                            ON a.idClase = b.Clase_idClase
                            WHERE a.Docente_idDocente = $docente ");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->ID; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->nombre; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->titulo; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->act; ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if ($row->estado == 0) {
                                            echo 'INACTIVO';
                                        }else {
                                            echo 'ACTIVO';
                                        }
                                        
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($_SESSION['role'] == "docente") { ?>
                                        
                                                <!--
                                                <a href="editar_actividad.php?id=<?php //echo $row->ID; ?>"
                                                class="btn btn-info btn-sm"  title="EDITAR ACTIVIDAD"><i class="fa fa-pencil"></i></a> -->
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
    $(document).ready(function () {
        $('#myProduct').DataTable();
    });
</script>
<script>
    $.ajax({
        url: "cliente.php",
        method: "GET",
        beforeSend: function () {
            $("#spinner").show();
        },
        success: function (data) {

            // do something with the data
        },
        complete: function () {
            $("#spinner").hide();
        }
    });
</script>
<?php
include_once 'inc/footer_all.php';
?>