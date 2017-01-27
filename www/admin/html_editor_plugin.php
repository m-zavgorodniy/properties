<?
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";

	@include ("htmleditor/editor/plugins/" . ACTION_TYPE . "/" . ACTION_TYPE . ".php");
?>
