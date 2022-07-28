<?php
/////////////////////////////////
//// http://mikir.in/code    ////
//// hardhikaputra@gmail.com ////
/////////////////////////////////

include "fats_config.php";


function get_URL(){
	$URL = 'http';
	if (isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"] == "on" ) ) {
		$URL = $URL . "s";
	}
	$URL = $URL . "://";

	if ($_SERVER["SERVER_PORT"] != "80") {
		$URL = $URL . $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$URL = $URL . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $URL;
}	
	
	
function str2hex($string)  {
	$string = str_split($string);
	foreach($string as &$char){
		$char = "\x".dechex(ord($char));
	}
	return implode('',$string);
}	

  
function write_CSS($show=true){
	if ($show){
		echo '<style>';
		echo '#box-lock { overflow: auto; background-color: #CC181E; color: #FFFFFF; border: 1px dashed; text-align:center; padding:5px; width:90%; margin: 10px auto; position: relative; }';
		echo '#box-lock-popup { overflow: auto; text-align:center; padding:5px; width:90%; margin: 10px auto; position: relative; }';
		echo '#box-lock-jquery { font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; font-size: small; }';
		echo '#box-text { font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; }';
		echo '#box-warn-cookies { font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; }';
		echo '#box-warn-js { font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; }';
		echo '</style>';
	}
}
  	
  	
function write_JS($fats_config ){
  $greet = strip_tags (str_replace('"', "\"", str_replace("'", "\'", $fats_config['greet'])));

	if($fats_config['adsense-do']){
		$adsense = "&&((window.google_unique_id!=undefined)||(window.adsbygoogle!=undefined))";
	}else{
		$adsense = "";
	}

	if (!is_Unlocked($fats_config, false)){
		if ($fats_config['jquery-do']){
			echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>'; 
		}    
		if ($fats_config['jqueryui-do']){ 
			echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>'; 
			echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">';
		}    
		if ($fats_config['jquerycookie-do']){ 
			echo '<script type="text/javascript" src="' . $fats_config['jquerycookie-urlpath'] . 'jquery.cookie.js"></script>'; 
		}    
		echo '<script type="text/javascript">var ' . $fats_config['keyvar'] . ' = false;</script>';    
		echo '<script type="text/javascript" src="' . $fats_config['ads-urlpath'] . 'advertisement.js.php?xfatsid=' . $fats_config['keyvar'] . '"></script>';    
		echo '<script type="text/javascript">$( document ).ready(function() {if ($.cookie("'. $fats_config['keyvar2'] .'")) { if(('. $fats_config['keyvar'] .')&&($("#' . $fats_config['adspng-divid'] . '").height() > 0)' . $adsense . '){jQuery.post("' . str2hex($fats_config['core-urlpath'] . "fats_core.php") . '",{fatsid:"' . write_ID() . '"},function(data){location.reload();});}else{ '; 
		if ($fats_config['message-method']=='jquery-popup'){ 
			echo '$("#box-lock-jquery").dialog({autoOpen:true,modal:true,show:{effect:"' . $fats_config['jquery-popup-fadein'] . '",duration:1000},hide:{effect: "' . $fats_config['jquery-popup-fadeout'] . '",duration: 1000}';
			if ($fats_config['redirect-do']){
				echo ',close: function(event, ui) { window.location.replace("' . str2hex($fats_config['redirect-url']) . '") }';
			}
			echo '});'; 
		} 
		if ($fats_config['message-method']=='js-popup'){ 
			echo 'alert("' . $greet . '");'; 
			if ($fats_config['redirect-do']){
				echo 'window.location.replace("' . str2hex($fats_config['redirect-url']) . '");';
			}
		} 
		if (($fats_config['message-method']=='inline')AND($fats_config['redirect-do'])){ 
			echo 'setTimeout("window.location.replace(\'' . str2hex($fats_config['redirect-url']) . '\');",5000);';
		}
		echo'}} });</script>';      
		write_CSS($fats_config['css-do']);	   
	}

}  

  
  
function write_Box($fats_config){
  if ($fats_config['message-method']=='inline') {
    $greet = str_replace('"', "&#34;", str_replace("'", "&#39;", $fats_config['greet']));
    $boxid = "";
  } else {
    if ($fats_config['message-method']=='jquery-popup'){
      $greet_popup = str_replace('"', "&#34;", str_replace("'", "&#39;", $fats_config['greet']));
    }
    $boxid = "-popup";  
    $greet = "";
  }
  $warnjs = str_replace('"', "&#34;", str_replace("'", "&#39;", $fats_config['nojs-warn']));
  $warncook = str_replace('"', "&#34;", str_replace("'", "&#39;", $fats_config['nocookies-warn']));
	echo '<div id="box-lock' . $boxid . '" ><noscript><span id="box-warn-js">' . $warnjs . '</span><br /></noscript><script>if ($.cookie(\''. $fats_config['keyvar2'] . '\')){document.write(\'<span id="box-text">' . $greet . '</span>\');}else{document.write(\'<span id="box-warn-cookies">' . $warncook . '</span><br />\');}</script><div id="' . $fats_config['adspng-divid'] . '"><img src="' . $fats_config['adspng-urlpath'] . 'ads.png" /></div></div>';
  if ($fats_config['message-method']=='jquery-popup'){
    echo '<div id="box-lock-jquery" title="Adblock Detected" style="display: none;"><p>' . $greet_popup . '</p></div>';
  }
}


function write_ID(){
	return str_rot13(urlencode(get_URL()));
}


function write_Key($fats_config, $url=""){
  $urlhash = sha1($fats_config['hashkey'] . $url);
	setcookie($urlhash, uniqid(), time() + 1, '/');
}


function get_Key($fats_config, $url=""){
	return sha1($fats_config['hashkey'] . $url);
}


function is_Unlocked($fats_config, $auto=true){  
	$urlhash = sha1($fats_config['hashkey'] . get_URL());
	if (isset($_COOKIE[$urlhash])){
		return true;
	} else {
		if ($auto){
			write_Box($fats_config);
		}
		return false;
	}  
}
  
  
$fats_config['keyvar'] = 'x'.md5(strtotime('now'));  
$fats_config['keyvar2'] = 'c'.md5(strtotime('now'));  
setcookie($fats_config['keyvar2'], true, time() + 5, '/');
if (isset($_POST['fatsid'])){
	$id = $_POST['fatsid'];
	$url = urldecode(str_rot13($id));
	$hash = get_Key($fats_config, $url);
	write_Key($fats_config, $url);    
	unset($_POST['fatsid']);
}

?>