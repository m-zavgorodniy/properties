<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

		$this->set_record_meta('type', array('type' => 'lookup', 'options_custom' => array('text' => 'Текст', 'textarea' => 'Текстовая область', 'html' => 'HTML', 'int' => 'Число целое', 'decimal' => 'Число с точкой')));
	}

}
?>