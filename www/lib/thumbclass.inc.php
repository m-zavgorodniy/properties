<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/external/phpthumb/phpthumb.class.php');

class myPhpThumb extends phpThumb
{
    function myPhpThumb()
    {
		$this->setParameter('config_document_root', $_SERVER['DOCUMENT_ROOT']);
//		$this->setParameter('config_cache_directory', $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/_thumbcache/');
//		$this->setParameter('config_imagemagick_path', '/usr/local/bin/convert');

		$this->setParameter('q', 90);

    }
	
	function createThumbnailFile($output_filename, $no_overwrite = false)
	{
		$source_filenam_ext = strtolower(pathinfo($this->src, PATHINFO_EXTENSION));
		switch($source_filenam_ext) {
			case 'gif': case 'png': $config_output_format = 'gif'; break;
			default: $config_output_format = 'jpeg';
		}
		$this->setParameter('f', $config_output_format);
		
		$res = false;
		if ($this->GenerateThumbnail()) {
			$output_size_x = ImageSX($this->gdimg_output);
			$output_size_y = ImageSY($this->gdimg_output);
			$output_filename_ext = strtolower(pathinfo($output_filename, PATHINFO_EXTENSION));
			$output_filename = substr($output_filename, 0, strlen($output_filename) - strlen($output_filename_ext));
			$output_filename .= $output_size_x . "x" . $output_size_y . "." . $output_filename_ext;
			if ($no_overwrite and file_exists($output_filename)) {
				$res = true;
			} else {
				if($this->RenderToFile($output_filename)) {
					$res = true;
				}
			}
		}
		return $res?next(explode($_SERVER['DOCUMENT_ROOT'], $output_filename)):false;
	}
}
?>