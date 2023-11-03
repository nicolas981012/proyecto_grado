<?php
include_once 'db/connect_db.php'; 
session_start();

if ($_SESSION['username'] == "") {
    header('location:index.php'); 
}

include_once 'inc/header_alumno.php'; 

if (isset($_GET['clase_id'])) {
    $clase_id = $_GET['clase_id'];
    $query = $pdo->prepare("SELECT * FROM actividad WHERE Clase_idClase = :clase_id");
    $query->bindParam(':clase_id', $clase_id);
    $query->execute();
} else {
    header('location:index.php');
}
?>

<!-- Aquí puedes agregar el código HTML y estilos para mostrar la lista de contenidos -->
<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-repeat:no-repeat;background-size:cover;" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Actividades de la Clase</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Actividades</h3>
            </div>
            <div class="box-body">
                <ul>
                    <?php
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        // Aquí se muestra una lista de los contenidos disponibles
                        echo '<li>';
                        echo '<a href="ver_actividad.php?actividad_id=' . $row['idActividad'] . '">';
                        echo $row['titulo'];
                        echo '</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

<?php
include_once 'inc/footer_all.php'; // Incluye el pie de página
?>