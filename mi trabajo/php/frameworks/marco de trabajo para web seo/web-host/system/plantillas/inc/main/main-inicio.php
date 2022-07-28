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
global $db_servicios;
global $counttrabajos;
global $detect;
?> 
<style>
	@media (min-width: 992px){ .col-md-2 { width: 19.666667%; } }
</style>
<div role="main" class="main">
  
	<div class="nivo-slider">
	
		<div class="slider-wrapper theme-default">
		 
			<div id="nivoSlider" class="nivoSlider">
			
				<?php 
				
				$db_gest_in->where('t_id', tb_secc_slider_1);  
						
				$tb_secc_slider = $db_gest_in->get('fx_tasks');  
						
				if($tb_secc_slider[0]['visible']=='Yes'){ 
						
					$get_imgs = get_img(tb_secc_slider_1);
							
					foreach($get_imgs as $get_img) {
									
						echo '<img src="'.compose_img($get_img['path'],$get_img['original_name'],true).'" data-thumb="'.compose_img($get_img['path'],$get_img['original_name'],true).'" alt="'.$get_img['description'].'"  /> '; 
							
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
			
					<h2 style="margin-top: 20px;"><?=l('que_hacemos',pag1,$db_web)?></h2>
		
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
	  
		?>
	<br><br>
	<div class="container">
	
		<div class="row">
			
		<?php 
		
		$tb_secc_inicio = array(tb_secc_inicio_1, tb_secc_inicio_2, tb_secc_inicio_3);
		 
		foreach ($tb_secc_inicio as $tb_seccion_inicio){
			
			$db_gest_in->where('t_id', $tb_seccion_inicio);
		
			$view_seccion_inicio = $db_gest_in->get('fx_tasks'); 
			
			if($view_seccion_inicio[0]['visible']=='Yes'){
				
				$get_img = get_img($view_seccion_inicio[0]['t_id']);
			?> 
		<div class="col-md-4">
 
			<span class="thumb-info thumb-info-hide-wrapper-bg seccion_inicio_1">
				
				<span class="thumb-info-wrapper">
					
					<img src="<?=compose_img($get_img[0]['path'],$get_img[0]['original_name'],true)?>" class="img-responsive" alt="<?=$get_img[0]['title']?>" title="<?=$get_img[0]['description']?>">
					  
				</span>
				
				<span class="thumb-info-caption seccion_inicio_cont">
					
					<span class="thumb-info-caption-text">
						
						<h5><?=$view_seccion_inicio[0]['task_name']?></h5>
					
						<?=$view_seccion_inicio[0]['description']?>
						
					</span>
					
				</span>
				
			</span>

		</div> 
			
		<?php } } ?>
		
		</div>

	</div>
	<?php 
	
	
	load_contenidorepetido('presupuesto');
	
	/* Trabajos realizados */ 
	
	if($detect->isMobile()){ 
	
		load_contenidorepetido('trabajos','simple'); 
															
	} else { 
	
		load_contenidorepetido('trabajos','avanzado');
		
	} 
	
	/* Fin de trabajos realiozados */ ?>
	 
	<section class="section proveedores page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background section-footer">
	
		<div class="container">
	
			<div class="row">
		
				<div class="col-md-12">

					<div class="row">
			
						<div class="col-md-4 col-md-offset-4">
				
							<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
					
								<h2><?=l('proveedores',pag1,$db_web)?></h2>
					
							</div>
							
						</div>
						
					</div>

					<div class="content-grid mt-lg mb-lg">
						
						<div class="row content-grid-row">
							
							<?php
							
							$get_img = get_img(tb_proveedores);
						   //count($get_img)
								for($i = 0; $i < count($get_img); ++$i) {
    					
							?>
							<div class="content-grid-item col-md-2 col-xs-6 center">
								
								<img class="img-responsive" src="<?=compose_img($get_img[$i]['path'],$get_img[$i]['file_name'],true)?>" alt="<?=$get_img['description']?>" title="<?=$get_img['title']?>">
								
							</div> 
							
							<?php } ?>
							
						</div>
							 
					</div>
					
				</div>
		
			</div>

		</div>
	
	</section>

	<section class="section page-header page-header-more-padding page-header-no-title-border page-header-custom-background section-footer" style="background:#333333; margin-bottom: 0px;">
				
		<div class="container">
					
			<div class="row">
						
				<div class="counters counters-text-light">
							
					<div class="col-md-7 col-sm-6 col-md-offset-1">
							<h3 style="font-weight: 700;
    font-size: 50px;
    text-transform: none;
    margin-bottom: 0px;
    color: #fff;
    line-height: 50px;"> 
										<?=l('lideres pladur',pag1,$db_web);?> 
									</h3>
							<div class="row">
							
								<div class="col-md-5">
					
								
									
								</div>
						
						</div>
						
						<div class="row">
						
							<div class="col-md-3">
				
								<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat"> <h2></h2> </div>
						
							</div>
						
						</div>
					
					</div>
							 
					<div class="col-md-3 col-sm-6 col-md-offset-1">
								
						<div class="counter center" style="float: left;">
							
							<i class="icon-ingrup" style="font-size: 6em;">&#xe800;</i>
							
							<strong data-to="<?=($counttrabajos*$counttrabajos)?>" style="font-size: 2em;">0</strong>
								
							<label><?=l('trabajos_realizados',pag1,$db_web)?></label>
								
						</div>
						
					</div>
					
				</div>
					
			</div>
			
		</div>
		
	</section>
	
	<?php load_contenidorepetido('otras'); ?>
</div>