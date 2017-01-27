<?
require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
require "lib/functions_admin.php";
require "access.php";

require "lib/doclist.class.php";

include_custom(ACTION_TYPE, 'doclist');
if (class_exists('CustomDoclist'))
	$doclist = new CustomDoclist(ACTION_TYPE, SITE_ID);
else
	$doclist = new Doclist(ACTION_TYPE, SITE_ID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <link rel="stylesheet" type="text/css" href="styles.css" />
	    <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
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
<?
	$doclist->render();
?>
	</body>
</html>