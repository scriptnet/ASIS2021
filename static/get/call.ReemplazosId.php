<?php
 require_once("../../admin/config/class.Database.php");
 
 if( isset( $_GET["filter"] ) ){

    $filter = $_GET["filter"];
    $sql1 = "SELECT EMPLE.E_Nombres, EMPLE.E_Apellidos, EMPLE.E_DNI FROM tbl_empleado EMPLE WHERE EMPLE.E_DNI ='$filter'";
    $res1 =  Database::get_row( $sql1 );

    $sql2 = "SELECT  EMPLE.E_Nombres, EMPLE.E_Apellidos, EMPLE.E_DNI, POS.P_Descripcion, REEM.puesto_TO FROM tbl_empleado EMPLE  INNER JOIN tbl_remplazos REEM ON EMPLE.E_DNI = REEM.Rem_to INNER JOIN tbl_posicion POS ON REEM.puesto_TO = POS.id_Posicion WHERE REEM.Rem_from ='$filter'";
    $res =  Database::get_json_rows( $sql2 );

    $dec = json_decode($res);
    if (!empty($dec)) {
        $respuesta = array('err' => false, 'ReemplazoNom' => $res1, 'Reemplazados' => $dec  );
    }else {
        $respuesta = array('err' => true, 'mess' => 'No hay data.' );
    }

    echo json_encode( $respuesta );
}
?>