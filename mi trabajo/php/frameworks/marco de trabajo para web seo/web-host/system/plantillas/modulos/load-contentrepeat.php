<?php if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/*
** Aquí albergamos las funciones genéricas web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/ 



function load_contenidorepetido($pag,$pag1){
	
	global $db_gest_in;
	global $trabajos_listado;
	global $trabajos_lists;
	global $db_servicios;
	global $counttrabajos;
	global $db_web;

	if($pag=='presupuesto'){ ?>

	<?php $solpresupuesto = sol_presupuesto(tb_solpresupuesto); ?>
	
	<div class="container-fluid">
	
		<div class="row">
		
			<div class="col-md-6 p-none">
		
				<section class="section section-primary pl-lg pr-lg match-height section-footer" style="border-top: 0px">
				
					<div class="row">
						
						<div class="col-md-12"> 
										
							<h2 class="seccion_presupuesto"><?=$solpresupuesto[0]['description'];?></h2>
								
							<br>
						
							<a data-toggle="modal" data-target="#formModal" href="#formModal" class="btn btn-quaternary btn-lg"><?=l('solicita presupuesto ya',pag1,$db_web)?></a>
						
							<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true"><?php load_presupuesto_modal(); ?></div>
						<br>
					
						<br>
					
						</div>
					
					</div>
					
				</section>
				
			</div>
				
			<div class="col-md-6 p-none hidden-xs">
					
				<?php $get_imgs = get_img(tb_solpresupuesto);?>
					
				<section class="section section-primary section-text-light section-background section-center match-height section-footer" style="background-image: url(<?=compose_img($get_imgs[0]['path'],$get_imgs[0]['original_name'],true)?>); background-repeat: no-repeat;">
							
					<div class="container">
						
						<div class="row">
									
							<div class="col-md-12"></div>
								
						</div>
						
					</div>
					
				</section>
				
			</div>
		
		</div>
		
	</div>

 <?php }  
	
	if($pag=='otras' or $pag1=='otras') { ?> 

	<section class="section page-header-more-padding newsletterseccion page-header-no-title-border page-header-custom-background section-footer">
	
		<div class="container">
	
			<div class="row">
		
				<div class="col-md-5 col-md-offset-1">
					
					<h2 class="newsletter-title"><?=l('info_novedades',pag1,$db_web)?></h2>
					
					<span class="newsletter"><?=l('suscribete',pag1,$db_web)?></span>
					
					<form class="form-inline">
 
						<div class="input-group">
							
							<span class="input-group-btn"> 
								<button type="submit" class="btn btn-default"><?=l('suscribete_btn',pag1,$db_web)?></button> 
							</span>
    
							<input type="email" class="form-control" id="exampleInputEmail3" placeholder="E-mail*">
  
						</div> 
    
					</form>
			
				</div>
				
				<div class="col-md-3 col-md-offset-3 newsletter-bg hidden-xs"></div>
				
			</div> 
			
		</div>
		
	</section>
	
	<section class="section socialmedia page-header-center page-header-more-padding page-header-no-title-border section-footer" style="background: #fff;">
	
		<div class="container">
	
			<div class="row">
		
				<div class="col-md-12">

					<div class="content-grid mt-lg mb-lg">
						
						<div class="row content-grid-row">
							 
							<div class="content-grid-item col-md-3 col-xs-6 center redesociales">
								
								<a href=""><i class="icon-ingrup">&#xe801;</i></a>
								
							</div>  
							
							<div class="content-grid-item col-md-3 col-xs-6 center redesociales">
								
								<a href=""><i class="icon-ingrup redesociales">&#xe802;</i></a>
								
							</div>  
							
							<div class="content-grid-item col-md-3 col-xs-6 center redesociales">
								
								<a href=""><i class="icon-ingrup redesociales">&#xe803;</i></a>
								
							</div>  
							
							<div class="content-grid-item col-md-3 col-xs-6 center redesociales">
								
								<a href=""><i class="icon-ingrup redesociales">&#xe804;</i></a>
								
							</div>  
							
						</div>
							 
					</div>
					
				</div>
		
			</div>

		</div>
	
	</section>

<?php } 
	
	if($pag=='trabajos' and $pag1=='basic'){
	
?> 
	
<div class="owl-carousel owl-theme full-width" data-plugin-options='{"responsive": {"0": {"items": 1}, "479": {"items": 1}, "768": {"items": 1}, "979": {"items": 1}, "1199": {"items": 1}}, "loop": false, "nav": true, "dots": false, "autoHeight": true, "margin": 10,"autoplay": true, "autoplayTimeout": 3000}'>
		
		<?php 
		
		foreach($trabajos_lists as $trabajos){ 
			
			$trabajo_cate = select_db('nombre_cat', array(db_trabajos, $trabajos['milestone']));
			
			$get_img = get_img($trabajos['t_id']);
		
		?>
		
		<div>
			
			<a href="/<?=pag1?>/proyecto/<?=format_uri($trabajos['task_name'])?>.html">
						
				<span class="thumb-info thumb-info-centered-info thumb-info-hide-info-hover">
						
					<span class="thumb-info-wrapper">
								
						<img src="<?=compose_img($get_img[0]['path'],$get_img[0]['original_name'],true)?>" class="img-responsive" alt="<?=$get_img[0]['description']?>" title="<?=$get_img[0]['title']?>">
								
						<span class="thumb-info-title">
							
							<span class="thumb-info-inner"><?=$trabajos['task_name']?></span>
								
							<span class="thumb-info-type"><?=$trabajo_cate[0]['milestone_name']?></span>
							
						</span> 
								
					</span>
							
				</span>
					
			</a>
					
		</div>
		
		<?php }  ?>

	</div>

<?php
	
	}
	
	if($pag=='trabajos' and $pag1=='simple'){
		?>
<section class="page-header page-header-center trabajos-simple page-header-more-padding page-header-no-title-border page-header-custom-background">
	
		<div class="container">
	
			<div class="row">
			
				<div class="col-md-4 col-md-offset-4">
				
					<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
		
						<h2 style="color: #fff;"><?=l('ultimostrabajos',pag1,$db_web)?></h2>
	
					</div>
		
				</div>
		
			</div>
	
		</div>  
	
	</section>
	
<div class="owl-carousel owl-theme full-width" data-plugin-options='{"responsive": {"0": {"items": 1}, "479": {"items": 1}, "768": {"items": 2}, "979": {"items": 3}, "1199": {"items": 3}}, "loop": false, "nav": true, "dots": false, "autoHeight": true, "margin": 10,"autoplay": true, "autoplayTimeout": 3000}'>
		
		<?php 
		
		foreach($trabajos_lists as $trabajos){ 
			
			$trabajo_cate = select_db('nombre_cat', array(db_trabajos, $trabajos['milestone']));
			
			$get_img = get_img($trabajos['t_id']);
		
		?>
		
		<div>
			
			<a href="/<?=pag1?>/proyecto/<?=format_uri($trabajos['task_name'])?>.html">
						
				<span class="thumb-info thumb-info-centered-info thumb-info-hide-info-hover">
						
					<span class="thumb-info-wrapper">
								
						<img src="<?=compose_img($get_img[0]['path'],$get_img[0]['original_name'],true)?>" class="img-responsive" alt="<?=$get_img[0]['description']?>" title="<?=$get_img[0]['title']?>">
								
						<span class="thumb-info-title">
							
							<span class="thumb-info-inner"><?=$trabajos['task_name']?></span>
								
							<span class="thumb-info-type"><?=$trabajo_cate[0]['milestone_name']?></span>
							
						</span> 
								
					</span>
							
				</span>
					
			</a>
					
		</div>
		
		<?php }  ?>

	</div>

<?php
	
	}
		
	if($pag=='trabajos' and $pag1=='avanzado'){?>


	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="margin-bottom: 0px;">
	
		<div class="container">
	
			<div class="row">
			
				<div class="col-md-4 col-md-offset-4">
				
					<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
		
						<h2 style="color: #fff;"><?=l('ultimostrabajos',pag1,$db_web)?></h2>
	
					</div>
		
				</div>
		
			</div>
	
		</div> 
	
		<div class="container">
	
			<div class="row">
			
				<div class="col-md-6 col-md-offset-4">
	
					<ul class="nav nav-pills sort-source center" data-sort-id="portfolio" data-option-key="filter">
		
						<li data-option-value="*" class="active"><a href="#"><?=l('mostrar todos',pag1,$db_web)?></a></li>
	
						<?php foreach($trabajos_listado as $trabajocat){ ?>
		
						<li data-option-value=".<?=format_uri($trabajocat['milestone_name'])?>"><a href="#"><?=$trabajocat['milestone_name']?></a></li>
		
						<?php } ?> 
	
					</ul>

				</div>
		
			</div>
	
		</div>
	
	</section>

<ul class="portfolio-list sort-destination full-width" data-sort-id="portfolio">
		
		<?php 
		
		foreach($trabajos_lists as $trabajos){ 
			
			$trabajo_cate = select_db('nombre_cat', array(db_trabajos, $trabajos['milestone']));
			
			$get_img = get_img($trabajos['t_id']);
		
		?>
		
		<li class="isotope-item <?=format_uri($trabajo_cate[0]['milestone_name'])?>">
					
			<div class="portfolio-item m-none">
							
				<a href="/<?=pag1?>/proyecto/<?=format_uri($trabajos['task_name'])?>.html">
								
					<span class="thumb-info thumb-info-centered-info thumb-info-no-borders m-none">
							
						<span class="thumb-info-wrapper">
								
							<img src="<?=compose_img($get_img[0]['path'],$get_img[0]['original_name'],true)?>" class="img-responsive" alt="<?=$get_img[0]['description']?>" title="<?=$get_img[0]['title']?>">
								
							<span class="thumb-info-title">
								
								<span class="thumb-info-inner"><?=$trabajos['task_name']?></span>
								
								<span class="thumb-info-type"><?=$trabajo_cate[0]['milestone_name']?></span>
								
							</span> 
							
						</span>
							
					</span>
					
				</a>
				
			</div>
			
		</li> 
			
		<?php } ?>
	
	</ul> 
	<hr>  

<?php }

	if($pag=='servicios' and $pag1=='movil'){ ?>

<div class="owl-carousel owl-theme full-width" data-plugin-options='{"responsive": {"0": {"items": 1}, "479": {"items": 1}, "768": {"items": 2}, "979": {"items": 3}, "1199": {"items": 3}}, "loop": true, "nav": true, "dots": false, "autoHeight": true, "margin": 10,"autoplay": true, "autoplayTimeout": 3000}'>

	<?php
					
	foreach($db_servicios[1] as $dbservicios){
			
				/* Eliminamos el nombre */ 
				$dbservicios_nombre = explode('|',$dbservicios['task_name']);
				$dbservicios_description = explode('|',$dbservicios['description']);
	  
	?>
	
<div>
			<a href="/<?=pag1?>/proyecto/<?=format_uri($trabajos['task_name'])?>.html">
						
				<span class="thumb-info thumb-info-centered-info thumb-info-no-borders m-none">
						
					<span class="col-md-3 col-sm-6 col-xs-12 servicios">
								
						<i class="iconos">&#xe<?=$dbservicios_nombre[1];?>;</i> 
								
							<div class="servicios_title">
						<h3><?=$dbservicios_nombre[0];?></h3>
					</div>
				
					<p> <?=$dbservicios_description[0]?> </p>
				
					<a href="/<?=pag1?>/servicio/<?=format_uri($dbservicios_nombre[0])?>.html" title="<?=$dbservicios_nombre[0]?>" class="btn btn-borders btn-primary btn-sm">Ver <?=$dbservicios_nombre[0];?></a>
								
					</span>
							
				</span>
					
			</a>
					
		</div>

	<?php  } ?>

</div>

<?php } 
	
	if($pag=='servicios' and $pag1=='escritorio'){?>

<div class="container">
 
	<div class="row">
		 
				<?php 
			
	foreach($db_servicios[1] as $dbservicios){
			
				/* Eliminamos el nombre */ 
				$dbservicios_nombre = explode('|',$dbservicios['task_name']);
				$dbservicios_description = explode('|',$dbservicios['description']);
	  
			?> 
		
				<div class="col-md-3 col-sm-6 col-xs-12 servicios">
	 
					<i class="iconos">&#xe<?=$dbservicios_nombre[1];?>;</i> 
				
					<div class="servicios_title">
						<h3><?=$dbservicios_nombre[0];?></h3>
					</div>
				
					<p> <?=$dbservicios_description[0]?> </p>
				
					<a href="/<?=pag1?>/servicio/<?=format_uri($dbservicios_nombre[0])?>.html" title="<?=$dbservicios_nombre[0]?>" class="btn btn-borders btn-primary btn-sm">Ver <?=$dbservicios_nombre[0];?></a>
			
				</div> 
		
				<?php }  ?>
				 
		
		</div> 
	
</div>

<?php }
} ?> 