<?php if(!defined('BASEPATH')) exit('Acceso no permitido :( ');

global $titulo_pagina;
global $description_pagina;
global $img_pagina;

?>
<!DOCTYPE html> 

<html <?php if(defined('class_html')){ echo ' class="'.class_html.'"';} ?>> 

	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

		<meta charset="utf-8">
 
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title><?=$titulo_pagina;?></title>	

		<link rel="canonical" href="<?=url_actual()?>" />
 
		<meta property="og:title"  content="<?=$titulo_pagina;?>" /> 
	
		<meta property="og:description" content="<?=$description_pagina;?>" />
 
		<meta property="og:image"  content="<?=$img_pagina;?>" /> 
	
		<meta property="og:locale" content="<?=pag1?>_ES" />

		<meta property="og:type" content="website" />
	
		<meta name="keywords" content="" />
	
		<meta name="description" content="<?=$description_pagina;?>">
	
		<meta name="author" content="INGRUP.ES">

		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
		<?php  $config_social = json_decode(configuracion_social); if($config_social->{'Twitter'} != '0'){?>
	
		<meta name="twitter:card" content="summary"/>

		<?php /* Descripción del sitio web para twitter */ ?>
		<meta name="twitter:description" content="<?=$description_pagina;?>"/>

		<?php /* Titulo del sitio web para twitter */ ?>
		<meta name="twitter:title" content="<?=$titulo_pagina;?>"/>
 
		<?php /* Usuario de twitter */ ?>
		<meta name="twitter:site" content="@<?=$config_social->{'Twitter'};?>"/>
 
		<?php /* Dominio */ ?>
		<meta name="twitter:domain" content="<?=$config_social->{'Twitter'};?>"/>
 
		<?php /* Imagen destacada del sitio web */ ?>
		<meta name="twitter:image" content="<?=$img_pagina;?>"/>

		<?php /* Usuario autor del sitio web */ ?>
		<meta name="twitter:creator" content="@<?=$config_social->{'Twitter'}?>"/>
	
		<?php } ?> 
	
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?=shortcuticon?>" type="image/x-icon" />
		<link rel="apple-touch-icon" href="<?=apple_touch_icon?>">

		<!-- Web Fonts  -->

		<link href="<?=link_fontgoogle?>" rel="stylesheet" type="text/css">
 
		<?php init_css(); ?> 
		
		<script src="<?=grupo_js_moderniz?>"></script> 
		
		<script type="application/ld+json">
		{
		  "@context" : "http://schema.org", "@type" : "LocalBusiness", "name" : "<?=nombre_empresa?>",
			"image" : "<?=host_img.logotipo_header?>", "telephone" : "+34 <?=telf_empresa?>",
			"email" : "<?=mail_cliente?>", "url" : "<?=httpdominio?>"},
			"review": { 
			 "@type":"Review", "reviewBody":"<?=$description?>",
			 "@type":"Person", "name":"<?=nombre_empresa?>"
			}
		}
		</script>
		
		<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "url": "<?=httpdominio?>",
      "logo": "<?=host_img.logotipo_header?>"
    } 
		</script> 
		
		<script type="application/ld+json">
				{ 
				  "@context" : "http://schema.org", 
					"@type" : "Organization",
					"name" : "<?=nombre_empresa?>",
					"url" : "<?=httpdominio?>",
					"sameAs" : ["<?=$social_google?>", "<?=$social_twitter?>", "<?=$social_facebook?>", "<?=$social_linked?>"] 
				}
		</script> 
		
		<script type="application/ld+json">	
		{ 
	   "@context" : "http://schema.org",
     "@type" : "Organization",
     "url" : "<?=httpdominio?>/<?=pag1?>/contacto.html",
     "contactPoint" : [
       { 
			   "@type" : "ContactPoint",
         "telephone" : "+34 <?=telf_empresa?>",
         "contactType" : "customer care"
       } ]
		}
		</script>

	</head>

	<body>
		
		<div <?php if(defined('class_body')){ echo 'class="'.class_body.'"';} ?>>
		 
			<?php load_header('default');?>
			  
			<?php load_main(pag2);?>
			
			<?php load_footer('default'); ?>
	 
		</div>
	
		<?php init_js(); ?> 
		
		<?php if(pag2=='contacto'){?>
	
		<script src="<?=grupo_js_map?>"></script> 
		
		<script>
			
			<?php
			/*  
			Map Settings 
			- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
			- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/
			*/ 
			
			?>
			var mapMarkers = [{
				address: "<?=strip_tags(direccion_empresa)?>",
				html: "<img height='30px' src='<?=host_img.logotipo_header?>'><br><?=direccion_empresa?>",
				icon: {
					image: "/img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				},
				popup: true
			}];
 
			var initLatitude = <?=latitud?>;
			var initLongitude = <?=longitud?>;
 
			var mapSettings = {
				controls: {
					draggable: (($.browser.mobile) ? false : true),
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true
				},
				scrollwheel: false,
				markers: mapMarkers,
				latitude: initLatitude,
				longitude: initLongitude,
				zoom: 16
			};

			var map = $("#googlemaps").gMap(mapSettings);
 
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$("#googlemaps").gMap("centerAt", options);
			} 
			 
		</script>
		  
		<?php } ?>
		
		<?php load_analytics(31); ?>
		
	</body>
	
</html>