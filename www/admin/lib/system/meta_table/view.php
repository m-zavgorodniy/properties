<?
class CustomView extends View {

	function make_main_toolbar(&$toolbar) {

		parent::make_main_toolbar($toolbar);

		if ($this->table_meta['editable']) {
			$toolbar->add_button("edit.php?type=meta_copy&id=" . $this->id . "&new=yes", "images/icons/page_white_copy.png", "Копировать");
		}

	}

}
?>