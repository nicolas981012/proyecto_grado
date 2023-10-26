<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
session_start();
error_reporting(0);
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "ESTUDIANTE") {
        include_once 'inc/header_estudiante.php';
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
                <h3 class="box-title">LISTA DE CLASES</h3>
                <a href="agregar_clase.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-bars"></i> AGREGAR CLASE</a>
            </div>
            <div class="box-body">

                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>FECHA INICIAL</th>
                                <th>FECHA FINAL</th>
                                <th>OPCION</th>
                            </tr>

                        </thead>
                        <tbody>
                            
                            <?php
                            
                            $docente =$_SESSION['Cedula'];
                            $select = $pdo->prepare("SELECT * from clase where Docente_idDocente=$docente");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->idClase; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Nombre; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Fecha_inicial; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Fecha_final; ?>
                                    </td>
                                    <td>
                                        <?php if ($_SESSION['role'] == "docente") { ?>
                                        
                                                
                                                <a href="ver_clase.php?id=<?php echo $row->idClase; ?>"
                                            class="btn btn-default btn-sm"  title="VER CLASE"><i class="fa fa-eye"></i></a>
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