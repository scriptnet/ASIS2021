<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");





    $idempleado = $_GET["cod"];
    $dia = $_GET["dia"];

    
    
    $respuesta = Database::get_todo_paginado_Horarios( 'tbl_detallediaempleado', $idempleado, $dia );

    
    echo json_encode( $respuesta );
    
   
    




?>
