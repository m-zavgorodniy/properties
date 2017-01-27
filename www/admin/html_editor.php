<?php
require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
require "lib/functions_admin.php";
require "access.php";

header("X-XSS-Protection: 0");

include_once("htmleditor/fckeditor.php") ;
$saveHTML = ($_POST['action'] == "saveHTML");
if ($saveHTML) {
	$html_editor_result = $_POST['FCKeditor1'] ;
	$html_field	= $_POST['html_field'];
}
else {
	$html_field = $_GET['html_field'];
	$html_value = $_POST[$html_field];
}
?>
<html><head>
	<title>FCKeditor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="styles.css" />
<?
if ($saveHTML) {
?>
<script type="text/javascript">
	window.onload = function() {
//		window.opener.document.forms[0].action='';
//		window.opener.document.forms[0].target='';
		window.opener.document.forms[0].<?=$html_field?>.value = window.document.getElementById('saveHTML').innerHTML;
		window.open('','_self','');
		window.close();
	}
</script>
<?
} else {
?>
<script type="text/javascript">
	window.onload = function() {
		window.focus();
	}
</script>
<?
}
?>
</head>
<body class="cm-edit-html">
<?
if ($saveHTML) {
?>
	<div style="display: none" id="saveHTML"><?=$html_editor_result?></div>
<?
} else {
?>
  <form action="html_editor.php" method="post">
<?
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = '/admin/htmleditor/' ;
$oFCKeditor->Value = $html_value ;
$oFCKeditor->Height = "600";
//$oFCKeditor->Config['SkinPath'] = '/admin/htmleditor/editor/skins/office2003/' ;
$oFCKeditor->Create() ;
?>
    <input type="hidden" name="html_field" value="<?=$html_field?>">
    <input type="hidden" name="action" value="saveHTML">
<!--    <div class="cm-edit-submit">
	    <input type="submit" value="Сохранить" class="submit">
        <input type="button" value="Отменить" onClick="window.close()">
    </div> -->
  </form>
<?
}
?>
</body>
</html>
