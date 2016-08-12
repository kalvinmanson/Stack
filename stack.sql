-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2016 a las 08:36:15
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `stack`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_cats`
--

CREATE TABLE IF NOT EXISTS `dro_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `dro_cats`
--

INSERT INTO `dro_cats` (`id`, `name`, `slug`, `picture`, `created`, `modified`) VALUES
(1, 'General', 'general', '7695_general.jpg', '2015-01-15 16:32:55', '2015-01-15 16:32:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_conts`
--

CREATE TABLE IF NOT EXISTS `dro_conts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT '0',
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  `picture` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `content` text CHARACTER SET latin1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `dro_conts`
--

INSERT INTO `dro_conts` (`id`, `cat_id`, `name`, `slug`, `picture`, `content`, `created`, `modified`) VALUES
(8, 1, 'Home', 'home', NULL, '<p>Lorem ipsum dolor sit amet</p>\r\n', '2016-05-03 00:34:38', '2016-05-03 00:34:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_countries`
--

CREATE TABLE IF NOT EXISTS `dro_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_lat` varchar(255) NOT NULL,
  `location_lon` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=244 ;

--
-- Volcado de datos para la tabla `dro_countries`
--

INSERT INTO `dro_countries` (`id`, `location_lat`, `location_lon`, `name`) VALUES
(1, '65', '33', 'Afghanistan'),
(2, '20', '41', 'Albania'),
(3, '3', '28', 'Algeria'),
(4, '-170', '-143.333', 'American Samoa'),
(5, '1.6', '42.5', 'Andorra'),
(6, '18.5', '-12.5', 'Angola'),
(7, '-631.667', '18.25', 'Anguilla'),
(8, '0', '-90', 'Antarctica'),
(9, '-61.8', '17.05', 'Antigua and Barbuda'),
(10, '-64', '-34', 'Argentina'),
(11, '45', '40', 'Armenia'),
(12, '-699.667', '12.5', 'Aruba'),
(13, '133', '-27', 'Australia'),
(14, '133.333', '473.333', 'Austria'),
(15, '47.5', '40.5', 'Azerbaijan'),
(16, '-76', '24.25', 'Bahamas'),
(17, '50.55', '26', 'Bahrain'),
(18, '90', '24', 'Bangladesh'),
(19, '-595.333', '131.667', 'Barbados'),
(20, '28', '53', 'Belarus'),
(21, '4', '508.333', 'Belgium'),
(22, '-88.75', '17.25', 'Belize'),
(23, '2.25', '9.5', 'Benin'),
(24, '-64.75', '323.333', 'Bermuda'),
(25, '90.5', '27.5', 'Bhutan'),
(26, '-65', '-17', 'Bolivia Plurinational State of'),
(27, '18', '44', 'Bosnia and Herzegovina'),
(28, '24', '-22', 'Botswana'),
(29, '3.4', '-544.333', 'Bouvet Island'),
(30, '-55', '-10', 'Brazil'),
(31, '71.5', '-6', 'British Indian Ocean Territory'),
(32, '1.146.667', '4.5', 'Brunei Darussalam'),
(33, '25', '43', 'Bulgaria'),
(34, '-2', '13', 'Burkina Faso'),
(35, '30', '-3.5', 'Burundi'),
(36, '105', '13', 'Cambodia'),
(37, '12', '6', 'Cameroon'),
(38, '-95', '60', 'Canada'),
(39, '-24', '16', 'Cape Verde'),
(40, '-80.5', '19.5', 'Cayman Islands'),
(41, '21', '7', 'Central African Republic'),
(42, '19', '15', 'Chad'),
(43, '-71', '-30', 'Chile'),
(44, '105', '35', 'China'),
(45, '1.056.667', '-10.5', 'Christmas Island'),
(46, '968.333', '-12.5', 'Cocos (Keeling) Islands'),
(47, '-72', '4', 'Colombia'),
(48, '44.25', '-121.667', 'Comoros'),
(49, '15', '-1', 'Congo'),
(50, '25', '0', 'Congo the Democratic Republic of the'),
(51, '-1.597.667', '-212.333', 'Cook Islands'),
(52, '-84', '10', 'Costa Rica'),
(53, '-5', '8', 'CÃ´te d''Ivoire'),
(54, '15.5', '451.667', 'Croatia'),
(55, '-80', '21.5', 'Cuba'),
(56, '33', '35', 'Cyprus'),
(57, '15.5', '49.75', 'Czech Republic'),
(58, '10', '56', 'Denmark'),
(59, '43', '11.5', 'Djibouti'),
(60, '-613.333', '154.167', 'Dominica'),
(61, '-706.667', '19', 'Dominican Republic'),
(62, '-77.5', '-2', 'Ecuador'),
(63, '30', '27', 'Egypt'),
(64, '-889.167', '138.333', 'El Salvador'),
(65, '10', '2', 'Equatorial Guinea'),
(66, '39', '15', 'Eritrea'),
(67, '26', '59', 'Estonia'),
(68, '38', '8', 'Ethiopia'),
(69, '-59', '-51.75', 'Falkland Islands (Malvinas)'),
(70, '-7', '62', 'Faroe Islands'),
(71, '175', '-18', 'Fiji'),
(72, '26', '64', 'Finland'),
(73, '2', '46', 'France'),
(74, '-53', '4', 'French Guiana'),
(75, '-140', '-15', 'French Polynesia'),
(76, '67', '-43', 'French Southern Territories'),
(77, '11.75', '-1', 'Gabon'),
(78, '-165.667', '134.667', 'Gambia'),
(79, '43.5', '42', 'Georgia'),
(80, '9', '51', 'Germany'),
(81, '-2', '8', 'Ghana'),
(82, '-53.667', '361.833', 'Gibraltar'),
(83, '22', '39', 'Greece'),
(84, '-40', '72', 'Greenland'),
(85, '-616.667', '121.167', 'Grenada'),
(86, '-615.833', '16.25', 'Guadeloupe'),
(87, '1.447.833', '134.667', 'Guam'),
(88, '-90.25', '15.5', 'Guatemala'),
(89, '-2.56', '49.5', 'Guernsey'),
(90, '-10', '11', 'Guinea'),
(91, '-15', '12', 'Guinea-Bissau'),
(92, '-59', '5', 'Guyana'),
(93, '-724.167', '19', 'Haiti'),
(94, '725.167', '-53.1', 'Heard Island and McDonald Islands'),
(95, '12.45', '41.9', 'Holy See (Vatican City State)'),
(96, '-86.5', '15', 'Honduras'),
(97, '1.141.667', '22.25', 'Hong Kong'),
(98, '20', '47', 'Hungary'),
(99, '-18', '65', 'Iceland'),
(100, '77', '20', 'India'),
(101, '120', '-5', 'Indonesia'),
(102, '53', '32', 'Iran Islamic Republic of'),
(103, '44', '33', 'Iraq'),
(104, '-8', '53', 'Ireland'),
(105, '-4.55', '54.23', 'Isle of Man'),
(106, '34.75', '31.5', 'Israel'),
(107, '128.333', '428.333', 'Italy'),
(108, '-77.5', '18.25', 'Jamaica'),
(109, '138', '36', 'Japan'),
(110, '-2.13', '49.21', 'Jersey'),
(111, '36', '31', 'Jordan'),
(112, '68', '48', 'Kazakhstan'),
(113, '38', '1', 'Kenya'),
(114, '173', '14.167', 'Kiribati'),
(115, '127', '40', 'Korea Democratic People''s Republic of'),
(116, '127.5', '37', 'Korea Republic of'),
(117, '476.581', '293.375', 'Kuwait'),
(118, '75', '41', 'Kyrgyzstan'),
(119, '105', '18', 'Lao People''s Democratic Republic'),
(120, '25', '57', 'Latvia'),
(121, '358.333', '338.333', 'Lebanon'),
(122, '28.5', '-29.5', 'Lesotho'),
(123, '-9.5', '6.5', 'Liberia'),
(124, '17', '25', 'Libyan Arab Jamahiriya'),
(125, '95.333', '471.667', 'Liechtenstein'),
(126, '24', '56', 'Lithuania'),
(127, '61.667', '49.75', 'Luxembourg'),
(128, '113.55', '221.667', 'Macao'),
(129, '22', '418.333', 'Macedonia the former Yugoslav Republic of'),
(130, '47', '-20', 'Madagascar'),
(131, '34', '-13.5', 'Malawi'),
(132, '112.5', '2.5', 'Malaysia'),
(133, '73', '3.25', 'Maldives'),
(134, '-4', '17', 'Mali'),
(135, '145.833', '358.333', 'Malta'),
(136, '168', '9', 'Marshall Islands'),
(137, '-61', '146.667', 'Martinique'),
(138, '-12', '20', 'Mauritania'),
(139, '57.55', '-202.833', 'Mauritius'),
(140, '451.667', '-128.333', 'Mayotte'),
(141, '-102', '23', 'Mexico'),
(142, '158.25', '69.167', 'Micronesia Federated States of'),
(143, '29', '47', 'Moldova Republic of'),
(144, '7.4', '437.333', 'Monaco'),
(145, '105', '46', 'Mongolia'),
(146, '19', '42', 'Montenegro'),
(147, '-62.2', '16.75', 'Montserrat'),
(148, '-5', '32', 'Morocco'),
(149, '35', '-18.25', 'Mozambique'),
(150, '98', '22', 'Myanmar'),
(151, '17', '-22', 'Namibia'),
(152, '1.669.167', '-0.5333', 'Nauru'),
(153, '84', '28', 'Nepal'),
(154, '5.75', '52.5', 'Netherlands'),
(155, '-68.75', '12.25', 'Netherlands Antilles'),
(156, '165.5', '-21.5', 'New Caledonia'),
(157, '174', '-41', 'New Zealand'),
(158, '-85', '13', 'Nicaragua'),
(159, '8', '16', 'Niger'),
(160, '8', '10', 'Nigeria'),
(161, '-1.698.667', '-190.333', 'Niue'),
(162, '167.95', '-290.333', 'Norfolk Island'),
(163, '145.75', '15.2', 'Northern Mariana Islands'),
(164, '10', '62', 'Norway'),
(165, '57', '21', 'Oman'),
(166, '70', '30', 'Pakistan'),
(167, '134.5', '7.5', 'Palau'),
(168, '35.25', '32', 'Palestinian Territory Occupied'),
(169, '-80', '9', 'Panama'),
(170, '147', '-6', 'Papua New Guinea'),
(171, '-58', '-23', 'Paraguay'),
(172, '-76', '-10', 'Peru'),
(173, '122', '13', 'Philippines'),
(174, '-127.4', '-24.7', 'Pitcairn'),
(175, '20', '52', 'Poland'),
(176, '-8', '39.5', 'Portugal'),
(177, '-66.5', '18.25', 'Puerto Rico'),
(178, '51.25', '25.5', 'Qatar'),
(179, '55.6', '-21.1', 'RÃ©union'),
(180, '25', '46', 'Romania'),
(181, '100', '60', 'Russian Federation'),
(182, '30', '-2', 'Rwanda'),
(183, '-5.7', '-159.333', 'Saint Helena Ascension and Tristan da Cunha'),
(184, '-62.75', '173.333', 'Saint Kitts and Nevis'),
(185, '-611.333', '138.833', 'Saint Lucia'),
(186, '-563.333', '468.333', 'Saint Pierre and Miquelon'),
(187, '-61.2', '13.25', 'Saint Vincent and the Grenadines'),
(188, '-1.723.333', '-135.833', 'Samoa'),
(189, '124.167', '437.667', 'San Marino'),
(190, '7', '1', 'Sao Tome and Principe'),
(191, '45', '25', 'Saudi Arabia'),
(192, '-14', '14', 'Senegal'),
(193, '21', '44', 'Serbia'),
(194, '556.667', '-45.833', 'Seychelles'),
(195, '-11.5', '8.5', 'Sierra Leone'),
(196, '103.8', '13.667', 'Singapore'),
(197, '19.5', '486.667', 'Slovakia'),
(198, '15', '46', 'Slovenia'),
(199, '159', '-8', 'Solomon Islands'),
(200, '49', '10', 'Somalia'),
(201, '24', '-29', 'South Africa'),
(202, '-37', '-54.5', 'South Georgia and the South Sandwich Islands'),
(203, '-4', '40', 'Spain'),
(204, '81', '7', 'Sri Lanka'),
(205, '30', '15', 'Sudan'),
(206, '-56', '4', 'Suriname'),
(207, '20', '78', 'Svalbard and Jan Mayen'),
(208, '31.5', '-26.5', 'Swaziland'),
(209, '15', '62', 'Sweden'),
(210, '8', '47', 'Switzerland'),
(211, '38', '35', 'Syrian Arab Republic'),
(212, '121', '23.5', 'Taiwan Province of China'),
(213, '71', '39', 'Tajikistan'),
(214, '35', '-6', 'Tanzania United Republic of'),
(215, '100', '15', 'Thailand'),
(216, '1.255.167', '-8.55', 'Timor-Leste'),
(217, '11.667', '8', 'Togo'),
(218, '-172', '-9', 'Tokelau'),
(219, '-175', '-20', 'Tonga'),
(220, '-61', '11', 'Trinidad and Tobago'),
(221, '9', '34', 'Tunisia'),
(222, '35', '39', 'Turkey'),
(223, '60', '40', 'Turkmenistan'),
(224, '-715.833', '21.75', 'Turks and Caicos Islands'),
(225, '178', '-8', 'Tuvalu'),
(226, '32', '1', 'Uganda'),
(227, '32', '49', 'Ukraine'),
(228, '54', '24', 'United Arab Emirates'),
(229, '-2', '54', 'United Kingdom'),
(230, '-97', '38', 'United States'),
(231, '166.6', '192.833', 'United States Minor Outlying Islands'),
(232, '-56', '-33', 'Uruguay'),
(233, '64', '41', 'Uzbekistan'),
(234, '167', '-16', 'Vanuatu'),
(235, '-66', '8', 'Venezuela Bolivarian Republic of'),
(236, '106', '16', 'Viet Nam'),
(237, '-64.5', '18.5', 'Virgin Islands British'),
(238, '-648.333', '183.333', 'Virgin Islands U.S.'),
(239, '-176.2', '-13.3', 'Wallis and Futuna'),
(240, '-13', '24.5', 'Western Sahara'),
(241, '48', '15', 'Yemen'),
(242, '30', '-15', 'Zambia'),
(243, '30', '-20', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_logs`
--

CREATE TABLE IF NOT EXISTS `dro_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `page_log` varchar(255) NOT NULL,
  `log` varchar(255) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Volcado de datos para la tabla `dro_logs`
--

INSERT INTO `dro_logs` (`id`, `user_id`, `page_log`, `log`, `ip`, `created`) VALUES
(58, 1, '/drodmin/index.php?o=pictures&cont_id=8', 'Registro agregado: Imagen de prueba | ID: 1', '127.0.0.1', '2016-08-12 07:35:39'),
(59, 1, '/drodmin/index.php?o=pictures&cont_id=8', 'Registro agregado: Otra imagen | ID: 2', '127.0.0.1', '2016-08-12 07:36:40'),
(60, 1, '/drodmin/index.php?o=pictures&a=edit&id=2&cont_id=8', 'Registro editado: Otra imagen | ID: 2', '127.0.0.1', '2016-08-12 07:37:36'),
(61, 1, '/drodmin/index.php?o=pictures&a=dell&id=1&cont_id=8', 'Registro eliminado ID: 1', '127.0.0.1', '2016-08-12 07:42:19'),
(62, 1, '/drodmin/index.php?o=pictures&cont_id=8', 'Registro agregado: nueva imagen | ID: 3', '127.0.0.1', '2016-08-12 07:50:11'),
(63, 1, '/drodmin/index.php?o=pictures&a=edit&id=3&cont_id=8', 'Registro editado: nueva imagen | ID: 3', '127.0.0.1', '2016-08-12 07:52:52'),
(64, 1, '/drodmin/index.php?o=conts', 'Registro agregado: Pagina de prueba | ID: 9', '127.0.0.1', '2016-08-12 08:06:49'),
(65, 1, '/drodmin/index.php?o=pictures&cont_id=9', 'Registro agregado: imagen para registro de prueba | ID: 4', '127.0.0.1', '2016-08-12 08:06:59'),
(66, 1, '/drodmin/index.php?o=pictures&a=edit&id=4&cont_id=9', 'Registro editado: imagen para registro de prueba | ID: 4', '127.0.0.1', '2016-08-12 08:07:24'),
(67, 1, '/drodmin/index.php?o=conts&a=dell&id=9', 'Registro eliminado ID: 9', '127.0.0.1', '2016-08-12 08:08:29'),
(68, 1, '/drodmin/index.php?o=logs&a=dell', 'Logs eliminados', '127.0.0.1', '2016-08-12 08:09:17'),
(69, 1, '/drodmin/index.php?o=pictures&a=dell&id=3&cont_id=8', 'Registro eliminado ID: 3', '127.0.0.1', '2016-08-12 08:10:13'),
(70, 1, '/drodmin/index.php?o=pictures&a=dell&id=2&cont_id=8', 'Registro eliminado ID: 2', '127.0.0.1', '2016-08-12 08:10:36'),
(71, 1, '/drodmin/index.php?o=cats&a=dell&id=3', 'Registro eliminado ID: 3', '127.0.0.1', '2016-08-12 08:11:57'),
(72, 1, '/drodmin/index.php?o=cats&a=dell&id=2', 'Registro eliminado ID: 2', '127.0.0.1', '2016-08-12 08:12:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_pictures`
--

CREATE TABLE IF NOT EXISTS `dro_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cont_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `content` text,
  `orden` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `dro_pictures`
--

INSERT INTO `dro_pictures` (`id`, `cont_id`, `name`, `picture`, `content`, `orden`, `link`, `created`, `modified`) VALUES
(4, 9, 'imagen para registro de prueba', '/contenido/dev/files/ninjas.jpg', NULL, 0, NULL, '2016-08-12 08:06:59', '2016-08-12 08:07:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_posts`
--

CREATE TABLE IF NOT EXISTS `dro_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `dro_posts`
--

INSERT INTO `dro_posts` (`id`, `name`, `slug`, `picture`, `content`, `created`, `modified`) VALUES
(2, 'Primer post d eprueba', 'primer-post-d-eprueba', '/contenido/userfiles/dev/files/corel-vs-illustrator.png', '<p>Lorem ipsum dolor sit amet.</p>\r\n', '2016-05-02 22:46:15', '2016-05-02 22:46:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dro_users`
--

CREATE TABLE IF NOT EXISTS `dro_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `rol` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'User',
  `city` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `dro_users`
--

INSERT INTO `dro_users` (`id`, `username`, `password`, `email`, `country_id`, `rol`, `city`, `name`, `birthdate`, `adress`, `phone`, `created`, `modified`) VALUES
(1, 'dev', 'a14760ef3c8e22a5bbfb6d4eee5ac8ddb9b022b9', 'dev@droni.co', 47, 'Dronico', 'BogotÃ¡', 'Gustavo Enrique BarragÃ¡n SÃ¡nchez', '1988-01-12', 'Cra 86 #89-56', '3143390071', '1899-11-30 00:00:00', NULL),
(3, 'jjacome', 'a14760ef3c8e22a5bbfb6d4eee5ac8ddb9b022b9', 'jcjacome@unal.edu.co', 47, 'Admin', 'BogotÃ¡', 'Jennyfer Carolina Jacome Suarez', '1994-08-12', 'Calle 86 #95-23 Blq D7 Apto 505', '3114949267', '2016-05-02 22:59:25', '2016-05-02 23:33:29');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
