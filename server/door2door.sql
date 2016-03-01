-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2016 a las 16:58:28
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `door2door`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `adm_id` int(11) NOT NULL,
  `adm_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrators`
--

INSERT INTO `administrators` (`adm_id`, `adm_active`) VALUES
(1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `debts`
--

CREATE TABLE IF NOT EXISTS `debts` (
  `debt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `debts`
--

INSERT INTO `debts` (`debt_id`) VALUES
(6),
(7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guards`
--

CREATE TABLE IF NOT EXISTS `guards` (
  `guard_id` int(11) NOT NULL,
  `guard_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `houses`
--

CREATE TABLE IF NOT EXISTS `houses` (
  `hou_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `houses`
--

INSERT INTO `houses` (`hou_id`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `pay_id` int(11) NOT NULL,
  `pay_period` smallint(6) DEFAULT NULL,
  `pay_person` int(11) DEFAULT NULL,
  `pay_amount` double NOT NULL,
  `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_receiver` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`pay_id`, `pay_period`, `pay_person`, `pay_amount`, `pay_date`, `pay_receiver`) VALUES
(1, 1, 1, 0, '2016-01-16 08:00:00', 1),
(2, 2, 2, 0, '0000-00-00 00:00:00', 1),
(3, 1, 3, 0, '0000-00-00 00:00:00', 1),
(4, 2, 1, 0, '0000-00-00 00:00:00', 1),
(5, 3, 1, 0, '0000-00-00 00:00:00', 1),
(6, 1, 2, 0, '0000-00-00 00:00:00', 1),
(7, 2, 3, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periods`
--

CREATE TABLE IF NOT EXISTS `periods` (
  `prd_id` smallint(6) NOT NULL,
  `prd_date` datetime NOT NULL,
  `prd_amount` double NOT NULL,
  `prd_debtRate` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `periods`
--

INSERT INTO `periods` (`prd_id`, `prd_date`, `prd_amount`, `prd_debtRate`) VALUES
(1, '2016-01-01 00:00:00', 500, 7),
(2, '2016-02-01 00:00:00', 400, 8),
(3, '2016-03-01 00:00:00', 350, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `per_id` int(11) NOT NULL,
  `per_first_name` varchar(30) DEFAULT NULL,
  `per_last_name` varchar(30) DEFAULT NULL,
  `per_phone` varchar(10) DEFAULT NULL,
  `per_email` varchar(30) DEFAULT NULL,
  `per_entryDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `per_photo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persons`
--

INSERT INTO `persons` (`per_id`, `per_first_name`, `per_last_name`, `per_phone`, `per_email`, `per_entryDate`, `per_photo`) VALUES
(1, 'Jose', 'Quijas', '1234567890', 'lehue@wea.com', '2016-01-11 22:24:28', 'leQuij.jpg'),
(2, 'Cosme', 'Fulanito', '6651113322', 'cosme_fulanito@gmail.com', '2016-01-18 15:50:28', 'cosmeFuuu.jpg'),
(3, 'Juana', 'Maguana', '6641111111', 'laquebaila@outlook.com', '2016-02-08 15:50:28', 'maguana.bmp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residents`
--

CREATE TABLE IF NOT EXISTS `residents` (
  `res_id` int(11) NOT NULL,
  `res_active` tinyint(1) NOT NULL,
  `res_house` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `residents`
--

INSERT INTO `residents` (`res_id`, `res_active`, `res_house`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `ser_id` int(11) NOT NULL,
  `ser_name` varchar(20) DEFAULT NULL,
  `ser_description` varchar(30) DEFAULT NULL,
  `ser_price` double DEFAULT NULL,
  `ser_duration` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`ser_id`, `ser_name`, `ser_description`, `ser_price`, `ser_duration`) VALUES
(1, 'papas', 'un pelapapas', 500000, 0),
(2, 'Cucaracha', 'Aun no puede caminar', 50000, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spendings`
--

CREATE TABLE IF NOT EXISTS `spendings` (
  `spn_id` int(11) NOT NULL,
  `spn_period` smallint(6) DEFAULT NULL,
  `spn_service` smallint(6) DEFAULT NULL,
  `spn_amount` double DEFAULT NULL,
  `spn_buyer` int(11) NOT NULL,
  `spn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `spendings`
--

INSERT INTO `spendings` (`spn_id`, `spn_period`, `spn_service`, `spn_amount`, `spn_buyer`, `spn_date`) VALUES
(1, 2, 2, 50000, 1, '2016-02-18 19:45:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_person` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_person`, `user_name`, `user_password`) VALUES
(1, 'mei257', '20eabe5d64b0e216796e834f52d61fd0b70332fc'),
(2, 'cosme', '4d2984028019893f15304da3e6cb60989147f177'),
(3, 'juanita', 'de29ed192adb22cad97a39ef1a2eb02617df60cb');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_administrators`
--
CREATE TABLE IF NOT EXISTS `view_administrators` (
`adm_id` int(11)
,`adm_first_name` varchar(30)
,`adm_last_name` varchar(30)
,`adm_phone` varchar(10)
,`adm_email` varchar(30)
,`adm_photo` varchar(20)
,`adm_active` char(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_newestpayment`
--
CREATE TABLE IF NOT EXISTS `view_newestpayment` (
`prd_id` smallint(6)
,`prd_date` datetime
,`prd_amount` double
,`prd_debtRate` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_residentsactive`
--
CREATE TABLE IF NOT EXISTS `view_residentsactive` (
`per_id` int(11)
,`per_first_name` varchar(30)
,`per_last_name` varchar(30)
,`per_phone` varchar(10)
,`per_email` varchar(30)
,`per_photo` varchar(20)
,`res_active` tinyint(1)
,`res_house` tinyint(4)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_residentsinactive`
--
CREATE TABLE IF NOT EXISTS `view_residentsinactive` (
`per_id` int(11)
,`per_first_name` varchar(30)
,`per_last_name` varchar(30)
,`per_phone` varchar(10)
,`per_email` varchar(30)
,`per_photo` varchar(20)
,`res_active` tinyint(1)
,`res_house` tinyint(4)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_administrators`
--
DROP TABLE IF EXISTS `view_administrators`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_administrators` AS select `persons`.`per_id` AS `adm_id`,`persons`.`per_first_name` AS `adm_first_name`,`persons`.`per_last_name` AS `adm_last_name`,`persons`.`per_phone` AS `adm_phone`,`persons`.`per_email` AS `adm_email`,`persons`.`per_photo` AS `adm_photo`,`administrators`.`adm_active` AS `adm_active` from (`administrators` join `persons` on((`administrators`.`adm_id` = `persons`.`per_id`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `view_newestpayment`
--
DROP TABLE IF EXISTS `view_newestpayment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_newestpayment` AS select `periods`.`prd_id` AS `prd_id`,`periods`.`prd_date` AS `prd_date`,`periods`.`prd_amount` AS `prd_amount`,`periods`.`prd_debtRate` AS `prd_debtRate` from `periods` order by `periods`.`prd_date` desc limit 1;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_residentsactive`
--
DROP TABLE IF EXISTS `view_residentsactive`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_residentsactive` AS select `persons`.`per_id` AS `per_id`,`persons`.`per_first_name` AS `per_first_name`,`persons`.`per_last_name` AS `per_last_name`,`persons`.`per_phone` AS `per_phone`,`persons`.`per_email` AS `per_email`,`persons`.`per_photo` AS `per_photo`,`residents`.`res_active` AS `res_active`,`residents`.`res_house` AS `res_house` from (`residents` join `persons` on((`persons`.`per_id` = `residents`.`res_id`))) where (`residents`.`res_active` = 1);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_residentsinactive`
--
DROP TABLE IF EXISTS `view_residentsinactive`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_residentsinactive` AS select `persons`.`per_id` AS `per_id`,`persons`.`per_first_name` AS `per_first_name`,`persons`.`per_last_name` AS `per_last_name`,`persons`.`per_phone` AS `per_phone`,`persons`.`per_email` AS `per_email`,`persons`.`per_photo` AS `per_photo`,`residents`.`res_active` AS `res_active`,`residents`.`res_house` AS `res_house` from (`residents` join `persons` on((`persons`.`per_id` = `residents`.`res_id`))) where (`residents`.`res_active` = 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indices de la tabla `debts`
--
ALTER TABLE `debts`
  ADD PRIMARY KEY (`debt_id`);

--
-- Indices de la tabla `guards`
--
ALTER TABLE `guards`
  ADD PRIMARY KEY (`guard_id`);

--
-- Indices de la tabla `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`hou_id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`pay_id`), ADD KEY `pay_period` (`pay_period`), ADD KEY `pay_person` (`pay_person`), ADD KEY `pay_receiver` (`pay_receiver`);

--
-- Indices de la tabla `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`prd_id`);

--
-- Indices de la tabla `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`per_id`);

--
-- Indices de la tabla `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`res_id`), ADD KEY `res_house` (`res_house`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ser_id`);

--
-- Indices de la tabla `spendings`
--
ALTER TABLE `spendings`
  ADD PRIMARY KEY (`spn_id`), ADD KEY `spn_period` (`spn_period`), ADD KEY `spn_service` (`spn_service`), ADD KEY `spn_buyer` (`spn_buyer`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_person`), ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `periods`
--
ALTER TABLE `periods`
  MODIFY `prd_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `persons`
--
ALTER TABLE `persons`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `ser_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `spendings`
--
ALTER TABLE `spendings`
  MODIFY `spn_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrators`
--
ALTER TABLE `administrators`
ADD CONSTRAINT `FK_Admin_Person` FOREIGN KEY (`adm_id`) REFERENCES `persons` (`per_id`);

--
-- Filtros para la tabla `debts`
--
ALTER TABLE `debts`
ADD CONSTRAINT `FK_Debt_Payment` FOREIGN KEY (`debt_id`) REFERENCES `payments` (`pay_id`);

--
-- Filtros para la tabla `guards`
--
ALTER TABLE `guards`
ADD CONSTRAINT `FK_Guard_Person` FOREIGN KEY (`guard_id`) REFERENCES `persons` (`per_id`);

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
ADD CONSTRAINT `FK_Payment_Admin` FOREIGN KEY (`pay_receiver`) REFERENCES `administrators` (`adm_id`),
ADD CONSTRAINT `FK_Payment_Period` FOREIGN KEY (`pay_period`) REFERENCES `periods` (`prd_id`),
ADD CONSTRAINT `FK_Payment_Resident` FOREIGN KEY (`pay_person`) REFERENCES `residents` (`res_id`);

--
-- Filtros para la tabla `spendings`
--
ALTER TABLE `spendings`
ADD CONSTRAINT `FK_Spending_Admin` FOREIGN KEY (`spn_buyer`) REFERENCES `administrators` (`adm_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
