<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Incluimos los archivos de carpeta func... 
**
** NOTA: Solo se abrira aquellas funciones que empiecen con func-
*/

$func_files = glob(ROOT.'/core/func/func-*.php'); // busca todos los nombres de ruta que coincidan con la extención.

foreach($func_files as $func_file){
   
	//echo $func_file.'<br>';
	require_once($func_file);
	
}
 

?>