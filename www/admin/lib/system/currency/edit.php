<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

		if ($this->input_params['id'] === '') {
			$this->set_record_meta('id', array('readonly' => 1, 'required' => 0));
		}

	}
}
?>