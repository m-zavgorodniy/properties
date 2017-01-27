<?
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<style>
		.cm-panel-right, .cm-panel-right a {color: #333333;}
		.cm-panel-right a {display: inline; float: none; margin: 0;}
		.cm-panel {border: 0; border-bottom: 1px solid #808080;}

	</style>
</head>
<body>
	<div class="cm-panel">
    <?	// ! hardcode for moscowkey
		if (ADMIN_LOGIN == $_SESSION['admin']) { ?>
        <a href="cms.php?view=metatable" target="tree" onClick="setFrame()"><img src="images/icons/gear_big.png" alt="">CMS</a>
    <?	} ?>
	    <div class="cm-panel-right">
			Designed by <a href="http://e-i.com.ru/" target="_blank">Eclipse</a>
	    </div>
    </div>
</body>
</html>
