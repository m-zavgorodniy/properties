<?
class CustomView extends View {

	function init() {
		global $config;

		if (parent::init()) {
			// todo! if site has it's own templates directory
			$this->set_record_meta('template', array('title' => 'Шаблон', 'published' => 1));
			$this->record['template'] = '<doc_root>' . $_SESSION['site_path'] . '/' . CMS_SITE_LIB_DIR_NAME . '/templates/' . $this->id . '.php';
			return true;
		} else {
			return false;
		}

	}
}
?>