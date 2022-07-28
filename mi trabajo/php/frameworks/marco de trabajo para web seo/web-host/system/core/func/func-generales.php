<?php  
if(!defined('BASEPATH')) exit('El acceso no permitido :( '); 
header("Cache-Control: must-revalidate"); 
header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí albergamos las funciones genéricas web.
** Reglas: Toda nueva inserción de codigo ha de realizarse en la zona inferior. he indicar la fecha.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/

# Lista de funciones genéricas de carga de la aplicacion
  


/* 
** Fecha de modificación: 8-12-2015
** Con esta funcion hacemos que ciertos textos esten ocultos para los robots 
*/
function obfuscate($text){ 
	
	$length = strlen($text); 
	
	$scrambled = '';

	for ($i = 0; $i < $length; ++$i) { $scrambled .= '&#' . ord(substr($text, $i, 1)) . ';';}
		
	return $scrambled; 
} 
 
/* 
** Fecha de modificación: 8-12-2015 
** Obtenemos la direccion ip real del usuario 
*/
function get_real_ip(){
	
	if(isset($_SERVER["HTTP_CLIENT_IP"]))
	{
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
	{
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(isset($_SERVER["HTTP_X_FORWARDED"]))
	{
		return $_SERVER["HTTP_X_FORWARDED"];
	}
	elseif(isset($_SERVER["HTTP_FORWARDED_FOR"]))
	{
		return $_SERVER["HTTP_FORWARDED_FOR"];
	}
	elseif(isset($_SERVER["HTTP_FORWARDED"]))
	{
		return $_SERVER["HTTP_FORWARDED"];
	}
	else
	{
		return $_SERVER["REMOTE_ADDR"];
	}
	
}
  
/*
** Fecha de modificación: 8-12-2015 
** Mostramos la fecha y hora en formato completo -> 14-10-2015 12:26:32 DIA / MES / AÑO - HORA ACTUAL
*/
function fecha_hora(){
	
	$time = time();
	
	$fecha_hora = date("d-m-Y H:i:s", $time);
	
	return $fecha_hora;
	
}  
 
/*
** Fecha de modificación: 8-12-2015 
** Aqui de sacamos un array array(3) { [0]=> string(2) "14" [1]=> string(2) "10" [2]=> string(4) "2015" }
*/
function datetime_decode($datetime){
	
	$datetime = date_create($datetime); 
		 
	$datetime = date_format($datetime, 'd-m-Y'); 
	
	$datetime=explode('-',$datetime);
	
	return $datetime;
}
  
/*
** Fecha de modificación: 8-12-2015 
** Funcion de idioma.
*/
function l($t,$i="es",$db_web)
{ 
	$load_idioma = $db_web->rawQuery('SELECT * from '.db_idioma.' where idioma="'.$i.'"', array(10));

	$l = array();
	
	foreach ($load_idioma as $load_idiomas){
 
		$l[$load_idiomas['asociado']] = array($i=>$load_idiomas['contenido']);

	}
	
	return $l[$t][$i];
}

/*
** Fecha de modificación: 8-12-2015 
** Funcion de estilos.
** Inicializamos la carga de los estilos del sitio web de el panel administrativo. 
*/
function init_css(){
	/* 
	** admin_extencion: Es una constante que indica a la condicion si esta habilitada la carga de otros estilos extras.
	** esta esta definida en config-web.php
	*/
	 
	if(admin_extencion==true or $_GET['view']=='admin'){ 
 
		for($x = count_css_1+1; $x <= count_css_2+count_css_1; $x++)
		{ 
			echo '<link rel="stylesheet" type="text/css" href="/?'; 
			
			if((count_css_1+1)<=$x){
				
				echo 'view=admin&';
			
			} 
			
			echo'load=grupo_css_'.$x.'.css">';  
		} 
	
	}
	
	for($x = 1; $x <= count_css_1; $x++){ 
		
		echo '<link rel="stylesheet" type="text/css" href="/?load=grupo_css_'.$x.'.css">';

	} 
	
}

function init_js(){
	/* 
	** admin_extencion: Es una constante que indica a la condicion si esta habilitada la carga de otros estilos extras.
	** esta esta definida en config-web.php
	*/
	 
	for($x = 1; $x <= count_js_1; $x++){ 
		
		echo '<script src="/?';
		/*añadimos condiciones de muestra de script segun la página */
		if(js_custom==$x and pag2=='menus'){ echo 'view=menus&';} 
		
		echo 'load=grupo_js_'.$x.'.js"></script>';

	}
	
	if(admin_extencion==true or $_GET['view']=='admin'){ 
 
		for($x = count_js_1+1; $x <= count_js_2+count_js_1; $x++)
		{ 
			echo '<script src="/?'; if((count_js_1+1)<=$x){ echo 'view=admin&';} echo '&load=grupo_js_'.$x.'.js"></script>';  
		} 
	
	}
	
}

function form_compos($id,$action,$method,$class){
	
	echo '<form id="'.$id.'" action="'.$action.'" method="'.$method.'" class="'.$class.'">';
 
}

function _progress_project(){
	
	global $db_web;
	
	$db_web->where('id', '1'); 
	$db_config = $db_web->get(db_config);  
	$_config_db = json_decode($db_config['0']['dat_config']);
	
	if(progress_project=='100' and status_project=='Done' and $_config_db->{'mantenimiento'}=='1'){
			  
		# {"display_error":"0","ssl":"0","zip":"0","mantenimiento":"0","mantenimiento_pass":"0"}
		$compose_json = '{"display_error":"'.$_config_db->{'display_error'}.'","ssl":"'.$_config_db->{'ssl'}.'","zip":"'.$_config_db->{'zip'}.'","mantenimiento":"0","mantenimiento_pass":"'.$_config_db->{'mantenimiento_pass'}.'"}';
		   
		$data = array('dat_config' => $compose_json); 
		$db_web->where('id', 1); 
		
			if($db_web->update(db_config, $data)){ mail_alert('El sitio web de '.nombre_empresa.' ha sido publicado.'); }
     
			else { mail_alert('El sitio web de '.nombre_empresa.' ha fallado en la publicación. '.$db_web->getLastError()); } 
		 
	} elseif(status_project=='On Hold' or status_project=='Active'){
			  
		if($_config_db->{'mantenimiento'}=='0'){
		$compose_json = '{"display_error":"'.$_config_db->{'display_error'}.'","ssl":"'.$_config_db->{'ssl'}.'","zip":"'.$_config_db->{'zip'}.'","mantenimiento":"1","mantenimiento_pass":"'.$_config_db->{'mantenimiento_pass'}.'"}';
		
			$data = array('dat_config' => $compose_json); 
			$db_web->where('id', 1); 
		
			if($db_web->update(db_config, $data)) { mail_alert('El sitio web de '.nombre_empresa.' ha sido despublicado.'); }
     
			else { mail_alert('El sitio web de '.nombre_empresa.' ha fallado en la despublicación. '.$db_web->getLastError()); } 
		
		}
		
	} else {
		
		//mail_alert('El estado del sitio web no ha sido cambiado <b>Estado</b>: '.status_project.' Progreso: '.progress_project);
	
	}
		
	
}

?>