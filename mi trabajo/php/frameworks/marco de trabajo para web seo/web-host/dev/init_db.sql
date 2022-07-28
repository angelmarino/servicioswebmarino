SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
 
--
-- Estructuras de las tablas del sitio web
--
CREATE TABLE IF NOT EXISTS `264350_lang` (
  `id` int(11) NOT NULL,
  `asociado` char(250) NOT NULL,
  `es` longtext NOT NULL,
  `ca` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
CREATE TABLE IF NOT EXISTS `264350_config` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL COMMENT 'Opción de pag en mantenimiento ',
  `email` varchar(50) NOT NULL COMMENT 'Email del cliente donde recibirá las notificaciones del sitio web.',
  `email_admin` varchar(50) NOT NULL COMMENT 'Email del administrador del sitio web aqui se envian los errores o insidencia ocurrida.',
  `empresa` text NOT NULL COMMENT 'Datos de la empresa en json Nombre, direccion, cif, ', 
  `idioma` text NOT NULL COMMENT 'Idioma predeterminado del sitio web'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `264350_config` (`id`, `estado`, `email`, `email_admin`, `empresa`, `idioma`) VALUES (2, '{"estado":"false","password":"fresgrup.com"}', 'info@fresgrup.com', 'programacio@ingrup.es', '{"nombre":"Fresgrup Obres i Serveis S.L.","direccion":"C/ Once de Septiembre, 12-14 08100 Mollet del Vallés","cif":""}', 'es');
 
CREATE TABLE IF NOT EXISTS `264350_servicios` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL COMMENT 'Título del servicio a usar no puede estar en blaco ya que se usará como url',
  `descripcion` text NOT NULL COMMENT 'Descripción corta usada para el seo o descripcion de la página.',
  `descripcion_larga` longtext NOT NULL COMMENT 'Aqui se muestra el contenido en html',
  `imagen` text NOT NULL COMMENT 'Imagen destacada del servicio',
  `idioma` char(2) NOT NULL COMMENT 'Idioma cargado para esta publicacion',
	 `rediret` char(100) NOT NULL COMMENT 'Url de traslado en caso que el sitio que cambie de url',
	 `estado` char(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 
CREATE TABLE IF NOT EXISTS `264350_trabajos` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `descripcion` text NOT NULL,
  `descripcion_larga` longtext NOT NULL,
  `img_dest` char(255) NOT NULL,
  `estado` char(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 
CREATE TABLE IF NOT EXISTS `264350_contactos` (
  `id` int(11) NOT NULL,
  `fecha` char(50) NOT NULL,
  `mensaje` longtext NOT NULL,
  `email` char(60) NOT NULL,
  `telf` char(40) NOT NULL,
  `ip` char(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
  
ALTER TABLE `264350_config` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `estado` (`estado`);
 
ALTER TABLE `264350_servicios` ADD PRIMARY KEY (`id`);

--
-- Indexamos las tablas y terminados la configuración
--

ALTER TABLE `264350_lang` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `asociado` (`asociado`);
 
ALTER TABLE `264350_lang` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT; 
 
ALTER TABLE `264350_trabajos` ADD PRIMARY KEY (`id`);

ALTER TABLE `264350_contactos` ADD PRIMARY KEY (`id`);

ALTER TABLE `264350_config` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `264350_servicios` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `264350_trabajos` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `264350_contactos` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;