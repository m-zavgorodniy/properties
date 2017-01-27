<?
require $_SERVER['DOCUMENT_ROOT'] . "/lib/mail.php";

class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();
		
		if ($this->init_params['sent']) {
			$this->set_table_meta(array('editable' => 0)); 
			$this->alert = 'Письмо отправлено.';
		} else if ($this->init_params['send']) {
			$this->set_table_meta(array('editable' => 0)); 
			$this->alert = 'Письмо находится в очереди отправки.';
		} else if ($this->is_new) {
			$rs = db_mysql_query("SELECT value FROM mailing_setting WHERE id = 'mailing_footer'", $this->conn);
			if ($row = mysql_fetch_row($rs)) {
				$this->set_record_meta('footer', array('title' => 'Текст внизу', 'default' => $row[0]));
			}
			mysql_free_result($rs);
		}
	}
}
?>
