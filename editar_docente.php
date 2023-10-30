<?php
include_once 'db/connect_db.php';
session_start();
include_once 'misc/plugin.php';
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
if ($id = $_GET['id']) {
    $select = $pdo->prepare("SELECT * FROM docente WHERE idDocente=$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $cedula = $row['idDocente'];
    $Nombre = $row['Nombre'];
    $Apellido = $row['Apellido'];
    $Correo = $row['Correo'];
    $Telefono = $row['Telefono'];
    $Contraseña = $row['Contrasena'];
    $Usuario = $row['Usuario'];
    $estado = $row['estado'];
}
if (isset($_POST['update_doc'])) {

    $dcedula = $_POST['cedula'];
    $dnombre = $_POST['nombre'];
    $dapellido = $_POST['apellido'];
    $dcorreo = $_POST['correo'];
    $dtelefono = $_POST['tel'];
    $dcontraseña = $_POST['contraseña'];
    $dusuario = $_POST['usuario'];
    $destado = $_POST['estado'];

    $update = $pdo->prepare("UPDATE docente SET Nombre=:enom,Apellido=:eape,
    Correo=:ecor,Telefono=:etel,
    Contrasena=:econtra,Usuario=:eusu,estado=:est WHERE idDocente= '$dcedula'");

    $update->bindParam('enom', $dnombre);
    $update->bindParam('eape', $dapellido);
    $update->bindParam('ecor', $dcorreo);
    $update->bindParam('etel', $dtelefono);
    $update->bindParam('econtra', $dcontraseña);
    $update->bindParam('eusu', $dusuario);
    $update->bindParam('est', $destado);

    if ($update->execute()) {
        header('location:ver_docente.php?id=' . urlencode($id));
            ob_end_flush();
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
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">EDITAR DOCENTE</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">CEDULA</label>
                            <input type="text" class="form-control" name="cedula" value="<?php echo $cedula; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">NOMBRE</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo $Nombre; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">APELLIDO</label>
                            <input type="text" class="form-control" name="apellido" value="<?php echo $Apellido; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">TELEFONO</label><br>
                            <input type="text" class="form-control" name="tel" value="<?php echo $Telefono; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">CORREO</label>
                            <input type="text" class="form-control" name="correo" value="<?php echo $Correo; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">USUARIO</label>
                            <input type="text" class="form-control" name="usuario" value="<?php echo $Usuario; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">CONTRASEÑA</label>
                            <input type="text" class="form-control" name="contraseña" value="<?php echo $Contraseña; ?>" required>
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
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="update_doc">ACTUALIZAR</button>
                    <a href="docentes.php" class="btn btn-warning">VOLVER</a>
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