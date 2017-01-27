<?
class CustomEditor extends Editor {

	function validate_input() {
	
		$this->set_record_meta('article_type_id', array('required' => false));
		
		if (parent::validate_input()) {
			return true;
		} else {
			return false;
		}
	}
		

}
?>