<?
class CustomView extends View {

	function make_main_toolbar(&$toolbar) {

		parent::make_main_toolbar($toolbar);
		
		if ($this->record['type_id'] == '') {
			$toolbar->add_button("edit.php?type=seo_parameter_gen&id=" . $this->id, "images/icons/gear_big.png", "Сформировать значения");
		}

	}

}
?>