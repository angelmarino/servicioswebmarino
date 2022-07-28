<?php if(!defined('BASEPATH')) exit('Acceso no permitido :( '); 

/* 
** Aquí albergamos la carga del footer.
** 
** Autor: Angel Luis
** 
** Empresa: Nolobrown S.L.
** 
** Proyecto Multisite
** 
*/ 
global $db_gest_in;
global $detect;
global $db_web; 

?>

<div role="main" class="main">
	
	<section class="page-header page-header-light page-header-reverse page-header-more-padding section-tertiary">

		<div class="container">

			<div class="row">

				<div class="col-md-12">

					<ul class="breadcrumb breadcrumb-valign-mid">

						<li><a href="<?=httpdominio?>"><?=l('menu-1-1',pag1,$db_web)?></a></li>

						<li class="active"><?=l('aviso404',pag1,$db_web)?></li>

					</ul>
				
				</div>

			</div>

		</div>

	</section>
	
	<div class="container">

		<section class="page-not-found">
	
			<div class="row">
	
				<div class="col-md-6 col-md-offset-1">
	
					<div class="page-not-found-main">
	
						<h2>404 <i class="fa fa-file"></i></h2>
	
						<p><?=l('aviso404',pag1,$db_web)?></p>
	
					</div>
	
				</div>
	
				<div class="col-md-4">
	
					<p>
	
						<?=l('aviso404text',pag1,$db_web)?> :(
	
					</p>
	
				</div>
	
			</div>
	
		</section>

	</div>

</div>