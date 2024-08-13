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
    $dia = $jsonarray["idDia"];
    $codEmpelado = $jsonarray["codEmpleado"];
    $hora1 = $jsonarray["hora1"];
    $hora2 = $jsonarray["hora2"];
    $puesto = $jsonarray["puesto"];

    $sql2 = "SELECT * FROM tbl_detallediaempleado DETEMD  WHERE DETEMD.id_Dia = '$dia' AND DETEMD.Cod_Empleado = '$codEmpelado' AND DETEMD.De_Status = '1'";
    $res = json_decode(Database::get_json_rows( $sql2 ), true);
    
    if (!empty($res)) {
     

      foreach ($res as $value) {
        $Tentrada = $value['H_Entrada'];
        $Tsalida = $value['H_Salida'];

        $valida = Validador($Tentrada, $Tsalida, $hora1, $hora2  );

        if (!$valida['err']) {
          $valid = array ( 'err'=>false, 'Mensaje'=>"No esta definida...");
        }else {
          $valid = array ( 'err'=>true, 'Mensaje'=>"Ya esta definida...");
        break;
        }
      }

      if (!$valid['err']) {
        $sql = "SELECT count(*) as cuantos from tbl_detallediaempleado EMPLE WHERE EMPLE.Cod_Empleado = '$codEmpelado' AND EMPLE.id_Dia = ' $dia' AND id_DPE = '$puesto'  ";
        $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
    
        $turno = $cuantos + 1;
    
                     $sql2 = "INSERT INTO tbl_detallediaempleado (id_Dia, De_Turno, Cod_Empleado, H_Entrada, H_Salida, id_DPE )
                    VALUES(
                        '$dia',
                        '$turno',
                        '$codEmpelado',
                        '$hora1',
                        '$hora2',
                        '$puesto'
                        )";
                        
          $hecho2 = Database::ejecutar_idu( $sql2 );
          if (is_numeric($hecho2) OR $hecho2 === true) {
    
            $respuesta = array ( 'err'=>false, 'Mensaje'=>"Guardado");
          }else {
              
            $respuesta = array ( 'err'=>true, 'Mensaje'=>"No se pudo guardar[err 2]");
          }
      }else {
        $respuesta = array ( 'err'=>true, 'Mensaje'=>"Ya esta definida...");
      }

  
        
    }else {
      // si esta vacio entonces solo dejame agregar
      $sql = "SELECT count(*) as cuantos from tbl_detallediaempleado EMPLE WHERE EMPLE.Cod_Empleado = '$codEmpelado' AND EMPLE.id_Dia = ' $dia' AND id_DPE = '$puesto'  ";
      $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
  
      $turno = $cuantos + 1;
  
                   $sql2 = "INSERT INTO tbl_detallediaempleado (id_Dia, De_Turno, Cod_Empleado, H_Entrada, H_Salida, id_DPE )
                  VALUES(
                      '$dia',
                      '$turno',
                      '$codEmpelado',
                      '$hora1',
                      '$hora2',
                      '$puesto'
                      )";
                      
        $hecho2 = Database::ejecutar_idu( $sql2 );
        if (is_numeric($hecho2) OR $hecho2 === true) {
  
          $respuesta = array ( 'err'=>false, 'Mensaje'=>"Guardado");
        }else {
            
          $respuesta = array ( 'err'=>true, 'Mensaje'=>"No se pudo guardar[err 1]");
        }
    }

 


}

echo json_encode($respuesta);



function Validador($from, $to, $key1, $key2){
  $from = strtotime($from) - 600;
  $to = strtotime($to) + 600;
  $key1 = strtotime($key1);
  $key2 = strtotime($key2);
  if ( $key1>=$key2) {
      $res = array ( 'err'=>true, 'Mensaje'=>"maldito perro la entrada tiene que ser menor que la salida");
  }else {
      if ($from > $key2) {
      
          $res = array ( 'err'=>false, 'Mensaje'=>"Todo va bien 1");
        }else {
           
            if ($to < $key1 ) {
              $res = array ( 'err'=>false, 'Mensaje'=>"Todo va bien 2");
            }else {
              $res = array ( 'err'=>true, 'Mensaje'=>"Ya tienes un turno definido");
            }
        } 
  }
  return $res;

}
?>