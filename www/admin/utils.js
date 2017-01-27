function openEditWindow(url, _w, _h) {
	var w = _w?_w:700;
	var h = _h?_h:800;
	window.open(url, '_blank', 'width=' + w + ',height=' + h + ',resizable=1,scrollbars=1,top='+Math.floor(screen.height/2-(h+50)/2-50)+',left='+Math.floor(screen.width/2-(w+50)/2-50));
	return false;
}

function openHTMLEditorWindow(form_obj, html_field_name) {
	form_obj.action = 'html_editor.php?html_field='+html_field_name;
	window.open('', 'html_editor', 'width=830,height=600,resizable=1,top='+Math.floor(screen.height/2-600/2-100)+',left='+Math.floor(screen.width/2-830/2-100));
	form_obj.target = 'html_editor';
	form_obj.submit();
	form_obj.action = '';
	form_obj.target = '';
	return false
}

function setCurrent() {
//	document.documentElement?document.documentElement.scrollLeft = 0:document.body.scrollLeft;

	var h = window.location.hash;
	var section_id;
	var default_view = false;
	if (h)
		section_id = h.substr(1, h.length).split('h_')[1];
	else {
		sections = document.getElementsByTagName('a');
//		if (sections.length == 1) {
			section_id = sections[0].id;
			default_view = true
//		}
//		else
//			return
	}
	section_obj = document.getElementById(section_id);
	
	if (section_obj) {
		if (current_section) {
			current_section.className = '';
		}
		current_section = section_obj;
		if (default_view)
			self.parent.content.location.href = current_section.href;

		section_obj.className = 'cm-sitetree-current';
	}
}

function reloadTree(from_popup) {
	if (from_popup)
		window.opener.parent.tree.location.reload();
	else
		window.parent.tree.location.reload()
}

function toggleSectionFolded(obj_id, href_obj) {
	obj = document.getElementById(obj_id);
	if (obj.style.display == 'none') {
		href_obj.childNodes[0].src = 'images/icons/bullet_toggle_minus.png';
		obj.style.display = 'block';
	} else {
		href_obj.childNodes[0].src = 'images/icons/bullet_toggle_plus.png';
		obj.style.display = 'none';
	}
}

function hideEmptyToolbar() {
	$(document).ready(function() {
		$(".cm-panel").each(function() {
			if (this.innerHTML.length == 0) $(this).hide()
		})
	})
}

var inputToSetUrlName = null;
function SetUrl(url, doNotClear) { //FCKeditor file browser calls this function after file selection dialog, do not change the name
	if (inputToSetUrlName == null)
		return;
	el = document.forms[0].elements[inputToSetUrlName];
	el.value = url;
	if (el.onchange)
		el.onchange();
	if (!doNotClear) //FCKeditor file browser window is not to be closed after selection of file
		inputToSetUrlName = null
}

function focusDefault() {
	fields = document.forms[0].elements;
	for (i=0; i<fields.length; i++) {
		if (fields[i].type == 'text') {
			fields[i].focus();
			break
		}
	}
}

String.prototype.editorTrim = function() {
	try {
//		return this.replace(/^[\s(&nbsp;)(<br>)]+|[\s(&nbsp;)(<br>)]+$/gi,"");
		return this.replace(/(&nbsp;)*$/i,"").replace(/^(&nbsp;)*/i,"")

	} catch(e) {
        	return this;
        }
}
