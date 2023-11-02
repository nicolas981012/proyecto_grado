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
        echo '</div>';
        echo '<div class="box-body">';
        echo '<p>' . $row['contenido_texto'] . '</p>';
        if (!empty($row['archivo'])) {
            echo '<a href="upload/' . $row['archivo'] . '" target="_blank">Descargar Archivo</a>';
        }
        if (!empty($row['video'])) {
            echo '<div class="embed-responsive embed-responsive-16by9">';
            echo '<iframe class="embed-responsive-item" src="' . $row['video'] . '"></iframe>';
            echo '</div>';
        }
        echo '</div>';
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