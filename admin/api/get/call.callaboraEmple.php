<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};
// Incluir el archivo de base de datos
include_once("../../config/class.Database.php");

if( isset( $_GET["dia"] ) ){

	$dia = $_GET["dia"];
    $sql = "SELECT S_Cod FROM tbl_dia where S_Nombre = '$dia'";
    $data_dia = Database::get_valor_query( $sql, 'S_Cod' );
    if ($data_dia) {

        $sql2 = "SELECT EMPL.E_Nombres, EMPL.E_Apellidos, DETEMD.H_Entrada, DETEMD.H_Salida, EMPL.E_DNI FROM tbl_detallediaempleado DETEMD INNER JOIN tbl_empleado EMPL ON DETEMD.Cod_Empleado = EMPL.E_DNI WHERE DETEMD.id_Dia = '$data_dia' AND DETEMD.De_Status = '1'";
        $res =  Database::get_json_rows( $sql2 );

        $sql3 = "SELECT EMPL.E_Nombres, EMPL.E_Apellidos FROM tbl_detallediaempleado DETEMD INNER JOIN tbl_empleado EMPL ON DETEMD.Cod_Empleado = EMPL.E_DNI WHERE DETEMD.id_Dia = '$data_dia' AND DETEMD.De_Status = '1' GROUP BY DETEMD.Cod_Empleado ";
        $res2 =  Database::get_json_rows( $sql3 );

        $sql3 = "SELECT count(*) as cuantos from tbl_empleado";

        $cuantos       = Database::get_valor_query( $sql3, 'cuantos' );


        $dec = json_decode($res);
        $EmpleadosLaboran = json_decode($res2);
        if (!empty($dec)) {
            $respuesta = array('err' => false, 'data' => $dec, 'EmpleadosLaboran' => $EmpleadosLaboran, 'CountosEmpleados' =>  $cuantos  );
        }else {
            $respuesta = array('err' => true, 'mess' => 'Hoy no trabaja nadie.', 'EmpleadosLaboran' => [], 'CountosEmpleados' =>  $cuantos );
        }
        
    }else {
        $respuesta = array('err' => true, 'mess' => 'Comunicate con el admin la base de datos fue modificado' );
    }


	
	// $resDni = $resDni[0];

	// $respuesta = array('err' => false,
	// 					'resDni'=> $resDni
	// 				   );
}else{
	$respuesta = array('err' => true );
}


echo json_encode( $respuesta );


?>
