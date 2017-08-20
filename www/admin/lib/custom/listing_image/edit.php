<?
class CustomEditor extends Editor {

	function on_update_success() {
		
		// this picture must be the very first listing's picture to set it as a main

		// !! todo - this not affects if sort order is changed in grid

		$rs = db_mysql_query("SELECT id FROM listing_image WHERE listing_id = (SELECT listing_id FROM listing_image WHERE id = " . $this->id . " LIMIT 1) ORDER BY sort_num LIMIT 1", $this->conn);
		$row = mysqli_fetch_row($rs);
		mysqli_free_result($rs);

		if ($row and $row[0] != $this->id) {
			parent::on_update_success();
			return;
		}
		
		$thumbnail_path = $_SERVER['DOCUMENT_ROOT'] . (!$config['GALLERY_THUMBNAIL_ALT_PATH']?
			(dirname($this->input_params['img_src_original']) . '/' . ($config['GALLERY_THUMBNAIL_DIR_NAME']?$config['GALLERY_THUMBNAIL_DIR_NAME']:'.resize')):$config['GALLERY_THUMBNAIL_ALT_PATH']);
		if (!file_exists($thumbnail_path) and !@mkdir($thumbnail_path)) {
			$this->alert .= "Ошибка при создании директории (Error creating thumbnail directory ".$thumbnail_path .")\n";
		} else {
			// nb! the sizes of the image are in the main configuration file
			if (false === ($listing_main_image = create_thumbnail($_SERVER['DOCUMENT_ROOT'] . $this->input_params['img_src_original'], $thumbnail_path . '/' . basename($this->input_params['img_src_original']))) or false === ($listing_thumb_image = create_thumbnail($_SERVER['DOCUMENT_ROOT'] . $this->input_params['img_src_original'], $thumbnail_path . '/' . basename($this->input_params['img_src_original']), 70, 70))) {
				$this->alert .= "Ошибка при создании уменьшенного изображения (Error creating thumbnail in ".$thumbnail_path .")\n";
			} else {
				$rs = db_mysql_query("SELECT listing_id FROM listing_image WHERE id = " . $this->id, $this->conn);
				if ($row = mysqli_fetch_row($rs)) {
					$r = db_mysql_query("UPDATE listing SET img_src = '" . mysqli_real_escape_string($this->conn, $listing_main_image) . "',  img_src_thumb = '" . mysqli_real_escape_string($this->conn, $listing_thumb_image) . "' WHERE id = " . $row[0], $this->conn);
					if ($r !== true) {
						$this->alert .= "Ошибка (Error updating listing: " . $r . ")\n";
					} else {
						parent::on_update_success();
					}
				}
				mysqli_free_result($rs);
			}
		}
	}
}
?>