<?
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
    <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="utils.js"></script>
    <script type="text/javascript">
		function setFrame() {
			window.top.content.location.href='void.php'
		}
		
		jQuery(function() {
			jQuery(".cm-panel-site-control").click(function() {
				jQuery(".cm-panel-site-select").show();
			});
			jQuery(".cm-panel-site-select-close").click(function() {
				jQuery(".cm-panel-site-select").hide();
			});
		});
    </script>
</head>
<body>
	<div class="cm-panel">
        <div class="cm-panel-site">
<?			$conn = db_mysql_connect();
			$rs = db_mysql_query("SELECT id, title FROM meta_site WHERE 1", $conn);
			//if (mysqli_num_rows($rs) > 1) {
				$site_select = '';
				while($row = mysqli_fetch_row($rs)) {
					if (SITE_ID == $row[0]) { ?>
						<div class="cm-panel-site-current"><?=$row[1]?></div>
		<?				} else {
						$site_select .= '<a href="./?site=' . $row[0] . '" target="_top">' . $row[1] . '</a>&nbsp';
					}
				} 
				if ($site_select) { ?>
					<a href="javascript:" class="cm-panel-site-control" target="tree" title="Выбрать сайт"><img src="images/icons/bullet_arrow_down.png" alt=""></a>
					<div class="cm-panel-site-select">
						<?=$site_select?><a href="javascript:" class="cm-panel-site-select-close">[x]</a>
					</div>
			<?	} ?>
                <div class="cm-panel-separator"></div>
		<?	//}
			mysqli_free_result($rs); 
			mysqli_close($conn); ?>
        </div>
		<a href="doclist.php?type=listing_type" target="tree" onClick="setFrame()"><img src="images/icons/application_view_list.png" alt="">Недвижимость</a>
    <?	// ! hardcode for moscowkey
		if (ADMIN_LOGIN == $_SESSION['admin']) { ?>
		<a href="doclist.php?type=container&mode=sitetree" target="tree" onClick="setFrame()"><img src="images/icons/sitemap.png" alt="">Разделы</a>
		<a href="doclist.php?type=banner_type" target="tree" onClick="setFrame()"><img src="images/icons/application_view_gallery.png" alt="">Баннеры</a>
		<a href="extras.php" target="tree" onClick="setFrame()"><img src="images/icons/wrench.png" alt="">Настройки и справочники</a>
<!--		<a href="mailing.php" target="tree" onClick="setFrame()"><img src="images/icons/email.png" alt="">Рассылки</a> -->
	    <a href="site.php?view=metatable" target="tree" onClick="setFrame()"><img src="images/icons/gear_big.png" alt="">Сайт</a>
    <?	} ?>
	    <div class="cm-panel-right">
<!--			<div class="cm-panel-separator"></div> -->
    <?	// ! hardcode for moscowkey
		if (ADMIN_LOGIN == $_SESSION['admin']) { ?>
			<a href="doclist.php?type=users_group" target="tree" onClick="setFrame()"><img src="images/icons/user.png" alt="">Пользователи</a>
    <?	} ?>
            <a href="view.php?type=user&id=<?=$_SESSION['admin_id']?>" target="content"><img src="images/icons/user_suit.png" alt=""><?=$_SESSION['admin']?></a>
        	<a href="login.php?logout" target="_top" class="last"><img src="images/icons/door_in.png" alt="">Выход</a>
	    </div>
    </div>
</body>
</html>
