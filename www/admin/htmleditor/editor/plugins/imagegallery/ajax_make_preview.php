<?
//	Image Gallery FCKEditor Plugin 
//	(c) 2009-2012 Eclipse Interactive
//	http://e-i.com.ru

	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require $_SERVER['DOCUMENT_ROOT']."/admin/lib/functions_admin.php";
	require $_SERVER['DOCUMENT_ROOT']."/admin/access.php";
	require $_SERVER['DOCUMENT_ROOT']."/lib/thumb.php";
	
	define('THUMB_DIR_NAME', $config['GALLERY_THUMBNAIL_DIR_NAME']?$config['GALLERY_THUMBNAIL_DIR_NAME']:'.resize');
	
	$error_header = 'HTTP/1.1 500 Internal Server Error';
	
	$img_src = $_GET['image'];
	$thumbnail_width = $_GET['width'];
	$thumbnail_height = $_GET['height'];
	if (!isset($img_src) || !isset($thumbnail_width) || !isset($thumbnail_height)) {
		header($error_header);
		die();
	}
	$crop = $_GET['crop'];

	if (strpos($img_src, "http://") !== false) {
		$img_src_expl = explode("http://", $img_src, 2);
		$img_src_expl = explode("/", $img_src_expl[1], 2);
		$img_src = "/" . $img_src_expl[1];
	}
	$img_src = $_SERVER['DOCUMENT_ROOT'] . $img_src;
	
	$thumbnail_path = $config['GALLERY_THUMBNAIL_ALT_PATH']?$_SERVER['DOCUMENT_ROOT'] . $config['GALLERY_THUMBNAIL_ALT_PATH']:dirname($img_src) . "/" . THUMB_DIR_NAME;
	if (!file_exists($thumbnail_path))
		if (!@mkdir($thumbnail_path, 0777)) {
			header($error_header);
			die("Error creating thumbnails directory: ".$thumbnail_path);
		}
	$thumbnail_file = basename($img_src); // "." . basename($img_src);
		
	$thumbnail_destination = $thumbnail_path . "/" . $thumbnail_file;
/*	if ($crop == 'h') {
		$thumbnail_height = $thumbnail_size;
	} else if ($crop == 'c') {
		$thumbnail_width = $thumbnail_height = $thumbnail_size;
	} else { // w, default
		$thumbnail_width = $thumbnail_size;
	}*/
	if (($thumbnail_destination = create_thumbnail($img_src, $thumbnail_destination, $thumbnail_width, $thumbnail_height, $crop)) === false) {
		header($error_header);
		die("Error generating thumbnail: ".$thumbnail_destination);
	}
	echo $thumbnail_destination;
	exit;
?>