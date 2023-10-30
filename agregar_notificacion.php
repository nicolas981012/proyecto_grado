<?php
include_once 'db/connect_db.php';
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
date_default_timezone_set('America/Bogota');

if (isset($_POST['add_notification'])) {

    $idClase= $_POST['clase'];
    $asunto = $_POST['asunto'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['contenido'];

            $insert = $pdo->prepare("INSERT INTO notificaciones
            (Clase_idClase,Asunto,Fecha,Mensaje) 
            VALUES (:clase,:asunto,:fecha,:descripcion)");

            $insert->bindParam(':clase', $idClase);
            $insert->bindParam(':asunto', $asunto);
            $insert->bindParam(':fecha', $fecha);
            $insert->bindParam(':descripcion', $descripcion);
            

            if ($insert->execute()) {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "notificacion guardada con éxito", "success", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
            } else {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurrió un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
            }
        }
 


// Add your code for database connections and other necessary functions here.
// You should define database connections and functions for storing notifications.
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NOTIFICACIÓN DE CLASE
        </h1>
        <br>
        <ol class="breadcrumb">
            <li><a href="clases.php"><i class="fa fa-dashboard"></i> LISTADO DE CLASES</a></li>
            <li class="active">AGREGAR NOTIFICACIÓN DE CLASE</li>
        </ol>
        <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">INGRESE UNA NUEVA NOTIFICACIÓN DE CLASE</h3>
            </div>
            <form action="" method="POST" name="form_notification" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">ASUNTO</label><br>
                            <input type="text" class="form-control" name="asunto" required>
                        </div>
                        <div class="form-group">
                            <label for="">FECHA DE NOTIFICACIÓN</label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="">CLASE</label>
                            <select class="form-control" name="clase" id="clase">
                                <?php
                                  $docente =$_SESSION['Cedula'];
                                $select = $pdo->prepare("SELECT * from clase where Docente_idDocente=$docente");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row)

                                ?>
                                    <option value="<?php echo $row['idClase']; ?>">
                                        <?php echo $row["Nombre"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">CONTENIDO</label>
                            <textarea name="contenido" cols="30" rows="9" class="form-control" required></textarea>
                        </div>
                    </div>

                    <center>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="add_notification">AGREGAR NOTIFICACIÓN</button>
                            <a href="clases.php" class="btn btn-warning">VOLVER</a>
                        </div>
                    </center>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper>

<?php
include_once 'inc/footer_all.php';