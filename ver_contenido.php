<?php
include_once 'db/connect_db.php'; // Incluye el archivo de conexión a la base de datos
session_start();

if ($_SESSION['username'] == "") {
    header('location:index.php'); // Redirecciona si el usuario no está autenticado
}

include_once 'inc/header_alumno.php'; // Incluye el encabezado para estudiantes

if (isset($_GET['contenido_id'])) {
    $contenido_id = $_GET['contenido_id'];

    // Consulta para obtener el contenido seleccionado
    $query = $pdo->prepare("SELECT * FROM contenido WHERE idContenido = :contenido_id");
    $query->bindParam(':contenido_id', $contenido_id);
    $query->execute();

    if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        // Muestra el título y el contenido
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
        // Redirecciona si el contenido no se encuentra
        header('location:index.php');
    }
} else {
    // Redirecciona si no se proporciona el ID del contenido
    header('location:index.php');
}
include_once 'inc/footer_all.php'; // Incluye el pie de página
?>