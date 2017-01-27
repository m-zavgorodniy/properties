<?
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";

/*	header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
	header("Content-Disposition: attachment; filename=".$action_type.".xls");

	echo chr(255).chr(254);*/
	
	if (isset($_POST['export'])) {
		header("Content-type: application/vnd.ms-excel; charset=Windows-1251");
		header("Content-Disposition: attachment; filename=".ACTION_TYPE.".xls");

		@require ("lib/".ACTION_TYPE."/export_".ACTION_TYPE.".php");
	} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Экспорт</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="styles.css">
    <script type="text/javascript" src="utils.js"></script>
	<? if (isset($_GET['export'])) {?>
		<script type="text/javascript">
			window.close();
		</script>
	<? } ?>
</head>
<body class="cm-edit">
<? if (isset($alert)) { ?>
		<div class="error">
			<?=$alert?>
		</div>
<? } ?>
	<form method="post" action="" name="editForm">
   	<table><tr><td class="cm-edit-content">
    	<table>
            <tr><td class="label">
				Выбрать:
	            </td>
	            <td class="input">
				<input type="radio" name="export_all" value="1" id="published_y" class="radio" checked><label for="published_y">Все записи</label>
                &#160;
				<input type="radio" name="export_all" value="0" id="published_n" class="radio" onFocus="this.form.export_count.focus()"><label for="published_n">Последние</label><input type="text" name="export_count" value="500" class="text" style="width: 50px; margin-left: .5em; vertical-align: middle" onFocus="this.form.export_all[1].checked = 1">
            </td></tr>
         </table>
       </td>
       <td></td>
       <td class="cm-edit-submit">
          <input type="submit" value="Экспорт" class="submit">
          <input type="button" value="Отменить" onclick="window.close()">
       </td>
    </tr></table>
		<input type="hidden" name="export" value="yes">
	</form>
</body>
</html>
<? }


/*function mconv($str) {
	return iconv('Windows-1251', 'UTF-16LE//IGNORE', $str);
}*/

function date_to_excel($datetime) {
	return strtotime($datetime . " UTC" ) / 86400 + 25569;
}

function text_to_sylk($string) {
	return str_replace(';', ';;', htmlspecialchars_decode_1251($string));
}
?>
