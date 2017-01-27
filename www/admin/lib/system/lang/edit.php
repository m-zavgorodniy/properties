<?
class CustomEditor extends Editor {

	function on_update_success() {
		// ! todo - привязка таблиц к сайту. Системные таблицы - для всех сайтов. Пока тупо для всех таблиц
		
		$rs = db_mysql_query("SELECT f.field, m.table_name FROM meta_table_field f, meta_table m WHERE m.id = f.meta_table_id AND f.multi_lang <> 0 AND f.published <> 0", $this->conn);
		while ($row = mysql_fetch_assoc($rs)) {
			$table = $row['table_name'];
			$field = '';
			$rs_desc = db_mysql_query("DESC `" . $table . "`", $this->conn);
			while ($row_desc = mysql_fetch_assoc($rs_desc)) {
				if ($row_desc['Field'] == $row['field']) {
					$field = $row_desc['Field'];
					$field_type = $row_desc['Type'];
					$field_nullable = ('YES' == strtoupper($row_desc['Null']));
					$field_default = $row_desc['Default'];
					break;
				}
			}
			mysql_free_result($rs_desc);
			
			if ($field) {
				if (true !== ($r = db_mysql_query("ALTER TABLE `" . $table . "` ADD `" . $field . "_" . $this->input_params['id'] . "` " . $field_type . (!$field_nullable?" NOT NULL":"") . (NULL !== $field_default?" DEFAULT '" . $field_default . "'":($field_nullable?" DEFAULT NULL":'')) . " AFTER  `" . $field . "`", $this->conn))) {
					if (false === strpos($r, 'Duplicate column name')) {
						$this->set_alert("Ошибка при создании поля '" . $field . "_" . $lang_id . "' (" . $r . ")");
						if (isset($this->post_params['__create_field'])) {
							$this->set_record_meta('__create_field',  array('type' => 'hidden', 'default' => $this->post_params['__create_field']));
						}
						return false;
					}
				}
			}

		}
		mysql_free_result($rs);

		parent::on_update_success();
	}

}
?>