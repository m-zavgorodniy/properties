<?
	define('SITE_PATH', next(explode($_SERVER['DOCUMENT_ROOT'], str_replace('\\', '/', dirname(__FILE__)))));
	
	require $_SERVER['DOCUMENT_ROOT'] .  '/lib/engine/url_processor.php';
?>