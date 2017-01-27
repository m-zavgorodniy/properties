<?
class CustomEditor extends Editor {

	function get_init_input() {
		global $config;

		parent::get_init_input();

		if ($this->init_params['is_system']) {
			$this->set_record_meta('id', array('readonly' => 1, 'required' => 0));
			$this->set_record_meta('published', array('readonly' => 1, 'required' => 0));
			$this->remove_record_meta('meta_table_id');
		}
		if ($this->init_params['id'] == 'index') {
			$this->set_record_meta('id', array('readonly' => 1, 'required' => 0));
		}

		$this->set_record_meta('template', array('title' => 'Шаблон', 'readonly' => 1, 'default' => '<doc_root>' . $_SESSION['site_path'] . '/' . CMS_SITE_LIB_DIR_NAME . '/templates/' . ($this->input_params['id']?$this->input_params['id']:'<Идентификатор>') . '.php'));
	}
}
?>