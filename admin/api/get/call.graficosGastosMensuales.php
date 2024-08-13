<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");





    $ano = $_GET["ano"];
    
    
    $respuesta = Database::graficoProcesarGastosMensuales( $ano );
    

    
    echo json_encode( $respuesta );
    
   
    




?>
