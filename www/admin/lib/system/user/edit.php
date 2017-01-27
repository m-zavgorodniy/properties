<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

		if ($this->input_params['login'] == ADMIN_LOGIN) {
			$this->set_record_meta('login', array('readonly' => 1));
			$this->set_record_meta('enabled', array('readonly' => 1));
		}

	}
}
?>