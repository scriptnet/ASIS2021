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
    

    
        foreach ($jsonarray as $row) {
            $codDni = $row["E_DNI"];
            $descripcion = $row["descripcion"];
            $precio = $row["precio"];
            // $pisi = $codDni.$row["pisi"];

                 $sql2 = "INSERT INTO tbl_cashadelanto (id_empleado, CA_fecha, CA_Precio, CA_Descripcion)
                VALUES(
                    '$codDni',
                    NOW(),
                    '$precio',
                    '$descripcion'
                    )";

                          $hecho2 = Database::ejecutar_idu( $sql2 );
                        if (is_numeric($hecho2) OR $hecho2 === true) {

                            $respuesta = array ( 'err'=>false, 'Mensaje'=>"Guardado");
                        }else {
                            
                            $respuesta = array ( 'err'=>true, 'Mensaje'=>"No se pudo guardar");
                        }

        }

    //              $sql2 = "INSERT INTO tbl_detallediaempleado (id_Dia, De_Turno, Cod_Empleado, H_Entrada, H_Salida)
    //             VALUES(
    //                 '$dia',
    //                 '$turno',
    //                 '$codEmpelado',
    //                 '$hora1',
    //                 '$hora2'
    //                 )";
                    
    //   $hecho2 = Database::ejecutar_idu( $sql2 );
    //   if (is_numeric($hecho2) OR $hecho2 === true) {

    //     $respuesta = array ( 'err'=>false, 'Mensaje'=>"Guardado");
    //   }else {
          
    //     $respuesta = array ( 'err'=>true, 'Mensaje'=>"No se pudo guardar");
    //   }


}

echo json_encode($respuesta);
?>