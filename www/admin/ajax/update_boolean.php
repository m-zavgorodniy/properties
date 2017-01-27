<?
	require $_SERVER['DOCUMENT_ROOT'] . "/lib/functions.php";
	require "../lib/functions_admin.php";
	require "../access.php";
	
	$conn = db_mysql_connect();
	$query = "UPDATE `" . $_POST['table'] . "` SET `" . $_POST['field'] . "` = " . ($_POST['action']=='exclude'?0:1) . " WHERE id = " . (int)$_POST['id'];
	if (true !== db_mysql_query($query, $conn)) {
		header('HTTP/1.1 500 Internal Server Error');
	}
	mysql_close($conn);
	exit;
?>