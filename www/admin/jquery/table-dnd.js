$(document).ready(initTables);

function initTables() {
  $(".cm-content-subquery table").tableDnD({
    onDragClass: "cm-drag",
    dragHandle: "cm-drag-handle",
	onDragStart: function (table, row) {
		table.className = 'cm-hide-drag-handle';
	},
    onDrop: function(table, row) {
	  table.className = '';
      var rows = table.tBodies[1].rows;
      var w = "";
      for (var i = 0; i < rows.length; i++) {
        w += rows[i].id + ";";
      }
	  
	  m_table = table.id.split("-")[1];
	  m_row_params = eval('w_init_' + m_table);
	  if (w != m_row_params) {
	  	$("#cm-upd-dnd-" + m_table).css('display', 'block');
	  }
    }
  });

    $(".cm-content-subquery .cm-drag-handle").hover(function() {
          $(this).addClass('cm-show-drag-handle');
    }, function() {
          $(this).removeClass('cm-show-drag-handle');
    });

}
