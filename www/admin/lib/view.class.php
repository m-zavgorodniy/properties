<?
require ("lib/metatable.class.php");
require ("lib/toolbar.class.php");

class View extends MetaTable {
	
	function render() {
		global $config;

		if ($this->init()) {
			
			if ($this->table_meta['is_in_site_tree']) { ?>
				<script>
					h = window.parent.tree.location.hash;
					if (h != "#h_<?=$this->table_meta['table_name']?>_<?=$this->id?>") {
						window.parent.tree.location.hash = "h_<?=$this->table_meta['table_name']?>_<?=$this->id?>";
						window.parent.tree.setCurrent();
					}
				</script>
		<?	} 
	
			foreach($this->toolbars as $toolbar) {
				$toolbar->render();
			}
			unset($toolbar);
	
			// back toolbar
			if (SHOW_BACK_BUTTON) {
				$ref = $_SERVER['HTTP_REFERER'];
				if (strpos($ref, '/view.php') !== false or strpos($ref, '/list.php') !== false or isset($_GET['inserted'])) { ?>
					<div class="cm-panel">
						<a href="#" onclick="history.back()"><img src="images/icons/arrow_left.png" alt=""></a>
					</div>
			<?	}
			}
		
			?>
	
			<script type="text/javascript" src="videoplayer/flowplayer-3.0.5.min.js"></script>
            
			<div class="cm-content">
				<div class="cm-content-title cm-content-title-bookmarks">
                <?	if (isset($this->bookmark)) { ?>
						<span class="inactive"><a href="view.php?type=<?=$this->table?>&id=<?=$this->id?>"><?=$this->table_meta['title']?></a></span>
                <?	} else { ?>
						<span><?=$this->table_meta['title']?></span>
                <?	} ?>
				<?	foreach ($this->sub_query as $table => $sub_query) {
                        if (!$this->sub_query_meta[$table]['is_bookmark']) {
                            continue;
                        }
                        if ($sub_query->rec_count) { 
							if ($this->bookmark != $this->sub_query_meta[$table]['meta_table']) { ?>
                        		<span class="inactive"><a href="view.php?type=<?=$this->table?>&id=<?=$this->id?>&bookmark=<?=$this->sub_query_meta[$table]['meta_table']?>"><?=$this->sub_query_meta[$table]['title_subquery']?> (<?=$sub_query->rec_count?>)</a></span>
                        <?	} else { ?>
                        		<span><?=$this->sub_query_meta[$table]['title_subquery']?> (<?=$sub_query->rec_count?>)</span>
                        <?	} 
                    	}
                    }
                    unset($sub_query); ?>
				</div>
				<div class="cm-content-fields">
				<table>
				<?	foreach($this->record_meta as $field => $meta) {
						if ($this->is_show_subqueries_only and !$meta['main']) continue;
						
						if ('hidden' == $meta['type'] or 'calc_view' == $meta['type']) continue;
						
						if (isset($this->bookmark) and !$meta['main']) {
							continue;
						}
						if ($meta['published']) {
							if (false === strpos($meta['type'], 'boolean') and 'meta_site_lang_id' != $field and empty($this->record[$field])) {
								continue;
							}

							if ($meta['type'] != 'html') $this->record[$field] = htmlspecialchars($this->record[$field], ENT_NOQUOTES); 

							if ('meta_site_lang_id' == $field) {
								$this->record['meta_site_lang_id'] = out_langs($this->record['meta_site_lang_id'], $this->site_langs_all);
							} ?>
						<tr>
							<td class="cm-content-field"><?=$meta['title']?><?=$meta['type'] == 'html'?" (html)":""?>:</td>
							<td>
							<?	switch ($meta['type']) { 
									case 'boolean':
									case 'boolean_ajax':
									case 'calc_boolean': ?>
										<img src="images/icons/<?=$this->record[$field]?'accept.png':('0' === $this->record[$field]?'delete.png':'help.png')?>" alt="" />
								<?	break;
									case 'html': ?>
										<div class="<?=$config['CONTENT_CSS_CLASS_NAME']?>">
											<?=html_content_filter($this->record[$field])?>
										</div>
								<?	break;
									case 'textarea': ?>
										<?=typo_filter(nl2br($this->record[$field]))?>
								<?	break;
									case 'image':
									case 'image_preview':
										if ($this->record[$field] != '') { ?> 
											<span class="cm-content-img-preview"><img src="<?=$this->record[$field]?>?<?=time()?>" alt="" /></span>
									<?	}
										break;
									case 'image_big': ?> 
										<a href="<?=$this->record[$field]?>" target="_blank"><?=$this->record[$field]?></a>
									<?	break;
									case 'flash':
										if ($this->record[$field] != '') {
											// todo! SITE_PATH?
											list($flash_width, $flash_height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->record[$field]); ?> 
    	                                    <object type="application/x-shockwave-flash" data="<?=$this->record[$field]?>" width="<?=$flash_width?>" height="<?=$flash_height?>">
        	                                    <param name="movie" value="<?=$this->record[$field]?>" />
            	                                <param name="wmode" value="transparent" />
                	                        </object>
									<?	}
										break;
									case 'doc': ?> 
										<a href="<?=$this->record[$field]?>" target="_blank"><?=$this->record[$field]?></a>
									<?	break;
									case 'video': ?>
										<a href="<?=$this->record[$field]?>" target="_blank"><?=$this->record[$field]?></a>
									<?	break;
									case 'lookup_custom':
									case 'lookup_external':
									case 'lookup': ?> 
										<?=typo_filter($this->record[$field . "_lookup"])?>
								<?		break;
									default: ?>
										<?=$this->record[$field]?>
							<?	} ?>
							</td>
						</tr>
					<?	}
					}
					unset($field); ?>
				</table>
				</div>
			</div>
            
		<?	foreach ($this->sub_query as $table => $sub_query) {
				if (($this->bookmark or $this->sub_query_meta[$table]['is_bookmark']) and $this->sub_query_meta[$table]['meta_table'] != $this->bookmark) {
					continue;
				}
				if ($sub_query->rec_count) {
					if (isset($this->order)) {
						list($order_table, $order_field, $order_direction, $order_field_type) = explode('.', $this->order);
						if ($order_table == $table) {
							$sub_query->set_order($order_table, $order_field, $order_direction, $order_field_type);
						}
					} ?>
					<div class="cm-content">
                    <?	if (!isset($this->bookmark)) { ?>
							<div class="cm-content-title">
								<span><?=$this->sub_query_meta[$table]['title_subquery']?></span>
							</div>
					<?	}
						$sub_query->render($this->bookmark); ?>
					</div>
			<?	}
			}
			unset($sub_query);
		}
	} // function render()


	function make_main_toolbar(&$toolbar) {
		if ($this->table_meta['editable']) { 
			$toolbar->add_button("edit.php?type=" . $this->table . "&id=" . $this->id , "images/icons/page_white_edit.png", "Редактировать");
		}
		if ($this->table_meta['deletable']) {
			$toolbar->add_button("delete.php?type=" . $this->table . "&id=" . $this->id . "&detail=yes", "images/icons/page_white_delete.png", "Удалить");
		}
	}

	function make_sub_toolbar(&$toolbar) {
		$add_lookup_params = '';
		foreach ($this->record_meta as $field_name => &$record_meta) {
			if ('lookup' == $record_meta['type']) {
				$add_lookup_params .= '&' . $field_name . '=' . $this->record[$field_name];
			}
		}
		unset($record_meta);
		foreach ($this->sub_query as $table => &$sub_query) {
			if ($sub_query->table_meta['editable'] and $sub_query->table_meta['deletable']) {
				if (strpos($sub_query->table_meta['table_name'], 'section') !== 0) {
					if (!$this->sub_query_meta[$table]['many2many_table']) {
						$sub_icon = "page_white_add.png";
					} else {
						$sub_icon = "page_white_link.png";
					}
				} else {
					$sub_icon = "folder_add.png";
				}
				$toolbar->add_button("edit.php?type=" . $this->sub_query_meta[$table]['meta_table'] . "&" . $this->table_meta['table_name'] . "_id=" . $this->id . $add_lookup_params . "&new=yes", "images/icons/" . $sub_icon, $this->sub_query_meta[$table]['title_addnew']);
			}
		}
		unset($sub_query);
	}
	
	function init() {
		if (parent::init()) {
			if (!($this->is_show_subqueries_only = defined('SHOW_SUBQUERIES_ONLY'))) {
				
				$this->make_main_toolbar($this->toolbars['main'] = new Toolbar());
				
			}
			
			$this->get_sub_queries();
			$this->make_sub_toolbar($this->toolbars['sub'] = new Toolbar());

			return true;
		} else {
			return false;
		}
	}

	var $toolbars;
	var $bookmark;
	var $order;

	var $is_show_subqueries_only;
}
?>