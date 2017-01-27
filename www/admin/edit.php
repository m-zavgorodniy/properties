<?
require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
require "lib/functions_admin.php";
require "access.php";

require "lib/edit.class.php";

include_custom(ACTION_TYPE, 'edit');
if (class_exists('CustomEditor'))
	$editor = new CustomEditor(ACTION_TYPE, SITE_ID, ID, $_GET, $_POST);
else
	$editor = new Editor(ACTION_TYPE, SITE_ID, ID, $_GET, $_POST);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<link type="text/css" media="screen" href="calendar/styles/vlaCal-v2.1.css" rel="stylesheet" />
    <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    <script type="text/javascript">jQuery.noConflict();</script>
	<script type="text/javascript" src="calendar/jslib/mootools-1.2-core.js"></script>
	<script type="text/javascript" src="calendar/jslib/vlaCal-v2.1.js"></script>
    <script type="text/javascript" src="utils.js"></script>
</head>
<body class="cm-edit cm-edit-wide">
<? 
	$editor->render();
?>
</body>
</html>