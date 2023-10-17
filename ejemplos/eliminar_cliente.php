<?php
 include_once'db/connect_db.php';
 include_once'misc/plugin.php';
 session_start();
 error_reporting(0);
 if($_SESSION['role']=="111100"){

    $id = $_GET['id'];

    $delete = $pdo->prepare("DELETE * FROM personas WHERE doc_per= $id");

    if($delete->execute()){

        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "El cliente ha sido eliminado satisfactoriamente", "info", {
            button: "Continuar",
                });
            });
            </script>';
        }else{

            echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "No se puede eliminar el cliente,debe primero eliminar ordenes y datos de este ", "info", {
            button: "Continuar",
                });
            });
            </script>';


        }
        header('refresh:2;cliente.php');
    
  }else{
      include_once'inc/header_all_operator.php';
  }

