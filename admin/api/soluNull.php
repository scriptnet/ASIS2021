<?php

require_once("../config/class.Database.php");


$sql2 = "SELECT ASS.id_Empleado, ASS.A_Turno, ASS.Fecha_Marcada, ASS.id_Dia, ASS.Ass_codigo,  ASS.A_Entrada_Marcada, ASS.id_Horario, ASS.A_Salida_Marcada, DEDIEM.H_Salida FROM tbl_asistencia ASS INNER JOIN tbl_detallediaempleado DEDIEM ON ASS.id_Horario = DEDIEM.id_DDE WHERE ASS.A_Salida_Marcada IS NULL ";
$res =  Database::get_arreglo( $sql2 );

foreach ($res as $key) {
  $idHorario = $key['id_Horario'];
  $horaMarcada = $key['A_Entrada_Marcada'];
  $salidaOriginal = $key['H_Salida'];
  $turno =  $key['A_Turno'];
  $fechaMarcada = $key['Fecha_Marcada'];
  $data_dia = $key['id_Dia'];
  $codDni = $key['id_Empleado'];
  $Ass_codigo =  $key['Ass_codigo'];
       // sacamos su horas hombre automatico
       $HoraEntrada = new DateTime($horaMarcada );//fecha inicial
       $SalidaOficial = new DateTime($salidaOriginal);//fecha de cierre

       $intervaloH = $HoraEntrada->diff($SalidaOficial);
       $h_hombre = $intervaloH->format('%H:%i:%s');


            $sql = "UPDATE tbl_asistencia SET
            A_Salida_Marcada = '$salidaOriginal',
            H_Hombre =  '$h_hombre'
            WHERE A_Turno = '$turno' AND Fecha_Marcada = '$fechaMarcada' AND id_Dia = '$data_dia' AND id_Empleado = '$codDni' AND Ass_codigo = '$Ass_codigo'";
            $hecho2 = Database::ejecutar_idu( $sql );
                     
                if (is_numeric($hecho2) OR $hecho2 === true) {
                $respuesta = array(
                    'err' => false,
                    'mensaje' => 'LA DATA FUE CURADA.',
                );
             }else {
                $respuesta = array(
                    'err' => true,
                    'mensaje' => 'HAY UN ERROR EN EL SISTEMA :( [3]',
                );
            break;
             }

     
}
echo json_encode($respuesta);
?>