<?
require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
require "lib/functions_admin.php";
require "access.php";

require "lib/delete.class.php";

include_custom(ACTION_TYPE, 'delete');

if (class_exists('CustomDeletePreview'))
	$delete_preview = new CustomDeletePreview(ACTION_TYPE, SITE_ID, ID, $_GET, $_POST);
else
	$delete_preview = new DeletePreview(ACTION_TYPE, SITE_ID, ID, $_GET, $_POST);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
    <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="utils.js"></script>
</head>
<body class="cm-edit">
<?
	$delete_preview->render();
?>
</body>
</html>
