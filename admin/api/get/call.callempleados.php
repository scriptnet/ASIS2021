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
    
    
    $respuesta = Database::get_todo_paginado_Empleados( 'tbl_empleado', $pag, $buscar, $por_pagina );
    
    // llamamos sus dias
    // $cod = $respuesta["tbl_empleado"];
    // $dias = Array();
    // $variable = "";
    // foreach ($cod as $row) {
    //     $codigo = $row["E_DNI"];
    //     // $variable.="$codigo ";
    //     $sql = "SELECT Cod_Empleado, S_Nombre FROM tbl_detallediaempleado DETADIA INNER JOIN tbl_dia DIA ON DETADIA.id_Dia = DIA.id_Dia WHERE DETADIA.Cod_Empleado = '$codigo'";
    //     $dia = Database::get_json_rows( $sql );

    //      array_push($dias, $dia);
    // }
    
    echo json_encode( $respuesta );
    
   
    




?>
