<?
require ("lib/tablerows.class.php");

class Doclist extends TableRows {
	
	function render() {
		if ($this->init()) {
			if ($this->get_table_records()) {
				foreach ($this->record_meta as $field => $meta) {
					if ($meta['main']) {
						$main_field = $field;
						break;
					}
				}
				unset($meta);
				foreach ($this->records as $row) { ?>
					<div class="cm-container">
						<a href="viewlist.php?type=<?=$this->table?>&id=<?=$row['id']?>" target="content" onclick="window.location.href='doclist.php?type=<?=$this->table?>&view=<?=$row['id']?>#h_<?=$this->table_meta['table_name']?>_<?=$row['id']?>';setCurrent(this)" id="<?=$this->table_meta['table_name']?>_<?=$row['id']?>"><span><img src="images/icons/bullet_toggle_<?=$row['id']==$_GET['view']?'minus':'plus'?>.png" alt=""></span><?=htmlspecialchars($row[$main_field])?></a>
					</div>
			<?	}
				unset($row);
				
			}
		}
	}

}
?>