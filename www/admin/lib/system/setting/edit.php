<?
class CustomEditor extends Editor {

	function get_init_input() {
		parent::get_init_input();

		$this->set_record_meta('value', array('type' => $this->input_params['type'], 'multi_lang' => (int)$this->input_params['multi_lang']));
		
		if (!$this->record_meta['value']['multi_lang']) {
			foreach($this->record_meta as $field => &$meta) {
				if ($meta['is_extra_lang']) {
					$this->remove_record_meta($field);
				}
			}
			unset($meta);
		}
	}

	function validate_input() {
	
		if (parent::validate_input()) {
			if ($this->record_meta['value']['type'] == 'int' and !is_int($this->input_params['value'])) {
				$this->set_alert("Значение должно быть целым числом");
				return false;
			} else if ($this->record_meta['value']['type'] == 'decimal' and (!is_numeric($this->input_params['value']) or !preg_match('/^\d+\.?\d*$/', $this->input_params['value']))) {
				$this->set_alert("Значение должно быть числом (десятичный разделитель - точка)");
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
		

}
?>