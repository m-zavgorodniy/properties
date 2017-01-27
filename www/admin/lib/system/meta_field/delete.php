<?
class CustomDeletePreview extends DeletePreview {

	function check_constraints() {

		return true;
	}

	function on_update_success() {

		// ALTER TABLE `article` DROP `picture_id`
//		if (true !== ($res = db_mysql_query("ALTER TABLE `" . $this->input_params['meta_table_id'] . "` DROP `" . $this->input_params['field'] . "`", $this->conn))) { 
//			$this->set_alert("Ошибка при удалении поля в базе данных (" . $res . ")");
//		} else {
			parent::on_update_success();
//		}
	}

}

?>