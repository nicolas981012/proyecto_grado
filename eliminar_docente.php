<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';

session_start();
ob_start();
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "alumno") {
        include_once 'inc/header_alumno.php';
    } else {
        if ($_SESSION['role'] == "docente") {
            include_once 'inc/header_docente.php';
        } else {
            if ($_SESSION['role'] == "administrador") {
                include_once 'inc/header_admin.php';
            }
        }
    }
}
    $id = $_GET['id'];
    $delete1 = $pdo->prepare("SELECT * FROM clase WHERE Docente_idDocente= $id");
    if ($delete1->execute()) {
        $delete = $pdo->prepare("DELETE FROM alumno WHERE id_Alumno= $id");
        if ($delete->execute()) {
            echo '<script type="text/javascript">
                jQuery(function validation(){
                swal("Info", " Estudiante eliminado", "info", {
                button: "Continuar",
                    });
                });
                </script>';
                header('refresh:1;Alumnos.php');
        }
    }else{
    $delete = $pdo->prepare("DELETE FROM alumno WHERE id_Alumno= $id");
    if ($delete->execute()) {
        echo '<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", " Estudiante eliminado", "info", {
            button: "Continuar",
                });
            });
            </script>';
            header('refresh:1;Alumnos.php');
    }
}
    
    ob_end_flush();