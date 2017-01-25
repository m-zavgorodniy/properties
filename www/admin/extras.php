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
    <?	$rs = db_mysql_query("SELECT m.id, m.title_list title FROM meta_table m WHERE m.is_in_extras <> 0 ORDER BY m.id = 'setting', m.id = 'seo_url_data', m.is_system <> 0, title", db_mysql_connect(true));
		while ($row = mysqli_fetch_assoc($rs)) { ?>
            <div class="cm-container">
                <a href="list.php?type=<?=$row['id']?>" target="content" onClick="window.location.href='extras.php?view=custom<?=$row['id']?>#h_custom<?=$row['id']?>';setCurrent(this);" id="custom<?=$row['id']?>"><span><img src="images/icons/bullet_toggle_<?=$g_view=='custom'.$row['id']?'minus':'plus'?>.png" alt=""></span><?=$row['title']?></a>
            </div>
	<?	}
		mysqli_free_result($rs); ?>
	</body>
</html>