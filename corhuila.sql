-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2024 a las 00:28:01
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
(21, 'Emprendimiento', 'Andrés Calderón', 'Administrativo TIC', 'Exposición de proyectos', '2024-07-11', '22:46:00', 'cancha princial quirinal'),
(22, 'Actividad cultural ', 'Andrés Calderón ', 'Administrativo TIC', 'Fiesta sampedrina ', '2024-07-17', '10:30:00', 'cancha princial quirinal '),
(23, 'Evento deportivo ', 'Andrés Calderón Osorio', 'Administrativo TIC', 'Campeonato de micro ', '2024-07-17', '18:30:00', 'cancha princial quirinal '),
(24, 'Evento deportivo ', 'Andrés Calderón Osorio', 'Administrativo TIC', 'Campeonato de Ajedrez ', '2024-08-03', '07:30:00', 'Sede quirinal '),
(26, 'Actividad deportiva ', 'Andrés Calderón', 'Administrativo TIC', 'Campeonato de Vóleibol ', '2024-07-18', '07:30:00', 'Cancha principal sede quirinal'),
(27, 'Evento institucional ', 'Andrés Calderón', 'Administrativo TIC', 'Exposición de programas de formación ', '2024-07-20', '08:30:00', 'Sede quirinal ');

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
(59, 21, 'Patricia Calderon', '2386452747', 'pato@gmail.com'),
(60, 21, 'Edgar Calderon', '23435456', 'elmejor@gmail.com'),
(61, 21, 'Yorleny Osorio ', '18327497', 'lamejor@gmail.com'),
(62, 21, 'Jesús  Calderon', '483943543', 'jesus@gmail.com'),
(63, 22, 'Patricia Calderón ', '2343545', 'pablo@gmail.com'),
(64, 21, 'Emiliano Calderon', '5546545465', 'agco7331@gmail.com');

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
(165, 'Andres Calderon ', 22, '23243535345', '3144863036', 'Masculino', 'Estudiante', 'Cancha sintética ', 'paesd@gmail.com', '2024-07-11', '17:38:00', '2024-07-11', '17:38:00', NULL),
(166, 'Patricia Calderon', 32, '11342354', '3144863036', 'Masculino', 'Administrativo', 'Cancha sintética ', 'agco7331@gmail.com', '2024-07-11', '17:43:00', '2024-07-11', '17:43:00', '$2y$10$y0RUgY4ObDSSsGOvMlr5m.JbIZNVjwksPX4OHi9lF01gdcRlIm/Be'),
(167, 'Edgar Calderón ', 50, '3234', '3144663033', 'Masculino', 'Externo', 'cancha princial quirinal ', 'mila@gmail.com', '2024-07-12', '07:17:00', '2024-07-12', '07:17:00', NULL),
(169, 'Yorleny Osorio ', 34, '242423', '3144663033', 'Femenino', 'Externo', 'cancha princial quirinal ', 'yorleny|@gmail.com', '2024-07-17', '11:44:00', '2024-07-17', '11:44:00', NULL),
(171, 'Emiliano Calderon', 6, '4567489', '3132014205', 'Masculino', 'Estudiante', 'Cancha sintética ', 'emiliano@gmail.com', '2024-07-17', '11:46:00', '2024-07-17', '11:46:00', NULL);

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
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id_participante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

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
