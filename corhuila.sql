-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2024 a las 15:32:39
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
-- Base de datos: `corhuila`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `iniciador` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `ubicacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `titulo`, `iniciador`, `cargo`, `descripcion`, `fecha`, `hora`, `ubicacion`) VALUES
(84, 'Emprendimiento ', 'Andrés Calderón Osorio', 'Administrativo TIC', 'Exposición de proyectos innovadores de estudiantes y personal administrativo de la CORHUILA ', '2024-07-24', '10:30:00', 'Área TIC'),
(85, 'Actividad deportiva ', 'Andrés Calderón Osorio', 'Administrativo TIC', 'Campeonato de futbol institucional ', '2024-07-24', '08:30:00', 'Cancha sintética '),
(86, 'Fiesta sampedrina ', 'Andrés Calderón Osorio', 'Administrativo TIC', 'Actividad cultural desarrollada para fortalecer la sociabilidad entre las diferentes grupos administrativos de la CORHUILA ', '2024-07-24', '08:30:00', 'Cancha principal sede quirinal '),
(87, 'Graduación de estudiantes ', 'Andrés Calderón Osorio', 'Administrativo TIC', 'Celebración de  graduación de los nuevos profesionales de ingeniería  ', '2024-07-24', '08:30:00', 'Cancha principal quirinal ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id_participante` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `identificación` varchar(50) NOT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `participantes`
--

INSERT INTO `participantes` (`id_participante`, `id_evento`, `nombre`, `identificación`, `correo`) VALUES
(82, 84, 'Andres Calderon ', '5862345', 'agco7331@gmail.com'),
(83, 84, 'Edgar Calderon', '23435456', 'edgar@gmail.com'),
(84, 84, 'Patricia Calderón Osorio', '2378546', 'patricia@gmail.com'),
(85, 84, 'Jesús Calderón ', '5634786', 'jesus@gmail.com'),
(86, 84, 'Emiliano Calderon', '34563467', 'emiliano@gmail.com'),
(87, 84, 'Yorleny Osorio ', '436345647', 'yorleny@gmail.com'),
(88, 85, 'Andres Calderon ', '3425236543', 'agco7331@gmail.com'),
(89, 86, 'Andrés Calderón Osorio ', '23465376', 'agco7331@gmail.com'),
(90, 87, 'Andrés Calderón Osorio ', '34634675', 'agco7331@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `identificacion` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `sexo` enum('Masculino','Femenino','Otro') NOT NULL,
  `cargo` enum('Estudiante','Profesor','Externo','Administrativo') NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `hora_ingreso` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `edad`, `identificacion`, `telefono`, `sexo`, `cargo`, `ubicacion`, `correo`, `fecha_ingreso`, `hora_ingreso`, `fecha_salida`, `hora_salida`, `contrasena`) VALUES
(165, 'Andres Calderon ', 22, '23243535345', '3144863036', 'Masculino', 'Externo', 'Cancha sintética ', 'paesd@gmail.com', '2024-07-11', '17:38:00', '2024-07-11', '17:38:00', NULL),
(166, 'Patricia Calderon', 32, '11342354', '3144863036', 'Masculino', 'Administrativo', 'Cancha sintética ', 'agco7331@gmail.com', '2024-07-11', '17:43:00', '2024-07-11', '17:43:00', '$2y$10$y0RUgY4ObDSSsGOvMlr5m.JbIZNVjwksPX4OHi9lF01gdcRlIm/Be'),
(167, 'Edgar Calderón ', 50, '3234', '3144663033', 'Masculino', 'Externo', 'cancha princial quirinal ', 'mila@gmail.com', '2024-07-12', '07:17:00', '2024-07-12', '07:17:00', NULL),
(169, 'Yorleny Osorio ', 34, '242423', '3144663033', 'Femenino', 'Externo', 'cancha princial quirinal ', 'yorleny|@gmail.com', '2024-07-17', '11:44:00', '2024-07-17', '11:44:00', NULL),
(175, 'Andres Calderon ', 33, '23243535', '31446630', 'Masculino', 'Profesor', 'Cancha sintética ', 'EYY@GMAIL.COM', '2024-07-23', '16:25:00', '2024-07-23', '16:25:00', '$2y$10$gayUa9F9gvQhcZclws741.Zn.aNqvOHbDJwaanKTuxJ/zokSrG9ae');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id_participante`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id_participante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
