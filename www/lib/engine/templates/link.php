<?
    $url = get_section_link($_SITE['section_id'], $_SITE['conn']);
	header('Location: '.$url); 

	function get_section_link($section_id, $conn) {
		$rs = db_mysql_query("SELECT url FROM section WHERE id = " . (int)$section_id, $conn);
		$url = "";
		if ($row = mysqli_fetch_row($rs))
			$url = $row[0];
		mysqli_free_result($rs);
		return $url;
	}
?>