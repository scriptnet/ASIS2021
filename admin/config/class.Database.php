<?php
class Database{
        private $_connection;
        private $_host = "localhost";
        private $_user = "root";
        private $_pass = "";
        private $_db   = "asistencia";

        // Almacenar una unica instancia
        private static $_instancia;



        // ================================================
        // Metodo para obtener instancia de base de datos
        // ================================================
        public static function getInstancia(){

            if(!isset(self::$_instancia)){
                self::$_instancia = new self;
            }


            return self::$_instancia;
        }
        // ================================================
        // Constructor de la clase Base de datos
        // ================================================
        public function __construct(){
            $this->_connection = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);

            // Manejar error en base de datos
            if (mysqli_connect_error()) {
                trigger_error('Falla en la conexion de base de datos'. mysqli_connect_error(), E_USER_ERROR );
            }
            $this->_connection->query("SET lc_time_names = 'es_ES'");
        }

        // Metodo vacio __close para evitar duplicacion
        private function __close(){}

        // Metodo para obtener la conexion a la base de datos
        public function getConnection(){
            $this->_connection->set_charset("utf8mb4");
            return $this->_connection;
        }

        // Metodo que revisa el String SQL
        private static function es_string($sql){
            if (!is_string($sql)) {
                trigger_error('class.Database.inc: $SQL enviado no es un string: ' .$sql);
                return false;
            }
            return true;
        }



        // ==================================================
        // 	Funcion que ejecuta el SQL y retorna un ROW
        // 		Esta funcion esta pensada para SQLs,
        // 		que retornen unicamente UNA sola línea
        // ==================================================
        public static function get_row($sql){

            if(!self::es_string($sql))
                exit();

            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();
            $resultado = $mysqli->query($sql);

            if($row = $resultado->fetch_assoc()){
                return $row;
            }else{
                return array();
            }
        }

        // ==================================================
        // 	Funcion que ejecuta el SQL y retorna un CURSOR
        // 		Esta funcion esta pensada para SQLs,
        // 		que retornen multiples lineas (1 o varias)
        // ==================================================
        public static function get_cursor($sql){

            if(!self::es_string($sql))
                exit();


            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

            $resultado = $mysqli->query($sql);
            return $resultado; // Este resultado se puede usar así:  while ($row = $resultado->fetch_assoc()){...}
        }


        // ==================================================
        // 	Funcion que ejecuta el SQL y retorna un jSon
        // 	data: [{...}] con N cantidad de registros
        // ==================================================
        public static function get_json_rows($sql){

            if(!self::es_string($sql))
                exit();

            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();


            $resultado = $mysqli->query($sql);


            // Si hay un error en el SQL, este es el error de MySQL
            if (!$resultado ) {
                return "class.Database.class: error ". $mysqli->error;
            }

            $i = 0;
            $registros = array();

            while($row = $resultado->fetch_assoc()){
                array_push( $registros, $row );
                // $registros[$i]= $row;
                // $i++;
            };
            return json_encode( $registros );
        }

        // ==================================================
        // 	Funcion que ejecuta el SQL y retorna un Arreglo
        // ==================================================
        public static function get_arreglo($sql){

            if(!self::es_string($sql))
                exit();

            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();


            $resultado = $mysqli->query($sql);


            // Si hay un error en el SQL, este es el error de MySQL
            if (!$resultado ) {
                return "class.Database.class: error ". $mysqli->error;
            }

            $i = 0;
            $registros = array();

            while($row = $resultado->fetch_assoc()){
                array_push( $registros, $row );
            };
            return $registros;
        }


        // ==================================================
        // 	Funcion que ejecuta el SQL y retorna un jSon
        // 	de una sola linea. Ideal para imprimir un
        // 	Query que solo retorne una linea
        // ==================================================
        public static function get_json_row($sql){

            if(!self::es_string($sql))
                exit();

            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

            $resultado = $mysqli->query($sql);

            // Si hay un error en el SQL, este es el error de MySQL
            if (!$resultado ) {
                return "class.Database.class: error ". $mysqli->error;
            }


            if(!$row = $resultado->fetch_assoc()){
                return "{}";
            }
            return json_encode( $row );
        }


        // ====================================================================
        // 	Funcion que ejecuta el SQL y retorna un valor
        // 	Ideal para count(*), Sum, cosas que retornen una fila y una columna
        // ====================================================================
        public static function get_valor_query($sql,$columna){

            if(!self::es_string($sql,$columna))
                exit();

            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

            $resultado = $mysqli->query($sql);

            // Si hay un error en el SQL, este es el error de MySQL
            if (!$resultado ) {
                return "class.Database.class: error ". $mysqli->error;
            }

            $Valor = NULL;
            //Trae el primer valor del arreglo
            if ($row = $resultado->fetch_assoc()) {
                // $Valor = array_values($row)[0];
                $Valor = $row[$columna];
            }

            return $Valor;
        }
        
        // ====================================================================
        // 	Funcion que ejecuta el SQL de inserción, actualización y eliminación
        // ====================================================================
        public static function ejecutar_idu($sql){

            if(!self::es_string($sql))
                exit();

            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

            if (!$resultado = $mysqli->query($sql) ) {
                return "class.Database.class: error ". $mysqli->error;
            }else{
                return $mysqli->insert_id;
            }


            return $resultado;
        }


        // ====================================================================
        // 	Funciones para encryptar y desencryptar data:
        // 		crypt_blowfish_bydinvaders
        // ====================================================================
        Public static function crypt($aEncryptar, $digito = 7) {
            $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $salt = sprintf('$2a$%02d$', $digito);
            for($i = 0; $i < 22; $i++)
            {
                $salt .= $set_salt[mt_rand(0, 22)];
            }
            return crypt($aEncryptar, $salt);
        }

        Public static function uncrypt($Evaluar, $Contra){

            if( crypt($Evaluar, $Contra) == $Contra)
                return true;
            else
                return false;

        }

        // ==================================
        //      GRAFICOS 
        //  =================================
        public static function graficoProcesarGastosMensuales($year){
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

            $GastosServicios = Array();
            $GastosPlantilla = Array();

            $sql = "SELECT 
            EMPL.E_Nombres AS NOMBRES,
            EMPL.E_Apellidos AS APELLIDOS,
            EMPL.E_DNI AS DNI
            FROM tbl_empleado EMPL 
            GROUP BY EMPL.E_DNI  
            ";
            $empleados = Database::get_arreglo( $sql );


            for ($i=0; $i < 12; $i++) { 

                $mes = $i + 1;
                
            
                $planillaSinPro = 0;
                $planillaConPro = 0;
                foreach ($empleados as $row) {
                    $dni = $row["DNI"];
                    
                    // SACAMOS EL ADELANTO
               
                    $sql = "SELECT 
                    IFNULL( SUM( CASHA.CA_Precio), 0) ADELANTO

                    FROM tbl_cashadelanto CASHA WHERE  CASHA.id_empleado =  $dni AND MONTH( CASHA.CA_fecha) = '$mes' AND  YEAR( CASHA.CA_fecha) = '$year'
 
                    ";
                    
                    $res = $mysqli->query($sql);
                    $totalAdelnto = $res->fetch_assoc();

                    // SACAMOS EL TOTAL NETO
                    $sql = "SELECT IFNULL(HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))), 0) AS H_HOMBRE, POS.P_Tarifa AS TARIFA,  IFNULL(HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))), 0) AS H_TARDE
                        FROM tbl_posicion POS INNER JOIN tbl_asistencia ASS ON POS.id_Posicion = ASS.id_Posicion 
                        WHERE ASS.id_Empleado = $dni AND MONTH(ASS.Fecha_Marcada) = '$mes' AND  YEAR(ASS.Fecha_Marcada) = '$year'  GROUP BY ASS.Ass_codigo";
                    $datosTarifaAss = Database::get_arreglo( $sql );
                    $totalNeto = 0;
                    $P_proyectada = 0;
                    foreach ($datosTarifaAss as $value) {
                        $tarifa =  $value['TARIFA'];
                        $horashombre = $value['H_HOMBRE'];
                        $horasTarde = $value['H_TARDE'];
                        $P_proyectada += $tarifa * $horashombre;
                        // $hh_t = ($tarifa * $horashombre)-($tarifa * $horasTarde);
                        $hh_t = ($tarifa * $horashombre)-($tarifa * $horasTarde);
                        $totalNeto += $hh_t;
                    }

                    $planillaSinPro  = $planillaSinPro + ($totalNeto - $totalAdelnto['ADELANTO']) ;
                    $planillaConPro  += $P_proyectada;

                }




          
               $GastosPlantilla[$i] = 0;
               
               $GastosPlantilla[$i] = ($planillaSinPro == 0)? 0 :  $planillaSinPro;


            }

            $data = Array(
                // "GastosServicios" => $GastosServicios,
                "GastosPlanilla" => $GastosPlantilla
            
            );

            return $data;

        }
        public static function graficoProcesarTardanzasPuntualidad($year){
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $totalTardanza = Array();
            $totalPuntualidad = Array();
            
            for ($i=0; $i < 12; $i++) { 
              $mes = $i + 1;
              $sql = "SELECT COUNT(*) AS total FROM tbl_asistencia WHERE  MONTH(Fecha_Marcada) = '$mes' AND  YEAR(Fecha_Marcada) = '$year' AND A_TARDANZA >= '00:01:00' AND id_Horario != 0 LIMIT 1";
              $res = $mysqli->query($sql);
              $totalTardanza[$i] = 0;

              foreach ($res as $row) {
                $totalTardanza[$i] = ($row['total'] == null)? 0 : $row['total'];
              }

              $sql2 = "SELECT COUNT(*) AS total2 FROM tbl_asistencia WHERE  MONTH(Fecha_Marcada) = '$mes' AND  YEAR(Fecha_Marcada) = '$year' AND A_TARDANZA < '00:01:00' AND id_Horario != 0 LIMIT 1";
              $res2 = $mysqli->query($sql2);
              $totalPuntualidad[$i] = 0;

              foreach ($res2 as $row) {
                $totalPuntualidad[$i] = ($row['total2'] == null)? 0 : $row['total2'];
              }

            }

            

            $data = Array(
                "tarde" => $totalTardanza,
                "puntual" => $totalPuntualidad
            
            );
            return $data;

            
            
        
        }

        //================================================
        //
        //API RENIEC
        //
        //==================================================


        public static function scriptentReniec($Dni){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://vinfo.sunedu.gob.pe/getDatos/$Dni");
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'X-Apple-Tz: 0',
                'X-Apple-Store-Front: 143444,12',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate',
                'Accept-Language: en-US,en;q=0.5',
                'Cache-Control: public',
                'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                // 'Host: www.example.com',
                'Referer: https://vinfo.sunedu.gob.pe/web', //Your referrer address
                'Sec-Fetch-Mode: cors',
                'X-Requested-With: XMLHttpRequest',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36',
                'X-MicrosoftAjax: Delta=true'
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec ($ch);
            $data = json_decode($server_output);

            if ($data->persona != null) {
                $datos = array();
                $datos[] = array(     
                    'err'	=> true,     
                    'PATERNO' => $data->persona->apellidoPaterno, 
                    'MATERNO' => $data->persona->apellidoMaterno,
                    'NOMBRES' => $data->persona->nombres,
                    'GENERO' => $data->persona->genero,
                    'DESGENERO' => $data->persona->desGenero,
                    'NACIMIENTO' => $data->persona->fechaNacimiento,
                    'DNI' => $Dni

                );
            }else {
                $datos = array();
                $datos[] = array(
                            'err'	=> false
                );
            }
            return $datos;
            curl_close ($ch);
        }
 //====================================================================================
        // PAGINACNION
        //====================================================================================

        // ================================================
        //   Funcion que pagina Posicion
        // ================================================
        Public static function get_todo_paginadoPosicion( $tabla,  $pagina = 1, $por_pagina = 20 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

            $sql = "SELECT count(*) as cuantos from $tabla";

            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla";
         

            $datos = Database::get_arreglo( $sql );
            // $datos2 = Database::get_arreglo( $sql2 );

            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $datos,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }

         // ================================================
        //   Funcion que pagina Posicion
        // ================================================
        Public static function get_todo_paginado_Empleados( $tabla,  $pagina = 1, $buscar, $por_pagina = 5 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla EMPLE ";

            if($buscar != ''){
                $sql .= " WHERE (EMPLE.E_Nombres like '%".$buscar."%' OR EMPLE.E_Apellidos  like '%".$buscar."%' OR EMPLE.E_DNI like '%".$buscar."%' OR EMPLE.E_Info_Contacto like '%".$buscar."%' OR EMPLE.E_Genero like '%".$buscar."%')";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla EMPLE";
                if($buscar != ''){
                    $sql .= " WHERE (EMPLE.E_Nombres like '%".$buscar."%' OR EMPLE.E_Apellidos  like '%".$buscar."%' OR EMPLE.E_DNI like '%".$buscar."%' OR EMPLE.E_Info_Contacto like '%".$buscar."%' OR EMPLE.E_Genero like '%".$buscar."%')";
                }
                $sql .= " order by EMPLE.id_Empleado DESC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );

            //ordenamos

            $dataCalculado = Array();

            foreach ($datos as $row) {
                $CODID=  $row['E_DNI'];
                
                $sql2 = "SELECT POS.id_Posicion, POS.P_Descripcion, DEPOEM.DePo_FromRem
                 FROM tbl_detalleposempleado DEPOEM  
                 INNER JOIN tbl_posicion POS 
                 ON DEPOEM.id_Posicion = POS.id_Posicion 
                 LEFT JOIN tbl_empleado EMP 
                 ON DEPOEM.DePo_FromRem = EMP.E_DNI 
                 WHERE DEPOEM.id_Empleado = $CODID";

                $puestos = Database::get_arreglo( $sql2 );
              
            //     $sql2 = "SELECT POS.id_Posicion, POS.P_Descripcion, DEPOEM.DePo_FromRem, EMP.E_Nombres, EMP.E_Apellidos 
            //     FROM tbl_detalleposempleado DEPOEM  
            //     INNER JOIN tbl_posicion POS 
            //     ON DEPOEM.id_Posicion = POS.id_Posicion 
            //     LEFT JOIN tbl_empleado EMP 
            //     ON DEPOEM.DePo_FromRem = EMP.E_DNI 
            //     WHERE DEPOEM.id_Empleado = $CODID";

            //    $puestos = Database::get_arreglo( $sql2 );
                


                $dataCalculado[]=array(
                    "id_Empleado" => $row['id_Empleado'],
                    "E_DNI" => $row['E_DNI'],
                    "E_Nombres" => $row['E_Nombres'],
                    "E_Apellidos" => $row['E_Apellidos'],
                    "POSICIONES" =>  $puestos,
                    "E_Info_Contacto" => $row['E_Info_Contacto'],
                    "E_Fecha_Nacimiento" => $row['E_Fecha_Nacimiento'],
                    "E_Direccion" => $row['E_Direccion'],
                    
                );

            }
         




            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $dataCalculado,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }

        // ================================================
        //   Funcion que pagina Posicion
        // ================================================
        Public static function get_todo_paginado_Horarios( $tabla, $idempleado, $dia, $pagina = 1, $por_pagina = 10 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla WHERE Cod_Empleado = $idempleado AND id_Dia = $dia AND De_Status = 1";

         



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = $dia AND De_Status = 1";
              
                $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );


            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $datos,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }


        // ================================================
        //   Funcion que pagina Posicion
        // ================================================
        Public static function get_todo_paginado_HorariosV2( $tabla, $idempleado, $puesto, $pagina = 1, $por_pagina = 10 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla WHERE Cod_Empleado = $idempleado AND De_Status = 1 AND id_DPE = $puesto";

         



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 1 AND De_Status = 1 AND id_DPE = $puesto";
              
                $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosLunes = Database::get_arreglo( $sql );

            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 2 AND De_Status = 1 AND id_DPE = $puesto";
              
                $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosMartes = Database::get_arreglo( $sql );

            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 3 AND De_Status = 1 AND id_DPE = $puesto";
                
                $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosMiercoles = Database::get_arreglo( $sql );


            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 4 AND De_Status = 1 AND id_DPE = $puesto";
                
            $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosJueves = Database::get_arreglo( $sql );


            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 5 AND De_Status = 1 AND id_DPE = $puesto";
                    
                $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosViernes = Database::get_arreglo( $sql );


            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 6 AND De_Status = 1 AND id_DPE = $puesto";
                        
            $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosSabado = Database::get_arreglo( $sql );
            

            $sql = "SELECT * from $tabla  WHERE Cod_Empleado = $idempleado AND id_Dia = 7 AND De_Status = 1 AND id_DPE = $puesto";
                            
            $sql .= " order by H_Entrada ASC limit $desde, $por_pagina ";

            $datosDomingo = Database::get_arreglo( $sql );


            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    'lunes' 			=> $datosLunes,
                    'martes' 			=> $datosMartes,
                    'miercoles' 			=> $datosMiercoles,
                    'jueves' 			=> $datosJueves,
                    'viernes' 			=> $datosViernes,
                    'sabado' 			=> $datosSabado,
                    'domingo' 			=> $datosDomingo,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }



                 // ================================================
        //   Funcion que pagina Posicion
        // ================================================
        Public static function get_todo_paginado_Asistencia( $tabla, $inicio, $fin, $pagina = 1, $buscar, $por_pagina = 5 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla ASS INNER JOIN  tbl_empleado EMPL ON ASS.id_Empleado = EMPL.E_DNI INNER JOIN tbl_dia DIA ON ASS.id_Dia = DIA.S_Cod INNER JOIN tbl_detallediaempleado DETAEMPLE ON ASS.id_Horario = DETAEMPLE.id_DDE WHERE  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin'";

            if($buscar != ''){
                $sql .= " AND (EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos  like '%".$buscar."%' OR EMPL.E_DNI like '%".$buscar."%' OR EMPL.E_Info_Contacto like '%".$buscar."%' OR EMPL.E_Genero like '%".$buscar."%' )";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla ASS INNER JOIN  tbl_empleado EMPL ON ASS.id_Empleado = EMPL.E_DNI INNER JOIN tbl_dia DIA ON ASS.id_Dia = DIA.S_Cod INNER JOIN tbl_detallediaempleado DETAEMPLE ON ASS.id_Horario = DETAEMPLE.id_DDE WHERE ASS.IsReemplazo = '0' AND  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin'";
                if($buscar != ''){
                    $sql .= " AND (EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos  like '%".$buscar."%' OR EMPL.E_DNI like '%".$buscar."%' OR EMPL.E_Info_Contacto like '%".$buscar."%' OR EMPL.E_Genero like '%".$buscar."%')";
                }
                $sql .= " order by ASS.id_Asistencia DESC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );


            $sqlRem = "SELECT * from $tabla ASS INNER JOIN  tbl_empleado EMPL ON ASS.id_Empleado = EMPL.E_DNI INNER JOIN tbl_dia DIA ON ASS.id_Dia = DIA.S_Cod WHERE ASS.IsReemplazo = '1' AND ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin'";
                if($buscar != ''){
                    $sqlRem .= " AND (EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos  like '%".$buscar."%' OR EMPL.E_DNI like '%".$buscar."%' OR EMPL.E_Info_Contacto like '%".$buscar."%' OR EMPL.E_Genero like '%".$buscar."%')";
                }
                $sqlRem .= " order by ASS.id_Asistencia DESC limit $desde, $por_pagina ";

            $datosRem = Database::get_arreglo( $sqlRem );
            $ReemplazosMarc = array();
            foreach ($datosRem as $key) {
            $codid = $key['id_reemplazo'];
            $id_reemplazo = $key['id_reemplazo'];

                $sql = "SELECT * FROM tbl_remplazos REEM INNER JOIN  tbl_empleado EMP ON REEM.Rem_to = EMP.E_DNI WHERE REEM.id_Rem =  $codid ";
                $Reem = Database::get_arreglo( $sql );

                $sql = "SELECT POS.P_Descripcion FROM tbl_remplazos REEM INNER JOIN tbl_posicion POS ON REEM.puesto_TO = POS.id_Posicion WHERE REEM.id_Rem = $id_reemplazo";
                $puestoRem = Database::get_arreglo( $sql );


                $ReemplazosMarc[]=array(
                    "Fecha_Marcada" =>  $key['Fecha_Marcada'],
                    "E_Nombres" =>  $key['E_Nombres'],
                    "E_Apellidos" =>  $key['E_Apellidos'],
                    "A_Entrada_Marcada" =>  $key['A_Entrada_Marcada'],
                    "A_Salida_Marcada" =>  $key['A_Salida_Marcada'],
                    "H_Hombre" =>  $key['H_Hombre'],
                    "Reemplazado" =>   $Reem[0]["E_Nombres"]." ".$Reem[0]["E_Apellidos"],
                    "PuestoRem" =>$puestoRem[0]['P_Descripcion']
                );
            }

            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $datos,
                    'Remplazaos'     => $ReemplazosMarc,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }

           // ================================================
        //   Funcion que pagina PosicionAll
        // ================================================
        Public static function get_todo_paginado_PosicionAll( $tabla,  $pagina = 1, $buscar, $por_pagina = 5 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla POS";

            if($buscar != ''){
                $sql .= " WHERE (POS.P_Descripcion like '%".$buscar."%')";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla POS";
                if($buscar != ''){
                    $sql .= " WHERE (POS.P_Descripcion like '%".$buscar."%')";
                }
                $sql .= " order by POS.id_Posicion DESC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );


            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $datos,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }
// ================================================
        //   Funcion que pagina Lista De Servicios
        // ================================================
        Public static function get_todo_paginado_ListarServicios( $tabla,  $pagina = 1, $buscar, $por_pagina = 50 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla SER";

            if($buscar != ''){
                $sql .= " WHERE (POS.P_Descripcion like '%".$buscar."%')";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla SER";
                if($buscar != ''){
                    $sql .= " WHERE (POS.P_Descripcion like '%".$buscar."%')";
                }
                $sql .= " order by SER.id_Serv DESC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );


            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $datos,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }
          // ================================================
        //   Funcion que pagina PaginadoAdelanto
        // ================================================
        Public static function get_todo_paginado_Adelanto( $tabla,  $pagina = 1, $buscar, $por_pagina = 5 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla CA INNER JOIN tbl_empleado EMPL ON CA.id_empleado = EMPL.E_DNI";

            if($buscar != ''){
                $sql .= " WHERE (CA.id_empleado like '%".$buscar."%')";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT * from $tabla CA  INNER JOIN tbl_empleado EMPL ON CA.id_empleado = EMPL.E_DNI";
                if($buscar != ''){
                    $sql .= " WHERE (POS.P_Descripcion like '%".$buscar."%')";
                }
                $sql .= " order by CA.CA_id DESC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );


            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $datos,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }

    // ================================================
        //   Funcion que pagina REEMPLAZOS ENTRE EMPLEADOS
        // ================================================
        Public static function get_todo_paginado_ReemplazosEmpleados( $tabla,  $pagina = 1, $buscar, $por_pagina = 5 ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

           
            $sql = "SELECT count(*) as cuantos from $tabla EMPLE  INNER JOIN tbl_remplazos REEM ON EMPLE.E_DNI = REEM.Rem_to INNER JOIN tbl_posicion POS ON REEM.puesto_TO = POS.id_Posicion";

            if($buscar != ''){
                $sql .= " WHERE (EMPLE.E_Nombres like '%".$buscar."%')";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            $sql = "SELECT EMPLE.E_Nombres, EMPLE.E_Apellidos, EMPLE.E_DNI, POS.P_Descripcion, REEM.puesto_TO, REEM.Rem_from, REEM.id_Rem,REEM.puesto_From ,REEM.Rem_disabled from $tabla EMPLE  INNER JOIN tbl_remplazos REEM ON EMPLE.E_DNI = REEM.Rem_to INNER JOIN tbl_posicion POS ON REEM.puesto_TO = POS.id_Posicion";
                if($buscar != ''){
                    $sql .= " WHERE (EMPLE.E_Nombres like '%".$buscar."%')";
                }
                $sql .= " order by REEM.id_Rem DESC limit $desde, $por_pagina ";

            $datos = Database::get_arreglo( $sql );
            

            $ArrReemplazos = array();

            foreach ($datos as $value) {
        
                 $dniRemmplazo =  $value['Rem_from'];
                 $puestoFromR = $value['puesto_From'];

                 $sql = "SELECT EMP.E_Nombres, EMP.E_Apellidos FROM tbl_empleado EMP WHERE EMP.E_DNI = '$dniRemmplazo'";
                 $Remm = Database::get_arreglo( $sql );
                 
                 $sql = "SELECT P_Tarifa FROM tbl_posicion WHERE id_Posicion = $puestoFromR";
                 $tarifaFrom = Database::get_arreglo( $sql );
                
                $ArrReemplazos[]=array(
                    "id_Rem" => $value['id_Rem'],
                    "E_Nombres" => $value['E_Nombres'],
                    "E_Apellidos" => $value['E_Apellidos'],
                    "E_DNI" =>$value['E_DNI'],
                    "P_Descripcion" => $value['P_Descripcion'],
                    "puesto_TO" => $value['puesto_TO'],
                    "Rem_from" =>$value['Rem_from'],
                    "Rem_disabled" =>$value['Rem_disabled'],
                    "REEMPLAZON" =>$Remm[0]['E_Nombres'] .' '. $Remm[0]['E_Apellidos'],
                    "TARIFAFROM" => $tarifaFrom[0]['P_Tarifa']
                );
            }

            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }


            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    $tabla 			=> $ArrReemplazos,
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }

         // ================================================
        //   Funcion que pagina Nomina de sueldos
        // ================================================
        Public static function get_todo_paginado_nominaSueldos( $tabla,  $pagina = 1, $buscar, $por_pagina = 20, $inicio, $fin  ){

            // Core de la funcion
            $db = DataBase::getInstancia();
            $mysqli = $db->getConnection();

        


            $sql = "SELECT count(*) as cuantos 
                    from tbl_asistencia ASS
                    INNER JOIN tbl_empleado EMPL ON ASS.id_Empleado = EMPL.E_DNI
                     INNER JOIN tbl_detalleposempleado DETAPUESTO ON EMPL.E_DNI = DETAPUESTO.id_Empleado
                    INNER JOIN tbl_posicion POS ON DETAPUESTO.id_Posicion = POS.id_Posicion
                    WHERE  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin' 
            ";

            if($buscar != ''){
                $sql .= "AND (EMPL.E_DNI like '%".$buscar."%' OR  EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos like '%".$buscar."%') GROUP BY ASS.id_Empleado ";
            }



            $cuantos       = Database::get_valor_query( $sql, 'cuantos' );
            $total_paginas = ceil( $cuantos / $por_pagina );

            if( $pagina > $total_paginas ){
                $pagina = $total_paginas;
            }


            $pagina -= 1;  // 0
            $desde   = $pagina * $por_pagina; // 0 * 20 = 0

            if( $pagina >= $total_paginas-1 ){
                $pag_siguiente = 1;
            }else{
                $pag_siguiente = $pagina + 2;
            }

            if( $pagina < 1 ){
                $pag_anterior = $total_paginas;
            }else{
                $pag_anterior = $pagina;
            }

            if( $desde <=0 ){
                $desde = 0;
            }


            // $sql = "SELECT * from $tabla EMPL INNER JOIN tbl_posicion POS ON EMPL.id_posicion = POS.id_Posicion";
            //     if($buscar != ''){
            //         $sql .= " WHERE (POS.P_Descripcion like '%".$buscar."%')";
            //     }
            //     $sql .= " order by EMPL.id_Empleado DESC limit $desde, $por_pagina ";

            // $datos = Database::get_arreglo( $sql );

            // $sql2 = "SELECT * FROM tbl_detalleposempleado DETAPOSEM INNER JOIN  tbl_posicion POS ON  DETAPOSEM.id_Posicion = POS.id_Posicion";
                
            // $PuestosEm = Database::get_arreglo( $sql2 );

            // ========================================
            //
            //=========================================

            //     $sql = "SELECT
            //             EMPL.E_Nombres,
            //             EMPL.E_Apellidos, 
            //             ASS.id_Empleado, 
            //             ASS.Fecha_Marcada,
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))) TardanzaH, 
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) TotalHoras,
            //             POS.P_Tarifa, 
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))) * POS.P_Tarifa DescuentoTarde,
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) * POS.P_Tarifa Total1
            //             from tbl_asistencia ASS
            //             INNER JOIN tbl_empleado EMPL ON ASS.id_Empleado = EMPL.E_DNI
            //             INNER JOIN tbl_detallediaempleado HORARIO ON ASS.id_Horario = HORARIO.id_DDE
            //             INNER JOIN tbl_posicion POS ON HORARIO.id_DPE = POS.id_Posicion
            //             WHERE  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin' 
            //            ";
            //             if($buscar != ''){
            //                 $sql .= "AND (ASS.id_Empleado like '%".$buscar."%' OR  EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos like '%".$buscar."%') GROUP BY ASS.id_Empleado";
            //             }else {
            //                 $sql .= "GROUP BY ASS.Ass_codigo";
            //             }
            //  $DetalleAss = Database::get_arreglo( $sql );
            // ========================================
            //
            //=========================================


            // $sql = "SELECT 
            //          EMPL.E_Nombres,
            //             EMPL.E_Apellidos, 
            //             ASS.id_Empleado, 
            //             ASS.Fecha_Marcada,
            //             ASS.Ass_codigo,
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))) TardanzaH, 
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) TotalHoras,
            //             POS.P_Tarifa,
            //             POS.P_Descripcion, 
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))) * POS.P_Tarifa DescuentoTarde,
            //             HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) * POS.P_Tarifa Total1
            //             from tbl_asistencia ASS
            //             INNER JOIN tbl_empleado EMPL ON ASS.id_Empleado = EMPL.E_DNI
            //             -- INNER JOIN tbl_detallediaempleado HORARIO ON ASS.id_Horario = HORARIO.id_DDE
            //             INNER JOIN tbl_posicion POS ON ASS.id_Posicion = POS.id_Posicion
            //             WHERE  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin' 
                      
            //        ";
            //         if($buscar != ''){
            //             $sql .= "AND (ASS.id_Empleado like '%".$buscar."%' OR  EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos like '%".$buscar."%') GROUP BY ASS.Ass_codigo";
            //         }else {
            //             $sql .= "GROUP BY ASS.Ass_codigo";
            //         }
            // $datos2 = Database::get_arreglo( $sql );

            // $dataCalculado = Array();
            // // para el pdf
            // $inicioFormat = date("d-m-Y", strtotime($inicio));
            // $finFormat = date("d-m-Y", strtotime($fin));
            // // sacamos el total de todo
            // $totalPlantilla = 0;
          

            // foreach ($datos2 as $row) {
            //     $CODID=  $row['id_Empleado'];
            //     $Ass_codigo=  $row['Ass_codigo'];

            //     $sql = "SELECT *,  COALESCE(SUM(CA_Precio), 0) AS ADELANTO FROM tbl_cashadelanto WHERE Ass_codigo = $Ass_codigo AND CA_fecha BETWEEN '$inicio' AND '$fin'";

            //     $res = $mysqli->query($sql);
            //     $carow = $res->fetch_assoc();

            


            //     $cashadvance = $carow['ADELANTO'];
            //     $descuento = number_format($cashadvance + $row['DescuentoTarde'], 2);
            //     $totalNeto = number_format($row['Total1']- $descuento, 2);

            //     $totalPlantilla += $totalNeto;

            //     $dataCalculado[]=array(
            //         "Nombres" => $row['E_Nombres'],
            //         "Apellidos" => $row['E_Apellidos'],
            //         "DNI" => $row['id_Empleado'],
            //         "Fech_Marc" => $row['Fecha_Marcada'],
            //         "tardeEnHoras" => $row['TardanzaH'],
            //         "HorasHombre" => $row['TotalHoras'],
            //         "tarifa" => $row['P_Tarifa'],
            //         "DescuentoTarde" => $row['DescuentoTarde'],
            //         "total1" => $row['Total1'],
            //         "SoloAdelanto" =>  $cashadvance,
            //         "DescuentoTA" =>  $descuento,
            //         "TotalNeto" =>  $totalNeto,
            //         "FECHAS" =>  $inicioFormat.' al '.$finFormat,
            //         "puesto" => $row['P_Descripcion']
            //     );

            // }

            
            
            $resultado = $mysqli->query($sql);

            $arrPaginas = array();
            for ($i=0; $i < $total_paginas; $i++) {
                array_push($arrPaginas, $i+1);
            }

            // llamamos a los empleados
            //
            //===========================================
            $sql = "SELECT 
               
                EMPL.E_Nombres AS NOMBRES,
                EMPL.E_Apellidos AS APELLIDOS,
                EMPL.E_DNI AS DNI

              FROM tbl_empleado EMPL   
              ";


                if($buscar != ''){
                    $sql .= "WHERE ( EMPL.E_Nombres like '%".$buscar."%' OR EMPL.E_Apellidos like '%".$buscar."%' OR EMPL.E_DNI like '%".$buscar."%' ) GROUP BY EMPL.E_DNI";
                }else {
                    $sql .= "GROUP BY EMPL.E_DNI";
                }


            $empleados = Database::get_arreglo( $sql );
            $EmpleadosArray = Array();
            $planillaSinPro = 0;
            $planillaConProH = 0;
            $resultadoAll = 0;
         
            foreach ($empleados as $row) {
                $dni = $row["DNI"];
                
                //PLANILLA PROYECTADA
                $sqlPp = "SELECT DETA.Cod_Empleado, POS.id_Posicion, POS.P_Tarifa, DETA.H_Entrada, DETA.H_Salida FROM tbl_detallediaempleado DETA INNER JOIN tbl_posicion POS ON DETA.id_DPE = POS.id_Posicion WHERE DETA.Cod_Empleado =  $dni AND DETA.De_Status = 1";
                $planillaProH = Database::get_arreglo( $sqlPp );
                foreach ($planillaProH as $key) {
                    $h_entrada = $key['H_Entrada'];
                    $h_salida = $key['H_Salida'];
                    $P_Tarifa = $key['P_Tarifa'];

              
                                

                    

                      // sacamos su horas totales
                        $HoraEntrada = new DateTime($h_entrada );//fecha inicial
                        $SalidaOficial = new DateTime($h_salida);//fecha de cierre

                        $intervaloH = $HoraEntrada->diff($SalidaOficial);
                        $h_hombre = $intervaloH->format('%H');
                      
                        $resultado1 = $h_hombre * $P_Tarifa;
                   
                        $resultadoAll +=  $resultado1;
                }
                // ASISTENCIA
                $sql = "SELECT 
                  IFNULL(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre))), 0) TotalHoras,
                  IFNULL(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA))), 0) TardanzaH

                FROM tbl_asistencia ASS WHERE ASS.id_Empleado =  $dni AND  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin' 
                ";
                
                $res = $mysqli->query($sql);
                $totalAss = $res->fetch_assoc();

                // SACAMOS EL ADELANTO
                $sql = "SELECT 
                 IFNULL( SUM( CASHA.CA_Precio), 0) ADELANTO

              FROM tbl_cashadelanto CASHA WHERE  CASHA.id_empleado =  $dni AND CASHA.CA_fecha BETWEEN '$inicio' AND '$fin' 
              ";
              
              $res = $mysqli->query($sql);
              $totalAdelnto = $res->fetch_assoc();

                // SACAMOS EL TOTAL NETO
                $sql = "SELECT IFNULL(HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))), 0) AS H_HOMBRE, POS.P_Tarifa AS TARIFA,  IFNULL(HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))), 0) AS H_TARDE
                  FROM tbl_posicion POS INNER JOIN tbl_asistencia ASS ON POS.id_Posicion = ASS.id_Posicion WHERE ASS.id_Empleado = $dni AND  ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin'  GROUP BY ASS.Ass_codigo";
                $datosTarifaAss = Database::get_arreglo( $sql );
                $totalNeto = 0;
                $P_proyectadaHombre = 0;
                foreach ($datosTarifaAss as $value) {
                    $tarifa =  $value['TARIFA'];
                    $horashombre = $value['H_HOMBRE'];
                    $horasTarde = $value['H_TARDE'];
                    $P_proyectadaHombre += $tarifa * $horashombre;
                    $hh_t = ($tarifa * $horashombre);
                    // $hh_t = ($tarifa * $horashombre)-($tarifa * $horasTarde);
                    $totalNeto += $hh_t;
                }
               
                // DETTALLE DE SUS PUESTOS
                $sql = "SELECT 
               
                   ASS.id_Empleado, 
                   ASS.Fecha_Marcada,
                   ASS.Ass_codigo,
                   HOUR(SEC_TO_TIME(SUM(SEC_TO_TIME(ASS.A_TARDANZA)))) TardanzaH, 
                   HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) TotalHoras,
                   POS.P_Tarifa,
                   POS.P_Descripcion, 
                   HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA)))) * POS.P_Tarifa DescuentoTarde,
                   HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) * POS.P_Tarifa Total1,
                --    (HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) - HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.A_TARDANZA))))) * POS.P_Tarifa AS TOTALNETO
                   (HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(ASS.H_Hombre)))) ) * POS.P_Tarifa AS TOTALNETO
                   from tbl_asistencia ASS
                   -- INNER JOIN tbl_detallediaempleado HORARIO ON ASS.id_Horario = HORARIO.id_DDE
                   INNER JOIN tbl_posicion POS ON ASS.id_Posicion = POS.id_Posicion
                   WHERE  ASS.id_Empleado = $dni AND ASS.Fecha_Marcada BETWEEN '$inicio' AND '$fin' 
                   GROUP BY ASS.Ass_codigo
                 
              ";
              
       $Detalle = Database::get_arreglo( $sql );

              $planillaSinPro  = $planillaSinPro + ($totalNeto - $totalAdelnto['ADELANTO']) ;
              $planillaConProH  += $P_proyectadaHombre;
                $EmpleadosArray[]=array(
                    // "ID_POSICION" => $row['POSICION_ID'],
                    "ADELANTO" => $totalAdelnto['ADELANTO'],
                    "NOMBRES" => $row['NOMBRES'],
                    "APELLIDOS" => $row['APELLIDOS'],
                    "H_HOMBRE" =>  $totalAss['TotalHoras'],
                    "H_TARDE" => $totalAss['TardanzaH'],
                    "TOTAL_NETO" => $totalNeto - $totalAdelnto['ADELANTO'],
                    "DETALLE" => $Detalle
                );
            }
              // trameos a servicios
              $sqlP = "SELECT * from tbl_servicios SER WHERE SER.Ser_Fecha BETWEEN '$inicio' AND '$fin'  ORDER BY SER.id_Serv DESC";
              $datosSERvicios = Database::get_arreglo( $sqlP );

            //   total de todos los servicios
            $totalMontoServicio = 0;
            foreach ($datosSERvicios as $row) {
                $monto = $row["Serv_Monto"];

                $totalMontoServicio += $monto;
            }
           
            
            // calculamos los dias de un rango de una fecha

            $fecha1D = new DateTime($inicio);//fecha inicial
            $fecha2D = new DateTime($fin);//fecha de cierre
			
            $diffD = $fecha1D->diff($fecha2D);
			// $TEST = $diffD->days + 1;
			// $TEST2 = $resultadoAll;
            $diffD = $diffD->days + 1;
            $diffD =  $diffD / 7;
            $resultadoAll = $resultadoAll *$diffD ;
          
            $respuesta = array(
                    'err'     		=> false,
                    'conteo' 		=> $cuantos,
                    'empleados' => $EmpleadosArray,
                    // $tabla 			=> $dataCalculado,
                    'Servicios'  => $datosSERvicios,
                    'totalPlanilla' => $planillaSinPro,
                    'planillaProyecta' =>  $resultadoAll,
					// 'TEST' => $TEST,
					// 'TEST_2' => $TEST2,
                    'TotalNetoServicio' => $totalMontoServicio + $planillaSinPro, 
                    'pag_actual'    => ($pagina+1),
                    'pag_siguiente' => $pag_siguiente,
                    'pag_anterior'  => $pag_anterior,
                    'total_paginas' => $total_paginas,
                    'paginas'	    => $arrPaginas
                    );


            return  $respuesta;

        }

}
?>