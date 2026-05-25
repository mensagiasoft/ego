-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-05-2026 a las 02:29:05
-- Versión del servidor: 8.0.45-36
-- Versión de PHP: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juanvil2_ego_salon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int NOT NULL,
  `fecha` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bloqueo` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `fecha`, `bloqueo`) VALUES
(1, '2026-03-01', 0),
(2, '2026-04-02', 1),
(3, '2026-04-05', 1),
(4, '2026-04-09', 1),
(6, '2026-04-04', 0),
(7, '2026-04-06', 0),
(8, '2026-04-08', 0),
(9, '2026-05-03', 0),
(10, '2026-05-04', 0),
(11, '2026-05-08', 0),
(12, '2026-05-17', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_productos`
--

CREATE TABLE `servicios_productos` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `tipo` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `porcentaje` int NOT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_productos`
--

INSERT INTO `servicios_productos` (`id`, `nombre`, `descripcion`, `monto`, `tipo`, `porcentaje`, `estado`) VALUES
(1, 'Corte de dama', 'Corte de dama', 20, 's', 50, 1),
(2, 'Corte de caballero', 'Corte de caballero', 20, 's', 50, 1),
(3, 'Corte de niño', 'Corte de niño', 20, 's', 50, 1),
(4, 'Cepillado o planchado', 'Cepillado o planchado', 40, 's', 40, 1),
(5, 'Tinte de crecimiento', 'Tinte de crecimiento', 80, 's', 40, 1),
(6, 'Tinte  color entero', 'Tinte  color entero', 120, 's', 40, 1),
(7, 'Baño de color', 'Baño de color', 80, 's', 40, 1),
(8, 'Mechas clásicas', 'Mechas clásicas', 200, 's', 40, 1),
(9, 'Mechas en tendencia', 'Mechas en tendencia', 350, 's', 40, 1),
(10, 'Peinado básico', 'Peinado básico', 60, 's', 40, 1),
(11, 'Botox anti Freeze', 'Botox anti Freeze', 150, 's', 40, 1),
(12, 'Botox hidratante', 'Botox hidratante', 100, 's', 40, 1),
(13, 'Tratamiento hidratante', 'Tratamiento hidratante', 50, 's', 40, 1),
(14, 'Alisado permanente', 'Alisado permanente', 300, 's', 40, 1),
(15, 'Alisado  semipermanente', 'Alisado  semipermanente', 200, 's', 40, 1),
(16, 'Planchado de cejas', 'Planchado de cejas', 40, 's', 40, 1),
(17, 'Lifting de pestañas', 'Lifting de pestañas', 40, 's', 40, 1),
(18, 'Pestañas  1 × 1', 'Pestañas  1 × 1', 35, 's', 40, 1),
(19, 'Depilación de cejas con hilo', 'Depilación de cejas con hilo', 10, 's', 50, 1),
(20, 'Depilación de bozo con hilo', 'Depilación de bozo con hilo', 10, 's', 50, 1),
(21, 'Depilación de rostro con hilo', 'Depilación de rostro con hilo', 30, 's', 50, 1),
(22, 'Depilación de cejas con cera', 'Depilación de cejas con cera', 15, 's', 40, 1),
(23, 'Depilación de bozo con cera', 'Depilación de bozo con cera', 15, 's', 40, 1),
(24, 'Depilación de rostro con cera', 'Depilación de rostro con cera', 40, 's', 40, 1),
(25, 'Depilación de ceja con navaja', 'Depilación de ceja con navaja', 10, 's', 50, 1),
(26, 'Maquillaje profesional', 'Maquillaje profesional', 80, 's', 40, 1),
(27, 'Maquillaje básico', 'Maquillaje básico', 40, 's', 40, 1),
(28, 'Decapage', 'Decapage', 150, 's', 40, 1),
(29, 'Tratamiento de células madres', 'Tratamiento de células madres', 80, 's', 40, 1),
(30, 'tratamiento de fuerza', 'tratamiento de fuerza', 80, 's', 40, 1),
(31, 'Tratamiento detox', 'Tratamiento detox', 60, 's', 40, 1),
(32, 'Aplicación de tinte', 'Aplicación de tinte', 30, 's', 40, 1),
(33, 'Manicure clásica', 'Manicure clásica', 20, 's', 40, 1),
(34, 'Permanente', 'Permanente', 80, 's', 40, 1),
(35, 'Shampoo Alfaparf', 'Shampoo Alfaparf', 70, 'p', 40, 1),
(36, 'Mascarilla Alfaparf', 'Mascarilla Alfaparf', 80, 'p', 40, 1),
(37, 'Kit Alfaparf', 'Kit Alfaparf', 150, 'p', 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_detalle`
--

CREATE TABLE `servicio_detalle` (
  `id` int NOT NULL,
  `id_detalle` int NOT NULL,
  `tipo_servicio` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `servicio` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `tipo_pago` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `persona` int DEFAULT NULL,
  `id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio_detalle`
--

INSERT INTO `servicio_detalle` (`id`, `id_detalle`, `tipo_servicio`, `servicio`, `monto`, `tipo_pago`, `persona`, `id_usuario`) VALUES
(2, 1, 'i', '9', 250.00, 'y', 1, 1),
(3, 1, 'i', '5', 80.00, 'e', 1, 1),
(4, 1, 'i', '2', 20.00, 'y', 2, 1),
(6, 1, 'i', '1', 20.00, 'e', 1, 2),
(7, 1, 'i', '21', 20.00, 'e', 1, 2),
(7, 2, 'i', '21', 40.00, 'y', 1, 2),
(8, 1, 'i', '2', 20.00, 'y', 1, 2),
(9, 1, 'i', '12', 100.00, 'e', 1, 2),
(10, 1, 'i', '29', 80.00, 'e', 1, 2),
(11, 1, 'i', '2', 20.00, 'y', 2, 1),
(11, 2, 'i', '4', 40.00, 'e', 1, 1),
(11, 3, 'i', '2', 20.00, 'e', 2, 1),
(11, 4, 'i', '6', 120.00, 'y', 1, 1),
(11, 5, 'i', '16', 20.00, 'y', 1, 1),
(11, 6, 'i', '1', 20.00, 'y', 1, 1),
(11, 7, 'i', '1', 30.00, 'y', 1, 1),
(12, 1, 'i', '2', 20.00, 'y', 2, 2),
(12, 2, 'i', '2', 20.00, 'y', 2, 2),
(12, 3, 'i', '2', 20.00, 'e', 2, 2),
(12, 4, 'i', '1', 20.00, 'y', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`) VALUES
(1, 'steffi', 'b2f2f5251d21ad0b20683761ce5cf0ae', 'Steffi Somoza'),
(2, 'martha', 'c9e5e65f64266ff3a84bb563b6df9da5', 'Martha Lozano');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicio_detalle`
--
ALTER TABLE `servicio_detalle`
  ADD PRIMARY KEY (`id`,`id_detalle`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
