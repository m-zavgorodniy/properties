<?
class CustomView extends View {

	function make_main_toolbar(&$toolbar) { 
		parent::make_main_toolbar($toolbar);

		if ($this->id == $_SESSION['admin_id'])
			$toolbar->add_button("edit.php?type=password", "images/icons/key.png", "Сменить пароль");
		else if ($this->record['login'] != ADMIN_LOGIN and $this->table_meta['editable'])
			$toolbar->add_button("edit.php?type=password_generate&id=" . $this->id, "images/icons/key_go.png", "Сгенерировать и выслать пароль");
		
	}

}
?>