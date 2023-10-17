<?php
include_once 'misc/plugin.php';
include_once 'db/connect_db.php';
session_start();
ob_start();
error_reporting(0);
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "111100") {
        include_once 'inc/header_all.php';
    } else {
        include_once 'inc/header_all_operator.php';
    }
}
date_default_timezone_set('America/Bogota');
if ($id = $_GET['id']) {
    $select = $pdo->prepare("SELECT * FROM garantia WHERE id_man_gar=$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);
    $id = $row['id_gar'];
    $codigo = $row['id_man_gar'];
    $observacion = $row['obs_gar'];
    $estado = $row['est_equ_gar'];
    $fecha = $row['fec_gar'];
    $imagen = $row['img_gar'];
    //id_gar,id_man_gar,obs_gar,est_equ_gar,fec_gar,img_gar
}
if (isset($_POST['update_garantia'])) {

    $idp = $_POST['codg'];
    $codigop = $_POST['idgar'];
    $observacionp = $_POST['obsg'];
    $estadop = sacar_estado();
    $fechap = $_POST['fecg'];
    $img = $_FILES['img']['name'];

    if (!empty($img)) {
        $img_tmp = $_FILES['img']['tmp_name'];
        $img_size = $_FILES['img']['size'];
        $img_ext = explode('.', $img);
        $img_ext = strtolower(end($img_ext));

        $img_new = uniqid() . '.' . $img_ext;

        $store = "upload/" . $img_new;

        if ($img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png' || $img_ext == 'gif') {
            if ($img_size >= 1000000) {
                echo '<script type="text/javascript">
                                jQuery(function validation(){
                                swal("Error", "el tamado de la imagen debe ser menor a 1MB", "error", {
                                button: "Continue",
                                    });
                                });
                                </script>';
            } else {
                if (move_uploaded_file($img_tmp, $store)) {
                    $img_new;
                    if (!isset($error)) {
                        $update = $pdo->prepare("UPDATE garantia SET id_gar=:id,id_man_gar=:codigo,
                                obs_gar=:observacion,est_equ_gar=:estado,fec_gar=:fecha,
                                img_gar=:imagen WHERE id_gar=$id");

                        $update->bindParam('id', $idp);
                        $update->bindParam('codigo', $codigop);
                        $update->bindParam('observacion', $observacionp);
                        $update->bindParam('estado', $estadop);
                        $update->bindParam('fecha', $fechap);
                        $update->bindParam('imagen', $img_new);
                        if ($update->execute()) {
                            header('location:ver_garantia.php?id=' . urlencode($id));
                        } else {
                            echo '<script type="text/javascript">
                            jQuery(function validation(){
                            swal("Error", "algo salio mal", "error", {
                            button: "Continue",
                                });
                            });
                            </script>';
                        }
                    } else {
                        echo '<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Error", "algo salio mal", "error", {
                        button: "Continue",
                            });
                        });
                        </script>';
                    }
                }
            }
        } else {
            echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Error", "cargar la imagen en alguno de los siguientes formatos : jpg, jpeg, png, gif", "error", {
                    button: "Continue",
                        });
                    });
                    </script>';
        }
    } else {
        $update = $pdo->prepare("UPDATE garantia SET id_gar=:id,id_man_gar=:codigo,
                                obs_gar=:observacion,est_equ_gar=:estado,fec_gar=:fecha,
                                img_gar:imagen WHERE id_gar=$id");

        $update->bindParam('id', $idp);
        $update->bindParam('codigo', $codigop);
        $update->bindParam('observacion', $observacionp);
        $update->bindParam('estado', $estadop);
        $update->bindParam('fecha', $fechap);
        $update->bindParam('imagen', $img_new);

        if ($update->execute()) {
            header('location:ver_garantia.php?id=' . urlencode($id));
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
}
function sacar_estado()
{
    try {
        $pdo = new PDO('mysql:host=68.178.221.224;dbname=soporte_tecnico_oklahoma2','admin_soporte','M1005450340s@');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $estado = $_POST['estg'];
    $select = $pdo->prepare("SELECT id_est FROM estados_equipo WHERE des_est='$estado'");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;
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
                <h3 class="box-title">EDITAR GARANTIA</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">CODIGO </label>
                            <input type="text" class="form-control" name="codg" value="<?php echo $id; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ORDEN NO</label>
                            <input type="text" class="form-control" name="idgar" value="<?php echo $codigo; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select class="form-control" name="estg" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM estados_equipo");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                ?>
                                    <option <?php if ($row['des_est'] == $estado) { ?> selected="selected" <?php } ?>>
                                        <?php echo $row['des_est']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">FECHA</label>
                            <input type="text" class="form-control" name="fecg" value="<?php echo $fecha; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">OBSERVACION</label>
                            <textarea name="obsg" id="description" cols="30" rows="4" class="form-control" required><?php echo $observacion; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                        <label for="">IMAGEN DEL EQUIPO</label>
                        <input type="file" class="input-group" name="imagen" onchange="readURL(this);" required> <br>
                            <img id="img_preview" src="upload/<?php echo $imagen?>" alt="Preview" class="img-responsive" />
                            
                            
                        </div>
                        
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="update_garantia">ACTUALIZAR GARANTIA</button>
                    <a href="garantia.php" class="btn btn-warning">VOLVER</a>
                </div>
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
                    .width(10)
                    .height(5);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php
include_once 'inc/footer_all.php';
?>