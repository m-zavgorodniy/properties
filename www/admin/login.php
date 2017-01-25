<?
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	
	$login = trim($_POST['login']);
	if (isset($login) and $login !== '') {
		$conn = db_mysql_connect();
		$query = "SELECT u.id, u.login, u.password, u.passkey, u.enabled, ug.users_group_id, u.name, u.middlename, u.surname, u.email
				  FROM user u
				  LEFT JOIN user2users_group ug ON u.id = ug.user_id
				  WHERE u.login = '" . mysqli_real_escape_string($conn, $login) . "'
				  LIMIT 1";
		$rs = db_mysql_query($query, $conn);
		if ($row = mysqli_fetch_assoc($rs) and $row['password'] == md5($row['passkey'] . $_POST['password'])) {
			if ($row['enabled'] != 0 and ($row['users_group_id'] !== NULL)) {
				session_start();
				session_regenerate_id(true);
				$_SESSION['admin_id'] = $row['id'];
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

				$_SESSION['admin'] = $row['login'];
				$_SESSION['email'] = $row['email'];
				
				$_SESSION['last_access_time'] = time();
				session_write_close();
				setcookie(SESSION_ID_COOKIE_NAME, session_id(), time() + SESSION_INACTIVITY_TIMEOUT, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
				
				db_mysql_query("INSERT INTO user_session (is_backoffice, id, user_id, ip, created, updated) VALUES (1, '" . session_id() . "', " . $row['id'] . ", '" . $_SERVER['REMOTE_ADDR'] . "', '" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')", $conn);
				
				// gc, kind of
				// user_session.updated is touched when the session is restored via cookie
				$my_maxlifetime = max(SESSION_INACTIVITY_TIMEOUT, min(ini_get('session.cookie_lifetime'), ini_get('session.gc_maxlifetime')));
				db_mysql_query("DELETE FROM user_session WHERE UNIX_TIMESTAMP(updated) < " . (time() - $my_maxlifetime) . " AND is_backoffice <> 0", $conn);

				if (strpos($_POST['back_path'], "edit.php") !== false or strpos($_POST['back_path'], "delete.php") !== false) {
					// editing or deleting window
					header("Location: " . $_POST['back_path']);
				} else if ($_POST['back_path']) {
					// main window
					header("Location: .?back_path=" . urlencode($_POST['back_path']));
				} else {
					header("Location: .");
				}
			    exit;
			} else {
				$alert = "Нет доступа";
			}
		} else {
			$alert = "Неправильное имя пользователя или пароль";
			usleep(500);
		}
		mysqli_free_result($rs);
		mysqli_close($conn);
	}

	if (isset($_GET['logout'])) {
		session_start();
		$conn = db_mysql_connect();
		db_mysql_query("DELETE FROM user_session WHERE id = '" . session_id() . "'", $conn);
		mysqli_close($conn);
		session_destroy();
		setcookie(SESSION_ID_COOKIE_NAME, '', 1, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true); // remove cookie
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?=get_site_title()?> - Система управления сайтом</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="STYLESHEET" type="text/css" href="styles.css">
	<style>
		html, body, table {width: 100%; height: 100%;}
		body {font-size: 70%; background-color: #ebebeb;}
		td {vertical-align: middle; padding-bottom: 75px;}
		.fieldset {background-color: #ffffff; width: 200px; margin: 0 auto; padding: 10px; padding: 20px;}
		label, input {display: block;}
		label {margin-bottom: 5px;}
		input.text {font-size: 100%; width: 178px; height: 1.5em; padding-top: .15em; margin-bottom: 1em; border: 1px solid #c3c3c3;}
		.submit {padding: 0 1em; font-size: 100%;}
		#login {background: url(images/icons/user.png) no-repeat 0 .1em; padding-left: 20px;}
		#password {background: url(images/icons/key.png) no-repeat 1px .1em; padding-left: 20px;}
		.error {color: #ed2429; margin-bottom: 1em;}
	</style>
    <script>
		if (self.top != null && self.top.frames.length != 0)
			self.top.location = self.location;
		window.onload = function() {
<?	if (!isset($alert)) { ?>
			document.getElementById('login').focus()
<? 	} else { ?>
			document.getElementById('password').focus()
<? 	} ?>
		}
    </script>
</head>

<body>
<table></td><td>
<form method="post" action="login.php">
<input type="hidden" name="back_path" value="<?=$_GET['back_path']?>">
<div class="fieldset">
<? if (isset($alert)) { ?>
		<div class="error">
			<?=$alert?>
		</div>
<? } ?>
		<div class="field">
			<label>Имя пользователя:</label>
			<input type="text" name="login" value="<?=$_POST['login']?>" class="text" id="login">
		</div>
		<div class="field">
			<label>Пароль:</label>
			<input type="password" name="password" value="" class="text" id="password">
		</div>
		<input type="submit" name="enter" value="Вход" class="submit">
</div>
</form>
</td></tr></table>
</body>
</html>