<?php if (!defined('BASEPATH')) exit('Acceso no permitido.');
  
/*
** Aquí albergamos la carga del footer. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/ 

global $detect;
global $db_gest_in;
global $db_servicios;

?>
 
<header id="header" class="header-mobile-nav-only" data-plugin-options='<?=data_plugin_option($detect)?>'>
			
	<div class="header-body">
			
		<div class="header-top">
			
			<div class="container">
				
				<p>
					<span class="ml-xs"><i class="fa fa-phone"></i> <?=telf_empresa?></span>
				
					<span class="ml-xs hidden-xs">| <i class="fa fa-clock-o"></i> Lunes a Viernes  9:00 a 18:00</span>

					<span class="ml-xs"> | <a href="mailto:<?=obfuscate(mail_cliente)?>"><?=obfuscate(mail_cliente)?></a></span>
				</p>
					 
				<ul class="header-social-icons social-icons idioma-icons">
								
					<li class="<?php if(pag1=='ca'){ echo 'active';}?>">
			
						<a href="<?=httpdominio.cambioidioma('ca')?>"> CAT</a>
			
					</li>
			
					<li class="<?php if(pag1=='es'){ echo 'active';} ?>">
			
						<a href="<?=httpdominio.cambioidioma('es')?>"> ESP</a>
			
					</li> 
							
				</ul>
			
			</div>
					
		</div>
					
		<div class="header-container container">
					
			<div class="header-row">
				
				<div class="header-column">
					
					<div class="header-logo">
							
						<a href="<?=httpdominio?>" title="<?=nombre_empresa?>">
							
							<img src="<?=host_img.logotipo_header?>" alt="<?=nombre_empresa?>" title="<?=nombre_empresa?>">
							
						</a>
						
					</div>
					
				</div>
				
				<div class="header-column">
					
					<div class="header-row">
						
						<div class="header-nav header-nav-dark-dropdown">
							
							<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
							
								<i class="fa fa-bars"></i>
								
							</button>
							
							
							<div class="header-nav-main header-nav-main-square header-nav-main-effect-3 header-nav-main-sub-effect-1 collapse">
											
								<nav>
							
									<ul class="nav nav-pills" id="mainNav">
									
										<li <? if(pag2=='inicio'){ echo 'class="active"';}?>>
	
											<a href="<?='/'.pag1?>/inicio.html" title="<?=l('menu_1_1',pag1,$db_web)?>"> <?=l('menu_1_1',pag1,$db_web)?> </a>
									
										</li> 
									
										<li class="<? if(pag2=='empresa'){ echo 'active';}?>">
										
											<a href="<?='/'.pag1?>/empresa.html" title="<?=l('menu_1_2',pag1,$db_web)?>"> <?=l('menu_1_2',pag1,$db_web)?> </a>
										
										</li> 
									
										<li class="<? if(pag2=='proyectos'){ echo 'active';}?>">
	
											<a href="<?='/'.pag1?>/proyectos.html">
	
												<?=l('menu_1_3',pag1,$db_web)?>
	
											</a>
									
										</li> 
									
										<li class="<? if(pag2=='servicios'){ echo 'active';}?> dropdown">
	
											<a href="<?='/'.pag1?>/servicios.html" class="dropdown-toggle">
	
												<?=l('menu_1_4',pag1,$db_web)?>
	
											</a>
											
											<ul class="dropdown-menu">
												
												<?php 
		 
												 foreach($db_servicios[1] as $dbservicios){
													
													 /* Eliminamos el nombre */ 
													 $dbserviciosnombre = explode('|',$dbservicios['task_name']);
	  
												?> 
											
												<li>
													
													<a href="/<?=pag1?>/servicio/<?=format_uri($dbserviciosnombre[0])?>.html" title="<?=$dbserviciosnombre[0]?>">
														
														<?=$dbserviciosnombre[0];?>
													
													</a>
												
												</li>
												
												<?php } ?>
											
											</ul>
									
										</li> 
									
										<li class="<? if(pag2=='contacto'){ echo 'active';}?>">
											
											<a href="/<?=pag1?>/contacto.html"> <?=l('menu_1_5',pag1,$db_web)?> </a>
											 
										</li> 
									 
										
									</ul>
									
								</nav>
								
							</div>
								
						</div>
						
					</div>
				
				</div>
			
			</div>
			
		</div>
		
	</div>

</header>