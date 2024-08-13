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

    
    $nombres =  $jsonarray["E_Nombres"];
    $E_Apellidos = $jsonarray["E_Apellidos"];
    $E_Direccion = $jsonarray["E_Direccion"];
    $E_Fecha_Nacimiento = $jsonarray["E_Fecha_Nacimiento"];
    $E_Info_Contacto = $jsonarray["E_Info_Contacto"];
    $fromRemplazo = $jsonarray["POSICIONES"][0]["DePo_FromRem"];
    // $E_Genero = $jsonarray["E_Genero"];
    // $ArrayPosi = $jsonarray["posciArray"];
    $coddni = $jsonarray["E_DNI"];


    $sql = "UPDATE tbl_empleado SET
    E_Nombres = '$nombres',
    E_Apellidos = '$E_Apellidos',
    E_Direccion =  '$E_Direccion' ,
    E_Fecha_Nacimiento = '$E_Fecha_Nacimiento',
    E_Info_Contacto ='$E_Info_Contacto'
    WHERE id_Empleado=" .$jsonarray["id_Empleado"];
    $hechoP = Database::ejecutar_idu( $sql );

    if (is_numeric($hechoP) OR $hechoP === true) {
        $sql = "DELETE FROM tbl_detalleposempleado WHERE id_Empleado = $coddni";
        $hechoP = Database::ejecutar_idu( $sql );

        if (is_numeric($hechoP) OR $hechoP === true) {
            
            foreach ($jsonarray["posciArray"] as $row) {
                $sql = "INSERT INTO tbl_detalleposempleado (id_Empleado, id_Posicion, DePo_FromRem)
                VALUES(
                    '$coddni', 
                    '$row',
                    '$fromRemplazo'
                    )";
                    
                $hechoP = Database::ejecutar_idu( $sql );

            }
            if (is_numeric($hechoP) OR $hechoP === true) {
                $respuesta = array(
                    'err' => false,
                    'mensaje' => 'GUARDARO',
                );
            }else {
                $respuesta = array(
                    'err' => true,
                    'mensaje' => 'Error[3]!',
                );
            }
        }else {
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error[2]!',
            );
        }

      
    }else {
        $respuesta = array(
            'err' => true,
            'mensaje' => 'ERROR[1]!',
        );
    }



    echo json_encode($respuesta);
}


?>