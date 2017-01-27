<?
	if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') die(); // only local testing
	
	require dirname(__FILE__) . '/../../script/' . $_SERVER['QUERY_STRING'];
?>