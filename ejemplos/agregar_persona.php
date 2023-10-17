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

date_default_timezone_set('America/Mexico_City');
if (isset($_POST['add_client'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];


    if (isset($_POST['cedula'])) {
        $select = $pdo->prepare("SELECT doc_per FROM personas WHERE doc_per='$cedula'");
        $select->execute();
        if ($select->rowCount() > 0) {
            echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Cliente ya registrado", "warning", {
                    button: "Continuar",
                        });
                    });
                    </script>';
        } else {

            $insert = $pdo->prepare("INSERT INTO personas(doc_per,nom_per,ape_per,tel_per,dir_per,cor_per)
                            values(:cedula,:nombre,:apellido,:telefono,:direccion,:correo)");

            $insert->bindParam(':cedula', $cedula);
            $insert->bindParam(':nombre', $nombre);
            $insert->bindParam(':apellido', $apellido);
            $insert->bindParam(':telefono', $telefono);
            $insert->bindParam(':direccion', $direccion);
            $insert->bindParam(':correo', $correo);

            if ($insert->execute()) {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "cliente guardado con 茅xito", "success", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
            } else {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurri贸 un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
                ;

            }
        }

    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
         <h1>
            CLIENTE
        </h1>
        <br>
    <ol class="breadcrumb">
        <li><a href= "cliente.php"><i class="fa fa-dashboard"></i>LISTADO CLIENTE</a></li>
        <li class="active">AGREGAR CLIENTE</li>
      </ol>
      <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">INGRESE UN NUEVO CLIENTE</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="">CEDULA</label><br>
                            <input type="text" class="form-control" name="cedula" required>
                        </div>
                        <div class="form-group">
                            <label for="">NOMBRES</label><br>
                            <input type="text" class="form-control" name="nombres" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">APELLIDOS</label><br>
                            <input type="text" class="form-control" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="">TELEFONO</label><br>
                            <input type="text" class="form-control" name="telefono" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">DIRECCION</label><br>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="">CORREO</label><br>
                            <input type="text" class="form-control" name="correo" required>
                        </div>
                    </div>
                </div>

                <center>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="add_client">AGREGAR CLIENTE</button>
                        <a href="cliente.php" class="btn btn-warning">VOLVER</a>
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

            reader.onload = function (e) {
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