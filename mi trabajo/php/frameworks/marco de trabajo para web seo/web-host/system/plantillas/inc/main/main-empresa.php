<?php if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/*
** Aquí albergamos las funciones genéricas web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/ 

global $db_gest_in;
global $db_web;
global $cat_milestone;
?> 
<div role="main" class="main">

	<?php $get_img = get_img(tb_fdtitle_empresa); ?>
	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background section-footer" style="background-image: url(<?=compose_img($get_img[0]['path'],$get_img[0]['file_name'],true)?>); margin-bottom: -10px;">
		
		<div class="container">
			
			<div class="row">
				
				<div class="col-md-12">
					
					<h1><?=l('sobrenosotros',pag1,$db_web)?></h1>
					
					<ul class="breadcrumb">
						
						<li><a href="#"><?=l('menu_1_1',pag1,$db_web)?></a></li>
						
						<li class="active"><?=l('menu_1_2',pag1,$db_web)?></li>
						
					</ul>
						
				</div>
				
			</div>
			
		</div>
		
	</section>
	
	<div class="nivo-slider"> 
		
		<div class="slider-wrapper theme-default"> 
			
			<div id="nivoSlider" class="nivoSlider"> 
			
				<?php 
	          $db_gest_in->where('t_id', tb_secc_slider_2);   
						$tb_secc_slider = $db_gest_in->get('fx_tasks');   
						if($tb_secc_slider[0]['visible']=='Yes'){  
							$get_imgs = get_img(tb_secc_slider_2); 
							foreach($get_imgs as $get_img){ 
								echo '<img src="'.compose_img($get_img['path'],$get_img['original_name'],true).'" data-thumb="'.compose_img($get_img['path'],$get_img['original_name'],true).'" alt="'.$get_img['description'].'"/> '; 
								} 
							}   
				?>
					
			</div>
	
			<div id="htmlcaption" class="nivo-html-caption"></div>
	
		</div>
	
	</div>
	
	<div class="container">
		
		<div class="row">
			
			<div class="col-md-4 col-md-offset-4">
		
				<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat"> 
				
					<h2> <?=l('sobrenosotros',pag1,$db_web)?> </h2>
				
				</div>
			
			</div>
		
		</div>
				
		<div class="row">
			
			<div class="col-md-12">
				
				<p> <?=nl2br($cat_milestone[0]['description']);?> </p>
				
			</div>
		
			<hr>
			 
			<div class="row">
			
				<div class="col-md-4 col-md-offset-4">
		
					<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat"> 
				
						<h2> <?=l('nuestro_compromiso',pag1,$db_web)?> </h2>
			 
					</div>
				
				</div>
			
			</div>
			
		</div>
		
	</div>
	
	<? load_contenidorepetido('presupuesto','otras')?>
	
</div>