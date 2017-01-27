<?
class CustomEditor extends Editor {

	function validate_input() {
		if ($this->input_params['multi_lang']) {
			if (true !== ($r = db_mysql_query("ALTER TABLE `" . $this->input_params['table_name'] . "` ADD meta_site_lang_id varchar(40) NOT NULL DEFAULT '' AFTER  id", $this->conn)) and false === strpos($r, 'Duplicate column name')) {
				$this->set_alert("Ошибка при создании поля 'meta_site_lang_id' (" . $r . ")");
				return false;
			}
		}
		
		return parent::validate_input();
	}
}
?>