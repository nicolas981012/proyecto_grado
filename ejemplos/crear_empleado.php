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

date_default_timezone_set('America/Mexico_City');
if (isset($_POST['add_product'])) {
  $code = $_POST['product_code'];
  $product = $_POST['product_name'];
  $category = $_POST['category'];
  $purchase = $_POST['purchase_price'];
  $sell = $_POST['sell_price'];
  $stock = $_POST['stock'];
  $min_stock = $_POST['min_stock'];
  $satuan = $_POST['satuan'];
  $desc = $_POST['description'];


  if (isset($_POST['product_code'])) {
    $select = $pdo->prepare("SELECT product_code FROM tbl_product WHERE product_code='$code'");
    $select->execute();

    if ($select->rowCount() > 0) {
      echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Empleado ya registrado", "warning", {
                    button: "Continuar",
                        });
                    });
                    </script>';
    } elseif (strlen($code) > 6 || strlen($code) < 6) {
      echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "El código debe tener 6 caracteres, como mínimo de acuerdo con las reglas", "warning", {
                    button: "Continuar",
                        });
                    });
                    </script>';
    } else {
      $img = $_FILES['product_img']['name'];
      $img_tmp = $_FILES['product_img']['tmp_name'];
      $img_size = $_FILES['product_img']['size'];
      $img_ext = explode('.', $img);
      $img_ext = strtolower(end($img_ext));

      $img_new = uniqid() . '.' . $img_ext;

      $store = "upload/" . $img_new;

      if ($img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png' || $img_ext == 'gif') {
        if ($img_size >= 1000000) {
          $error = '<script type="text/javascript">
                            jQuery(function validation(){
                            swal("Error", "El archivo debe tener 1 MB.", "error", {
                            button: "Continuar",
                                });
                            });
                            </script>';
          echo $error;
        } else {
          if (move_uploaded_file($img_tmp, $store)) {
            $product_img = $img_new;
            if (!isset($error)) {

              $insert = $pdo->prepare("INSERT INTO tbl_product(product_code,product_name,product_category,purchase_price,sell_price,stock,min_stock,product_satuan,description,img)
                            values(:product_code,:product_name,:product_category,:purchase_price,:sell_price,:stock,:min_stock,:satuan,:desc,:img)");

              $insert->bindParam(':product_code', $code);
              $insert->bindParam(':product_name', $product);
              $insert->bindParam(':product_category', $category);
              $insert->bindParam(':purchase_price', $purchase);
              $insert->bindParam(':sell_price', $sell);
              $insert->bindParam(':stock', $stock);
              $insert->bindParam(':min_stock', $min_stock);
              $insert->bindParam(':satuan', $satuan);
              $insert->bindParam(':desc', $desc);
              $insert->bindParam(':img', $product_img);

              if ($insert->execute()) {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Success", "Producto guardado con éxito", "success", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
              } else {
                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurrió un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
                ;
              }

            } else {
              echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "Ocurrió un error", "error", {
                                        button: "Continuar",
                                            });
                                        });
                                        </script>';
              ;
              ;
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
  }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      orden
    </h1>
    <hr>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ingrese una nueva orden</h3>
      </div>
      <form action="" method="POST" name="form_product" enctype="multipart/form-data" autocomplete="off">
        <div class="box-body">
          <div class="col-md-4">

            <div class="form-group">
              <label for="">Código de orden</label><br>
              <input type="text" class="form-control" name="code_orden">
            </div>
            <div class="form-group">
              <label for="">Cedula cliente</label><br>
              <input type="text" class="form-control" name="code_orden">
            </div>
            <div class="form-group">
              <label for="">quien realizo el trabajo</label>
              <select class="form-control" name="empleado" required>
                <?php
                $select = $pdo->prepare("SELECT * FROM usuario");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                  extract($row)
                    ?>
                  <option>
                    <?php echo $row['nom_usu']; ?>
                  </option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">equipo</label>
              <input type="text" class="form-control" name="equipo">
            </div>
            <div class="form-group">
              <label for="">Valor</label>
              <input type="text" class="form-control" name="valor">
            </div>
            <div class="form-group">
              <label for="">referencia</label>
              <input type="text" class="form-control" name="referencia">
            </div>
            <div class="form-group form-row">
              <label for="">serial</label>
              <input type="text" class="form-control" name="serial">
            </div>
            <div class="form-group">
              <label for="">marca</label>
              <input type="text" class="form-control" name="marca">
            </div>
            <div class="form-group">
              <label for="">falla del equipo</label>
              <textarea name="falla" id="description" cols="30" rows="10" class="form-control" required></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">trabajo realizado</label>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                required></textarea>
            </div>
            <div class="form-group form-row">
              <label for="">observacion</label>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                required></textarea>
            </div>
            <div class="form-group">
              <label for="">Categoría</label>
              <select class="form-control" name="empleado" required>
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
            <div class="form-group">
              <label for="">estado</label>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                required></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">accesorios</label>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                required></textarea>
            </div>
          </div>

          <center>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" name="add_product">Agregar orden</button>
              <a href="orden.php" class="btn btn-warning">Volver</a>
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

      reader.onload = function (e) {
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