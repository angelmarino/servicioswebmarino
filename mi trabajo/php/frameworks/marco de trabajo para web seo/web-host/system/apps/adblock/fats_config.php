<?php

$fats_config = array(

	// Set your own key here. It will be used to generate hash. Alphanumeric only!
	"hashkey" => "mykey", 

	// Absolute path where advertisement.js.php file is. End it with slash.
	"ads-urlpath" => "http://www.mydomain.com/assets/js/",  
	
	// Absolute path where fats_core.php file is. End it with slash.
	"core-urlpath" => "http://www.mydomain.com/",

	// Absolute path where ads.png file is. End it with slash.
	"adspng-urlpath" => "http://www.mydomain.com/assets/image/", 
	
	// Set your random div ID here. It will be used to test adblock functionality. Alphanumeric only!
	"adspng-divid" => "myrandomdiv",  

	// true | false --> Load Adsense detection method. Set to false if you're not using Adsense.
	"adsense-do" => true,  
	
	// true | false --> load jQuery library. Set to false if you already load jQuery.
	"jquery-do" => true,  
	
	// true | false --> (optional) load jQuery UI library. Set to false if you already load jQuery UI. Required for jquery-popup message.
	"jqueryui-do" => true,  

	// true | false --> load jQuery cookie library. Set to false if you already load jQuery cookie.
	"jquerycookie-do" => true,  
	
	// Absolute path where jquery.cookie.js file is. End it with slash.
	"jquerycookie-urlpath" => "http://www.mydomain.com/assets/js/",  

	// true | false --> load default css style. Set to false if you have custom css.
	"css-do" => true,  
  
	// inline | jquery-popup | js-popup --> How the message will be displayed. You will need to load jquery UI for jquery-popup.
	"message-method" => "js-popup",  

	// You can change the effect for jquery-popup box
	// Here are some effects that can be use: slide, size, scale, pulsate, puff, fold, fade, explode, drop, clip, blind, bounce
	"jquery-popup-fadein" => "explode",
	"jquery-popup-fadeout" => "bounce",

	// true | false --> redirect url after showing the message.
	"redirect-do" => true,  
	
	// Your complete redirect url if the redirect-do is set to true.
	"redirect-url" => "http://www.mydomain.com/home.php",  
  
	// Message to show if visitor disable their javascript in their browser. Can have html in it.
	"nojs-warn" => "You will have to enable javascript in your browser to view this content.",
	
	// Message to show if visitor disable their cookie in their browser. Can have html in it.
	"nocookies-warn" => "You will have to enable cookies in your browser to view this content.",

	// Message to show if visitor using AdBlock. Can have html in it.
	// Note: HTML tag will be stripped for js-popup method
	"greet" => "We've detected that you're using AdBlock Plus or some other adblocking software. We need money to operate the site, and almost all of that comes from our online advertising. <br /><br /><strong>Please disable your AdBlock software to view our content.</strong> "

);

?>