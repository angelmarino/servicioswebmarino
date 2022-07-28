<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Aquí albergamos las funciones de gestión de url web.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/

function load_dominio(){
	/* Con esta función definimos */ 
	if(ssl==1){ define("http", 'https://'); } else { define("http", 'http://'); } 

	define("dominio", $_SERVER['HTTP_HOST']);

	define("httpdominio", http.dominio);
	define("uri", $_SERVER['REQUEST_URI']);
	define("http_dominio_uri", http.dominio.uri);
} 

function url_actual(){
	
	/*
	** Recojemos la configuración actual de la base de datos, para activar o no el ssl.
	*/
	
	if(ssl==1){ $http='https://'; } else { $http='http://'; }
	
	$url = $http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
																						
	return $url;
	
}

/* Funcion especializada en redireccionar a sitio web */

function redirect($uri,$code=302)
{
    // Specific URL
    $location = null;
    
	if (substr($uri,0,4)=='http') {
        
			$location = $uri;
    
		} else {
        
			$location = url_actual();
        
			// Special Trick, // starts at webserver root / starts at app root
       
			if (substr($uri,0,2) == '//') {
            $location .= '/' . ltrim($uri,'/');
        } elseif (substr($uri,0,1) == '/') {
            $location .= '/' . ltrim($uri,'/');
        }
    }

    // $sn = \$_SERVER['SCRIPT_NAME'];
    // $cp = dirname($sn);
    // $schema = \$_SERVER['SERVER_PORT']=='443'?'https':'http';
    // $host = strlen(\$_SERVER['HTTP_HOST'])?\$_SERVER['HTTP_HOST']:\$_SERVER['SERVER_NAME'];
    // if (substr($to,0,1)=='/') $location = "$schema://$host$to";
    // elseif (substr($to,0,1)=='.') // Relative Path
    // {
    //   $location = "$schema://$host/";
    //   $pu = parse_url($to);
    //   $cd = dirname(\$_SERVER['SCRIPT_FILENAME']).'/';
    //   $np = realpath($cd.\$pu['path']);
    //   $np = str_replace(\$_SERVER['DOCUMENT_ROOT'],'',$np);
    //   $location.= $np;
    //   if ((isset(\$pu['query'])) && (strlen(\$pu['query'])>0)) $location.= '?'.\$pu['query'];
    // }
    // }

    $hs = headers_sent();
    if ($hs === false) {
        switch ($code) {
        case 301:
            // Convert to GET
            header("301 Moved Permanently HTTP/1.1",true,$code);
            break;
        case 302:
            // Conform re-POST
            header("302 Found HTTP/1.1",true,$code);
            break;
        case 303:
            // dont cache, always use GET
            header("303 See Other HTTP/1.1",true,$code);
            break;
        case 304:
            // use cache
            header("304 Not Modified HTTP/1.1",true,$code);
            break;
        case 305:
            header("305 Use Proxy HTTP/1.1",true,$code);
            break;
        case 306:
            header("306 Not Used HTTP/1.1",true,$code);
            break;
        case 307:
            header("307 Temporary Redirect HTTP/1.1",true,$code);
            break;
        }
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header("Location: $location");
    }
    // Show the HTML?
    if (($hs==true) || ($code==302) || ($code==303)) {
        // todo: draw some javascript to redirect
        $cover_div_style = 'background-color: #ccc; height: 100%; left: 0px; position: absolute; top: 0px; width: 100%;';
        echo "<div style='$cover_div_style'>\n";
        $link_div_style = 'background-color: #fff; border: 2px solid #f00; left: 0px; margin: 5px; padding: 3px; ';
        $link_div_style.= 'position: absolute; text-align: center; top: 0px; width: 95%; z-index: 99;';
        echo "<div style='$link_div_style'>\n";
        echo "<p>Please See: <a href='$uri'>".htmlspecialchars($location)."</a></p>\n";
        echo "</div>\n</div>\n";
    }
    exit(0);
}


/*
** Con esta función analizaremos la url actual del sitio web y sacaremos en un array.
** geturl[0] = idioma | geturl[1] = categoria padre | geturl[2] = sub categoría
*/

function get_url()
{ 
	// Función sin acavar
	
	$get_url=$_SERVER['REQUEST_URI'];
	 
	// Verificamos la url enviada
	
	if(extension($get_url)=='html'){
	
		// Obtenemos toda la url execto los últimos 5 caracteres.
		$get_url = substr($get_url, 0, -5);
		
		$ex_get_url = explode('/', $get_url);
		 
		$ex_get_url_C = count($ex_get_url);

		/* */
		
		for($x = 1; $x <= $ex_get_url_C; $x++) {
   
			if(!empty($ex_get_url[$x])){ define("pag".$x, $ex_get_url[$x]);}
		
		}
		  
		for($x = 0; $x <= count(is); $x++) {
   
			if(pag1==is[$x]){ $is = 1;} else { $is = 0;}
		
		}
		
		if($is == 1){
			
			define("l", pag1);
		
		} else {
			
			define("l", i);
			
		} 
		
	}
	 
}
 

function format_uri( $string, $separator = '-' )
{
    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = array( '&' => 'and');
    $string = mb_strtolower( trim( $string ), 'UTF-8' );
    $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
    $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
    $string = preg_replace("/[$separator]+/u", "$separator", $string);
    return $string;
}


function youtube_url($url){
    
	$pattern = '
	   %^# Match any youtube URL
    (?:https?://)?  # Optional scheme. Either http or https
    (?:www\.)?      # Optional www subdomain
    (?:             # Group host alternatives
      youtu\.be/    # Either youtu.be,
    | youtube\.com  # or youtube.com
      (?:           # Group path alternatives
        /embed/     # Either /embed/
      | /v/         # or /v/
      | .*v=        # or /watch\?v=
      )             # End path alternatives.
    )               # End host alternatives.
    ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
    ($|&).*         # if additional parameters are also in query string after video id.
    $%x';
	
    $result = preg_match($pattern, $url, $matches);
    
	if(false !== $result){ return $matches[1]; }
	
	return false;
}

function get_socialurl($red){
	
	$redes_s = json_decode(configuracion_social);
		   
	return $redes_s->{$red};;
}

function file_exist($archivo){
	
	/* Procesamos la busqueda del archivo remoto */
	
	$fp = curl_init($archivo); 
	$ret = curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
	
	/* Esperamos 30 segundos */
	$ret = curl_setopt($fp, CURLOPT_TIMEOUT, 30);
	$ret = curl_exec($fp); 
	$info = curl_getinfo($fp, CURLINFO_HTTP_CODE);
	curl_close($fp); 

	/* 
	** Verificamos el estado y si el archivo no existe lanzamos una error,
	** si el archivo existe cargamos el archivo normalmente.
	*/
	if($info == 404) {
		
		/* Lanzamos imagen error definida en una constante */
		$file =  img_notfound; 
		
	} else {
		
		/* Lanzamos el archivo previamente enviado. */
		
		$file = $archivo;
		
	} 
	
	return $file;
}
?>