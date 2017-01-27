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
		   	<a href="list.php?type=meta_table&system=1" target="content" onClick="window.location.href='cms.php?view=metatable_s#h_metatable_s';setCurrent(this);" id="metatable_s"><span><img src="images/icons/bullet_toggle_<?=$g_view=='metatable_s'?'minus':'plus'?>.png" alt=""></span>Системные таблицы</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=meta_table_field_group" target="content" onClick="window.location.href='cms.php?view=meta_table_field_group#h_meta_table_field_group';setCurrent(this);" id="meta_table_field_group"><span><img src="images/icons/bullet_toggle_<?=$g_view=='meta_table_field_group'?'minus':'plus'?>.png" alt=""></span>Группы полей</a>
        </div>
<!--        <div class="cm-container">
		   	<a href="list.php?type=mailing_type" target="content" onClick="window.location.href='cms.php?view=mailing_type#h_mailingtype';setCurrent(this);" id="mailingtype"><span><img src="images/icons/bullet_toggle_<?=$g_view=='mailingtype'?'minus':'plus'?>.png" alt=""></span>Типы рассылок</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=mailing_setting_admin" target="content" onClick="window.location.href='cms.php?view=setting#h_mailing_setting_admin';setCurrent(this);" id="mailing_setting_admin"><span><img src="images/icons/bullet_toggle_<?=$g_view=='mailing_setting_admin'?'minus':'plus'?>.png" alt=""></span>Настройки рассылок</a>
        </div> -->
        <div class="cm-container">
		   	<a href="list.php?type=site" target="content" onClick="window.location.href='cms.php?view=site#h_site';setCurrent(this);" id="site"><span><img src="images/icons/bullet_toggle_<?=$g_view=='site'?'minus':'plus'?>.png" alt=""></span>Сайты</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=users_group" target="content" onClick="window.location.href='cms.php?view=usergroup#h_usergroup';setCurrent(this);" id="usergroup"><span><img src="images/icons/bullet_toggle_<?=$g_view=='usergroup'?'minus':'plus'?>.png" alt=""></span>Группы пользователей</a>
        </div>
	</body>
</html>