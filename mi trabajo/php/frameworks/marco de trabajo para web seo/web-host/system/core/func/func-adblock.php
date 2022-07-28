<?php  
if(!defined('BASEPATH')) exit('El acceso no permitido :( '); 
header("Cache-Control: must-revalidate"); 
header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");




?>