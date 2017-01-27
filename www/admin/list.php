<?
require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
require "lib/functions_admin.php";
require "access.php";

require "lib/list.class.php";

include_custom(ACTION_TYPE, 'list');
if (class_exists('CustomList'))
	$clist = new CustomList(ACTION_TYPE, SITE_ID);
else
	$clist = new CList(ACTION_TYPE, SITE_ID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="styles.css" />
	    <script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="jquery/jquery.tablednd_0_5.js"></script>
        <script type="text/javascript" src="jquery/table-dnd.js"></script>
        <!--<script type="text/javascript" src="/jquery.lightbox-0.5.min.js"></script>
	    <script type="text/javascript" src="/jquery.lightbox-init.js"></script>-->
        <script type="text/javascript" src="utils.js"></script>
        <script type="text/javascript" src="ajax.js"></script>
	</head>
	<body>
<?
	$clist->order = $_GET['order'];
	$from_param = (int)$_GET[$clist->table . '_from'];
	$clist->records_from = $from_param?$from_param:1;
	$clist->render();
?>
	</body>
</html>
