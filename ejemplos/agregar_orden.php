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
$array = array();
date_default_timezone_set('America/Bogota');
$_SESSION['cedula'] = $_POST['cliente'];
if (isset($_POST['add_orden'])) {
    $codigo = $_POST['codigo'];
    $cedula_cliente = $_POST['cliente'];
    $fecha =  $fecha = date('Y-m-d H:m:s');
    $equipo = $_POST['equipo'];
    $valor = $_POST['valor'];
    $referencia = $_POST['referencia'];
    $serial1 = $_POST['serial'];
    $marca = $_POST['marca'];
    $falla = $_POST['falla'];
    $trabajo = $_POST['trabajo'];
    $observacion = $_POST['observacion'];
    $estadoequipo = $_POST['estado'];
    $accesorios = $_POST['accesorios'];
    $sede = $_SESSION['sede'];

    if (isset($_POST['cedula'])) {
        $select = $pdo->prepare("SELECT doc_per FROM personas WHERE doc_per = '$cedula_cliente'");
        $select->execute();

        if ($select->rowCount() > 0) {
            $id = sacar_id();
            $cedulaf = $_SESSION['user_id'];;
            $mantefinal = sacar_mantenimiento();


            $insert = $pdo->prepare("INSERT INTO mantenimiento(id_man,con_man,doc_cli,id_usu,fec_man,equ_man,val_man,ref_equ,ser_equ,mar_equ,fal_equ,tra_equ,obs_man,est_man,est_equ,acc_equ,sed_emp_man)
            values(:id,:con,:cedula,:empleado,:fecha,:equipo,:valor,:referencia,:serial1,:marca,:falla,:trabajo,:observacion,:estado,:estadoequipo,:accesorios,:sede1)");
            $insert->bindParam(':id', $id);
            $insert->bindParam(':con', $codigo);
            $insert->bindParam(':cedula', $cedula_cliente);
            $insert->bindParam(':empleado', $cedulaf);
            $insert->bindParam(':fecha', $fecha);
            $insert->bindParam(':equipo', $equipo);
            $insert->bindParam(':valor', $valor);
            $insert->bindParam(':referencia', $referencia);
            $insert->bindParam(':serial1', $serial1);
            $insert->bindParam(':marca', $marca);
            $insert->bindParam(':falla', $falla);
            $insert->bindParam(':trabajo', $trabajo);
            $insert->bindParam(':observacion', $observacion);
            $insert->bindParam(':estado',  $mantefinal);
            $insert->bindParam(':estadoequipo', $estadoequipo);
            $insert->bindParam(':accesorios', $accesorios);
            $insert->bindParam(':sede1', $sede);

            if ($insert->execute()) {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "orden registrada", "success", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
                $hola = 1;
                header('location:ver_orden.php?id=' . urlencode($id));
                ob_end_flush();

            } else {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurri車 un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';;
                $hola = 2;
            }
        } else {

            echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Cliente no registrado", "warning", {
                    button: "Continuar",
                        });
                    });
                    </script>';


            $insert = $pdo->prepare("INSERT INTO mantenimiento(id_man,con_man,doc_cli,id_usu,fec_man,equ_man,val_man,ref_equ,ser_equ,mar_equ,fal_equ,tra_equ,obs_man,est_man,est_equ,acc_equ,sed_emp_man)
                    values(:id,:con,:cedula,:empleado,:fecha,:equipo,:valor,:referencia,:serial1,:marca,:falla,:trabajo,:observacion,:estado,:estadoequipo,:accesorios,:sede1)");
            $insert->bindParam(':id', $id);
            $insert->bindParam(':con', $codigo);
            $insert->bindParam(':cedula', $cedula_cliente);
            $insert->bindParam(':empleado', $cedulaf);
            $insert->bindParam(':fecha', $fecha);
            $insert->bindParam(':equipo', $equipo);
            $insert->bindParam(':valor', $valor);
            $insert->bindParam(':referencia', $referencia);
            $insert->bindParam(':serial1', $serial1);
            $insert->bindParam(':marca', $marca);
            $insert->bindParam(':falla', $falla);
            $insert->bindParam(':trabajo', $trabajo);
            $insert->bindParam(':observacion', $observacion);
            $insert->bindParam(':estado',  $mantefinal);
            $insert->bindParam(':estadoequipo', $estadoequipo);
            $insert->bindParam(':accesorios', $accesorios);
            $insert->bindParam(':sede1', $sede);
        }
    }
}


function sacar_cedula()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $cedula_empleado = $_POST['empleado'];
    $select = $pdo->prepare("SELECT doc_usu FROM usuario WHERE usu='$cedula_empleado'");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;
}
function sacarcedulac()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $cedula_cliente = $_POST['Cedula2'];
    $select = $pdo->prepare("SELECT doc_per FROM personas WHERE doc_per= $cedula_cliente ");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;
}
function sacar_mantenimiento()
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
function sacar_id()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }

    $codigo = $_SESSION['sede'];
    $id = "";
    $select = $pdo->prepare("SELECT MAX(`con_man`)FROM mantenimiento WHERE sed_emp_man = $codigo;");
    $select->execute();
    $row = $select->fetchColumn() + 1;

    if ($_SESSION['sede'] == 1) {
        $id = 'S' . "-" . strval($row);
    } elseif ($_SESSION['sede'] == 3) {
        $id =  'M' . "-" . strval($row);
    } elseif ($_SESSION['sede'] == 4) {
        $id =  'A' . "-" . strval($row);
    } elseif ($_SESSION['sede'] == 6) {
        $id =  'Y' . "-" . strval($row);
    }
    $id2 = strval($id);
    return $id2;
}
function sacar_sede()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $codigo = $_POST['sede'];
    $select = $pdo->prepare("SELECT id_emp FROM sedes_empresa WHERE ciu_emp='$codigo'");
    $select->execute();
    $row = $select->fetchColumn();
    $row = (int)$row;
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
function almacenardatos()
{
    $codigo = $_POST['codigo'];
    $cedula_cliente = $_POST['cliente'];
    $fecha =  $fecha = date('Y-m-d H:m:s');
    $equipo = $_POST['equipo'];
    $valor = $_POST['valor'];
    $referencia = $_POST['referencia'];
    $serial1 = $_POST['serial'];
    $marca = $_POST['marca'];
    $falla = $_POST['falla'];
    $trabajo = $_POST['trabajo'];
    $observacion = $_POST['observacion'];
    $estadoequipo = $_POST['estado'];
    $accesorios = $_POST['accesorios'];
    $sede = $_SESSION['sede'];

    $array["cliente2"] = "$cedula_cliente";
    $array["cliente"] = "$cedula_cliente";
    $array["equipo"] = "$equipo";
    $array["valor"] = "$valor";
    $array["referencia"] = "$referencia";
    $array["serial1"] = "$serial1";
    $array["marca"] = "$marca";
    $array["falla"] = "$falla";
    $array["trabajo"] = "$trabajo";
    $array["observacion"] = "$observacion";
    $array["estado"] = "$estadoequipo";
    $array["accesorios"] = "$accesorios";
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
         <h1>
            ORDEN
        </h1>
        <br>
    <ol class="breadcrumb">
        <li><a href= "orden.php"><i class="fa fa-dashboard"></i>LISTADO ORDEN</a></li>
        <li class="active">AGREGAR ORDEN</li>
      </ol>
      <br>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">INGRESE UNA NUEVA ORDEN</h3>
            </div>
            <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off"  >
                <div class="box-body">
                    <div class="col-md-4">

                        <div class="form-group">
                            <?php
                            $sede = $_SESSION['sede'];
                            $select = $pdo->prepare("SELECT MAX(`con_man`)FROM mantenimiento WHERE sed_emp_man = '$sede'");
                            $select->execute();
                            $row2 = $select->fetchColumn() + 1;
                            ?>
                            <label for="">CODIGO DE ORDEN</label><br>
                            <input type="text" class="form-control" id="codigo" name="codigo" value=" <?php echo $row2; ?> " required readonly>
                            <?php

                            ?>
                        </div>
                        <div class="input-group">
                            <label for="">CEDULA CLIENTE</label><br>
                            <input type="text" class="form-control" name="cliente" value="<?php echo $_SESSION['cedula']  ?>">
                            <br><br><br>
                            <div class="input-group-btn">
                                <button class="btn btn-default" name="C_Cliente" type="submit">CONSULTAR
                                </button>
                            </div>
                        </div>
                        <?php
                       
                        if (isset($_POST['C_Cliente'])) {
                            $cedula_cliente = $_POST['cliente'];
                            $_SESSION['cedula'] = $cedula_cliente;
                            $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per='$cedula_cliente'");
                            $select->execute();
                            $row = $select->fetch(PDO::FETCH_ASSOC);
                            $cedula = $row['doc_per'];
                            $nombre = $row['nom_per'];
                            $apellido = $row['ape_per'];
                            $telefono = $row['tel_per'];
                            $direccion = $row['dir_per'];
                            $correo = $row['cor_per'];
                            $row2 = $select->rowCount();
                            if ($row2 == 0) { ?>
                                <p class="box-title"><span class="label label-danger pull-right">Cliente no registrado</span></p>
                                <div class="form-group">
                                    <label for="">CEDULA</label>
                                    <input type="text" class="form-control" name="Doccliente" value="<?php echo $cedula_cliente ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">NOMBRE</label>
                                    <input type="text" class="form-control" name="nomcliente">
                                </div>
                                <div class="form-group">
                                    <label for="">APELLIDO</label>
                                    <input type="text" class="form-control" name="apecliente">
                                </div>
                                <div class="form-group form-row">
                                    <label for="">TELEFONO</label>
                                    <input type="text" class="form-control" name="telcliente">
                                </div>
                                <div class="form-group">
                                    <label for="">DIRECCION</label>
                                    <input type="text" class="form-control" name="dircliente">
                                </div>
                                <div class="form-group">
                                    <label for="">CORREO</label>
                                    <input type="text" class="form-control" name="corcliente">
                                </div>
                                <center>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success" name="Crear_Cliente" type="submit">Crear cliente
                                        </button>
                                    </div>
                                </center>
                                <br><br>
                            <?php
                            } else { ?>
                                <p class="box-title"><span class="label label-success pull-right">Cliente registrado</span></p>
                                <div class="form-group">
                                    <label for="">CEDULA</label>
                                    <input type="text" class="form-control" name="editcedula" value="<?php echo $cedula ?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">NOMBRE</label>
                                    <input type="text" class="form-control" name="editnombre" value="<?php echo $nombre ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">APELLIDO</label>
                                    <input type="text" class="form-control" name="editapellido" value="<?php echo $apellido ?>">
                                </div>
                                <div class="form-group form-row">
                                    <label for="">TELEFONO</label>
                                    <input type="text" class="form-control" name="editelefono" value="<?php echo $telefono ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">DIRECCION</label>
                                    <input type="text" class="form-control" name="editdireccion" value="<?php echo $direccion ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">CORREO</label>
                                    <input type="text" class="form-control" name="editcorreo" value="<?php echo $correo ?>">
                                </div>
                                <center>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" name="Editar_Cliente" type="submit">Editar Cliente
                                        </button>
                                </center>
                                <br><br>

                        <?php
                            }
                        }
                        ?>
                        <?php
                        if (isset($_POST['Crear_Cliente'])) {
                            $cedulac = $_POST['Doccliente'];
                            $nombrec = $_POST['nomcliente'];
                            $apellidoc = $_POST['apecliente'];
                            $telefonoc = $_POST['telcliente'];
                            $direccionc = $_POST['dircliente'];
                            $correoc = $_POST['corcliente'];
                            $insert = $pdo->prepare("INSERT INTO personas(doc_per,nom_per,ape_per,tel_per,dir_per,cor_per)
                            values(:doc,:nom,:ape,:tel,:dir,:cor)");
                            $insert->bindParam(':doc', $cedulac);
                            $insert->bindParam(':nom', $nombrec);
                            $insert->bindParam(':ape', $apellidoc);
                            $insert->bindParam(':tel', $telefonoc);
                            $insert->bindParam(':dir', $direccionc);
                            $insert->bindParam(':cor', $correoc);
                            if ($insert->execute()) {
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "cliente registrado", "success", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
                                $hola = 1;
                                
                            } else {
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurri車 un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';;
                                $hola = 2;
                            }
                        }
                        if (isset($_POST['Editar_Cliente'])) {
                            $ecedulac = $_POST['editcedula'];
                            $enombrec = $_POST['editnombre'];
                            $eapellidoc = $_POST['editapellido'];
                            $etelefonoc = $_POST['editelefono'];
                            $edireccionc = $_POST['editdireccion'];
                            $ecorreoc = $_POST['editcorreo'];
                            $update = $pdo->prepare("UPDATE personas SET doc_per=:product_code,nom_per=:product_name,
                            ape_per=:product_category, tel_per=:purchase_price, dir_per=:sell_price,
                            cor_per=:stock WHERE doc_per=$ecedulac");
                            $update->bindParam('product_code', $ecedulac);
                            $update->bindParam('product_name', $enombrec);
                            $update->bindParam('product_category', $eapellidoc);
                            $update->bindParam('purchase_price', $etelefonoc);
                            $update->bindParam('sell_price', $edireccionc);
                            $update->bindParam('stock', $ecorreoc);
                            if ($update->execute()) {
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Correcto", "cliente actualizado", "success", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
                                $hola = 1;
                               
                            } else {
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurri車 un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';;
                                $hola = 2;
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label for="">QUIEN REALIZO EL TRABAJO</label><br>
                            <input type="text" class="form-control" name="cedula" value="<?php echo Sacarnombreempleado(); ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">EQUIPO</label>
                            <input type="text" class="form-control" name="equipo">
                        </div>
                        <div class="form-group">
                            <label for="">VALOR</label>
                            <input type="number" class="form-control" name="valor" onkeypress="return valideKey(event);" >
                        </div>
                        <div class="form-group">
                            <label for="">REFERENCIA</label>
                            <input type="text" class="form-control" name="referencia">
                        </div>
                        <div class="form-group form-row">
                            <label for="">SERIAL</label>
                            <input type="text" class="form-control" name="serial">
                        </div>
                        <div class="form-group">
                            <label for="">MARCA</label>
                            <input type="text" class="form-control" name="marca">
                        </div>
                        <div class="form-group">
                            <label for="">FALLA DEL EQUIPO</label>
                            <textarea name="falla" id="descripcion" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">TRABAJO REALIZADO</label>
                            <textarea name="trabajo" id="trabajo" cols="30" rows="10" class="form-control"> </textarea>
                        </div>
                        <div class="form-group form-row">
                            <label for="">OBSERVACION</label>
                            <textarea name="observacion" id="observacion" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO MANTENIMIENTO</label>
                            <select class="form-control" name="estadoman" id="estadoman">
                                <?php
                                $select = $pdo->prepare("SELECT * FROM estados_equipo");
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row)

                                ?>
                                    <option value="<?php echo $row['des_est']; ?>">
                                        <?php echo $row["des_est"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#estadoman > option[value="RECIBIDO EN BODEGA"]').attr('selected', 'selected');
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="">ESTADO EQUIPO</label>
                            <textarea name="estado" id="description" cols="15" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">ACCESORIOS</label>
                            <textarea name="accesorios" id="description" cols="30" rows="10" class="form-control"></textarea>
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


                    <center>
                        <div class="box-footer">
                             <button type="submit" class="btn btn-primary" name="add_orden">AGREGAR</button>
                            <a href="orden.php" class="btn btn-warning">VOLVER</a>
                        </div>
                    </center>
                  
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off" >
                    <div class="box-body">
                        <center>
                            <div class="box-footer">
                                <a href="misc/nota.php?id='<?php echo $row->id; ?>'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i><span>IMPRIMIR</span></a>
                            </div>
                        </center>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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
    $(document).ready(function() {
        $("#BCliente").click(function() {
            var nombre = $(this).data('doc');
            

            $("#nombre").val(nombre);
           


        });
    });
</script>



<script type="text/javascript">
function valideKey(evt){
  
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { 
      return true;
    } else if(code>=48 && code<=57) { 
      return true;
    } else{ 
      return false;
    }
}
</script> 
<?php
include_once 'inc/footer_all.php';
?>