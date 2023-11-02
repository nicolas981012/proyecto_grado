-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2023 a las 15:47:37
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
-- Base de datos: `proyecto_grado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `idActividad` int(10) UNSIGNED NOT NULL,
  `Clase_idClase` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(20) DEFAULT NULL,
  `objetivo` varchar(200) DEFAULT NULL,
  `tipo_actividad` varchar(200) DEFAULT NULL,
  `estado_tarea` int(3) NOT NULL,
  `estado` int(3) NOT NULL,
  `archivo` varchar(200) DEFAULT NULL,
  `calificacion` varchar(200) DEFAULT NULL,
  `comentario_docente` varchar(200) DEFAULT NULL,
  `Fecha_limite` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`idActividad`, `Clase_idClase`, `titulo`, `objetivo`, `tipo_actividad`, `estado_tarea`, `estado`, `archivo`, `calificacion`, `comentario_docente`, `Fecha_limite`) VALUES
(1, 1, 'TAREA NUMEROS', '<p>Objetivo:</p>\r\n\r\n<p>Reconocer y saber escribir los primeros numeros en ingles</p>\r\n', 'ESCRITURA', 1, 1, '', '', '', '2023-11-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `Cedula` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Apellido` varchar(20) DEFAULT NULL,
  `Correo` varchar(20) DEFAULT NULL,
  `Direccion` varchar(20) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Usuario` varchar(20) DEFAULT NULL,
  `Contrasena` varchar(20) DEFAULT NULL,
  `estado` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`Cedula`, `Nombre`, `Apellido`, `Correo`, `Direccion`, `Telefono`, `Usuario`, `Contrasena`, `estado`) VALUES
(1057517034, 'nicolas', 'pardo', 'nicolaspardo034@gmai', 'calle8#8-89', '3183322963', 'admin', '12345', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_Alumno` int(10) UNSIGNED NOT NULL,
  `administrador_Cedula` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Apellido` varchar(20) DEFAULT NULL,
  `Grado` int(10) UNSIGNED DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Contrasena` varchar(20) DEFAULT NULL,
  `Usuario` varchar(20) DEFAULT NULL,
  `estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_Alumno`, `administrador_Cedula`, `Nombre`, `Apellido`, `Grado`, `Correo`, `Telefono`, `Contrasena`, `Usuario`, `estado`) VALUES
(1005450340, 1057517034, 'mateo', 'salazar', 2, 'msalazar3@iear.edu.co', '3182909852', '123', 'estudiante1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `idClase` int(10) UNSIGNED NOT NULL,
  `Docente_idDocente` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Nivel` int(10) UNSIGNED DEFAULT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Fecha_inicial` date DEFAULT NULL,
  `Fecha_final` date DEFAULT NULL,
  `Imagen` varchar(100) NOT NULL,
  `grado` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`idClase`, `Docente_idDocente`, `Nombre`, `Nivel`, `Descripcion`, `Fecha_inicial`, `Fecha_final`, `Imagen`, `grado`) VALUES
(1, 1340567890, 'CLASE NUMEROS', 0, 'CLASE DE APRENDIZAJE', '2023-10-24', '2023-11-30', '6538514b02d31.jpg', 2),
(2, 1340567890, 'abecedario', 0, 'vamos a aprender el ', '2023-10-25', '2023-11-30', '6539a69582cff.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `idContenido` int(10) UNSIGNED NOT NULL,
  `Clase_idClase` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(20) DEFAULT NULL,
  `contenido_texto` varchar(200) DEFAULT NULL,
  `archivo` varchar(200) DEFAULT NULL,
  `estado` int(2) NOT NULL,
  `video` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`idContenido`, `Clase_idClase`, `titulo`, `contenido_texto`, `archivo`, `estado`, `video`) VALUES
(1, 1, 'Introduccion numeros', '<p>numeros del 1 al 10</p>\r\n\r\n<p><strong>1 &ndash; One</strong><br />\r\n<strong>2 &ndash; Two</strong><br />\r\n<strong>3 &ndash; Three</strong><br />\r\n<strong>4 &ndash; Four</strong><br />\r\n<strong>5 &n', '653a92ac7951b.docx', 1, 'https://www.youtube.com/embed/b02Ojls1O14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `idDocente` int(10) UNSIGNED NOT NULL,
  `administrador_Cedula` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Apellido` varchar(20) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Correo` varchar(20) DEFAULT NULL,
  `Usuario` varchar(20) NOT NULL,
  `Contrasena` varchar(20) NOT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`idDocente`, `administrador_Cedula`, `Nombre`, `Apellido`, `Telefono`, `Correo`, `Usuario`, `Contrasena`, `estado`) VALUES
(1340567890, 1057517034, 'benito', 'baron', '3156784587', 'profebenito@iear.com', 'docente1', '12345', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE `grado` (
  `id_grado` int(10) UNSIGNED NOT NULL,
  `Grado_numerico` varchar(20) DEFAULT NULL,
  `Grado_letra` varchar(20) DEFAULT NULL,
  `estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `grado`
--

INSERT INTO `grado` (`id_grado`, `Grado_numerico`, `Grado_letra`, `estado`) VALUES
(1, '401', 'CUARTO-UNO', 1),
(2, '501', 'QUINTO-UNO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `idNotificaciones` int(10) UNSIGNED NOT NULL,
  `Clase_idClase` int(10) UNSIGNED NOT NULL,
  `Asunto` varchar(200) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Mensaje` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`idNotificaciones`, `Clase_idClase`, `Asunto`, `Fecha`, `Mensaje`) VALUES
(1, 1, 'No empezar Clase aun', '2023-10-26', 'por favor no ingresar a contenido de la clase ya que se actualizara este');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

CREATE TABLE `progreso` (
  `Alumno_id_Alumno` int(10) UNSIGNED NOT NULL,
  `Clase_idClase` int(10) UNSIGNED NOT NULL,
  `Calificacion` int(10) UNSIGNED DEFAULT NULL,
  `Comentario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD KEY `actividad_FKIndex2` (`Clase_idClase`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`Cedula`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_Alumno`),
  ADD KEY `Alumno_FKIndex2` (`administrador_Cedula`),
  ADD KEY `grado_FKIndex3` (`Grado`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`idClase`),
  ADD KEY `Clase_FKIndex1` (`Docente_idDocente`) USING BTREE,
  ADD KEY `clase_FKIndex3` (`grado`);

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`idContenido`),
  ADD KEY `contenido_clase` (`Clase_idClase`) USING BTREE;

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`idDocente`),
  ADD KEY `Docente_FKIndex1` (`administrador_Cedula`);

--
-- Indices de la tabla `grado`
--
ALTER TABLE `grado`
  ADD PRIMARY KEY (`id_grado`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`idNotificaciones`),
  ADD KEY `Notificaciones_FKIndex1` (`Clase_idClase`);

--
-- Indices de la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD PRIMARY KEY (`Alumno_id_Alumno`,`Clase_idClase`),
  ADD KEY `Alumno_has_Clase_FKIndex1` (`Alumno_id_Alumno`),
  ADD KEY `Alumno_has_Clase_FKIndex2` (`Clase_idClase`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `Cedula` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1057517035;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `idClase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `idNotificaciones` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`Clase_idClase`) REFERENCES `clase` (`idClase`);

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`administrador_Cedula`) REFERENCES `administrador` (`Cedula`),
  ADD CONSTRAINT `alumno_ibfk_2` FOREIGN KEY (`Grado`) REFERENCES `grado` (`id_grado`);

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `clase_ibfk_1` FOREIGN KEY (`Docente_idDocente`) REFERENCES `docente` (`idDocente`),
  ADD CONSTRAINT `clase_ibfk_2` FOREIGN KEY (`grado`) REFERENCES `grado` (`id_grado`);

--
-- Filtros para la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD CONSTRAINT `contenido_ibfk_1` FOREIGN KEY (`Clase_idClase`) REFERENCES `clase` (`idClase`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`administrador_Cedula`) REFERENCES `administrador` (`Cedula`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`Clase_idClase`) REFERENCES `clase` (`idClase`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
