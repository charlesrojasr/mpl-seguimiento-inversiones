-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2025 a las 18:21:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `admin_db_arbolado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_actividad`
--

CREATE TABLE `dashboard_seg_actividad` (
  `id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `actividad` varchar(1000) NOT NULL,
  `indicadores` varchar(1000) NOT NULL,
  `meta` varchar(45) NOT NULL,
  `avance` varchar(45) NOT NULL,
  `detalle` varchar(1000) NOT NULL,
  `porcentaje` varchar(50) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `fecha_registro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_actividad`
--

INSERT INTO `dashboard_seg_actividad` (`id`, `area_id`, `actividad`, `indicadores`, `meta`, `avance`, `detalle`, `porcentaje`, `estado_id`, `fecha_registro`) VALUES
(1, 2, 'IMPLEMENTAR UN SISTEMA DE COMPRAS VERDES PARA LA MUNICIPALIDAD.', 'SISTEMA DE COMPRAS VERDES IMPLEMENTADOS', '2', '2', 'EN INTERNO LA IMPLEMENTACIÓN DEL SGD REDUJO LA COMPRA DEL PAPEL EN LAS DISTINTAS AREAS./EN LO EXTERNO SE REALIZO LA ADQUISICIÓN DE LAS LUCES LED PARA ILUMINAR EL DISTRITO.', '100', 3, '2025-11-25 17:18:12'),
(2, 5, 'PLAN DE SEGURIDAD CIUDADANA', 'PLAN ELABORADO Y ACTUALIZADO ANUALMENTE', '1', '1', 'SE CUENTA CON UN PLAN DE ACCIÓN DISTRITAL DE SEGURIDAD CIUDADANA 2024-2027, CON UN HORIZONTE TEMPORAL DE CUATRO AÑOS CONFORME A LA NORMATIVA VIGENTE. APROBADO CON ORDENANZA MUNICIPAL 619 - MPL DEL 14 DE FEBRERO DEL 2024.', '100', 3, '2025-11-25 17:19:07'),
(3, 5, 'OPTIMIZACIÓN VERTICAL DE LA RESPUESTA INMEDIATA DE NUESTRAS FUERZAS ANTE UN HECHO DELICTIVO EN PROCESO. INTEGRACIÓN DINÁMICA Y PERMANENTE DEL EJE VECINO - MUNICIPALIDAD - POLICÍA NACIONAL', 'IMPLEMENTACIÓN DE MECANISMO DE OPTIMIZACIÓN DE RESPUESTA INMEDIATA', '1', '1', 'SE HA DOTADO A LA COMISARÍA DE PUEBLO LIBRE DE 08 CELULARES PARA UNA COMUNICACIÓN MÁS DIRECTA CON LOS VECINOS POR CADA SECTOR Y DE 05 RADIOS ASIGNADAS A CADA PATRULLERO PARA QUE UNA REACCIÓN MÁS RÁPIDA ANTE UN HECHO DELICTIVO, SE HA REACTIVADO LA VISUALIZACIÓN DE LAS CÁMARAS DE VIDEO VIGILANCIA EN LA CENTRAL DE LA COMISARÍA.', '100', 3, '2025-11-25 17:19:42'),
(4, 5, 'CONVOCATORIA Y CAPACITACIÓN DE UN CUERPO DE ACCIONES RÁPIDAS CONFORMADO ÚNICAMENTE POR LICENCIADOS DE LAS FFAA EN APOYO A LA COMISARÍA DEL SECTOR Y A LAS FUERZAS REGULARES DEL SERENAZGO.', 'CUERPO DE ACCIONES RÁPIDAS CONFORMADO Y OPERATIVO', '1', '1', 'EL CUERPO DE SERENAZGO TIENE DENTRO DE SUS GRUPO DE TRABAJO EL GRUPO DE INTERVENCIÓN RÁPIDA (GIR) Y LOS MOTORIZADOS DE INTERVENCIÓN RÁPIDA (MIR).', '100', 3, '2025-11-25 17:21:53'),
(5, 5, 'FORMACIÓN DE UN GRUPO DE PATRULLAJE MIMETIZADO (DE CIVIL) EN ZONAS DE ALTO FLUJO PEATONAL Y VEHICULAR.', 'GRUPO DE PATRULLAJE MIMETIZADO', '1', '0', 'NORMATIVAMENTE NO SE PUEDE DAR CUMPLIMIENTO A ESTE COMPROMISO EN RAZÓN QUE LA LEY DE SERENAZGO ESTABLECE EL USO DE UN UNIFORME ÚNICO PARA EFECTUAR EL SERVICIO DE SERENAZGO, FORMAR UN GRUPO QUE ACTÚE DE CIVIL NO ESTA DENTRO DE SUS FACULTADES Y PODRÍAN TRAER PROBLEMAS LEGALES SUS INTERVENCIONES.', '0', 1, '2025-11-25 17:22:25'),
(6, 5, 'IMPLEMENTACIÓN DE UN ÁREA DE INTELIGENCIA OPERATIVA DEPENDIENTE DIRECTAMENTE DE LA GERENCIA DE SEGURIDAD CIUDADANA Y MANEJO DE INFORMACIÓN SENSIBLE CON LA COMISARÍA DEL SECTOR', 'AREA IMPLEMENTADA', '1', '1', 'SE TRABAJA PERMANENTEMENTE CON LA COMISARÍA Y EL DEPINCRI REMITIENDO LA INFORMACIÓN OBTENIDA POR LOS SERENOS O REMITIDA POR LOS VECINOS REFERENTES A POSIBLE ACTIVIDAD DELICTIVA EN EL DISTRITO.', '100', 3, '2025-11-25 17:23:18'),
(7, 5, 'EL PLAN INTEGRAL DE SEGURIDAD PÚBLICA PISP TENDRÁ UN HORIZONTE TEMPORAL DE UN AÑO SUJETO A EVALUACIÓN, REVISIÓN, Y REDISEÑO DE SER NECESARIO. MÁXIMA EN FENOMENOLOGÍA SOCIAL: LO SOCIAL ES ALTAMENTE DINÁMICO.', 'PLAN ELABORADO', '1', '1', 'SE CUENTA CON UN PLAN DE ACCIÓN DISTRITAL DE SEGURIDAD CIUDADANA 2024-2027 CON UN HORIZONTE DE 04 AÑOS, ESTABLECIDO POR LA NORMATIVA DE SEGURIDAD CIUDADANA VIGENTE.', '100', 3, '2025-11-25 17:24:26'),
(8, 5, 'EMPADRONAMIENTO Y CAPACITACIÓN DE LOS VIGILANTES INDEPENDIENTES DE CUADRA PARA INCORPORARLOS TÉCNICAMENTE AL NUEVO SISTEMA FRONTAL DE COMBATE A LA DELINCUENCIA.', 'PADRON DE VIGLANTES ACTUALIZADO', '1', '1', 'LOS VIGILANTES PARTICULARES DE LOS OCHO SECTORES SE ENCUENTRAN DEBIDAMENTE IDENTIFICADOS.', '100', 3, '2025-11-25 17:25:15'),
(9, 5, 'ESTABLECIMIENTO DE 01 JORNADA ANUAL DE TRABAJO, INTERCAMBIO DE EXPERIENCIAS, CAPACITACIÓN, CON PERSONAL DE CARABINEROS DE CHILE (UNA DE LAS MEJORES FUERZAS POLICIALES DE LATINOAMÉRICA) Y CON EL CENTRO DE ESTUDIOS EN SEGURIDAD CIUDADANA DE LA UNIVERSIDAD DE CHILE.', 'JORNADA DE TRABAJO', '1', '0', 'SE REALIZARÁ INTERCAMBIO DE MANERA VCIRTUAL EN 2026', '0', 1, '2025-11-25 17:25:42'),
(10, 5, 'ESTABLECIMIENTO DE UNA BRIGADA DE APOYO INMEDIATO A LAS VÍCTIMAS DE LA DELINCUENCIA Y VIOLENCIA DOMÉSTICA SEA EN TEMAS DE DENUNCIAS POLICIALES APOYO PSICOLÓGICO, MÉDICOS, DE TAL FORMA QUE LA VÍCTIMA VEA EL APOYO DE SU MUNICIPALIDAD EN CASO DE DARSE UN EVENTO CRIMINAL.', 'BRIGADA DE APOYO CONFORMADA', '1', '0', 'IMPLICA LA CONTRATACIÓN DE PERSONAL PROFESIONAL EN DERECHO, PSICOLOGÍA QUE PUEDAN REALIZAR EL APOYO EN EL MOMENTO DEL HECHO Y UN SEGUIMIENTO DEL CASO, LO QUE GENERARÍA UN PRESUPUESTO ADICIONAL.', '0', 4, '2025-11-25 17:51:09'),
(11, 5, 'REACTIVACIÓN Y POTENCIAMIENTO DE LA BRIGADA CANINA', 'PROGRAMA DE REACTIVACIÓN DE BRIGADA CANINA', '1', '1', 'SE CUENTA CON UNA BRIGADA CANINA CON 8 CANES Y CON LAS INSTALACIONES DE SUS CANILES RENOVADAS. LA BRIGADA CANINA ADEMÁS DE LA LABOR PROPIA DE SEGURIDAD SE PROYECTA A LA COMUNIDAD A TRAVÉS DEL TOUR DE LAS COLITAS.', '100', 3, '2025-11-25 18:17:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_area`
--

CREATE TABLE `dashboard_seg_area` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_area`
--

INSERT INTO `dashboard_seg_area` (`id`, `nombre`, `estado`) VALUES
(1, 'ALCALDÍA', '1'),
(2, 'GERENCIA DE ADMINISTRACIÓN', '1'),
(3, 'GERENCIA DE ASESORÍA JURÍDICA', '1'),
(4, 'GERENCIA DE COMUNICACIONES E IMAGEN INSTITUCIONAL', '1'),
(5, 'GERENCIA DE COORDINACIÓN DE LA SEGURIDAD CIUDADANA', '1'),
(6, 'GERENCIA DE CULTURA, TURISMO Y EDUCACIÓN', '1'),
(7, 'GERENCIA DE DESARROLLO HUMANO', '1'),
(8, 'GERENCIA DE DESARROLLO URBANO Y DEL AMBIENTE', '1'),
(9, 'GERENCIA DE DISEÑO, INNOVACIÓN Y DESARROLLO SOSTENIBLE', '1'),
(10, 'GERENCIA DE PLANEAMIENTO Y PRESUPUESTO', '1'),
(11, 'GERENCIA DE RENTAS Y DESARROLLO ECONÓMICO', '1'),
(12, 'GERENCIA DE TECNOLOGÍA DE LA INFORMACIÓN', '1'),
(13, 'GERENCIA MUNICIPAL', '1'),
(14, 'ORGANO DE CONTROL INSTITUCIONAL', '1'),
(15, 'PROCURADURIA', '1'),
(16, 'SECRETARÍA GENERAL', '1'),
(17, 'SUBGERENCIA DE ATENCIÓN AL CIUDADANO Y GESTIÓN DOCUMENTAL', '1'),
(18, 'SUBGERENCIA DE CONTABILIDAD', '1'),
(19, 'SUBGERENCIA DE DESARROLLO EMPRESARIAL Y COMERCIALIZACIÓN', '1'),
(20, 'SUBGERENCIA DE FISCALIZACIÓN Y SANCIONES ADMINISTRATIVAS', '1'),
(21, 'SUBGERENCIA DE GESTIÓN AMBIENTAL', '1'),
(22, 'SUBGERENCIA DE GESTIÓN DE RIESGO DE DESASTRES', '1'),
(23, 'SUBGERENCIA DE JUVENTUD Y DEPORTES', '1'),
(24, 'SUBGERENCIA DE LOGÍSTICA Y PATRIMONIO', '1'),
(25, 'SUBGERENCIA DE OBRAS PRIVADAS Y HABILITACIONES URBANAS', '1'),
(26, 'SUBGERENCIA DE OBRAS PÚBLICAS Y CATASTRO', '1'),
(27, 'SUBGERENCIA DE PARTICIPACIÓN VECINAL', '1'),
(28, 'SUBGERENCIA DE RECAUDACIÓN Y EJECUTORIA COACTIVA', '1'),
(29, 'SUBGERENCIA DE RECURSOS HUMANOS', '1'),
(30, 'SUBGERENCIA DE REGISTRO Y FISCALIZACIÓN TRIBUTARIA', '1'),
(31, 'SUBGERENCIA DE TESORERÍA', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_estado`
--

CREATE TABLE `dashboard_seg_estado` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_estado`
--

INSERT INTO `dashboard_seg_estado` (`id`, `descripcion`) VALUES
(1, 'Sin Iniciar'),
(2, 'En Progreso'),
(3, 'Completado'),
(4, 'Otra estrategia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_permissions`
--

CREATE TABLE `dashboard_seg_permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL,
  `permission_modulo` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_permissions`
--

INSERT INTO `dashboard_seg_permissions` (`id`, `permission_name`, `permission_modulo`) VALUES
(1, 'actividades', 'Actividades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_roles`
--

CREATE TABLE `dashboard_seg_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_roles`
--

INSERT INTO `dashboard_seg_roles` (`id`, `role_name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_role_permissions`
--

CREATE TABLE `dashboard_seg_role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_role_permissions`
--

INSERT INTO `dashboard_seg_role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dashboard_seg_users`
--

CREATE TABLE `dashboard_seg_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dashboard_seg_users`
--

INSERT INTO `dashboard_seg_users` (`id`, `username`, `password`, `role_id`) VALUES
(1, 'administrador', '$2y$10$wUoGZ3tS80hU9OqlcVetFuYkSKsj/L5kNFS14lFI3Ctys6COnSI4.', 1),
(2, 'achuquimango', '$2y$10$yl.LAe72PQRfzVS7JZMv6Oq7A5aFvsRmjdTfTFkZ1RbS8msxnBs2K', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dashboard_seg_actividad`
--
ALTER TABLE `dashboard_seg_actividad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha_registro_UNIQUE` (`fecha_registro`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `estado_id` (`estado_id`);

--
-- Indices de la tabla `dashboard_seg_area`
--
ALTER TABLE `dashboard_seg_area`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dashboard_seg_estado`
--
ALTER TABLE `dashboard_seg_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dashboard_seg_permissions`
--
ALTER TABLE `dashboard_seg_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dashboard_seg_roles`
--
ALTER TABLE `dashboard_seg_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dashboard_seg_role_permissions`
--
ALTER TABLE `dashboard_seg_role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dashboard_seg_users`
--
ALTER TABLE `dashboard_seg_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_actividad`
--
ALTER TABLE `dashboard_seg_actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_area`
--
ALTER TABLE `dashboard_seg_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_estado`
--
ALTER TABLE `dashboard_seg_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_permissions`
--
ALTER TABLE `dashboard_seg_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_roles`
--
ALTER TABLE `dashboard_seg_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_role_permissions`
--
ALTER TABLE `dashboard_seg_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dashboard_seg_users`
--
ALTER TABLE `dashboard_seg_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dashboard_seg_actividad`
--
ALTER TABLE `dashboard_seg_actividad`
  ADD CONSTRAINT `fk_actividad_area` FOREIGN KEY (`area_id`) REFERENCES `dashboard_seg_area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_actividad_estado` FOREIGN KEY (`estado_id`) REFERENCES `dashboard_seg_estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
