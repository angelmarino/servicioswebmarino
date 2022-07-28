<?php if(!defined('BASEPATH')) exit('El acceso no permitido :( ');
header("Cache-Control: must-revalidate");
header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
/*
** Aquí albergamos las funciones de optimización web.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/

function _cache_regenerate(){
	
	/* Eliminamos el contenido de la carpeta de cache */
	
	$files = glob(ROOT.'cache/*'); // get all file names

	foreach($files as $file){ // iterate files
  
		if(is_file($file))
			
			unlink($file); // delete file
	}
	
	/* Generamos otra vez el contenido nuevo de la cache */
	 	 
	$handler = curl_init('http://'.$_SERVER['HTTP_HOST'].'/inicio.html');  

	$response = curl_exec ($handler);  

	curl_close($handler);  

	echo $response; 

} 


?>