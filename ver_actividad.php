<?php
include_once 'db/connect_db.php';
session_start();

if ($_SESSION['username'] == "") {
    header('location:index.php');
}

include_once 'inc/header_alumno.php';

if (isset($_GET['actividad_id'])) {
    $contenido_id = $_GET['actividad_id'];
    $query = $pdo->prepare("SELECT * FROM actividad WHERE idActividad = :contenido_id");
    $query->bindParam(':contenido_id', $contenido_id);
    $query->execute();
    if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="content-wrapper" style="background-image: url(./img/53.jpeg);background-size:cover">';
        echo '<section class="content container-fluid">';
        echo '<div class="box">';
        echo '<div class="box-header with-border">';
        echo '<h3 class="box-title">' . $row['titulo'] . '</h3>';
        echo '<p>' . $row['tipo_actividad'] . '</p>';
        echo '</div>';
        echo '<div class="box-body">';
        if (!empty($row['archivo'])) {
            echo '<a href="upload/' . $row['archivo'] . '" target="_blank">Descargar Archivo</a>';
        }
        echo '<p>' . $row['objetivo'] . '</p>';
        echo '<p>' . $row['Fecha_limite'] . '</p>';
        echo '</div>';
        echo '<a href="entregar_actividad.php?actividad_id=' . $row['idActividad'] . '">';
        echo "Contestar Actividad";
        echo '</a>';
        

        echo '</div>';
        echo '</section>';
        echo '</div>';
    } else {
        
        header('location:index.php');
    }
} else {
   
    header('location:index.php');
}
include_once 'inc/footer_all.php'; 
?>