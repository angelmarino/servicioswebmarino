-- MySQL dump 10.13  Distrib 5.5.48, for Linux (x86_64)
--
-- Host: localhost    Database: db_aplacat
-- ------------------------------------------------------
-- Server version	5.5.48

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `db_aplacat`
--


--
-- Table structure for table `264350_Meditor_config`
--

DROP TABLE IF EXISTS `264350_Meditor_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `264350_Meditor_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `objeto` char(100) NOT NULL,
  `valor` text NOT NULL,
  `operacion` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `objeto` (`objeto`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `264350_Meditor_config`
--

LOCK TABLES `264350_Meditor_config` WRITE;
/*!40000 ALTER TABLE `264350_Meditor_config` DISABLE KEYS */;
INSERT INTO `264350_Meditor_config` VALUES (1,'db_server','{\"servidor\":\"85.214.89.209\",\"db\":\"gestion_ingrup\",\"usuario\":\"user_Meditor\",\"clave\":\"Meditor_264350@.\",\"id_cliente\":\"43\"}','');
/*!40000 ALTER TABLE `264350_Meditor_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `264350_config`
--

DROP TABLE IF EXISTS `264350_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `264350_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `web_config` text NOT NULL,
  `social_config` text NOT NULL COMMENT 'Cada red social tendrá valor cero sino el nombre usuario',
  `email` varchar(50) NOT NULL COMMENT 'Email del cliente donde recibirá las notificaciones del sitio web.',
  `email_admin` varchar(50) NOT NULL COMMENT 'Email del administrador del sitio web aqui se envian los errores o insidencia ocurrida.',
  `empresa` text NOT NULL COMMENT 'Datos de la empresa en json Nombre, direccion, cif, ',
  `idioma` text NOT NULL COMMENT 'Idioma predeterminado del sitio web',
  `dat_config` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `264350_config`
--

LOCK TABLES `264350_config` WRITE;
/*!40000 ALTER TABLE `264350_config` DISABLE KEYS */;
INSERT INTO `264350_config` VALUES (1,'{\"host_img\":\"http://aplacat.com/img/\",\"logotipo\":\"logo-aplacat.jpg\"}','{\"Snapchat\":\"0\",\"Vkontakte\":\"0\",\"Sina Weibo\":\"0\",\"Tumblr\":\"0\",\"Twitter\":\"0\",\"Instagram\":\"0\",\"LinkedIn\":\"0\",\"Google+\":\"0\",\"QZone\":\"0\",\"Facebook\":\"0\",\"Pinterest\":\"0\"}','info@aplacat.com','programacio@ingrup.es','{\"nombre\":\"Aplacat\",\"direccion\":\"Carrer Can Mas Colomé 13, 08520 Corró d\'Avall, Barcelona\",\"cif\":\"0\",\"google_verifi\":\"0\",\"msn_verif\":\"0\",\"telefono\":\"648 617 369\"}','es','{\"display_error\":\"1\",\"ssl\":\"0\",\"zip\":\"1\",\"mantenimiento\":\"0\",\"mantenimiento_pass\":\"aplacat.com\"}');
/*!40000 ALTER TABLE `264350_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `264350_lang`
--

DROP TABLE IF EXISTS `264350_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `264350_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` char(30) NOT NULL,
  `asociado` char(250) NOT NULL,
  `contenido` text NOT NULL,
  `idioma` char(2) NOT NULL,
  `edit` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `264350_lang`
--

LOCK TABLES `264350_lang` WRITE;
/*!40000 ALTER TABLE `264350_lang` DISABLE KEYS */;
INSERT INTO `264350_lang` VALUES (1,'','enviar','Enviar','es',0),(3,'','enviar','Envia','ca',0),(26,'','todos','Todos','es',0),(27,'','todos','Tots','ca',0),(44,'','solicitarpresupuesto','Sol&middot;licitar pressupost','ca',0),(45,'','solicitarpresupuesto','Solicitar presupuesto','es',0),(46,'','contactaconnosotros','Contacta con nosotros','es',0),(47,'','contactaconnosotros','Contacta amb nosaltres','ca',0),(48,'','nombre','Nombre','es',0),(49,'','nombre','Nom','ca',0),(50,'','cognoms','Apellidos','es',0),(51,'','cognoms','Cognoms','ca',0),(54,'','mensaje','Missatge','ca',0),(55,'','mensaje','Mensaje','es',0),(62,'','fecha','Fecha','es',0),(63,'','fecha','Data','ca',0),(115,'','galeriadeimagenes','Galería de imágenes','es',0),(116,'','galeriadeimagenes','Galeria d\'imatges','ca',0),(135,'','required_nombre','Por favor escriba su nombre','es',0),(136,'','required_nombre','Si us plau escrigui el seu nom','ca',0),(137,'','required_apellidos','Por favor escriba sus apellidos','es',0),(138,'','required_apellidos','Si us plau escrigui els seus cognoms','ca',0),(139,'','required_email','Por favor escriba un email válido','es',0),(140,'','required_email','Si us plau escrigui un email vàlid','ca',0),(141,'','required_email_o','Por favor escriba un email','es',0),(142,'','required_email_o','Si us plau escrigui un email','ca',0),(143,'','required_telefono','Escriba un número de teléfono','es',0),(144,'','required_telefono','Introduïu un número de telèfon','ca',0),(145,'','required_mensaje','Por favor escriba un mensaje','es',0),(146,'','required_mensaje','Si us plau escrigui un missatge','ca',0),(147,'','required_servicios','Por favor seleccione un servicio','es',0),(148,'','required_servicios','Si us plau seleccioni un servei','ca',0),(149,'','send_mensaje','Su solicitud ha sido enviada.','es',0),(150,'','send_mensaje','La seva sol·licitud ha estat enviada.','ca',0),(151,'','send_mensaje_error','No se ha podido enviar la solicitud','es',0),(152,'','send_mensaje_error','No s\'ha pogut enviar la sol·licitud','ca',0),(153,'','telefono','Teléfono','es',0),(154,'','telefono','Telèfon','ca',0),(155,'','pag_mantenimiento_title','Página en mantenimiento','es',0),(156,'','pag_mantenimiento_title','Pàgina en manteniment','ca',0),(157,'','pag_mantenimiento_slug','Estamos actualizando nuestro sitio web, vuelva más tarde.','es',0),(158,'','pag_mantenimiento_slug','Estem actualitzant el nostre lloc web, torni més tard.','ca',0),(159,'','in_passacceso','Contraseña de acceso','es',0),(160,'','in_passacceso','Clau d\'accés','ca',0),(161,'','in_intro','Entrar','es',0),(162,'','in_intro','Entrada','ca',0),(163,'','menu_1_1','Inicio','es',0),(164,'','menu_1_2','Compañia','es',0),(165,'','menu_1_3','Proyectos','es',0),(166,'','menu_1_4','Servicios','es',0),(167,'','menu_1_5','Contacto','es',0),(170,'','menu_1_1','Inici','ca',0),(171,'','menu_1_2','Companyia','ca',0),(172,'','menu_1_3','Projectes','ca',0),(173,'','menu_1_4','Serveis','ca',0),(174,'','menu_1_5','Contacte','ca',0),(177,'','aviso404','Lo sentimos la página solicitada no está disponible','es',0),(178,'','aviso404text','Puede que la página ya no esté disponible. :(','ca',0),(179,'','aviso404','Ho sentim la pàgina sol·licitada no està disponible','es',0),(180,'','aviso404text','Pot ser que la pàgina ja no estigui disponible. :(','ca',0),(181,'','avisomantenimiento','Nuestro sitio web está en mantenimiento','es',0),(182,'','avisomantenimiento','El nostre lloc web està en manteniment','ca',0),(183,'','avisoconstruccion','Lloc web en construcció','ca',0),(184,'','avisoconstruccion','Sitio web en construcción','es',0),(185,'','in_cookies','Utilizamos cookies propias y de terceros para evaluar el uso que se hace de la Web y la actividad general de la misma. Si usted continua navegando, consideramos que acepta su uso. Puede cambiar la configuración y obtener más información.','',0),(186,'','in_cookies','Utilizamos cookies propias y de terceros para evaluar el uso que se hace de la Web y la actividad general de la misma. Si usted continua navegando, consideramos que acepta su uso. Puede cambiar la configuración y obtener más información.','',0),(187,'system','enviarsolicitud','Enviar solicitud','es',0),(188,'system','enviarsolicitud','Enviar sol·licitud','ca',0),(189,'system','enviando','Enviando','es',0),(190,'system','enviando',' Enviant','ca',0),(191,'system','cerrarv','Cerrar','es',0),(192,'system','cerrarv','Tancar','ca',0),(195,'','direccion','Dirección','es',0),(196,'','direccion','Direcció','ca',0),(197,'web','sobrenosotros','Sobre Nosotros','es',0),(198,'web','sobrenosotros','Sobre Nosaltres','ca',0),(199,'web','informacion','información','es',0),(200,'web','informacion','informació','ca',0),(201,'web','contacto','Contacto','es',0),(202,'web','contacto','Contacte','ca',0),(204,'web','proyecto','Proyectos','es',0),(205,'web','servicios','Servicios','es',0),(206,'web','quehacemos','Que hacemos','es',0),(207,'web','contacto','Contacto','es',0),(208,'web','text_footer','Compañia líder en el sector del montaje de sistemas de yeso laminado o Pladur y el montaje de todo tipo de materiales para la construcción en seco. ','es',0),(209,'web','trabajos_realizados','Proyectos realizados','es',0),(210,'web','trabajos_realizados','Projectes realitzats','ca',0),(211,'web','nuestro_compromiso','Nuestro compromiso','es',0),(212,'web','nuestro_compromiso','El nostre compromís','ca',0),(213,'web','que_hacemos','¿Qué hacemos?','es',0),(214,'web','que_hacemos','Què fem?','ca',0),(215,'web','donde_estamos','¿Quieres saber dónde estamos?<br>¡Miralo desde Goolge Maps!<br>','es',0),(216,'web','donde_estamos','Vols saber on som?<br>\'Miralo des de Google Maps!<br>','ca',0),(217,'web','ultimostrabajos','Últimos trabajos','es',0),(218,'web','ultimostrabajos','Últims treballs','ca',0),(219,'web','mostrar todos','Todos los proyectos','es',0),(220,'web','mostrar todos','Tots els projectes','ca',0),(221,'web','solicita presupuesto ya','¡SOLICITA PRESUPUESTO YA!','es',0),(222,'web','solicita presupuesto ya','SOL·LICITA PRESSUPOST JA!','ca',0),(223,'web','proyecto','Projectes','ca',0),(224,'web','servicios','Serveis','ca',0),(225,'web','text_footer','Companyia líder en el sector del muntatge de sistemes de guix laminat o Pladur i el muntatge de tot tipus de materials per a la construcció en sec.','ca',0),(226,'web','lideres pladur','Líderes en la instalación con Pladur.','es',0),(227,'web','lideres pladur','Líders en la instal·lació amb Pladur.','ca',0),(228,'web','trabajos_realizados','Trabajos realizados ','es',0),(229,'web','trabajos_realizados',' Treballs realitzats','ca',0),(230,'web','formulario contacto','Formulario de contacto','es',0),(231,'web','formulario contacto','Formulari de contacte','ca',0),(232,'web','proveedores','Proveedores','es',0),(233,'web','proveedores','Proveïdors','ca',0),(234,'web','elproyecto','El proyecto','es',0),(235,'web','elproyecto','El projecte','ca',0),(236,'web','losdetalles','Los detalles','es',0),(237,'web','losdetalles','Els detalls','ca',0),(238,'web','categoria','Categoría','es',0),(239,'web','categoria','Categoria','ca',0),(240,'web','anoejecucion','Año de ejecución','es',0),(241,'web','anoejecucion','Any d\'execució','ca',0),(242,'','seleccioneunservicio','Selecione un servicio','es',0),(243,'','seleccioneunservicio','Seleccioni un servei','ca',0),(244,'','otrosservicios','Otros','es',0),(245,'','otrosservicios','Altres','ca',0),(246,'','info_novedades','¿Quieres estar informado de todas nuestras novedades en Pladur?','es',0),(247,'','info_novedades','Vols estar informat de totes? Les nostres novetats en Pladur?','ca',0),(248,'','suscribete','Suscríbete a nuestra Newsletter','es',0),(249,'','suscribete','Subscriu-te a la nostra Newsletter','ca',0),(250,'','suscribete_btn','SUSCRIBETE','es',0),(251,'','suscribete_btn','SUBSCRIU','ca',0),(252,'','detalleservicio','Detalles del servicios','es',0),(253,'','detalleservicio',' Detalls del serveis','ca',0),(254,'','','','',0),(255,'','','','',0),(256,'','','','',0),(257,'','','','',0),(258,'','','','',0),(259,'','','','',0),(260,'','','','',0),(261,'','','','',0),(262,'','','','',0),(263,'','','','',0),(264,'','','','',0),(265,'','','','',0),(266,'','','','',0),(267,'','','','',0),(268,'','','','',0),(269,'','','','',0),(270,'','','','',0),(271,'','','','',0),(272,'','','','',0),(273,'','','','',0),(274,'','','','',0),(275,'','','','',0),(276,'','','','',0),(277,'','','','',0),(278,'','','','',0),(279,'','','','',0),(280,'','','','',0),(281,'','','','',0),(282,'','','','',0),(283,'','','','',0),(284,'','','','',0),(285,'','','','',0),(286,'','','','',0),(287,'','','','',0),(288,'','','','',0),(289,'','','','',0),(290,'','','','',0),(291,'','','','',0),(292,'','','','',0),(293,'','','','',0),(294,'','','','',0),(295,'','','','',0),(296,'','','','',0),(297,'','','','',0),(298,'','','','',0),(299,'','','','',0),(300,'','','','',0),(301,'','','','',0),(302,'','','','',0),(303,'','','','',0),(304,'','','','',0),(305,'','','','',0),(306,'','','','',0),(307,'','','','',0),(308,'','','','',0),(309,'','','','',0),(310,'','','','',0),(311,'','','','',0),(312,'','','','',0),(313,'','','','',0),(314,'','','','',0),(315,'','','','',0),(316,'','','','',0),(317,'','','','',0),(318,'','','','',0),(319,'','','','',0),(320,'','','','',0),(321,'','','','',0),(322,'','','','',0),(323,'','','','',0),(324,'','','','',0),(325,'','','','',0),(326,'','','','',0),(327,'','','','',0),(328,'','','','',0),(329,'','','','',0),(330,'','','','',0),(331,'','','','',0),(332,'','','','',0),(333,'','','','',0),(334,'','','','',0),(335,'','','','',0),(336,'','','','',0),(337,'','','','',0),(338,'','','','',0),(339,'','','','',0),(340,'','','','',0),(341,'','','','',0),(342,'','','','',0),(343,'','','','',0),(344,'','','','',0),(345,'','','','',0),(346,'','','','',0),(347,'','','','',0),(348,'','','','',0),(349,'','','','',0);
/*!40000 ALTER TABLE `264350_lang` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-24 12:32:01

