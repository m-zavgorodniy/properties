<?
	require $_SERVER['DOCUMENT_ROOT'] . "/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";

	if (strpos($_GET['back_path'], "view.php") !== false or strpos($_GET['back_path'], "viewlist.php") !== false or strpos($_GET['back_path'], "list.php") !== false) {
		$content_src = $_GET['back_path'];
	} else {
		$content_src = 'void.php';
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
		<title><?=get_site_title()?> - Система управления сайтом</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script>
            if (self.top != null && self.top.frames.length != 0) {
                self.location = 'void.php';
            }
        </script>
</head>
	<frameset
		rows="29,*,28"
		frameborder="0"
		framespacing="0">

        <frame
            src="top.php"
            name="top"
            scrolling="no"
            noresize="true" />
        <frameset
            cols="20%, *"
                border="1"
                frameborder="1"
                framespacing="4"
                topmargin="0"
                leftmargin="0"
                marginheight="0"
                marginwidth="0">
            <frame
                src="doclist.php?type=listing_type"
                name="tree"
                topmargin="0"
                leftmargin="0"
                marginheight="0"
                marginwidth="0"
                frameborder="0"
                border="0" />
            <frame
                src="<?=$content_src?>"
                name="content"
                topmargin="0"
                leftmargin="0"
                marginheight="0"
                marginwidth="0"
                frameborder="no"
                border="0" />
        </frameset>
        <frame
            src="footer.php"
            name="footer"
            scrolling="no"
            noresize="true" />
	</frameset>
	<noframes></noframes>
</html>