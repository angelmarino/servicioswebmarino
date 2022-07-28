<?php if (!defined('BASEPATH')) exit('Acceso no permitido.'); 

/* 
** Aquí albergamos la carga del footer. 
** Autor: Angel Luis 
** Empresa: Nolobrown S.L. 
** Proyecto Multisite 
*/

function load_formulario($tipo='norm'){
	
	global $db_gest_in;
	global $db_web;
	global $db_servicios;
 
?>

<div class="alert alert-success hidden" id="contactSuccess">
	
	<b>¡Bravo! </b> <?=l('send_mensaje',pag1,$db_web)?>

</div>

<div class="alert alert-danger hidden" id="contactError">
	
	<b>Error! </b> <?=l('send_mensaje_error',pag1,$db_web)?>
						
</div>
 
<form id="contactForm" action="/?load=envia.form" method="POST">

	<div class="form-group">

		<div class="col-md-6">

			<label><?=l('nombre',pag1,$db_web)?> *</label>

			<input type="text" value="" data-msg-required="<?=l('required_nombre',pag1,$db_web)?>" maxlength="100" class="form-control" name="nombre" id="nombre" required>

		</div>

		<div class="col-md-6">

			<label>Email *</label> 
			<input type="email" value="" data-msg-required="<?=l('required_email_o',pag1,$db_web)?>" data-msg-email="<?=l('required_email',pag1,$db_web)?>" maxlength="100" class="form-control" name="email" id="email" required>

		</div>

	</div>

	<div class="form-group">

		<div class="col-md-6"> 
			
			<label><?=l('telefono',pag1,$db_web)?> *</label> 
			
			<input type="text" value="" name="telefono" id="telefono" data-msg-required="<?=l('required_telefono',pag1,$db_web)?>" data-plugin-masked-input data-input-mask="999 999-999" placeholder="600 000-000" class="form-control" required>
	
		</div> 
	
		<div class="col-md-6">
    
			<label><?=l('menu_1_4',pag1,$db_web)?></label>
		
			<select data-msg-required="<?=l('required_servicios',pag1,$db_web)?>" class="form-control populate" name="servicio" id="servicio" required>
					
				<option value=""> <?=l('seleccioneunservicio',pag1,$db_web)?></option>
		
				<?php  foreach($db_servicios[1] as $dbservicios){
		
	 $dbserviciosnombre = explode('|',$dbservicios['task_name']);
	  
				?> 
				
				<option value="<?=$dbserviciosnombre[0]?>"> <?=$dbserviciosnombre[0]?> 	</option>
			
				<?php }  ?>
				
				<option value="<?=l('otrosservicios',pag1,$db_web)?>"> <?=l('otrosservicios',pag1,$db_web)?>	</option> 
		
			</select>
		
		</div>
 

	</div>
	
	<div class="form-group">

		<div class="col-md-12">

			<label><?=l('mensaje',pag1,$db_web)?> *</label>
 
			<textarea maxlength="1000" data-msg-required="<?=l('required_mensaje',pag1,$db_web)?>." rows="3" class="form-control" name="mensaje" id="mensaje" required="" aria-required="true" data-plugin-maxlength ></textarea>
	
		</div>

	</div>
  
	<hr class="short">

	<div class="col-md-12"> 

		<input type="submit" value="<?=l('enviarsolicitud',pag1,$db_web);?>" class="btn btn-borders btn-secondary mr-xs mb-sm" data-loading-text="<?=l('enviando',pag1,$db_web)?>...">

	</div>

</form>
 
<hr class="short">

<?php } 

function load_presupuesto_modal(){
	
	global $db_web; 

?>

<div class="modal-dialog">
	
	<div class="modal-content">
		
		<div class="modal-header">
			
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			 
			<br>
			
		</div>
		
		<div class="modal-body">
			
			<?php load_formulario(); ?>
			
			<br>
	
		</div>
		
		<div class="modal-footer">
			
			<button type="button" class="btn btn-default" data-dismiss="modal"><?=l('cerrarv',pag1,$db_web);?></button> 
		
		</div>
		
	</div>
	
</div> 

<?php } 

?> 