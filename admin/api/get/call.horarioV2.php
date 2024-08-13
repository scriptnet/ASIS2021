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
    $puesto = $_GET["puesto"];
    // $dia = $_GET["dia"];

    
    
    $respuesta = Database::get_todo_paginado_HorariosV2( 'tbl_detallediaempleado', $idempleado, $puesto );

    
    echo json_encode( $respuesta );
    
   
    




?>
