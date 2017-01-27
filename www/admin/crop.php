<?	
	require $_SERVER['DOCUMENT_ROOT']."/lib/functions.php";
	require "lib/functions_admin.php";
	require "access.php";

	session_start();
	session_write_close();
	
	preg_match_all("/\((\d+)(x|х)(\d+)\)/", $_REQUEST['title'], $size, PREG_SET_ORDER);
	if ($size[0]) {
		$w = $size[0][1];
		$h = $size[0][3];
	}
	define('PREVIEW_WIDTH', isset($w)?$w:$config['GALLERY_THUMBNAIL_WIDTH']);
	define('PREVIEW_HEIGHT', isset($h)?$h:$config['GALLERY_THUMBNAIL_HEIGHT']);
	define('CROPBOX_WIDTH', 650);
	define('CROPBOX_HEIGHT', 600);
	
	define('RESIZE_DIR_NAME', $config['GALLERY_THUMBNAIL_DIR_NAME']?$config['GALLERY_THUMBNAIL_DIR_NAME']:'.resize');
	if ($_REQUEST['thumb_path']) {
		$config['GALLERY_THUMBNAIL_ALT_PATH'] = $_REQUEST['thumb_path'];
	}
	
	if (!PREVIEW_WIDTH or !PREVIEW_HEIGHT) {
		// possible to get here if picture's title is defined as 'Picture (0x0)'
		$error = true;
		$alert = "Не определены размеры ресайза.";
	} else if ($img_src = $_REQUEST['img_src']) {
		$img_ext = strtolower(end(explode('.', basename($img_src))));
		if ('jpg' != $img_ext and 'jpeg' != $img_ext) {
			$error = true;
			// ! todo - process not only jpeg
			$alert = "Изображение должно быть в формате JPG.";
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$jpeg_quality = 90;
		
			if ($img_r = @imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$img_src)) {
				if ($dst_r = @ImageCreateTrueColor( PREVIEW_WIDTH, PREVIEW_HEIGHT )) { 
					if (@imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],PREVIEW_WIDTH,PREVIEW_HEIGHT,$_POST['w'],$_POST['h'])) {
						$bg_white = imagecolorallocate($dst_r, 255, 255, 255);
						imagefill($dst_r, 0, 0, $bg_white);
						$output_dir = $config['GALLERY_THUMBNAIL_ALT_PATH']?$config['GALLERY_THUMBNAIL_ALT_PATH']:dirname($img_src) . '/' . RESIZE_DIR_NAME;
						$output_filename = $output_dir . '/' . mb_substr(basename($img_src), 0, mb_strlen(basename($img_src),'UTF-8')-mb_strlen($img_ext,'UTF-8')-1,'UTF-8') . '.' . PREVIEW_WIDTH . 'x' . PREVIEW_HEIGHT . '.' . $img_ext;
						if (!file_exists($_SERVER['DOCUMENT_ROOT'].$output_dir) and !@mkdir($_SERVER['DOCUMENT_ROOT'].$output_dir)) {
							$error = 4;
						}
						if (!$error and !@imagejpeg($dst_r,$_SERVER['DOCUMENT_ROOT'].$output_filename,$jpeg_quality)) {
							$error = 5;
						}
					} else {
						$error = 3;
					}
				} else {
					$error = 2;
				}
			} else {
				$error = 1;
			}
			if ($error) {
				$alert = "Ошибка при обработке изображения (" . $error . ").";
			} else {
				$success = true;
			}
		}
	}
	if ($error) {
		unset($img_src);
	}
?>
<!doctype html>
<html>
<head>

	<title></title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
	<link rel="stylesheet" href="jquery/jcrop/css/jquery.Jcrop.css" type="text/css" />

	<script type="text/javascript" src="jquery/jcrop/js/jquery.min.js"></script>
	<script type="text/javascript" src="jquery/jcrop/js/jquery.Jcrop.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css" />
    <script type="text/javascript" src="utils.js"></script>
    
<?	if ($success) { ?>
		<script type="text/javascript">
			window.opener.document.editForm.<?=$_REQUEST['field']?>.value = "<?=$output_filename?>";
			window.close();
		</script>
<?	} ?>
    
    <style type="text/css">
		.crop-preview {width: <?=PREVIEW_WIDTH?>px; padding: 0 15px 0 5px;}
		.crop-preview-box {width: <?=PREVIEW_WIDTH?>px; height: <?=PREVIEW_HEIGHT?>px; overflow: hidden;}
		table {width: auto !important;}
		td {vertical-align: top;}
		.crop-title {margin-bottom: 5px; font-size: 12px;}
		.crop-title img {position: absolute;}
		.crop-submit {text-align: center;}
    </style>

</head>
<body class="cm-edit cm-edit-wide">
<script language="Javascript">
var jcrop_api, boundx, boundy;
$(function() {

	$('#jcrop_target').Jcrop({
		onChange: showPreview,
		onSelect: showPreview,
		aspectRatio: <?=PREVIEW_WIDTH?> / <?=PREVIEW_HEIGHT?>,
		setSelect: [0, 0, <?=PREVIEW_WIDTH?>, <?=PREVIEW_HEIGHT?>],
		minSize: [<?=PREVIEW_WIDTH?>, <?=PREVIEW_HEIGHT?>],
		boxWidth: <?=CROPBOX_WIDTH?>,
		boxHeight: <?=CROPBOX_HEIGHT?>
	}, function() {
		// Use the API to get the real image size
		var bounds = this.getBounds();
		boundx = bounds[0];
		boundy = bounds[1];
		// Store the API in the jcrop_api variable
		jcrop_api = this;			
	}); 

	var $preview = $('#preview');
	function showPreview(coords)
	{
		if (parseInt(coords.w) > 0)
		{
		  var rx = <?=PREVIEW_WIDTH?> / coords.w;
		  var ry = <?=PREVIEW_HEIGHT?> / coords.h;
		
		  $preview.css({
			width: Math.round(rx * boundx) + 'px',
			height: Math.round(ry * boundy) + 'px',
			marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			marginTop: '-' + Math.round(ry * coords.y) + 'px'
		  });
		}

		$('#x').val(coords.x);
		$('#y').val(coords.y);
		$('#w').val(coords.w);
		$('#h').val(coords.h);

	};

});

</script>
	<? if ($error) { ?>
	    <div class="error"><?=$alert?></div>
        <br />
    <?	} ?>
    <table><tr><td>
    	<div class="crop-title">Исходная картинка:
        	<a href="#" onClick="inputToSetUrlName='img_src'; window.open('htmleditor/editor/filemanager/browser/default/browser.html?Type=Image&CurrentFolder=&Connector=http<?=$_SERVER['HTTPS']?'s':''?>%3A%2F%2F<?=current(explode(':', $_SERVER['HTTP_HOST']))?>%2Fadmin%2Fhtmleditor%2Feditor%2Ffilemanager%2Fconnectors%2Fphp%2Fconnector.php', '_blank', 'width=600,height=500,resizable=1'); return false;"><img src="images/icons/folder_image.png" alt="Выбрать картинку" title="Выбрать картинку"></a>
            <form method="get">
                <input type="hidden" name="img_src" value="" onChange="this.form.submit()" />
				<input type="hidden" name="field" value="<?=$_REQUEST['field']?>" />
                <input type="hidden" name="title" value="<?=$_REQUEST['title']?>" />
                <input type="hidden" name="thumb_path" value="<?=$_REQUEST['thumb_path']?>" />
            </form>
        </div>
	<?	if ($img_src) { ?>
    		<img src="<?=$img_src?>" id="jcrop_target" />
	<?	} ?>
    </td>
<?	if ($img_src) { ?>
    <td class="crop-preview">
	    <div class="crop-title"><?=$_GET['title']?>:</div>
	    <div class="crop-preview-box">
	        <img src="<?=$img_src?>" id="preview" />
	    </div>
        <div class="crop-submit">
        <form method="post">
            <input type="hidden" name="img_src" value="<?=$img_src?>" />
            <input type="hidden" name="field" value="<?=$_REQUEST['field']?>" />
            <input type="hidden" name="title" value="<?=$_REQUEST['title']?>" />
            <input type="hidden" name="thumb_path" value="<?=$_REQUEST['thumb_path']?>" />
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
            <div class="cm-edit-submit">
                    <input type="submit" value="Сохранить" class="submit" />
                    <input type="button" value="Отменить" onClick="window.close();" />
            </div>
        </form>
	    </div>
    </td>
<?	} ?>
    </tr>
    </table>
</body>
</html>
