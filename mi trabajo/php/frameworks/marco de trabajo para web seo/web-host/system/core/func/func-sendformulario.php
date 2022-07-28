<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Aquí albergamos las funciones de gestión de url web.
** Autor: Angel Luis
** Empresa: Nolobrown S.L.
** Proyecto Multisite
*/

function process_form(){
 
	global $db_gest_in;
	global $db_web;

	session_cache_limiter('nocache');

	header('Expires: ' . gmdate('r', 0));
	header('Content-type: application/json');
 
	$enablePHPMailer = false;
	 
	$ValidateMail=ValidateMail($_POST['email']);
	
	if(!empty($_POST['email']) and $ValidateMail['0']=='1') {
 
		$fields = array(0 => array('text' => 'Nombre', 'val' => $_POST['nombre']),
										1 => array('text' => 'Apellidos', 'val' => $_POST['apellidos']),
										2 => array('text' => 'Email', 'val' => $_POST['email']),
										3 => array('text' => 'Servicios', 'val' => $_POST['servicio']),
										4 => array('text' => 'Teléfono', 'val' => $_POST['telefono']),
										5 => array('text' => 'Mensaje', 'val' => $_POST['mensaje'])
									 );

		$message = "";

		foreach($fields as $field) 
		{
			$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
		}
 
		$headers = '';
		$headers .= 'From: ' . nombre_empresa . ' <'.'web@'.dominio.'>' . "\r\n";
		$headers .= "Reply-To: " .  $_POST['email'] . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		/* Preparamos la info para enviar al sistema de gestion de ingrup */
		$data_C = array("user_to" => id_cliente, "user_from" => "33", "message" => $message);
		
		/* Nos enviamos la misma información */
		$data_A = array("user_to" => '1', "user_from" => "33", "message" => $message);
		
		$id_cliente = $db_gest_in->insert('fx_messages', $data_C);
		$id_admin = $db_gest_in->insert('fx_messages', $data_A);
		
		/* SACAMOS LA PLANTILLA A ENVIAR POR MAIL */
		
		$db_gest_in->where('email_group', 'message_received'); 
		$results = $db_gest_in->get('fx_email_templates'); 
		  
		$a_remplazar = array("{SENDER}", "{RECIPIENT}", "{MESSAGE}"); 
		$remplazado   = array("INMANAGER", nombre_empresa, $message);

		$newphrase = str_replace($a_remplazar, $remplazado, $results[0]['template_body']);

		// Gives: SELECT * FROM users WHERE firstName='John' OR firstName='peter'
		if(mail(mail_cliente, $results[0]['subject'], $newphrase, $headers) and $id_cliente and $id_admin) { 
			
			$arrResult = array ('response'=>'success');
		
			/* añadimos un segundo envio a manuel */
			mail_alert($message,'creatiu@ingrup.es');
			
		} else {
			
			$arrResult = array ('response'=>'error'); 
			mail_alert('fallo al enviar el formulario');
		
		} 
		
		echo json_encode($arrResult); 
	
	} else {

		mail_alert('Fallo al enviar el formulario '.$ValidateMail['1'].' '.$_POST['email']);
		
		$arrResult = array('response'=>'error');
	
		echo json_encode($arrResult);

	}


} 
	
?>