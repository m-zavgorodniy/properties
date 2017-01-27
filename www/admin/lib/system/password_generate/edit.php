<?
require $_SERVER['DOCUMENT_ROOT'] . "/lib/mail.php";

class CustomEditor extends Editor {

	function init() {
		if (parent::init()) {
			$this->set_alert("Новый пароль будет сгенерирован автоматически и отправлен на e-mail пользователя. С этого момента старый пароль пользователя будет недействителен.");

			$this->is_send = true;

			return true;
		} else {
			return false;
		}
	}
	
	function update() {
		$pass = generate_password();
		$salt = generate_passkey();
		
		db_mysql_query("START TRANSACTION", $this->conn); // rollback if error occurs while sending new password to user
		$res = db_mysql_query("UPDATE user SET password = '" . md5($salt . $pass) . "', passkey = '" . mysql_real_escape_string($salt) . "' WHERE id = " . $this->id, $this->conn);
		if ($res === true) {
			$message = "Здравствуйте, " . $this->input_params['name'] . " " . $this->input_params['surname'] . ".\r\n\r\nВаш новый пароль: " . $pass;
			if (!@mail_send($this->input_params['email'], "Новый пароль", $message)) {
				global $config_mail;
				$res = "Error sending message via SMTP on " . $config_mail['smtp_host'] . ":" . $config_mail['smtp_port'];
			}
		}
		if ($res === true) {
			db_mysql_query("COMMIT", $this->conn);
		} else {
			db_mysql_query("ROLLBACK", $this->conn);
		}
		return $res;
	}
	
	function on_update_success() { 
		$this->set_table_meta(array('editable' => 0)); 
		$this->set_alert('');?>

		<div class="info">
			Пароль успешно отправлен.
		</div>
<?	}

}
?>
