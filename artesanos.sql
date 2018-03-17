-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2017 a las 23:37:18
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `artesanos`
--
CREATE DATABASE IF NOT EXISTS `artesanos` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `artesanos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

CREATE TABLE `albums` (
  `idalbums` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tituloalbum` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `albums`
--

INSERT INTO `albums` (`idalbums`, `idusuario`, `tituloalbum`) VALUES
(69, 35, 'jmrel22'),
(70, 36, 'lu23'),
(71, 37, 'Dorian'),
(72, 38, 'Marcelo'),
(73, 35, 'Musica'),
(74, 35, 'Imagenes'),
(75, 36, 'Guitarras'),
(76, 36, 'Instrumentos'),
(77, 37, 'cuadros-africanos-tripticos'),
(78, 37, 'Cuadros Modernos'),
(79, 36, 'batas'),
(80, 37, ' Cuadros Minimalistas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idcomentario` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idfoto` int(11) NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idcomentario`, `idusuario`, `idfoto`, `comentario`, `fecha`) VALUES
(107, 37, 27, 'Cuadro', '2017-11-17  a las 20:12'),
(110, 37, 11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui in voluptas nemo, minus, ab animi quod ', '2017-11-17  a las 20:16'),
(111, 37, 11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui in voluptas nemo, minus, ab animi quod ', '2017-11-17  a las 20:16'),
(112, 37, 11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui in voluptas nemo, minus, ab animi quod Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui in voluptas nemo, minus, ab animi quod Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui in voluptas nemo, minus, ab animi quod ', '2017-11-17  a las 20:16'),
(113, 37, 11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui in voluptas nemo, minus, ab animi quod ', '2017-11-17  a las 20:16'),
(114, 35, 36, 'GGGFF', '2017-11-17  a las 22:01'),
(115, 35, 36, 'sal', '2017-11-17  a las 22:02'),
(116, 35, 36, 'kl', '2017-11-17  a las 22:02'),
(117, 35, 10, 'hola', '2017-11-17  a las 22:07'),
(118, 35, 33, 'asld', '2017-11-17  a las 22:09'),
(119, 35, 15, 'jj', '2017-11-17  a las 23:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `idfoto` int(11) NOT NULL,
  `titulofoto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `privacidad` int(11) NOT NULL,
  `urlfoto` varchar(2000) COLLATE utf8_spanish_ci NOT NULL,
  `idalbum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`idfoto`, `titulofoto`, `privacidad`, `urlfoto`, `idalbum`) VALUES
(7, '99', 1, 'img/35/73/4images.jpg', 73),
(8, '', 1, 'img/35/73/5descarga (1).jpg', 73),
(9, 'ska', 1, 'img/35/73/6images (1).jpg', 73),
(10, 'fondo1', 1, 'img/35/74/3images (2).jpg', 74),
(11, '2', 0, 'img/35/74/4fondo.jpg', 74),
(12, '1', 1, 'img/36/75/5descarga (1).jpg', 75),
(13, '2', 1, 'img/36/75/6descarga (2).jpg', 75),
(14, '3', 1, 'img/36/75/7images (1).jpg', 75),
(15, '4', 1, 'img/36/75/8images.jpg', 75),
(16, '5', 1, 'img/36/75/5images (2).jpg', 75),
(17, '1Âº Encuentro de luthiers y fabricantes', 1, 'img/36/76/3D_Q_NP_401225-MLA25403064857_022017-Q.jpg', 76),
(18, 'bongos', 1, 'img/36/76/4images.jpg', 76),
(19, 'instrumentos-musicales', 1, 'img/36/76/3instrumentos-musicales.jpg', 76),
(20, 'ethnicos', 1, 'img/37/77/5dd9b9fff9a7166eb6af4a42afb7ad434.jpg', 77),
(23, 'Buy Cheap Paintings', 1, 'img/37/77/8hand-painted-wall-art-sunrise-african-tribes.jpg', 77),
(25, 'Wooden Framed Handpainted', 1, 'img/37/77/3Framed-3-piece-canvas-wall-art-handpainted-home-decoration-landscape-oil-painting-Free-Shipping-.jpg', 77),
(26, 'Quadro Decorativo Flores/Florais', 1, 'img/37/77/4400-12ba03702e57fb080914848628851648-1024-1024.jpg', 77),
(27, 'Cuadros Modernos', 1, 'img/37/78/2MF-011.jpg', 78),
(28, 'Acheter Triptyque', 1, 'img/37/78/2Triptyque-Diamant-broderie-paysage-rouge-arbre-5d-bricolage-diamant-peinture-3d-diamant-image-De-point-de.jpg_640x640.jpg', 78),
(30, '2017 Modern Beautiful ', 1, 'img/37/78/3modern-beautiful-oil-paintings-pretty-different.jpg', 78),
(31, ' Buy Home Decor', 1, 'img/37/78/4Home-Decor-Hand-Painted-Red-Love-Heart-Butterfly-Oil-Painting-For-Living-Room-Wall-Pictures-5.jpg_640x640.jpg', 78),
(32, 'Especial BaterÃ­as AcÃºsticas', 1, 'img/36/79/3descarga.jpg', 79),
(33, 'BaterÃ­as - BaterÃ­as acÃºsticas', 1, 'img/36/79/4drum_sets_1200x480_3ce2628c7f936e1098b50a4259e42be0.jpg', 79),
(34, ' Decoracion Nordica ', 1, 'img/37/80/3decoracion_nordica_Cuadro_Winter_ml.jpg', 80),
(35, ' GALERIA W CHMURACH', 1, 'img/37/80/4obraz-do-salonu-styl-skandynawski.jpg', 80),
(36, '22cranes', 1, 'img/37/80/3galeria-sztuki[2].jpg', 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialfoto`
--

CREATE TABLE `historialfoto` (
  `idfoto` int(11) NOT NULL,
  `urlfoto` varchar(2000) COLLATE utf8_spanish_ci NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `historialfoto`
--

INSERT INTO `historialfoto` (`idfoto`, `urlfoto`, `idusuario`) VALUES
(30, 'img/perfiles/35 0.jpg', 35),
(31, 'img/perfiles/37 0.jpg', 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguidores`
--

CREATE TABLE `seguidores` (
  `idseguidor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `seguidores`
--

INSERT INTO `seguidores` (`idseguidor`, `idusuario`) VALUES
(35, 36),
(35, 37),
(36, 37),
(37, 35),
(37, 36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `idseguidor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`idseguidor`, `idusuario`) VALUES
(35, 38),
(37, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `contrasena` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `antecedentes` text COLLATE utf8_spanish_ci NOT NULL,
  `intereses` text COLLATE utf8_spanish_ci NOT NULL,
  `fotoperfil` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `contrasena`, `nombre`, `nombre_usuario`, `email`, `antecedentes`, `intereses`, `fotoperfil`) VALUES
(35, ' ,¹b¬Y[–K-#Kp', 'Juan M', 'jmrel22', 'jmr_122@hotmail.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus eos aspernatur praesentium tenetur natus dignissimos? Incidunt alias, quos, iure dicta ea dolores praesentium cumque, reiciendis fugiat tempore nulla expedita.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus eos aspernatur praesentium tenetur natus dignissimos? Incidunt alias, quos, iure dicta ea dolores praesentium cumque, reiciendis fugiat tempore nulla expedita.', '30'),
(36, ' ,¹b¬Y[–K-#Kp', 'Luciana', 'lu23', 'Luciana@hotmail.com', '', '', '-1'),
(37, ' ,¹b¬Y[–K-#Kp', 'Dorian23', 'Dorian', 'Dorian@hotmail.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quia temporibus, illo error, libero modi omnis possimus soluta laudantium fuga quas, dolore quos repellat. Laboriosam accusamus tenetur doloremque quasi dolores.', '', '31'),
(38, ' ,¹b¬Y[–K-#Kp', 'Marcelo23', 'Marcelo', 'Marcelo@hotmail.com', '', '', '-1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`idalbums`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idcomentario`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`idfoto`);

--
-- Indices de la tabla `historialfoto`
--
ALTER TABLE `historialfoto`
  ADD PRIMARY KEY (`idfoto`);

--
-- Indices de la tabla `seguidores`
--
ALTER TABLE `seguidores`
  ADD UNIQUE KEY `idseguidor` (`idseguidor`,`idusuario`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD UNIQUE KEY `idseguidor` (`idseguidor`,`idusuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albums`
--
ALTER TABLE `albums`
  MODIFY `idalbums` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idcomentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `historialfoto`
--
ALTER TABLE `historialfoto`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
