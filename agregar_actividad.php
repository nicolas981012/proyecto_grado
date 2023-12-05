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

if (isset($_POST['add_actividad'])) {

    $codigoac = $_POST['codigo'];
    $claseac = $_POST['clase'];
    $tituloac = $_POST['titulo'];
    $objetivosac = $_POST['texto'];
    $estado= $_POST['estado'];
    $fecha = $_POST['fecha_limite'];
    $actividad= $_POST['tipo_actividad'];
    $estadoacti='1';
    $arch="";
    $cali="";
    $coment="";
    $img = $_FILES['archivo']['name'];
    $img_tmp = $_FILES['archivo']['tmp_name'];
    $img_size = $_FILES['archivo']['size'];
    $img_ext = explode('.', $img);
    $img_ext = strtolower(end($img_ext));
    $img_new = uniqid() . '.' . $img_ext;
    $store = "upload/" . $img_new;
    
    if ($img_ext == 'docx' || $img_ext == 'pdf' || $img_ext == 'pptx') {
        if ($img_size >= 10000000) {
            echo '<script type="text/javascript">
                            jQuery(function validation(){
                            swal("Error", "El archivo debe tener 10 MB como maximo.", "error", {
                            button: "Continuar",
                                });
                            });
                            </script>';
        } else {
            if (move_uploaded_file($img_tmp, $store)) {
                $archivo_img = $img_new;
                if (!isset($error)) {


                    $insert = $pdo->prepare("INSERT INTO actividad(idActividad, Clase_idClase, titulo, 
                    objetivo, tipo_actividad, estado, 
                    Fecha_limite, archivo) VALUES 
                    (:id,:clase,:titulo,:objetivo,:actividad,:estado,:fecha,:archivo)");
                    $insert->bindParam(':id', $codigoac);
                    $insert->bindParam(':clase', $claseac);
                    $insert->bindParam(':titulo', $tituloac);
                    $insert->bindParam(':objetivo', $objetivosac);
                    $insert->bindParam(':actividad', $actividad);
                    $insert->bindParam(':estado', $estado);
                    $insert->bindParam(':archivo', $archivo_img);
                    $insert->bindParam(':fecha', $fecha);
                    if ($insert->execute()) {
                        echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "actividad añadido con exito ", "success", {
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
                swal("Error", "Sube un documento con los siguientes formatos : docx,pdf", "error", {
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
            ACTIVIDADES
        </h1>
        <br>
        <ol class="breadcrumb">
            
            <li class="active">AGREGAR ACTIVIDAD</li>
        </ol>
        <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">AÑADIR
                    ACTIVIDAD A CLASE </h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-6">

                        <div class="form-group">
                            <?php
                            $select = $pdo->prepare("SELECT MAX(`idActividad`)FROM actividad");
                            $select->execute();
                            $row2 = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO</label><br>
                            <input type="text" class="form-control" name="codigo" value=" <?php echo $row2; ?> " required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">TITULO</label><br>
                            <input type="text" class="form-control" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="">CLASE</label>
                            <select class="form-control" name="clase" id="clase">
                                <?php
                                $docente = $_SESSION['Cedula'];
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
                        <div class="form-group">
                            <label for="">ARCHIVO</label>
                            <br>
                            <input type="file" class="input-group" name="archivo" onchange="readURL(this);" required> <br>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select class="form-control" name="estado" required>
                                <option value="1">
                                    ACTIVA
                                </option>
                                <option value="0">
                                    INACTIVO
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">FECHA LIMITE ENTREGA:</label>
                            <input type="date" class="form-control" name="fecha_limite" required>
                        </div>
                        <div class="form-group">
                                <label for="">TIPO DE ACTIVIDAD:</label>
                                <select class="form-control" name="tipo_actividad" required>
                                    <option value="LECTURA">
                                        LECTURA
                                    </option>
                                    <option value="ESCRITURA">
                                        ESCRITURA
                                    </option>
                                    <option value="AUDIO">
                                        AUDIO
                                    </option>
                                </select>
                            </div>

                    </div>
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <label>Ingrese los objetivos de la actividad</label>
                                </h3>
                                <!-- tools box -->
                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                                        <i class="fa fa-times"></i></button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
                                <form>
                                    <textarea id="editor1" name="texto" rows="10" cols="80">

                    </textarea>
                                </form>
                            </div>
                        </div>

                        <center>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary" name="add_actividad">AGREGAR ACTIVIDAD</button>
                                <a href="" class="btn btn-warning">VOLVER</a>
                            </div>
                        </center>
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
<script>
    $(function() {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1')
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5()
    })
</script>
<!-- CK Editor -->
<script src="bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<?php
include_once 'inc/footer_all.php';
?>