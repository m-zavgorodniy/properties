function save_upd_dnd(table_id, table, messagebox_id, reload_tree) {
  w_params = "";
  var rows = document.getElementById(table_id).tBodies[1].rows;
  for (var i = 0; i < rows.length; i++) {
	w_params += rows[i].id.split("-")[1] + ";";
  }
  w_params =  w_params.substr(0, w_params.length - 1);

  $.ajax({
			type: "POST",
			async : true,
			url: "/admin/ajax/table-dnd.php",
			data: "t=" + table + "&w=" + w_params,
			success: function(data) {
				self.location.reload();
				if (reload_tree)
					reloadTree()
			},
			error: function(xhr) {$("#" + messagebox_id).html(xhr.status==500?xhr.responseText:xhr.status); return false}
  });
//  w_init_section = w;
}

function ajax_toggle_boolean(table, field, id) {
	var toggle_control = "#toggle_" + table + "_" + field + "_" + id;
	var toggle_img = toggle_control + " img";
	
	var action = 'exclude';
	if ($(toggle_control).attr('rel') == 0) {
		action = 'include'
	}
	$(toggle_img).attr('src', '/admin/images/load_small.gif');
	$.ajax({
			type: "POST",
			url: "/admin/ajax/update_boolean.php",
			data: "table=" + table + "&field=" + field + "&id=" + id + "&action=" + action,
			success: function(data) {
				if (action == 'exclude') {
					$(toggle_control).attr('rel', 0);
					$(toggle_img).attr('src', '/admin/images/icons/cancel.png');
					$(toggle_img).attr('title', 'Включить');
				} else {
					$(toggle_control).attr('rel', 1);
					$(toggle_img).attr('src', '/admin/images/icons/tick.png');
					$(toggle_img).attr('title', 'Исключить');
				}
			},
			error: function(xhr) {
				alert("Error " + xhr.status);
			}
	});
}
