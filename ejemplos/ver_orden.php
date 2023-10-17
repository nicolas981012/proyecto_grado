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
function sacarestado($estadoman)
{

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT des_est FROM estados_equipo WHERE id_est='$estadoman'");
    $select->execute();
    $row = $select->fetchColumn();
    return $row;

}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      ORDEN
    </h1>
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
              <p class="list-group-item list-group-item-success">DETALLE DE LA ORDEN</p>
              <li class="list-group-item"> <b>CODIGO DE ORDEN</b> :<span class="label badge pull-right">
                  <?php echo $row->con_man; ?>
                </span></li>
              <li class="list-group-item"><b>EQUIPO</b> :<span class="label label-info pull-right">
                  <?php echo $row->equ_man; ?>
                </span></li>
              <li class="list-group-item"><b>SERIAL</b> :<span class="label label-primary pull-right">
                  <?php echo $row->ser_equ; ?>
                </span></li>
              <li class="list-group-item"><b>REFERENCIA</b> :<span class="label label-warning pull-right">
                  <?php echo $row->ref_equ; ?>
                </span></li>
              <li class="list-group-item"><b>MARCA</b> :<span class="label label-warning pull-right">
                  <?php echo $row->mar_equ; ?>
                </span></li>
              <li class="list-group-item"><b>CEDULA</b> :<span class="label label-success pull-right">
                  <?php echo $row->doc_cli; ?>
                </span></li>
              <li class="list-group-item"><b>NOMBRE</b> :<span class="label label-success pull-right">
                  <?php echo sacarnombre($row->doc_cli); ?>
                </span></li>
            </ul>
          </div>
          <div class="col-md-6">
            <ul class="list-group">
              <p class="list-group-item list-group-item-success">DETALLE DE LA ORDEN</p>
              <li class="list-group-item"><b>FALLA EQUIPO </b> :<span class="label label-default pull-right">
                  <?php echo $row->fal_equ; ?>
                </span></li>
              <li class="list-group-item"><b>ESTADO EQUIPO</b> :<span class="label label-default pull-right">
                  <?php echo $row->est_equ; ?>
                </span></li>
              <li class="list-group-item"><b>EMPLEADO</b> :<span class="label label-default pull-right">
                  <?php echo $_SESSION['username']; ?>
                </span></li>
              <li class="list-group-item"><b>OBSERVACIONES</b> :<span class="label label-default pull-right">
                  <?php echo $row->obs_man; ?>
                </span></li>
              <li class="list-group-item"><b>TRABAJO REALIZADO</b> :<span class="label label-default pull-right">
                  <?php echo $row->tra_equ; ?>
                </span></li>
              <li class="list-group-item"><b>ESTADO MANTENIMIENTO</b> :<span class="label label-default pull-right">
                  <?php echo sacarestado($row->est_man); ?>
                </span></li>
            </ul>
          </div>
          <center>
            <div class="box-footer">
              <a href="agregar_orden.php" class="btn btn-warning">VOLVER</a>
              <a href="misc/nota.php?id=<?php echo $row->id_man; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i><span>IMPRIMIR</span></a>
            </div>
          </center>
        <?php
        }
        ?>
      </div>

    </div>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'inc/footer_all.php';
?>