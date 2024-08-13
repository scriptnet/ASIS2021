<?php

// session_start();
// $user = $_SESSION['user'];

// if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
//   header("location: ../../");
//   exit;
// };

 $respuesta = array(
            'err' => true,
            'mensaje' => 'no hayd data.',
        );
		
		
$method = $_SERVER['REQUEST_METHOD'];
if ('POST' === $method) {

    require_once("../../admin/config/class.Database.php");
    require_once("ReemplazosValidador.php");
    
    $postdata = file_get_contents("php://input");
    $jsonarray = json_decode($postdata, true);
    
    $codDni =  $jsonarray["codDni"];
    $dia =  $jsonarray["dia"];
    $horaMarcada =  $jsonarray["horaMarcada"];
    $fechaMarcada =  $jsonarray["fechaNow"];
    
    $idSelect = $jsonarray["idSelect"];
    $puestoId = $jsonarray["puestoId"];

    // verificamos si el dni es valido

    $sql = "SELECT count(*) as existe FROM tbl_empleado where E_DNI = '$codDni'";
    $existe = Database::get_valor_query( $sql, 'existe' );

    if( $existe == 1 ){

        $sql = "SELECT S_Cod FROM tbl_dia where S_Nombre = '$dia'";
        $data_dia = Database::get_valor_query( $sql, 'S_Cod' );

        if ($data_dia) {


       
           
            if (false) {
               


            }else {
                    // si no es  un remplazo
                $sql = "SELECT id_DDE, De_Turno, H_Entrada, H_Salida, id_DPE FROM tbl_detallediaempleado where id_Dia = '$data_dia' AND Cod_Empleado = '$codDni' AND De_Status = 1";
                $data_horario= Database::get_arreglo( $sql );
    
                if (!empty($data_horario)) {
                    foreach ($data_horario as $row) {
                        $turno = $row["De_Turno"];
                        $entrada = $row["H_Entrada"];
                        $salida = $row["H_Salida"];
                        $TuHorario = $row["id_DDE"];
                        $posicionEm = $row["id_DPE"];
                        $Ass_codigo = $codDni.$posicionEm;
         
                         //convertir a hora unix
                         $entradaUNIX=strtotime($entrada);
                         $salidaUNIX=strtotime($salida);
                         $marcadaUNIX=strtotime($horaMarcada);
                        //  10 min antes
                         $entradaUNIX10min =  $entradaUNIX - 600;
                         if ( $marcadaUNIX >= $entradaUNIX10min AND  $marcadaUNIX < $entradaUNIX ) {
                            $horaMarcada = $entrada;
                            $marcadaUNIX=strtotime($entrada);
                            $verifica = true; //controla para que no marque como entrada, cuando pasa su hora de salida
                         }else {
                            $verifica = true;
                         }

                      //30 min despues
                      $salidaUNIX30MIN = $salidaUNIX + 600;
                      if ($marcadaUNIX <= $salidaUNIX30MIN AND $marcadaUNIX > $salidaUNIX) {
                          $horaMarcada = $salida;
                          $marcadaUNIX=strtotime($salida);
                          $verifica = false;
                      }

                         if ($marcadaUNIX >= $entradaUNIX AND $marcadaUNIX <= $salidaUNIX  ) {
                             // CAPTURAMOS NO ES NECESARIO PERO ALV
                            
                             $resultTurno =  $turno;
                             $resultEntrada =  $entrada;
                             $resultSalida =  $salida;
         
         
         
                             $sql = "SELECT count(*) as existe FROM tbl_asistencia WHERE A_Turno = '$turno' AND Fecha_Marcada = '$fechaMarcada' AND id_Dia = '$data_dia' AND id_Empleado = '$codDni' AND Ass_codigo = '$Ass_codigo' ";
                             $existeAS = Database::get_valor_query( $sql, 'existe' );
         
                             if( $existeAS == 1 ){
    
                                $sqlEntrada = "SELECT A_Entrada_Marcada FROM tbl_asistencia WHERE A_Turno = '$turno' AND Fecha_Marcada = '$fechaMarcada' AND id_Dia = '$data_dia' AND id_Empleado = '$codDni' AND Ass_codigo = '$Ass_codigo'";
                                $dataEntrada = Database::get_valor_query( $sqlEntrada, 'A_Entrada_Marcada' );
    
    
                                $fecha1 = new DateTime($dataEntrada );//fecha inicial
                                $fecha2 = new DateTime($horaMarcada);//fecha de cierre
    
                                $intervalo = $fecha1->diff($fecha2);
                                $h_hombre = $intervalo->format('%H:%i:%s');
    
                                 $sql = "UPDATE tbl_asistencia SET
                                         A_Salida_Marcada = '$horaMarcada',
                                         H_Hombre =  '$h_hombre'
                                         WHERE A_Turno = '$turno' AND Fecha_Marcada = '$fechaMarcada' AND id_Dia = '$data_dia' AND id_Empleado = '$codDni' AND Ass_codigo = '$Ass_codigo'";
                                         $hecho2 = Database::ejecutar_idu( $sql );
                                

                                         if (is_numeric($hecho2) OR $hecho2 === true) {
                                            $respuesta = array(
                                                'err' => false,
                                                'mensaje' => 'SALIDA_ACTUALIZADA.',
                                            );

                                            
                                         }else {
                                            $respuesta = array(
                                                'err' => true,
                                                'mensaje' => 'HAY UN ERROR EN EL SISTEMA :( [3]',
                                            );
                                         }


                                      
         
         
                             }else{
                                
                                if ($verifica) {
                                    // sacamos su tardanza
                                    $fecha1 = new DateTime($resultEntrada );//fecha inicial
                                    $fecha2 = new DateTime($horaMarcada);//fecha de cierre
        
                                    $intervalo = $fecha1->diff($fecha2);
                                    $TARDANZA = $intervalo->format('%H:%i:%s');
                                    
                                    // sacamos su horas hombre automatico
                                    $HoraEntrada = new DateTime($horaMarcada );//fecha inicial
                                    $SalidaOficial = new DateTime($salida);//fecha de cierre
        
                                    $intervaloH = $HoraEntrada->diff($SalidaOficial);
                                    $h_hombre = $intervaloH->format('%H:%i:%s');
        
                                     $sql2 = "INSERT INTO tbl_asistencia (A_Turno, Fecha_Marcada, id_Dia, id_Empleado, A_Entrada_Marcada, A_Salida_Marcada, A_TARDANZA, H_Hombre,id_Horario, id_Posicion,  Ass_codigo)
                                                 VALUES(
                                                     '$turno',
                                                     '$fechaMarcada',
                                                     '$data_dia',
                                                     '$codDni',
                                                     '$horaMarcada',
                                                     '$salida',
                                                     '$TARDANZA',
                                                     '$h_hombre',
                                                     '$TuHorario',
                                                     '$posicionEm',
                                                     '$Ass_codigo'
                                                     )";
                                                     
                                     $hecho2 = Database::ejecutar_idu( $sql2 );
             
                                                    
                                     if (is_numeric($hecho2) OR $hecho2 === true) {
                                        $respuesta = array(
                                            'err' => false,
                                            'mensaje' => 'SU ENTRADA FUE REGISTRADA.',
                                        );
                                     }else {
                                        $respuesta = array(
                                            'err' => true,
                                            'mensaje' => 'HAY UN ERROR EN EL SISTEMA :( [4]',
                                        );
                                     }
                                }else {
                                    $respuesta = array(
                                        'err' => false,
                                        'mensaje' => 'ESTAS FUERA DE TU HORARIO [2].',
                                    );
                                }
                             }
         
         
                           
                             break;
                         }else {
    
                            //  $respuesta = array(
                            //      'err' => true,
                            //      'mensaje' => 'ESTAS FUERA DE TU HORARIO.[1]',
                            //  );


                            $mensajeStado = "ESTAS FUERA DE TU HORARIO";
                                    //====================================================
                                    //      VERIFICAMOS SI REMPLAZA A OTRO EMPLEADO
                                    //====================================================
                                    if (!isset($idSelect)) {
                                        $veriRem =  ReemplazosV::validarReemplazo1a1( $codDni, $data_dia, $horaMarcada, $fechaMarcada, $mensajeStado);
                                    }else {
                                        $veriRem =  ReemplazosV::validarReemplazo1aMuchos( $codDni, $data_dia, $horaMarcada, $fechaMarcada, $idSelect, $puestoId);
                                    }
                                  


                                    
                             $respuesta = array(
                                'err' => true,
                                'mensaje' => $veriRem["mensaje"],
                                'typeModal' => $veriRem["typeModal"],
                                'dataRemp' => array(
                                    'CodEmpl' =>  $codDni,
                                    'horaMarcada' =>   $horaMarcada,
                                    'FechaMarcada' => $fechaMarcada,
                                    'diaM' => $dia
                                )
                            );


                                    //====================================================
                                    //     FIN DE SCRIPT
                                    //====================================================



                         }
         
                     }
                }else {
    
    
                                    $mensajeStado = "HOY NO TRABAJAS";
                                    //====================================================
                                    //      VERIFICAMOS SI REMPLAZA A OTRO EMPLEADO
                                    //====================================================
                                    if (!isset($idSelect)) {
                                        $veriRem =  ReemplazosV::validarReemplazo1a1( $codDni, $data_dia, $horaMarcada, $fechaMarcada, $mensajeStado);
                                    }else {
                                        $veriRem =  ReemplazosV::validarReemplazo1aMuchos( $codDni, $data_dia, $horaMarcada, $fechaMarcada, $idSelect, $puestoId);
                                    }
                                  


                                    
                                    $respuesta = array(
                                        'err' => true,
                                        'mensaje' => $veriRem["mensaje"],
                                        'typeModal' => $veriRem["typeModal"],
                                        'dataRemp' => array(
                                            'CodEmpl' =>  $codDni,
                                            'horaMarcada' =>   $horaMarcada,
                                            'FechaMarcada' => $fechaMarcada,
                                            'diaM' => $dia
                                        )
                                    );
                } 
            }


        }else {
            $respuesta = array(
                'err' => true,
                'mensaje' => 'ERROR[1].',
            );
        }

    }else {
        $respuesta = array(
            'err' => true,
            'mensaje' => 'EL DNI NO ESTA REGISTRADO.',
        );
    }

}

echo json_encode($respuesta);
?>