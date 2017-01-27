<?
class CustomEditor extends Editor {

	function init() {
		if (parent::init()) {
			$this->set_alert("Список значений параметра в формате ЧПУ будет полностью обновлен.
			<br><font color='red'>Могут изменениться адреса уже проиндексированных поисковиками страниц.</font>");
			
			return true;
		} else {
			return false;
		}
	}

	function get_init_input() {
		parent::get_init_input();
		
		$sef_url_rules = get_sef_url_rules($this->conn);
		$rule = $sef_url_rules[$this->id];
		
		$this->values_table_name = $rule['values_table'];
		
		$this->source_field = $rule['values_source_field'];
		$this->set_record_meta('meta_table_field_id', array('title' => "Поле с исходными значениями"));
		$this->record['meta_table_field_id_lookup'] = $this->values_table_name . "." . $this->source_field;

		$this->target_field = $rule['values_target_field'];
		$this->set_record_meta('sef_field', array('title' => "Поле со значениями в формате ЧПУ", 'readonly' => 1, 'default' => $this->values_table_name . "." . $this->target_field));

		$rs_desc = db_mysql_query("DESC `" . $this->values_table_name . "`", $this->conn);
		while ($row = mysql_fetch_row($rs_desc)) {
			if ($row[0] == $this->target_field) {
				$this->target_field_exists = true;
				break;
			}
		}
		mysql_free_result($rs_desc);
		if ($this->target_field_exists) {
			$this->set_alert("Список значений параметра в формате ЧПУ будет обновлен только для тех записей, для которых это значение по каким-либо причинам пусто. Уже существующие значения, и, соответственно, адреса уже проиндексированных поисковиками страниц не изменятся");
		} else {
			$this->set_alert("В таблице <b>" . $this->values_table_name . "</b> будет автоматически создано поле <b>" . $this->target_field . "</b> и заполнено значениями параметра в формате ЧПУ.
			
			ЧПУ будет работать с этим параметром только после выполнения этого действия. Вы также можете выполнить его позже в любой момент.");
		}
		
	}
	
	function update() {
		if (!$this->target_field_exists) {
			if (true === ($r = db_mysql_query("ALTER TABLE `" . $this->values_table_name . "` ADD `" . $this->target_field . "` VARCHAR(255) NULL", $this->conn))) {
				$r = db_mysql_query("ALTER TABLE `" . $this->values_table_name . "` ADD UNIQUE (`" . $this->target_field . "`)", $this->conn);
			}
			if (true !== $r) {
				return $r;
			}
		}
		
		$rs = db_mysql_query("SELECT id, `" . $this->source_field . "` FROM `" . $this->values_table_name . "` WHERE 1", $this->conn);
		while ($row = mysql_fetch_row($rs)) {
			$r = db_mysql_query("UPDATE `" . $this->values_table_name . "` SET `" . $this->target_field . "` = '" . mysql_real_escape_string(make_safe_url(transliterate($row[1])), $this->conn) . "' WHERE id = " . $row[0] . " AND (TRIM(`" . $this->target_field . "`) = '' OR `" . $this->target_field . "` IS NULL)", $this->conn);
			if (true !== $r) {
				// try to add ID to the sef value if error is caused by not unique value
				// target field MUST have unique index
				$r = db_mysql_query("UPDATE `" . $this->values_table_name . "` SET `" . $this->target_field . "` = '" . mysql_real_escape_string(make_safe_url(transliterate($row[1]) . '-' . $row[0]), $this->conn) . "' WHERE id = " . $row[0] . " AND (TRIM(`" . $this->target_field . "`) = '' OR `" . $this->target_field . "` IS NULL)", $this->conn);
			}
			if (true !== $r) {
				break;
			}
		}
		mysql_free_result($rs);
		if (true === $r) {
			db_mysql_query("UPDATE seo_parameter SET activated = 1 WHERE id = '" . $this->id . "'", $this->conn);
		}
		return $r;
	}
	
	function on_update_success() { 
		$this->set_table_meta(array('editable' => 0)); 
		$this->set_alert(''); ?>

		<script type="text/javascript">
			opener.location.reload();
        </script>
		<div class="info">
			Список значений <?=$this->target_field_exists?' обновлен':' сформирован'?>.
		</div>
<?	}

	var $values_table_name;
	var $source_field;
	var $target_field;
	var $target_field_exists;
}
?>
