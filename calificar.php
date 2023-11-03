<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
session_start();

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
if ($id = $_GET['id']) {
    $select = $pdo->prepare("SELECT * FROM progreso WHERE id_Progreso=$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);
    $progreso = $row['id_Progreso'];
    $idalumno = $row['Alumno_id_Alumno'];
    $idactividad = $row['Actividad_idActividad'];
    $estado = $row['Estado'];
    $respuesta = $row['respuesta'];
    $archivo = $row['archivo'];
    $calificacion = $row['Calificacion'];
    $comentario = $row['Comentario_docente'];
}
if (isset($_POST['update_actividad'])) {
    $codigo_progreso = $_POST['codigo'];
    $ecalificacion = $_POST['calificacion'];
    $ecomentario = $_POST['comentario'];
    $eestado=1;

    $update = $pdo->prepare("UPDATE progreso SET Calificacion=:califica,
    Comentario_docente=:coment,Estado=:est WHERE id_progreso=$id");

    $update->bindParam('califica', $ecalificacion);
    $update->bindParam('coment', $ecomentario);
    $update->bindParam('est', $est);

    if ($update->execute()) {
        echo '<script type="text/javascript">
        jQuery(function validation(){
        swal("Success", "Actividad calificada con exito ", "success", {
        button: "Continuar",
            });
        });
        </script>';
    } else {
        echo '<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Error", "Ocurrio un error", "error", {
                        button: "Continuar",
                            });
                        });
                        </script>';
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-repeat:no-repeat;background-size:cover;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">CALIFICAR ACTIVIDAD</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">CODIGO</label>
                            <input type="text" class="form-control" name="codigo" value="<?php echo $progreso; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ALUMNO</label>
                            <input type="text" class="form-control" name="estudiante" value="<?php echo $idalumno; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ACTIVIDAD</label>
                            <input type="text" class="form-control" name="actividad" value="<?php echo $idactividad; ?>" required readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">ARCHIVO</label>
                            <input type="number" class="form-control" name="archivo" value="<?php echo $telefono; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">CALIFICACION</label>
                            <input type="text" class="form-control" name="calificacion" value="<?php echo $direccion; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">COMENTARIO</label>
                            <input type="text" class="form-control" name="comentario" value="<?php echo $correo; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">RESPUESTA ESTUDIANTE</label>
                            <textarea name="falla" id="respuesta" cols="30" rows="10" class="form-control" value="" required><?php echo $respuesta; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="update_actividad">CALIFICAR</button>
                    <a href="actividad_calificar.php" class="btn btn-warning">VOLVER</a>
                </div>
            </form>

        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'inc/footer_all.php';
?>