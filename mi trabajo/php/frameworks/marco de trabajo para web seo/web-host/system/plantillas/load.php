<?php  if (!defined('BASEPATH')) exit('Acceso no permitido.');
# Iniciamos la configuración del sitio web.
  
global $db_web; 
global $db_gest_in;
global $db_servicios;

 
function load_header($tipo){
	
	global $db_gest_in;
	global $db_web;
	global $detect;
	
	$dir_header = '/plantillas/inc/header/';
	
	if($tipo=='default') {
		/* */
		require_once ROOT.$dir_header.'header-default.php'; 
	} else {
		/* */
		require_once ROOT.$dir_header.'header-'.$tipo.'.php'; 
	}
	
}

/*
**
*/

function load_main($tipo){

	global $db_gest_in;
	global $db_web;
	global $detect;
	
	$dir_main = '/plantillas/inc/main/';

	/*
	** Buscamos los main que estén en la página web.
	** Verificar el archivo config-web.php
	*/
 
	if($tipo=='inicio'){
		/* Cargamos la página principal del sitio web. */
		require_once ROOT.$dir_main.'main-inicio.php'; 
	}    
	elseif($tipo=='contacto'){
		/* INiciamos la pagina de contacto */
		require_once ROOT.$dir_main.'main-contacto.php'; 
	}   
	elseif($tipo=='empresa'){
		/*  */ 
		require_once ROOT.$dir_main.'main-empresa.php'; 
	} 
	elseif($tipo=='servicios' or $tipo=='servicio'){
		/**/ 
		if($tipo=='servicios' and !empty(pag3)){
			
			require_once ROOT.$dir_main.'main-servicios.php'; 
		
		} else {
		
			require_once ROOT.$dir_main.'main-servicio.php';
			
		}
	}  
	elseif($tipo=='proyectos' or $tipo=='proyecto'){
		/**/
		if($tipo=='proyectos' and !empty(pag3)){
			
			require_once ROOT.$dir_main.'main-proyectos.php'; 
		
		} else  {
		
			require_once ROOT.$dir_main.'main-proyecto.php';
			
		}
	}  
	elseif($tipo=='mantenimiento'){ 
		/* Iniciamos la página de mantenimiento o construcción  */ 
		require_once ROOT.$dir_main.'main-mantenimiento.php';
	} 

}

/* 
**
*/

function load_footer($tipo){
	
	global $db_gest_in;
	global $db_web;
	global $detect;
	
	$dir_footer = '/plantillas/inc/footer/';
	
	if($tipo=='default'){
		
		require_once ROOT.$dir_footer.'footer-default.php';
	
	} else {
		
		require_once ROOT.$dir_footer.'footer-'.$tipo.'.php'; 
	} 
}
 
/*
** Busca todos los nombres de ruta que coincidan con la extención.
*/
$load_modulos = glob(ROOT.'/plantillas/modulos/load-*.php'); 

foreach($load_modulos as $load_modulo){
    
	require_once($load_modulo);
	
}

function data_plugin_option($detect){
	
	global $detect;
	
	if($detect->isMobile()){
		
		$data_plugin = '{"stickyEnabled": false, "stickyEnableOnBoxed": false, "stickyEnableOnMobile": false, "stickyStartAt": 57, "stickySetTop": "0px", "stickyChangeLogo": false}';
		
	}   else {
		
		$data_plugin = '{"stickyEnabled": false, "stickyEnableOnBoxed": false, "stickyEnableOnMobile": false, "stickyStartAt": 1, "stickySetTop": "1"}';
	}
	
	return $data_plugin;
}


// Cargamos la página de mantenimiento.
if(mantenimiento=='1'){ 
	
	// Cargamos la página de mantenimiento.
	$protector = new maxProtector(); 
	$protector->login(); 
 
}  

function sol_presupuesto($tb_solpresupuesto){
	
	global $db_gest_in;
	
	$db_gest_in->where('visible', 'Yes');
	$db_gest_in->where('t_id', $tb_solpresupuesto); 
	$sol_presupuesto_task = $db_gest_in->get('fx_tasks');
	
	return $sol_presupuesto_task;
}

//

$db_servicios     = servicios(tb_servicios); 
$trabajos_listado = select_db('project',db_trabajos);
$trabajos_lists   = select_db('project_task',db_trabajos);
$cat_milestone    = select_db('get_proyecto',tb_empresa); 
$counttrabajos    = count($trabajos_lists); 

    if(pag2=='servicio'){
	foreach($db_servicios[1] as $dbservicio) {

		$dbserviciosnombre = explode('|',$dbservicio['task_name']);
	 
		if(format_uri($dbserviciosnombre[0])==pag3){
		
			$servicios_explo = explode('|',$dbservicio['task_name']); 
			$servicios_desc = explode('|',$dbservicio['description']);  
			
			$titulo_pagina = $servicios_explo[0].' - '.nombre_empresa; 
			$description_pagina = $servicios_explo[0];
			$img_pagina = host_img.logotipo_header;
		
		}
	} 
}

elseif(pag2=='proyecto'){
	
	foreach ($trabajos_lists as $trabajo){
		
		if(format_uri($trabajo['task_name'])==pag3){
			
			/* Sacamos los datos del trabajo */ 
			$titulo_pagina = $trabajo['task_name'];
			$description_pagina = $trabajo['description']; 
		
			$trabajo_img = get_img($trabajo['t_id']); 
			$img_pagina = compose_img($trabajo_img[0]['path'],$trabajo_img[0]['file_name'],true); 
			break;
		}
	}
}

elseif(pag2=='contacto'){
	 
	$titulo_pagina = l('contactaconnosotros',pag1,$db_web).' - '.nombre_empresa;
	$description_pagina = l('text_footer',pag1,$db_web); 
	$img_pagina = host_img.logotipo_header; 

}

elseif(pag2=='inicio'){
	$titulo_pagina = l('menu_1_1',pag1,$db_web).' - '.nombre_empresa;
	$description_pagina = l('text_footer',pag1,$db_web);
	$img_pagina = host_img.logotipo_header;
}

elseif(pag2=='servicios'){
	
	$titulo_pagina = l('menu_1_4',pag1,$db_web).' - '.nombre_empresa;
	$description_pagina = l('text_footer',pag1,$db_web);
	$img_pagina = host_img.logotipo_header;

}

elseif(pag2=='proyectos'){
	 
	$titulo_pagina = l('menu_1_3',pag1,$db_web).' - '.nombre_empresa;
	$description_pagina = l('text_footer',pag1,$db_web);
	$img_pagina = host_img.logotipo_header;

}
elseif(pag2=='empresa'){
	 
	$titulo_pagina = l('menu_1_2',pag1,$db_web).' - '.nombre_empresa;
	$description_pagina = l('text_footer',pag1,$db_web);
	$img_pagina = host_img.logotipo_header;

}

/* Iniciamos proceso de optimización del sitio web. */
if(load_chache==true){
	// Establecemos en la configuracion que se carge la cache del sitio.
	load_cache_html('inc/html.php', $detect,$db_web);
}
 
?> 