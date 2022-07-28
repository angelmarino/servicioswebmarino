<?php 

if(!defined('BASEPATH')) exit('El acceso no permitido :( '); 
header("Cache-Control: must-revalidate"); 
header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí albergamos las funciones de optimización y cacheo del sitio web web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
** Update: 17-12-2015 
*/ 

function compress_css($buffer) { 
  
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
   
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    
	return $buffer;
  
}
	
function compress_js($buffer){
	 
	/* DOC:  http://www.desarrolloweb.com/articulos/comprimir-archivos-javascript-desde-php.html https://github.com/rgrove/jsmin-php/blob/master/jsmin.php */ 
	
	$ruta_jszip = ROOT."core/class/jsmin.php"; 
	
	if(file_exists($ruta_jszip) and js_zip==true) {
		// El archivo exite 
		include_once(ROOT."core/class/jsmin.php");
		// Lamamos a la clase inicializando el contenido.
		$buffer = JSMin::minify($buffer); 
	} 
	elseif(js_zip==false){ $buffer=$buffer; }
	
	else { 
		// Lanzamos una notificación al administrador del sitio web.
		notifi(mail_admin, 'Fallo de carga en script', send_error()); 
		
		// Pasamos el bufer a false para que no de error y continue la ejecucion del codigo.
		$buffer=false;
	}
	
	return $buffer;
}

function compress($al_file, $detect,$db_web){
	
	$buf = isset($buf) ? $buf : null ;
	
	$buf = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"), array('',' '), str_replace(array("\n","\r","\t"),'',$buf));
   
	function ob_html_compress($buf){
		/* Limpiamos el código html del sitio. */
		return preg_replace(array('//Uis',"/[[:blank:]]+/"), array('',' '), str_replace(array("\n","\r","\t"),'',$buf));
	}
	
	/*
	** Activamos el almacenamiento en búfer de la salida. 
	*/ 
	ob_start("ob_html_compress"); 
	header("Content-type: text/html; charset=utf-8");
  
	/*
	** Incluimos el archivo de inicio o a comprimir.
	*/
	
	include_once ROOT."plantillas/".$al_file;
	 
	ob_end_flush();
	
}

function load_cache_html($archivo){
	
	global $detect;
	global $db_web;
	global $db_gest_in;
	 
	$cachefile = dir_chache.md5(dominio.uri).$detect->isMobile().'.html.'.ext_chache;

	// calculamos el tiempo del cache

	if(file_exists($cachefile)){
  
		$cachelast = filemtime($cachefile);

	} else { $cachelast = 0; }

	// Mostramos el archivo si aun no vence
  
	$opera = (time()-time_cache);
	
	if($opera < $cachelast) { readfile($cachefile); exit(); }
 
	/* Si el archivo de cache se encuentra detenemos el scritp 
	** En caso contrario continuamos con la ejecución */
	
	$buf = isset($buf) ? $buf : null ;
	
	$buf = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"), array('',' '), str_replace(array("\n","\r","\t"),'',$buf));
   
	function ob_html_compress($buf){
		/* Limpiamos el código html del sitio. */
		return preg_replace(array('//Uis',"/[[:blank:]]+/"), array('',' '), str_replace(array("\n","\r","\t"),'',$buf));
	}
	
	ob_start(); 
  
	header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
	header('Cache-Control: public');
	
	require_once "system/plantillas/".$archivo;
	  
	// Primero vamos a asegurarnos de que el archivo existe y es escribible. 
	if (!$gestor = fopen($cachefile, 'a')) { 
		
		$msg = "No se puede abrir el archivo ($cachefile)";
		// Lanzamos una notificación al administrador del sitio web.
		notifi(mail_admin, $msg, send_error()); 
		exit;
	}
	
	$compress =	ob_get_contents();
	
	if (is_writable($cachefile)) {

		$buf = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"), array('',' '), str_replace(array("\n","\r","\t"),'',$compress));
		
		// En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adición. 
		// El puntero al archivo está al final del archivo 
		// donde irá $contenido cuando usemos fwrite() sobre él. 
		
		// Escribir $contenido a nuestro archivo abierto.

		if (fwrite($gestor, ob_html_compress($buf)) === FALSE) {

			$msg = "No se puede escribir en el archivo ($cachefile)";
			
			// Lanzamos una notificación al administrador del sitio web.
			notifi(mail_admin, $msg, send_error()); 
		 
			exit();
		}
		
	 fclose($gestor);
	}
	ob_end_flush();

}

function load_cache_css($archivo){
 
	$cachefile = dir_chache.md5(dominio.uri).$_GET['load'].'.'.ext_chache;

	// calculamos el tiempo del cache

	if(file_exists($cachefile)){
  
		$cachelast = filemtime($cachefile);

	} else { $cachelast = 0; }

	// Mostramos el archivo si aun no vence

	if ((time()-time_cache) < $cachelast) {
  
		readfile($cachefile);
  
		exit();
	}
 
	ob_start(); 
 
	header("Content-type: text/css");
	header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
	header('Cache-Control: public');

	foreach($archivo as $archivos){ include $archivos;	}
	
/**/

// Generamos el nuevo archivo cache

	$fp = fopen($cachefile, 'w');

	// Guardamos el contenido del buffer

	$compress=	ob_get_contents();
	
	fwrite($fp, compress_css($compress));

	fclose($fp);
 
	ob_end_flush();
	
}

function load_cache_js($archivo){
 
	$cachefile = dir_chache.md5(dominio.uri).'.js'.'.'.ext_chache;

	// calculamos el tiempo del cache

	if(file_exists($cachefile)){
  
		$cachelast = filemtime($cachefile);

	} else { $cachelast = 0; }

	// Mostramos el archivo si aun no vence

	if (time() - time_cache < $cachelast) {
  
		readfile($cachefile);
  
		exit();
		
	}
 
	ob_start(); 
 
	header("Content-type: application/x-javascript");
	header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
	header('Cache-Control: public');
	
	foreach($archivo as $archivos){ include $archivos; }
	
/**/

// Generamos el nuevo archivo cache

	$fp = fopen($cachefile, 'w');

// guardamos el contenido del buffer

	
	$compress =	ob_get_contents();
	
	fwrite($fp, compress_js($compress));

	fclose($fp);
 
	ob_end_flush();
	
}
?>