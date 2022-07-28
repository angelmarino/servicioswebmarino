<?php if(!defined('BASEPATH')) exit('El acceso no permitido :( ');

header("Cache-Control: must-revalidate");

header("Expires: ".gmdate ("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");
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
?>

<div role="main" class="main">

	<div class="container">

		<div class="row">

			<div class="col-md-12 center">

				<div class="logo">

					<a href="/<?=pag1?>/inicio.html">

						<img src="<?=host_img.logotipo_header?>" alt="<?=nombre_empresa?>">

					</a>

				</div>

			</div>

		</div>

		<div class="row">

			<div class="col-md-12">

				<hr class="tall">

			</div>

		</div>

		<div class="row">

			<div class="col-md-12 center">

				<h1 class="mb-sm small"><?=l('avisoconstruccion',pag1,$db_web)?></h1>

				<p class="mb-none lead">  </p>

			</div>

		</div>

		<div class="row">

			<div class="col-md-12">

				<hr class="tall">

			</div>

		</div>

		<div class="row">

			<div class="col-md-6 col-md-offset-3">

				<div class="progress-bars">

					<div class="progress-label">

						<span>
							
							<strong>Desarrollo:</strong> 
							
							<span class="label label-success"><?=status_project?></span>
							
						</span>

					</div>
					
					<hr>

					<div class="progress">

						<div class="progress-bar progress-bar-primary" data-appear-progress-animation="<?=progress_project?>%">

							<span class="progress-bar-tooltip"><?=progress_project?>%</span>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="row">

			<div class="col-md-12">

				<hr class="tall">

			</div>

		</div>

		<div class="row">

			<div class="col-md-6 col-md-offset-3">

				<form class="iphorm" action="<?php echo url_actual();?>" method="post" enctype="multipart/form-data">

					<div class="row">

						<div class="center">

							<div class="col-md-6">

								<input class="form-control " name="passwd" type="password" placeholder="Clave de acceso"/> 

							</div>

							<div class="col-md-6">

								<input name="submitBtn" class="btn btn-primary" type="submit" value="Entrar" />

							</div>

						</div>

					</div>

				</form>

			</div>

		</div>

	</div>

</div>

