<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");





    $buscar = $_GET["filter"];
    $por_pagina = $_GET["limit"];
    $pag = $_GET["page"];
    $inicio = $_GET["inicio"];
    $fin = $_GET["fin"];
    
    
    $respuesta = Database::get_todo_paginado_nominaSueldos( 'tbl_empleado', $pag, $buscar, $por_pagina, $inicio, $fin );
    
    
    echo json_encode( $respuesta );
    
   
    




?>
