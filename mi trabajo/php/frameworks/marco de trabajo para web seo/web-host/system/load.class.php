<?php if (!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Incluimos los archivos de carpeta func... 
**
** NOTA: Solo se abrira aquellas clases que empiecen con class-
*/ 


/*
** Busca todos los nombres de ruta que coincidan con la extención.
*/
$class_files = glob(ROOT.'/core/class/class-*.php'); 

foreach($class_files as $class_file){
  
	require_once($class_file);
	
}

/* Añadimos la nueva integración de phpmailer */

//require_once(ROOT.'core/class/');

?>