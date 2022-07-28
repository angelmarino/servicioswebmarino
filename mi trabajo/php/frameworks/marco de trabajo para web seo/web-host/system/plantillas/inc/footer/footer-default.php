<?php if(!defined('BASEPATH')) exit('Acceso no permitido :('); 
header("Cache-Control: must-revalidate"); 
header("Expires: ".gmdate("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí albergamos la carga del footer. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite
**
*/  
?>
<footer class="color aplacat-background-1" id="footer">
			
	<div class="container">
				
		<div class="row">
				
			<div class="col-md-5">
					
				<h5><?=l('sobrenosotros',pag1,$db_web)?></h5>
					
				<a href="<?=httpdominio?>" title="<?=nombre_empresa?>">
					
					<img src="<?=host_img?>logo-footer-aplacat.png" alt="<?=nombre_empresa?>" title="<?=nombre_empresa?>">
				
				</a>
				
				<p><?=l('text_footer',pag1,$db_web)?></p>
					
				<p><?=nombre_empresa?>© Copyright <?=date('Y')?></p>
				
			</div>
				
			<div class="col-md-3">
				
				<h5>
					
					<?=l('informacion',pag1,$db_web);
					
					if($detect->isMobile()){ ?> 
					
					<a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#informacion" aria-expanded="false" aria-controls="informacion">
  Mostrar
					</a> 
				
					<?php } ?>
				
				</h5>
				
				<ul class="list list-icons list-icons-sm collapse" id="informacion">
					
					<li><i class="fa fa-caret-right"></i> <a href="<?='/'.pag1?>/empresa.html"><?=l('sobrenosotros',pag1,$db_web)?></a></li>
					<li><i class="fa fa-caret-right"></i> <a href="<?='/'.pag1?>/proyectos.html"><?=l('proyecto',pag1,$db_web)?></a></li>
					<li><i class="fa fa-caret-right"></i> <a href="<?='/'.pag1?>/servicios.html"><?=l('servicios',pag1,$db_web)?></a></li>
					<li><i class="fa fa-caret-right"></i> <a href="#formModal" data-toggle="modal" data-target="#formModal"><?=l('solicitarpresupuesto',pag1,$db_web)?></a></li>
				</ul>
						
				<br>
				
				<p class="mapsfooter"> 
				
					<a class="popup-gmaps" href="https://maps.google.com/maps?q=<?=direccion_empresa?>">
						
						<?=l('donde_estamos',pag1,$db_web)?> 
						
						<img src="<?=host_img?>google-maps.png">
					
					</a>
					
				</p>
				
			</div>
		
			<div class="col-md-4 sombra" id="solicitudepresupuesto">
				
				<h5 class="mb-sm"><?=l('contacto',pag1,$db_web)?></h5>
				
				<span class="phone"> <?=telf_empresa?></span>  
				
				<ul class="list list-icons list-icons-sm">
				
					<li><i class="fa fa-envelope"></i> <a href="mailto:<?=obfuscate(mail_cliente)?>"><?=obfuscate(mail_cliente)?></a></li> 
					<li><i class="fa fa-map-marker"></i> <?=direccion_empresa?></li>
			
				</ul> 
			
			</div>
		
		</div>
	
	</div>
	
	<div class="footer-copyright">
		
		<div class="container">
		
			<div class="row">
				
				<div class="col-md-12 center">
				 
					<p class="center text-info">
					
						<a href="https://ingrup.es/es/web/inicio.html" title="INGRUP ESTUDI" rel="external nofollow" target="_blank" class="ingrup">  
							
							<span class="hidden-xs"> Diseño y desarrollo web</span>
			 
							<span class="visible-xs">Estudio de diseño y publicidad</span>
							
							<img src="https://img.ingrup.es/logo_ingrup.png" width="33px" height="41px" alt="ingrup estudi" title="ingrup estudi">
			
							<span class="hidden-xs">Estudio de diseño y publicidad</span>
			
						</a>  
					
					</p>
					
				</div>
				
			</div>
	
		</div>
	
	</div>

</footer>
 