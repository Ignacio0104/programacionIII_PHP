-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2022 a las 02:29:45
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parcialcriptomonedas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `perfil_usuario` varchar(100) NOT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `mail`, `clave`, `perfil_usuario`, `fechaBaja`) VALUES
(1, 'ignacio@gmail.com', '$2y$10$iuIO5Py/BfwggQGIOZLNp.gKtCqZ5OMPvU7dJcSzo4JDC5xWupJjq', 'admin', NULL),
(2, 'pedro@gmail.com', '$2y$10$/mD1XxfJekYHu0YzOy3Ps.3qmJdNFXs4e.XgH5FwnqBdyUcuGBU2q', 'cliente', NULL),
(3, 'sebastian@gmail.com', '$2y$10$FqN432S97zh4VHb1pwiB3eflDdUO58ifqoLrickqauVp0tjYUP7WO', 'admin', NULL),
(4, 'facundo@gmail.com', '$2y$10$wlPlAeiqoTvJcO1ABGV.BeHaK5xtzMvaXpG9hkpKSKGUydxDQCVty', 'cliente', NULL),
(5, 'gonzalo@gmail.com', '$2y$10$rzFKaWADVRnMxckN0H/CneBnjzj0ML5p4erY5GR3YVrH/IqLMHg7m', 'cliente', NULL),
(6, 'peter@gmail.com', '$2y$10$CcMRsmqg6BzP0yT9Qmqp/eZCrRpE51vC1BMDzGazEhkx9hksWuCWK', 'cliente', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
