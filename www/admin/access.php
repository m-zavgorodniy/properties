<?
/*ini_set('session.cookie_lifetime', $config_auth['admin_session_lifetime']);
ini_set('session.gc_maxlifetime', $config_auth['admin_session_lifetime']);
ini_set('session.save_path', $config_auth['session_save_path']);*/
session_start();
if (!isset($_SESSION['admin_id'])) {
	if (!isset($_COOKIE[SESSION_ID_COOKIE_NAME])) {
		// not logged in
		close_user_session();
		exit;
	}
	// logged in but session's gone, try to restore
	$conn = db_mysql_connect();
	$query = "SELECT u.id, u.login, u.enabled, ug.users_group_id, u.name, u.middlename, u.surname, s.id session_id, u.email, s.ip session_ip
			  FROM user_session s, user u
			  LEFT JOIN user2users_group ug ON u.id = ug.user_id
			  WHERE s.id = '" . mysqli_real_escape_string($conn, $_COOKIE[SESSION_ID_COOKIE_NAME]) . "' AND UNIX_TIMESTAMP(s.updated) >= " . (time() - SESSION_INACTIVITY_TIMEOUT) . " AND s.user_id = u.id
			  LIMIT 1";
	$rs = db_mysql_query($query, $conn);
	if ($row = mysqli_fetch_assoc($rs)) {
		if ($row['enabled'] != 0 and $row['users_group_id'] !== NULL) {
			$_SESSION['admin_id'] = $row['id'];
			$_SESSION['ip'] = $row['session_ip'];

			$_SESSION['admin'] = $row['login'];
			$_SESSION['email'] = $row['email'];
			
			$old_session_id = $row['session_id'];
			session_regenerate_id(true);
			
			db_mysql_query("UPDATE user_session SET id = '" . session_id() . "', updated = '" . date("Y-m-d H:i:s") . "' WHERE id = '" . $old_session_id . "'", $conn);
		}
	}
	mysqli_free_result($rs);
	mysqli_close($conn);
} else if ($_SESSION['last_access_time'] < time() - SESSION_INACTIVITY_TIMEOUT) { // nb! only after 'if (!isset($_SESSION['admin_id'])) {...'
	// session expired
	close_user_session();
	exit;
}

if (!isset($_SESSION['admin_id']) or (SESSION_BIND_TO_IP and $_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])) {
	close_user_session();
	exit; 
} else if ($_SESSION['admin'] != ADMIN_LOGIN) {
	// backoffice user must be included in any user group
	// this code isn't moved to the MetaTable class (to use its connection etc) 'cos it must work for AJAX_REQUEST
	$conn = db_mysql_connect();
	$query = "SELECT GROUP_CONCAT(g.admin_access SEPARATOR ',') admin_access
			  FROM user u
			  LEFT JOIN user2users_group ug ON u.id = ug.user_id
			  LEFT JOIN users_group g ON ug.users_group_id = g.id
			  WHERE u.id = " . (int)$_SESSION['admin_id'] . " AND u.enabled <> 0
			  GROUP BY u.id";
	$rs = db_mysql_query($query, $conn);
	if (!($row = mysqli_fetch_row($rs)) or ($row[0] and (false === strpos($row[0], $_GET['type'])) and $_GET['type'] != 'password')) {
		define('ACCESS_ONLY', $row[0]);
	}
	mysqli_free_result($rs);
	mysqli_close($conn);

	if (defined('ACCESS_ONLY') and defined('AJAX_REQUEST')) {
		session_write_close();
		header("HTTP/1.1 401 Unauthorized");
		exit;
	}
}

// current site selection
if (isset($_GET['site'])) {
	$_SESSION['site_id'] = $_GET['site'];
	set_site_path($_GET['site']);
	session_write_close();
	header("Location: .");
	exit;
} else {
	// select a default site
	// ! todo - restore user's current site from user's stored session  
	if ($_SESSION['site_id'] === NULL) {
		$_SESSION['site_id'] = '';
		set_site_path('');
	}
}
define('SITE_ID', $_SESSION['site_id']);

$site_config_path = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['site_path'] . '/' . CMS_SITE_LIB_DIR_NAME . '/config.php';
if (file_exists($site_config_path)) {
	// ! todo - (?) is it a correct way to check if site's directory is properly set?
	unset($_SESSION['site_warning_show']); // set by set_site_path() above
	include $site_config_path;
} else if (isset($_SESSION['site_warning_show'])) {
	// ! todo - show this in pop-up
	session_write_close();
	header("Location: warning.php?type=site&reason=" . urlencode(str_replace($_SERVER['DOCUMENT_ROOT'], '&lt;doc_root&gt;', $site_config_path)));
	exit;
}


// extend session timeout
$_SESSION['last_access_time'] = time();
setcookie(SESSION_ID_COOKIE_NAME, session_id(), time() + SESSION_INACTIVITY_TIMEOUT, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);

session_write_close();


function close_user_session() {
	$conn = db_mysql_connect();
	db_mysql_query("DELETE FROM user_session WHERE id = '" . session_id() . "'", $conn);
	mysqli_close($conn);
	session_destroy();
	setcookie(SESSION_ID_COOKIE_NAME, '', 1, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true); // remove cookie
	if (!defined('AJAX_REQUEST')) {
		header("Location: login.php?back_path=" . urlencode($_SERVER['REQUEST_URI']));
	} else {
		header("HTTP/1.1 401 Unauthorized");
	}
}
?>
