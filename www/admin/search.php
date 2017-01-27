<?
 // todo: make Search class extending MetaTable, get fields in list and search by them all 
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Поиск</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<?	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sql_filter = "(1"; // bracket is for OR below for multi language
			foreach ($_POST as $param => &$value) {
				if (trim($value)) {
					if ($param == 'id') {
						$sql_filter .= ") AND (`" . $_GET[SEARCH_TABLE_NAME_PARAM_NAME]. "`.id = " . (int)$value;
					} else if ('__multilang__' != $value) {
						$sql_filter .= ") AND (`" . $_GET[SEARCH_TABLE_NAME_PARAM_NAME]. "`.`" . $param . "` LIKE '%" . addslashes(trim($value)) . "%'";
					} else {
						// must go strict AFTER the main lang field
						$sql_filter .= " OR `" . $_GET[SEARCH_TABLE_NAME_PARAM_NAME]. "`.`" . $param . "` LIKE '%" . addslashes($value_prev) . "%'";
					}
				}
				$value_prev = trim($value);
			} 
			unset($value);
			$sql_filter .= ")"; ?>
			<script type="text/javascript">
				window.opener.location.href += "&filter=<?=urlencode($sql_filter)?>";
				window.close();
			</script>
	<?	} ?>
</head>
<body class="cm-edit">
	<form method="post" action="" name="editForm">
   	<table><tr><td class="cm-edit-content">
    	<table>
            <tr><td class="label">
				id:
	            </td>
	            <td class="input">
				<input type="text" name="id" value="" class="text">
            </td></tr>
        <?	foreach ($_GET as $param => &$title) { 
				if ($param == SEARCH_TABLE_NAME_PARAM_NAME) continue; 
				if ('__multilang__' == $title) { ?>
					<input type="hidden" name="<?=$param?>" value="<?=$title?>" class="text">
			<?	} else { ?>
				<tr><td class="label">
					<?=$title?>:
					</td>
					<td class="input">
					<input type="text" name="<?=$param?>" value="" class="text">
				</td></tr>
			<?	}
			}
			unset($title); ?>
        </table>
       </td>
       <td></td>
       <td class="cm-edit-submit">
          <input type="submit" value="Найти" class="submit">
          <input type="button" value="Отменить" onclick="window.close()">
       </td>
    </tr></table>
	</form>
</body>
</html>
