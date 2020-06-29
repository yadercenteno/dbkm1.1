-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-06-2020 a las 20:48:06
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbkm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `id` int(11) NOT NULL COMMENT 'Identificador del acceso',
  `usuario_id` int(11) NOT NULL COMMENT 'Identificador del usuario que accede',
  `tipo_acceso` int(1) NOT NULL DEFAULT 1 COMMENT 'Tipo de acceso (entrata o salida)',
  `ip` varchar(45) DEFAULT NULL COMMENT 'Dirección IP del usuario que ingresa',
  `registrado_at` datetime DEFAULT NULL COMMENT 'Fecha de registro del acceso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que registra los accesos de los usuarios al sistema';

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`id`, `usuario_id`, `tipo_acceso`, `ip`, `registrado_at`) VALUES
(1, 2, 2, '127.0.0.1', '2020-06-28 11:51:22'),
(2, 2, 1, '127.0.0.1', '2020-06-28 11:51:27'),
(3, 2, 2, '127.0.0.1', '2020-06-28 12:08:47'),
(4, 107, 1, '127.0.0.1', '2020-06-28 12:08:52'),
(5, 107, 2, '127.0.0.1', '2020-06-28 12:08:59'),
(6, 2, 1, '127.0.0.1', '2020-06-28 12:09:20'),
(7, 2, 2, '127.0.0.1', '2020-06-28 12:11:18'),
(8, 2, 1, '127.0.0.1', '2020-06-28 12:12:21'),
(9, 2, 2, '127.0.0.1', '2020-06-28 12:12:44'),
(10, 107, 1, '127.0.0.1', '2020-06-28 12:12:48'),
(11, 107, 2, '127.0.0.1', '2020-06-28 12:13:21'),
(12, 107, 1, '127.0.0.1', '2020-06-28 12:13:26'),
(13, 107, 2, '127.0.0.1', '2020-06-28 12:14:06'),
(14, 2, 1, '127.0.0.1', '2020-06-28 12:14:15'),
(15, 2, 2, '127.0.0.1', '2020-06-28 12:14:23'),
(16, 107, 1, '127.0.0.1', '2020-06-28 12:14:28'),
(17, 107, 2, '127.0.0.1', '2020-06-28 12:14:33'),
(18, 2, 1, '127.0.0.1', '2020-06-28 12:15:29'),
(19, 2, 2, '127.0.0.1', '2020-06-28 12:36:41'),
(20, 107, 1, '127.0.0.1', '2020-06-28 12:36:46'),
(21, 107, 2, '127.0.0.1', '2020-06-28 12:41:11'),
(22, 2, 1, '127.0.0.1', '2020-06-28 12:41:15'),
(23, 2, 2, '127.0.0.1', '2020-06-28 12:42:48'),
(24, 107, 1, '127.0.0.1', '2020-06-28 12:42:53'),
(25, 107, 2, '127.0.0.1', '2020-06-28 12:45:27'),
(26, 2, 1, '127.0.0.1', '2020-06-28 12:45:34'),
(27, 2, 2, '127.0.0.1', '2020-06-28 12:46:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acuentas`
--

CREATE TABLE `acuentas` (
  `id` int(11) NOT NULL,
  `codigo_cta` varchar(10) NOT NULL,
  `nombre_cta` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que contiene el listado de cuentas presup. disponibles';

--
-- Volcado de datos para la tabla `acuentas`
--

INSERT INTO `acuentas` (`id`, `codigo_cta`, `nombre_cta`) VALUES
(1, '1000', 'Gastos de personal'),
(2, '1002', 'Gastos de seguridad social'),
(3, '1003', 'Gastos de materiales'),
(4, '1004', 'Servicios profesionales'),
(5, '1005', 'Servicios bÃ¡sicos'),
(6, '1006', 'Impuestos y tasas'),
(9, '1007', 'Gastos de representaciÃ³n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apresupgeneral`
--

CREATE TABLE `apresupgeneral` (
  `id` int(11) NOT NULL,
  `cuenta_id` int(11) NOT NULL,
  `mes1` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes2` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes3` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes4` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes5` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes6` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes7` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes8` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes9` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes10` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes11` decimal(19,2) NOT NULL DEFAULT 0.00,
  `mes12` decimal(19,2) NOT NULL DEFAULT 0.00,
  `observaciones` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que almacena el presupuesto general por cada periodo';

--
-- Volcado de datos para la tabla `apresupgeneral`
--

INSERT INTO `apresupgeneral` (`id`, `cuenta_id`, `mes1`, `mes2`, `mes3`, `mes4`, `mes5`, `mes6`, `mes7`, `mes8`, `mes9`, `mes10`, `mes11`, `mes12`, `observaciones`) VALUES
(1, 2, '105.25', '150.25', '87.50', '50.25', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '99.50', '120.50', NULL),
(2, 1, '2500.00', '2850.00', '2500.00', '2500.00', '2950.00', '2500.00', '2500.00', '2957.21', '2100.00', '2500.00', '2500.00', '2500.00', 'Salarios de 2 trabajadores'),
(3, 3, '0.00', '0.00', '150.00', '0.00', '150.00', '0.00', '150.00', '0.00', '150.00', '0.00', '150.00', '0.00', 'PapelerÃ¬a de oficina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backup`
--

CREATE TABLE `backup` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `denominacion` varchar(200) NOT NULL,
  `tamano` varchar(45) DEFAULT NULL,
  `archivo` varchar(45) NOT NULL,
  `registrado_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene las copias de seguridad del sistema';

--
-- Volcado de datos para la tabla `backup`
--

INSERT INTO `backup` (`id`, `usuario_id`, `denominacion`, `tamano`, `archivo`, `registrado_at`) VALUES
(1, 2, 'Primer respaldo', '0', 'backup-1.sql', '2014-02-02 10:09:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id` int(11) NOT NULL COMMENT 'Identificador de la ciudad',
  `ciudad` varchar(45) NOT NULL COMMENT 'Nombre de la cuidad',
  `registrado_at` datetime DEFAULT NULL COMMENT 'Fecha de registro',
  `modificado_in` datetime DEFAULT NULL COMMENT 'Fecha de la última modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene las ciudades que se manejan del sistema';

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `ciudad`, `registrado_at`, `modificado_in`) VALUES
(1, 'Oficina central', '2018-09-23 10:07:14', NULL),
(2, 'Sucursal 1', '2018-09-23 10:08:30', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL COMMENT 'Identificador de la empresa',
  `razon_social` varchar(100) NOT NULL COMMENT 'Nombre de la empresa',
  `siglas` varchar(45) DEFAULT NULL COMMENT 'Siglas del nombre de la empresa',
  `nit` varchar(15) NOT NULL COMMENT 'Número de identificación tributaria de la empresa',
  `dv` int(2) DEFAULT NULL COMMENT 'Digito de verificación del NIT',
  `representante_legal` varchar(100) NOT NULL COMMENT 'Nombre del representante legal de la empresa',
  `nuip` bigint(20) NOT NULL COMMENT 'Número de identificación personal',
  `tipo_nuip_id` int(1) NOT NULL COMMENT 'Tipo de identificación',
  `pagina_web` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `registrado_at` varchar(45) DEFAULT NULL,
  `modificado_in` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la información básica de la empresa';

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `razon_social`, `siglas`, `nit`, `dv`, `representante_legal`, `nuip`, `tipo_nuip_id`, `pagina_web`, `logo`, `registrado_at`, `modificado_in`) VALUES
(1, 'KumbiaPHP', 'KumbiaPHP', '0', 6, 'Nombre del representante', 0, 1, 'https://kumbiaphp.com', 'logo_gg.png', '2013-01-01 00:00:01', '2020-06-28 11:54:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

CREATE TABLE `estado_usuario` (
  `id` int(11) NOT NULL COMMENT 'Identificador del estado del usuario',
  `usuario_id` int(11) NOT NULL COMMENT 'Identificador del usuario',
  `estado_usuario` int(11) NOT NULL COMMENT 'Código del estado del usuario',
  `descripcion` varchar(100) NOT NULL COMMENT 'Motivo del cambio de estado',
  `fecha_estado_at` datetime DEFAULT NULL COMMENT 'Fecha del cambio de estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los estados de los usuarios';

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`id`, `usuario_id`, `estado_usuario`, `descripcion`, `fecha_estado_at`) VALUES
(2, 2, 1, 'Activo por ser el Super Usuario del sistema', '2013-01-01 00:00:01'),
(200, 107, 1, 'Activado por registro inicial', '2020-06-28 12:08:42'),
(201, 107, 2, 'Prueba de baja', '2020-06-28 12:11:14'),
(202, 107, 1, 'Activado nuevamente', '2020-06-28 12:12:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL COMMENT 'Identificador del menú',
  `menu_id` int(11) DEFAULT NULL COMMENT 'Identificador del menú padre',
  `recurso_id` int(11) DEFAULT NULL COMMENT 'Identificador del recurso',
  `menu` varchar(45) NOT NULL COMMENT 'Texto a mostrar del menú',
  `url` varchar(60) DEFAULT NULL COMMENT 'Url del menú',
  `posicion` int(11) DEFAULT 0 COMMENT 'Posisión dentro de otros items',
  `icono` varchar(45) DEFAULT NULL COMMENT 'Icono a mostrar ',
  `activo` int(1) NOT NULL DEFAULT 1 COMMENT 'Menú activo o inactivo',
  `visibilidad` int(1) NOT NULL DEFAULT 1 COMMENT 'Indica si el menú se muestra en el backend o en el frontend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los menú para los usuarios';

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `menu_id`, `recurso_id`, `menu`, `url`, `posicion`, `icono`, `activo`, `visibilidad`) VALUES
(1, NULL, NULL, 'Inicio', '#', 10, 'fa-home', 1, 1),
(2, 1, 2, 'Inicio', 'dashboard/', 11, 'fa-home', 1, 1),
(3, NULL, NULL, 'Sistema', '#', 900, 'fa-cogs', 1, 1),
(4, 3, 4, 'Accesos', 'sistema/accesos/listar/', 901, 'fa-exchange', 1, 1),
(5, 3, 5, 'AuditorÃ­as', 'sistema/auditorias/', 902, 'fa-eye', 1, 1),
(6, 3, 6, 'Respaldar BD', 'sistema/backups/listar/', 903, 'fa-hdd-o', 1, 1),
(7, 3, 7, 'Mantenimiento', 'sistema/mantenimiento/', 904, 'fa-bolt', 1, 1),
(8, 3, 8, 'MenÃºs', 'sistema/menus/listar/', 905, 'fa-list', 1, 1),
(9, 3, 9, 'Perfiles', 'sistema/perfiles/listar/', 906, 'fa-group', 1, 1),
(10, 3, 10, 'Permisos', 'sistema/permisos/listar/', 907, 'fa-magic', 1, 1),
(11, 3, 11, 'Recursos', 'sistema/recursos/listar/', 908, 'fa-lock', 1, 1),
(12, 3, 12, 'Usuarios', 'sistema/usuarios/listar/', 909, 'fa-user', 1, 1),
(13, 3, 13, 'Visor de sucesos', 'sistema/sucesos/', 910, 'fa-filter', 1, 1),
(14, 3, 14, 'Sistema', 'sistema/configuracion/', 911, 'fa-wrench', 1, 1),
(15, NULL, NULL, 'Configuraciones', '#', 800, 'fa-wrench', 1, 1),
(16, 15, 15, 'Empresa', 'config/empresa/', 813, 'fa-briefcase', 1, 1),
(17, 15, 16, 'Sucursales', 'config/sucursal/listar/', 809, 'fa-sitemap', 1, 1),
(22, NULL, NULL, 'Ejemplos', '#', 700, 'fa-eye', 1, 1),
(23, 22, 22, 'Cuentas', 'ejemplos/acuentas/listar/', 803, 'fa-book', 1, 1),
(29, 22, 27, 'Presupuesto', 'ejemplos/apresupgeneral/listar/', 701, 'fa-tasks', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` int(2) NOT NULL COMMENT 'Identificador del perfil',
  `perfil` varchar(45) NOT NULL COMMENT 'Nombre del perfil',
  `estado` int(1) NOT NULL DEFAULT 1 COMMENT 'Indica si el perfil esta activo o inactivo',
  `plantilla` varchar(45) DEFAULT 'default' COMMENT 'Plantilla para usar en el sitema',
  `registrado_at` datetime DEFAULT NULL COMMENT 'Fecha de registro del perfil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los grupos de los usuarios';

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `perfil`, `estado`, `plantilla`, `registrado_at`) VALUES
(1, 'Super Usuario', 1, 'default', '2013-01-01 00:00:01'),
(2, 'normal', 1, 'default', '2013-10-14 13:01:34'),
(3, 'ver', 1, 'default', '2013-10-23 19:07:08'),
(4, 'total', 1, 'default', '2013-10-26 14:24:17'),
(5, 'aprobador', 1, 'default', '2013-12-20 15:29:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `nuip` bigint(20) NOT NULL COMMENT 'Número de identificación personal',
  `tipo_nuip_id` int(11) NOT NULL COMMENT 'Tipo de identificación',
  `telefono` varchar(45) DEFAULT NULL,
  `fotografia` varchar(45) DEFAULT 'default.png' COMMENT 'Fotografía',
  `registrado_at` datetime DEFAULT NULL,
  `modificado_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene las personas que interactúan con el siste';

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `apellido`, `nuip`, `tipo_nuip_id`, `telefono`, `fotografia`, `registrado_at`, `modificado_in`) VALUES
(1, 'Cronjob', 'System', 11, 1, NULL, 'default.png', '2013-01-01 00:00:01', NULL),
(2, 'Super', 'Admin', 12, 1, NULL, 'default.png', '2013-10-26 14:26:14', '2019-01-26 11:08:12'),
(187, 'Usuario de', 'Prueba', 123, 1, NULL, 'default.png', '2020-06-28 12:08:42', '2020-06-28 12:14:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL COMMENT 'Identificador del recurso',
  `modulo` varchar(45) DEFAULT NULL COMMENT 'Nombre del módulo',
  `controlador` varchar(45) DEFAULT NULL COMMENT 'Nombre del controlador',
  `accion` varchar(45) DEFAULT NULL COMMENT 'Nombre de la acción',
  `recurso` varchar(100) DEFAULT NULL COMMENT 'Nombre del recurso',
  `descripcion` text NOT NULL COMMENT 'Descripción del recurso',
  `activo` int(1) NOT NULL DEFAULT 1 COMMENT 'Estado del recurso',
  `registrado_at` datetime DEFAULT NULL COMMENT 'Fecha de registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los recursos a los que acceden los usuari';

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id`, `modulo`, `controlador`, `accion`, `recurso`, `descripcion`, `activo`, `registrado_at`) VALUES
(1, '*', NULL, NULL, '*', 'Comodin para la administracion total (usar con cuidado)', 1, '2013-01-01 00:00:01'),
(2, 'dashboard', '*', '*', 'dashboard/*/*', 'Pagina principal del sistema', 1, '2013-01-01 00:00:01'),
(3, 'sistema', 'mi_cuenta', '*', 'sistema/mi_cuenta/*', 'Gestion de la cuenta del usuario logueado', 1, '2013-01-01 00:00:01'),
(4, 'sistema', 'acceso', '*', 'sistema/acceso/*', 'Submodulo para la gestion de ingresos al sistema', 1, '2013-01-01 00:00:01'),
(5, 'sistema', 'auditoria', '*', 'sistema/auditoria/*', 'Submodulo para el control de las acciones de los usuarios', 1, '2013-01-01 00:00:01'),
(6, 'sistema', 'backups', '*', 'sistema/backups/*', 'Submodulo para la gestion de las copias de seguridad', 1, '2013-01-01 00:00:01'),
(7, 'sistema', 'mantenimiento', '*', 'sistema/mantenimiento/*', 'Submodulo para el mantenimiento de las tablas', 1, '2013-01-01 00:00:01'),
(8, 'sistema', 'menus', '*', 'sistema/menus/*', 'Submodulo del sistema para la creacion de menus', 1, '2013-01-01 00:00:01'),
(9, 'sistema', 'perfiles', '*', 'sistema/perfiles/*', 'Submodulo del sistema para los perfiles de usuarios', 1, '2013-01-01 00:00:01'),
(10, 'sistema', 'permisos', '*', 'sistema/permisos/*', 'Submodulo del sistema para asignar recursos a los perfiles', 1, '2013-01-01 00:00:01'),
(11, 'sistema', 'recursos', '*', 'sistema/recursos/*', 'Submodulo del sistema para la gestion de los recursos', 1, '2013-01-01 00:00:01'),
(12, 'sistema', 'usuarios', '*', 'sistema/usuarios/*', 'Submodulo para la administracion de los usuarios del sistema', 1, '2013-01-01 00:00:01'),
(13, 'sistema', 'sucesos', '*', 'sistema/suceso/*', 'Submodulo para el listado de los logs del sistema', 1, '2013-01-01 00:00:01'),
(14, 'sistema', 'configuracion', '*', 'sistema/configuracion/*', 'Submodulo para la configuracion de la aplicacion (.ini)', 1, '2013-01-01 00:00:01'),
(15, 'config', 'empresa', '*', 'config/empresa/*', 'Submodulo para la configuracion de la informacion de la Empresa', 1, '2013-01-01 00:00:01'),
(16, 'config', 'sucursal', '*', 'config/sucursal/*', 'Submodulo para la administracion de las Sucursales', 1, '2013-01-01 00:00:01'),
(17, 'inicio', 'inicio', '*', 'inicio/inicio/*', 'El mero incio del programa', 1, '2013-09-30 20:26:42'),
(22, 'ejemplos', 'acuentas', '*', 'ejemplos/acuentas/*', 'Listado de cuentas de gasto', 1, '2013-11-02 15:34:07'),
(27, 'ejemplos', 'apresupgeneral', '*', 'ejemplos/apresupgeneral/*', 'Presupuesto general del perÃ­odo', 1, '2013-11-24 13:01:32'),
(29, 'reporte', 'acuentas', '*', 'reporte/acuentas/*', 'Reporte de Catalogo de Cuentas', 1, '2013-12-19 14:17:38'),
(32, 'reporte', 'apresupgeneral', '*', 'reporte/apresupgeneral/*', 'Reporte de presupuesto general', 1, '2013-12-19 14:21:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso_perfil`
--

CREATE TABLE `recurso_perfil` (
  `id` int(11) NOT NULL,
  `recurso_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `registrado_at` datetime DEFAULT NULL,
  `modificado_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los recursos del usuario en el sistema se';

--
-- Volcado de datos para la tabla `recurso_perfil`
--

INSERT INTO `recurso_perfil` (`id`, `recurso_id`, `perfil_id`, `registrado_at`, `modificado_in`) VALUES
(1, 1, 1, '2013-01-01 00:00:01', NULL),
(2, 2, 2, '2013-10-14 13:01:34', NULL),
(9, 2, 3, '2013-10-23 19:07:08', NULL),
(15, 2, 4, '2013-10-26 14:24:17', NULL),
(205, 2, 5, '2013-12-20 15:29:24', NULL),
(2364, 53, 4, '2016-03-09 09:20:39', NULL),
(2365, 54, 4, '2016-03-09 09:20:39', NULL),
(2369, 59, 5, '2016-03-09 09:20:39', NULL),
(2370, 59, 4, '2016-03-09 09:20:39', NULL),
(2371, 59, 3, '2016-03-09 09:20:39', NULL),
(2392, 60, 5, '2016-03-09 09:20:39', NULL),
(2393, 60, 4, '2016-03-09 09:20:39', NULL),
(2394, 60, 3, '2016-03-09 09:20:39', NULL),
(2480, 48, 4, '2018-02-22 15:47:58', NULL),
(2481, 49, 4, '2018-02-22 15:47:58', NULL),
(2482, 50, 4, '2018-02-22 15:47:58', NULL),
(2483, 51, 4, '2018-02-22 15:47:58', NULL),
(2484, 52, 4, '2018-02-22 15:47:58', NULL),
(2485, 55, 4, '2018-02-22 15:47:58', NULL),
(2486, 58, 4, '2018-02-22 15:47:58', NULL),
(3058, 34, 5, '2018-09-28 13:46:21', NULL),
(3059, 34, 2, '2018-09-28 13:46:21', NULL),
(3060, 34, 4, '2018-09-28 13:46:21', NULL),
(3061, 34, 3, '2018-09-28 13:46:21', NULL),
(3062, 36, 5, '2018-09-28 13:46:21', NULL),
(3063, 36, 4, '2018-09-28 13:46:21', NULL),
(3064, 36, 3, '2018-09-28 13:46:21', NULL),
(3065, 37, 5, '2018-09-28 13:46:21', NULL),
(3066, 37, 4, '2018-09-28 13:46:21', NULL),
(3067, 37, 3, '2018-09-28 13:46:21', NULL),
(3068, 39, 5, '2018-09-28 13:46:21', NULL),
(3069, 39, 2, '2018-09-28 13:46:21', NULL),
(3070, 39, 4, '2018-09-28 13:46:21', NULL),
(3071, 39, 3, '2018-09-28 13:46:21', NULL),
(3072, 42, 5, '2018-09-28 13:46:21', NULL),
(3073, 42, 4, '2018-09-28 13:46:21', NULL),
(3074, 42, 3, '2018-09-28 13:46:21', NULL),
(3075, 46, 5, '2018-09-28 13:46:21', NULL),
(3076, 46, 2, '2018-09-28 13:46:21', NULL),
(3077, 46, 4, '2018-09-28 13:46:21', NULL),
(3078, 46, 3, '2018-09-28 13:46:21', NULL),
(3079, 56, 5, '2018-09-28 13:46:21', NULL),
(3080, 56, 4, '2018-09-28 13:46:21', NULL),
(3081, 56, 3, '2018-09-28 13:46:21', NULL),
(3082, 67, 5, '2018-09-28 13:46:21', NULL),
(3083, 67, 4, '2018-09-28 13:46:21', NULL),
(3084, 67, 3, '2018-09-28 13:46:21', NULL),
(3085, 68, 5, '2018-09-28 13:46:21', NULL),
(3086, 68, 4, '2018-09-28 13:46:21', NULL),
(3087, 68, 3, '2018-09-28 13:46:21', NULL),
(3088, 35, 5, '2018-09-28 13:46:21', NULL),
(3089, 35, 4, '2018-09-28 13:46:21', NULL),
(3090, 35, 3, '2018-09-28 13:46:21', NULL),
(3091, 38, 5, '2018-09-28 13:46:21', NULL),
(3092, 38, 4, '2018-09-28 13:46:21', NULL),
(3093, 38, 3, '2018-09-28 13:46:21', NULL),
(3094, 40, 5, '2018-09-28 13:46:21', NULL),
(3095, 40, 2, '2018-09-28 13:46:21', NULL),
(3096, 40, 4, '2018-09-28 13:46:21', NULL),
(3097, 40, 3, '2018-09-28 13:46:21', NULL),
(3098, 43, 5, '2018-09-28 13:46:21', NULL),
(3099, 43, 4, '2018-09-28 13:46:21', NULL),
(3100, 43, 3, '2018-09-28 13:46:21', NULL),
(3101, 47, 5, '2018-09-28 13:46:21', NULL),
(3102, 47, 2, '2018-09-28 13:46:21', NULL),
(3103, 47, 4, '2018-09-28 13:46:21', NULL),
(3104, 47, 3, '2018-09-28 13:46:21', NULL),
(3105, 57, 5, '2018-09-28 13:46:21', NULL),
(3106, 57, 4, '2018-09-28 13:46:21', NULL),
(3107, 57, 3, '2018-09-28 13:46:21', NULL),
(3108, 3, 5, '2018-09-28 13:46:21', NULL),
(3109, 3, 2, '2018-09-28 13:46:21', NULL),
(3110, 3, 4, '2018-09-28 13:46:21', NULL),
(3111, 3, 3, '2018-09-28 13:46:21', NULL),
(3255, 31, 5, '2019-10-21 12:52:08', NULL),
(3256, 31, 2, '2019-10-21 12:52:08', NULL),
(3257, 31, 4, '2019-10-21 12:52:08', NULL),
(3258, 31, 3, '2019-10-21 12:52:08', NULL),
(3322, 30, 5, '2019-11-06 15:07:05', NULL),
(3323, 30, 2, '2019-11-06 15:07:05', NULL),
(3324, 30, 4, '2019-11-06 15:07:05', NULL),
(3325, 30, 3, '2019-11-06 15:07:05', NULL),
(3326, 1, 4, '2019-11-11 16:21:02', NULL),
(3327, 44, 5, '2019-11-11 16:21:02', NULL),
(3328, 44, 2, '2019-11-11 16:21:02', NULL),
(3329, 44, 4, '2019-11-11 16:21:02', NULL),
(3330, 44, 3, '2019-11-11 16:21:02', NULL),
(3331, 45, 5, '2019-11-11 16:21:02', NULL),
(3332, 45, 2, '2019-11-11 16:21:02', NULL),
(3333, 45, 4, '2019-11-11 16:21:02', NULL),
(3334, 45, 3, '2019-11-11 16:21:02', NULL),
(3335, 64, 4, '2019-11-11 16:21:02', NULL),
(3338, 18, 4, '2019-11-11 16:21:02', NULL),
(3339, 19, 4, '2019-11-11 16:21:02', NULL),
(3340, 20, 4, '2019-11-11 16:21:02', NULL),
(3341, 21, 4, '2019-11-11 16:21:02', NULL),
(3344, 24, 4, '2019-11-11 16:21:02', NULL),
(3345, 25, 4, '2019-11-11 16:21:02', NULL),
(3346, 26, 5, '2019-11-11 16:21:02', NULL),
(3347, 26, 4, '2019-11-11 16:21:02', NULL),
(3348, 61, 4, '2019-11-11 16:21:02', NULL),
(3349, 65, 4, '2019-11-11 16:21:02', NULL),
(3350, 69, 5, '2019-11-11 16:21:02', NULL),
(3351, 69, 2, '2019-11-11 16:21:02', NULL),
(3352, 69, 4, '2019-11-11 16:21:02', NULL),
(3353, 69, 3, '2019-11-11 16:21:02', NULL),
(3354, 66, 5, '2019-11-11 16:21:02', NULL),
(3355, 66, 2, '2019-11-11 16:21:02', NULL),
(3356, 66, 4, '2019-11-11 16:21:02', NULL),
(3357, 66, 3, '2019-11-11 16:21:02', NULL),
(3358, 71, 4, '2019-11-11 16:21:02', NULL),
(3363, 23, 5, '2019-11-11 16:21:02', NULL),
(3364, 23, 4, '2019-11-11 16:21:02', NULL),
(3365, 23, 3, '2019-11-11 16:21:02', NULL),
(3366, 33, 5, '2019-11-11 16:21:02', NULL),
(3367, 33, 2, '2019-11-11 16:21:02', NULL),
(3368, 33, 4, '2019-11-11 16:21:02', NULL),
(3369, 33, 3, '2019-11-11 16:21:02', NULL),
(3370, 41, 5, '2019-11-11 16:21:02', NULL),
(3371, 41, 4, '2019-11-11 16:21:02', NULL),
(3372, 62, 5, '2019-11-11 16:21:02', NULL),
(3373, 62, 4, '2019-11-11 16:21:02', NULL),
(3374, 63, 5, '2019-11-11 16:21:02', NULL),
(3375, 63, 2, '2019-11-11 16:21:02', NULL),
(3376, 63, 4, '2019-11-11 16:21:02', NULL),
(3377, 63, 3, '2019-11-11 16:21:02', NULL),
(3378, 70, 5, '2019-11-11 16:21:02', NULL),
(3379, 70, 4, '2019-11-11 16:21:02', NULL),
(3383, 28, 5, '2019-11-11 16:21:02', NULL),
(3384, 28, 4, '2019-11-11 16:21:02', NULL),
(3385, 28, 3, '2019-11-11 16:21:02', NULL),
(3452, 15, 4, '2020-06-28 12:10:02', NULL),
(3453, 16, 4, '2020-06-28 12:10:02', NULL),
(3454, 22, 5, '2020-06-28 12:10:02', NULL),
(3455, 22, 2, '2020-06-28 12:10:02', NULL),
(3456, 22, 4, '2020-06-28 12:10:02', NULL),
(3457, 27, 5, '2020-06-28 12:10:02', NULL),
(3458, 27, 2, '2020-06-28 12:10:02', NULL),
(3459, 27, 4, '2020-06-28 12:10:02', NULL),
(3460, 17, 5, '2020-06-28 12:10:02', NULL),
(3461, 17, 2, '2020-06-28 12:10:02', NULL),
(3462, 17, 4, '2020-06-28 12:10:02', NULL),
(3463, 17, 3, '2020-06-28 12:10:02', NULL),
(3464, 29, 5, '2020-06-28 12:10:02', NULL),
(3465, 29, 2, '2020-06-28 12:10:02', NULL),
(3466, 29, 4, '2020-06-28 12:10:02', NULL),
(3467, 29, 3, '2020-06-28 12:10:02', NULL),
(3468, 32, 5, '2020-06-28 12:10:02', NULL),
(3469, 32, 2, '2020-06-28 12:10:02', NULL),
(3470, 32, 4, '2020-06-28 12:10:02', NULL),
(3471, 32, 3, '2020-06-28 12:10:02', NULL),
(3472, 4, 4, '2020-06-28 12:10:02', NULL),
(3473, 5, 4, '2020-06-28 12:10:02', NULL),
(3474, 6, 4, '2020-06-28 12:10:02', NULL),
(3475, 7, 4, '2020-06-28 12:10:02', NULL),
(3476, 8, 4, '2020-06-28 12:10:02', NULL),
(3477, 9, 4, '2020-06-28 12:10:02', NULL),
(3478, 10, 4, '2020-06-28 12:10:02', NULL),
(3479, 11, 4, '2020-06-28 12:10:02', NULL),
(3480, 12, 4, '2020-06-28 12:10:02', NULL),
(3481, 13, 4, '2020-06-28 12:10:02', NULL),
(3482, 14, 4, '2020-06-28 12:10:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id` int(11) NOT NULL COMMENT 'Identificación de la sucursal',
  `empresa_id` int(11) NOT NULL COMMENT 'Identificador de la empresa',
  `sucursal` varchar(45) NOT NULL COMMENT 'Nombre de la sucursal',
  `sucursal_slug` varchar(45) DEFAULT NULL COMMENT 'Slug de la sucursal',
  `ciudad_id` int(11) NOT NULL COMMENT 'Identificador de la ciudad',
  `registrado_at` datetime DEFAULT NULL COMMENT 'Fecha de registro',
  `modificado_in` datetime DEFAULT NULL COMMENT 'Fecha de la última modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene las sucursales de la empresa';

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id`, `empresa_id`, `sucursal`, `sucursal_slug`, `ciudad_id`, `registrado_at`, `modificado_in`) VALUES
(1, 1, 'Oficina central', 'oficina-principal', 1, '2013-01-01 00:00:01', '2020-06-28 12:01:58'),
(2, 1, 'Sucursal 1', NULL, 1, '2018-09-23 10:07:14', '2020-06-28 12:02:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_nuip`
--

CREATE TABLE `tipo_nuip` (
  `id` int(11) NOT NULL,
  `tipo_nuip` varchar(45) NOT NULL COMMENT 'Nombre del tipo de identificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los tipos de identificación de las person';

--
-- Volcado de datos para la tabla `tipo_nuip`
--

INSERT INTO `tipo_nuip` (`id`, `tipo_nuip`) VALUES
(1, 'Trabajador fijo'),
(2, 'Trabajador temporal'),
(3, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL COMMENT 'Identificador del usuario',
  `sucursal_id` int(11) DEFAULT NULL COMMENT 'Identificador a la sucursal a la cual pertenece',
  `persona_id` int(11) NOT NULL COMMENT 'Identificador de la persona',
  `login` varchar(45) NOT NULL COMMENT 'Nombre de usuario',
  `password` varchar(45) NOT NULL COMMENT 'Contraseña de acceso al sistea',
  `perfil_id` int(2) NOT NULL COMMENT 'Identificador del perfil',
  `email` varchar(45) DEFAULT NULL COMMENT 'Dirección del correo electónico',
  `tema` varchar(45) DEFAULT 'default' COMMENT 'Tema aplicable para la interfaz',
  `app_ajax` int(1) DEFAULT 1 COMMENT 'Indica si la app se trabaja con ajax o peticiones normales',
  `datagrid` int(11) DEFAULT 30 COMMENT 'Datos por página en los datagrid',
  `registrado_at` datetime DEFAULT NULL COMMENT 'Fecha de registro',
  `modificado_in` datetime DEFAULT NULL COMMENT 'Fecha de la última modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los usuarios';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `sucursal_id`, `persona_id`, `login`, `password`, `perfil_id`, `email`, `tema`, `app_ajax`, `datagrid`, `registrado_at`, `modificado_in`) VALUES
(1, NULL, 1, 'cronjob', '963db57a0088931e0e3627b1e73e6eb5', 1, NULL, 'default', 1, 30, '2013-01-01 00:00:01', NULL),
(2, NULL, 2, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 'micorreo@gmail.com', 'default', 1, 30, '2013-01-01 00:00:01', '2013-10-23 19:02:23'),
(107, 0, 187, 'prueba', '93301ada8177f4b7841620847f3d06d41febdd1d', 2, 'prueba@gmail.com', 'default', 1, 30, '2020-06-28 12:08:42', '2020-06-28 12:14:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acceso_usuario_idx` (`usuario_id`);

--
-- Indices de la tabla `acuentas`
--
ALTER TABLE `acuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigo_cta` (`codigo_cta`),
  ADD KEY `nombre_cta` (`nombre_cta`);

--
-- Indices de la tabla `apresupgeneral`
--
ALTER TABLE `apresupgeneral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cuenta` (`cuenta_id`);

--
-- Indices de la tabla `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_backup_usuario_idx` (`usuario_id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empresa_tipo_nuip_idx` (`tipo_nuip_id`);

--
-- Indices de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estado_usuario_usuario_idx` (`usuario_id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_recurso_idx` (`recurso_id`),
  ADD KEY `fk_menu_menu_idx` (`menu_id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_persona_tipo_nuip_idx` (`tipo_nuip_id`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recurso_perfil`
--
ALTER TABLE `recurso_perfil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recurso_perfil_recurso_idx` (`recurso_id`),
  ADD KEY `fk_recurso_perfil_perfil_idx` (`perfil_id`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sucursal_empresa_idx` (`empresa_id`),
  ADD KEY `fk_sucursal_ciudad_idx` (`ciudad_id`);

--
-- Indices de la tabla `tipo_nuip`
--
ALTER TABLE `tipo_nuip`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_perfil_idx` (`perfil_id`),
  ADD KEY `fk_usuario_persona_idx` (`persona_id`),
  ADD KEY `fk_usuario_sucursal_idx` (`sucursal_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso`
--
ALTER TABLE `acceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del acceso', AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `acuentas`
--
ALTER TABLE `acuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `apresupgeneral`
--
ALTER TABLE `apresupgeneral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la ciudad', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la empresa', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del usuario', AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del menú', AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del perfil', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del recurso', AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `recurso_perfil`
--
ALTER TABLE `recurso_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3483;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificación de la sucursal', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tipo_nuip`
--
ALTER TABLE `tipo_nuip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del usuario', AUTO_INCREMENT=108;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apresupgeneral`
--
ALTER TABLE `apresupgeneral`
  ADD CONSTRAINT `apresupgeneral_ibfk_1` FOREIGN KEY (`cuenta_id`) REFERENCES `acuentas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
