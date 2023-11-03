<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
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
                <h3 class="box-title">LISTA DE ACTIVIDADES CALIFICADAS</h3>
                <a href="dashboard.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-bars"></i> INICIO</a>
            </div>
            <div class="box-body">

                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ACTIVIDAD</th>
                                <th>CALIFICACION </th>
                                <th>COMENTARIO </th>
                            </tr>

                        </thead>
                        <tbody>
                            
                            <?php
                            
                            $docente =$_SESSION['Cedula'];
                            $select = $pdo->prepare("SELECT * FROM progreso where Estado = 1 AND Alumno_id_Alumno = $docente; ");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->id_Progreso; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Actividad_idActividad; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Calificacion; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->Comentario_docente; ?>
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