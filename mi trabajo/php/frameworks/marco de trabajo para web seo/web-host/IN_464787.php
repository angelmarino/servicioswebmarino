<?php   
/**
 * MARCO DE TRABAJO DE PÁGINA WEB INGRUP 
 * =====================================
 *
 * Pasos de ejecución.
 *
 * 1. Nos conectamos a la base de datos del cliente nos descargamos la configuración inicial.
 * 
 * -----------------------------------------------------------------------
 *  
 * -----------------------------------------------------------------------
 *
 * @author Angel Luis Marino <angelluismarino@gmail.com> 
 * 
	* Programa creado en el tiempo libre de angel Luis :D
 */  
header("Cache-Control: must-revalidate");
 
header("Expires: ".gmdate("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
  
if(!isset($_SESSION)){session_start();} 
   
if(!ini_get('date.timezone')){ date_default_timezone_set('Europe/Paris'); }
  
setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");

/* 
** Verificamos el estado de la sesión de desarrollo. 
** Asi mostramos los errores del sitio web. 
*/ 
# if($_SESSION['dev']){ ini_set('display_errors', 1); error_reporting(E_ALL);}

#ini_set('display_errors', 1); error_reporting(E_ALL);

/*
 *---------------------------------
 * NOMBRE DE LA CARPETA DEL SISTEMA
 *---------------------------------
 *
 * Esta variable contiene en nombre de la carpeta del sistema.
 * Incluya la vía de acceso si la carpeta no está en el mismo directorio
 * como este archivo.
 *
 */

	$system_path = 'system';
 
	// Establezca el directorio actual correctamente para las solicitudes de la CLI

	if(defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if(realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// Asegurar que hay una barra diagonal
	$system_path = rtrim($system_path, '/').'/';

	// ¿Es correcta la ruta del sistema?
	if(!is_dir($system_path))
	{
		exit("La carpeta del sistema no está configurada correctamente. Por favor, abra el siguiente archivo: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Ahora que sabemos el camino, establecer las principales constantes de trayectoria
 * -------------------------------------------------------------------
 */
	// El nombre de este archivo
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// La extensión del archivo PHP
	// esta constante mundial está en desuso.

	define('EXT', '.php');

	// Camino a la carpeta del sistema. 
	define('BASEPATH', str_replace("\\", "/", $system_path));

	// Camino al controlador frontal (Este archivo)
	define('FCPATH', str_replace(SELF, '', __FILE__));

  // Nombre de la "carpeta de sistema"
  define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

  define("dir_img", dirname(__FILE__).'/img/');
 
 
/*
** Cargamos los archivos de configuracion del sitio web. */

require_once 'system/config-system.php'; 

/*
** Como hay más script que llaman al de inicio, indicamos una condición de estado. 
*/
 
    if(extension=='css'){ 
	
	header("Content-type: text/css"); 
	header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
	
	/* Cargamos los archivos css del sitio web básicos */
	for ($x = 1; $x <= $grupo_css_C; $x++) { 

		if($_GET['load']=='grupo_css_'.$x.'.css'){load_cache_css($grupo_css['web'][$x]);} 
	
	}
	 
	$ini_css = $grupo_css_C + 1;
	$fin_css = $grupo_css_C + $grupo_css_AC;
	
	/* Cargamos los archivos css del sitio web avanzados */
	for ($e = $ini_css; $e <= $fin_css; $e++){
  
		if($_GET['load']=='grupo_css_'.$e.'.css'){load_cache_css($grupo_css['admin'][$e]);} 
	
	}
	
}

elseif(extension=='js'){ 
				
	header("content-type:application/javascript"); 
	header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
 
	/* Cargamos los archivos js del sitio web básicos */
	for ($x = 1; $x <= $grupo_js_C; $x++) { 

		if($_GET['load']=='grupo_js_'.$x.'.js'){ load_cache_js($grupo_js['web'][$x]); } 
	
	}
	 
	$ini_js = $grupo_js_C + 1;
	$fin_js = $grupo_js_C + $grupo_js_AC;
	
	/* Cargamos los archivos js del sitio web avanzados */
	for ($e = $ini_js; $e <= $fin_js; $e++){
  
		if($_GET['load']=='grupo_js_'.$e.'.js'){load_cache_js($grupo_js['admin'][$e]);} 
 
	}
	  
}

elseif(extension=='html'){
	 
	/***************************************************************************/
	/**** Iniciamos la carga de complementos para el lanzamiento de la web. ****/
	/***************************************************************************/
    
	/* Iniciamos el control de versión */ 
	//web_key(dominio, 3);
	 
	
	require_once(ROOT.'plantillas/load.php');
 
} 
 
elseif(extension=='cron' and $_GET['load']=='modificaciones.cron'){
		
	error_reporting(0); 
	
	if(date("H:i")=='00:00'){ _cache_regenerate(); } 
	
	$db_gest_in->where('t_id', tb_cache);   
	$row_fecha = $db_gest_in->get('fx_tasks');  
   
	if($row_fecha[0]['due_date']==date("Y-m-d")){ _cache_regenerate();}
}

elseif(extension=='form' and $_GET['load']=='envia.form'){

	process_form(mail_admin,mail_cliente);

}



























?> 