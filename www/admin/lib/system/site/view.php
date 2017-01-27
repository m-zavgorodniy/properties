<?
class CustomView extends View {

	function init() {
		global $config;

		if (parent::init()) {
			$this->record['path_files'] = '<doc_root>' . ($this->record['path_files']?$this->record['path_files']:$this->record['path']);
			return true;
		} else {
			return false;
		}

	}
}
?>