<?
class CustomDeletePreview extends DeletePreview {

	function on_update_success() {

		parent::on_update_success();

		self::delete_section($this->input_params['path'].$this->input_params['dir'], $this->get_site_path());

	}

	// static
	function delete_section($section_path, $site_path) {
		$dirname = $_SERVER['DOCUMENT_ROOT'] . $site_path;
	
		if (trim(strtr($section_path, "\\", "/"), " /") !== "") {
			$dirname .= $section_path;
			$not_site_root = true;
		}
	
		// check if we are about to delete somebody's else index file
		$signature = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/lib/engine/index_file_signature.tmpl');
		$filename = $dirname . '/index.php';
		if (file_exists($filename) and strpos(file_get_contents($filename), $signature) === false) {
			$exception = $filename . " was modified";
		} else {
			if (file_exists($filename) and !(@unlink($filename))) {
				$exception = "Can not delete " . $filename;
			} else if ($not_site_root) {
				// rmdir is not supposed to remove directory recursively, but it's better to know for sure
				if (file_exists($dirname) and ($handle = opendir($dirname))) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							$is_files = true;
							break;
						}
					}
					closedir($handle);
					if (!$is_files) {
						@rmdir($dirname);
					}
				}
			}
		}
	
		return $exception?$exception:true;
	}
}

?>