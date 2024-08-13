<?php

session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};


$method = $_SERVER['REQUEST_METHOD'];
if ('POST' === $method) {

    require_once("../../config/class.Database.php");

  
    $postdata = file_get_contents("php://input");
    $jsonarray = json_decode($postdata, true);

    if ( isset( $jsonarray['id_Posicion'] )) { //atualizzar
        $sql = "UPDATE tbl_posicion
        SET
        P_Descripcion      = '". $jsonarray['P_Descripcion'] ."',
        P_Tarifa    = '". $jsonarray['P_Tarifa'] ."',
        PosCategoria    = '". $jsonarray['Categoria'] ."'
        WHERE id_Posicion=" . $jsonarray['id_Posicion'];

        $hecho = Database::ejecutar_idu( $sql );


        if (is_numeric($hecho) OR $hecho === true) {
            $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro actualizado');
          
          }else {
            $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
          }


    }else {
        $sql ="INSERT INTO tbl_posicion(P_Descripcion, P_Tarifa, PosCategoria)
        VALUES ('".$jsonarray['P_Descripcion']."',
                '".$jsonarray['P_Tarifa']."',
                '". $jsonarray['Categoria'] ."'
                )";

                $hecho = Database::ejecutar_idu( $sql );

                if (is_numeric($hecho) OR $hecho === true) {
                $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro Insertado');

                }else {
                $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
                }
    }
    echo json_encode($respuesta);
}


?>