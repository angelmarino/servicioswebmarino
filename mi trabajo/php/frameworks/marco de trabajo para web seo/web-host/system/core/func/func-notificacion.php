<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Aquí albergamos las funciones de notificación web.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
**  
** Proyecto Multisite
**
*/

function send_error(){
	
	/*
	** Recojemos todos los datos del cliente y la página actual. 
	*/
	
	$SERVER_info = '<table cellpadding="10">' ;

	foreach ($_SERVER as $key=>$value) { $SERVER_info .= '<tr><td>'.$key.'</td><td>' .$value. '</td></tr>'; }

	$SERVER_info .= '</table>' ;
	
}
 

/*
** Con esta función sacaremos un mensaje de alerta La vía de entrada tiene que ser json.
*/

function alert($alert){
	
	
 $bien  = isset($bien) ? $bien : null ; 

	$error = isset($error) ? $error : null ; 

	$info  = isset($info) ? $info : null ; 

	$aviso = isset($aviso) ? $aviso : null ; 

	
	/*
	** Mostramos la alerta en formato json
	** {"tipo":"bien","contenido":"Mensaje de salida"}
	**
	** El sistema de colores de la misma cambia según el tipo de alerta (boostrapp)
	*/
	
	function aviso($bien,$error,$info,$aviso){
	
		$alert = isset($alert) ? $alert : null ;
	
		if (!empty($bien))  { $alert = '<div class="alert alert-success" role="alert">' .$bien. '</div>';} 

		if (!empty($error)) { $alert = '<div class="alert alert-danger" role="alert">' .$error. '</div>';} 

		if (!empty($aviso)) { $alert = '<div class="alert alert-warning" role="alert">' .$aviso. '</div>';}

		if (!empty($info))  { $alert = '<div class="alert alert-info" role="alert">' .$info. '</div>';}
  
		return $alert;
	}
	
	
	$alert=json_decode($alert);
		
	if($alert->{'tipo'}=='bien'){
			
		$bien = $alert->{'contenido'};
		
		$bien = aviso($bien, null, null, null);
		
		return $bien;
		
	} 
	
	elseif($alert->{'tipo'}=='error'){
			
		$error = $alert->{'contenido'};
		
		$error = aviso(null, $error, null, null);
			
		return $error;
		
	}
	
	elseif($alert->{'tipo'}=='aviso'){
			
		$aviso = $alert->{'contenido'};
		
		$aviso = aviso(null, null, $aviso, null);
			
		return $aviso;
		
	}
	
	elseif($alert->{'tipo'}=='info'){
			
		$info = $alert->{'contenido'};
		
		$info = aviso(null, null, null, $info);
			
		return $info;
		
	}
	
}


/*
** Función genérica de envio de notificaciones
** 
** $tipo = Aqui establecemos el tipo de notificacion a sacar. 
*/

function send_notificacion($tipo,$usuario,$titulo,$contenido){

	$titulo_mail = $titulo;

	$contenido_mail = $contenido;
	
	$para  = 'soporte@ingrup.es' . ', '; // atención a la coma

	$para .= $usuario;

	$titulo =  $titulo_mail;

	//include 'plantilla-mail.php';

	$mensaje = $platilla_html;

	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$cabeceras .= 'From: Notificación desde INGRUP.ES <web@ingrup.es>' . "\r\n";

	//$cabeceras .= 'Cc: archivotarifas@example.com' . "\r\n";

	//$cabeceras .= 'Bcc: copiaoculta@example.com' . "\r\n";

	// enviamos el correo!

	$estado_mail =	mail($para, $titulo, $mensaje, $cabeceras);

	if ($estado_mail) { 
	
		$info = '{"tipo":"bien","contenido":"Le hemos enviado un email a su correo. :) "}';

	} else { 

		$info = '{"tipo":"error","contenido":"Ha habido un error al procesar el envio."}';

	} 
	
	return $info;
	
}

/* Para enviar mail en utf8 */
function notifi($para, $asunto = '(No subject)', $mensaje = '')
{ 
	$nombre = "=?UTF-8?B?".base64_encode('Web '.nombre_empresa)."?=";
	$asunto = "=?UTF-8?B?".base64_encode($asunto)."?=";

	$headers = "From: $nombre <"."web@".dominio.">\r\n". 
               "MIME-Version: 1.0" . "\r\n" . 
               "Content-type: text/html; charset=UTF-8" . "\r\n"; 

	return mail($para, $asunto, $mensaje, $headers); 
}

function mail_alert($mensaje,$dest=mail_admin){ 
	$mensaje .= send_error();
	notifi($dest, "Aviso desde ".dominio, $mensaje); 
};

?>