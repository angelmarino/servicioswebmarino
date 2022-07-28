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


foreach ($trabajos_lists as $trabajo){
	if(format_uri($trabajo['task_name'])==pag3){
		
		/* Sacamos los datos del trabajo */
		$trabajo_titulo = $trabajo['task_name'];
		$trabajo_description = $trabajo['description']; 
		$trabajo_img = get_img($trabajo['t_id']);
		break;
	}
}
?> 
<div role="main" class="main">

	<?php $get_img = get_img(tb_fdtitle_trabajos);?>
	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="background-image: url(<?=compose_img($get_img[0]['path'],$get_img[0]['file_name'],true)?>); margin-bottom: 0px;">
				
		<div class="container">
				
			<div class="row">
					
				<div class="col-md-12">
					
					<h1><?=$trabajo_titulo?></h1>
						
					<ul class="breadcrumb">
						
						<li><a href="#"><?=l('menu_1_1',pag1,$db_web)?></a></li>
							
						<li class="active"><?=l('menu_1_3',pag1,$db_web)?></li>
						
					</ul>
						
				</div>
				
			</div>
			
		</div>
		
	</section>

	<div class="container">

		<div class="row">
			
			<div class="col-md-7">

				<div class="row">

					<div class="lightbox" data-plugin-options='{"delegate": "a.lightbox-portfolio", "type": "image", "gallery": {"enabled": true}}'>
								
						<ul class="portfolio-list">
							
							<?php for ($x = 0; $x <= count($trabajo_img); $x++) { if(!empty($trabajo_img[$x])){?>
						 
							<li class="col-md-12">
										
								<div class="portfolio-item">
									
									<span class="thumb-info thumb-info-centered-icons thumb-info-no-borders">
										
										<span class="thumb-info-wrapper">
										
											<img src="<?=compose_img($trabajo_img[$x]['path'],$trabajo_img[$x]['original_name'],true)?>" class="img-responsive" alt="">
											
											<a href="<?=compose_img($trabajo_img[$x]['path'],$trabajo_img[$x]['original_name'],true)?>" class="lightbox-portfolio">
												
												<span class="thumb-info-action">
												
													<span class="thumb-info-action-icon thumb-info-action-icon-light"><i class="fa fa-search-plus"></i></span>
												
												</span>
												
											</a>
											
										</span>
											
									</span>
									
								</div>
									
							</li> 
							
							<?php } } ?>	
					
						</ul>
							
					</div>
						
				</div>

			</div>

			<div class="col-md-5">
						
				<aside class="sidebar" id="sidebar" data-plugin-sticky data-plugin-options='{"minWidth": 991, "containerSelector": ".container", "padding": {"top": 10}}'>  
					<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
					
						<h2 style="text-align: left!important;"><?=l('elproyecto',pag1,$db_web)?></h2>
					
					</div>
							
					<p class="mt-xlg"><?=$trabajo_description?></p>
  
					<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat">
					
						<h2 style="text-align: left!important;"><?=l('losdetalles',pag1,$db_web)?></h2>
					
					</div>
							 
						<span class="categoria">
							<p><?=l('categoria',pag1,$db_web)?></p>
							<b> </b>
						</span>
						
						<span class="fecha">
							<p><?=l('anoejecucion',pag1,$db_web)?></p>
							<b> </b>
						</span>  
					
				</aside>
			
			</div>
			
		</div>

	</div>

	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="margin-bottom: 0px;">
	
		<div class="container">
	
			<div class="row">
			
				<div class="col-md-3 col-md-offset-5">
				
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
		
		<?php }  ?>

	</div>
	
	
	<? load_contenidorepetido('presupuesto','otras')?>
	
	
</div>