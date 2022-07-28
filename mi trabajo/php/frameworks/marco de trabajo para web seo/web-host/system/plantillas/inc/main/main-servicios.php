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
?>  
<div role="main" class="main">

	<?php $get_img = get_img(tb_fdtitle_empresa);?>
	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="background-image: url(<?=compose_img($get_img[0]['path'],$get_img[0]['file_name'],true)?>);">
				
		<div class="container">
				
			<div class="row">
					
				<div class="col-md-12">
					
					<h1><?=l('menu_1_4',pag1,$db_web)?></h1>
						
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
			
			<div class="col-md-3 col-md-offset-5">
		
				<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat"> 
			
					<h2><?=l('que_hacemos',pag1,$db_web)?></h2>
			
				</div>
				
			</div>
		
		</div>
		
	</div>
	
			
	<?php 
	
	if($detect->isMobile()){ 
	
		load_contenidorepetido('servicios','movil'); 
	
	} else { 
	
		load_contenidorepetido('servicios','escritorio');
	
	} 
					 load_contenidorepetido('presupuesto','otras')?>

</div>