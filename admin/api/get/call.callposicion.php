<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// importamos

  require_once("../../config/class.Database.php");


  $respuesta = Database::get_todo_paginadoPosicion( 'tbl_posicion' );

echo json_encode( $respuesta );
?>