-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2023 a las 23:04:58
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
(1005450340, 1057517034, 'mateo', 'salazar', 501, 'msalazar3@iear.edu.co', '3182909852', '123', 'estudiante1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `idClase` int(10) UNSIGNED NOT NULL,
  `Docente_idDocente` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Nivel` int(10) UNSIGNED DEFAULT NULL,
  `Descripcion` varchar(20) DEFAULT NULL,
  `Fecha_inicial` date DEFAULT NULL,
  `Fecha_final` date DEFAULT NULL,
  `Imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`idClase`, `Docente_idDocente`, `Nombre`, `Nivel`, `Descripcion`, `Fecha_inicial`, `Fecha_final`, `Imagen`) VALUES
(1, 1340567890, 'CLASE NUMEROS', 0, 'CLASE DE APRENDIZAJE', '2023-10-24', '2023-11-30', '6538514b02d31.jpg');

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
-- Estructura de tabla para la tabla `evaluacioninicial`
--

CREATE TABLE `evaluacioninicial` (
  `id_valuacioninicial` int(10) UNSIGNED NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Contenido` varchar(20) DEFAULT NULL,
  `Calificacion` int(10) UNSIGNED DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`Cedula`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_Alumno`),
  ADD KEY `Alumno_FKIndex2` (`administrador_Cedula`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`idClase`),
  ADD KEY `Clase_FKIndex1` (`Docente_idDocente`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`idDocente`),
  ADD KEY `Docente_FKIndex1` (`administrador_Cedula`);

--
-- Indices de la tabla `evaluacioninicial`
--
ALTER TABLE `evaluacioninicial`
  ADD PRIMARY KEY (`id_valuacioninicial`);

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
  MODIFY `idClase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `evaluacioninicial`
--
ALTER TABLE `evaluacioninicial`
  MODIFY `id_valuacioninicial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `idNotificaciones` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
