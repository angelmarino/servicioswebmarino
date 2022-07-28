<?php 
header('Content-type: text/javascript'); 
if(isset($_GET['xfatsid'])){
	echo htmlEntities($_GET['xfatsid'], ENT_QUOTES) . ' = true;';
} else {
	echo 'x'.md5(strtotime('now')) . ' = false;';
}
?>