<?php



// session_start();
// $user = $_SESSION['user'];

// if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
//   header("location: ../../");
//   exit;
// };


$method = $_SERVER['REQUEST_METHOD'];
if ('DELETE' === $method) {

    require_once("../../config/class.Database.php");

    $id = $_GET["id"];

    $sql1 = "DELETE FROM tbl_cashadelanto where CA_id = $id";

    $hecho1 = Database::ejecutar_idu( $sql1 );
    // $idAd =  $jsonarray['CA_id'];
    // $adelantoP = $jsonarray['CA_Precio'];
    // $CA_Descripcion = $jsonarray['CA_Descripcion'];

    // $sql = "UPDATE tbl_cashadelanto SET
    // CA_Precio = '$adelantoP',
    // CA_Descripcion = '$CA_Descripcion'
    // WHERE CA_id=" .$idAd;
    // $hechoP = Database::ejecutar_idu( $sql );

    if (is_numeric($hecho1) OR $hecho1 === true) {
        $respuesta = array(
            'err' => false,
            'mensaje' => 'Eliminado!',
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