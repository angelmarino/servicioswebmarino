<?php  if(!defined('BASEPATH')) exit('El acceso no permitido :( '); 
 
/*
** Aquí albergamos la configuración del sitio web que se va a cargar.
** Reglas de desaroollo:
*** Cualquier adición a este código se ha de realizar en la parte inferior del sitio web.
*** Cualquier modificación o alteración se ha de indicar la fecha y lugar al inicio de cada grupo de script.
**  
** Autor: Angel Luis <contacto@angelluis.es> 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite.
*/ 
 
// Llamamos a la funcion get_url para tener la lista de url actual de sitio web.

get_url(); 

if(ssl==1){
	
	/*
		** Verificamos en la configuración el ssl.
		** En caso de no usar ssl creamos la variable http sin ssl. 
		** añadir a la función rediret() la opción de sll.
		*/
		
		if($_SERVER['HTTPS'] != "on")
		{ 
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			exit();
		}
	}

/*
** Fecha de modificación: 8-12-2015 
** Grupo de hojas de estilo del sitio web 
** En esta sección definimos los estilos del sitio web.
** Reglas:
*** En los array hay que enumerarlos manualmente.
*/ 

define('admin_extencion',true); // Habilitamos en la funcion initcss(); las extenciones. ** Fecha de modificación: 8-12-2015 
define('css_zip',false); // Decidimos si queremos comprimir el css de lo contrario cargará  los archivos css uno a uno.

$grupo_css = array(); 
$grupo_css['web'][1] = array('vendor/bootstrap/css/bootstrap.css', 'vendor/font-awesome/css/font-awesome.css', 'vendor/simple-line-icons/css/simple-line-icons.css', 'vendor/owl.carousel/assets/owl.carousel.min.css', 'vendor/owl.carousel/assets/owl.theme.default.min.css', 'vendor/magnific-popup/magnific-popup.css');

$grupo_css['web'][2] = array('css/theme.css', 'css/theme-elements.css', 'css/theme-blog.css', 'css/theme-shop.css', 'css/theme-animate.css');
 
$grupo_css['web'][3] = array('vendor/rs-plugin/css/settings.css', 'vendor/rs-plugin/css/layers.css', 'vendor/rs-plugin/css/navigation.css', 'vendor/circle-flip-slideshow/css/component.css', 'vendor/nivo-slider/nivo-slider.css', 'vendor/nivo-slider/default/default.css');

$grupo_css['web'][4] = array('fonts/fontello.css', 'css/custom.css');

define('link_fontgoogle','https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light');

if(admin_extencion==false or $_GET['view']=='admin'){
	
/* 
** Fecha de modificación: 8-12-2015
** Iniciamos la carga de los estilos avanzados del sitio web 
** Nota: Si mas de 3 página que precisan de ellos quitar la limitación 
*/
	
	$grupo_css['admin'][5] = array('admin/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css', 
	 'admin/vendor/jquery-ui/jquery-ui.css',
	 'admin/vendor/jquery-ui/jquery-ui.theme.css',
	 'admin/vendor/select2/css/select2.css',
	 'admin/vendor/select2-bootstrap-theme/select2-bootstrap.css',
	 'admin/vendor/bootstrap-multiselect/bootstrap-multiselect.css',
	 'admin/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css');

	$grupo_css['admin'][6] = array('admin/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css',
	 'admin/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css',
	 'admin/vendor/dropzone/basic.css',
	 'admin/vendor/dropzone/dropzone.css',
	 'admin/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css',
	 'admin/vendor/summernote/summernote.css',
	 'admin/vendor/summernote/summernote-bs3.css',
	 'admin/vendor/codemirror/lib/codemirror.css',
	 'admin/vendor/codemirror/theme/monokai.css','admin/stylesheets/theme-admin-extension.css');  
}

/* Contamos el grupo de array de css de la web */
$grupo_css_C = count($grupo_css['web']); 
define('count_css_1', $grupo_css_C);

/* Contamos el grupo de array de css de las extenciones. */ 
$grupo_css_AC = count($grupo_css['admin']); 
define('count_css_2', $grupo_css_AC);

/* Sumamos el total de ccs de los array(); */
define('count_css', (count_css_1+count_css_2));

/* Finalizamos el procesamiento de los css */





/*
** Fecha de modificación: 8-12-2015
**  
** En el caso de tener problemas con la ejecución de los js lo cambiamos a false y asi el contenido js no se cachea.
*/
define('js_zip',false); // Decidimos si queremos cargar los archivos js comprimidos de los contrario los cargará uno a uno.

$grupo_js = array();
$grupo_js['web'][1] = array('vendor/jquery/jquery.min.js', 
														'vendor/jquery.appear/jquery.appear.min.js', 
														'vendor/jquery.easing/jquery.easing.min.js', 
														'vendor/jquery-cookie/jquery-cookie.min.js', 
														'vendor/bootstrap/js/bootstrap.min.js', 
														'vendor/common/common.min.js', 
														'vendor/jquery.validation/jquery.validation.min.js',
														'vendor/jquery.stellar/jquery.stellar.min.js',
														'vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js',
														'vendor/jquery.gmap/jquery.gmap.min.js',
														'vendor/jquery.lazyload/jquery.lazyload.min.js',
														'vendor/isotope/jquery.isotope.min.js',
														'vendor/owl.carousel/owl.carousel.min.js',
														'vendor/magnific-popup/jquery.magnific-popup.min.js',
														'vendor/vide/vide.min.js'); 

$grupo_js['web'][2] = array('js/theme.js','js/custom.js','js/theme.init.js'); 

define('js_custom',3);// Definimos el numero del array que se encargará de filtrar

 
	
	$grupo_js['web'][3] = array('js/examples/examples.gallery.js',
															'js/examples/examples.carousels.js', 
															'vendor/rs-plugin/js/jquery.themepunch.tools.min.js',
															'vendor/circle-flip-slideshow/js/jquery.flipshow.js',
															'vendor/rs-plugin/js/jquery.themepunch.revolution.min.js',
															'vendor/nivo-slider/jquery.nivo.slider.min.js',
															'js/views/view.home.js',
															'js/views/view.contact.js',
															'js/examples/examples.lightboxes.js');
															 
 
 
if(admin_extencion==false or $_GET['view']=='admin'){
	
	/* 
	** Fecha de modificación: 8-12-2015
	** Iniciamos la carga de los estilos avanzados del sitio web.
	** Nota: Si mas de 3 página que precisan de ellos quitar la limitación 
	*/
	$grupo_js['admin'][4] = array('admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
		'admin/vendor/jquery-placeholder/jquery-placeholder.js',
		/*'admin/vendor/jquery-ui/jquery-ui.js',*/
		'admin/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js',
		'admin/vendor/select2/js/select2.js',
		'admin/vendor/bootstrap-multiselect/bootstrap-multiselect.js',
		'admin/vendor/jquery-maskedinput/jquery.maskedinput.js',
		'admin/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js',
		'admin/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
		'admin/vendor/bootstrap-timepicker/bootstrap-timepicker.js',
		'admin/vendor/fuelux/js/spinner.js',
		'admin/vendor/dropzone/dropzone.js',
		'admin/vendor/bootstrap-markdown/js/markdown.js',
		'admin/vendor/bootstrap-markdown/js/to-markdown.js',
		'admin/vendor/bootstrap-markdown/js/bootstrap-markdown.js',
		'admin/vendor/codemirror/lib/codemirror.js',
		'admin/vendor/codemirror/addon/selection/active-line.js',
		'admin/vendor/codemirror/addon/edit/matchbrackets.js',
		'admin/vendor/codemirror/mode/javascript/javascript.js');
	
	$grupo_js['admin'][5] = array('admin/vendor/codemirror/mode/xml/xml.js',
		'admin/vendor/codemirror/mode/htmlmixed/htmlmixed.js',
		'admin/vendor/codemirror/mode/css/css.js',
		'admin/vendor/summernote/summernote.js',
		'admin/vendor/bootstrap-maxlength/bootstrap-maxlength.js',
		'admin/vendor/ios7-switch/ios7-switch.js',
		'admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js',
		'admin/javascripts/theme.admin.extension.js',
		'admin/javascripts/forms/examples.advanced.form.js');
}
 
/* Contamos el grupo de array de js de la web. */
$grupo_js_C = count($grupo_js['web']); 
define('count_js_1', $grupo_js_C);

/* Contamos el grupo de array de js de las extenciones. */ 
$grupo_js_AC = count($grupo_js['admin']); 
define('count_js_2', $grupo_js_AC);

/* Sumamos el total de ccs de los array(); */
define('count_js', (count_js_1+count_js_2)); 

define('grupo_js_map','//maps.google.com/maps/api/js?sensor=false');
define('grupo_js_moderniz','/vendor/modernizr/modernizr.min.js'); // 10-12-2015

 
/*
** Definimos las clases de la estructura del html del sitio web
*/  

define('class_html', 'boxed');

// Definimos la primera clase del del primer div del body
define('class_body', 'body '); 

define('logotipo', 'site-container'); 


$datos_empresa = json_decode(datos_empresa);

$datos_web = json_decode(datos_web);

define("nombre_empresa", $datos_empresa->{'nombre'});

define("direccion_empresa", $datos_empresa->{'direccion'});

define("telf_empresa", $datos_empresa->{'telefono'});

define("logotipo_empresa", $datos_empresa->{'logotipo'});

define("google_verifi", $datos_empresa->{'google_verifi'});

define("msn_verif", $datos_empresa->{'msn_verif'});

define("host_img", $datos_web->{'host_img'});

define("logotipo_header", $datos_web->{'logotipo'});

define("img_notfound","https://img.ingrup.es/not_found.png");// Requeria por el sistema

define("url_gestion", 'https://file.ingrup.es/');// Requeria por el sistema

define("shortcuticon", '/img/favicon.ico');// Requeria por el sistema

define("apple_touch_icon", '/img/apple-touch-icon.png');// Requeria por el sistema
 
/* 
Constantes representadas *httpdominio* validad si esta actio o no el ssl del domnio.
*/
load_dominio();

 // Establecemos los idiomas activos en el sitio web.
 
const lang_activo = array('es','ca'); 


/* 
** Definimos las página web activas en el sitio web. 
*/
const paginas_web = array('inicio',
													'servicios',
													'servicio',
													'galeria',
													'menus',
													'menus-cat',
													'menu',
													'contacto', 
													'mantenimiento',
													'legal');

// Creamos una funcion unica para este sitio web.
function cambioidioma($idioma){
    
	# Definimos la url corta. 
  $view_url = substr($_SERVER['REQUEST_URI'], 3);  
	    if(lang_activo[0]==$idioma) { $view_url = '/es'.$view_url; } 
	elseif(lang_activo[1]==$idioma) { $view_url = '/ca'.$view_url; }
	   
	return $view_url;
} 

/* Establacemos la configuracion de Meditor */

/* */

define('latitud','41.6264738');
define('longitud','2.2973091000000068');
define('tb_cache','524');
    
if(pag1=='es'){
	
			/* Tablas de base de datos en castellano */  
			define('db_sitioweb_ec','85');
			
			/* Servicios */
			define('tb_servicios','191');
			define('tb_fdtitle_servicio','632');
			
			/* Solicitud de presupuesto */
			define('tb_solpresupuesto','581');
			
			/* Página empresa */
			define('tb_empresa','195'); # Milestone
			define('tb_secc_slider_2','561'); # Tarea
			define('tb_fdtitle_empresa','593');
			
			/* Trabajos realizados */
			define('db_trabajos','90');
			define('tb_fdtitle_trabajos','594');
		 
			/* Página Inicio */
			define('tb_secc_slider_1','560');
			define('tb_secc_inicio_1','578');
			define('tb_secc_inicio_2','579');
			define('tb_secc_inicio_3','580'); 
	    define('tb_proveedores','563');  
			
			/* Página de contacto */
	    define('tb_fdtitle_contacto','630');
      define('tb_contacto','193');
}
elseif(pag1=='ca'){ 
	
	/* Tablas de base de datos en castellano */  
	define('db_sitioweb_ec','92');
			
	/* Servicios */
	define('tb_servicios','200');
	define('tb_fdtitle_servicio','631');
			
	/* Solicitud de presupuesto */
	define('tb_solpresupuesto','604');
			
	/* Página empresa */
	define('tb_empresa','203'); # Milestone
	define('tb_secc_slider_2','598'); # Tarea
	define('tb_fdtitle_empresa','614');
			
	/* Trabajos realizados */
	define('db_trabajos','93');
	define('tb_fdtitle_trabajos','615');
		 
	/* Página Inicio */
	define('tb_secc_slider_1','597');
	define('tb_secc_inicio_1','601');
	define('tb_secc_inicio_2','602');
	define('tb_secc_inicio_3','603'); 
	define('tb_proveedores','600'); 
			
	/* Página de contacto */
	define('tb_fdtitle_contacto','629');
	define('tb_contacto','201'); 
}


 

?>