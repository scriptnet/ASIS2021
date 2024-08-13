<?php

$entrada = "08:00:00";
$salida = "12:00:00";

$Entrada1 = "09:00:00";
$Salida1 = "10:00:00";

$respuesta = Validador($Entrada1, $Salida1, $entrada, $salida  );
// $respuesta = json_decode($respuesta);
echo  $respuesta['Mensaje'];
function Validador($from, $to, $key1, $key2){

    $from = strtotime($from) - 600;
    $to = strtotime($to) + 1800;
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