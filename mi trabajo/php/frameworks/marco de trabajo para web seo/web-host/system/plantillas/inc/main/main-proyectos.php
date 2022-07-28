<?php if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/*
** Aquí albergamos las funciones genéricas web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/ 
global $db_gest_in;
global $trabajos_listado;
global $trabajos_lists;
global $db_web;
?> 
<div role="main" class="main">

	<?php $get_img = get_img(tb_fdtitle_trabajos);?>
	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="background-image: url(<?=compose_img($get_img[0]['path'],$get_img[0]['file_name'],true)?>); margin-bottom: 0px;">
				
		<div class="container">
				
			<div class="row">
					
				<div class="col-md-12">
					
					<h1><?=l('trabajos_realizados',pag1,$db_web)?></h1>
						
					<ul class="breadcrumb">
						
						<li><a href="#"><?=l('menu_1_1',pag1,$db_web)?></a></li>
							
						<li class="active"><?=l('menu_1_3',pag1,$db_web)?></li>
						
					</ul>
						
				</div>
				
			</div>
			
		</div>
		
	</section>
 
	<?php	
	
	if($detect->isMobile()){ 
		
		load_contenidorepetido('trabajos','simple'); 
		
	} else { 
		
		load_contenidorepetido('trabajos','avanzado');
	} 
					 
	 load_contenidorepetido('presupuesto','otras');
					 
	?>
</div>