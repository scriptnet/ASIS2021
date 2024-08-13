<?php



session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../../");
  exit;
};


$method = $_SERVER['REQUEST_METHOD'];
if ('PUT' === $method) {

    require_once("../../config/class.Database.php");

    $postdata = file_get_contents("php://input");
    $jsonarray = json_decode($postdata, true);

    $sql = "UPDATE tbl_detallediaempleado SET
    De_Status = '0'
    WHERE id_DDE=" .$jsonarray["id"];
    $hechoP = Database::ejecutar_idu( $sql );

    if (is_numeric($hechoP) OR $hechoP === true) {
        $respuesta = array(
            'err' => false,
            'mensaje' => 'Desactivado!',
        );
    }else {
        $respuesta = array(
            'err' => true,
            'mensaje' => 'ERROR[1]!',
        );
    }



    echo json_encode($respuesta);
}


?>