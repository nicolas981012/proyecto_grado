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

date_default_timezone_set('America/Mexico_City');
if (isset($_POST['add_alum'])) {

    $cedula = $_POST['cedula'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $estado = $_POST['estado'];
    $telefono = $_POST['tel'];
    $correo = $_POST['email'];
    $grado = $_POST['grado'];
    $apellido = $_POST['apellido'];
    $administrador= $_SESSION['Cedula'];
    $nombre = $_POST['nombre'];


    if (isset($_POST['cedula'])) {
        $select = $pdo->prepare("SELECT id_alumno FROM alumno WHERE id_alumno='$cedula'");
        $select->execute();

        if ($select->rowCount() > 0) {
            echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "alumno ya registrado", "warning", {
                    button: "Continuar",
                        });
                    });
                    </script>';
        } else {

            $insert = $pdo->prepare("INSERT INTO `alumno`(`id_Alumno`, `administrador_Cedula`, `Nombre`, `Apellido`, `Grado`, `Correo`, `Telefono`, `Contrasena`, `Usuario`, `estado`) VALUES
                                                 (:id,:administrador,:nombre,:apellido,:grado,:email,:telefono,:contrasena,:usuario,:estado)");

            $insert->bindParam(':id', $cedula);
            $insert->bindParam(':administrador', $administrador);
            $insert->bindParam(':nombre', $nombre);
            $insert->bindParam(':apellido', $apellido);
            $insert->bindParam(':grado', $grado);
            $insert->bindParam(':email', $email);
            $insert->bindParam(':telefono', $telefono);
            $insert->bindParam(':contrasena', $contrasena);
            $insert->bindParam(':usuario', $usuario);
            $insert->bindParam(':estado', $estado);

            if ($insert->execute()) {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "alumno guardado con éxito", "success", {
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
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-repeat:no-repeat;background-size:cover;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ALUMNO
        </h1>
        <br>
        <ol class="breadcrumb">
            <li><a href="cliente.php"><i class="fa fa-dashboard"></i>LISTADO ALUMNOS</a></li>
            <li class="active">AGREGAR ALUMNO</li>
        </ol>
        <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">INGRESE UN NUEVO ALUMNO</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="">CEDULA</label><br>
                            <input type="text" class="form-control" name="cedula">
                        </div>
                        <div class="form-group">
                            <label for="">NOMBRE</label><br>
                            <input type="text" class="form-control" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="">APELLIDO</label><br>
                            <input type="text" class="form-control" name="apellido">
                        </div>
                       
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">GRADO</label><br>
                            <select class="form-control" name="grado" required>
                            <?php
                                  $docente =$_SESSION['Cedula'];
                                $select = $pdo->prepare("SELECT * from grado where estado=1");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row)

                                ?>
                                    <option value="<?php echo $row['id_grado']; ?>">
                                        <?php echo $row["Grado_numerico"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO</label><br>
                            <select class="form-control" name="estado" required>
                                <option value="1">
                                    ACTIVO
                                </option>
                                <option value="0">
                                    INACTIVO
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">TELEFONO</label><br>
                            <input type="text" class="form-control" name="tel">
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                            <label for="">USUARIO</label><br>
                            <input type="text" class="form-control" name="usuario">
                        </div>
                        <div class="form-group">
                            <label for="">CONTRASEÑA</label><br>
                            <input type="text" class="form-control" name="contrasena">
                        </div>
                        <div class="form-group">
                            <label for="">CORREO</label><br>
                            <input type="text" class="form-control" name="email">
                        </div>
                        
                    </div>
                </div>

                <center>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="add_alum">AGREGAR ALUMNO</button>
                        <a href="alumnos.php" class="btn btn-warning">VOLVER</a>
                    </div>
                </center>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img_preview').attr('src', e.target.result)
                    .width(250)
                    .height(200);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php
include_once 'inc/footer_all.php';
?>