-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2022 a las 02:29:20
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
-- Estructura de tabla para la tabla `criptomonedas`
--

CREATE TABLE `criptomonedas` (
  `id` int(11) NOT NULL,
  `precio` float NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `URLImagen` varchar(8000) NOT NULL,
  `nacionalidad` varchar(250) NOT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `criptomonedas`
--

INSERT INTO `criptomonedas` (`id`, `precio`, `nombre`, `URLImagen`, `nacionalidad`, `fechaBaja`) VALUES
(1003, 17000, 'Bitcoin', '.\\fotosCripto\\\\bitcoin.png', 'China', NULL),
(1004, 1500, 'Ethereum', '.\\fotosCripto\\\\ETHEREUM.jpg', 'Rusia', NULL),
(1005, 119, 'Solana', '.\\fotosCripto\\\\Solana.png', 'Espana', NULL),
(1006, 1, 'USDT', '.\\fotosCripto\\\\USDT.png', 'USA', NULL),
(1007, 1, 'USDC', '.\\fotosCripto\\\\usdc.png', 'USA', NULL),
(1008, 1, 'USDC', '.\\fotosCripto\\\\usdc.png', 'USA', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `criptomonedas`
--
ALTER TABLE `criptomonedas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `criptomonedas`
--
ALTER TABLE `criptomonedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
