<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

		// get path form parent section
		$rs = db_mysql_query_with_params("SELECT path, dir FROM section WHERE id = {section_id}", array('section_id' => $this->input_params['section_id']), $this->conn);
		if ($row = mysql_fetch_row($rs)) {
			$path = $row[0] . $row[1];
		}
		mysql_free_result($rs);
		$this->set_record_meta('path', array('default' => $path . "/"));
		if (!$path)
			$this->set_record_meta('dir', array('required' => 0));
		
		// do not allow to edit directory name if there are subsections
		if (!$this->is_new and !$this->check_constraints(array('section'))) {
			$this->set_record_meta('dir', array('readonly' => 1));
		}
	}

	function validate_input() {
		if (parent::validate_input()) {

			if (!self::valid_dir($this->input_params['dir'])) {
				$this->set_alert("Название папки должно содержать только строчные латинские символы или цифры");
				return false;
/*			} else if ($this->input_params['path'] == '/' and in_array($this->input_params['dir'], array('admin', 'images', 'lib', 'uploads'))) {
				$this->set_alert("Название папки '" . $this->input_params['dir'] . "' является зарезервированным. Пожалуйста, выберите другое.");
				return false;
			} else {
				 // check if we are about to overwrite somebody's else index file
				$signature = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/lib/engine/index_file_signature.tmpl');
				$filename = $_SERVER['DOCUMENT_ROOT'] . $this->input_params['path'] . $this->input_params['dir'] . '/index.php';
				if (file_exists($filename) and strpos(@file_get_contents($filename), $signature) === false) {
					$this->set_alert("В папке с названием '" . $input_params['dir'] . "' уже существует файл index.php.");
					return false;
				}*/
			}
			
			return true;
		} else {
			return false;
		}
	}

/*	function on_update_success() {
		if ($this->input_params['published'] and 
			true !== self::create_section($this->site_id, $this->get_site_path(), $this->input_params['path'], $this->input_params['dir'],
										   $this->input_params['section_type_id'], $this->is_new?$this->inserted_id:$this->id)) {
			$this->set_alert("Ошибка при создании файла");
		} else {
			parent::on_update_success();
		}
	}*/

	function on_update_error($error_message) {
		parent::on_update_error($error_message);
		
		if (strpos($error_message, 'for key 2') !== false)
			$this->set_alert("Папка с названием '" . $this->input_params['dir'] . "' уже существует в разделе.");
	}

	// static
/*	function create_section($site_id, $site_path, $path, $dir, $section_type_id, $new_section_id) {
		$tmpl_file = fopen($_SERVER['DOCUMENT_ROOT'].'/lib/engine/index_file.tmpl', 'r');
		$tmpl = '';
		while (!feof($tmpl_file)) {
		   $line = fgets($tmpl_file);
		   $tmpl .= $line;
		}
		fclose($tmpl_file);
		$tmpl_parts = explode("{SITE_ID}", $tmpl);
		$tmpl = $tmpl_parts[0].$site_id.$tmpl_parts[1];
		$tmpl_parts = explode("{SITE_PATH}", $tmpl);
		$tmpl = $tmpl_parts[0].$site_path.$tmpl_parts[1];
		$tmpl_parts = explode("{SECTION_ID}", $tmpl);
		$tmpl = $tmpl_parts[0].$new_section_id.$tmpl_parts[1];
		$tmpl_parts = explode("{SECTION_TYPE}", $tmpl);
		$tmpl = $tmpl_parts[0].$section_type_id.$tmpl_parts[1];
		
		$dirname = $_SERVER['DOCUMENT_ROOT'].$site_path.$path.$dir;

		$old = umask(0);
		@mkdir($dirname, 0755);
		umask($old);
	
		// check if we are about to overwrite somebody's else index file
		$signature = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/lib/engine/index_file_signature.tmpl');
		$filename = $dirname.'/index.php';
		if (file_exists($filename) and strpos(file_get_contents($filename), $signature) === false) {
			return "Can not overwrite " . $filename;
		}
		if (!($file = @fopen($filename, 'w'))) {
			return "Can not create " . $filename;
		}
		fputs($file, $tmpl);
		fputs($file, "\r\n" . $signature);
		fclose($file);
//		chmod($filename, 0664);
	
		return true;
	} */

	function valid_dir($str) {
		if (empty($str))
			return true;
		return ( ! preg_match("/^[a-z0-9\+_\-]+$/", $str)) ? FALSE : TRUE;
	}
}
?>