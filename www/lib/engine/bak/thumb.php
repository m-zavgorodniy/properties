<?php
//require 'config.php';
require 'thumbclass.inc.php';

function create_thumbnail($source_filename, $output_filename, $w = 0, $h = 0, $crop = '') {
	global $config;
	if (!$crop) {
		$crop = $config['GALLERY_THUMBNAIL_CROP_METHOD'];
	}
	if (!$w) {
		$w = $config['GALLERY_THUMBNAIL_WIDTH'];
	}
	if (!$h) {
		$h = $config['GALLERY_THUMBNAIL_HEIGHT'];
	}

	$phpThumb = new myPhpThumb();

	$phpThumb->setSourceFilename($source_filename);
	
	switch($crop) {
		case 'c':
			$phpThumb->setParameter('w', $w);
			$phpThumb->setParameter('h', $w);
			$phpThumb->setParameter('zc', 1);
			break;
		case 'h':
			$phpThumb->setParameter('h', $h);
			break;
		case 'w':
			$phpThumb->setParameter('w', $w);
			break;
		default:
			// to get exact both width end height of thumbnail let's resize shorter side to fit area and crop another one
			list($source_width, $source_height) = getimagesize($source_filename);
			if ($source_width > $w or $source_height > $h) {
				if ($source_width / $source_height > $w / $h) {
					$phpThumb->setParameter('h', $h);
					$resize_rate = $source_height / $h;
					$new_w = $source_width / $resize_rate;
					$side_crop_l = $side_crop_r = ceil(($new_w - $w) / 2);
					if (($side_crop_l + $side_crop_r + $w) > $new_w) $side_crop_r--; // 1 pixel - crop can be only bigger than exact width because of 'ceil' above
					if (($side_crop_l + $side_crop_r + $w) > $new_w) $side_crop_l--;
					$phpThumb->setParameter('fltr', 'crop|' . $side_crop_l . '|' . $side_crop_r . '|0|0');
				} else {
					$phpThumb->setParameter('w', $w);
					$resize_rate = $source_width / $w;
					$new_h = $source_height / $resize_rate;
					$side_crop_t = $side_crop_b = ceil(($new_h - $h) / 2);
					if (($side_crop_t + $side_crop_b + $h) > $new_h) $side_crop_b--; // 1 pixel - crop can be only bigger than exact height because of 'ceil' above
					if (($side_crop_t + $side_crop_b + $h) > $new_h) $side_crop_t--;
					$phpThumb->setParameter('fltr', 'crop|0|0|' . $side_crop_t . '|' . $side_crop_b);
				}
			} else {
				$phpThumb->setParameter('w', $source_width);
			}
	}

	return $phpThumb->createThumbnailFile($output_filename);
}

function resize_w($source_filename, $w, $output_filename = '') {
	$phpThumb = new myPhpThumb();

	$phpThumb->setSourceFilename($source_filename);
	
	$phpThumb->setParameter('w', $w);
	
	if ($phpThumb->GenerateThumbnail() and $phpThumb->RenderToFile($output_filename?$output_filename:$source_filename)) {
		return true;
	} else {
		return false;
	}
}

function resize_h($source_filename, $h, $output_filename = '') {
	$phpThumb = new myPhpThumb();

	$phpThumb->setSourceFilename($source_filename);
	
	$phpThumb->setParameter('h', $h);
	
	if ($phpThumb->GenerateThumbnail() and $phpThumb->RenderToFile($output_filename?$output_filename:$source_filename)) {
		return true;
	} else {
		return false;
	}
}

function resize_wh($source_filename, $w, $h, $output_filename = '') {
	$phpThumb = new myPhpThumb();

	$phpThumb->setSourceFilename($source_filename);
	
	$phpThumb->setParameter('w', $w);
	$phpThumb->setParameter('h', $h);
	
	if ($phpThumb->GenerateThumbnail() and $phpThumb->RenderToFile($output_filename?$output_filename:$source_filename)) {
		return true;
	} else {
		return false;
	}
}

?>