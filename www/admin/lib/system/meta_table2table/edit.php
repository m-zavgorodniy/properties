<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

/*		$this->set_record_meta('many2many_meta_table_id', array('lookup_filter' => "meta_table.is_system = 0"));
		$this->set_record_meta('detail_meta_table_id', array('lookup_filter' => "meta_table.is_system = 0"));*/

	}

}
?>