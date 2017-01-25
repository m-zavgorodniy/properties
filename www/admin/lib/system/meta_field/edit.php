<?
class CustomEditor extends Editor {

	function get_init_input() {
		
		parent::get_init_input();

		// copy is in seo_parameter/edit.php
		$this->set_record_meta('lookup_meta_table_field_id', array('sql_custom' => "SELECT f.id, CONCAT(t.title,' : ',f.title, IF(is_system, ' (системная таблица)', '')) title FROM meta_table t, meta_table_field f WHERE f.meta_table_id = t.id AND f.type_extra IS NULL ORDER BY 2")); // (f.field = 'title' OR f.field = 'name' OR f.field = 'login' OR f.field = 'company') // AND t.is_system = 0
		$this->set_record_meta('field_old', array('type' => "hidden", 'default' => $this->input_params['field']));

		$rs = db_mysql_query("SELECT table_name FROM meta_table WHERE id = '" . $this->input_params['meta_table_id'] . "'", $this->conn);
		if ($row = mysqli_fetch_assoc($rs)) {
			$this->set_record_meta('table_name', array('type' => "hidden", 'default' => $row['table_name']));
		}
		mysqli_free_result($rs);
		
		$this->set_record_meta('type_extra', array('type' => "lookup", 'options_custom' => array(
			 '' => "Текстовое поле",
			 'textarea' => "Текстовая область",
			 'html' => "HTML",
			 'lookup' => "Выбор из справочника (связь через поле)",
			 'lookup_external' => "Выбор из справочника (связь через таблицу)",
			 'lookup_custom' => "Вариант выбора",
			 'date' => "Дата",
			 'datetime' => "Дата и время",
			 'boolean' => "Да/Нет",
			 'boolean_ajax' => "Да/Нет (AJAX)",
			 'sort' => "Порядковый номер",
			 'number' => "Число целое",
			 'float' => "Число с точкой",
			 'currency' => "Цена (использовать справочник валют)",
			 'image' => "Картинка",
			 'image_preview' => "Картинка уменьшенная",
			 'image_big' => "Картинка исходная",
			 'url' => "Ссылка (URL)",
			 'flash' => "Флэш",
			 'video' => "Видео",
			 'doc' => "Документ",
			 'google_map' => "Координаты на карте Google",
			 'file' => "Файл",
			 'password' => "Пароль",
			 'calc' => "Вычисляемое поле (SQL), строка",
			 'calc_boolean' => "Вычисляемое поле (SQL), Да/Нет",
			 'calc_view' => "Вычисляемое поле (SQL), скрытое (hidden)",
			 'hidden' => "Скрытое поле (hidden)"
			 )));
	}
	
	function render() {
		parent::render(); ?>
		
		<script type="text/javascript">
			jQuery(function() {
				var type_extra_select = jQuery("[name='type_extra']");
				type_extra_select
					.change(function() {
						var lookup_meta_table_field = jQuery("[name='lookup_meta_table_field_id']").closest("tr");
						var lookup_meta_table = jQuery("[name='lookup_external_meta_table_id']").closest("tr");
						var lookup_filter_field = jQuery("[name='lookup_filter']").closest("tr");
						var lookup_quick_add_field = jQuery("[name='lookup_quick_add']").closest("tr");
						var lookup_multi = jQuery("[name='lookup_multi']").closest("tr");
						var sql_value = jQuery("[name='sql_value']").closest("tr");
						var type_extra_select_val = jQuery(":selected", type_extra_select).val();
						
						if ('lookup' != type_extra_select_val && 'lookup_custom' != type_extra_select_val && 'lookup_external' != type_extra_select_val) {
							lookup_multi.css("display", "none");
						} else {
							lookup_multi.css("display", "table-row");
						}
						if ('lookup' != type_extra_select_val && 'lookup_external' != type_extra_select_val) {
							lookup_filter_field.css("display", "none");
						} else {
							lookup_filter_field.css("display", "table-row");
						}
						if ('lookup' == type_extra_select_val || 'lookup_external' == type_extra_select_val) {
							lookup_meta_table_field.css("display", "table-row");
							lookup_quick_add_field.css("display", "table-row");
						} else {
							lookup_meta_table_field.css("display", "none");
							lookup_quick_add_field.css("display", "none");
						}
						if ('lookup_external' == type_extra_select_val) {
							lookup_meta_table.css("display", "table-row");
						} else {
							lookup_meta_table.css("display", "none");
						}
						if ('calc' == type_extra_select_val || 'calc_boolean' == type_extra_select_val || 'calc_view' == type_extra_select_val) {
							sql_value.css("display", "table-row");
						} else {
							sql_value.css("display", "none");
						}
					})
					.each(function() {type_extra_select.triggerHandler("change");})
			});
        </script>
<?	}

	function validate_input() {
		if (isset($this->post_params['__create_field'])) {
			$this->hide_output();
			list($table, $field) = explode('.', $this->post_params['__create_field']);
/*	not sure is it right
			$reserved_field_names = array('id', 'meta_site_id', 'meta_site_lang_id', 'meta_table_id');
			if (in_array($field, $reserved_field_names)) {
				$this->set_alert("Ошибка при создании поля: имя поля '" . $field . "' является зарезервированным. Пожалуйста, выберите другое.");
				return false;
			}*/
			// ALTER TABLE `article` ADD `www` VARCHAR( 22 ) NOT NULL
			if (true !== ($r = db_mysql_query("ALTER TABLE `" . $table . "` ADD `" . $field . "` " . $this->input_params['type'] . (!$this->input_params['nullable']?" NOT NULL":""), $this->conn))) {
				$this->set_alert("Ошибка при создании поля '" . $this->input_params['__create_field'] . "' (" . $r . ")");
				$this->set_record_meta('__create_field',  array('type' => 'hidden', 'default' => $this->post_params['__create_field']));
				return false;
			} else if (!$this->input_params['multi_lang']) { ?>
            	<script type="text/javascript">
					window.close()
                </script>
			<?	return false;
			}
		}

		if ($this->input_params['multi_lang'] and
				($this->post_params['__create_field'] and true === $r or 
				!$this->is_new)) {
			if (!isset($field)) { // otherwise $field and $table are set above (if isset($this->post_params['__create_field'])..)
				$field = $this->input_params['field'];
				$table = $this->input_params['table_name'];
			}

			$rs = db_mysql_query("DESC `" . $table . "`", $this->conn);
			while ($row = mysqli_fetch_assoc($rs)) {
				if ($field == $row['Field']) {
					$field_type = $row['Type'];
					$field_nullable = ('YES' == strtoupper($row['Null']));
					$field_default = $row['Default'];
					break;
				}
			}
			mysqli_free_result($rs);
			if (!isset($field_type)) {
				$this->set_alert("Ошибка: поля '" . $field . "' нет в таблице!");
				if (isset($this->post_params['__create_field'])) {
					$this->set_record_meta('__create_field',  array('type' => 'hidden', 'default' => $this->post_params['__create_field']));
				}
				return false;
			}

			foreach ($this->site_langs_extra as $lang_id => &$extra_lang) {
				if (true !== ($r = db_mysql_query("ALTER TABLE `" . $table . "` ADD `" . $field . "_" . $lang_id . "` " . $field_type . (!$field_nullable?" NOT NULL":"") . (NULL !== $field_default?" DEFAULT '" . $field_default . "'":($field_nullable?" DEFAULT NULL":'')) . " AFTER  `" . $field . "`", $this->conn)) and false === strpos($r, 'Duplicate column name')) {
					$this->set_alert("Ошибка при создании поля '" . $field . "_" . $lang_id . "' (" . $r . ")");
					if (isset($this->post_params['__create_field'])) {
						$this->set_record_meta('__create_field',  array('type' => 'hidden', 'default' => $this->post_params['__create_field']));
					}
					return false;
				}
			}
			unset($extra_lang);
		}
		
		return parent::validate_input();
	}
	
	function on_update_success() {
		if ($this->input_params['published'] and $this->input_params['type_extra'] != 'lookup_external' and $this->input_params['type_extra'] != 'calc' and $this->input_params['type_extra'] != 'calc_boolean' and $this->input_params['type_extra'] != 'calc_view') {
			$rs = db_mysql_query("SELECT * FROM `" . $this->input_params['table_name'] . "` WHERE 1 LIMIT 1", $this->conn);
			$row = mysqli_fetch_assoc($rs);
			mysqli_free_result($rs);
			if ($row and !isset($row[$this->input_params['field']])) {
				$this->set_alert("Поля '" . $this->input_params['table_name'] . "." . $this->input_params['field'] . "' в базе данных не существует. Создать его?");
				$this->set_record_meta('__create_field',  array('type' => 'hidden', 'default' => $this->input_params['table_name'] . "." . $this->input_params['field']));
				$this->hide_output();

				parent::on_update_success(1);
			} else {
				parent::on_update_success();
			}
		} else {
			parent::on_update_success();
		}
	}

	function hide_output() { ?>
    	<style type="text/css">
			.label, .input {display: none;}
        </style>
<?	}

}
?>