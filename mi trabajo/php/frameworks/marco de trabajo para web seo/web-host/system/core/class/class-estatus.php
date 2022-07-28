<?php  if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/*
** Aquí albergamos las funciones genéricas web. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/
 
class maxProtector
{
	var $password=mantenimiento_pass;
	
    function showLoginForm()
		{  
			load_header('mantenimiento', '');  
			load_main('mantenimiento', ''); 
			load_footer('mantenimiento', '');  
		}

    function login() {
					
			$loggedin = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        
			if((!isset($_POST['submitBtn'])) && (!($loggedin)))
			{
				$_SESSION['loggedin'] = false;
				$this->showLoginForm();
				exit();
			} 
			
			else if (isset($_POST['submitBtn'])) 
			{
				$pass = isset($_POST['passwd']) ? $_POST['passwd'] : '';
      
				if ($pass != $this->password) 
				{
					$_SESSION['loggedin'] = false;
					$this->showLoginForm();
					exit();     
				}  else  {
					$_SESSION['loggedin'] = true;
												
				}
       
			}
			
		}
}

 
?>