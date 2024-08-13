<?php
session_start();
require_once("../../config/class.Database.php");


$postdata = file_get_contents("php://input");

$request = json_decode($postdata);
$request =  (array) $request;


$respuesta = array(
				'err' => true,
				'mensaje' => 'Usuario/Contraseña incorrectos',
			);


// ================================================
//   Encriptar la contraseña maestra (UNICA VEZ)
// ================================================
// encriptar_usuario();

if(  isset( $request['usuario'] ) && isset( $request['pass'] ) ){ // ACTUALIZAR

    $user = addslashes( $request['usuario'] );
	$pass = addslashes( $request['pass'] );

    $user = strtoupper($user);
    
    // Verificar que el usuario exista
	$sql = "SELECT count(*) as existe FROM tbl_usuarios where User_Nom = '$user'";
    $existe = Database::get_valor_query( $sql, 'existe' );
    
    if( $existe == 1 ){

        $sql = "SELECT User_Pass FROM tbl_usuarios where User_Nom = '$user'";
        $data_pass = Database::get_valor_query( $sql, 'User_Pass' );
        
        	// Encriptar usando el mismo metodo
         $pass = Database::uncrypt( $pass, $data_pass );
         
         if( $data_pass == $pass ){

            $respuesta = array(
				'err' => false,
				'mensaje' => 'Login valido',
				'url' => 'panel.php#scriptnet/index'
            );
            
            $_SESSION['user'] = $user;

            // actualizar ultimo acceso
			$sql = "UPDATE tbl_usuarios set Us_UltimoAcceso = NOW() where User_Nom = '$user'";
			Database::ejecutar_idu($sql);

         }

    }


}


// sleep(1.5);
echo json_encode( $respuesta );





// Esto se puede borrar despues
// ================================================
//   Funcion para Encriptar
// ================================================
// function encriptar_usuario(){

// 	$usuario_id = '1';
// 	$contrasena = 'cajlab12';
// 	$contrasena_crypt = Database::crypt( $contrasena );

// 	$sql = "UPDATE tbl_usuarios set User_Pass = '$contrasena_crypt' where id_User = '$usuario_id'";
// 	Database::ejecutar_idu($sql);

// }


?>