<?php if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/*
** Aquí albergamos las funciones genéricas web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/ 

global $db_gest_in; 
global $db_servicios;
global $db_web;

foreach($db_servicios[1] as $dbservicio) {

	$dbserviciosnombre = explode('|',$dbservicio['task_name']);
	  
	if(format_uri($dbserviciosnombre[0])==pag3){
		
		$servicios_explo = explode('|',$dbservicio['task_name']);
		$icono_servicio = $servicios_explo[1];
		$nombre_servicio = $servicios_explo[0];
		
		$servicios_desc = explode('|',$dbservicio['description']);
		$servicio_des_l = $servicios_desc[1];
		$servicio_des_c = $servicios_desc[0];
		
	} 
}
 
?>  
<div role="main" class="main">

	<?php $get_img = get_img(tb_fdtitle_empresa);?>
	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="background-image: url(<?=compose_img($get_img[0]['path'],$get_img[0]['file_name'],true)?>);">
				
		<div class="container">
				
			<div class="row">
					
				<div class="col-md-12">
					
					<h1><?=$nombre_servicio?></h1>
						
					<ul class="breadcrumb">
						
						<li><a href="#"><?=l('menu_1_1',pag1,$db_web)?></a></li>
							
						<li class="active"><?=l('menu_1_4',pag1,$db_web)?></li>
						
					</ul>
						
				</div>
				
			</div>
			
		</div>
		
	</section>
	  
	<div class="container">
		 
		<div class="row"> 
			
			<div class="col-md-3 servicio">
				
				<i class="iconos">&#xe<?=$icono_servicio;?>;</i>
				<p>
					<b><?=$nombre_servicio;?></b>
					<br>
					<?=$servicio_des_c;?>
				</p>
				
			</div>
			
			<div class="col-md-5">
				
				<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
		
					<h2><?=l('detalleservicio',pag1,$db_web)?></h2>
	
				</div> 
				
				<p> <?=$servicio_des_l?> 	</p>
				
			</div>
			
			<div class="col-md-4">
				
				<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
		
					<h2><?=l('trabajos_realizados',pag1,$db_web)?></h2>
	
				</div>
		
				<?php /**/ load_contenidorepetido('trabajos','basic'); ?>
				
			</div>
		
		</div>
	
	</div>
	 
	<?php load_contenidorepetido('presupuesto','otras'); ?>

</div>