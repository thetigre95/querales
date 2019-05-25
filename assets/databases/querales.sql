-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2019 a las 18:41:26
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `querales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`id`, `nombre`, `estatus`) VALUES
(1, 'Provincial', 1),
(2, 'Bicentenario', 1),
(3, 'Venezuela', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cedula` varchar(12) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1',
  `telefono` varchar(14) DEFAULT NULL,
  `nivel` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cedula`, `nombres`, `apellidos`, `direccion`, `estatus`, `telefono`, `nivel`) VALUES
('17034662', 'JESUS EDUARDO', 'YANEZ BRACHO', 'EDO. LARAMP. URDANETAPQ. SAN MIGUEL', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `cedula` int(11) NOT NULL,
  `cuenta` varchar(30) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `banco` int(11) NOT NULL,
  `pago_movil` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `nombre`, `cedula`, `cuenta`, `telefono`, `banco`, `pago_movil`) VALUES
(1, 'williams querales', 11877172, '01082427390100009100', '04165529945', 1, 0),
(2, 'williams querales', 24928137, '01082427350100080980', '04245308470', 1, 0),
(3, 'Mary Yanez', 12706065, '01750337570061101094', '04264585380', 2, 0),
(4, 'Mary Yanez', 12706065, '01020343150000315300', '04264585380', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencia`
--

CREATE TABLE `transferencia` (
  `id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cedula` varchar(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `monto` float NOT NULL,
  `banco` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transferencia`
--

INSERT INTO `transferencia` (`id`, `fecha`, `cedula`, `nombre`, `monto`, `banco`, `cuenta`, `estatus`) VALUES
(1, '2019-05-02 04:45:45', '25747027', 'luis querales', 30000, 2, 1, 1),
(2, '2019-05-02 04:46:13', '25747027', 'luis querales', 20000, 2, 2, 2),
(3, '2019-05-03 04:45:45', '25747027', 'luis querales', 30000, 2, 2, 1),
(21, '2019-05-19 05:18:43', '21211212', 'dianna', 1141, 1, 1, 1),
(22, '2019-05-19 05:19:17', '19431295', 'jose', 23131, 1, 1, 1),
(23, '2019-05-19 05:20:39', '12', 'jose', 213141, 1, 2, 1),
(24, '2019-05-19 05:21:49', '121324245', 'jose', 541451, 1, 1, 2),
(25, '2019-05-19 05:22:27', '32', 'asd', 1213, 1, 1, 1),
(26, '2019-05-19 05:23:06', '7391002', 'af', 134134, 1, 2, 1),
(27, '2019-05-19 05:25:08', '7391002', 'jose', 131314, 1, 1, 1),
(28, '2019-05-19 05:25:30', '19431295', 'julio', 4546, 1, 1, 2),
(29, '2019-05-19 06:02:35', '1212', 'julio', 2121, 1, 1, 1),
(30, '2019-05-19 06:03:20', '121313', 'jose', 121212, 1, 1, 1),
(31, '2019-05-19 06:04:00', '22323', 'adsfaff', 232423, 1, 1, 2),
(32, '2019-05-19 06:06:35', '7391002', 'asad', 312, 2, 3, 1),
(33, '2019-05-19 06:12:52', '11', 'jose', 212, 1, 1, 1),
(34, '2019-05-19 06:13:37', '7391002', 'asas', 2131, 1, 1, 2),
(35, '2019-05-19 06:19:00', '7391002', 'asas', 1313, 2, 3, 2),
(36, '2019-05-19 06:22:02', '24928137', 'jose', 1231, 1, 1, 1),
(37, '2019-05-19 06:49:59', '24550293', 'jose', 13131, 1, 1, 2),
(38, '2019-05-19 07:01:00', '24550293', 'jose', 2000, 1, 1, 2),
(39, '2019-05-19 07:02:44', '11877172', 'sfgsg', 1213, 1, 2, 1),
(40, '2019-05-19 07:10:19', '131212', 'jose', 1212, 1, 1, 1),
(41, '2019-05-19 13:26:12', '24550293', 'jose', 1213, 2, 3, 2),
(42, '2019-05-19 13:52:39', '26398738', 'cheja', 2000, 1, 2, 2),
(43, '2019-05-19 14:33:26', '17034662', 'jose ', 1213, 1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_banco_titular` (`banco`);

--
-- Indices de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transferencia_cuenta` (`cuenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `FK_banco_titular` FOREIGN KEY (`banco`) REFERENCES `banco` (`id`);

--
-- Filtros para la tabla `transferencia`
--
ALTER TABLE `transferencia`
  ADD CONSTRAINT `fk_transferencia_cuenta` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
