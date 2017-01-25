<?
class CustomEditor extends Editor {

function init() {
	if (parent::init()) {
		$this->set_record_meta('title', array('default' => $this->id));
		$this->set_record_meta('new_meta_table', array('title' => "В новую таблицу", 'required' => true));

		return true;
	} else {
		return false;
	}
}

function insert() {
	// it's IS_NEW. to move to inserted_id
	$new_table = mysqli_real_escape_string($this->conn, $this->post_params['new_meta_table']);

	db_mysql_query("START TRANSACTION", $this->conn);
	$query = "insert into meta_table (id, table_name, depends_on_site, title, sortable, editable, deletable, is_many2many, title_list, title_addnew, title_in_delete_confirm)
			  select '" . $new_table . "', table_name,  depends_on_site, title, sortable, editable, deletable, is_many2many, title_list, title_addnew, title_in_delete_confirm 
			  from meta_table where id = '" . mysqli_real_escape_string($this->conn, $this->id) . "'";
	if (true === ($r = db_mysql_query($query, $this->conn))) { 
		$query = "insert into meta_table2table (meta_table_id, detail_meta_table_id, many2many_meta_table_id, sort_num, title_subquery, title_addnew, is_bookmark) 
				  select '" . $new_table . "', detail_meta_table_id, many2many_meta_table_id, sort_num, title_subquery, title_addnew, is_bookmark 
				  from meta_table2table where meta_table_id = '" . mysqli_real_escape_string($this->conn, $this->id) . "'"; 
		if (true === ($r = db_mysql_query($query, $this->conn))) {
			$rs = db_mysql_query("select id, field, '" . $new_table . "', title, title_en, meta_table_field_group_id, type, type_extra, lookup_multi, nullable, lookup_meta_table_field_id, lookup_external_meta_table_id, lookup_filter, required, sort_num, comment, default_value, published, readonly, is_title, is_in_subquery, in_subquery_wide, default_order_num, in_subquery_colnum, in_subquery_title, editable, multi_lang, sql_value, unit_id
					  from meta_table_field where meta_table_id = '" . mysqli_real_escape_string($this->conn, $this->id) . "'", $this->conn);
			while ($row = mysqli_fetch_assoc($rs)) {
				$old_field_id = $row['id'];
				unset($row['id']);
				foreach($row as $field => &$value) {
					if (in_array($field, array('type_extra', 'lookup_meta_table_field_id', 'lookup_external_meta_table_id', 'comment', 'default_value', 'default_order_num', 'in_subquery_colnum', 'in_subquery_title', 'sql_value', 'unit_id')) and $value == '') {
						$value = "NULL";
					} else {
						$value = "'".mysqli_real_escape_string($this->conn, $value)."'";
					}
				}
				unset($value);
				echo $query = "insert into meta_table_field (field, meta_table_id, title, title_en, meta_table_field_group_id, type, type_extra, lookup_multi, nullable, lookup_meta_table_field_id, lookup_external_meta_table_id, lookup_filter, required, sort_num, comment, default_value, published, readonly, is_title, is_in_subquery, in_subquery_wide, default_order_num, in_subquery_colnum, in_subquery_title, editable, multi_lang, sql_value, unit_id) VALUES (" . implode(",", $row) . ")";
				if (true !== ($r = db_mysql_query($query, $this->conn))) break;																																																																																									  				$new_field_id = current(mysqli_fetch_row(db_mysql_query("SELECT LAST_INSERT_ID()", $this->conn)));
				
				$query = "insert into meta_table_field_option (meta_table_field_id, title, title_en, img_src, is_group_title, sort_num, published)
						  select " . $new_field_id . ", title, title_en, img_src, is_group_title, sort_num, published
						  from meta_table_field_option where meta_table_field_id = " . $old_field_id; 
				if (true !== ($r = db_mysql_query($query, $this->conn))) break;
			}
			mysqli_free_result($rs);
		}
	}
	if ($r === true) {
		db_mysql_query("COMMIT", $this->conn);
		$this->table = "meta_table";
		$this->inserted_id = $new_table;
	} else {
		db_mysql_query("ROLLBACK", $this->conn);
	}
	return $r;
}

}
?>
