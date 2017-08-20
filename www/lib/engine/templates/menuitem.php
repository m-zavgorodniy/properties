<?
    $url = get_menuitem_link($_SITE['section_id'], $_SITE['site_path'], $_SITE['conn']);
	header('Location: ' . $url);
	
	function get_menuitem_link($section_id, $_SITE_path, $conn) {
		$rs = db_mysql_query("SELECT id, section_type_id, path, dir, url
							  FROM section
							  WHERE published <> 0 AND section_id = " . (int)$section_id ."
							  ORDER BY sort_num
							  LIMIT 1", $conn);
		if ($row = mysqli_fetch_assoc($rs)) {
			if ($row['section_type_id'] != 'menuitem') {
				if ($row['section_type_id'] != 'link') {
					$url = $_SITE_path . $row['path'] . $row['dir'];
				} else {
					$url = $row['url'];
				}
			} else {
				$url = get_menuitem_link($row['id'], $_SITE_path, $conn);
			}
		}
		mysqli_free_result($rs);
		return $url;
	}	
?>