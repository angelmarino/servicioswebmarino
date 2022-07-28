<?php

function dinvaders_upload_image($args,$img_dest) {
	# Extraemos los datos del array
	extract($args, EXTR_SKIP);
	# Le agregamos una id unica para evitar duplicado
	$filename = uniqid(microtime()) . $filename;
	# Con explore() obtenemos la extensión del archivo
	$ext = end(explode('.', $filename));
	# Encryptamos el nombre del archivo con md5() para evitar que el archivo tenga otra extensión y acortamos el nombre con substr()
	$filename = substr(md5($filename), 0, 10);
	# Le devolvemos la extensión al archivo
	$filename = $filename . '.' . $ext;
	# Creamos una variable con la ruta en donde estará alojada la imagen
	$filepath = $_SERVER['DOCUMENT_ROOT'].$img_dest.$filename;

	# Movemos el archivo temporal a donde lo queremos colocar
	move_uploaded_file($tmp_name, $filepath);
	# Le cambiamos los permisos al archivo
	chmod( $filepath , 0644 );
}

if(isset($_POST['subir'])) 
{
	# MIME types permitidos
	$mime = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
	# Buscamos si el archivo que subimos tiene el MIME type que permitimos en nuestra subida
	if(!in_array($_FILES['imagen']['type'],$mime))
	{
		$error = true;
		$msg .= 'Ups! Solamente puedes subir imágenes con la extensión GIF, JPG, JPEG, PJPEG o PNG';
	}
	# Le decimos al usuario que se olvido de subir un archivo
	if( $_FILES['imagen']['type'] == '' )
	{
		$error = true;
	 $msg .= 'Hey -.-, te olvidaste de un pequeño detalle... No subiste ningún archivo!';
	}
	# Indicamos hasta que peso de archivo puede subir el usuario.
/* 	if( $_FILES['imagen']['size'] < 600000 ) 
	{
		$error = true;
		echo $sobrepeso = 'Wow! El archivo que estas subiendo tiene sobrepeso! Bájalo hasta 60kb que es lo máximo que aceptamos :)';
	} */
	# Si el archivo cumple con las expectativas quiere decir que la variable $error viene vacia y se ejecutará la función que colocaremos ahí
	if(empty($error))
	{
		$args = array(
		'filename' => $_FILES['imagen']['name'],
		'tmp_name' => $_FILES['imagen']['tmp_name']
		);
		dinvaders_upload_image($args,'/test/tinymce/img/');
		$msg = 'Todo bien';
	}
	else { $msg = 'Algo va mal';}
}
?>

<!DOCTYPE html>
<html>
<head>
  
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>
   <?php
$carpeta_ficheros = 'img/';
$directorio = opendir($carpeta_ficheros); // Abre la carpeta

while ($fichero = readdir($directorio)) { // Lee cada uno de los ficheros
  
	if (!is_dir($fichero)){ // Omite las carpetas

		?>

 
		
	<img class='fichero' data-src='<?=$carpeta_ficheros.$fichero?>' width="100" class="img" src="<?=$carpeta_ficheros.$fichero?>">
 
<?php	} } ?>

	
	<hr>
	<? echo $msg;?>
	<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
 <label>Sube tu imagen</label><input type="file" name="imagen" />
 <button type="submit" name="subir">¡Súbeme!</button>
</form>
	
	
<script type="text/javascript" language="javascript">
$(document).on("click","img.fichero",function(){
  item_url = $(this).data("src");
  var args = top.tinymce.activeEditor.windowManager.getParams();
  win = (args.window);
  input = (args.input);
  win.document.getElementById(input).value = item_url;
  top.tinymce.activeEditor.windowManager.close();
});
</script>
	
	
</body>
</html>

