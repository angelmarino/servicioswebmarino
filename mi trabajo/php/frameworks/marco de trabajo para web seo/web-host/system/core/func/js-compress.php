<?php

$l=$_GET['script']; $p=$_GET['p'];

$url_plantilla = "inc/plantillas/mapintxo.com/";

if($_GET['js']=="script")
{
	$js = array(
								$url_plantilla.'js/modernizr-2.6.2.min.js',
								$url_plantilla.'js/jquery.js',
								$url_plantilla.'js/jquery.mobilemenu.js',
								
								$url_plantilla.'js/jquery.cookie.js',
								#$url_plantilla.'js/controlpanel.js',
								
					   $url_plantilla.'js/jquery.viewport.js',
								$url_plantilla.'js/jquery.tabs.min.js',
								
					   $url_plantilla.'js/jquery.prettyPhoto.js',
								$url_plantilla.'js/jquery.carouFredSel-6.2.0-packed.js',
								$url_plantilla.'js/jquery.tweet.js',
								$url_plantilla.'js/custom.js',
								
						  $url_plantilla.'js/isotope.js', 
		      $url_plantilla.'js/jquery.smartresize.js', 
					
						  $url_plantilla.'js/jquery.themepunch.plugins.min.js',
								$url_plantilla.'js/jquery.themepunch.revolution.min.js',
					
					   $url_plantilla.'js/layerslider.transitions.js',
							 $url_plantilla.'js/layerslider.kreaturamedia.jquery.js'
								);
				}
  
$raiz_css="../../";

header("content-type:application/x-javascript");
  
ob_start("compress");
  
function compress($buffer) 
{
  
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    
	return $buffer;
  
}

$count = count($js);

for ($in=0; $in<$count; $in++)
{
	include($raiz_css.$js[$in]) ;
}

ob_end_flush();
?>