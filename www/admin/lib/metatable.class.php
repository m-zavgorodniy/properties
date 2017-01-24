<?
require_once (defined('BACK_OFFICE_PATH')?(BACK_OFFICE_PATH . '/'):'') . "lib/tablerows.class.php";

class MetaTable {
	
	function init() {
		if ($this->get_table_meta()) {
			$this->get_site_langs();

			if (defined('ACCESS_ONLY')) { // comes from access.php
				$access_only = array_map('trim', explode(',', ACCESS_ONLY));
				if (!in_array($this->table, $access_only)) {
					$this->table_meta['editable'] = $this->table_meta['deletable'] = $this->table_meta['sortable'] = 0;
				}
			}
			if ($this->is_list)
				$this->count_records();
			else
				$this->get_table_records();
			return true;
		} else {
			return false;
		}
	}
	
	function get_table_meta() {
		$rs = db_mysql_query("SELECT id table_meta, table_name, depends_on_site, filter_data_by_meta_table, sql_filter,
								title, sortable, editable, deletable, searchable, multi_lang,
								is_in_site_tree, is_many2many,
								title_list, title_addnew, title_in_delete_confirm,
								frontend_onpage_num, frontend_sql_filter, frontend_sql_order
							  FROM meta_table 
							  WHERE id = '" . mysqli_real_escape_string($this->conn, $this->table) . "'", $this->conn);
		if ($this->table_meta = mysqli_fetch_assoc($rs)) {
			$r = true;
		}
		mysqli_free_result($rs);
		return $r?true:false;
	}
	
	function count_records() {
		$this->get_table_records(true);
	}
	
	function get_table_records($count_only = false) { // also sets $records and $record_meta 
		$record_meta = array();
		
		$rs_field = db_mysql_query("SELECT f.id field_id, f.field, f.title, f.type, f.type_extra, f.required, f.comment, f.default_value, f.published, f.readonly, f.multi_lang, f.lookup_multi, f.lookup_filter, f.lookup_quick_add,
										(SELECT table_name FROM meta_table WHERE id = l.meta_table_id) lookup_meta_table, l.field lookup_meta_table_field, l.multi_lang lookup_multi_lang,
										(SELECT table_name FROM meta_table WHERE id = f.lookup_external_meta_table_id) lookup_external_table,
										f.is_in_subquery, IFNULL(f.in_subquery_title, f.title) in_subquery_title, f.in_subquery_colnum, f.in_subquery_wide,
										f.default_order_num, f.is_title, f.sql_value,
										f.meta_table_field_group_id field_group_id, g.title field_group,
										u.title unit
								    FROM meta_table_field_group g, meta_table_field f
								    LEFT JOIN meta_table_field l ON l.id = f.lookup_meta_table_field_id
									LEFT JOIN unit u ON u.id = f.unit_id
								    WHERE g.id = f.meta_table_field_group_id AND f.meta_table_id = '" . mysqli_real_escape_string($this->conn, $this->table) . "' AND f.published <> 0
								    ORDER BY " . ($this->is_list?"f.in_subquery_colnum,":"") . "g.sort_num, f.sort_num", $this->conn);

		if ($this->table_meta['sql_filter']) {
			$this->sql_filter = $this->table_meta['sql_filter'] . ($this->sql_filter?' AND (' . $this->sql_filter . ')':'') ;
		}

		$res = "SELECT ";
		if ($count_only) {
			$res .= "COUNT(*) count";
			// quick and dirty counting when filtering by external (many-to-many) fields at the front end
			if ($this->is_front and $this->sql_filter) {
				$lookup_join = "";
				while ($row = mysqli_fetch_assoc($rs_field)) {
					if ('lookup_external' == $row['type_extra'] and false !== strpos($this->sql_filter, $row['field'])) {
						$lookup_join .= " LEFT JOIN `" . $row['lookup_external_table'] . "` ON `" . $row['lookup_external_table'] . "`.`" . $this->table_meta['table_name'] . "_id` = `" . $this->table_meta['table_name'] . "`.id";
					}
				}
			}
		} else {
			if ($this->is_list) {
				$res .= "`" . $this->table_meta['table_name'] . "`.id,";
			}
			$lookup_join = "";
			$subquery_order = array();
			$alias_counter = 1;
			while ($row = mysqli_fetch_assoc($rs_field)) {
				if (!$this->is_list or $row['is_in_subquery'] or $row['is_title'] or $this->is_front) {
					$field = $row['field'];
					if ((!($this instanceof Editor and !$row['readonly']) or $this instanceof DeletePreview) and ($row['type_extra'] == 'lookup' and !empty($row['lookup_meta_table_field']) or $row['type_extra'] == 'lookup_custom') or $row['type_extra'] == 'lookup_external' and !empty($row['lookup_external_table'])) {
						if ($row['type_extra'] == 'lookup_custom') {
							$row['lookup_meta_table'] = 'meta_table_field_option';
							$row['lookup_meta_table_field'] = 'title';
						}
						if ($row['type_extra'] == 'lookup_external') {
							$lookup_join .= " LEFT JOIN `" . $row['lookup_external_table'] . "` ON `" . $row['lookup_external_table'] . "`.`" . $this->table_meta['table_name'] . "_id` = `" . $this->table_meta['table_name'] . "`.id";
						}
						$lookup_join .= " LEFT JOIN `" . $row['lookup_meta_table'] . "` ";
		
						$lookup_meta_table_alias = "m" . $alias_counter++;
						$lookup_join .= $lookup_meta_table_alias;
		
						if (!$row['lookup_multi'] and $row['type_extra'] != 'lookup_external') {
							$lookup_join .= " ON `" . $this->table_meta['table_name'] . "`.`" . $field . "` = `" . $lookup_meta_table_alias . "`.id";
							$res .= "`" . $lookup_meta_table_alias . "`.`" . $row['lookup_meta_table_field'] . (($this->front_lang_id and $row['lookup_multi_lang'])?'_'.$this->front_lang_id:"") . "` `" . $field . "_lookup`,";
						} else {
							$is_lookup_multi = true;
							$lookup_join .= " ON ";
							if ($row['type_extra'] != 'lookup_external') {
								if ($row['type_extra'] == 'lookup_custom') {
									$lookup_join .= " `" . $lookup_meta_table_alias . "`.meta_table_field_id = " . $row['field_id'] . " AND ";
								}
								$lookup_join .= "FIND_IN_SET(`" . $lookup_meta_table_alias . "`.id, `" . $this->table_meta['table_name'] . "`.`" . $field . "`)";
							} else {
								$lookup_join .= "`" . $lookup_meta_table_alias . "`.id = `" . $row['lookup_external_table'] . "`.`" . $row['lookup_meta_table'] . "_id` AND " . ($row['lookup_filter']?preg_replace("/(^|\s)" . $row['lookup_meta_table'] . "\./", "\\1" . $lookup_meta_table_alias . ".", $row['lookup_filter']):"1");
							}
							if ($this->front_lang_id and $row['lookup_multi_lang']) {
								$lang_postfix = '_' . $this->front_lang_id;
							} else {
								$lang_postfix = '';
							}
							$res .= "GROUP_CONCAT(DISTINCT `" . $lookup_meta_table_alias . "`.`" . $row['lookup_meta_table_field'] . $lang_postfix . "` ORDER BY `" . $lookup_meta_table_alias . "`.`" . $row['lookup_meta_table_field'] . $lang_postfix . "` SEPARATOR ', ') `" . $field . "_lookup`,";
						}
						if ($row['type_extra'] != 'lookup_external') {
							$res .= "`" . $this->table_meta['table_name'] . "`.`" . $field . "`";
						} else {
							$res .= "GROUP_CONCAT(DISTINCT `" . $lookup_meta_table_alias . "`.id ORDER BY `" . $lookup_meta_table_alias . "`.`" . $row['lookup_meta_table_field'] . "` SEPARATOR ',') `" . $field . "`"; // nb! no space after comma in ','
						}
						
						$lookup_meta_table_alias = false;
					} else if ($row['type_extra'] == 'datetime' or $row['type_extra'] == 'date') {
						$res .= "IF (YEAR(`" . $this->table_meta['table_name'] . "`.`" . $field . "`) = '0000', NULL, DATE_FORMAT(`" . $this->table_meta['table_name'] . "`.`" . $field . "`, '" . ($this->is_front?'%Y-%m-%d':get_date_format()) . ($row['type_extra'] == 'datetime'?' %H:%i':'') . "')) `" . $field . "`";
					} else if ($row['type_extra'] == 'calc' or $row['type_extra'] == 'calc_boolean' or $row['type_extra'] == 'calc_view') {
						// todo. maybe. sql filter by calculated fields

						// if sql_value contains a select from joined table it doesn't work in Editor as it doesn't join tables, it uses IDs+lookups
						// todo! a quick workaround for now
						if (!($this instanceof Editor and false !== stripos($row['sql_value'], ' from '))) {
							$res .= "(" . $row['sql_value'] . ") `" . $field . "`";
						} else {
							$res .= "1";
						}
					} else {
						$res .= "`" . $this->table_meta['table_name'] . "`.`" . $field . (($this->front_lang_id and $row['multi_lang'])?'_'.$this->front_lang_id."` `" . $field . "`":"`");
						if (!$this->is_front and $row['multi_lang'] and $this->site_langs_extra) {
							foreach($this->site_langs_extra as $lang_id => &$lang_extra) {
								$res .= ", `" . $this->table_meta['table_name'] . "`.`" . $field . "_" . $lang_id . "`";
							}
							unset($lang_extra);
						}
					}
					
					$res .= ",";
					if (!empty($row['default_order_num'])) {
						$order_num = $row['default_order_num'];
						while (array_key_exists($order_num, $subquery_order)) {
							$order_num++;
						}
						$subquery_order[$order_num] = $field;
					}
					if ($this->is_list) {
						$field_meta['title'] = $row['in_subquery_title'];
						$field_meta['wide'] = $row['in_subquery_wide'];
						// !! hardcode - rating
						$field_meta['order_desc'] = (strpos($row['type_extra'], 'date') === 0 or 'rating' == $field);
					} else {
						$field_meta['field_id'] = $row['field_id'];
						$field_meta['field_group_id'] = $row['field_group_id'];
						$field_meta['field_group'] = $row['field_group'];
						$field_meta['title'] = $row['title'];
						$field_meta['published'] = $row['published'];
						$field_meta['required'] = $row['required'];
						$field_meta['comment'] = $row['comment'];
						$field_meta['default'] = $row['default_value'];
						$field_meta['lookup_meta_table'] = $row['lookup_meta_table'];
						$field_meta['lookup_field'] = $row['lookup_meta_table_field'];
						$field_meta['lookup_external_table'] = $row['lookup_external_table'];
						$field_meta['lookup_multi'] = $row['lookup_multi'];
						$field_meta['lookup_filter'] = $row['lookup_filter'];
						$field_meta['lookup_quick_add'] = $row['lookup_quick_add'];
						$field_meta['readonly'] = ($row['readonly'] or $row['type_extra'] == 'calc' or $row['type_extra'] == 'calc_boolean');
						$field_meta['unit'] = $row['unit'];
						if (!$this->is_front and preg_match("/\((\d+?)(\,|\))/", $row['type'], $matches)) {
							if ((int)$matches[1]) $field_meta['width'] = (int)$matches[1];
						}
					}
					$field_meta['type'] = trim($row['type_extra']);
					$field_meta['main'] = $row['is_title'];
					$field_meta['multi_lang'] = $row['multi_lang'];
					$field_meta['order_num'] = $row['default_order_num'];
					
					if ($field_meta['main']) {
						$field_main = $field;
					}
					$this->record_meta[$field] = $field_meta;
					
					if ($field_meta['multi_lang'] and $this->site_langs_extra) {
						if (!$this->is_list) {
							foreach($this->site_langs_extra as $lang_id => &$lang_extra) {
								$multi_lang_meta = & $this->record_meta[$field.'_'.$lang_id];
								$multi_lang_meta = $field_meta;
								$multi_lang_meta['title'] .= ' (' . $lang_extra . ')';
								$multi_lang_meta['is_extra_lang'] = 1;
								$multi_lang_meta['lang_id'] = $lang_id;
							}
							unset($lang_extra);
						}
					}
				}
			}
			if (!count($subquery_order) and isset($field_main)) {
				$subquery_order[0] = $field_main;
			}
			$res = rtrim($res, ','); // remove trailing comma
		}
		mysqli_free_result($rs_field);
		
		$rs = db_mysql_query("DESC " . $this->table_meta['table_name'], $this->conn);
		while ($row = mysqli_fetch_assoc($rs)) {
			if ('meta_site_lang_id' == $row['Field']) {
				$res .= ", `" . $this->table_meta['table_name'] . "`.meta_site_lang_id";
			}
		}
		mysqli_free_result($rs);
		$res .= " FROM `" . $this->table_meta['table_name'] . "`" . $lookup_join;
		if ($this->id) { // !$this->is_list // single record
			$res .= " WHERE `" . $this->table_meta['table_name'] . "`.id = '" . mysqli_real_escape_string($this->conn, $this->id) . "'";
		} else {
			if ($this->master_id === NULL) { // list of all records
				if ($this->table_meta['filter_data_by_meta_table']) {
					$res .= " WHERE `" . $this->table_meta['table_name'] . "`.meta_table_id = '" . mysqli_real_escape_string($this->conn, isset($_GET['meta_table_id'])?$_GET['meta_table_id']:$this->table) . "'";
				} else {
					$res .= " WHERE 1";
				}
			} else { //if ($many2many_link_table === NULL) { // subquery with master table id


				// !! todo. what's on large tables?

				// $res .= " WHERE `" . $this->table_meta['table_name'] . "`.`" . $this->master_table . "_id` = '" . mysqli_real_escape_string($this->conn, $this->master_id) . "'";
				$res .= " WHERE FIND_IN_SET('" . mysqli_real_escape_string($this->conn, $this->master_id) . "', `" . $this->table_meta['table_name'] . "`.`" . $this->master_table . "_id`)" . ($this->table_meta['filter_data_by_meta_table']?" AND `" . $this->table_meta['table_name'] . "`.meta_table_id = '" .  $this->table . "'":'');

				
		/*	} else { // many to many subquery
				$res .= ",`" . $many2many_link_table . "`";
				$res .= " WHERE `" . $many2many_link_table . "`.`" . $master_table . "_id` = '" . mysqli_real_escape_string($this->conn, $this->id) . "' AND `" . $this->table_meta['table_name'] . "`.id = `" . $many2many_link_table . "`.`" . $this->table_meta['table_name'] . "_id`";*/
			}
		}
		if ($this->is_front and $this->table_meta['multi_lang']) {
			$res .= " AND (`" . $this->table_meta['table_name'] . "`.meta_site_lang_id = '" . $this->front_lang_id . "' OR FIND_IN_SET('" . $this->front_lang_id . "', `" . $this->table_meta['table_name'] . "`.meta_site_lang_id))";
		}
		if ($this->table_meta['depends_on_site']) {
			$res .= " AND `" . $this->table_meta['table_name'] . "`.meta_site_id = '" . mysqli_real_escape_string($this->conn, $this->site_id) . "'";
		}
		if ($this->sql_filter) { //if ($this->sql_filter !== NULL) {
			$res .= " AND " . $this->sql_filter;
		}
		if (!$count_only) {
			if ($is_lookup_multi) {
				$res .= " GROUP BY `" . $this->table_meta['table_name'] . "`.id";
			}
			if (!$this->id) { // added
				$res .= " ORDER BY ";
				if (!empty($this->sql_order)) {
					$res .= $this->sql_order;
				} else if (count($subquery_order) > 0) {
					ksort($subquery_order);
					foreach($subquery_order as $order_field) {
						$res .= "`" . $this->table_meta['table_name'] . "`.`" . $order_field . "`" . ($this->record_meta[$order_field]['order_desc']?" DESC":"") . ",";
					}
					unset($order_field);
					$res = rtrim($res, ','); // remove trailing comma
				} else {
					$res .= "1";
				}
				if ($this->is_list and $this->records_on_page) {
					$res .= " LIMIT " . ($this->records_from - 1) . ", " . $this->records_on_page;
				}
			}
		}
//	echo $res . '<br><br>';
/*		$this->records = array();
		$rs = db_mysql_query($res, $this->conn);
		while ($row = mysqli_fetch_assoc($rs)) {
			$this->records[] = $row;
		}
		mysqli_free_result($rs);
		$this->record = $this->records[0];*/
		
		if (!$this->is_new) { // is_new is set if type of object is Editor (?)
			// todo!!!
			// если условие по вычисляемому полю - то оно должно быть вычислено и тут
			// например - is_suburb = (SELECT is_suburb FROM loc_city WHERE loc_city.id = listing.loc_city_id)
			// => ошибка SQL:
			// SELECT COUNT(*) count FROM `listing` WHERE 1 AND (listing.listing_status_id = 1 AND listing.listing_type_id = '1' AND listing.property_type_id = '1' AND listing.loc_region_id = '1' AND is_suburb = '1')
			// или считать по FOUND_ROWS()
			$rs = db_mysql_query($res, $this->conn);
			if ($count_only) {
				if ($row = mysqli_fetch_row($rs)) {
					$this->rec_count = $row[0];
					$r = true;
				}
			} else {
				while ($row = mysqli_fetch_assoc($rs)) {
					$this->records[$row['id']] = $row;
					$r = true;
				}
//				$this->rec_count = count($this->records);
				if (true === $r) {
					$this->record = current($this->records);
				}
			}
			mysqli_free_result($rs);
		}
		
		return $r; 
	/*
	single (with lookup)
	SELECT s.*, t.name section_type_id FROM section s, section_type t WHERE s.id = $id AND s.section_type_id = t.id
	
	subquery
	SELECT s.id, s.title, s.dir, s.sort_num, s.published, s.section_type_id, t.name section_type_id
				 FROM section s, section_type t
				 WHERE s.section_type_id = t.id AND s.section_id = $id
				 ORDER BY s.sort_num, s.title
	 
	many to many subquery
	SELECT f.id, f.name title, f.published
				  FROM news_folder f, news_folder2section nfs
				  WHERE nfs.section_id = $id AND f.id = nfs.news_folder_id
				  ORDER BY f.id
	*/
	}

	function set_table_meta($values) { // $values is array
		foreach ($values as $meta_id => $value) {
			$this->table_meta[$meta_id] = $value;
		}
		unset($value);
	}
	
	function set_record_meta($field, $values) { // $values is array
		foreach ($values as $meta_id => $value) {
			$this->record_meta[$field][$meta_id] = $value;
		}
		unset($value);
	}
	
	function remove_record_meta($field) {
		unset($this->record_meta[$field]);
	}

	function clear_record_meta() {
		$this->record_meta = array();
	}

	function get_sub_queries() {
		$this->sub_query = array();
		$this->sub_query_meta = array();
		if ('section' == $this->table and $this instanceof View) { // show only linked with section_type sub tables
			$rs = db_mysql_query("SELECT t2t.detail_meta_table_id FROM meta_table2section_type t2s, meta_table2table t2t, section s WHERE t2s.meta_table_id = t2t.many2many_meta_table_id AND s.section_type_id = t2s.section_type_id AND s.id = " . $this->id, $this->conn);
			while ($row = mysqli_fetch_row($rs)) {
				$tables_linked_to_section_type[$row[0]] = $row[0];
			}
			mysqli_free_result($rs);
		}
		$rs = db_mysql_query("SELECT detail_meta_table_id meta_table,
							 	title_subquery, title_addnew, many2many_meta_table_id many2many_table,
								is_bookmark,
								condition_field, condition_value,
								(SELECT sql_filter FROM meta_table WHERE meta_table.id = meta_table2table.detail_meta_table_id) sql_filter
							  FROM meta_table2table
							  WHERE meta_table_id = '" . mysqli_real_escape_string($this->conn, $this->table) . "'
							  ORDER BY sort_num", $this->conn);
		while ($row = mysqli_fetch_assoc($rs)) {
			$condition_values = explode(',', $row['condition_value']);
			if ($row['condition_field'] and $row['condition_value'] and !in_array($this->record[$row['condition_field']], $condition_values)) {
				continue;
			}
			if ('section' == $this->table and 'article' != $row['meta_table'] and 'section' != $row['meta_table'] and !$tables_linked_to_section_type[$row['meta_table']]) {
				continue;
			}
			
			$table_meta = $row['meta_table'];
			$this->sub_query_meta[$table_meta] = $row;
			$sub_query = new TableRows($table_meta, $this->site_id, $row['sql_filter'], $this->table_meta['table_name'], $this->id, $row['many2many_table'], $_GET[$table_meta . '_from'], $this->conn);
			if ($sub_query->init()) { // only count records if bookmark  /// $sub_query->init($row['is_bookmark'])
				$this->sub_query[$table_meta] = $sub_query;
			}
		}
		mysqli_free_result($rs);
	}

	function get_site_path() {
		$site_path = '/';
		$rs = db_mysql_query("SELECT path FROM meta_site WHERE id = '" . mysqli_real_escape_string($this->conn, $this->site_id) . "'", $this->conn);
		if ($row = mysqli_fetch_row($rs)) {
			$site_path .= trim($row[0], '/');
		}
		mysqli_free_result($rs);
		return $site_path;
	}
	
	function get_site_langs() {
		// default language
		$rs = db_mysql_query("SELECT lang_title FROM meta_site WHERE id = '" . mysqli_real_escape_string($this->conn, $this->site_id) . "'", $this->conn);
		if ($row = mysqli_fetch_row($rs)) {
			$site_lang = $row[0];
		}
		mysqli_free_result($rs);
		
		$this->site_langs_all = array('' => $site_lang);
		
		// extra languages
		$res = array();
		$rs = db_mysql_query("SELECT id, title FROM meta_site_lang WHERE meta_site_id = '" . mysqli_real_escape_string($this->conn, $this->site_id) . "'", $this->conn);
		while ($row = mysqli_fetch_assoc($rs)) {
			$res[$row['id']] = $row['title'];
		}
		mysqli_free_result($rs);
		
		$this->site_langs_extra = $res;
		$this->site_langs_all = array_merge($this->site_langs_all , $this->site_langs_extra);
	}

	function set_sql_filter($filter) {
		$this->sql_filter = $filter;
	}

	function set_order($order_table_name, $order, $direction = 'asc', $order_field_type = '') {
		if ($order_field_type == 'date' or $order_field_type == 'datetime') {
			$this->sql_order = "`" . $order_table_name . "`.`". $order . "`" . " " . $direction;
		} else {
			$this->sql_order = "`" . $order . "` " . $direction;
		}
	}

	function MetaTable($table, $site_id, $id = NULL, $is_list = false, $sql_filter = NULL, $master_table = NULL, $master_id = NULL, $many2many_table = NULL, $records_from = NULL, $records_on_page = NULL, $conn = NULL, $front_lang_id = '') {
		if (!$conn) {
			$this->conn = db_mysql_connect();
			register_shutdown_function('mysqli_close', $this->conn);
		} else {
			$this->conn = $conn;
		}
		$this->table = $table;
		$this->id = $id;
		$this->site_id = $site_id;
		
		$this->is_list = $is_list;
		$this->sql_filter = $sql_filter;
		
		// !! hardcode for moscowkey
		// !! TODO - filtering of lists in viewlist.php
		if ($this instanceof TableRows and 'listing' == $this->table) {
			$this->sql_filter .= ($this->sql_filter?' AND ':'');
			if ($_GET['import']) {
				$this->sql_filter .= 'listing.agent_source IS NOT NULL';
			} else {
				$this->sql_filter .= 'listing.agent_source IS NULL';
			}
			if (ADMIN_LOGIN != $_SESSION['admin']) {
				$this->sql_filter .= ' AND listing.user_id = ' . $_SESSION['admin_id'];
			}
		}

		$this->master_id = $master_id;
		$this->master_table = $master_table;
		$this->many2many_table = $many2many_table;
		
		$this->records_on_page = $records_on_page;
		$this->records_from = (int)$records_from?(int)$records_from:1;

		$this->is_front = $this instanceof MetaTableSiteLink;
		$this->front_lang_id = $front_lang_id;
	}

	var $conn;
	var $table;
	var $id;
	var $site_id;
	var $site_langs_all;
	var $site_langs_extra;

	var $table_meta;
	var $records;
	var $record;
	var $record_meta;

	var $records_on_page;
	var $records_from;

	var $is_list;
	var $master_id;
	var $master_table;
	var $many2many_table;

	var $sql_filter;
	var $sql_order;

	var $rec_count;

	var $sub_query;
	var $sub_query_meta;

	var $is_front;
	var $front_lang_id;
}
?>