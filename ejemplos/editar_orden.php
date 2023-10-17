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
if (isset($_POST['update_cliente'])) {
    //$pid = $_POST['cedula'];
    $pcon = $_POST['codigo'];
    $pdoc = $_POST['cedulac'];
    $pdocusu = $_SESSION['user_id'];;
    //$pfecha = $_POST['cedula'];
    $pequipo = $_POST['equipo'];
    $pvalor = $_POST['valor'];
    $preferencia = $_POST['referencia'];
    $pserial = $_POST['serial'];
    $pmarca = $_POST['marca'];
    $pfalla = $_POST['falla'];
    $ptrabajo = $_POST['trabajo'];
    $pobservacion = $_POST['observacion'];
    $pestadoman = sacar_mantenimiento2();
    $pestadoequ = $_POST['estado'];
    $paccesorios = $_POST['accesorios'];
    $psede = $_SESSION['sede'];

    $update = $pdo->prepare("UPDATE mantenimiento SET con_man=:econ,
                doc_cli=:edocl, id_usu=:eidusu,
                equ_man=:equ,val_man=:eval,ref_equ=:eref,
                ser_equ=:eser,mar_equ=:emar, fal_equ=:efal,
                tra_equ=:etra,obs_man=:eobs,est_man=:est1,
                est_equ=:est,acc_equ=:eacc,sed_emp_man=:esedem WHERE id_man='$id'");

    //$update->bindParam('eid', $pid);
    $update->bindParam('econ', $pcon);
    $update->bindParam('edocl', $pdoc);
    $update->bindParam('eidusu', $pdocusu);
    //$update->bindParam('efec', $pfecha);
    $update->bindParam('equ', $pequipo);
    $update->bindParam('eval', $pvalor);
    $update->bindParam('eref', $preferencia);
    $update->bindParam('eser', $pserial);
    $update->bindParam('emar', $pmarca);
    $update->bindParam('efal', $pfalla);
    $update->bindParam('etra', $ptrabajo);
    $update->bindParam('eobs', $pobservacion);
    $update->bindParam('est1', $pestadoman);
    $update->bindParam('est', $pestadoequ);
    $update->bindParam('eacc', $paccesorios);
    $update->bindParam('esedem', $psede);

    if ($update->execute()) {
        header('location:ver_orden.php?id=' . urlencode($id));
        ob_end_flush();
    } else {
        echo '<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Error", "Ocurri車 un error", "error", {
                        button: "Continuar",
                            });
                        });
                        </script>';
    }
}
function sacar_mantenimiento2()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $estadoman = $_POST['estadoman'];
    $select = $pdo->prepare("SELECT id_est FROM estados_equipo WHERE des_est='$estadoman'");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;
}
function Sacarnombreempleado()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $estadoman = $_SESSION['user_id'];
    $select = $pdo->prepare("SELECT nom_usu FROM usuario WHERE doc_usu='$estadoman'");
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
                <h3 class="box-title">EDITAR ORDEN</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">

                        <div class="form-group">
                            <?php
                            $sede = $_SESSION['sede'];
                            $select = $pdo->prepare("SELECT MAX(`con_man`)FROM mantenimiento WHERE sed_emp_man = $sede;");
                            $select->execute();
                            $row = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO DE ORDEN</label><br>
                            <input type="text" class="form-control" name="codigo" value="<?php echo $con; ?>" required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="">CEDULA DEL CLIENTE</label><br>
                            <input type="text" class="form-control" value="<?php echo $doc; ?>" name="cedulac" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">QUIEN REALIZO EL TRABAJO</label><br>
                            <input type="text" class="form-control" name="cedula" value="<?php echo Sacarnombreempleado(); ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">EQUIPO</label>
                            <input type="text" class="form-control" value="<?php echo $equipo; ?>" name="equipo" required>
                        </div>
                        <div class="form-group">
                            <label for="">VALOR</label>
                            <input type="number" class="form-control" value="<?php echo $valor; ?>" name="valor" required>
                        </div>
                        <div class="form-group">
                            <label for="">REFERENCIA</label>
                            <input type="text" class="form-control" value="<?php echo $referencia; ?>" name="referencia" required>
                        </div>
                        <div class="form-group form-row">
                            <label for="">SERIAL</label>
                            <input type="text" class="form-control" value="<?php echo $serial; ?>" name="serial" required>
                        </div>
                        <div class="form-group">
                            <label for="">MARCA</label>
                            <input type="text" class="form-control" value="<?php echo $marca; ?>" name="marca" required>
                        </div>
                        <div class="form-group">
                            <label for="">FALLA DEL EQUIPO</label>
                            <textarea name="falla" id="descripcion" cols="30" rows="10" class="form-control" value="" required><?php echo $falla; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">TRABAJO REALIZADO</label>
                            <textarea name="trabajo" id="trabajo" cols="30" rows="10" class="form-control" value="<?php echo $trabajo; ?>" required><?php echo $trabajo; ?></textarea>
                        </div>
                        <div class="form-group form-row">
                            <label for="">OBSERVACION</label>
                            <textarea name="observacion" id="observacion" cols="30" rows="10" class="form-control" value="<?php echo $observacion; ?>" required><?php echo $observacion; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO MANTENIMIENTO</label>
                            <select class="form-control" name="estadoman" id="estadoman">
                                <?php
                                $estadoman;
                                $select2 = $pdo->prepare("SELECT des_est FROM estados_equipo WHERE id_est='$estadoman'");
                                $select2->execute();
                                $row2 = $select2->fetchColumn();
                                $select = $pdo->prepare("SELECT * FROM estados_equipo");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row)

                                ?>
                                    <option <?php if($row['des_est']==$row2) {?>
                                    selected = "selected"
                                    <?php }?> >
                                        <?php echo $row["des_est"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO EQUIPO</label>
                            <textarea name="estado" id="description" cols="30" rows="10" class="form-control" value="<?php echo $estadoequ; ?>" required><?php echo $estadoequ; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">ACCESORIOS</label>
                            <textarea name="accesorios" id="description" cols="30" rows="10" class="form-control" value="<?php echo $accesorios; ?>" required><?php echo $accesorios; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">SEDE</label>
                            <input name="sede" id="description" cols="30" rows="10" class="form-control" value="
                            <?php
                            $SEDE = $_SESSION['sede'];
                            $select = $pdo->prepare("SELECT ciu_emp FROM sedes_empresa WHERE id_emp='$SEDE'");
                            $select->execute();
                            echo $row = $select->fetchColumn();
                            ?>" required readonly>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="update_cliente">ACTUALIZAR ORDEN</button>
                    <a href="orden.php" class="btn btn-warning">VOLVER</a>
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