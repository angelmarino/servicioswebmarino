<?php if(!defined('BASEPATH')) exit('El acceso directo a este archivo no está permitido.');

/*
** Aquí albergamos las funciones de trato con las imagenes web.
** 
** Autor: Angel Luis
**
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
**
*/
 
function mostrarTituloImg($name){
 
	// Sacamos el nombre real de la imagen 
	
	$name = basename($name);
	
	$name = substr($name, 0, -4);
	
	$name = ereg_replace("[0-9]", '', $name);
	
  //Eliminamos los Guinos del Titulo y Agregamos un Espacio en Blanco  
	$guiones2=preg_replace("/-/", " ", $name);  
 
	//Cambiar el Titulo a Miniscula para el Link
 
	$mayusculas=ucwords($guiones2);
 
    //Eliminar los Caracteres Especiales del Titulo.
 
    $titulo=ereg_replace("[^A-Za-z0-9-]", " ", $mayusculas);
 
    echo $titulo;
 
}

/* funcion para cargar imagenes y redimencionarlas */

function redimencionar_img($img_nombre,$img_origen,$img_destino,$ancho_MAX,$alto_MAX){
	
	// Convertimos de png a jpg
	
	function png2jpg($originalFile, $outputFile, $quality) 
	{
		$image = imagecreatefrompng($originalFile);
		imagejpeg($image, $outputFile, $quality);
		imagedestroy($image);
	}
	
	//Ruta de la imagen original 
	
	$rutaImagenOriginal=$img_origen.$img_nombre;
	
	png2jpg($rutaImagenOriginal, $rutaImagenOriginal, 95);
	
	//Creamos una variable imagen a partir de la imagen original
	$img_original = imagecreatefromjpeg($rutaImagenOriginal);
	
	//Se define el maximo ancho o alto que tendra la imagen final
	$max_ancho = $ancho_MAX;
	
	$max_alto = $alto_MAX;
	
	//Ancho y alto de la imagen original
	list($ancho,$alto)=getimagesize($rutaImagenOriginal);
	
	//Se calcula ancho y alto de la imagen final
	$x_ratio = $max_ancho / $ancho;

	$y_ratio = $max_alto / $alto;
	
	//Si el ancho y el alto de la imagen no superan los maximos, 
	//ancho final y alto final son los que tiene actualmente
	if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
	
		$ancho_final = $ancho;
		
		$alto_final = $alto;

	}
	/*
	 * si proporcion horizontal*alto mayor que el alto maximo,
	 * alto final es alto por la proporcion horizontal
	 * es decir, le quitamos al alto, la misma proporcion que 
	 * le quitamos al alto
	 * 
	*/
	elseif (($x_ratio * $alto) < $max_alto){
		
		$alto_final = ceil($x_ratio * $alto);
		
		$ancho_final = $max_ancho;
		
	}
	/*
	 * Igual que antes pero a la inversa
	*/
	else{
		
		$ancho_final = ceil($y_ratio * $ancho);
		
		$alto_final = $max_alto;
		
	}
	
	//Creamos una imagen en blanco de tamaᯠ$ancho_final  por $alto_final .
	$tmp=imagecreatetruecolor($ancho_final,$alto_final);	
	
	//Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
	imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	
	//Se destruye variable $img_original para liberar memoria
	imagedestroy($img_original);
	
	//Definimos la calidad de la imagen final
 
	//Se crea la imagen final en el directorio indicado
	//imagejpeg($tmp,"retoque.jpg",$calidad);
	
	//Definimos la calidad de la imagen final
 $calidad=95;
//Se crea la imagen final en el directorio indicado
	
 imagejpeg($tmp,$img_destino.$img_nombre,$calidad);
	
	return $rutaImagenOriginal;
}


function cargarimagen($ruta_destino,$imagen,$nombre,$ancho,$alto){
	
	$img_magazine = isset($_FILES["fileToUpload"]) ? $_FILES["fileToUpload"] : null ;
 
	if(isset($img_magazine)){ 

		if (file_exists($ruta_destino)){
  
			$name_img = format_uri(html_entity_decode($nombre, ENT_NOQUOTES)).'.jpg';
		
			$target_file = $ruta_destino . $name_img;

			if (file_exists($target_file)) {
   
				echo "Sorry, file already exists.";
    

			} else {
				
				// Check file size

				$valid_formats = array("jpg", "png", "gif", "zip", "bmp");

				$max_file_size = 500000; //100 kb

				$path = "uploads/"; // Upload directory

				$count = 0;
			
				if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	// Loop $_FILES to exeicute all files
	
					foreach ($_FILES['files']['name'] as $f => $name) {     
	    
						if ($_FILES['files']['error'][$f] == 4) {
	        
							continue; // Skip file if any error found
	    
						}	       
	    
						if ($_FILES['files']['error'][$f] == 0) {	           
	        
							if ($_FILES['files']['size'][$f] > $max_file_size) {
	           
								$message[] = "$name is too large!.";
	           
								continue; // Skip large files
	       
							}
			
							elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
			
								$message[] = "$name is not a valid format";
				
								continue; // Skip invalid file formats
			
							}	else{ // No error found! Move uploaded files 
	           
								if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name))
	            
									$count++; // Number of successfully uploaded file
	       
							}
	    }
	}
				
				
}
    
			if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			{
				$url_img_dest='https://img.ingrup.es/magazine/'.$name_img;
				
				$img_nombre = $name_img;
				$img_origen = './img/magazine/';
				$img_destino = './img/magazine/dest/';
				
				redimencionar_img($img_nombre,$img_origen,$img_destino,'333','237');
					   
				$img_dest=$img_nombre;
				
			} else {
       
				 $url_img_dest='https://img.ingrup.es/not_found.png';
   
			}

				
				
			}
		
		} else {
			
			echo "El fichero $target_file no existe";

		}
	
	}

}


?>