<?php include "fats_core.php"; ?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="utf-8" http-equiv="encoding" />
<title>FAtS - Force AdBlock to Stop: Hide your content if visitor using AdBlock</title>
<style>
#container{	margin: 0 auto;	width: 900px;	background:#fff; }
#content{	clear: left; padding: 20px; text-align:left;}
#content p{	padding:10px;}
</style>
<?php write_JS($fats_config ); ?>
</head>
<body>
<div id="container">
  <div id="content">
    <h1>My Content</h1>
    <p>This is my public content</p>
    
<?php if (is_Unlocked($fats_config)){ // START HIDDEN CONTENT ?>

    <p style="background-color:#C7F039;">This is my premium content.</p>

<?php } ///////////////////////////// STOP HIDDEN CONTENT ?>
  
	<div id="container" style="text-align:center;margin:10px">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-9379858969119884";
		google_ad_slot = "9452050909";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript"
		src="//pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>

    <p>This is another public content.</p>
  </div>
</div>
</body>
</html>