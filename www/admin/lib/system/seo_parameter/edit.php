<?
class CustomEditor extends Editor {

	function get_init_input() {
		
		parent::get_init_input();
	
		// copy is in meta_field/edit.php
		$this->set_record_meta('meta_table_field_id', array('sql_custom' => "SELECT f.id, CONCAT(t.title,' : ',f.title, IF(is_system, ' (системная таблица)', '')) title FROM meta_table t, meta_table_field f WHERE f.meta_table_id = t.id AND f.type_extra IS NULL ORDER BY 2")); // (f.field = 'title' OR f.field = 'name' OR f.field = 'login' OR f.field = 'company') // AND t.is_system = 0

		$this->set_record_meta('type_id', array('type' => "lookup", 'options_custom' => array(
			 '' => "Обычный (url: /<название параметра>-<id или текстовое значение>/)",
			 'boolean' => "Да/Нет (url: /<название параметра>/)",
			 'numeric' => "Числовой (url: /<название параметра>-<число или диапазон>/)"
		 )));
	}

	function render() {
		parent::render(); ?>
		
		<script type="text/javascript">
			jQuery(function() {
				var type_id_select = jQuery("[name='type_id']");
				var field_id_select = jQuery("[name='meta_table_field_id']");
				type_id_select
					.change(function() {
						var type_id = jQuery("[name='type_id']").closest("tr");
						var meta_table_field_id = jQuery("[name='meta_table_field_id']").closest("tr");
						var is_multi_value = jQuery("[name='is_multi_value']").closest("tr");
						var type_id_select_val = jQuery(":selected", type_id_select).val();
						
						if ('' == type_id_select_val) {
							meta_table_field_id.css("display", "table-row");
						} else {
							meta_table_field_id.css("display", "none");
						}
						if ('boolean' == type_id_select_val) {
							is_multi_value.css("display", "none");
						} else {
							is_multi_value.css("display", "table-row");
						}
						field_id_select.triggerHandler("change");
					})
					.each(function() {type_id_select.triggerHandler("change");field_id_select.triggerHandler("change");});
				
				field_id_select
					.change(function() {
						var $titles = jQuery("[name^='title']").closest("tr");
						var field_id_select_val = jQuery(":selected", field_id_select).val();
						var type_id_select_val = jQuery(":selected", type_id_select).val();
						if (('' != type_id_select_val) || ('' == field_id_select_val)) {
							$titles.css("display", "table-row");
						} else {
							$titles.css("display", "none");
						}
					})
					.each(function() {field_id_select.triggerHandler("change");});

			});
        </script>
<?	}

	function validate_input() {
		if (parent::validate_input()) {

			if (!preg_match("/^[a-z\-]+$/", $this->input_params['id'])) {
				$this->set_alert("Имя параметра в ЧПУ может содержать только строчные латинские символы и дефисы.");
				return false;
			}
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