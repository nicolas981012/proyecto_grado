<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
include_once 'db/connect_db.php';
session_start();
error_reporting(0);
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "ESTUDIANTE") {
        include_once 'inc/header_estudiante.php';
    } else {
        if ($_SESSION['role'] == "DOCENTE") {
            include_once 'inc/header_docente.php';
        } else {
            if ($_SESSION['role'] == "administrador") {
                include_once 'inc/header_admin.php';
            }
        }
    }
}
    $id = $_GET['id'];

    $delete = $pdo->prepare("UPDATE alumno SET estado= 0 WHERE id_Alumno = '$id'");
    if ($delete->execute()) {
        echo '<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", " Estudiante deshabilitado", "info", {
            button: "Continuar",
                });
            });
            </script>';
            header('refresh:2;Alumnos.php');
    }
    
    ob_end_flush();

