<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");

if( isset( $_GET["filter"] ) ){

    $filter = $_GET["filter"];

    $sql2 = "SELECT * FROM tbl_empleado EMPLE  WHERE (EMPLE.E_Nombres like '%".$filter."%' OR EMPLE.E_Apellidos  like '%".$filter."%' OR EMPLE.E_DNI like '%".$filter."%' OR EMPLE.E_Info_Contacto like '%".$filter."%' OR EMPLE.E_Genero like '%".$filter."%')";
    $res =  Database::get_json_rows( $sql2 );

    $dec = json_decode($res);
    if (!empty($dec)) {
        $respuesta = array('err' => false, 'EMPLEADOS' => $dec  );
    }else {
        $respuesta = array('err' => true, 'mess' => 'No hay data.' );
    }

    echo json_encode( $respuesta );
}