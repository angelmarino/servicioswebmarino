<?php 

if(!defined('BASEPATH')) exit('El acceso no permitido :( ');

header("Cache-Control: must-revalidate");

header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí iniciamos la exportación desde gestion.ingrup.es al sitio web del cliente.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/

/* 
** Recojemos la información de la base de datos externa y la pasamos 
** al hosting del cliente.
**
** Esta es una tarea cron que se activará en el sitio web según el estado de 
** la tarea que se este ejecutando dependiendo del numero de proyecto del sitio web.
**
** Lo primero a ejecutar será, la extracción de la conexión del panel de gestión remoto.
*/






?>