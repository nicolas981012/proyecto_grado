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
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      GARANTIA
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="box box-success">
      <div class="box-body">
        <?php
        $id = $_GET["id"];

        $select = $pdo->prepare("SELECT * FROM garantia WHERE id_man_gar='$id'");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_OBJ)) { ?>

          <div class="col-md-4">
            <ul class="list-group">


              <p class="list-group-item list-group-item-success">DETALLE DE LA GARANTIA</p>

              <li class="list-group-item"> <b>CODIGO DE GARANTIA</b> :<span class="label badge pull-right">
                  <?php echo $row->id_gar; ?>
                </span></li>
              <li class="list-group-item"><b>ORDEN DE MANTENIMIENTO</b> :<span class="label label-info pull-right">
                  <?php echo $row->id_man_gar; ?>
                </span></li>
              <li class="list-group-item"><b>OBSERVACION</b> :<span class="label label-primary pull-right">
                  <?php echo $row->obs_gar; ?>
                </span></li>

            </ul>
          </div>
          <div class="col-md-4">
            <ul class="list-group">

              <p class="list-group-item list-group-item-success">DETALLE DE LA GARANTIA</p>

              <li class="list-group-item"><b>ESTADO</b> :<span class="label label-warning pull-right">
                  <?php echo $row->est_equ_gar; ?>
                </span></li>
              <li class="list-group-item"><b>FECHA</b> :<span class="label label-warning pull-right">
                  <?php echo $row->fec_gar; ?>
                </span></li>
            </ul>
          </div>
          <div class="col-md-3">
              <ul class="list-group">
                <center>
                  <p class="list-group-item list-group-item-success">IMAGEN GARANTIA</p>
                </center>
                <img src="upload/<?php echo $row->img_gar ?>" alt="Product Image" id="img_preview" class="img-responsive">
              </ul>
            
          </div>
        <?php
        }
        ?>
      </div>
      <center>
        <div class="box-footer">
          <a href="garantia.php" class="btn btn-warning">VOLVER</a>
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
<?php
include_once 'inc/footer_all.php';
?>