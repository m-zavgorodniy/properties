<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

		$rs = db_mysql_query("SELECT w, h FROM banner_type WHERE id = '" . $this->init_params['banner_type_id'] . "'", $this->conn);
		if ($row = mysqli_fetch_assoc($rs)) {
			if (isset($this->record_meta['img_src'])) {
				$this->set_record_meta('img_src', array('title' => $this->record_meta['img_src']['title'] . ' (' . $row['w'] . 'x' . $row['h'] . ')'));
			}
			if (isset($this->record_meta['flash_src'])) {
				$this->set_record_meta('flash_src', array('title' => $this->record_meta['flash_src']['title'] . ' (' . $row['w'] . 'x' . $row['h'] . ')'));
			}
		}
		mysqli_free_result($rs);

	}

	function validate_input() {
	
		$this->set_record_meta('color_scheme_id', array('required' => false));
		
		if (parent::validate_input()) {
			return true;
		} else {
			return false;
		}
	}
		

}
?>