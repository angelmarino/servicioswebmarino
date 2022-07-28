<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

// Iniciamos la clase para la descompresión del archivo.

//echo '<h1>Modo desarrollo activo.</h1><br>';


// echo zip_descompress('dev/PHP-Cache-Class-master.zip', 'dev/pruebas/');

header("Cache-Control: must-revalidate");
 
header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
 
//echo l('enviar',"ca",$db_web);

//echo i;
 
// Settings


/* 
get_url();

echo l;

echo pag1;

echo pag2;

echo pag3; */

//	if($load_idioma['0']['idioma']==$i){
//		
//		echo $load_idioma['0']['contenido'];
//		
//	}


$SERVER_info = '<table cellpadding="10">' ;
foreach ($_SERVER as $key=>$value) { $SERVER_info .= '<tr><td>'.$key.'</td><td>' .$value. '</td></tr>'; }
$SERVER_info .= '</table>' ; 
 

require ROOT.'/core/class/-tag-engine.php';


//echo $SERVER_info;
 
/* function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

  */
// include_once ROOT.'plantillas/load.php';


//echo '<img src="'.get_gravatar('support@gravatar.com').'">';

/*

You have missed 'REDIRECT_STATUS'

Very useful if you point all your error pages to the same file.

File; .htaccess
# .htaccess file.

ErrorDocument 404 /error-msg.php
ErrorDocument 500 /error-msg.php
ErrorDocument 400 /error-msg.php
ErrorDocument 401 /error-msg.php
ErrorDocument 403 /error-msg.php
# End of file.

File; error-msg.php
<?php
  $HttpStatus = $_SERVER["REDIRECT_STATUS"] ;
  if($HttpStatus==200) {print "Document has been processed and sent to you.";}
  if($HttpStatus==400) {print "Bad HTTP request ";}
  if($HttpStatus==401) {print "Unauthorized - Iinvalid password";}
  if($HttpStatus==403) {print "Forbidden";}
  if($HttpStatus==500) {print "Internal Server Error";}
  if($HttpStatus==418) {print "I'm a teapot! - This is a real value, defined in 1998";}

?>

*/

?>




<?php 



/*


Detectar internet explorer

<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE ||
    strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) {
    echo 'You are using Internet Explorer.<br />';
}
?>





*/

?>