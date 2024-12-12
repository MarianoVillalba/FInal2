-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 22:25:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examenfinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclista`
--

CREATE TABLE `ciclista` (
  `CiclistaID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Fecha_Nac` date NOT NULL,
  `Nacionalidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclista`
--

INSERT INTO `ciclista` (`CiclistaID`, `Nombre`, `Fecha_Nac`, `Nacionalidad`) VALUES
(1, 'Juan Pérez', '1990-05-14', 'España'),
(2, 'Luis Martínez', '1987-09-23', 'México'),
(3, 'Ana García', '1995-03-10', 'Colombia'),
(4, 'Carlos Fernández', '2000-01-18', 'Argentina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `EquipoID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Nacionalidad` varchar(50) NOT NULL,
  `Direccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`EquipoID`, `Nombre`, `Nacionalidad`, `Direccion`) VALUES
(1, 'Team A', 'España', 'Calle Sol, 123'),
(2, 'Team B', 'Colombia', 'Av. Luna, 456'),
(3, 'Team C', 'México', 'Plaza Estrella, 789'),
(4, 'Team D', 'Argentina', 'Boulevard Sur, 101');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participa`
--

CREATE TABLE `participa` (
  `PruebaID` int(11) NOT NULL,
  `CiclistaID` int(11) NOT NULL,
  `EquipoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `participa`
--

INSERT INTO `participa` (`PruebaID`, `CiclistaID`, `EquipoID`) VALUES
(1, 1, 1),
(1, 4, 4),
(2, 2, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertenece`
--

CREATE TABLE `pertenece` (
  `CiclistaID` int(11) NOT NULL,
  `EquipoID` int(11) NOT NULL,
  `Fec_Inicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pertenece`
--

INSERT INTO `pertenece` (`CiclistaID`, `EquipoID`, `Fec_Inicio`) VALUES
(1, 1, '2020-01-01'),
(2, 2, '2018-03-15'),
(3, 3, '2019-06-20'),
(4, 4, '2021-02-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `PruebaID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `AñoEdic` int(11) NOT NULL,
  `NumEtapa` int(11) NOT NULL,
  `Ganador` varchar(100) DEFAULT NULL,
  `Fin_del_Contrato` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`PruebaID`, `Nombre`, `AñoEdic`, `NumEtapa`, `Ganador`, `Fin_del_Contrato`) VALUES
(1, 'Tour de Francia', 2023, 21, 'Juan Pérez', '2023-07-31'),
(2, 'Giro de Italia', 2022, 18, 'Luis Martínez', '2022-06-15'),
(3, 'Vuelta a España', 2021, 20, 'Ana García', '2021-09-25');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciclista`
--
ALTER TABLE `ciclista`
  ADD PRIMARY KEY (`CiclistaID`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`EquipoID`);

--
-- Indices de la tabla `participa`
--
ALTER TABLE `participa`
  ADD PRIMARY KEY (`PruebaID`,`CiclistaID`,`EquipoID`),
  ADD KEY `CiclistaID` (`CiclistaID`),
  ADD KEY `EquipoID` (`EquipoID`);

--
-- Indices de la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD PRIMARY KEY (`CiclistaID`,`EquipoID`),
  ADD KEY `EquipoID` (`EquipoID`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`PruebaID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciclista`
--
ALTER TABLE `ciclista`
  MODIFY `CiclistaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `EquipoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `PruebaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `participa`
--
ALTER TABLE `participa`
  ADD CONSTRAINT `participa_ibfk_1` FOREIGN KEY (`PruebaID`) REFERENCES `prueba` (`PruebaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participa_ibfk_2` FOREIGN KEY (`CiclistaID`) REFERENCES `ciclista` (`CiclistaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participa_ibfk_3` FOREIGN KEY (`EquipoID`) REFERENCES `equipo` (`EquipoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD CONSTRAINT `pertenece_ibfk_1` FOREIGN KEY (`CiclistaID`) REFERENCES `ciclista` (`CiclistaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pertenece_ibfk_2` FOREIGN KEY (`EquipoID`) REFERENCES `equipo` (`EquipoID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
