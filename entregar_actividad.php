
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
    if (isset($_GET['actividad_id'])) {
        $contenido_id = $_GET['actividad_id'];
        if (isset($_POST['add_eactividad'])) {

            $codigoconte = $_POST['codigo'];
            $claseconte = $_POST['clase'];
            $tituloconte = $_POST['titulo'];
            $archivoconte = $_POST['archivo'];
            $estadoconte = $_POST['estado'];
            $textoconte = $_POST['texto'];
            $img = $_FILES['archivo']['name'];
            $img_tmp = $_FILES['archivo']['tmp_name'];
            $img_size = $_FILES['archivo']['size'];
            $img_ext = explode('.', $img);
            $img_ext = strtolower(end($img_ext));
            $img_new = uniqid() . '.' . $img_ext;
            $store = "upload/" . $img_new;

            if ($img_ext == 'docx' || $img_ext == 'pdf') {
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

                            $insert = $pdo->prepare("INSERT INTO contenido(idContenido, Clase_idClase, titulo, 
                    contenido_texto, archivo, estado, video) VALUES
                    (:id,:clase,:titulo,:texto,:archivo,:estado,:video)");

                            $insert->bindParam(':id', $codigoconte);
                            $insert->bindParam(':clase', $claseconte);
                            $insert->bindParam(':titulo', $tituloconte);
                            $insert->bindParam(':texto', $textoconte);
                            $insert->bindParam(':archivo', $archivo_img);
                            $insert->bindParam(':estado', $estadoconte);
                            $insert->bindParam(':video', $videoconte);


                            if ($insert->execute()) {
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Success", "actividad entregada con exito ", "success", {
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
    }

    ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ACTIVIDAD
        </h1>
        <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">ENTREGAR ACTIVIDAD </h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-6">

                        <div class="form-group">
                            <?php
                            $select = $pdo->prepare("SELECT MAX(`idContenido`)FROM contenido");
                            $select->execute();
                            $row2 = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO</label><br>
                            <input type="text" class="form-control" name="codigo" value=" <?php echo $row2; ?> " required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">ARCHIVO(solo si es necesario)</label>
                            <br>
                            <input type="file" class="input-group" name="archivo" onchange="readURL(this);"> <br>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <label>RESPUESTA(solo texto)</label>
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
                                    <textarea id="editor1" name="texto" rows="10" cols="80" required>

                    </textarea>
                                </form>
                            </div>
                        </div>

                        <center>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary" name="add_eactividad">ENTREGAR</button>
                                <a href="dashboard.php" class="btn btn-warning">CANCELAR</a>
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