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

    $nombres =  $jsonarray["Nombres"];
    $Apellidos =  $jsonarray["Apellidos"];
    $Direccion =  $jsonarray["Direccion"];
    $dateFN = date('Y-m-d', strtotime(str_replace('-', '/', $jsonarray["date"])));
    $dni =  $jsonarray["dni"];
    $cel =  $jsonarray["cel"];
    $genero = $jsonarray["genero"];
    $posicion = $jsonarray["posicion"];
    $tipo = 0;
    // if (!isset($jsonarray["fromRemplazo"])) {
    //     $fromRemplazo = "";
    //     $tipo = 0;
    // }else {
        
    //     $fromRemplazo = $jsonarray["fromRemplazo"];
    //     $tipo = 1;
    // }
    
    // VERIFICAMOS SI EL DNI EXISTE
    $rptaT = Consulta($dni);
    if ($rptaT) {
        // INSERTAMOS EL EMPLEADO

        $sql = "INSERT INTO tbl_empleado (E_Nombres, E_Apellidos, E_Direccion, E_Fecha_Nacimiento, E_DNI, E_Info_Contacto, E_Genero, E_tipo)
        VALUES(
            '$nombres', 
            '$Apellidos', 
            '$Direccion',
            '$dateFN',
            '$dni',
            '$cel',
            '$genero',
            '$tipo'
            )";
            
        $hecho = Database::ejecutar_idu( $sql );
        if (is_numeric($hecho) OR $hecho === true) {

            foreach ($jsonarray["posicion"] as $row) {
                $idPos = $row['id_Posicion'];

                $sql2 = "INSERT INTO tbl_detalleposempleado (id_Empleado, id_Posicion)
                VALUES(
                    '$dni', 
                    '$idPos'
                
                    )";
                    
                $hecho2 = Database::ejecutar_idu( $sql2 );

            }

            if (is_numeric($hecho2) OR $hecho2 === true) {
                $respuesta = array ( 'err'=>false, 'Mensaje'=>"Guardado");
            }else {
                $respuesta = array ( 'err'=>true, 'Mensaje'=>"Error comunicate con el admin");
            }
           
        }else{
            $respuesta = array ( 'err'=>true, 'Mensaje'=>"No se pudo agregar el empleado");
        }
    }else {
        $respuesta = Array ( 'err'=>true, 'Mensaje'=>'El Empleado ya existe');
    }
    
   

}else{
    echo "============================\n maldito perro que haces aqui? -.-";
    $respuesta = Array ( 'err'=>true, 'Mensaje'=>'Error de data!');
}


//=====================================================
//Verificamos si el Dni existe
//=====================================================
function Consulta ($dni){
    $sql1="SELECT E_DNI FROM tbl_empleado WHERE E_DNI = '$dni'";
    $respuesta  = Database::get_row( $sql1 );
     if (isset($respuesta['E_DNI'])) {
      $estado = false;
    } else {
      $estado = true;
    }
    return $estado;
  };

echo json_encode($respuesta);
?>