<?php
include_once 'db/connect_db.php';
include_once 'misc/plugin.php';
session_start();
ob_start();
if ($_SESSION['username'] == "") {
    header('location:index.php');
} else {
    if ($_SESSION['role'] == "111100") {
        include_once 'inc/header_all.php';
    } else {
        include_once 'inc/header_all_operator.php';
    }
}
    $id = $_GET['id'];

    $delete = $pdo->prepare("UPDATE mantenimiento SET est_man= 8 WHERE id_man = '$id'");
    if ($delete->execute()) {
        echo '<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "  ORDEN CANCELADA", "info", {
            button: "Continuar",
                });
            });
            </script>';
            header('refresh:2;orden_completo.php');
    }
    
    ob_end_flush();

