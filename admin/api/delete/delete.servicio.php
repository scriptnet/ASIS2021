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

    $sql1 = "DELETE FROM tbl_servicios where id_Serv = $id";

    $hecho1 = Database::ejecutar_idu( $sql1 );
    

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