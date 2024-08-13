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

    $idReemplazo = $jsonarray;

    if (isset($idReemplazo)) {

      $sql = "UPDATE tbl_remplazos SET
      Rem_disabled = 1
      WHERE id_Rem=" .$idReemplazo;
      $hechoP = Database::ejecutar_idu( $sql );
      if (is_numeric($hechoP) OR $hechoP === true) {
        $respuesta = array ( 'err'=>false, 'Mensaje'=>'GUARDADO');
      }else {
        $respuesta = array ( 'err'=>true, 'Mensaje'=>'ERROR AL guardar');
      }

     
    }else {
      
      $respuesta = array ( 'err'=>true, 'Mensaje'=>'Error de variables');
    }


    echo json_encode($respuesta);

}
