<?
class CustomEditor extends Editor {

	function validate_input() {
		if (parent::validate_input()) {

			if (!preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*(\/.*)?$/i', $this->input_params['url']) and !preg_match('/^\//', $this->input_params['url'])) {
				$this->set_alert("Возможны только ссылки по протоколам http или https без указания порта, либо относительные ссылки (начинающиеся с /)");
				return false;
			}
			
//			$this->input_params['url'] = preg_replace('/^http(s?)\:\/\//i', '', $this->input_params['url']);
			return true;
		} else {
			return false;
		}
	}

	function on_update_success() {
		if (!$this->input_params['activated'] and '' == $this->input_params['type_id'] and $this->input_params['meta_table_field_id']) { ?>
			<script type="text/javascript">
				opener.location.reload();
				window.location.href = "edit.php?type=seo_parameter_gen&id=<?=$this->input_params['id']?>"
	        </script>
<?		} else {
			parent::on_update_success();
		}
	}

}
?>