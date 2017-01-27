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
		   	<a href="list.php?type=meta_table" target="content" onClick="window.location.href='site.php?view=metatable#h_metatable';setCurrent(this);" id="metatable"><span><img src="images/icons/bullet_toggle_<?=$g_view=='metatable'?'minus':'plus'?>.png" alt=""></span>Таблицы</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=section_type" target="content" onClick="window.location.href='site.php?view=sectiontype#h_sectiontype';setCurrent(this);" id="sectiontype"><span><img src="images/icons/bullet_toggle_<?=$g_view=='sectiontype'?'minus':'plus'?>.png" alt=""></span>Типы разделов</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=article_type" target="content" onClick="window.location.href='site.php?view=articletype#h_articletype';setCurrent(this);" id="articletype"><span><img src="images/icons/bullet_toggle_<?=$g_view=='articletype'?'minus':'plus'?>.png" alt=""></span>Типы статей</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=banner_type" target="content" onClick="window.location.href='site.php?view=bannertype#h_bannertype';setCurrent(this);" id="bannertype"><span><img src="images/icons/bullet_toggle_<?=$g_view=='bannertype'?'minus':'plus'?>.png" alt=""></span>Типы баннеров</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=container" target="content" onClick="window.location.href='site.php?view=container#h_container';setCurrent(this);" id="container"><span><img src="images/icons/bullet_toggle_<?=$g_view=='container'?'minus':'plus'?>.png" alt=""></span>Меню</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=setting_admin" target="content" onClick="window.location.href='site.php?view=setting#h_setting';setCurrent(this);" id="setting"><span><img src="images/icons/bullet_toggle_<?=$g_view=='setting'?'minus':'plus'?>.png" alt=""></span>Настройки шаблонов</a>
        </div>
        <div class="cm-container">
		   	<a href="list.php?type=seo_parameter" target="content" onClick="window.location.href='site.php?view=sef#h_sef';setCurrent(this);" id="sef"><span><img src="images/icons/bullet_toggle_<?=$g_view=='sef'?'minus':'plus'?>.png" alt=""></span>Настройки ЧПУ</a>
        </div>
        <div class="cm-container">
		   	<a href="view.php?type=site&id=<?=$_SESSION['site_id']?>" target="content" onClick="window.location.href='site.php?view=site_setting#h_site_setting';setCurrent(this);" id="site_setting"><span><img src="images/icons/bullet_toggle_<?=$g_view=='site_setting'?'minus':'plus'?>.png" alt=""></span>Настройки сайта</a>
        </div>
	</body>
</html>