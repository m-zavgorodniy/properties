<?
require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
require "lib/functions_admin.php";
require "access.php";

require "lib/view.class.php";

include_custom(ACTION_TYPE, 'view');
if (class_exists('CustomView'))
	$view = new CustomView(ACTION_TYPE, SITE_ID, ID);
else
	$view = new View(ACTION_TYPE, SITE_ID, ID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <link rel="stylesheet" type="text/css" href="<?=$_SESSION['site_path'] . '/' . trim($config['CONTENT_CSS_FILE_PATH'], '/')?>" />
		<!--<link rel="stylesheet" type="text/css" href="/jquery.lightbox-0.5.css" media="screen" />-->
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
	$view->bookmark = $_GET['bookmark'];
	$view->order = $_GET['order'];
	$view->render();
?>
	</body>
</html>
<?
/*
$start_time = microtime();
$start_array = explode(" ",$start_time);
$start_time = $start_array[1] + $start_array[0];
$end_time = microtime();
$end_array = explode(" ",$end_time);
$end_time = $end_array[1] + $end_array[0];
$time = $end_time - $start_time;
printf("Максим, я очень старалась и сгенерила эту страницу за %f секунд",$time);*/
?>