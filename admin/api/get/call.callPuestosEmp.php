<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");





    $idCod = $_GET["cod"];

    
    
    $sql2 = "SELECT * FROM tbl_detalleposempleado DEPOSEMPL INNER JOIN tbl_posicion POS ON DEPOSEMPL.id_Posicion = POS.id_Posicion WHERE DEPOSEMPL.id_Empleado = '$idCod'";
        $res =  Database::get_json_rows( $sql2 );
        $EmpleadoPuesto = json_decode($res);


        if (!empty($EmpleadoPuesto)) {
            $respuesta = array('err' => false, 'data' => $EmpleadoPuesto  );
        }else {
            $respuesta = array('err' => true, 'mess' => 'No hay puestos.');
        }


    echo json_encode( $respuesta );
    
   
    




?>
