<?php  if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/*
** Aquí albergamos las funciones requeridas en inmanager. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite
**
*/

function get_img($task){
	
	global $db_gest_in;
	$db_gest_in->where('task', $task); 
	$get_img = $db_gest_in->get('fx_task_files'); 	 
	return $get_img;
}

function format_fecha($t_id){
	
	global $db_gest_in;
	 
	$db_gest_in->where('t_id', $t_id); 
	$blog_fecha = $db_gest_in->get('fx_tasks');
	
	/*  */
	list($anio, $mes, $dia) = explode("-",$blog_fecha[0]['due_date']);
	
	return array($dia,$mes,$anio);
}


/* Obtenemos la página actual de los sitio web. */
function pag_actual_espacio($pag_actual){
	
	/* Iniciamos la variables globales */
	global $db_gest_in;
	global $detect;
	global $db_web; 
	
	/* Buscamos la info a la base de datos */ 
	$espacio_task = $db_gest_in->rawQuery('SELECT * FROM fx_tasks WHERE milestone='.tb_espacios.'', array(10));
	 
	/* Contamos el contenido del array */
	$espacio_task_C = count($espacio_task);
	  
	for ($x = 0; $x <= $espacio_task_C; $x++) {
		
		if(format_uri($espacio_task[$x]['task_name'])==$pag_actual and !empty($espacio_task[$x])){
		  
			/* Sacamos el contenido y lo pasamos a una constante. */
			define('espacio_titulo', $espacio_task[$x]['task_name']);
			define('espacio_id', $espacio_task[$x]['t_id']);
			define('espacio_descri', $espacio_task[$x]['description']);
			define('espacio_cat', $espacio_task[$x]['milestone']);
			 
		}  
	}  
}
 
function servicios($tb_servicios){
	
	/* Iniciamos la variables globales */
	global $db_gest_in;
	global $detect;
	global $db_web; 
	
	/* Buscamos la info a la base de datos */  
	$db_gest_in->where('id', $tb_servicios); 
	$cat_servicio = $db_gest_in->get('fx_milestones'); 
	
	/************/
	
	$db_gest_in->where('visible', 'Yes');
	$db_gest_in->where('milestone', $cat_servicio[0]['id']); 
	$servicios_task = $db_gest_in->get('fx_tasks');
	 
	/************/
	 
	return array($cat_servicio, $servicios_task);
}
  
function get_data_cat($db_trabajos,$pag){ 
	
	global $db_gest_in; 
	 
	if($pag=='pagina'){ 
		$db_gest_in->where('project', $db_trabajos); 
		$menu_cat = $db_gest_in->get('fx_milestones'); 
		$menu_cat_C = count($menu_cat);
		for ($x = 0; $x <= $menu_cat_C; $x++) { 
	
			if(!empty($menu_cat[$x]) and format_uri($menu_cat[$x]['milestone_name'])==pag3){
		
				$titulo = $menu_cat[$x]['milestone_name'];
				$description = $menu_cat[$x]['description'];
				$id = $menu_cat[$x]['id']; 
			} 
		} 
		return array($id,$titulo,$description);
	} 
}

function select_db($select,$db_seleccionada){
	  
	global $db_gest_in; 
	
	if($select=='project'){ 
		$db_gest_in->where('project', $db_seleccionada); 
		$selecto1 = $db_gest_in->get('fx_milestones');
		return $selecto1;
	} 
	elseif($select=='t_id'){
		$db_gest_in->where('visible', 'Yes'); 
		$db_gest_in->where('t_id', $db_seleccionada); 
		$selecto2 = $db_gest_in->get('fx_tasks');  
		return $selecto2;
	} 
	elseif($select=='milestone'){ 
		$db_gest_in->where('visible', 'Yes'); 
		$db_gest_in->where('milestone', $db_seleccionada); 
		$selecto3 = $db_gest_in->get('fx_tasks');
		return $selecto3; 
	}
	elseif($select=='project_task'){
		$db_gest_in->where('visible', 'Yes'); 
		$db_gest_in->where('project', $db_seleccionada); 
		$selecto4 = $db_gest_in->get('fx_tasks');
		return $selecto4; 
	}
	elseif($select=='nombre_cat'){ 
		/* Para sacar el nombre de una categoria emplearemos una array en la busqueda. */
		$db_gest_in->where('project', $db_seleccionada[0]); 
		$db_gest_in->where('id', $db_seleccionada[1]); 
		$selecto5 = $db_gest_in->get('fx_milestones'); 
		return $selecto5;
	}
	elseif($select=='get_proyecto'){
		/* Buscamos el milestone */
		$db_gest_in->where('id', $db_seleccionada); 
		$selecto6 = $db_gest_in->get('fx_milestones'); 
		return $selecto6;
	}
}


function compose_img($img_path,$original_name,$remplazar=true){ 
	/*
	** Lanzamos la composicion de la imagen.
	** Verificamos que el archivo existe sino lanzamos un error img_notfound. 
	*/ 
	if($remplazar=true){ 
    /* Composición de imagen con remplazo en guion bajo */
		$img_out = file_exist(url_gestion.$img_path.str_replace(" ", "_", $original_name)); 
	
	} else {
		/* Composición de imagen sin remplazos. */
		$img_out = file_exist(url_gestion.$img_path.$original_name);
		 
	}
	return $img_out;
}

?>




