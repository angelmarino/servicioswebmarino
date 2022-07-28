<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Aquí albergamos las funciones de seguridad web.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/


/*
** Con estas funciones limpiamos todo lo que llega por GET y POST
*/
function _post($post,$ifilter){
 
	$post = isset($_POST[$post]) ? $_POST[$post] : null ;
	
	$post = addslashes($post);
	
	$post = $ifilter->process($post);
	
	return $post;
}
function _get($get,$ifilter){
	
	$get = isset($_GET[$get]) ? $_GET[$get] : null ;
	  
	$get = addslashes($get);
	
	$get = $ifilter->process($get);
	 
	return $get;
}

/*
** Función encargada de limpiar los datos enviados por post y get
*/

function limpiarCadena($valor)
{
	$valor = str_ireplace("SELECT","",$valor);
	$valor = str_ireplace("COPY","",$valor);
	$valor = str_ireplace("DELETE","",$valor);
	$valor = str_ireplace("DROP","",$valor);
	$valor = str_ireplace("DUMP","",$valor);
	$valor = str_ireplace("select","",$valor);
	$valor = str_ireplace("copy","",$valor);
	$valor = str_ireplace("delete","",$valor);
	$valor = str_ireplace("drop","",$valor);
	$valor = str_ireplace("dump","",$valor);
	$valor = str_ireplace(" OR ","",$valor);
	$valor = str_ireplace("%","",$valor);
	$valor = str_ireplace("LIKE","",$valor);
	$valor = str_ireplace("--","",$valor);
	$valor = str_ireplace("^","",$valor);
	$valor = str_ireplace("[","",$valor);
	$valor = str_ireplace("]","",$valor);
	$valor = str_ireplace("\\","",$valor);
	$valor = str_ireplace("!","",$valor);
	$valor = str_ireplace("¡","",$valor);
	$valor = str_ireplace("?","",$valor);
	$valor = str_ireplace("=","",$valor);
	$valor = str_ireplace("&","",$valor);
				
	return $valor;
}


/*
** Función que permite la verificación simple de un email sin verificar si el dominio existe.
*/

function verificaremail($email){

	if(!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$",$email)){ 
		
		return FALSE; 
	
	}else{ 
		
		return TRUE; 
	
	} 

}


/*
** Función que permite la verificacion completa de un email verificando que el dominio existe.
*/
 
function ValidateMail($Email) { 
           
	global $HTTP_HOST; 
    
	$result = array(); 

// Step 2 -- Verifícamos el formato de la dirección de email. 

// A continuación, vamos a usar nuestra expresión regular para determinar si la dirección de correo electrónico está formateado correctamente. Si la dirección de correo electrónico no es válida, devuelve un error:

	if(!filter_var($Email, FILTER_VALIDATE_EMAIL)) { 

		$result[0]=false; 
      
		$result[1]="$Email no tiene un formato correcto."; 
     
		return $result; 
   
	} 

# Step 3 -- Busque la dirección del servidor de correo 

# Ahora, partirse la dirección de correo electrónico y utilizar el nombre de dominio para buscar un servidor de correo que puede utilizar para comprobar aún más la dirección de correo electrónico. Si no se encuentra un servidor de correo, usted sólo tiene que utilizar la dirección de dominio como una dirección de servidor de correo:

# Note: En el caso de que el paso opcional 4 no se sigue, la parte de otra cosa de este paso debe devolver en el error para que la secuencia de comandos para funcionar correctamente. 

	list ( $Username, $Domain ) = explode("@",$Email); 

	if (getmxrr($Domain, $MXHost))  { 

		$ConnectAddress = $MXHost[0]; 
    
	} else { 

		$ConnectAddress = $Domain; 

	} 

// Step 4 -- Conectarse a servidor de correo y comprobar la dirección de correo electrónico (OPTIONAL) 

// Por último, una vez que tenga la mejor conjetura en un servidor de correo, es el momento de abrir una conexión y hablar con el servidor. Como dije anteriormente, este paso es opcional. Después de cada orden que usted envíe, tendrás que leer un kilobyte (1024 bytes) de datos del servidor. Debería ser más que suficiente para recibir la respuesta completa del servidor para ese comando.

// Tenga en cuenta que usted va a almacenar la salida desde el servidor en tres variables independientes: $ a, $ Desde y $ Out. Esto se hace para que pueda comprobar las respuestas después de cerrar la conexión, para ver si realmente tiene una dirección de correo electrónico real o no.

// Si el guión no se puede conectar en absoluto, o la dirección de correo electrónico no es válida, defina el array $ resultado a los valores adecuados:
/*
	$Connect = fsockopen ( $ConnectAddress, 25 ); 

	if($Connect){

		if(ereg("^220", $Out = fgets($Connect, 1024))) { 

			fputs ($Connect, "HELO $HTTP_HOST\r\n"); 
           
			$Out = fgets ( $Connect, 1024 ); 
          
			fputs ($Connect, "MAIL FROM: <{$Email}>\r\n"); 
         
			$From = fgets ( $Connect, 1024 ); 
          
			fputs ($Connect, "RCPT TO: <{$Email}>\r\n"); 
         
			$To = fgets ($Connect, 1024); 
        
			fputs ($Connect, "QUIT\r\n"); 
       
			fclose($Connect); 
      
			if (!ereg ("^250", $From) || !ereg ( "^250", $To )) { 
               
				$result[0]=false; 
              
				$result[1]="Servidor rechazó dirección"; 
               
				return $result; 

			}
		
		} 
		
		else { 

			$result[0] = false; 
           
			$result[1] = "No hay respuesta del servidor"; 
            
			return $result; 
       
		}
	
	} else { 

		$result[0]=false; 
       
		$result[1]="No se puede conectar el servidor de correo electrónico."; 
      
		return $result; 
   
	} 
*/
// Step 5 -- Devolver los resultados

// Finalmente, la última y más fácil de paso es devolver los resultados y acabado:
   
	$result[0]=true; 
   
	$result[1]="$Email parece ser válida."; 
  
	return $result; 
	
}
  

/*
$mailusuario[0];

// 1 = mail válido;
// 0 = mail inválido;

$mailusuario[1];

// Saca la dirección de email

*/
 
function web_key($domain,$product) {
  
	$postvalue="domain=$domain&product=".urlencode($product);

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, url_webkey);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postvalue);
	$result= json_decode(curl_exec($ch), true);
	curl_close($ch);

	if($result['status'] != 200) {
	
		define("load_web_key", 0,FALSE);
		$html = file_get_contents(ROOT.'temp/license_key.tpl');
		$search = '<%returnmessage%>';
		$replace = $result['message'];
		$html = str_replace($search, $replace, $html);

		die($html);

	} else {
		
		define("load_web_key", 1,TRUE);
		
	}
}           
?> 