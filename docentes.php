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
        if ($_SESSION['role'] == "DOCENTE") {
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
                <h3 class="box-title">LISTA DE DOCENTES</h3>
                <a href="agregar_docente.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-bars"></i> AGREGAR DOCENTE</a>
            </div>
            <div class="box-body">

                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>CEDULA</th>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>TELEFONO</th>
                                <th>ESTADO</th>
                                <th>OPCION</th>
                            </tr>

                        </thead>
                        <tbody>
                            
                            <?php
                            
                            $no = 1;
                            $select = $pdo->prepare("SELECT * from docente");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->idDocente; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Nombre; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Apellido; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Telefono; ?>
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
                                        <?php if ($_SESSION['role'] == "administrador") { ?>
                                            <a href="devolver_estadoc.php?id=<?php echo $row->idDocente; ?>"
                                    class="btn btn-danger btn-sm" title="INACTIVAR DOCENTE"><i class="fa fa-trash" ></i></a>
                                            
                                            <a href="editar_docente.php?id=<?php echo $row->idDocente; ?>"
                                                class="btn btn-info btn-sm"  title="EDITAR DOCENTE"><i class="fa fa-pencil"></i></a>
                                                
                                                <a href="ver_docente.php?id=<?php echo $row->idDocente; ?>"
                                            class="btn btn-default btn-sm"  title="VER DOCENTE"><i class="fa fa-eye"></i></a>
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