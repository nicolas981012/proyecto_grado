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
<html>

<head>
    <meta http-equiv="refresh" content="60">
</head>

</html>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="text-center" id="spinner">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
    </div>
    <style>
        #spinner {
            display: none;
        }
    </style>
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">LISTA DE CLIENTES</h3>
                <a href="agregar_persona.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-bars"></i>AGREGAR CLIENTE</a>
            </div>
            <div class="box-body">

                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead class="thead-dark">
                            <tr>
                                <th>CEDULA</th>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>TELEFONO</th>
                                <th>OPCION</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT doc_per,nom_per,ape_per,tel_per FROM personas");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->doc_per; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->nom_per; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->ape_per; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->tel_per; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($_SESSION['role'] == "111100") { ?>
                                            
                                            <?php
                                        }
                                        ?>
                                        <a href="ver_persona.php?id=<?php echo $row->doc_per; ?>"
                                            class="btn btn-default btn-sm"  title="VER CLIENTE"><i class="fa fa-eye"></i></a>
                                            <a href="editar_cliente.php?id=<?php echo $row->doc_per; ?>"
                                                class="btn btn-info btn-sm" title="EDITAR CLIENTE"><i class="fa fa-pencil"></i></a>
                                    </td>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(document).ready(function () {
        $('#myProduct').DataTable();
    });
</script>
<script>
    $.ajax({
        url: "cliente.php",
        method: "GET",
        beforeSend: function () {
            $("#spinner").show();
        },
        success: function (data) {

            // do something with the data
        },
        complete: function () {
            $("#spinner").hide();
        }
    });
</script>
<?php
include_once 'inc/footer_all.php';
?>