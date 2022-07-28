<?php 
session_start();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Configure Script Settings Below ///////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 1. Set usernames and passwords.
//////////////////////////////////

	$users = array(
	
  	//"admin1" => "pass1", //Remove the // at the beginning of this line to add another user.
 	"admin" => "pass" //Default username and password to login to the script. I recommend changing this to something more secure.
	
	);
	

// 2. Set allowed file types
//////////////////////////////////

	$allowed_extensions = array(
	
		//Allowed archive types: 	
		"gzip", "rar", "tar", "zip",
		
		////Allowed audio file types:
		"midi", "mp3", "mpg", "wmv", 
		
		//Allowed document types:
		"doc", "pdf", "text", "txt",
		
		//Allowed image types:
		"bmp", "gif", "jpg", "jpeg", "png",
		
		//Allowed video types:
		"avi", "flv", "mov", "swf"

	);
	global $allowed_extensions; //DO NOT EDIT THIS LINE!


// 3. Delete script checked by default.
///////////////////////////////////////

	/**
	
	Deleting this script is very important as it is very powerful if accessed by the wrong person.
	 
	By default, this script will always be set to be deleted, but if you set the variable from 1 to 0,
	then the script will remain on the server until you have marked the script for deletion. This is
	very useful if you are constantly using this script repeatedly.

	 */

	$delete_this_script = 1; //Set to 0 to uncheck by default.

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DO NOT EDIT BELOW UNLESS YOU ARE EXPERIENCED WITH PHP! YOU HAVE BEEN WARNED!///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
//If the username isn't set or user is logging out.
if (!$_SESSION['username'] or isset($_GET['logout'])){

//If the user is logging out.
if(isset($_GET['logout'])) {
    $_SESSION['username'] = ''; //Clear the user's session, which will in turn activate the login area.
    header('Location:  ' . $_SERVER['PHP_SELF']); //Reload the scripts page.
}

if(isset($_POST['username'])) { //If login information is correct.
	if($users[$_POST['username']] !== NULL && $users[$_POST['username']] == $_POST['password']) {
  	$_SESSION['username'] = $_POST['username'];
  	header('Location:  ' . $_SERVER['PHP_SELF']); //Reload the scripts page.
    }else { //If login information is incorrect.
		if ($_POST['username'] == ''){ //If username is blank.
			$login_error = '<div class="error_message">User Cannot Be Blank, Please Try Again!</div>';
		} else if ($_POST['password'] == '') { //If password is blank.
			$login_error = '<div class="error_message">Password Cannot Be Blank, Please Try Again!</div>';
		} else { //If username or password is incorrect.
  			$login_error = '<div class="error_message">Invalid Login, Please Try Again!</div>';
		}
    }
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Remote File Uploader &amp; .ZIP Unpacker</title>
<script type="text/javascript">
function showIcon() {
window.setTimeout('showProgress()', 0);
}
function showProgress() {
document.getElementById('progress').style.display = 'inline';
}

var condition_separator = " AND ";
var possibility_separator = " OR ";
var name_value_separator = " BEING ";
var depends = "DEPENDS ON ";
var conflicts = "CONFLICTS WITH ";
var empty = "EMPTY";

function addEvent(el, ev, f) {
  if(el.addEventListener)
    el.addEventListener(ev, f, false);
  else if(el.attachEvent) {
    var t = function() {
      f.apply(el);
    };
    addEvent.events.push({'element': el, 'event': ev, 'handler': f});
    el.attachEvent("on" + ev, t);
  } else
    el['on' + ev] = f;
}

function addEvents(els, evs, f) {
  for(var i = 0; i < els.length; ++i)
    for(var j = 0; j < evs.length; ++j)
      addEvent(els[i], evs[j], f);
}

addEvent.events = [];

if(typeof window.event !== "undefined")
  addEvent(window, "unload", function() {
      for(var i = 0, e = addEvent.events; i < e.length; ++i)
        e[i].element.detachEvent("on" + e[i].event, e[i].handler);
    }
  );

function getRadioValue(el) {
  if(!el.length) return null;
  for(var i = 0; i < el.length; ++i)
    if(el[i].checked) return el[i].value;
  return null;
}

function getSelectValue(el) {
  if(!el.tagName  || el.tagName.toLowerCase() !== "select")
    return null;
  return el.options[el.selectedIndex].value;
}

function isElementValue(el, v) {
  if(v === empty) v = '';
  return (
    getRadioValue(el) == v ||
    getSelectValue(el) == v ||
    (
      el.tagName &&
      el.tagName.toLowerCase() !== "select" &&
      el.value == v
    )
  );
}

function setupDependencies() {
  var showEl = function() {
    this.style.display = "";
    if(this.parentNode.tagName.toLowerCase() == "label")
      this.parentNode.style.display = "";
  };
  var hideEl = function() {
    this.style.display = "none";
    if(typeof this.checked !== "undefined") this.checked = false;
    else this.value = "";
    if(this.parentNode.tagName.toLowerCase() == "label")
      this.parentNode.style.display = "none";
    this.hidden = true;
  };
  var calcDeps = function() {
    for(var i = 0, e = this.elements; i < e.length; ++i) {
      e[i].hidden = false;
      for(var j = 0, f = e[i].className.split(condition_separator); j < f.length; ++j)
        if(f[j].indexOf(depends) === 0) {
          for(var k = 0, g = f[j].substr(depends.length).split(possibility_separator); k < g.length; ++k)
            if(g[k].indexOf(name_value_separator) === -1) {
	      if(e[g[k]] && e[g[k]].checked) break;
            else if(k + 1 == g.length)
                e[i].hide();
            } else {
              var n = g[k].split(name_value_separator),
                v = n[1];
              n = n[0];
	      if(e[n])
	        if(isElementValue(e[n], v)) break;
	        else if(k + 1 == g.length) e[i].hide();
	    }
        } else if(f[j].indexOf(conflicts) === 0) {
          if(f[j].indexOf(name_value_separator) === -1) {
	    if(e[f[j].substr(conflicts.length)] && e[f[j].substr(conflicts.length)].checked) {
              e[i].hide();
              break;
            }
          } else {
            var n = f[j].substr(conflicts.length).split(name_value_separator),
              v = n[1];
            n = n[0];
            if(e[n]) {
              if(isElementValue(e[n], v)) {
                e[i].hide();
                break;
              }
            }
          }
        }
      if(!e[i].hidden) e[i].show();
    }
  };
  var changeHandler = function() {
    this.form.calculateDependencies();
    return true;
  };
  for(var i = 0; i < arguments.length; ++i) {
    for(var j = 0, e = window.document.forms[arguments[i]].elements; j < e.length; ++j) {
      addEvents([e[j]], ["change", "keyup", "focus", "click", "keydown"], changeHandler);
      e[j].hide = hideEl;
      e[j].show = showEl;
    }

    (e = window.document.forms[arguments[i]]).calculateDependencies = calcDeps;
    e.calculateDependencies();
  }
}

window.onload = function() {
	setupDependencies('upload');
};
</script>
<style type="text/css">
.maincontainer { width:500px; margin-left:auto; margin-right:auto; }
.logincontainer { width:500px; margin-left:auto; margin-right:auto; }
h1 { text-align:center; font-size: 24px; color: #333; text-shadow: 2px 2px 4px black; }
input { margin: 0; padding: 5px; color: #666; background: #f5f5f5; border: 1px solid #ccc; margin: 3px 0; font:1em "Lucida Grande", "Lucida Sans Unicode", Arial, sans-serif; -moz-border-radius: 5px; -webkit-border-radius:5px; }
input:focus { border: 1px solid #999; background-color: #fff; color:#333; }
input.submit { cursor: pointer; border: 1px solid #222; background:#333; color:#fff; -moz-border-radius: 5px; -webkit-border-radius:5px; }
hr { color: inherit; height: 0; margin: 6px 0 6px 0; padding: 0; border: 1px solid #d9d9d9; border-style: none none solid; }
.error_message { display: block; height: 22px; line-height: 22px; background: #FBE3E4; padding: 3px 3px 3px 3px; margin: 10px 0; color:#8a1f11;border: 1px solid #FBC2C4; -moz-border-radius: 5px; -webkit-border-radius:5px; }
.success_message { display: block; height: 22px; line-height: 22px; background: #0F0; padding: 3px 3px 3px 3px; margin: 10px 0; color:#060; border: 1px solid #0C0; -moz-border-radius: 5px; -webkit-border-radius:5px; }
.warning { color:#F00; font-weight:bold; text-align:center; margin-left:auto; margin-right:auto; display:inline; }
.user { text-align:right; font-weight:bold; }
.copyright { text-align:center; font-weight:bold; margin-left:auto; margin-right:auto; }
</style>
</head>

<body>
<!-- User Authentication Area Start -->
<?php if (!$_SESSION['username']){ ?>
<div class="logincontainer">
<h1>Remote File Uploader &amp; .ZIP Unpacker</h1>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
  <br /><b>For Server Security Purposes, You Are Required To Login:</b>
  <?php if ($login_error != ''){ echo $login_error; } ?>
  <hr />
  <p><label>Username: <input type="text" id="username" name="username" value="<?=$username?>" /></label></p>
  <p><label>Password: <input type="password" id="password" name="password" value="<?=$password?>" /></label></p>
  <hr />
  <p><input type="submit" name="submit" value="Login" class="button"/></p>
</form>

</div>
<?php exit; } ?>
<!-- User Authentication Area End -->

<?php
//Set Error and Success Variables
	$error 		= '';
	$success 	= '';


//Remote Upload Process
//*****************************************************
if(isset($_POST['upload']) && !empty($_POST['link'])) {

	$url 				= 	trim($_POST['link'], " ");
	$filename			=	basename($url);
	$extension_check	=	pathinfo($url);
	
	if (!in_array($extension_check['extension'], $allowed_extensions)) {
		$error = '<div class="error_message">Attention! Must be a valid file format!</div>';
	} elseif (file_exists($filename) && !isset($_POST['overwrite'])) {
		$error = '<div class="error_message">Attention! File already exists!</div>';
	} else {
		define('BUFSIZ', 4095); //How much server memory will be used.
		$rfile = fopen($url, 'r');
		$lfile = fopen($filename, 'w');
		while(!feof($rfile))
		fwrite($lfile, fread($rfile, BUFSIZ), BUFSIZ);
		fclose($rfile);
		fclose($lfile);

		//Unzip Process
		if (isset($_POST['unzip']) && $extension_check['extension'] == "zip") {
		function unzip($file){
    		$zip=zip_open(realpath(".")."/".$file);
    		if(!$zip) {return("Unable to proccess file '{$file}'");}
    		$e='';
			while($zip_entry=zip_read($zip)) {
       			$zdir=dirname(zip_entry_name($zip_entry));
       			$zname=zip_entry_name($zip_entry);
       			if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
       			if(!is_dir($zdir)) mkdirr($zdir,0777);
       			#print "{$zdir} | {$zname} \n";
       			$zip_fs=zip_entry_filesize($zip_entry);
       			if(empty($zip_fs)) continue;
       			$zz=zip_entry_read($zip_entry,$zip_fs);
       			$z=fopen($zname,"w");
       			fwrite($z,$zz);
       			fclose($z);
       			zip_entry_close($zip_entry);
    		}
    		zip_close($zip);
    		return($e);
		}

		function mkdirr($pn,$mode=null) {
  			if(is_dir($pn)||empty($pn)) return true;
  			$pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);
  			if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}
  			$next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
  			if(mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
  			return false;
		}

		unzip("$filename");
		}
	
		//Delete .ZIP Process
		if(isset($_POST['delete_archive']) && $extension_check['extension'] == "zip") {
			unlink("$filename");
		}

		//Finished
		$success = "<div class=\"success_message\">Process Completed Succesfully! <a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME'])."/\" target=\"_blank\">View Directory</a></div>";
		}
}

//Direct Upload Process
//**********************************************************************
if(isset($_POST['upload']) && !empty($_FILES['direct_upload']['name'])) {

	$url				=	$_FILES['direct_upload']['name'];
	$filename			=	basename($url);
	$extension_check	=	pathinfo($url);

	if (!in_array($extension_check['extension'], $allowed_extensions)) {
		$error = '<div class="error_message">Attention! Must be a valid file format!</div>';
	} elseif (file_exists($filename) && !isset($_POST['overwrite'])) {
		$error = '<div class="error_message">Attention! File already exists!</div>';
	} else {
	
		//Move Uploaded File To Directory
		move_uploaded_file($_FILES["direct_upload"]["tmp_name"], $filename);
 

		//Unzip Process
		if (isset($_POST['unzip']) && $extension_check['extension'] == "zip") {
		
		function unzip($file){
    		$zip=zip_open(realpath(".")."/".$file);
    		if(!$zip) {return("Unable to proccess file '{$file}'");}
    		$e='';
			while($zip_entry=zip_read($zip)) {
       			$zdir=dirname(zip_entry_name($zip_entry));
       			$zname=zip_entry_name($zip_entry);
       			if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
       			if(!is_dir($zdir)) mkdirr($zdir,0777);
       			#print "{$zdir} | {$zname} \n";
       			$zip_fs=zip_entry_filesize($zip_entry);
       			if(empty($zip_fs)) continue;
       			$zz=zip_entry_read($zip_entry,$zip_fs);
       			$z=fopen($zname,"w");
       			fwrite($z,$zz);
       			fclose($z);
       			zip_entry_close($zip_entry);
    		}
    		zip_close($zip);
    		return($e);
		}

		function mkdirr($pn,$mode=null) {
  			if(is_dir($pn)||empty($pn)) return true;
  			$pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);
  			if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}
  			$next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
  			if(mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
  			return false;
		}

		unzip("$filename");
		}
	
		//Delete .ZIP Process
		if(isset($_POST['delete_archive']) && $extension_check['extension'] == "zip") {
			unlink("$filename");
		}

		//Finished
		$success = "<div class=\"success_message\">Process Completed Succesfully! <a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME'])."/\" target=\"_blank\">View Directory</a></div>";
		}
}


//Just Unzip Process
//*****************************************************
if(isset($_POST['upload']) && !empty($_POST['only_unzip'])) {

	$url 				= 	$_POST['only_unzip'];
	$filename			=	basename($url);
	$extension_check	=	pathinfo($url);
	
	if ($extension_check['extension'] != "zip") {
		$error = '<div class="error_message">Attention! Must be .zip archive!</div>';
	//} elseif (file_exists($filename) && !isset($_POST['overwrite'])) {
		//$error = '<div class="error_message">Attention! File already exists!</div>';
	} else {

		//Unzip Process
		if (isset($_POST['unzip']) && $extension_check['extension'] == "zip") {
		
		function unzip($file){
    		$zip=zip_open(realpath(".")."/".$file);
    		if(!$zip) {return("Unable to proccess file '{$file}'");}
    		$e='';
			while($zip_entry=zip_read($zip)) {
       			$zdir=dirname(zip_entry_name($zip_entry));
       			$zname=zip_entry_name($zip_entry);
       			if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
       			if(!is_dir($zdir)) mkdirr($zdir,0777);
       			#print "{$zdir} | {$zname} \n";
       			$zip_fs=zip_entry_filesize($zip_entry);
       			if(empty($zip_fs)) continue;
       			$zz=zip_entry_read($zip_entry,$zip_fs);
       			$z=fopen($zname,"w");
       			fwrite($z,$zz);
       			fclose($z);
       			zip_entry_close($zip_entry);
    		}
    		zip_close($zip);
    		return($e);
		}

		function mkdirr($pn,$mode=null) {
  			if(is_dir($pn)||empty($pn)) return true;
  			$pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);
  			if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}
  			$next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
  			if(mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
  			return false;
		}

		unzip("$filename");
		}
	
		//Delete .ZIP Process
		if(isset($_POST['delete_archive']) && $extension_check['extension'] == "zip") {
			unlink("$filename");
		}

		//Finished
		$success = "<div class=\"success_message\">Process Completed Succesfully! <a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME'])."/\" target=\"_blank\">View Directory</a></div>";
		}
}

//*************************************************************************************************************************************************
//*************************************************************************************************************************************************

//If No Variables Are Set
if(isset($_POST['upload']) && empty($_POST['link']) && empty($_FILES['direct_upload']['name']) && empty($_POST['only_unzip'])) {
	$error = '<div class="error_message">Attention! Nothing to Upload!</div>';
}

//*************************************************************************************************************************************************
//*************************************************************************************************************************************************

//Main Script
if(!isset($_POST['upload']) || $error != '' || $success != '') {
?>
<div class="maincontainer">
<h1>Remote File Uploader &amp; .ZIP Unpacker</h1>
<?php echo $error; echo $success; ?>

<!-- Remote .ZIP Uploader/Unzipper Form Start -->
<form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" id="upload" name="upload" method="post" >

<!-- Step 1: Select Upload Type -->
<hr />
<b><u>Step 1: Select Upload Type:</u></b><br /><br />
<label>Remote Upload: <input type="checkbox" name="remote_upload_check" value="<?=$remote_upload;?>" id="remote_upload_select" onclick="document.getElementById('direct_upload_select').checked=false;document.getElementById('only_unzip_select').checked=false;document.getElementById('unzip').checked=false;document.getElementById('overwrite').checked=true;" checked /></label>
<label>&nbsp;&nbsp;Direct Upload: <input type="checkbox" name="direct_upload_check" value="<?=$direct_upload;?>" id="direct_upload_select" onclick="document.getElementById('remote_upload_select').checked=false;document.getElementById('only_unzip_select').checked=false;document.getElementById('unzip').checked=false;document.getElementById('overwrite').checked=true;" /></label>
<label>&nbsp;&nbsp;Only Unzip .zip: <input type="checkbox" name="only_unzip_check" value="<?=$only_unzip;?>" id="only_unzip_select" onclick="document.getElementById('remote_upload_select').checked=false;document.getElementById('direct_upload_select').checked=false;document.getElementById('unzip').checked=true;" /></label>
<br /><br />

<!-- Step 2: Link To File or Directly Upload -->
<hr />
<label><b><u>Step 2: Link To File:</u></b> (Example: <i>http://yoursite.com/yourfile.zip</i>)<br /><br />
<input type="text" name="link" size="60" value="" onblur="if (this.value == '') this.value = this.defaultValue" onfocus="if (this.value == this.defaultValue) this.value = ''" class="DEPENDS ON remote_upload_check" /><br /><div class="warning">*Note</div>&nbsp;- <b>http://</b> <u>MUST</u> be included in link!</label>
<label><b><u>Step 2: Direct Upload:</u></b> (Upload directly from your computer)<br /><br />
<input name="direct_upload" type="file" size="45" class="DEPENDS ON direct_upload_check" /></label>

<label><b><u>Step 2: Select .zip Archive:</u></b><br /><br />
<select size="5" name="only_unzip" class="DEPENDS ON only_unzip_check">
<?PHP
if ($script_directory = opendir(realpath(".").DIRECTORY_SEPARATOR)) {
   while (false !== ($files = readdir($script_directory)))
      {
		  $files_zip = pathinfo($files);
          if ($files != "." && $files != ".." && $files_zip['extension'] == "zip")
	  	  {
          	$directory_list .= "<option value=\"$files\">$files</option>";
          }
       }
  closedir($script_directory);
  }
  
echo "$directory_list";
?>
</select>
</label>
<br /><br />

<!-- Step 3: Select Archive Options -->
<hr />
<b><u>Step 3: Select File Options:</u></b><br /><br />
<label>Unzip .zip archive: <input type="checkbox" name="unzip" id="unzip" value="<?=$unzip;?>" /></label>
<label>&nbsp;&nbsp;Delete .zip archive (<i>After Unzip</i>): <input type="checkbox" name="delete_archive" id="delete_archive" value="<?=$delete_archive;?>" class="DEPENDS ON unzip" /></label>
<label>&nbsp;&nbsp;Overwrite: <input type="checkbox" name="overwrite" id="overwrite" value="<?=$overwrite;?>" class="DEPENDS ON remote_upload_check OR direct_upload_check" checked /></label>
<br /><br />
<b>*Note - Unzipping &amp; Deleting only applies to .zip archives!</b>
<br /><br />

<!-- Step 4: Select Script Options -->
<hr />
<b><u>Step 4: Select Script Options:</u></b>
<br /><br />
<?php if ($delete_this_script == 0){ ?>
<label><b>-</b> <div class="warning">*Recommended</div>&nbsp;- Delete This Script (<i>After Upload Completed</i>): <input type="checkbox" name="delete_self" value="<?=$delete_self;?>" /></label>
<?php } elseif ($delete_this_script == 1){ ?>
<label><b>-</b> <div class="warning">*Recommended</div>&nbsp;- Delete This Script (<i>After Upload Completed</i>): <input type="checkbox" name="delete_self" value="<?=$delete_self;?>" checked /></label>
<?php } ?>
<br /><br />

<!-- Step 5: Upload the .zip file -->
<hr />
<b><u>Step 5: Upload File:</u></b><br /><br />
<input type="submit" name="upload" id="upload" onclick="showIcon();" value="Upload Now!" class="DEPENDS ON remote_upload_check OR direct_upload_check" />
<input type="submit" name="upload" id="upload" onclick="showIcon();" value="Unzip Now!" class="DEPENDS ON only_unzip_check" />
</form>
<!-- Remote .ZIP Uploader/Unzipper Form End -->

<!-- Upload Progress Notification Start -->
<div class="progress" id="progress" style="display:none;">
<br /><b>Uploading...</b>
</div>
<!-- Upload Progress Notification End -->

<!-- Show Script Directory Start -->
<hr />
<p><b>Scripts Location: <?php echo "<a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME'])."/\" target=\"_blank\">".dirname($_SERVER['SCRIPT_NAME'])."/</a>"; ?></b><br />(<i>.zip archive will be uploaded to this directory.</i>)</p>
<!-- Show Script Directory End -->

<!-- Logout Link Start -->
<div class="user">
	<a href="<?=htmlentities($_SERVER['PHP_SELF']);?>?logout">Logout</a>
</div>
<!-- Logout Link End -->
<br /><hr /><br />
<?php
}
?>
</body>
</html>
<?php
//Delete this script after successful run.
if(isset($_POST['delete_self']) && $success != '') {
	unlink(__FILE__);
}
?>