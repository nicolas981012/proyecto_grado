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

error_reporting(0);
date_default_timezone_set('America/Bogota');

if (isset($_POST['add_garantia'])) {
    
    $codigo = $_POST['codigo'];
    $orden = $_POST['orden'];
    $estadof = sacar_estado();
    $fecha = $_POST['fecha'];
    $observacion = $_POST['observacion'];
    $img = $_FILES['imagen']['name'];
    $img_tmp = $_FILES['imagen']['tmp_name'];
    $img_size = $_FILES['imagen']['size'];
    $img_ext = explode('.', $img);
    $img_ext = strtolower(end($img_ext));
    $img_new = uniqid() . '.' . $img_ext;
    $store = "upload/" . $img_new;

    if ($img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png' || $img_ext == 'gif') {
        if ($img_size >= 1000000) {
            echo '<script type="text/javascript">
                            jQuery(function validation(){
                            swal("Error", "El archivo debe tener 1 MB.", "error", {
                            button: "Continuar",
                                });
                            });
                            </script>';
            
        } else {
            if (move_uploaded_file($img_tmp, $store)) {
                $garantia_img = $img_new;
                if (!isset($error)) {

                    $insert = $pdo->prepare("INSERT INTO garantia(id_gar,id_man_gar,obs_gar,est_equ_gar,fec_gar,img_gar)
                            values(:id,:codigo,:observacion,:estado,:fecha,:imagen)");

                    $insert->bindParam(':id', $codigo);
                    $insert->bindParam(':codigo', $orden);
                    $insert->bindParam(':observacion', $observacion);
                    $insert->bindParam(':estado', $estadof );
                    $insert->bindParam(':fecha',$fecha );
                    $insert->bindParam(':imagen', $garantia_img);

                    if ($insert->execute()) {
                        echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Success", "garantia registrada", "success", {
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
                                        </script>';;
                    }
                } else {
                    echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurri贸 un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';;;
                }
            }
        }
    } else {
        $error = '<script type="text/javascript">
                jQuery(function validation(){
                swal("Error", "Sube una imagen con los siguientes formatos : jpg, jpeg, png, gif", "error", {
                button: "Continuar",
                    });
                });
                </script>';
        echo $error;
    }
}
function sacar_estado()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $estado = $_POST['estadogar'];
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
            GARANTIA
        </h1>
        <br>
    <ol class="breadcrumb">
        <li><a href= "garantia.php"><i class="fa fa-dashboard"></i>LISTADO GARANTIA</a></li>
        <li class="active">AGREGAR GARANTIA</li>
      </ol>
      <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">INGRESE UNA NUEVA GARANTIA</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">

                        <div class="form-group">
                            <?php
                            $sede = $_SESSION['sede'];
                            $select = $pdo->prepare("SELECT MAX(`id_gar`)FROM garantia ;");
                            $select->execute();
                            $row = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO</label><br>
                            <input type="text" class="form-control" name="codigo" value=" <?php echo $row; ?> " required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">ORDEN MANTENIMIENTO</label><br>
                            <input type="text" class="form-control" name="orden" value="<?php $id = $_GET['id'];
                                                                                        echo $id; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO GARANTIA</label>
                            <select class="form-control" name="estadogar" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM estados_equipo");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row)
                                ?>
                                    <option>
                                        <?php echo $row['des_est']; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">FECHA</label>
                            <input type="text" class="form-control" name="fecha" value=" <?php date_default_timezone_set('America/Bogota');
                                                                                            $DateAndTime = date('Y-m-d h:i:s ', time());
                                                                                            echo $DateAndTime; ?>  " required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">OBSERVACION</label>
                            <textarea name="observacion" id="trabajo" cols="30" rows="5" class="form-control" required></textarea>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">IMAGEN DEL EQUIPO</label><br>
                            <br>
                            <input type="file" class="input-group" name="imagen" onchange="readURL(this);" required> <br>
                            <img id="img_preview" src="upload/<?php echo $row->img_gar ?>" alt="Preview" class="img-responsive" />
                        </div>
                    </div>


                    <center>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="add_garantia">AGREGAR GARANTIA</button>
                            <a href="garantia.php" class="btn btn-warning">VOLVER</a>
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