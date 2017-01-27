<?php
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";

	($g_type = $_GET['type']) or die();
	
	session_start();
	unset($_SESSION[$g_type . '_warning_show']);

//	require "access.php";

	session_write_close();
	if (isset($_POST['getit'])) {
		header("Location: .");
		exit;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
			html, body, table {width: 100%; height: 100%;}
        </style>
	</head>
	<body>
    	<table>
        	<tr><td align="center" valign="middle">
                <div class="cm-ajax-message">
                <?	if ('site' == $g_type) { ?>
                        Конфигурационный файл текущего сайта (<?=$_GET['reason']?>) не найден &mdash;<br>
                        пожалуйста, проверьте настройки сайта.
                <?	} ?>
                    <br />
                    <br />
                    <form action="" method="post">
                        <input type="submit" name="getit" value="Ok" />
                    </form>
                </div>
            </td></tr>
        </table>
	</body>
</html>
