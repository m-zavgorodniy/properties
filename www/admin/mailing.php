<?
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";

	$g_view = $_GET['view'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <script type="text/javascript" src="utils.js"></script>
        <script type="text/javascript">
			var current_section;
			window.onload = function() {
				setCurrent()
			}
        </script>
		<!--[if lt IE 7.]>
		<script defer type="text/javascript" src="sitetree_pngfix.js"></script>
		<![endif]-->
	</head>
	<body class="cm-sitetree">
        <div class="cm-container">
		   	<a href="list.php?type=mailing" target="content" onClick="window.location.href='mailing.php?view=mailing#h_mailing';setCurrent(this);" id="mailing"><span><img src="images/icons/bullet_toggle_<?=$g_view=='mailing'?'minus':'plus'?>.png" alt=""></span>Рассылки</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=mailing_list" target="content" onClick="window.location.href='mailing.php?view=mailing_list#h_mailinglist';setCurrent(this);" id="mailinglist"><span><img src="images/icons/bullet_toggle_<?=$g_view=='mailinglist'?'minus':'plus'?>.png" alt=""></span>Подписчики</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=mailing_setting" target="content" onClick="window.location.href='mailing.php?view=mailing_setting#h_mailingsetting';setCurrent(this);" id="mailingsetting"><span><img src="images/icons/bullet_toggle_<?=$g_view=='mailingsetting'?'minus':'plus'?>.png" alt=""></span>Настройки</a>
        </div>
	</body>
</html>