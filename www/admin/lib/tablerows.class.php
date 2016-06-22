<?
require_once (defined('BACK_OFFICE_PATH')?(BACK_OFFICE_PATH . '/'):'') . "lib/metatable.class.php";

class TableRows extends MetaTable {

	function render($bookmark = NULL) {
		if ($this->rec_count == 0)
			return;
		$this->get_table_records();
		if (!is_array($this->record_meta)) {
			die("Define one or more columns to be shown in the list");
		}
		
		$is_many2many = $this->table_meta['is_many2many']; ?>
        <div class="cm-content">
            <div class="cm-content-subquery">
<?				if ($this->table_meta['sortable'])	{ ?>
                <div class="cm-ajax-message" id="cm-upd-dnd-<?=$this->table?>">
                    <div class="cm-ajax-message-close"><a href="#" onclick="this.parentNode.parentNode.style.display = 'none'; return false;"><img src="images/icons/cancel_grey.png" alt="Отменить"></a></div>
                    <div id="cm-upd-dnd-message-<?=$this->table?>">
                        Вы изменили порядок записей
                        <br />
                        <br />
                        <form>
                            <input type="button" value="Сохранить" onclick="save_upd_dnd('sub-<?=$this->table?>', '<?=$this->table_meta['table_name']?>', 'cm-upd-dnd-message-<?=$this->table?>', <?=$this->table_meta['is_in_site_tree']?'true':'false'?>); return false;" />
                        </form>
                    </div>
                    <script type="text/javascript">
                      var w_init_<?=$this->table?> = "";
                      $(document).ready(function() {
                          $("#sub-<?=$this->table?>").each(function() {
                              var rows = this.tBodies[1].rows;
                              for (var i = 0; i < rows.length; i++) {
                                w_init_<?=$this->table?> += rows[i].id + ";";
                              }
                          });
                      });
                    </script>
                </div>
<?				}

			define(PAGES_IN_BLOCK, 10);
			define(FROM_PARAM_NAME, $this->table . '_from');

			$page_uri = current(explode('&' . FROM_PARAM_NAME . '=', $_SERVER['REQUEST_URI']));
			
			$pages_count = ceil($this->rec_count / $this->records_on_page);
			$blocks_count = ceil($this->rec_count / ($this->records_on_page * PAGES_IN_BLOCK));
			$current_page = ceil($this->records_from / $this->records_on_page);
			$current_block = ceil($this->records_from / ($this->records_on_page * PAGES_IN_BLOCK));
			$first_page_in_block = ($current_block - 1) * PAGES_IN_BLOCK + 1; ?>

            <div class="cm-content-navigation">
			<?	if ($this->table_meta['searchable']) { ?>
                <div class="cm-content-navigation-search">
                    <a href="javascript:;" onclick="return openEditWindow('search.php?<?=$search_fields_url_query?>')"><img src="images/icons/magnifier.png" alt="Найти" title="Найти" /></a> <strong>Фильтр:</strong> все записи
                </div>
            <?	} ?>
			<?	if ($pages_count != 1) { ?>
            		<div class="cm-content-navigation-pages">
            	<?	if ($current_page > 1) { ?>
                        <span><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=1"><img src="images/icons/arrow_first.png" alt="В начало" title="В начало" /></a></span>
                        <span><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=<?=($current_page - 2) * $this->records_on_page + 1?>"><img src="images/icons/arrow_prev.png" alt="Предыдущая" title="Предыдущая" /></a></span>
            <?		}
                    if ($current_block > 1) { ?>
                        <span><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=<?=($current_block - 2) * PAGES_IN_BLOCK * $this->records_on_page + 1?>">...</a></span>
            <?		}
                    for($i=$first_page_in_block; $i<=$pages_count and $i<=$first_page_in_block+PAGES_IN_BLOCK-1; $i++) { 
                        $_from = ($i-1)*$this->records_on_page + 1; 
                        $_to = $_from - 1 + $this->records_on_page; 
                        if ($_to > $this->rec_count)
                            $_to = $this->rec_count; ?>
                        <span class="cm-content-navigation-page<?=$i==$current_page?' cm-content-navigation-page-active':''?>"><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=<?=$_from?>"><?=$_from?>-<?=$_to?></a></span>
            <?		}
                    if ($blocks_count > 1 and $current_block < $blocks_count) { ?>
                        <span><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=<?=$current_block * PAGES_IN_BLOCK * $this->records_on_page + 1?>">...</a></span>
            <?		}
                    if ($current_page != $pages_count) { ?>
                        <span><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=<?=$current_page * $this->records_on_page + 1?>"><img src="images/icons/arrow_next.png" alt="Следующая" title="Следующая" /></a></span>
                        <span><a href="<?=$page_uri?>&<?=FROM_PARAM_NAME?>=<?=($pages_count - 1) * $this->records_on_page + 1?>"><img src="images/icons/arrow_last.png" alt="В конец (записей <?=$this->rec_count?>)" title="В конец (записей <?=$this->rec_count?>)" /></a></span>
            <?		} ?>
            		</div>
			<?	} ?>
            </div>

            <table cellspacing="0" id="sub-<?=$this->table?>">
                <tr>
<?						if ($this->table_meta['editable'])	{ ?>	
                    <th>&#160;</th>
<?						} ?>
<?						if ($this->table_meta['deletable'])	{ ?>	
                    <th>&#160;</th>
<?						}
                    $wide_cols = 0;
                    foreach ($this->record_meta as $column => $meta) {
                        if ($meta['main'] or $meta['wide'])
                            $wide_cols++;
						if ($meta['main'] and $meta['wide'])
							$main_is_wide = true;
						if (!$meta['main'] and $meta['wide'])
							$main_is_not_wide = true;
                    }
					if (isset($main_is_wide)) unset($main_is_not_wide);
					if (!isset($main_is_not_wide)) $main_is_wide = true;
					else if (isset($main_is_not_wide)) $wide_cols--;
					
					$col_num = 2; // first column is always id
                    foreach ($this->record_meta as $column => $meta) { ?>
                        <th<?=($meta['main'] and $main_is_wide and $meta['type'] != 'date' or $meta['wide'])?' width="' . (floor(100/($wide_cols?$wide_cols:1))) .'%"':''?>>
                        <?	if ($this->master_table != NULL) { //  it's a sub query
                        		$view_link = "type=" . $this->master_table . "&id=" . $this->master_id . ($bookmark?'&bookmark='.$bookmark:'');
                        	} else {
                        		$view_link = "type=" . $this->table;
                        	}
							// ...&order=news.2.asc 
							$sql_order = end(explode('`'.$this->table_meta['table_name'].'`.', $this->sql_order, 2)); ?>
                       		<a href="?<?=$view_link?>&order=<?=$this->table_meta['table_name']?>.<?=$column?>.<?=($meta['order_desc'] and $sql_order != '`'.$column.'` desc' or $sql_order == "`".$column."` asc")?'desc':'asc'?>.<?=$meta['type']?>"><?=$meta['title']?>
                        <?	if (strpos($sql_order, '`'.$column.'` ') === 0) { // !$this->sql_order and $meta['order_num'] or ?>    
                            <span class="cm-subquery-order"><img src="images/icons/order_<?=($meta['order_desc'] and !$sql_order or $sql_order == '`'.$column.'` desc')?'desc':'asc'?>.png" alt="" /></span>
                        <?	} ?> 
	                        </a>   
                        </th>
<?						$col_num++;
					} 
                    unset($meta); ?>
                </tr>
                <tbody>
            <?	foreach ($this->records as $subrow) {
					$field_lang_id = '';
					if ($subrow['meta_site_lang_id']) {
						 // $subrow['meta_site_lang_id'] - also does not display record's language if it's only one and it's default
						if ($this->table_meta['multi_lang']) {
							$field_lang_id = current(explode(',', $subrow['meta_site_lang_id']));
						}
						$subrow['meta_site_lang_id'] = out_langs($subrow['meta_site_lang_id'], $this->site_langs_all);
					}
?>
                <tr id="section-<?=$subrow['id']?>">
<?						if ($this->table_meta['editable']) { ?>	
                        <td><a href="edit.php?type=<?=$this->table?>&id=<?=$subrow['id']?>" target="_blank" onclick="return openEditWindow('edit.php?type=<?=$this->table?>&id=<?=$subrow['id']?>')"><img src="images/icons/<?=$is_many2many?"link_edit.png":"bullet_edit.png"?>" title="Редактировать" alt="" /></a></td>
<?						} ?>	
<?						if ($this->table_meta['deletable']) { // or $is_many2many) { ?>	
                        <td><a href="delete.php?type=<?=$this->table?>&id=<?=$subrow['id']?>" target="_blank" onclick="return openEditWindow('delete.php?type=<?=$this->table?>&id=<?=$subrow['id']?>')"><img src="images/icons/<?=$is_many2many?"link_break.png":"bullet_delete.png"?>" title="Удалить<?=$is_many2many?" связь":""?>" alt="" /></a></td>
<?						}
                    foreach ($this->record_meta as $column => $meta) {
                        if ($meta['type'] == 'boolean' or $meta['type'] == 'calc_boolean') { ?>
                            <td align="center" class="cm-content-subquery-boolean"><img src="images/icons/<?= $subrow[$column]==1?'accept.png':(!($subrow[$column]===NULL or $subrow[$column]==='')?'delete.png':'help.png')?>" alt="" /></td>
<?                      } else if ($meta['type'] == 'boolean_ajax') { ?>
                            <td align="center" class="cm-content-subquery-boolean"><a href="#" rel="<?=$subrow[$column]?1:0?>" onclick="ajax_toggle_boolean('<?=$this->table_meta['table_name']?>', '<?=$column?>', <?=$subrow['id']?>); return false" id="toggle_<?=$this->table_meta['table_name'] . "_" . $column . "_" . $subrow['id']?>"><img src="images/icons/<?=$subrow[$column]==1?'tick.png':(!($subrow[$column]===NULL or $subrow[$column]==='')?'cancel.png':'help.png')?>" alt="" title="<?= !empty($subrow[$column])?'Исключить':'Включить'?>"></a></td>
<?						} else if ($meta['type'] == 'sort' and $this->table_meta['sortable']) { ?>
                            <td align="right"<?=$this->rec_count <= RECORDS_ON_PAGE_NUM?' class="cm-drag-handle" title="Переместить"':''?>><?=htmlspecialchars($subrow[$column])?></td> <? /*=$this->master_table?' class="cm-drag-handle" title="Переместить"':'' */?>
                    <?	} else if ($meta['type'] == 'lookup' or $meta['type'] == 'lookup_custom' or $meta['type'] == 'lookup_external') { ?>
                            <td nowrap="">
<?								if ($meta['main']) { ?>
                                <a href="view.php?type=<?=$this->many2many_table?$this->many2many_table.'&id='.$subrow[$column]:$this->table.'&id=' . $subrow['id']?>"><?=htmlspecialchars($subrow[$column . "_lookup"])?></a>
<?								} else { ?>
                                <?=htmlspecialchars($subrow[$column . "_lookup"])?>
<?								} ?>&#160;
                            </td>
<?						} else {
                            $field_value = '';
                            if ($meta['type'] === 'html') {
                                $field_value = $subrow[$column];
                            } else if ($meta['type'] === 'textarea') {
                                $field_value = nl2br(htmlspecialchars($subrow[$column]));
                            } else if (0 === strpos($meta['type'], 'image')) {
                                if ($subrow[$column]) {
                                    $field_value = '<img src="' . htmlspecialchars($subrow[$column]) . (false === strpos($subrow[$column], '?')?'?' . rand():'') . '" alt="" class="cm-content-subquery-image" />';
                                }
                            } else {
                                $field_value = htmlspecialchars($subrow[$column . (($meta['multi_lang'] and $field_lang_id)?'_' . $field_lang_id:'')]);
                            } ?>
                            <td<?=($meta['main'] and $main_is_wide or $meta['wide'] and $meta['type'] != 'date' or $meta['type'] == 'html' or $meta['type'] == 'textarea')?'':''/*' nowrap=""'*/?><?=$type !== 'digit'?'':' align="right"'?><?=$meta['type'] == 'date'?' nowrap':'' ?>>
<?								if ($meta['main']) { ?>
                                <a href="view.php?type=<?=$this->table . "&id=" . $subrow['id']?>"><?=$field_value?></a>
<?								} else { ?>
                                <?=$field_value?>
<?								} ?>&#160;
                            </td>
<?							}
                    } 
                    unset($meta); ?>
                </tr>
            <? 
                }
                unset($subrow);
            ?>
                </tbody>
            </table>
            </div>
        </div>
<?	}
	
	function TableRows($table, $site_id, $sql_filter = NULL, $master_table = NULL, $master_id = NULL, $many2many_table = NULL, $records_from = NULL, $conn = NULL) {
		parent::MetaTable($table, $site_id, NULL, true, $sql_filter, $master_table, $master_id, $many2many_table, $records_from, RECORDS_ON_PAGE_NUM, $conn);
	}
}
?>