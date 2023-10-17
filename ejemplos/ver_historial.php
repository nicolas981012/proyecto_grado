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
$id = $_GET["id"];
function sacarestado($estadoman)
{

    try {
        $pdo = new PDO('mysql:host=68.178.221.224;dbname=soporte_tecnico_oklahoma2','admin_soporte','M1005450340s@');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT obs_pre FROM observaciones_predis WHERE id_obs='$estadoman'");
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
function sacarnombrempleado($nombret)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    //$sede = $_GET['sede'];
    $select = $pdo->prepare("SELECT nom_usu,ape_usu FROM usuario WHERE doc_usu='$nombret'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->nom_usu . '' . '' . $row->ape_usu;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
   <section class="content-header">
    <center>
      <h1>
        HISTORIAL
      </h1>
    </center>
    <br>
    <ol class="breadcrumb">
      <li><a href="orden.php"><i class="fa fa-file-text-o"></i>LISTADO ORDEN</a></li>
      <li><a href="Observacion.php?id=<?php echo $id; ?>"><i class="fa fa-dashboard"></i>AÑADIR OBSERVACION</a></li>
      <li class="active">VER HISTORIAL</li>
    </ol>
    <br>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="box box-success">
      <div class="box-body">
        <?php
        $id = $_GET["id"];

        $select = $pdo->prepare("SELECT * FROM mantenimiento WHERE id_man='$id'");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_OBJ)) { ?>

          <div class="col-md-6">
            <ul class="list-group">


              <p class="list-group-item list-group-item-info">DATOS BASICOS</p>

              <li class="list-group-item"> <b>ID MANTENIMIENTO</b> :<span class="label badge pull-right">
                  <?php echo $row->id_man; ?>
                </span></li>
              <li class="list-group-item"><b>QUIEN REALIZA EL MANTENIMIENTO</b> :<span class="label label-info pull-right">
                  <?php echo sacarnombrempleado($row->id_usu); ?>
                </span></li>
              <li class="list-group-item"><b>FECHA</b> :<span class="label label-primary pull-right">
                  <?php echo $row->fec_man; ?>
                </span></li>
              <li class="list-group-item"><b>CLIENTE</b> :<span class="label label-primary pull-right">
                  <?php echo sacarnombre($row->doc_cli); ?>
                </span></li>

            </ul>
          </div>
          <div class="col-md-6">
            <ul class="list-group">

              <p class="list-group-item list-group-item-info">DETALLE DEL EQUIPO</p>

              <li class="list-group-item"><b>EQUIPO</b> :<span class="label label-warning pull-right">
                  <?php echo $row->equ_man; ?>
                </span></li>
              <li class="list-group-item"><b>REFERENCIA</b> :<span class="label label-warning pull-right">
                  <?php echo $row->ref_equ; ?>
                </span></li>
              <li class="list-group-item"><b>SERIAL</b> :<span class="label label-warning pull-right">
                  <?php echo $row->ser_equ; ?>
                </span></li>
              <li class="list-group-item"><b>FALLA</b> :<span class="label label-warning pull-right">
                  <?php echo $row->fal_equ; ?>
                </span></li>
            </ul>
          </div>
        <?php
        }
        ?>
      </div>


      <div class="box-body">
        <?php
        $id = $_GET["id"];

        $select = $pdo->prepare("SELECT * FROM garantia WHERE id_man_gar='$id'");
        $select->execute();
        $row2 = $select->rowCount();
        if ($row2 == 0) { ?>
          <div class="col-md-2">
            <ul class="list-group">
              <center>
                <p class="list-group-item list-group-item-danger">EL EQUIPO NO SE ENCUENTRA EN PROCESO DE GARANTIA</p>
              </center>
          </div>
          </ul>
          <?php
        } else {

          while ($row = $select->fetch(PDO::FETCH_OBJ)) { ?>

            <div class="col-md-9">
              <ul class="list-group">


                <p class="list-group-item list-group-item-info">DATOS BASICOS DE LA GARANTIA</p>

                <li class="list-group-item"> <b>ID GARANTIA</b> :<span class="label badge pull-right">
                    <?php echo $row->id_gar; ?>
                  </span></li>
                <li class="list-group-item"><b>OBSERVACION</b> :<span class="label label-info pull-right">
                    <?php echo $row->obs_gar; ?>
                  </span></li>
                <li class="list-group-item"><b>ESTADO</b> :<span class="label label-primary pull-right">
                    <?php echo $row->est_equ_gar; ?>
                  </span></li>
                <li class="list-group-item"><b>FECHA</b> :<span class="label label-primary pull-right">
                    <?php echo $row->fec_gar; ?>
                  </span></li>

              </ul>
            </div>
            <div class="col-md-2">
              <ul class="list-group">

                <ul class="list-group">
                  <center>
                    <p class="list-group-item list-group-item-info">IMAGEN EQUIPO</p>
                  </center>
                  <img src="upload/<?php echo $row->img_gar ?>" alt="Product Image" id="img_preview" class="img-responsive">
                </ul>
              </ul>
            </div>
          <?php
          }
          ?>
        <?php
        }
        ?>
      </div>

      <div class="box-header with-border">
        <p class="list-group-item list-group-item-info">HISTORIAL DEL EQUIPO</p>
      </div>
      <div class="box-body">
        <div style="overflow-x:auto;">
          <table class="table table-striped" id="myProduct">
            <thead>
              <tr>
                <th>ID</th>
                <th>FECHA</th>
                <th>ESTADO</th>
                <th>OBSERVACION</th>
                <th>OPCION</th>
              </tr>

            </thead>
            <tbody>
              <?php
              $id = $_GET["id"];
              $select = $pdo->prepare("SELECT * FROM observaciones WHERE id_man_obs = '$id' order by fec_obs desc");
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_OBJ)) {
              ?>
                <tr>
                  <td><?php echo $row->id_obs; ?></td>
                  <td><?php echo $row->fec_obs; ?></td>
                  <td class="success"><?php echo sacarestado($row->obs_pre); ?></td>
                  <td><?php echo $row->obs_obs; ?></td>
                  <td>

                    <a href="ver_orden.php?id=<?php echo $row->id_man; ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>

                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="box-footer">
          <?php if ($_SESSION['role'] == "111100") { ?>
            <a href="orden.php" class="btn btn-warning">VOLVER</a>
            
          <?php
          }
          ?>
          
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