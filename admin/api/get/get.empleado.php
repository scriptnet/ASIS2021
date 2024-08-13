<?php

session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");

if( isset( $_GET["id"] ) ){

	$codDni = $_GET["id"];

	$sql = "SELECT E_Apellidos,E_DNI,E_Nombres FROM tbl_empleado  where E_DNI = $codDni";

	$resDni =  Database::get_arreglo( $sql );

	$sql = "SELECT * FROM tbl_detalleposempleado DEEMPPO INNER JOIN  tbl_posicion POS ON DEEMPPO.id_Posicion = POS.id_Posicion where id_Empleado = $codDni";
	$Puestos =  Database::get_arreglo( $sql );

	$resDni = $resDni[0];

	$respuesta = array('err' => false,
						'E_Apellidos'=> $resDni['E_Apellidos'],
						'E_DNI' => $resDni['E_DNI'],
						'E_Nombres'=> $resDni['E_Nombres'],
						'Puestos'=> $Puestos,
						
					   );
}else{
	$respuesta = array('err' => true );
}


echo json_encode( $respuesta, JSON_NUMERIC_CHECK );


?>
