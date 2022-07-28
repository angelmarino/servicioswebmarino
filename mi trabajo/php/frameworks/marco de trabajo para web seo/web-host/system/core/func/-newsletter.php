<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Aquí albergamos las funciones de la newsletter.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/
 
function verificar_newsletter($email,$conn_t){
	
	if(!empty($email)){
	
		$nuevo_correo = "select email from in_newsletter where email='$email'";
  
		$valida = $conn_t->query($nuevo_correo);
 
		//Como correo es UNIQUE si valida tiene más de un resultado,
 
		//el correo ya estaba en la base de datos
  
		if($valida->num_rows > 0){ 
	
		} else {
		
			$info = '{"tipo":"bien","contenido":"Registrate a nuestra newletter"}';
	
		}
	}
	
	return $info;
}

/* 
** Esta funcion hay que revisarla, hay que aplicar el nuevo sistema de conecion a la base de datos.
*/

function insert_newsletter(){
	
	$email=$_POST['email'];

	if(verificaremail($email)){
	$server_1 = "localhost"; $usuario = "user_general"; $contrasenya = "8bZ6kT!afZl1vxah"; $dbname = "ingrup_es";
 $conn_t = new mysqli($server_1, $usuario, $contrasenya, $dbname);
 
	if($conn_t->connect_error) { $error = "Ha ocurrido un error" ;} 
	$nuevo_correo = "select email from in_newsletter where email='$email'";
  
	$valida = $conn_t->query($nuevo_correo);
 
	//Como correo es UNIQUE si valida tiene más de un resultado,
       
	//el correo ya estaba en la base de datos
        
	if($valida->num_rows > 0)	{
		
		$arrResult = array ('response'=>'error','message'=>'La dirección de email ya existe!');
	
	} else {
		
		$opciones_mail='{"estado":"1","nombre":"","fecha-alta":"'.date("Y-m-d H:i:s").'","fecha-baja":""}';
		$sql = "INSERT INTO in_newsletter (email, opciones) VALUES ('".$email."', '".$opciones_mail."')";

		if($conn_t->query($sql) === TRUE) { $arrResult = array ('response'=>'success'); }  
	}
	
} 
	
	else { 
		
		$arrResult = array ('response'=>'error','message'=>'Dirección de email inválida!'); 

	}
	
	echo json_encode($arrResult);

} 
	


?>