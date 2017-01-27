<?
require $_SERVER['DOCUMENT_ROOT'] . "/lib/mail.php";

class CustomDeletePreview extends DeletePreview {

	function get_init_input() {
		parent::get_init_input();
		
		if ($this->init_params['sent']) {
			$this->set_table_meta(array('deletable' => 0)); 
			$this->alert = 'Письмо отправлено.';
		} else if ($this->init_params['send']) {
			$this->set_table_meta(array('deletable' => 0)); 
			$this->alert = 'Письмо находится в очереди отправки.';
		}
	}
}
?>
