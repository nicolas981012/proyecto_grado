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

error_reporting(0);
date_default_timezone_set('America/Bogota');

if (isset($_POST['add_clase'])) {
    
    $codigoc = $_POST['codigo'];
    $nombrec = $_POST['nombre'];
    $nivelc = $_POST['nivel'];
    $fechai = $_POST['fechainicial'];
    $fechaf = $_POST['fechafinal'];
    $docente =$_SESSION['Cedula'];
    $grado=$_SESSION['grado'];
    $descripcion = $_POST['descripcion'];
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
                $clase_img = $img_new;
                if (!isset($error)) {

                    $insert = $pdo->prepare("INSERT INTO clase(idClase, Docente_idDocente, Nombre, Nivel, Descripcion, Fecha_inicial, Fecha_final, Imagen,grado) 
                    VALUES (:id,:docente,:nombre,:nivel,:descripcion,:fechai,:fechaf,:imagen,:grado)");

                    $insert->bindParam(':id', $codigoc);
                    $insert->bindParam(':docente', $docente);
                    $insert->bindParam(':nombre', $nombrec);
                    $insert->bindParam(':nivel', $nivelc);
                    $insert->bindParam(':descripcion',$descripcion);
                    $insert->bindParam(':fechai', $fechai);
                    $insert->bindParam(':fechaf', $fechaf);
                    $insert->bindParam(':imagen', $clase_img);
                    $insert->bindParam(':grado', $grado);

                    if ($insert->execute()) {
                        echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Success", "clase añadida con exitp", "success", {
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
                                        </script>';;
                    }
                } else {
                    echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "OcurriO un error", "error", {
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



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-repeat:no-repeat;background-size:cover;">


    <!-- Content Header (Page header) -->
      <section class="content-header">
         <h1>
            CLASE
        </h1>
        <br>
    <ol class="breadcrumb">
        <li><a href= "clases.php"><i class="fa fa-dashboard"></i>LISTADO DE CLASES</a></li>
        <li class="active">AGREGAR CLASE</li>
      </ol>
      <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">INGRESE UNA NUEVA CLASE</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">

                        <div class="form-group">
                        <?php
                            $select = $pdo->prepare("SELECT MAX(`idClase`)FROM clase");
                            $select->execute();
                            $row2 = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO</label><br>
                            <input type="text" class="form-control" name="codigo"  value=" <?php echo $row2; ?> " required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">NOMBRE</label><br>
                            <input type="text" class="form-control" name="nombre"required>
                        </div>
                        <div class="form-group">
                            <label for="">NIVEL</label>
                            <select class="form-control" name="nivel" required>
                            <option value="principiante">
                                    PRINCIPIANTE
                                </option>
                                <option value="intermedio">
                                    INTERMEDIO
                                </option>
                                <option value="avanzado">
                                    AVANZADO
                                </option>
                            </select>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">FECHA INICIAL</label>
                            <input type="date" class="form-control" name="fechainicial"required>
                        </div>
                        <div class="form-group">
                            <label for="">FECHA FINAL</label>
                            <input type="date" class="form-control" name="fechafinal" required>
                        </div>
                        <div class="form-group">
                            <label for="">DESCRIPCION</label>
                            <textarea name="descripcion" id="trabajo" cols="30" rows="1" class="form-control" required></textarea>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">IMAGEN</label><br>
                            <br>
                            <input type="file" class="input-group" name="imagen" onchange="readURL(this);" required> <br>
                        </div>
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
                    </div>


                    <center>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="add_clase">AGREGAR CLASE</button>
                            <a href="clases.php" class="btn btn-warning">VOLVER</a>
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