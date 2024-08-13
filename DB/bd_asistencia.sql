-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-08-2022 a las 23:01:06
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asistencia`
--

CREATE TABLE `tbl_asistencia` (
  `id_Asistencia` int(11) NOT NULL,
  `A_Turno` int(11) NOT NULL,
  `Fecha_Marcada` date NOT NULL,
  `id_Dia` int(11) NOT NULL,
  `id_Empleado` int(11) NOT NULL,
  `A_Entrada_Marcada` time NOT NULL,
  `A_Salida_Marcada` time DEFAULT NULL,
  `A_TARDANZA` time NOT NULL,
  `H_Hombre` time NOT NULL,
  `id_Horario` int(11) NOT NULL,
  `id_Posicion` int(11) NOT NULL,
  `Ass_codigo` varchar(50) NOT NULL,
  `IsReemplazo` int(11) NOT NULL DEFAULT 0,
  `id_reemplazo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cashadelanto`
--

CREATE TABLE `tbl_cashadelanto` (
  `CA_id` int(11) NOT NULL,
  `CA_fecha` date NOT NULL,
  `id_empleado` varchar(8) NOT NULL,
  `CA_Precio` decimal(10,2) NOT NULL,
  `CA_Descripcion` varchar(190) NOT NULL,
  `Ass_codigo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_cashadelanto`
--

INSERT INTO `tbl_cashadelanto` (`CA_id`, `CA_fecha`, `id_empleado`, `CA_Precio`, `CA_Descripcion`, `Ass_codigo`) VALUES
(18, '2022-03-02', '78375004', '100.00', 'pa su comida :v', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detallediaempleado`
--

CREATE TABLE `tbl_detallediaempleado` (
  `id_DDE` int(11) NOT NULL,
  `De_Turno` int(11) NOT NULL,
  `id_Dia` int(11) NOT NULL,
  `Cod_Empleado` varchar(8) NOT NULL,
  `H_Entrada` time NOT NULL,
  `H_Salida` time NOT NULL,
  `De_Status` tinyint(1) NOT NULL DEFAULT 1,
  `id_DPE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalleposempleado`
--

CREATE TABLE `tbl_detalleposempleado` (
  `id_DetallePosEmp` int(11) NOT NULL,
  `id_Empleado` varchar(8) NOT NULL,
  `id_Posicion` int(11) NOT NULL,
  `DePo_FromRem` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_dia`
--

CREATE TABLE `tbl_dia` (
  `id_Dia` int(11) NOT NULL,
  `S_Cod` varchar(3) NOT NULL,
  `S_Nombre` varchar(10) NOT NULL,
  `S_NombreSpanish` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_dia`
--

INSERT INTO `tbl_dia` (`id_Dia`, `S_Cod`, `S_Nombre`, `S_NombreSpanish`) VALUES
(1, '1', 'Monday', 'Lunes'),
(2, '2', 'Tuesday', 'Martes'),
(3, '3', 'Wednesday', 'Miercoles'),
(4, '4', 'Thursday', 'Jueves'),
(5, '5', 'Friday', 'Viernes'),
(6, '6', 'Saturday', 'Sábado'),
(7, '7', 'Sunday', 'Domingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empleado`
--

CREATE TABLE `tbl_empleado` (
  `id_Empleado` int(11) NOT NULL,
  `E_Nombres` varchar(45) NOT NULL,
  `E_Apellidos` varchar(45) NOT NULL,
  `E_Direccion` varchar(100) NOT NULL,
  `E_Fecha_Nacimiento` date NOT NULL,
  `E_DNI` varchar(8) NOT NULL,
  `E_Info_Contacto` varchar(45) NOT NULL,
  `E_Genero` int(11) NOT NULL,
  `E_Created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `E_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_keypress`
--

CREATE TABLE `tbl_keypress` (
  `id` int(11) NOT NULL,
  `base64Img` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Key_number` int(11) NOT NULL,
  `KeyDescripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_posicion`
--

CREATE TABLE `tbl_posicion` (
  `id_Posicion` int(11) NOT NULL,
  `P_Descripcion` varchar(45) NOT NULL,
  `P_Tarifa` decimal(10,2) NOT NULL,
  `PosCategoria` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_posicion`
--

INSERT INTO `tbl_posicion` (`id_Posicion`, `P_Descripcion`, `P_Tarifa`, `PosCategoria`) VALUES
(16, 'SECRE', '50.00', 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_remplazos`
--

CREATE TABLE `tbl_remplazos` (
  `id_Rem` int(11) NOT NULL,
  `Rem_from` varchar(8) CHARACTER SET utf8 NOT NULL,
  `Rem_to` varchar(8) CHARACTER SET utf8 NOT NULL,
  `puesto_TO` int(11) NOT NULL,
  `puesto_From` int(11) NOT NULL,
  `Rem_disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_servicios`
--

CREATE TABLE `tbl_servicios` (
  `id_Serv` int(11) NOT NULL,
  `Serv_Descripcion` varchar(80) NOT NULL,
  `Serv_Monto` decimal(10,2) NOT NULL,
  `Ser_Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_servicios`
--

INSERT INTO `tbl_servicios` (`id_Serv`, `Serv_Descripcion`, `Serv_Monto`, `Ser_Fecha`) VALUES
(17, 'LUZ', '30.00', '2022-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_turno`
--

CREATE TABLE `tbl_turno` (
  `id_turnos` int(11) NOT NULL,
  `T_NombreTurno` varchar(45) NOT NULL,
  `T_Entrada` time NOT NULL,
  `T_Salida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_turno`
--

INSERT INTO `tbl_turno` (`id_turnos`, `T_NombreTurno`, `T_Entrada`, `T_Salida`) VALUES
(1, 'Mañanero', '07:00:00', '12:00:00'),
(2, 'Tarde', '14:00:00', '06:00:00'),
(3, 'Noche', '19:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_User` int(11) NOT NULL,
  `User_Nom` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `User_Pass` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Us_UltimoAcceso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_User`, `User_Nom`, `User_Pass`, `Us_UltimoAcceso`) VALUES
(1, 'SCRIPTNET', '$3w4UEkIvNnGk', '2022-03-03 12:31:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_asistencia`
--
ALTER TABLE `tbl_asistencia`
  ADD PRIMARY KEY (`id_Asistencia`);

--
-- Indices de la tabla `tbl_cashadelanto`
--
ALTER TABLE `tbl_cashadelanto`
  ADD PRIMARY KEY (`CA_id`);

--
-- Indices de la tabla `tbl_detallediaempleado`
--
ALTER TABLE `tbl_detallediaempleado`
  ADD PRIMARY KEY (`id_DDE`);

--
-- Indices de la tabla `tbl_detalleposempleado`
--
ALTER TABLE `tbl_detalleposempleado`
  ADD PRIMARY KEY (`id_DetallePosEmp`);

--
-- Indices de la tabla `tbl_dia`
--
ALTER TABLE `tbl_dia`
  ADD PRIMARY KEY (`id_Dia`);

--
-- Indices de la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  ADD PRIMARY KEY (`id_Empleado`);

--
-- Indices de la tabla `tbl_keypress`
--
ALTER TABLE `tbl_keypress`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_posicion`
--
ALTER TABLE `tbl_posicion`
  ADD PRIMARY KEY (`id_Posicion`);

--
-- Indices de la tabla `tbl_remplazos`
--
ALTER TABLE `tbl_remplazos`
  ADD PRIMARY KEY (`id_Rem`);

--
-- Indices de la tabla `tbl_servicios`
--
ALTER TABLE `tbl_servicios`
  ADD PRIMARY KEY (`id_Serv`);

--
-- Indices de la tabla `tbl_turno`
--
ALTER TABLE `tbl_turno`
  ADD PRIMARY KEY (`id_turnos`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_User`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_asistencia`
--
ALTER TABLE `tbl_asistencia`
  MODIFY `id_Asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_cashadelanto`
--
ALTER TABLE `tbl_cashadelanto`
  MODIFY `CA_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_detallediaempleado`
--
ALTER TABLE `tbl_detallediaempleado`
  MODIFY `id_DDE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_detalleposempleado`
--
ALTER TABLE `tbl_detalleposempleado`
  MODIFY `id_DetallePosEmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_dia`
--
ALTER TABLE `tbl_dia`
  MODIFY `id_Dia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  MODIFY `id_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tbl_keypress`
--
ALTER TABLE `tbl_keypress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_posicion`
--
ALTER TABLE `tbl_posicion`
  MODIFY `id_Posicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_remplazos`
--
ALTER TABLE `tbl_remplazos`
  MODIFY `id_Rem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_servicios`
--
ALTER TABLE `tbl_servicios`
  MODIFY `id_Serv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_turno`
--
ALTER TABLE `tbl_turno`
  MODIFY `id_turnos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
