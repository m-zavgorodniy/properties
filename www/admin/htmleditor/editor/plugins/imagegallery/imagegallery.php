<?	
//	Image Gallery FCKEditor Plugin 
//	(c) 2009-2012 Eclipse Interactive
//	http://e-i.com.ru
	
	// must be included
	if (strtr(__FILE__, "\\", "/") == strtr($_SERVER['SCRIPT_FILENAME'], "\\", "/")) {
		die();
	}
	define('THUMB_DIR_NAME', $config['GALLERY_THUMBNAIL_ALT_PATH']?$config['GALLERY_THUMBNAIL_ALT_PATH']:($config['GALLERY_THUMBNAIL_DIR_NAME']?$config['GALLERY_THUMBNAIL_DIR_NAME']:'.resize'));
	define('THUMB_WIDTH', $config['GALLERY_THUMBNAIL_WIDTH']?$config['GALLERY_THUMBNAIL_WIDTH']:180);
	define('THUMB_HEIGHT', $config['GALLERY_THUMBNAIL_HEIGHT']?$config['GALLERY_THUMBNAIL_HEIGHT']:120);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Image Gallery FCKEditor Plugin by Eclipse Interactive</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
    <script type="text/javascript" src="jquery/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.tablednd_0_5.js"></script>
    <script type="text/javascript" src="jquery/table-dnd.js"></script>
    <script type="text/javascript" src="/jquery.lightbox-0.5.min.js"></script>
    <script type="text/javascript" src="utils.js"></script>
	<script type="text/javascript">
    <!--
    var FCK = window.opener.FCK;
	var fotosetNode = FCK.Selection.MoveToAncestorNode("TD") || FCK.Selection.MoveToAncestorNode("P") || FCK.Selection.MoveToAncestorNode("DIV");
    function ok() {
		FCK.Focus();
		if (fotosetNode == null) {
			fotosetNode = insertFotosetNode(FCK.InsertElement( "P" ))
		}
		else {
			$("img", fotosetNode).remove();
			if (fotosetNode.nodeName != "TD") {
				FCK.Focus(); // for IE
				fotosetNode = insertFotosetNode(fotosetNode.innerHTML.editorTrim().length > 0 ? FCK.InsertElement( "P" ) : fotosetNode)
			}
			fotosetNode.innerHTML = fotosetNode.innerHTML.editorTrim();
		}
		var fotoset_params = "w" + document.editForm.preview_width.value + "-h" + document.editForm.preview_height.value + "-" + $("input[@name='preview_crop']:checked").val();
		$(fotosetNode).attr("class", "fotoset");
		$(fotosetNode).addClass("fotoset-" + fotoset_params);

		var gallery_id = Math.floor((Math.random()*100000)+1); 
		$(".section").each(function() {
			var img_src = $(".img-src", this).attr("href");
/*			if (img_src.indexOf("http://<?=current(explode(':', $_SERVER['HTTP_HOST']))?>") != -1) {
				img_src = img_src.split("http://<?=current(explode(':', $_SERVER['HTTP_HOST']))?>")[1];
			}*/
			var img_desc = $(".img-desc", this).val();
			var img_preview = $(".img-preview img", this).attr("src");
			var img_preview_width = $(".img-width", this).text();
			var img_preview_height = $(".img-height", this).text();
			
			$(fotosetNode).append("<a class=\"fotoset-item\" title=\"" + img_desc + "\" href=\"" + img_src + "\" rel=\"fotoset" + gallery_id + "\"><img src=\"" + img_preview + "\" width=\"" + img_preview_width + "\" height=\"" + img_preview_height + "\" alt=\"" + img_desc + "\"></a>" + "\n");
			
		});

		window.close()
    }
	
	function insertFotosetNode(nodeToInsertIn) {
		var oDoc = FCK.EditorDocument;
		
		// not using jquery to append elements because of "IE doesn't allow elements created in one document to be appended to another document"
		var table = oDoc.createElement( "TABLE" );
		nodeToInsertIn.appendChild( table );
		$(table).attr("cellspacing", "0");

		var tbody = oDoc.createElement( "TBODY" );
		table.appendChild( tbody );
		var row = oDoc.createElement( "TR" );
		tbody.appendChild( row );

		var newFotosetNode = oDoc.createElement( "TD" );
		row.appendChild( newFotosetNode );

		return newFotosetNode;
	}

	var loadImage = new Image(); // preload loading gif
	loadImage.src = "images/load.gif";
	var errorImage = new Image(); // preload error gif
	errorImage.src = "images/icons/cross.png";
	function appendImage(img_src, description, width, height, crop) {
		var newRow = insertImageRow(img_src, description);
		window.location.hash = $(newRow).attr("id");
		makePreview(newRow, width, height, crop)
	}
	
	function makePreview(row, width, height, crop) {
		$(".img-preview", row).parent().css("background-color", "#ffffff");
		$(".img-preview img", row).attr("style", "width: 24px");
		$(".img-preview img", row).attr("src", loadImage.src);
		$.ajax({
		  type: "GET",
		  url: "/admin/htmleditor/editor/plugins/imagegallery/ajax_make_preview.php", // Safari didn't get relative path here, so "/admin/" was added
		  data: "image=" + $(".img-src", row).attr("href") + "&width=" + width + "&height=" + height + (crop?"&crop=" + crop:""),
		  success: function (preview_src) {
			$(".error").css("display", "none");
		  	setPreview(row, preview_src);
		  },
		  error: function (xhr) {
			$(".error").text("Ошибка при генерации превью (" + (xhr.status==500?xhr.responseText:xhr.status) + ")");
			$(".error").css("display", "block");
			$(".img-preview img", row).attr("style", "width: 16px");
			$(".img-preview img", row).attr("src",errorImage.src);
		  }
		});
	}

	var rowsCount = 0;
	function insertImageRow(img_src, description, preview_src, width, height) {
		// append pictures in table
		var clonedRow = $("#sub_sample_row").clone(true);
		$(clonedRow).attr("id", "section-" + ++rowsCount);
		$(clonedRow).attr("class", "section");
		$(clonedRow).attr("style", "");
		$(".img-src", clonedRow).attr("href", img_src);
		$(".img-src", clonedRow).text(img_src.replace(/\//g,"/ ").replace("/ / ", "//"));
		$(".img-desc", clonedRow).val(description);

		if (preview_src) {
			setPreview(clonedRow, preview_src, width, height);
		}

		$("#sub-picture-body").append(clonedRow);
		initTables();
		$("#sub_header").attr("style", "");
		
		return clonedRow;
	}
	
	function setPreview(row, preview_src, width, height) {
		$(".img-preview", row).attr("href", preview_src);
		$(".img-preview img", row).attr("src", "images/void.gif");
		$(".img-preview img", row).attr("style", "width: 50px");
		$(".img-preview img", row).attr("src", preview_src);
		if (preview_src.indexOf("<?=THUMB_DIR_NAME?>") != -1) {
			var preview_src_tmp = preview_src.substr(0, preview_src.lastIndexOf("."));
			preview_src_tmp = preview_src_tmp.substr(preview_src_tmp.lastIndexOf(".") + 1, preview_src_tmp.length);
			preview_src_tmp = preview_src_tmp.split("x");
			var img_width = parseInt(preview_src_tmp[0]);
			var img_height = parseInt(preview_src_tmp[1]);
			var alt_text = "";
			if (!isNaN(img_width) && !isNaN(img_height)) {
				$(".img-width", row).text(img_width);
				$(".img-height", row).text(img_height);
				alt_text = img_width + "x" + img_height;
				if (width && height && (width!=img_width || height!=img_height)) {
					$(".img-width", row).text(width);
					$(".img-height", row).text(height);
					alt_text += " \nРазмер изменен пользователем: " + width + "x" + height;
					$(".img-preview", row).parent().css("background-color", "#ffcccc");
					$(".img-renew", row).css("display", "block");
				}
			} else if (width && height) { // back compatibility: older version of the plugin did not include width & height into the name of the file
				alt_text = width + "x" + height;
				$(".img-width", row).text(width);
				$(".img-height", row).text(height);
			}
			$(".img-preview img", row).attr("alt", alt_text);
			$(".img-preview img", row).attr("title", alt_text);
		} else if (width && height) {
			$(".img-width", row).text(width);
			$(".img-height", row).text(height);
			alt_text = "Картинка пользователя: " + width + "x" + height;
			$(".img-preview img", row).attr("alt", alt_text);
			$(".img-preview img", row).attr("title", alt_text);
			$(".img-preview", row).parent().css("background-color", "#ccffcc");
		}
	}
	
	$(document).ready(function() {
		if (fotosetNode != null) {
			$("img", fotosetNode).each(function() {
				if (this.parentNode.nodeName == "A" && $(this.parentNode).hasClass("fotoset-item")) {
					insertImageRow(this.parentNode.href, this.parentNode.title, this.src, this.width, this.height)
				}
				else
					appendImage(this.src, this.alt, document.editForm.preview_width.value, document.editForm.preview_height.value)
			});
			// restore fotoset parameters
			var fotosetClass = $(fotosetNode).attr("class");
			if (fotosetClass) {
				var params = fotosetClass.split(" fotoset-")[1];
				if (params) {
					// w140-h100-wh
					params = params.split("-");
					document.editForm.preview_width.value = params[0].substring(1, params[0].length);
					document.editForm.preview_height.value = params[1].substring(1, params[1].length);
					$("input[name='preview_crop'][value='" + params[2] + "']").attr("checked", true)
				}
			}
		}
		window.focus();
	});
	
	var FCKFileBrowserWindow;
	function changeFCKOpenFileBehavior() {
		if (!FCKFileBrowserWindow.frames || FCKFileBrowserWindow.frames.length == 0 || !FCKFileBrowserWindow.frmResourcesList || !FCKFileBrowserWindow.frmResourcesList.OpenFile) {
			setTimeout("changeFCKOpenFileBehavior()", 100);
		} else {
			FCKFileBrowserWindow.frmResourcesList.OpenFile = function( fileUrl ) {
				self.SetUrl( encodeURI( fileUrl ).replace( '#', '%23' ), true ) ;
			}
			FCKFileBrowserWindow.focus();
		}
	}
	var	screenX = window.screenX || window.screenLeft || 0; 
	var	screenY = window.screenY || window.screenTop || 0; 
	window.onfocus = function() {
	   	if (FCKFileBrowserWindow) FCKFileBrowserWindow.close();
	}
    //-->
    </script>
</head>
<body class="cm-edit">
    <div class="error" style="display: none;"></div>
    
	<form method="post" action="" name="editForm" onSubmit="return false;">
    <input type="hidden" name="img_src" value="" onChange="appendImage(this.value, '', editForm.preview_width.value, editForm.preview_height.value, $('input[name=\'preview_crop\']:checked').val())">
   	<table><tr><td class="cm-edit-content">
    	<table>
            <tr><td>
            	<div class="input">
                    <div class="cm-edit-setting">
                        <a href="#" onClick="d = document.getElementById('cm-edit-setting'); d.style.display = 'block'; return false;">
                            <img src="images/icons/image_gear.png" alt="" title="">Настройки</a>
                        <div id="cm-edit-setting">
                            <div class="cm-ajax-message-close"><a href="#" onclick="this.parentNode.parentNode.style.display = 'none'; return false;"><img src="images/icons/cancel_grey.png" alt="Закрыть"></a></div>
                        	<div class="cm-edit-setting-title">Генерация превью</div>
                            Размер: <input type="text" name="preview_width" value="<?=THUMB_WIDTH?>" style="width: 30px;" maxlength="3"> x <input type="text" name="preview_height" value="<?=THUMB_HEIGHT?>" style="width: 30px;" maxlength="3">
                            <div class="cm-checkbox">
	                            <input type="radio" name="preview_crop" value="wh" id="preview_crop_wh" checked>
	                            <label for="preview_crop_wh">Точное соотвествие</label>
                            </div>
                            <div class="cm-checkbox">
	                            <input type="radio" name="preview_crop" value="w" id="preview_crop_w">
	                            <label for="preview_crop_w">По ширине</label>
                            </div>
                            <div class="cm-checkbox">
	                            <input type="radio" name="preview_crop" value="h" id="preview_crop_h">
	                            <label for="preview_crop_h">По высоте</label>
                            </div>
                            <div class="cm-checkbox">
	                            <input type="radio" name="preview_crop" value="c" id="preview_crop_c">
	                            <label for="preview_crop_c">Квадратное (вырез, по ширине)</label>
                            </div>
                        </div>
                    </div>
                <a href="#" onClick="inputToSetUrlName='img_src'; FCKFileBrowserWindow = window.open('htmleditor/editor/filemanager/browser/default/browser.html?Type=Image&Connector=http<?=$_SERVER['HTTPS']?'s':''?>%3A%2F%2F<?=current(explode(':', $_SERVER['HTTP_HOST']))?>%2Fadmin%2Fhtmleditor%2Feditor%2Ffilemanager%2Fconnectors%2Fphp%2Fconnector.php', '_blank', 'top=' + (screenY+45) + ',left=' + (screenX+200) + ',width=800,height=600,resizable=1'); changeFCKOpenFileBehavior(); return false;">
                    <img src="images/icons/image_add.png" alt="" title="">Добавить картинку</a>
                </div>

				<script type="text/javascript">
                  var w_init_picture = "";
                  $(document).ready(function() {
                      $("#sub-picture").each(function() {
                          var rows = this.tBodies[1].rows;
                          for (var i = 0; i < rows.length; i++) {
                            w_init_picture += rows[i].id + ";";
                          }
                      });
                  });
                </script>
            	<div class="cm-content-subquery">
                    <table cellspacing="0" id="sub-picture">
                        <tr id="sub_header" style="display: none;">
                            <th>&#160;</th>
                            <th>&#160;</th>
                            <th>Порядок</th>
                            <th>Превью</th>
                            <th width="100%">Картинка</th>
                            <th>Подпись</th>
                        </tr>
                        <tbody id="sub-picture-body">
                        <tr id="sub_sample_row" style="display: none;">
                            <td><a href="#" onclick="$(this.parentNode.parentNode).remove(); return false;"><img src="images/icons/bullet_delete.png" title="Удалить" alt="Удалить"></a></td>
                            <td><span class="img-renew"><a href="#" onclick="makePreview(this.parentNode.parentNode.parentNode, editForm.preview_width.value, editForm.preview_height.value, $('input[name=\'preview_crop\']:checked').val()); return false;"><img src="images/icons/gear.png" title="Обновить превью в соответствии с настройками" alt=""></a></span></td>
							<td align="right" class="cm-drag-handle" title="Переместить">&#160;</td>
                            <td class="cm-img-preview">
                            	<a href="#" class="img-preview" target="_blank"><img src="images/void.gif" alt=""></a>
                                <div class="img-size" style="display: none;"><span class="img-width"></span>x<span class="img-height"></span></div>
                                <div class="img-renew" style="display: none;"><a href="#" onclick="this.parentNode.style.display = 'none'; makePreview(this.parentNode.parentNode.parentNode, $('.img-width', this.parentNode.parentNode.parentNode).text(), $('.img-height', this.parentNode.parentNode.parentNode).text(), $('input[name=\'preview_crop\']:checked').val()); return false;"><img src="images/icons/gear.png" title="Обновить превью в соответствии с установленным пользователем размером картинки" alt=""></div>
                            </td>
                            <td><a href="#" class="img-src" target="_blank">ololo</a></td>
                            <td><textarea class="img-desc"></textarea></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td></tr>
         </table>
    </td><td class="cm-edit-submit">
    	<div>
            <input type="button" value="OK" class="submit" onclick="ok()">
            <input type="button" value="Отменить" onclick="window.close()">
        </div>
    </td></tr></table>
	</form>
</body>
</html>
