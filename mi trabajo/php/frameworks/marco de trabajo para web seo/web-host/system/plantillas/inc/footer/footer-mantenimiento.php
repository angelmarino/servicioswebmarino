<?php if(!defined('BASEPATH')) exit('El acceso no permitido :( ');

header("Cache-Control: must-revalidate");

header("Expires: ".gmdate("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí albergamos la carga del footer.
** Autor: Angel Luis
** Empresa: Nolobrown S.L.
** Proyecto Multisite
*/  
 ?>
 
<footer class="color color-quaternary" id="footer">

	<div class="container">

		<div class="row">

			<div class="col-md-8">

				<h4><?=nombre_empresa?></h4>

				<p><strong><?=l('direccion',pag1,$db_web)?>:</strong> <?=direccion_empresa?></p>

				<hr class="light">

			</div>

			<div class="col-md-3 col-md-offset-1">

				<h5 class="mb-sm"><?=l('telefono',pag1,$db_web)?></h5>

				<span class="phone"><?=telf_empresa?></span> 

				<ul class="list list-icons list-icons-sm">

					<li><i class="fa fa-envelope"></i> <a href="mailto:<?=obfuscate(mail_cliente)?>"><?=obfuscate(mail_cliente)?></a></li>

				</ul>

				<ul class="social-icons">

					<!--li class="social-icons-facebook">
						<a href="http://www.facebook.com/<?=get_socialurl('Facebook')?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
					</li--> 

				</ul>

			</div>

		</div>

	</div>

	<div class="footer-copyright">

		<div class="container">

			<div class="row">
  
				<div class="col-md-12">

					<p>© Copyright 2015. All Rights Reserved. <?=nombre_empresa?></p>

				</div>

			</div>

		</div>

	</div>

</footer>
 
</div> 

<?php init_js(); ?>

</body>
</html>