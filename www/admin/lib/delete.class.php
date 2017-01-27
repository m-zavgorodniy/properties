<?
require ("lib/edit.class.php");

class DeletePreview extends Editor {
	
	function render() { 
		if ($this->init()) {
		
			if ($this->record) {
				$this->get_init_input();
				$constraints_ok = $this->check_constraints();
				if ($this->is_update and $constraints_ok and $this->table_meta['deletable']) {
					$r = $this->delete();
						
					if ($r === true)
						$this->on_update_success();
					else
						$this->on_update_error($r);
				} ?>
		
				<script type="text/javascript">
					document.title = "<?=$this->title?><?=$this->is_new?' [Новый]':''?>";
				</script>
		
			<?	if ($this->alert) { ?>
					<div class="error">
						<?=$this->alert?>
					</div>
			<?	} else if (!$this->table_meta['deletable']) { ?>
					<div class="error">
						Нет доступа на удаление
					</div>
			<?	} else if (!$constraints_ok) { ?>
					<div class="info">
						Удаление невозможно - есть вложенные записи
					</div>
			<?	} else { ?>
					<div class="question">
						Вы уверены, что хотите удалить <span class="low"><?=$this->table_meta['title_in_delete_confirm']?$this->table_meta['title_in_delete_confirm']:$this->table_meta['title']?></span>?
					</div>
			<?	} ?>
		
			<form method="post" action="" name="editForm">
			<table><tr><td class="cm-edit-content">
				<table>
				<?	foreach($this->record_meta as $field => $meta) { ?>
					<?	if ($meta['main']) {?>
							<tr><td class="label">
								<?=htmlspecialchars($meta['title'])?>:
							</td>
							<td class="input view">
								<?=htmlspecialchars($this->record[$field . ($meta['type'] == 'lookup'?"_lookup":"")])?>
							</td></tr>
					<?	}
					}
					unset($field); ?>
				</table>
			</td><td class="cm-edit-submit">
				<div>
					<input type="submit" value="Удалить"<?=(!$constraints_ok or !$this->table_meta['deletable'])?' disabled=""':''?> class="delete" />
					<input type="button" value="Отменить" onclick="window.close()" />
					<input type="hidden" name="<?=$this->update_param_name?>" value="1" />
				</div>
			</td></tr></table>
			</form>
		<?	}
		}
	} // function render()

	function delete() {
		return db_mysql_query("DELETE FROM `" . $this->table_meta['table_name'] . "` WHERE id = '" . mysql_real_escape_string($this->id) . "'", $this->conn);
	}

	function on_update_success() { ?>
		<script type="text/javascript">
            <? if ($this->table_meta['is_in_site_tree']) { ?>
				if (window.opener.parent.tree.location.href.indexOf("mode=sitetree") != -1) {
	                reloadTree(true)
				}
            <? } ?>
            <? if ($this->is_detail) {?>
                window.opener.history.back();
            <? } else { ?>
                window.opener.location.reload();
            <? } ?>
            window.close();
        </script>
<?	}

	function init() {
		if (parent::init()) {
			$this->title .= " [Удаление]";

			return true;
		} else {
			return false;
		}
	}

	function DeletePreview($meta_table, $site_id, $id, $get_params, $post_params) {
		parent::Editor($meta_table, $site_id, $id, $get_params, $post_params);
		
		$this->detail_param_name = 'detail';
		$this->is_detail = isset($get_params[$this->detail_param_name]);	
	}
	
	var $detail_param_name;
	var $is_detail;
}
?>