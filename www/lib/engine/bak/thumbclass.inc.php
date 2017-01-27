<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/external/phpthumb/phpthumb.class.php');

class myPhpThumb extends phpThumb
{
    function myPhpThumb()
    {
		$this->setParameter('config_document_root', $_SERVER['DOCUMENT_ROOT']);
//		$this->setParameter('config_cache_directory', $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/_thumbcache/');
//		$this->setParameter('config_imagemagick_path', '/usr/local/bin/convert');

		$this->setParameter('q', 80);

    }
	
	function createThumbnailFile ($output_filename)
	{
		$source_filenam_ext = strtolower(pathinfo($this->src, PATHINFO_EXTENSION));
		switch($source_filenam_ext) {
			case 'jpg': case 'jpeg': $config_output_format = 'jpeg'; break;
			case 'gif': case 'png': $config_output_format = 'gif'; break;
			default: $config_output_format = 'jpeg';
		}
		$this->setParameter('f', $config_output_format);
		
		if ($this->GenerateThumbnail()) {
			$output_size_x = ImageSX($this->gdimg_output);
			$output_size_y = ImageSY($this->gdimg_output);
			$output_filename_ext = strtolower(pathinfo($output_filename, PATHINFO_EXTENSION));
			$output_filename = substr($output_filename, 0, strlen($output_filename) - strlen($output_filename_ext));
			$output_filename .= $output_size_x . "x" . $output_size_y . "." . $output_filename_ext;
			if($this->RenderToFile($output_filename)) {
				return next(explode($_SERVER['DOCUMENT_ROOT'], $output_filename));
			}
		}
		return false;
	}
}
?>