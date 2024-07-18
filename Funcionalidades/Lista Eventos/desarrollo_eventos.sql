-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2024 a las 07:02:47
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `desarrollo_eventos`
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
