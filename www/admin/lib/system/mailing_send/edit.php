<?
require $_SERVER['DOCUMENT_ROOT'] . "/lib/mail.php";

class CustomEditor extends Editor {

	function init() {
		if (parent::init()) {
			$this->is_send = true;
			
			return true;
		} else {
			return false;
		}
	}

	function get_init_input() {
		parent::get_init_input();
		
		if ($this->init_params['send']) {
			$this->set_table_meta(array('editable' => 0)); 
			$this->alert = 'Письмо находится в очереди отправки.';
		} else {
			$this->alert = 'Письмо будет отправлено подписчикам. Отмена данной операции невозможна.';
		}
	}
	
	function validate_input() {
		if (parent::validate_input()) {
			$this->input_params['mailing_body'] = file_get_contents('http://' . current(explode(':', $_SERVER['HTTP_HOST'])) . '/admin/mailing_preview.php?id=' . $this->id);
			
			$recepients = array();
			$rs = db_mysql_query("SELECT email FROM mailing_list WHERE enabled <> 0", $this->conn);
			while ($row = mysqli_fetch_assoc($rs)) {
				$r = make_mail_recepients($row['email']);
				foreach ($r as &$recepient) {
					$recepients[] = $recepient;
				}
				unset($recepient);
			}
			mysqli_free_result($rs);
			$recepients = array_unique($recepients);
			$this->input_params['mailing_list'] = implode(',', $recepients);

			$this->input_params['send'] = 1;
			
			return true;
		} else {
			return false;
		}
	}
	
	function on_update_success() {
		$this->set_table_meta(array('editable' => 0)); 
		$this->alert = ''; ?>
        
		<div class="info">
			Письмо поставлено в очередь отправки.
		</div>
        <script>
			window.opener.location.reload()
        </script>
<?	}
}
?>
