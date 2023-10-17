<?php
include_once 'misc/plugin.php';
include_once 'db/connect_db.php';
ob_start();
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "111100") {
        include_once 'inc/header_all.php';
    } else {
        include_once 'inc/header_all_operator.php';
    }
}   
if ($id = $_GET['id']) {
    $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per=$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $cedula = $row['doc_per'];
    $nombre = $row['nom_per'];
    $apellido = $row['ape_per'];
    $telefono = $row['tel_per'];
    $direccion= $row['dir_per'];
    $correo = $row['cor_per'];
}
if (isset($_POST['update_cliente'])) {
    $cedu_cliente = $_POST['cedula'];
    $nom_cliente = $_POST['nombre'];
    $ape_cliente = $_POST['apellido'];
    $tel_cliente = $_POST['telefono'];
    $dir_cliente = $_POST['direccion'];
    $cor_cliente = $_POST['correo'];
 
        $update = $pdo->prepare("UPDATE personas SET doc_per=:product_code,nom_per=:product_name,
                ape_per=:product_category, tel_per=:purchase_price, dir_per=:sell_price,
                cor_per=:stock WHERE doc_per=$id");

        $update->bindParam('product_code', $cedu_cliente);
        $update->bindParam('product_name', $nom_cliente);
        $update->bindParam('product_category', $ape_cliente);
        $update->bindParam('purchase_price', $tel_cliente);
        $update->bindParam('sell_price', $dir_cliente);
        $update->bindParam('stock', $cor_cliente);
       
if ($update->execute()) {
    header('location:ver_empleado.php?id=' . urlencode($id));
    ob_end_flush();
        } else {
            echo '<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Error", "Ocurri贸 un error", "error", {
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
                <h3 class="box-title">EDITAR CLIENTE</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">DOCUMENTO</label>
                            <input type="text" class="form-control" name="cedula"
                                value="<?php echo $cedula; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">NOMBRE</label>
                            <input type="text" class="form-control" name="nombre"
                                value="<?php echo $nombre; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">APELLIDO</label>
                            <input type="text" class="form-control" name="apellido"
                                value="<?php echo $apellido; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">TELEFONO</label>
                            <input type="number" class="form-control" name="telefono"
                                value="<?php echo $telefono; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">DIRECCION</label>
                            <input type="text" class="form-control" name="direccion"
                                value="<?php echo $direccion; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">CORREO</label>
                            <input type="text" class="form-control" name="correo"
                                value="<?php echo $correo; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="update_cliente">ACTUALIZAR CLIENTE</button>
                    <a href="cliente.php" class="btn btn-warning">VOLVER</a>
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