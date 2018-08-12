-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2017 a las 17:30:17
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barber_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barberia`
--

create database barber_1;
use barber_1;

CREATE TABLE `Barberia` (
  `PkIdBarberia` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Descripcion` varchar(500) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `barberia`
--

INSERT INTO `Barberia` (`PkIdBarberia`, `Nombre`, `Descripcion`, `Estado`) VALUES
(1, 'Usuarios', 'Usuarios', 0),
(2, 'Tapia', 'Tapia', 0),
(12, 'El Barbero', 'Atenas', 1),
(13, 'Munes Tie', 'Atenas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

CREATE TABLE `Canton` (
  `PkIdCanton` int(11) NOT NULL,
  `FkIdProvinciaCanton` int(11) NOT NULL,
  `Canton` varchar(100) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `Canton` (`PkIdCanton`, `FkIdProvinciaCanton`, `Canton`, `Estado`) VALUES
(1, 1, 'Central', 1),
(2, 1, 'Escazu', 1),
(3, 1, 'Desamparados', 1),
(4, 1, 'Tarrazu', 1),
(5, 1, 'Puriscal', 1),
(6, 1, 'Aserri', 1),
(7, 1, 'Mora', 1),
(8, 1, 'Goicoechea', 1),
(9, 1, 'Santa Ana', 1),
(10, 1, 'Alajuelita', 1),
(11, 1, 'Vizquez De Coronado', 1),
(12, 1, 'Acosta', 1),
(13, 1, 'Tibas', 1),
(14, 1, 'Moravia', 1),
(15, 1, 'Montes De Oca', 1),
(16, 1, 'Turrubares', 1),
(17, 1, 'Dota', 1),
(18, 1, 'Curridabat', 1),
(19, 1, 'Perez Zeledon', 1),
(20, 1, 'Leon Cortes Castro', 1),
(21, 2, 'Central', 1),
(22, 2, 'San Ramon', 1),
(23, 2, 'Grecia', 1),
(24, 2, 'San Mateo', 1),
(25, 2, 'Atenas', 1),
(26, 2, 'Naranjo', 1),
(27, 2, 'Palmares', 1),
(28, 2, 'Poas', 1),
(29, 2, 'Orotina', 1),
(30, 2, 'San Carlos', 1),
(31, 2, 'Zarcero', 1),
(32, 2, 'Valverde Vega', 1),
(33, 2, 'Upala', 1),
(34, 2, 'Los Chiles', 1),
(35, 2, 'Guatuso', 1),
(36, 3, 'Central', 1),
(37, 3, 'Paraiso', 1),
(38, 3, 'La Union', 1),
(39, 3, 'Jimenez', 1),
(40, 3, 'Turrialba', 1),
(41, 3, 'Alvarado', 1),
(42, 3, 'Oreamuno', 1),
(43, 3, 'El Guarco', 1),
(44, 4, 'Central', 1),
(45, 4, 'Barva', 1),
(46, 4, 'Santo Domingo', 1),
(47, 4, 'Santa Barbara', 1),
(48, 4, 'San Isidro', 1),
(49, 4, 'San Rafael', 1),
(50, 4, 'Belen', 1),
(51, 4, 'Flores', 1),
(52, 4, 'San Pablo', 1),
(53, 4, 'Sarapiqui', 1),
(54, 5, 'Liberia', 1),
(55, 5, 'Nicoya', 1),
(56, 5, 'Santa Cruz', 1),
(57, 5, 'Bagaces', 1),
(58, 5, 'Carrillo', 1),
(59, 5, 'Canas', 1),
(60, 5, 'Abangares', 1),
(61, 5, 'Tilaran', 1),
(62, 5, 'Nandayure', 1),
(63, 5, 'La Cruz', 1),
(64, 5, 'Hojancha', 1),
(65, 6, 'Central', 1),
(66, 6, 'Esparza', 1),
(67, 6, 'Buenos Aires', 1),
(68, 6, 'Montes De Oro', 1),
(69, 6, 'Osa', 1),
(70, 6, 'Quepos', 1),
(71, 6, 'Golfito', 1),
(72, 6, 'Coto Brus', 1),
(73, 6, 'Parrita', 1),
(74, 6, 'Corredores', 1),
(75, 6, 'Garabito', 1),
(76, 7, 'Central', 1),
(77, 7, 'Pococi', 1),
(78, 7, 'Siquirres', 1),
(79, 7, 'Talamanca', 1),
(80, 7, 'Guacimo', 1),
(81, 7, 'Guacimo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EmailSucursal`
--

CREATE TABLE `EmailSucursal` (
  `PkIdEmailSucursal` int(11) NOT NULL,
  `FkIdSucursalBarberiaEmail` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `EmailSucursal`
--

INSERT INTO `EmailSucursal` (`PkIdEmailSucursal`, `FkIdSucursalBarberiaEmail`, `Email`, `Estado`) VALUES
(1, 2, 'rlobo1@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EmailUsuario`
--

CREATE TABLE `EmailUsuario` (
  `PkIdEmailUsuario` int(11) NOT NULL,
  `FkIdUsuarioEmail` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `EmailUsuario`
--

INSERT INTO `EmailUsuario` (`PkIdEmailUsuario`, `FkIdUsuarioEmail`, `Email`, `Estado`) VALUES
(1, 3, 'kimberlyporras@gmail.com', 1),
(2, 4, 'kimberlyporras@gmail.com', 1),
(3, 5, 'kimberlyporras@gmail.com', 1),
(12, 14, 'kimberlyporras@gmail.com', 1),
(13, 3, 'rlobo@hotmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `HorarioBarbero`
--

CREATE TABLE `HorarioBarbero` (
  `PkIdHorarioBarbero` int(11) NOT NULL,
  `FkIdUsuarioHorarioBarbero` int(11) NOT NULL,
  `Dia` varchar(30) NOT NULL,
  `HoraInicial` time NOT NULL,
  `HoraFinal` time NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `HorarioBarbero`
--

INSERT INTO `HorarioBarbero` (`PkIdHorarioBarbero`, `FkIdUsuarioHorarioBarbero`, `Dia`, `HoraInicial`, `HoraFinal`, `Estado`) VALUES
(1, 3, 'J', '06:00:00', '09:00:00', 1),
(2, 2, 'J-V-M-L', '06:00:00', '08:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PausaHorarioBarbero`
--

CREATE TABLE `PausaHorarioBarbero` (
  `PkIdPausaHorarioBarbero` int(11) NOT NULL,
  `FkIdUsuarioPausaHorarioBarbero` int(11) NOT NULL,
  `Dia` char(1) DEFAULT NULL,
  `HoraInicial` time NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `PausaHorarioBarbero`
--

INSERT INTO `PausaHorarioBarbero` (`PkIdPausaHorarioBarbero`, `FkIdUsuarioPausaHorarioBarbero`, `Dia`, `HoraInicial`, `Duracion`, `Fecha`, `Estado`) VALUES
(1, 2, 'J', '06:00:00', 90, '0000-00-00', 1),
(2, 3, 'T', '08:00:00', 90, '2017-09-13', 1),
(3, 2, 'V', '01:00:00', 90, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Provincia`
--

CREATE TABLE `Provincia` (
  `PkIdProvincia` int(11) NOT NULL,
  `Provincia` varchar(100) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Provincia`
--

INSERT INTO `Provincia` (`PkIdProvincia`, `Provincia`, `Estado`) VALUES
(1, 'San Jose', 1),
(2, 'Alajuela', 1),
(3, 'Cartago', 1),
(4, 'Heredia', 1),
(5, 'Guanacastes', 1),
(6, 'Puntarenas', 1),
(7, 'Limon', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Reserva`
--

CREATE TABLE `Reserva` (
  `PkIdReserva` int(11) NOT NULL,
  `FkIdSucursalBarberiaReserva` int(11) NOT NULL,
  `FkIdUsuarioReserva` int(11) NOT NULL,
  `FkIdUsuarioBarbero` int(11) NOT NULL,
  `FkIdServicioReserva` int(11) NOT NULL,
  `Dia` date NOT NULL,
  `HoraInicial` time NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Reserva`
--

INSERT INTO `Reserva` (`PkIdReserva`, `FkIdSucursalBarberiaReserva`, `FkIdUsuarioReserva`, `FkIdUsuarioBarbero`, `FkIdServicioReserva`, `Dia`, `HoraInicial`, `Estado`) VALUES
(4, 2, 3, 2, 1, '2017-01-08', '10:00:00', 1),
(5, 1, 2, 3, 4, '2017-01-09', '02:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Servicio`
--

CREATE TABLE `Servicio` (
  `PkIdServicio` int(11) NOT NULL,
  `FkIdUsuarioservicio` int(11) NOT NULL,
  `Descripcion` varchar(400) NOT NULL,
  `Duracion` varchar(10) NOT NULL,
  `Estado` tinyint(1) NOT NULL,
  `Precio` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Servicio`
--

INSERT INTO `Servicio` (`PkIdServicio`, `FkIdUsuarioservicio`, `Descripcion`, `Duracion`, `Estado`, `Precio`) VALUES
(1, 2, 'Corte de pelo', '20', 1, '4000.00'),
(2, 2, 'Manicure', '40', 1, '3500.00'),
(3, 2, 'Tinte pelo mediano', '60', 1, '45000.00'),
(4, 3, 'Tinte pelo corto', '60', 1, '30000.00'),
(5, 2, 'Tinte pelo corto', '45', 1, '25000.00'),
(6, 2, 'Tinte pelo largo', '60', 1, '45000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SucursalBarberia`
--

CREATE TABLE `SucursalBarberia` (
  `PkIdSucursalBarberia` int(11) NOT NULL,
  `FkIdCantonSucursalBarberia` int(11) DEFAULT NULL,
  `FkIdBarberiaSucursalBarberia` int(11) NOT NULL,
  `Descripcion` varchar(500) DEFAULT NULL,
  `DetalleDireccion` varchar(500) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `SucursalBarberia`
--

INSERT INTO `SucursalBarberia` (`PkIdSucursalBarberia`, `FkIdCantonSucursalBarberia`, `FkIdBarberiaSucursalBarberia`, `Descripcion`, `DetalleDireccion`, `Estado`) VALUES
(1, 1, 1, 'Tapia 1', 'por la escuela', 1),
(2, 2, 1, 'Sucursal Moncho', 'atras del Poli Deportivo valle esmeralda', 1),
(3, 1, 1, 'Usuarios', 'Usuarios', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TelefonoSucursal`
--

CREATE TABLE `TelefonoSucursal` (
  `PkIdTelefonoSucursal` int(11) NOT NULL,
  `FkIdSucursalBarberiaTelefono` int(11) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `TelefonoSucursal`
--

INSERT INTO `TelefonoSucursal` (`PkIdTelefonoSucursal`, `FkIdSucursalBarberiaTelefono`, `Telefono`, `Estado`) VALUES
(1, 2, 244669161, 1),
(2, 2, 830960141, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TelefonoUsuario`
--

CREATE TABLE `TelefonoUsuario` (
  `PkIdTelefonoUsuario` int(11) NOT NULL,
  `FkIdUsuarioTelefono` int(11) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `TelefonoUsuario`
--

INSERT INTO `TelefonoUsuario` (`PkIdTelefonoUsuario`, `FkIdUsuarioTelefono`, `Telefono`, `Estado`) VALUES
(1, 3, 83096014, 1),
(2, 3, 87051854, 1),
(3, 4, 83096014, 1),
(4, 4, 87051854, 1),
(5, 5, 83096014, 1),
(6, 5, 87051854, 1),
(23, 14, 83096014, 1),
(24, 14, 87051854, 1),
(25, 2, 24466916, 0),
(26, 3, 24466916, 1),
(27, 3, 24466916, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `PkIdUsuario` int(11) NOT NULL,
  `FkIdSucursalBarberiaUsuario` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `PrimerApellido` varchar(50) NOT NULL,
  `SegundoApellido` varchar(50) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Contrasenna` varchar(50) NOT NULL,
  `Tipo` char(1) NOT NULL,
  `Estado` tinyint(1) NOT NULL,
  `Rol` char(2) NOT NULL,
  `TiempoBarbero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`PkIdUsuario`, `FkIdSucursalBarberiaUsuario`, `Nombre`, `PrimerApellido`, `SegundoApellido`, `Usuario`, `Contrasenna`, `Tipo`, `Estado`, `Rol`, `TiempoBarbero`) VALUES
(2, 1, 'Ronald', 'Lobo', '', 'amor', '123', 'N', 1, 'BR', 20),
(3, 1, 'admistrador', 'lobo', 'porras', 'admin', 'admin', 'N', 1, 'A', 30),
(4, 1, 'kim', 'Porras', 'Rojas', 'admin', 'admin', 'N', 1, 'A', 30),
(5, 1, 'Rosi', 'Porras', 'Rojas', 'admin', 'admin', 'N', 1, 'A', 30),
(14, 1, 'Vicki', 'Porras', 'Rojas', 'vporras', 'admin', 'N', 1, 'A', 30);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `barberia`
--
ALTER TABLE `Barberia`
  ADD PRIMARY KEY (`PkIdBarberia`);

--
-- Indices de la tabla `canton`
--
ALTER TABLE `Canton`
  ADD PRIMARY KEY (`PkIdCanton`),
  ADD KEY `FkIdProvinciaCanton` (`FkIdProvinciaCanton`);

--
-- Indices de la tabla `EmailSucursal`
--
ALTER TABLE `EmailSucursal`
  ADD PRIMARY KEY (`PkIdEmailSucursal`),
  ADD KEY `FkIdSucursalBarberiaEmail` (`FkIdSucursalBarberiaEmail`);

--
-- Indices de la tabla `EmailUsuario`
--
ALTER TABLE `EmailUsuario`
  ADD PRIMARY KEY (`PkIdEmailUsuario`),
  ADD KEY `FkIdUsuarioEmail` (`FkIdUsuarioEmail`);

--
-- Indices de la tabla `HorarioBarbero`
--
ALTER TABLE `HorarioBarbero`
  ADD PRIMARY KEY (`PkIdHorarioBarbero`),
  ADD KEY `FkIdUsuarioHorarioBarbero` (`FkIdUsuarioHorarioBarbero`);

--
-- Indices de la tabla `PausaHorarioBarbero`
--
ALTER TABLE `PausaHorarioBarbero`
  ADD PRIMARY KEY (`PkIdPausaHorarioBarbero`),
  ADD KEY `FkIdUsuarioPausaHorarioBarbero` (`FkIdUsuarioPausaHorarioBarbero`);

--
-- Indices de la tabla `Provincia`
--
ALTER TABLE `Provincia`
  ADD PRIMARY KEY (`PkIdProvincia`);

--
-- Indices de la tabla `Reserva`
--
ALTER TABLE `Reserva`
  ADD PRIMARY KEY (`PkIdReserva`),
  ADD KEY `FkIdSucursalBarberiaReserva` (`FkIdSucursalBarberiaReserva`),
  ADD KEY `FkIdUsuarioReserva` (`FkIdUsuarioReserva`),
  ADD KEY `FkIdServicioReserva` (`FkIdServicioReserva`),
  ADD KEY `FkIdUsuarioBarbero` (`FkIdUsuarioBarbero`);

--
-- Indices de la tabla `Servicio`
--
ALTER TABLE `Servicio`
  ADD PRIMARY KEY (`PkIdServicio`),
  ADD KEY `FkIdUsuarioservicio` (`FkIdUsuarioservicio`);

--
-- Indices de la tabla `SucursalBarberia`
--
ALTER TABLE `SucursalBarberia`
  ADD PRIMARY KEY (`PkIdSucursalBarberia`),
  ADD KEY `FkIdCantonSucursalBarberia` (`FkIdCantonSucursalBarberia`),
  ADD KEY `FkIdBarberiaSucursalBarberia` (`FkIdBarberiaSucursalBarberia`);

--
-- Indices de la tabla `TelefonoSucursal`
--
ALTER TABLE `TelefonoSucursal`
  ADD PRIMARY KEY (`PkIdTelefonoSucursal`),
  ADD KEY `FkIdSucursalBarberiaTelefono` (`FkIdSucursalBarberiaTelefono`);

--
-- Indices de la tabla `TelefonoUsuario`
--
ALTER TABLE `TelefonoUsuario`
  ADD PRIMARY KEY (`PkIdTelefonoUsuario`),
  ADD KEY `FkIdUsuarioTelefono` (`FkIdUsuarioTelefono`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`PkIdUsuario`),
  ADD KEY `FkIdSucursalBarberiaUsuario` (`FkIdSucursalBarberiaUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `barberia`
--
ALTER TABLE `Barberia`
  MODIFY `PkIdBarberia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `canton`
--
ALTER TABLE `Canton`
  MODIFY `PkIdCanton` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT de la tabla `EmailSucursal`
--
ALTER TABLE `EmailSucursal`
  MODIFY `PkIdEmailSucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `EmailUsuario`
--
ALTER TABLE `EmailUsuario`
  MODIFY `PkIdEmailUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `HorarioBarbero`
--
ALTER TABLE `HorarioBarbero`
  MODIFY `PkIdHorarioBarbero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `PausaHorarioBarbero`
--
ALTER TABLE `PausaHorarioBarbero`
  MODIFY `PkIdPausaHorarioBarbero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `Provincia`
--
ALTER TABLE `Provincia`
  MODIFY `PkIdProvincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `Reserva`
--
ALTER TABLE `Reserva`
  MODIFY `PkIdReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Servicio`
--
ALTER TABLE `Servicio`
  MODIFY `PkIdServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `SucursalBarberia`
--
ALTER TABLE `SucursalBarberia`
  MODIFY `PkIdSucursalBarberia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `TelefonoSucursal`
--
ALTER TABLE `TelefonoSucursal`
  MODIFY `PkIdTelefonoSucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `TelefonoUsuario`
--
ALTER TABLE `TelefonoUsuario`
  MODIFY `PkIdTelefonoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `PkIdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canton`
--
ALTER TABLE `canton`
  ADD CONSTRAINT `FkIdProvinciaCanton` FOREIGN KEY (`FkIdProvinciaCanton`) REFERENCES `Provincia` (`PkIdProvincia`);

--
-- Filtros para la tabla `EmailSucursal`
--
ALTER TABLE `EmailSucursal`
  ADD CONSTRAINT `FkIdSucursalBarberiaEmail` FOREIGN KEY (`FkIdSucursalBarberiaEmail`) REFERENCES `SucursalBarberia` (`PkIdSucursalBarberia`);

--
-- Filtros para la tabla `EmailUsuario`
--
ALTER TABLE `EmailUsuario`
  ADD CONSTRAINT `FkIdUsuarioEmail` FOREIGN KEY (`FkIdUsuarioEmail`) REFERENCES `Usuarios` (`PkIdUsuario`);

--
-- Filtros para la tabla `HorarioBarbero`
--
ALTER TABLE `HorarioBarbero`
  ADD CONSTRAINT `FkIdUsuarioHorarioBarbero` FOREIGN KEY (`FkIdUsuarioHorarioBarbero`) REFERENCES `Usuarios` (`PkIdUsuario`);

--
-- Filtros para la tabla `PausaHorarioBarbero`
--
ALTER TABLE `PausaHorarioBarbero`
  ADD CONSTRAINT `FkIdUsuarioPausaHorarioBarbero` FOREIGN KEY (`FkIdUsuarioPausaHorarioBarbero`) REFERENCES `Usuarios` (`PkIdUsuario`);

--
-- Filtros para la tabla `Reserva`
--
ALTER TABLE `Reserva`
  ADD CONSTRAINT `FkIdServicioReserva` FOREIGN KEY (`FkIdServicioReserva`) REFERENCES `Servicio` (`PkIdServicio`),
  ADD CONSTRAINT `FkIdSucursalBarberiaReserva` FOREIGN KEY (`FkIdSucursalBarberiaReserva`) REFERENCES `SucursalBarberia` (`PkIdSucursalBarberia`),
  ADD CONSTRAINT `FkIdUsuarioBarbero` FOREIGN KEY (`FkIdUsuarioBarbero`) REFERENCES `Usuarios` (`PkIdUsuario`),
  ADD CONSTRAINT `FkIdUsuarioReserva` FOREIGN KEY (`FkIdUsuarioReserva`) REFERENCES `Usuarios` (`PkIdUsuario`);

--
-- Filtros para la tabla `Servicio`
--
ALTER TABLE `Servicio`
  ADD CONSTRAINT `FkIdUsuarioservicio` FOREIGN KEY (`FkIdUsuarioservicio`) REFERENCES `Usuarios` (`PkIdUsuario`);

--
-- Filtros para la tabla `SucursalBarberia`
--
ALTER TABLE `SucursalBarberia`
  ADD CONSTRAINT `FkIdBarberiaSucursalBarberia` FOREIGN KEY (`FkIdBarberiaSucursalBarberia`) REFERENCES `barberia` (`PkIdBarberia`),
  ADD CONSTRAINT `FkIdCantonSucursalBarberia` FOREIGN KEY (`FkIdCantonSucursalBarberia`) REFERENCES `canton` (`PkIdCanton`);

--
-- Filtros para la tabla `TelefonoSucursal`
--
ALTER TABLE `TelefonoSucursal`
  ADD CONSTRAINT `FkIdSucursalBarberiaTelefono` FOREIGN KEY (`FkIdSucursalBarberiaTelefono`) REFERENCES `SucursalBarberia` (`PkIdSucursalBarberia`);

--
-- Filtros para la tabla `TelefonoUsuario`
--
ALTER TABLE `TelefonoUsuario`
  ADD CONSTRAINT `FkIdUsuarioTelefono` FOREIGN KEY (`FkIdUsuarioTelefono`) REFERENCES `Usuarios` (`PkIdUsuario`);

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `FkIdSucursalBarberiaUsuario` FOREIGN KEY (`FkIdSucursalBarberiaUsuario`) REFERENCES `SucursalBarberia` (`PkIdSucursalBarberia`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
