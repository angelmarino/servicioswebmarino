<?php if (!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/* Aqui llamamos a la clase de compresion de css según se requiera la página que estamos cargando 

Estilos genericos


<link rel="stylesheet" type="text/css" href="" media="screen"> 

*/

/* Archivos predeterminados del sistema de archivos css */
$vendor_css = array('vendor/bootstrap/css/bootstrap.css',
																				'vendor/font-awesome/css/font-awesome.css',
																			 'vendor/simple-line-icons/css/simple-line-icons.css',
																			 'vendor/owl.carousel/assets/owl.carousel.min.css',
																			 'vendor/owl.carousel/assets/owl.theme.default.min.css',
																			 'vendor/magnific-popup/magnific-popup.css');

/* Archivos necesario para el thema por defcto del sitio web */
$theme_css = array('css/theme.css',
																			'css/theme-elements.css',
																			'css/theme-blog.css',
																			'css/theme-shop.css',
																			'css/theme-animate.css');

/* Estilos necesarios para la página actual 
** Estos archivos son variables asi que... ojo 
*/
$page_css = array('vendor/rs-plugin/css/settings.css',
																		'vendor/rs-plugin/css/layers.css',
																		'vendor/rs-plugin/css/navigation.css',
																		'vendor/circle-flip-slideshow/css/component.css',
																		'css/theme-animate.css');

/* Estilos del thema por defecto y las modificaciones
** Para no duplicar estilo es recomendable copiar el archivo por defecto a custom y trabajar sobre ese.*/
$estilopropio_css = array('css/skins/default.css', 'css/custom.css');


$vendor_js = array('vendor/jquery/jquery.js',
																		'vendor/jquery.appear/jquery.appear.js',
																		'vendor/jquery.easing/jquery.easing.js',
																		'vendor/jquery-cookie/jquery-cookie.js',
																		'vendor/bootstrap/js/bootstrap.js',
																		'vendor/common/common.js',
																		'vendor/jquery.validation/jquery.validation.js',
																		'vendor/jquery.stellar/jquery.stellar.js',
																		'vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js',
																		'vendor/jquery.gmap/jquery.gmap.js',
																		'vendor/jquery.lazyload/jquery.lazyload.js',
																		'vendor/isotope/jquery.isotope.js',
																		'vendor/owl.carousel/owl.carousel.js',
																		'vendor/magnific-popup/jquery.magnific-popup.js',
																		'vendor/vide/vide.js',
																		'js/theme.js');

$plugin_js = array('vendor/rs-plugin/js/jquery.themepunch.tools.min.js',
																		'vendor/rs-plugin/js/jquery.themepunch.revolution.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.actions.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.carousel.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.kenburn.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.migration.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.navigation.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.parallax.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.slideanims.min.js',
																		'vendor/rs-plugin/js/extensions/revolution.extension.video.min.js',
																		'vendor/circle-flip-slideshow/js/jquery.flipshow.js',
																		'js/views/view.home.js');

$load_js = array('js/custom.js','js/theme.init.js');

?>



<?php 

?>