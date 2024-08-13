<?php

class ReemplazosV{
    public static function validarReemplazo1a1($codDni, $data_dia, $horaMarcada, $fechaMarcada, $mesajesS){

        $sqlRem = "SELECT count(*) as existe FROM tbl_remplazos where Rem_from = '$codDni' AND Rem_disabled = 0";
        $existeRem = Database::get_valor_query( $sqlRem, 'existe' );

        if( $existeRem == 1 ){
         
            $sqlRem = "SELECT * FROM tbl_remplazos WHERE Rem_from = '$codDni' AND Rem_disabled = 0";
            $existeRem = Database::get_row( $sqlRem );
            // ORDENAMOS VARIABLES
            $reemplazo = $codDni;
            $reemplazado = $existeRem['Rem_to'];
            $horarioPuesto = $existeRem['puesto_TO'];
            $idPuestoRemplazo = $existeRem['puesto_From'];
            $id_Rem = $existeRem['id_Rem'];

            $sqlRem2 = "SELECT id_DDE, De_Turno, H_Entrada, H_Salida, id_DPE FROM tbl_detallediaempleado where id_Dia = '$data_dia' AND Cod_Empleado = '$reemplazado' AND De_Status = 1 AND id_DPE = '$horarioPuesto'";
            $data_horarioRem= Database::get_arreglo( $sqlRem2 );

            if (!empty($data_horarioRem)) {
                foreach ($data_horarioRem as $row) {
                    $turno = $row["De_Turno"];
                    $entrada = $row["H_Entrada"];
                    $salida = $row["H_Salida"];
                    $TuHorario = $row["id_DDE"];
                    $posicionEm = $row["id_DPE"];
                    $Ass_codigo = $codDni.$idPuestoRemplazo;

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
                        $resultTurno =  $turno;
                        $resultEntrada =  $entrada;
                        $resultSalida =  $salida;

                        
                        $sql = "SELECT count(*) as existe FROM tbl_asistencia WHERE A_Turno = '$turno' AND Fecha_Marcada = '$fechaMarcada' AND id_Dia = '$data_dia' AND id_Empleado = '$codDni' AND Ass_codigo = '$Ass_codigo' AND IsReemplazo = 1 ";
                        $existeAS = Database::get_valor_query( $sql, 'existe' );
                        if( $existeAS == 1 ){
                           

                            $respuesta = array(
                                'mensaje' => "YA FUE REGISTRADO [REEMPLAZO]",
                                'typeModal' => 1
                            );
                        }else {
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

                                 $sql2 = "INSERT INTO tbl_asistencia (A_Turno, Fecha_Marcada, id_Dia, id_Empleado, A_Entrada_Marcada, A_Salida_Marcada, A_TARDANZA, H_Hombre,id_Horario, id_Posicion,  Ass_codigo, IsReemplazo, id_reemplazo)
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
                                                     '$idPuestoRemplazo',
                                                     '$Ass_codigo',
                                                     '1',
                                                     '$id_Rem'
                                                     )";
                                                     
                                     $hecho2 = Database::ejecutar_idu( $sql2 );

                                     if (is_numeric($hecho2) OR $hecho2 === true) {
                                      

                                        $respuesta = array(
                                            'mensaje' => "SU ENTRADA FUE REGISTRADA [REEMPLAZO]",
                                            'typeModal' => 1
                                        );
                                     }else {
                                    

                                        $respuesta = array(
                                            'mensaje' => "ERROR EN EL SISTEMA[01] [REEMPLAZO]",
                                            'typeModal' => 1
                                        );
                                     }
                                     
                                     

                            }else {
                              
                                $respuesta = array(
                                    'mensaje' => "ESTAS FUERA DE SU HORARIO [REEMPLAZO]",
                                    'typeModal' => 1
                                );
                            }
                           
                        }

                    }else {
                        
                        $respuesta = array(
                            'mensaje' => "ESTAS FUERA DE SU HORARIO. [REEMPLAZO]",
                            'typeModal' => 1
                        );
                    }

                }

            }else {
         
                $respuesta = array(
                    'mensaje' => $mesajesS,
                    'typeModal' => 1
                );
            }
        }else {
            // $respuesta = "ESTAS FUERA DE TU HORARIO[1].";
            $respuesta = array(
                'mensaje' => $mesajesS,
                'typeModal' => 1
            );


            if ($existeRem >= 2) {
                $respuesta = array(
                    'mensaje' =>"VER EMPLEADOS A REEMPLAZAR",
                    'typeModal' => 2
                );

            }

          
        }

        return $respuesta;
      
    }



    public static function validarReemplazo1aMuchos($codDni, $data_dia, $horaMarcada, $fechaMarcada, $idSelect, $puestoId){

        $sqlRem = "SELECT count(*) as existe FROM tbl_remplazos where Rem_from = '$codDni' AND Rem_to = '$idSelect' AND puesto_TO = '$puestoId' AND Rem_disabled = 0 ";
        $existeRem = Database::get_valor_query( $sqlRem, 'existe' );

        if( $existeRem == 1 ){
         
            $sqlRem = "SELECT * FROM tbl_remplazos WHERE Rem_from = '$codDni'  AND Rem_to = '$idSelect' AND puesto_TO = '$puestoId' AND Rem_disabled = 0 ";
            $existeRem = Database::get_row( $sqlRem );
            // ORDENAMOS VARIABLES
            $reemplazo = $codDni;
            $reemplazado = $existeRem['Rem_to'];
            $horarioPuesto = $existeRem['puesto_TO'];
            $idPuestoRemplazo = $existeRem['puesto_From'];
            $id_Rem = $existeRem['id_Rem'];

            $sqlRem2 = "SELECT id_DDE, De_Turno, H_Entrada, H_Salida, id_DPE FROM tbl_detallediaempleado where id_Dia = '$data_dia' AND Cod_Empleado = '$reemplazado' AND De_Status = 1 AND id_DPE = '$horarioPuesto'";
            $data_horarioRem= Database::get_arreglo( $sqlRem2 );

            if (!empty($data_horarioRem)) {
                foreach ($data_horarioRem as $row) {
                    $turno = $row["De_Turno"];
                    $entrada = $row["H_Entrada"];
                    $salida = $row["H_Salida"];
                    $TuHorario = $row["id_DDE"];
                    $posicionEm = $row["id_DPE"];
                    $Ass_codigo = $codDni.$idPuestoRemplazo;

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
                        $resultTurno =  $turno;
                        $resultEntrada =  $entrada;
                        $resultSalida =  $salida;

                        
                        $sql = "SELECT count(*) as existe FROM tbl_asistencia WHERE A_Turno = '$turno' AND Fecha_Marcada = '$fechaMarcada' AND id_Dia = '$data_dia' AND id_Empleado = '$codDni' AND Ass_codigo = '$Ass_codigo' AND IsReemplazo = 1";
                        $existeAS = Database::get_valor_query( $sql, 'existe' );
                        if( $existeAS == 1 ){
                            // $respuesta = "YA FUE REGISTRADO [REEMPLAZO]";
                            $respuesta = array(
                                'mensaje' => "YA FUE REGISTRADO [REEMPLAZO]",
                                'typeModal' => 1
                            );
                        }else {
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

                                 $sql2 = "INSERT INTO tbl_asistencia (A_Turno, Fecha_Marcada, id_Dia, id_Empleado, A_Entrada_Marcada, A_Salida_Marcada, A_TARDANZA, H_Hombre,id_Horario, id_Posicion,  Ass_codigo, IsReemplazo, id_reemplazo)
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
                                                     '$idPuestoRemplazo',
                                                     '$Ass_codigo',
                                                     '1',
                                                     ' $id_Rem'
                                                     )";
                                                     
                                     $hecho2 = Database::ejecutar_idu( $sql2 );

                                     if (is_numeric($hecho2) OR $hecho2 === true) {
                                      

                                        $respuesta = array(
                                            'mensaje' => "SU ENTRADA FUE REGISTRADA [REEMPLAZO]",
                                            'typeModal' => 1
                                        );
                                     }else {
                                    

                                        $respuesta = array(
                                            'mensaje' => "ERROR EN EL SISTEMA[01] [REEMPLAZO]",
                                            'typeModal' => 1
                                        );
                                     }
                                     
                                     

                            }else {
                              
                                $respuesta = array(
                                    'mensaje' => "ESTAS FUERA DE SU HORARIO[2][REEMPLAZO]",
                                    'typeModal' => 1
                                );
                            }
                           
                        }

                    }else {
                        
                        $respuesta = array(
                            'mensaje' => "ESTAS FUERA DE SU HORARIO[REEMPLAZO]",
                            'typeModal' => 1
                        );
                    }

                }

            }else {
         
                $respuesta = array(
                    'mensaje' => "HOY NO TRABAJA ESTE EMPLEADO [REEMPLAZO].",
                    'typeModal' => 1
                );
            }



        }else {
            // $respuesta = "ESTAS FUERA DE TU HORARIO[1].";
            $respuesta = array(
                'mensaje' => "ESTAS FUERA DE SU HORARIO[1].",
                'typeModal' => 1
            );


            if ($existeRem >= 2) {
                $respuesta = array(
                    'mensaje' => "ERROR EN LA TABLA REEMPLAZO, HAY DUPLICADOS",
                    'typeModal' => 1
                );

            }

          
        }
     
        return $respuesta;
    }
}
?>