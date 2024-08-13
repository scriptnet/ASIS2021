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

    $idAd =  $jsonarray['CA_id'];
    $adelantoP = $jsonarray['CA_Precio'];
    $CA_Descripcion = $jsonarray['CA_Descripcion'];

    $sql = "UPDATE tbl_cashadelanto SET
    CA_Precio = '$adelantoP',
    CA_Descripcion = '$CA_Descripcion'
    WHERE CA_id=" .$idAd;
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



    echo json_encode($respuesta);
}


?>