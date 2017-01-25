<?
	define('AJAX_REQUEST', true);
	
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "../lib/functions_admin.php";
	require "../access.php";

	$ids = explode(";", $_POST['w']);
	$conn = db_mysql_connect();
	$rs = db_mysql_query("SELECT f.field FROM meta_table m, meta_table_field f WHERE m.table_name = '".mysqli_real_escape_string($conn, $_POST['t'])."' AND f.meta_table_id = m.id AND f.type_extra = 'sort' AND f.published LIMIT 1", $conn);
	if ($row = mysqli_fetch_row($rs)) {
		for ($i = 0, $init_order = 10, $len = count($ids); $i < $len, !empty($ids[$i]); $i++, $init_order += 10) {
			$r = db_mysql_query("UPDATE `".mysqli_real_escape_string($conn, $_POST['t'])."` SET " . $row[0] . " = ".$init_order." WHERE id = '".$ids[$i] . "'", $conn);
			if ($r !== true) {
				break;
			}
		}
	} else {
		$r = "No ordering field";
	}
	mysqli_free_result($rs);
	mysqli_close($conn);

	if (true !== $r) {
		header("HTTP/1.1 500 Internal Server Error");
		echo($r);
	}
	exit;
?>