<?php if(!defined('BASEPATH')) exit('El acceso no permitido :( ');

header("Cache-Control: must-revalidate");

header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí albergamos el contenido del header de la página de mantenimiento..
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/ 
global $db_gest_in;
global $db_web;
global $detect;
global $titulo_pagina;
global $description_pagina;
global $img_pagina;

?> 

<html<? if (defined('class_html')){ echo ' class="'.class_html.'"';} ?>> 
 
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

		<meta charset="utf-8">
 
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>Página en mantenimiento <?=$titulo_pagina .' - '. nombre_empresa?></title>	
		
		<meta property="og:image"  content="<?=$img_pagina;?>" /> 
		
		<meta name="description" content="<?=$description_pagina;?>">
		
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
		<link href='<?=link_fontgoogle?>' rel='stylesheet' id="googlefont">

		<?php init_css(); ?>
		  
		<script src="<?=grupo_js_moderniz?>"></script>
 
	</head>

	<body> 
		
		<div class="body coming-soon">
		
			<header id="header" data-plugin-options='{"stickyEnabled": false}'>
			
				<div class="header-body">
				
					<div class="header-top">
					
						<div class="container">
					
							<p> 
								
								<span class="ml-xs"> <?=nombre_empresa?> 
									
									<i class="fa fa-phone"></i> <?=telf_empresa?>
								
								</span>
								
								<span class="hidden-xs"></span>
							
							</p>
						
							<ul class="header-social-icons social-icons hidden-xs">
								
								<!--li class="social-icons-facebook">
									
									<a href="http://www.facebook.com/<?=get_socialurl('Facebook')?>" target="_blank" title="Facebook">
										
										<i class="fa fa-facebook"></i>
									
									</a>
								
								</li--> 
							
							</ul>
					
						</div>
						
					</div>
			
				</div>
				
			</header>