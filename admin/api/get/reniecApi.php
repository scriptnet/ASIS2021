<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");






    $dni = $_GET["number"];
    
    

    
    $rpta  = Database::scriptentReniec(  $dni );

    if ($rpta[0]['err']) {
        $respuesta = array ( 'err'=>false, 'Mensaje'=>'okay', 'reniec'=>$rpta);
    }else {
        $respuesta = array ( 'err'=>true, 'Mensaje'=>'No Existe');
    }
    
    echo json_encode( $respuesta );
    
   
    




?>
