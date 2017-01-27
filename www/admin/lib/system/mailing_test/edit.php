<?
require $_SERVER['DOCUMENT_ROOT'] . "/lib/mail.php";

class CustomEditor extends Editor {

	function init() {
		if (parent::init()) {
			$this->set_record_meta('mailing_list_test', array('title' => "Адрес(а)", 'required' => true, 'type' => 'textarea', 'default' => $_SESSION['email']));
	
			$this->is_send = true;
			
			return true;
		} else {
			return false;
		}
	}
	
	function update() {
		global $config;
		
		$message = file_get_contents('http://' . current(explode(':', $_SERVER['HTTP_HOST'])) . '/admin/mailing_preview.php?id=' . $this->id);

		$recepients = make_mail_recepients($this->input_params['mailing_list_test']);
		foreach ($recepients as &$recepient) {
			if (true !== ($res = @mail_send($recepient, $this->input_params['subject'], str_replace($config['mail']['unsubscribe_by_email_uri'], $config['mail']['unsubscribe_by_email_uri'] . $recepient, $message), true))) {
				return $res;
			}
		}
		return true;
	}
	

	function on_update_success() {
		$this->set_table_meta(array('editable' => 0)); ?>
        
		<div class="info">
			Тестовая рассылка отправлена.
		</div>
<?	}
}
?>
