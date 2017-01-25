<?
require BACK_OFFICE_PATH . '/lib/metatable.class.php';

class MetaTableSiteLink extends MetaTable {
	
	function init($records_on_page = 0) {
		if ($this->get_table_meta()) {
			$this->records_on_page = $records_on_page?$records_on_page:$this->table_meta['frontend_onpage_num'];
			$this->records_from = ($this->page - 1) * $this->records_on_page + 1;

			$do_run_query = true;
			if ($this->table_meta['frontend_sql_filter']) {
				// syntax: book.published AND [book_section_id = {book_section}]
				// {get parameter name}
				// [active if {get parameter} is set]
				// we can use GET params in filters. example: service_group_id = {service_group}
				if (preg_match_all("/{([a-zA-Z0-9_\-]+)}/U", $this->table_meta['frontend_sql_filter'], $matches)) {
					foreach ($matches[1] as &$param_name) {
						$do_filter = false;
						$is_range = false;
						$param_value = $_GET[$param_name];
						if (isset($param_value) and '' !== $param_value) {
							$this->table_meta['frontend_sql_filter'] = preg_replace("/\[([^{]*){\s*" . $param_name . "\s*}([^\]]*)\]/", "\\1{" . $param_name . "}\\2", $this->table_meta['frontend_sql_filter']); // remove square brackets
							if (!is_array($param_value) or 1 == count($param_value)) {
								if (is_array($param_value)) {
									// integers only
									$param_value = (int)$param_value[0];
								} else if ('-' != $param_value and preg_match("/^(\d+)?\-(\d+)?$/", $param_value, $matches)) {
									// integers only
									$param_value_min = ((NULL !== $matches[1] and '' !== $matches[1])?(int)$matches[1]:0);
									$param_value_max = ((NULL !== $matches[2] and '' !== $matches[2])?(int)$matches[2]:'100000000000000000000'); // greater than MySQL's max unsigned bigint
									if ($param_value_min > $param_value_max) {
										$s = $param_value_min;
										$param_value_min = $param_value_max;
										$param_value_max = $s;
									}
									$this->table_meta['frontend_sql_filter'] = preg_replace("/(=|(<>))\s*{\s*" . $param_name . "\s*}/", '\\2 BETWEEN ' . $param_value_min . ' AND ' . $param_value_max, $this->table_meta['frontend_sql_filter']);
									$this->table_meta['frontend_sql_filter'] = str_replace('<> BETWEEN', ' NOT BETWEEN', $this->table_meta['frontend_sql_filter']);
									$is_range = true;
/*								} else {
									// if {parameter_name} in frontend_sql_filter is not embraced with quotes, do it
									if (!preg_match("/\'[^{\[]*{\s*" . $param_name . "\s*}[^\'\]]*\'/", $this->table_meta['frontend_sql_filter'])) {
										$embrace_qoutes = "'";
									} else {
										$embrace_qoutes = "";
									}*/
								}
								if (!$is_range) {
									$this->table_meta['frontend_sql_filter'] = preg_replace("/{\s*" . $param_name . "\s*}/", "'" . mysqli_real_escape_string($this->conn, $param_value) . "'", $this->table_meta['frontend_sql_filter']);
								//	$this->table_meta['frontend_sql_filter'] = preg_replace("/{\s*" . $param_name . "\s*}/", $embrace_qoutes . mysqli_real_escape_string($this->conn, $param_value) . $embrace_qoutes, $this->table_meta['frontend_sql_filter']);
								}
								$do_filter = true;
							} else {
								// only integer and not empty values allowed if a parameter is array:
								// type_id IN (1,2,3) or type_id = 1 if only one value (see above 1 == count($param_value))
								$values_set = '';
								foreach ($param_value as &$param_value) {
									if ((int)$param_value) {
										$values_set .= (int)$param_value . ',';
									}
								}
								unset($value);
								if ($values_set) {
									$this->table_meta['frontend_sql_filter'] = preg_replace("/(=|(<>))\s*{\s*" . $param_name . "\s*}/", '\\2 IN (' . rtrim($values_set, ',') . ')', $this->table_meta['frontend_sql_filter']);
									$this->table_meta['frontend_sql_filter'] = str_replace('<> IN', ' NOT IN', $this->table_meta['frontend_sql_filter']);
									$do_filter = true;
								}
							}
						} 
						if (!$do_filter) {
							// skip filtering in square brackets if SQL contains parameter name which is not defined in GET
							// example: [service_group_id = {service_group}]
							$this->table_meta['frontend_sql_filter'] = preg_replace("/\[[^{]*{\s*" . $param_name . "\s*}[^\]]*\]/", '1', $this->table_meta['frontend_sql_filter'], -1, $preg_replace_count);
							if (0 == $preg_replace_count) {
								$do_run_query = false;
								break; 
							}
						}
					}
					unset($param_name);
// echo $this->table_meta['frontend_sql_filter'];
				}
				// ! todo
				//
				// если фильтровать записи по external полю (таблица подключется через LEFT JOIN),
				// то _значения этого поля в выборке тоже будут отфильтрованы (LEFT JOIN участвует и в фильтрации и в выборке)
				$this->sql_filter = '(' . $this->table_meta['frontend_sql_filter'] . ')';
			}
			if ($this->table_meta['frontend_sql_order']) {
				$this->sql_order = $this->table_meta['frontend_sql_order'];
			}
			
			if ($do_run_query and $this->get_table_records()) {
				if (!$record_id) $this->count_records();
				
				foreach($this->record_meta as $field => &$meta) {
					 // for typo
					if ($meta['type'] == '' or $meta['type'] == 'calc') {
						$this->field_types[$field] = 'text';
					} else if (0 === strpos($meta['type'], 'lookup')) {
						$this->field_types[$field . '_lookup'] = 'text';
					} else {
						$this->field_types[$field] = $meta['type'];
					}
					
					// for page title
					if ($meta['main']) {
						$this->title_field_name = $field;
					}
				}
				unset($meta);
			} else {
				return false;
			}
			return true;
		} else {
			return false;
		}
	}

	function MetaTableSiteLink($table, $site_id, $record_id, $master_table = NULL, $master_id = NULL, $page = 1, $conn = NULL, $lang_id = '') {
		parent::MetaTable($table, $site_id, $record_id, true, NULL, $master_table, $master_id, NULL, NULL, NULL, $conn, $lang_id);
		
		$this->page = $page;
		$this->field_types = array();
	}
	
	var $page;

	var $field_types;
	var $title_field_name;
}
?>