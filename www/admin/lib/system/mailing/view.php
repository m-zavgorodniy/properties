<?
class CustomView extends View {

	function init() {
		if (MetaTable::init()) {
			$this->make_main_toolbar($this->toolbars['main'] = new Toolbar());

			if ($this->record['send']) {
				$this->sub_query = array();
			} else {
				$this->get_sub_queries();
				$this->make_sub_toolbar($this->toolbars['sub'] = new Toolbar());
			}

			return true;
		} else {
			return false;
		}
	}

	function make_main_toolbar(&$toolbar) { 
		parent::make_main_toolbar($toolbar);

		$toolbar->add_button("mailing_preview.php?id=" . $this->id, "images/icons/page_gear.png", "Просмотреть");
		if ($this->record['send']) {
			$toolbar->remove_button(0);
			$toolbar->remove_button(1);
		} else {
			$toolbar->add_button("edit.php?type=mailing_test&id=" . $this->id, "images/icons/user_go.png", "Отправить тест");
			$toolbar->add_button("edit.php?type=mailing_send&id=" . $this->id, "images/icons/email_go.png", "Отправить подписчикам");
		}
	}

}
?>