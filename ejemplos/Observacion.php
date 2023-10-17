<?php
include_once 'db/connect_db.php';
session_start();
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
    $select = $pdo->prepare("SELECT * FROM mantenimiento WHERE id_man='$id'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $id = $row['id_man'];
    $con = $row['con_man'];
    $doc = $row['doc_cli'];
    $docusu = $row['id_usu'];
    $fecha = $row['fec_man'];
    $equipo = $row['equ_man'];
    $valor = $row['val_man'];
    $referencia = $row['ref_equ'];
    $serial = $row['ser_equ'];
    $marca = $row['mar_equ'];
    $falla = $row['fal_equ'];
    $trabajo = $row['tra_equ'];
    $observacion = $row['obs_man'];
    $estadoman = $row['est_man'];
    $estadoequ = $row['est_equ'];
    $accesorios = $row['acc_equ'];
    $sede = $row['sed_emp_man'];
}
if (isset($_POST['add_orden'])) {
    $codigo = $_POST['codigo'];
    $Fecha = $_POST['Fecha'];
    $Estado = sacar_estado();
    $empleado = $_POST['empleado'];
    $id = $_POST['id'];
    $url = $_POST['url'];
    $observacion = $_POST['observacion'];

    $insert = $pdo->prepare("INSERT INTO observaciones(id_obs,fec_obs,obs_pre,obs_obs,usu_obs,id_man_obs,url_obs)
            values(:id,:fec,:observacion,:nota,:usuario,:mantenimiento,:urlobs)");

    $insert->bindParam(':id', $codigo);
    $insert->bindParam(':fec', $Fecha);
    $insert->bindParam(':observacion', $Estado);
    $insert->bindParam(':nota', $observacion);
    $insert->bindParam(':usuario', $empleado);
    $insert->bindParam(':mantenimiento', $id);
    $insert->bindParam(':urlobs', $url);
    
    if ($insert->execute()) {
        header('location:ver_historial.php?id='. urlencode($id));
        ob_end_flush();
        //echo '<script> window.location.href='ver_historial.php?id=' . urlencode($id) </script>';
    } else {
        echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurri車 un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';;
    }
}

function sacar_estado()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $estado2 = $_POST['estado'];
    $select = $pdo->prepare("SELECT id_obs FROM observaciones_predis WHERE obs_pre='$estado2'");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;
}
function sacarnombre($nombre)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    //$sede = $_GET['sede'];
    $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per='$nombre'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->nom_per . ' ' . ' ' . $row->ape_per;
}



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            OBSERVACION
        </h1>
        <hr>
       
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        
        <div class="box box-success">
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                <div class="col-md-6">
            <ul class="list-group">


              <p class="list-group-item list-group-item-info">DATOS BASICOS</p>

              <li class="list-group-item"> <b>ID MANTENIMIENTO</b> :<span class="label badge pull-right">
                  <?php echo $id; ?>
                </span></li>
              <li class="list-group-item"><b>QUIEN REALIZA EL MANTENIMIENTO</b> :<span class="label label-info pull-right">
                  <?php echo  $docusu; ?>
                </span></li>
              <li class="list-group-item"><b>FECHA</b> :<span class="label label-primary pull-right">
                  <?php echo $fecha; ?>
                </span></li>
              <li class="list-group-item"><b>CLIENTE</b> :<span class="label label-primary pull-right">
                  <?php echo sacarnombre($doc); ?>
                </span></li>

            </ul>
          </div>
          <div class="col-md-6">
            <ul class="list-group">

              <p class="list-group-item list-group-item-info">DETALLE DEL EQUIPO</p>

              <li class="list-group-item"><b>EQUIPO</b> :<span class="label label-warning pull-right">
                  <?php echo $equipo; ?>
                </span></li>
              <li class="list-group-item"><b>REFERENCIA</b> :<span class="label label-warning pull-right">
                  <?php echo $referencia; ?>
                </span></li>
              <li class="list-group-item"><b>SERIAL</b> :<span class="label label-warning pull-right">
                  <?php echo $serial; ?>
                </span></li>
              <li class="list-group-item"><b>FALLA</b> :<span class="label label-warning pull-right">
                  <?php echo $falla ; ?>
                </span></li>
            </ul>
            <br><br><br><br>
          </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <?php
                            $sede = $_SESSION['sede'];
                            $select = $pdo->prepare("SELECT MAX(`id_obs`)FROM observaciones");
                            $select->execute();
                            $row = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO</label><br>
                            <input type="text" class="form-control" name="codigo" value=" <?php echo $row; ?> " required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">FECHA</label><br>
                            <input type="text" class="form-control" name="Fecha" value=" <?php date_default_timezone_set('America/Bogota');
                                                                                            $DateAndTime = date('Y-m-d h:i:s ', time());
                                                                                            echo $DateAndTime; ?>  " required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select class="form-control" name="estado" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM observaciones_predis");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row)
                                ?>
                                    <option>
                                        <?php echo $row['obs_pre']; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">QUIEN REALIZO EL TRABAJO</label>
                            <input type="text" class="form-control" name="empleado" value="<?php echo $_SESSION['user_id']; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ID MANTENIMIENTO</label>
                            <input type="text" class="form-control" name="id" value="<?php $id = $_GET['id'];
                                                                                        echo $id; ?>" required readonly>
                        </div>
                        <div class="form-group form-row">
                            <label for="">URL</label>
                            <input type="text" class="form-control" name="url">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">OBSERVACION</label>
                            <textarea name="observacion" id="description" cols="30" rows="6" class="form-control" required></textarea>
                        </div>
                    </div>


                    <center>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="add_orden">AGREGAR OBSERVACION</button>
                            <a href="Orden.php" class="btn btn-warning">VOLVER</a>
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