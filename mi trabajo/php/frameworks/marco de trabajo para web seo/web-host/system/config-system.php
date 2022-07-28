<?php if(!defined('BASEPATH')) exit('Acceso no permitido.'); 

/*

*******************************************
*******************************************
**                                       **
** PARÁMETROS DE CONFIGURACIÓN GENÉRICAS **
**                                       **
*******************************************
*******************************************

*/

/*
** Establecemos las tablas de la base de datos
*/
/* 1 */ define("db_idioma", '264350_lang'); /* Tabla de idioma*/
/* 2 */ define("db_config", '264350_config'); /* Tabla de configuraciones genericas */ 
/* 6 */ define("db_medit_config", '264350_Meditor_config'); /* Tabla de configuracion de Meditor*/ 

// Lista de idiomas que estrán cargados en el sitio web.

const is = array('es','ca');
/*
** Establecemos el directorio raiz del sitio web.
*/
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__).DS); /* El directorio raiz es hasta system */
  
/* 
** Configuración para la función load_cache(); 
*/
define("time_cache", 86400);    /* Establecido 1 dia de chache por pagina */ 
define("dir_chache", ROOT.'cache/'); /* Archivo de almacenamiento de la cache */ 
define("ext_chache", 'cache');  /* Extención del archivo de chache */

define("load_chache", true);

/*
** Definimos ruta de los archivos css
*/

define("css_web", ROOT.'css/');

/* Definimos otros archivo css */
define("css_vendor", 'vendor/');

define('extension', extension($_SERVER['REQUEST_URI']));

function extension($archivo){ 
	
	$partes = explode(".", $archivo); 
	
	$extension = end($partes); 
	
	return $extension;
}
							

/*
** Iniciamos la carga de las clases.
*/

if(extension=='html' or extension=='form' or extension=='cron'){

	/* Control de versiones */
	define("url_webkey", 'https://get.ingrup.es/api/');
	define("url_analytics", 'analytics.ingrup.es');
	
	$_SESSION['dev']=FALSE;
	
	require_once ROOT.'load.class.php';

	// Iniciamos la conexion con la base de datos de configuración.

	$db_web = new MysqliDb('localhost', 'user_aplacat', 'IN_grup.341@aplacat', 'db_aplacat');

	$load_db = $db_web->get(db_config);
 
	$load_config = json_decode($load_db['0']['dat_config']);
 
	define("display_error", $load_config->{'display_error'});

	define("ssl", $load_config ->{'ssl'});
	
	define("optimize", $load_config ->{'zip'});
	
	define("mantenimiento", $load_config ->{'mantenimiento'});
	
	define("mantenimiento_pass", $load_config ->{'mantenimiento_pass'});
	 
	/*
	** Idioma predeterminado del sitio web.
	*/
		
	define("i", $load_db['0']['idioma']);
		
	define("mail_admin", $load_db['0']['email_admin']);
		
	define("mail_cliente", $load_db['0']['email']);

	define("datos_empresa", $load_db['0']['empresa']);
	
	define("datos_web", $load_db['0']['web_config']);
	
	define("configuracion_social", $load_db['0']['social_config']);
	 
	/* Sacamos la configuración guardada en el editor */ 

	$db_web->where("id", 1);

	$db_medit_config = $db_web->getOne(db_medit_config);

	define("get_medit_config", $db_medit_config['valor']);
	
	/* Para poder proceder con las modificaciones del sitio web recojemos de la base de datos el id del proyecto */
	
	$db_web->where("id", 3);

	$db_medit_config = $db_web->getOne(db_medit_config);

	define("proyecto_activo", $db_medit_config['valor']);

	$medit_config = json_decode(get_medit_config);

	define('id_cliente',$medit_config->{'id_cliente'});
	
	$db_gest_in = new MysqliDb($medit_config->{'servidor'}, $medit_config->{'usuario'}, $medit_config->{'clave'}, $medit_config->{'db'});
 
} 
/*
** Iniciamos la carga de las funciones.
** La carga de las funciones no se puede mover de este sitio ya que requiere de las 
** confiraciones descargadas de la base de dados para funcionar.
*/
require_once ROOT.'load.func.php';


if($_SERVER['REQUEST_URI']=='/'){	redirect(url_actual().'es/inicio.html',$code=301);}

/*
** Cargamos la configuración para la plantilla web.
*/
require_once ROOT.'config-web.php';
 
if(extension=='html' or extension=='form'){
  
	/* Sacamos el estado de la página */
	$db_gest_in->where('project_id', db_sitioweb_ec);
	$progress = $db_gest_in->get('fx_projects');  

	/* 
	** Sacamos el progreso o porcentaje del sitio web 
	** si este tiene un valor igual a 100 procedemos con la publicación del sitio web.
	*/
	define('progress_project',$progress[0]['progress']); 
	 
	/*
	** El estado nos dice en que condición de desarrollo se encuentra el sitio web.
	*/
	define('status_project',$progress[0]['status']);
	
	_progress_project();

/*
** Repasamos los datos que se envian y el tiempo de intervalo de envío.
*/

	include_once ROOT.'secure.php';

	$ifilter = new InputFilter();

	$ifilter = isset($ifilter) ? $ifilter : null ;
 
	$detect = new Mobile_Detect();
	
	$detect = isset($detect) ? $detect : null ;
 
#############################################################################

	//include ROOT.'core/captcha/captcha.php'; // Elemento desactivado por no ser necesario en el sitio web.

	// Include ROOT.'config/reenvio.php'; // Elemento desactivado por no ser necesario en el sitio web.

//	$_SESSION['captcha'] = simple_php_captcha();

	//$IN_CAPTCHA_CODE = $_SESSION['captcha']['code'];

	//$IN_CAPTCHA = '<img class="rounded img-responsive" src="' . $_SESSION['captcha']['image_src'] . '" alt="IN-CAPTCHA">';
	
}

#############################################################################
?>
 