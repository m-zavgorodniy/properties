<?
class CustomList extends CList {

	function CustomList($meta_table, $site_id) {

		parent::CList($meta_table, $site_id);

		$this->set_sql_filter('meta_table.is_system = ' . ($_GET['system']?1:0));

	}

}
?>