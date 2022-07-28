<?php  if(!defined('BASEPATH')) exit('El acceso no permitido :( '); 

/*
** Aquí albergamos las funciones genéricas web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/

?>
<div role="main" class="main">

	<?php $get_img = get_img(tb_fdtitle_contacto);?>
	
	<section class="page-header page-header-center page-header-more-padding page-header-no-title-border page-header-custom-background" style="background-image: url(<?=compose_img($get_img[0]['path'],$get_img[0]['file_name'],true)?>);">
		
		<div class="container">
				
			<div class="row">
					
				<div class="col-md-12">
					
					<h1><?=l('contactaconnosotros',pag1,$db_web)?></h1>
						
					<ul class="breadcrumb">
						
						<li><a href="#"><?=l('menu_1_1',pag1,$db_web)?></a></li>
							
						<li class="active"><?=l('menu_1_5',pag1,$db_web)?></li>
						
					</ul>
						
				</div>
				
			</div>
			
		</div>
		
	</section>
  
	<div class="container">
		 
		<div class="row">
			
			<div class="col-md-8">
				
				<div class="row">
		
					<div class="col-md-7 col-md-offset-0">
		
						<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat"> 
			
							<h2 style="text-align: left!important;"> <?=l('formulario contacto',pag1,$db_web)?> </h2> 
				
						</div>
					
					</div>
				
				</div>
			
				<div class="row">
					
					<?php load_formulario();?> 
				
				</div>
		
			</div>
		
			<div class="col-md-4 sombra" id="solicitudepresupuesto">
					
				<div class="row">
		
					<div class="col-md-6 col-md-offset-0">
		
						<div class="heading heading-tertiary heading-border heading-bottom-border titleaplacat"> 
			
							<h2 style="text-align: left!important;"><?=l('contacto',pag1,$db_web)?></h2>
				
						</div>
					
					</div>
				
				</div>
				
				<ul class="list list-icons list-icons-sm">
					
					<li><i class="fa fa-map-marker"></i> <?=direccion_empresa?></li>
					<li><i class="fa fa-envelope"></i> <a href="mailto:<?=obfuscate(mail_cliente)?>"><?=obfuscate(mail_cliente)?></a></li>
					<li><i class="fa fa-phone"></i> <?=telf_empresa?></li>
					<li><i class="fa fa-clock-o"></i> Lunes a Viernes  9:00 a 18:00</li>
			
				</ul> 
				
			</div>
		
		</div>
		
	</div>
	 
	<section class="section map"> 
		<div id="googlemaps" class="google-map"></div> 
	</section> 
	<?php load_contenidorepetido('presupuesto','otras'); ?>
 
</div>