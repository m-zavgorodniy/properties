<?
class CustomEditor extends Editor {

	function init() {
		$this->id = $_SESSION['admin_id'];
		if (parent::init()) {
			$this->set_record_meta('old_password', array('title' => "Старый пароль", 'required' => true, 'type' => 'password'));
			$this->set_record_meta('new_password', array('title' => "Новый пароль", 'required' => true, 'type' => 'password'));
			$this->set_record_meta('new_password_confirm', array('title' => "Подтвердите пароль", 'required' => true, 'type' => 'password'));
	
			return true;
		} else {
			return false;
		}
	}
	
	function validate_input() {
	
		if (parent::validate_input()) {
			if (!$this->check_password()) { // gets the salt also
				$this->set_alert("Неправильный старый пароль");
				return false;
			} else if ($this->input_params['new_password'] !== $this->input_params['new_password_confirm']) {
				$this->set_alert("Не совпадает подтверждение пароля");
				return false;
			}
			return true;
		} else {
			return false;
		}
		
	}
	
	function update() {
		return db_mysql_query("UPDATE user SET password = '" . md5($this->salt . $this->input_params['new_password']) . "' WHERE id = " . $this->id, $this->conn);
	}
	
	function on_update_success() { 
		$this->remove_record_meta('old_password');
		$this->remove_record_meta('new_password');
		$this->remove_record_meta('new_password_confirm');
		$this->set_table_meta(array('editable' => 0)); ?>
        
		<div class="info">
			Пароль успешно изменен.
		</div>
<?	}

	function check_password() {
		$rs = db_mysql_query("SELECT password, passkey FROM user WHERE id = " . $this->id, $this->conn);
		if ($row = mysqli_fetch_assoc($rs)) {
			$this->salt = $row['passkey'];
			if (md5($this->salt . $this->input_params['old_password']) == $row['password']) {
				$res = true;
			}
			else {
				$res = false;
			}
		}
		mysqli_free_result($rs);
		return $res;
	}
	
	var $salt;
}
?>
