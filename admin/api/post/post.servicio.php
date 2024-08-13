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

    $desc =  $jsonarray["Serv_Descripcion"];
    $monto =  $jsonarray["Serv_Monto"];
    $fecha =  $jsonarray["fecha"];



    if (isset($jsonarray["id_Serv"])) {
        $sql = "UPDATE tbl_servicios SET
        Serv_Descripcion = '$desc',
        Serv_Monto = '$monto',
        Ser_Fecha = '$fecha'
        WHERE id_Serv=" .$jsonarray["id_Serv"];
        $hechoP = Database::ejecutar_idu( $sql );

        if (is_numeric($hechoP) OR $hechoP === true) {
            $respuesta = array(
                'err' => false,
                'mensaje' => 'Actualizado!',
            );
        }else {
            $respuesta = array(
                'err' => true,
                'mensaje' => 'ERROR[1]!',
            );
        }
        
    }else {
        $sql ="INSERT INTO tbl_servicios(Serv_Descripcion, Serv_Monto, Ser_Fecha)
        VALUES ('$desc',
                '$monto',
                '$fecha')";

                $hecho = Database::ejecutar_idu( $sql );

                if (is_numeric($hecho) OR $hecho === true) {
                $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro Insertado');

                }else {
                $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
                }
    }

    // $sql = "UPDATE tbl_detallediaempleado SET
    // De_Status = '0'
    // WHERE id_DDE=" .$jsonarray["id"];
    // $hechoP = Database::ejecutar_idu( $sql );

    // if (is_numeric($hechoP) OR $hechoP === true) {
    //     $respuesta = array(
    //         'err' => false,
    //         'mensaje' => 'Desactivado!',
    //     );
    // }else {
    //     $respuesta = array(
    //         'err' => true,
    //         'mensaje' => 'ERROR[1]!',
    //     );
    // }



    echo json_encode($respuesta);
}


?>