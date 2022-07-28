<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

if(!empty($_POST) or !empty($_GET)){ require_once ROOT.'core/seguridad/core-seguridad.php'; }
   

/*
** Aquí llamamos a la funcion limpiarCadena que se encarga de limpiar la cadena de la url. contra aataques de sql inyections
**
*/
array_walk($_POST, 'limpiarCadena');

array_walk($_GET, 'limpiarCadena');
 
?> 