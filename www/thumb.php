<?php
	$_GET['src'] or die();
	
	$mode = $_GET['mode'];
	unset($_GET['mode']);

	switch ($mode) {
		case 'thumb':
			// 173x115
			$_GET['w'] = 203; // 173+(15*2)
			$_GET['h'] = 145; // 115+(15*2)
			$_GET['zc'] = 1;
			$_GET['fltr'] = 'crop|0|0|15|15';
			break;
		default:
			$_GET['fltr'] = 'crop|0|0|64|64';
	}
	$PHPTHUMB_DEFAULTS['q'] = 90;
	
	// for src like image.jpg?3394623, which is to prevent browser caching
	$_GET['src'] = current(explode('?', $_GET['src']));
	
	require $_SERVER['DOCUMENT_ROOT'].'/lib/external/phpthumb/phpThumb.php';
	
/*	$phpThumb = new phpThumb();
	$phpThumb->setSourceFilename($img_src); 
	$phpThumb->setParameter('config_output_format', 'jpeg');
	$phpThumb->setParameter('config_document_root', $_SERVER['DOCUMENT_ROOT']);
	$phpThumb->setParameter('config_cache_directory', $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/property/agency/_cache/');
	$phpThumb->setParameter('w', 'plan' != $_GET['type'] ? 110 : 290);
	$phpThumb->setParameter('q', 80);
	if ($phpThumb->GenerateThumbnail()) {
			$phpThumb->OutputThumbnail();
	}*/
?>