<?php if(!defined('BASEPATH')) exit('El acceso no permitido :( ');

header("Cache-Control: must-revalidate");
header("Expires: ".gmdate("D, d M Y H:i:s", time() + 60*60*24*3)." GMT");

/*
** Aquí albergamos la configuración del sitio web que se va a cargar.
** Autor: Angel Luis
** Empresa: Nolobrown S.L.
** Proyecto Multisite
**
*/ 

function load_analytics($web_id){ ?>
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//<?=url_analytics?>/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?=$web_id?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//<?=url_analytics?>/piwik.php?idsite=<?=$web_id?>" style="border:0;" alt="" /></p></noscript> 
<?php } ?>