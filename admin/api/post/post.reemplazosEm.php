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

    $reemplazo =  $jsonarray["from"]; //quien va a reemplazar desde
    $reemplazado =  $jsonarray["to"]; //el reemplazado hasta
    $Horario =  $jsonarray["HorarioPuesto"]; //puesto horario del hasta
    $tarifa =  $jsonarray["Posicion"]; //puesto horario del hasta
    
    // VERIFICAR SI EL REEMPLAZO YA EXISTE
    $sql = "SELECT count(*) as existe FROM tbl_remplazos WHERE Rem_from = '$reemplazo' AND  Rem_to = '$reemplazado' AND puesto_TO = '$Horario'";
    $existe = Database::get_valor_query( $sql, 'existe' );
    if( $existe == 1 ){
      $respuesta = array ( 'err'=>true, 'Mensaje'=>'Este reemplazo ya existe.');
    }else {
      $sql ="INSERT INTO tbl_remplazos(Rem_from, Rem_to, puesto_TO, puesto_From)
      VALUES ('$reemplazo',
              '$reemplazado',
              '$Horario',
              '$tarifa'
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
