<?php

/*
**Función de extracción de archvivos comprimidos.
*/

function zip_descompress($ubicacion, $destino){
	
	$zip = new ZipArchive;

	if($zip->open($ubicacion) === TRUE) {
    
		$zip->extractTo($destino);
		$zip->close();
		$resultado = true;
	
	} else {
		/* Damos false */
		$resultado= false;
	}
	
	return $resultado;
}

?>