<?
class CustomDeletePreview extends DeletePreview {

	function get_init_input() {
		parent::get_init_input();
		
		if ($this->input_params['id'] === '') {
			$this->set_table_meta(array('deletable' => false));
		}

	}
				   
}
?>