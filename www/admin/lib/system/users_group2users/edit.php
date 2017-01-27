<?
class CustomEditor extends Editor {

	function get_init_input() {
		
		parent::get_init_input();

		$this->set_record_meta('user_id', array('lookup_filter' => "login IS NOT NULL"));
	}

}
?>