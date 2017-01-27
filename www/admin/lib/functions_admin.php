<?
require "config_admin.php";

function include_custom($meta_table, $action) {
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . $_SESSION['site_path'] . "/admin/lib/custom/functions.php")) {
		include $_SERVER['DOCUMENT_ROOT'] . $_SESSION['site_path'] . "/admin/lib/custom/functions.php";
	} else if (file_exists("lib/custom/functions.php")) {
		include "lib/custom/functions.php";
	}

	if (file_exists($_SERVER['DOCUMENT_ROOT'] . $_SESSION['site_path'] . "/admin/lib/custom/" . $meta_table . "/" . $action . ".php"))
		include ($_SERVER['DOCUMENT_ROOT'] . $_SESSION['site_path'] . "/admin/lib/custom/" . $meta_table . "/" . $action . ".php");
	else if (file_exists("lib/custom/" . $meta_table . "/" . $action . ".php"))
		include ("lib/custom/" . $meta_table . "/" . $action . ".php");
	else if (file_exists("lib/system/" . $meta_table . "/" . $action . ".php"))
		include ("lib/system/" . $meta_table . "/" . $action . ".php");
}

function get_site_title($conn = NULL) {
	$query = "SELECT meta_title FROM section WHERE section_id IS NULL AND meta_site_id = ''";
	$rs = ($conn !== NULL?db_mysql_query($query, $conn):db_query($query));
	$title = '';
	if ($row = mysql_fetch_row($rs))
		$title = $row[0];
	mysql_free_result($rs);
	return $title;
}

function get_date_format() {
	// we'll use it in bright future for multi language back office
	return DATE_FORMAT;
}

function set_site_path($site_id) {
	$conn = db_mysql_connect();
	$rs = db_mysql_query("SELECT path, path_files FROM meta_site WHERE id = '" . mysql_real_escape_string($site_id) . "'", $conn);
	if ($row = mysql_fetch_assoc($rs)) {
		// ! admin\htmleditor\editor\filemanager\connectors\php\config.php is modified to get the site path from the session - look for $Config['UserFilesPath']
		$_SESSION['site_path'] = $row['path_files']?$row['path_files']:$row['path'];
	}
	mysql_free_result($rs);
	mysql_close($conn);
	
	$_SESSION['site_warning_show'] = 1;
}

function out_langs($lang_ids, $langs_all) {
	$res = '';
	$langs = explode(',', $lang_ids);
	foreach ($langs as &$lang) {
		$res .= $langs_all[$lang] . ', ';
	}
	return rtrim($res, ', ');
}

function handle_db_alert($str) {
	$res = '';
	if (strpos($str, 'cannot be null') !== false)
		$res = "Пожалуйста, заполните все обязательные поля";
	else if (strpos($str, 'Incorrect datetime') !== false)
		$res = "Некорректный ввод даты";
	else if (strpos($str, 'Incorrect integer') !== false or strpos($str, 'Incorrect float') !== false)
		$res = "Некорректный ввод числа";
	else if (strpos($str, 'Duplicate entry') !== false)
		$res = "Запись с такими данными уже существует";
	else if (strpos($str, 'Error sending message') !== false)
		$res = "Невозможно отправить сообщение";

	if ($res) {
		return $res . " (" . $str . ")";
	} else {
		return $str;
	}
}

?>