<? 
require "lib/metatable.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/lib/thumb.php";
require $_SERVER['DOCUMENT_ROOT'] . "/lib/translit.php";

define('GENERATE_PREVIEW_TEXT', 'Сгенерировать автоматически');
define('SIZE_PATTERN', "/(\d+|\?)\s*(x|х|X|Х)\s*(\d+|\?)/");

class Editor extends MetaTable {
	
	function init() {
		if (parent::init()) {
			$this->title = $this->table_meta['title'] . ($this->is_new?' [Новый]':'');
			$this->get_sub_queries();
			
//			if ($this->table_meta['multi_lang']) {
				$this->remove_record_meta("meta_site_lang_id");
//			}
			
			return true;
		} else {
			return false;
		}
	}

	function render() {
		global $config;
		if ($this->init()) {
			if (!$this->table_meta['editable']) {
				$this->set_alert("Нет доступа на редактирование");
			}
			if ($this->is_new or $this->record) {
				$this->get_init_input();
				if ($this->is_update) {
					$this->get_form_input();
					if ($this->validate_input()) {
						if ($this->is_new) {
							$r = $this->insert();
						}
						else {
							$r = $this->update();
						}
							
						if ($r === true)
							$this->on_update_success();
						else
							$this->on_update_error($r);
					}
				} ?>
                
				<script type="text/javascript">
					document.title = "<?=$this->title?>";
				</script>
		
			<?	if ($this->alert) { ?>
					<div class="<?=$this->is_update?"error":"info"?>">
						<?=nl2br($this->alert)?>
					</div>
			<? 	} ?>
		
			<script type="application/javascript">
                jQuery(function() {
                    jQuery(".lookup_external_option_delete").live("click", function() {
                        var field_name = jQuery(this).closest(".lookup_external_options").attr("id").split("lookup_external_options_")[1];
                        jQuery(this).closest(".lookup_external_option").remove();
                        make_lookup_external_total(field_name);
                    });
					jQuery(".lookup_external_select").change(function() {
						/* jquery is visibly slow accepting big select, use pure js */
						var id = this.options[this.selectedIndex].value; //jQuery(":selected", this).val();
						if ("" == id) return;
						
						var text = this.options[this.selectedIndex].text; //jQuery(":selected", this).text();
						var field_name = jQuery(this).attr("id").split("lookup_external_select_")[1];
						jQuery("#lookup_external_options_" + field_name).append('<div class="lookup_external_option" id="lookup_external_option_' + id + '">' + text + ' <a href="javascript:;" class="lookup_external_option_delete">[x]</a></div>');
						make_lookup_external_total(field_name);
						this.selectedIndex = 0;
					})
					.each(function() {
						var field_name = jQuery(this).attr("id").split("lookup_external_select_")[1];
						make_lookup_external_total(field_name);
					});
                });
                function make_lookup_external_total(field_name) {
                    var field_ids = "";
					jQuery("#lookup_external_select_" + field_name + " option").removeAttr("disabled");
                    jQuery("#lookup_external_options_" + field_name + " .lookup_external_option").each(function() {
						var id = jQuery(this).attr("id").split("lookup_external_option_")[1];
                        field_ids += id + ",";
						jQuery("#lookup_external_select_" + field_name + " option[value='" + id + "']").attr("disabled", "yes");
                    });
                    if (field_ids.length) field_ids = field_ids.substr(0,field_ids.length-1);
                    jQuery("[name='" + field_name + "']").val(field_ids);
					
					jQuery(".lookup_external_option_text", jQuery("#lookup_external_options_" + field_name)).each(function() {
						jQuery(this).text(jQuery("#lookup_external_select_" + field_name + " option[value='" + jQuery(this).closest(".lookup_external_option").attr("id").split("lookup_external_option_")[1] + "']").text());
					})
				}
            </script>
			<form method="post" action="" name="editForm" enctype="multipart/form-data">
			<table><tr><td class="cm-edit-content">
            	<?	if ($this->table_meta['multi_lang'] and $this->site_langs_extra) {
						$langs = is_array($this->post_params["meta_site_lang_id"])?$this->post_params["meta_site_lang_id"]:explode(',', $this->record['meta_site_lang_id']); ?>
						<script>
                            jQuery(function() {
                                jQuery(".cm-lang-select input")
                                    .change(function() {
                                        change_lang(jQuery(this));
                                    })
                                    .each(function() {
                                        change_lang(jQuery(this));
                                    });
                            });
                            function change_lang($control) {
                                var lang_field_class_name = $control.attr("id").split("__control")[1];
                                if ($control.attr("checked")) {
                                    jQuery("." + lang_field_class_name).show();
                                } else {
                                    jQuery("." + lang_field_class_name).hide();
                                }
                            }
                        </script>
                        <div class="cm-lang-select"><div class="cm-lang-select-box">
                        	<div class="cm-checkbox">
	                            <input type="checkbox" name="meta_site_lang_id[]" id="__control__lang" value=""<?=(false !== array_search('', $langs) or $this->is_new)?' checked=""':''?> /><label for="__control__lang"><strong><?=$this->site_langs_all['']?></strong></label>&nbsp;&nbsp;
                            </div>
						<?	foreach ($this->site_langs_extra as $lang_id => &$lang_extra) { ?>
                                <div class="cm-checkbox">
                                    <input type="checkbox" name="meta_site_lang_id[]" id="__control__lang_<?=$lang_id?>" value="<?=$lang_id?>"<?=(false !== array_search($lang_id, $langs) or $this->is_new)?' checked=""':''?> /><label for="__control__lang_<?=$lang_id?>"><?=$lang_extra?></label>&nbsp;&nbsp;
                                </div>
                        <?	}
                            unset($lang_extra); ?>
                        </div></div>
				<?	}
					foreach($this->record_meta as $field => $meta) {
						if ($meta['type'] == 'calc_view') continue;
						if (($meta['type'] == 'calc' or $meta['type'] == 'calc_boolean') and $this->is_new) continue;

						$has_dlg = false;
						ob_start();
						if ($meta['type'] != 'hidden') { ?>
						<tr<?=$meta['multi_lang']?' class="__lang' . ($meta['lang_id']?'_' . $meta['lang_id']:'') . '"':''?>><td class="label<?=$meta['is_extra_lang']?' label-extra':''?>">
                        <?	if ($meta['type'] == 'image_preview' and !preg_match(SIZE_PATTERN, $meta['title'])) {
								$meta['title'] .= ' (' . $config['GALLERY_THUMBNAIL_WIDTH'] . 'x' . $config['GALLERY_THUMBNAIL_HEIGHT'] . ')';
							} ?>
							<?=$meta['title']?><?=$meta['type'] == 'html'?" (html)":""?><?=$meta['unit']?' (' . $meta['unit'] . ')':''?><?=($meta['required'] and $meta['type'] != 'boolean' and !$meta['readonly'])?"*":""?>:
                        <?   if ($meta['comment'] and !$meta['is_extra_lang']) { // ?>
								<img src="images/icons/information.png" alt="" title="<?=htmlspecialchars($meta['comment'])?>" align="middle" />
						<?	} ?>
							</td>
							<td class="input">
							<?	if ($meta['lookup_filter']) {
									// we can use init_params in filters. example: service_package.service_group_id = {service_group_id}.
									$meta['lookup_filter'] = preg_replace("/{([a-zA-Z0-9_\-]+)}/eU", "\$this->init_params['\\1']", $meta['lookup_filter']);
								}
								if ($meta['default']) {
									// eg. look for the files in /property/2015/07/2456 -> default: /property/{Y}/{M}/{listing_id}
									$parse_date = explode('-', date('Y-m-d'));
									$file_browser_current_folder = str_replace(array('{Y}', '{M}', '{D}'), $parse_date, $meta['default']);
									foreach ($this->input_params as $param_name => &$param_value) {
										$file_browser_current_folder = str_replace('{' . $param_name . '}', $param_value, $file_browser_current_folder);
									}
									unset($param_value);
									$file_browser_current_folder = urlencode('/' . trim($file_browser_current_folder, '/') . '/');
								}
								switch ($meta['type']) { 
									case 'boolean': 
									case 'boolean_ajax': 
									case 'calc_boolean': 
										if (!$meta['readonly'] and $meta['type'] != 'calc_boolean') { ?>
											<input type="radio" name="<?=$field?>" value="1" id="<?=$field?>_y" class="radio"<?=(!isset($this->input_params[$field]) and $meta['default'] or isset($this->input_params[$field]) and $this->input_params[$field])?" checked=\"\"":""?> /><label for="<?=$field?>_y">Да</label>
										&#160;
											<input type="radio" name="<?=$field?>" value="0" id="<?=$field?>_n" class="radio"<?=(!isset($this->input_params[$field]) and ($meta['required'] and !$meta['default'] or !$meta['required'] and '0' === $meta['default'] ) or isset($this->input_params[$field]) and ($meta['required'] and !$this->input_params[$field] or !$meta['required'] and '0' === $this->input_params[$field]))?" checked=\"\"":""?> /><label for="<?=$field?>_n">Нет</label>
									<?	} else if (!($meta['type'] == 'calc_boolean' and $this->is_new)) { ?>
											<input type="text" name="<?=$field?>_view" value="<?=$this->record[$field]?"Да":"Нет"?>" <?=Editor::set_readonly($meta['readonly'])?> />
											<input type="hidden" name="<?=$field?>" value="<?=$this->record[$field]?>" />
                                    <?	}
										break;
									case 'html': ?>
										<div class="edit-html">
											<a href="#" target="_blank" onclick="return openHTMLEditorWindow(window.document.editForm, '<?=$field?>');"><img src="images/icons/html_go.png" alt="">Редактор</a>
										</div>
										<textarea name="<?=$field?>" <?=Editor::set_readonly($meta['readonly'])?>><?=isset($this->input_params[$field])?$this->input_params[$field]:$meta['default']?></textarea>
									<?	break;
									case 'textarea': ?>
										<textarea name="<?=$field?>" <?=Editor::set_readonly($meta['readonly'])?>><?=isset($this->input_params[$field])?$this->input_params[$field]:$meta['default']?></textarea>
									<?	break;
									case 'image':
									case 'image_preview': ?>
                                    	<input type="hidden" name="<?=$field?>_generate_preview" value="<?=(isset($this->input_params[$field]) and $this->input_params[$field] != GENERATE_PREVIEW_TEXT)?$this->post_params[$field . '_generate_preview']:1?>" />
								<?	case 'image_big':
										if ($meta['type'] != 'image_preview') {
											$is_source_for_resizing = true;
										}
										if (!$meta['readonly']) { 
										$has_dlg = true;?>
										<input type="text" name="<?=$field?>" value="<?=isset($this->input_params[$field])?$this->input_params[$field]:(($meta['type'] == 'image_preview' and RESIZE_ENABLED)?GENERATE_PREVIEW_TEXT:'')?>" class="text<?=$meta['type'] == 'image_preview'?' image-preview':''?>" <?=Editor::set_readonly($meta['readonly'])?> /><span class="cm_img_dlg">
											<a href="#" onClick="inputToSetUrlName='<?=$field?>'; window.open('htmleditor/editor/filemanager/browser/default/browser.html?Type=Image&CurrentFolder=<?=$file_browser_current_folder?>&Connector=http<?=$_SERVER['HTTPS']?'s':''?>%3A%2F%2F<?=current(explode(':', $_SERVER['HTTP_HOST']))?>%2Fadmin%2Fhtmleditor%2Feditor%2Ffilemanager%2Fconnectors%2Fphp%2Fconnector.php', '_blank', 'width=600,height=500,resizable=1'); return false;">
												<img src="images/icons/folder_image.png" alt="Выбрать картинку" title="Выбрать картинку"></a>
										<?	if ($meta['type'] == 'image_preview' and $is_source_for_resizing) { ?><a href="#" onClick="document.editForm.<?=$field?>_generate_preview.value = 1; document.editForm.<?=$field?>.value = '<?=GENERATE_PREVIEW_TEXT?>'; return false"><img src="images/icons/image_gear.png" alt="<?=GENERATE_PREVIEW_TEXT?>" title="<?=GENERATE_PREVIEW_TEXT?>" /></a><a href="#" onClick="openEditWindow('crop.php?img_src=' + editForm.<?=$current_image_field?>.value + '&title=<?=urlencode($meta['title'])?>&field=<?=$field?>&thumb_path=<?=urlencode($config['GALLERY_THUMBNAIL_ALT_PATH'])?>', 980, 750); return false"><img src="images/icons/image_edit.png" alt="Вырезать область" title="Вырезать область" /></a>
                                        <?	} else {
												$current_image_field = $field;
											} ?>
										</span>
                                    <?	} else { ?>
                                    	<img src="<?=$this->record[$field]?>" alt="" />
                                        <input type="hidden" name="<?=$field?>" value="<?=$this->record[$field]?>" />
									<?	}
										break;
									case 'doc': ?>
										<input type="text" name="<?=$field?>" value="<?=isset($this->input_params[$field])?$this->input_params[$field]:$meta['default']?>" class="text" <?=Editor::set_readonly($meta['readonly'])?> /><span class="cm_img_dlg">
											<a href="#" onClick="inputToSetUrlName='<?=$field?>'; window.open('htmleditor/editor/filemanager/browser/default/browser.html?Type=File&CurrentFolder=<?=$file_browser_current_folder?>&Connector=http<?=$_SERVER['HTTPS']?'s':''?>%3A%2F%2F<?=$_SERVER['HTTP_HOST']?>%2Fadmin%2Fhtmleditor%2Feditor%2Ffilemanager%2Fconnectors%2Fphp%2Fconnector.php', '_blank', 'width=600,height=500,resizable=1'); return false;">
												<img src="images/icons/folder_image.png" alt="Выбрать документ" title="Выбрать документ"></a>
										</span>
									<?	break;
									case 'flash':
										$has_dlg = true; ?>
										<input type="text" name="<?=$field?>" value="<?=isset($this->input_params[$field])?$this->input_params[$field]:$meta['default']?>" class="text" <?=Editor::set_readonly($meta['readonly'])?> /><span class="cm_img_dlg">
											<a href="#" onClick="inputToSetUrlName='<?=$field?>'; window.open('htmleditor/editor/filemanager/browser/default/browser.html?Type=Media&CurrentFolder=<?=$file_browser_current_folder?>&Connector=http<?=$_SERVER['HTTPS']?'s':''?>%3A%2F%2F<?=$_SERVER['HTTP_HOST']?>%2Fadmin%2Fhtmleditor%2Feditor%2Ffilemanager%2Fconnectors%2Fphp%2Fconnector.php', '_blank', 'width=600,height=500,resizable=1'); return false;">
												<img src="images/icons/folder_picture.png" alt="Выбрать флэш" title="Выбрать флэш"></a>
										</span>
									<?	break;
									case 'video':
										$has_dlg = true; ?>
										<input type="text" name="<?=$field?>" value="<?=isset($this->input_params[$field])?$this->input_params[$field]:$meta['default']?>" class="text" <?=Editor::set_readonly($meta['readonly'])?> /><span class="cm_img_dlg">
											<a href="#" onClick="inputToSetUrlName='<?=$field?>'; window.open('htmleditor/editor/filemanager/browser/default/browser.html?Type=Media&CurrentFolder=<?=$file_browser_current_folder?>&Connector=http<?=$_SERVER['HTTPS']?'s':''?>%3A%2F%2F<?=$_SERVER['HTTP_HOST']?>%2Fadmin%2Fhtmleditor%2Feditor%2Ffilemanager%2Fconnectors%2Fphp%2Fconnector.php', '_blank', 'width=600,height=500,resizable=1'); return false;">
												<img src="images/icons/folder_picture.png" alt="Выбрать видео" title="Выбрать видео"></a>
										</span>
									<?	break;
									case 'date':
									case 'datetime': // ! todo: add input for time ?>
										<input type="text" name="<?=$field?>" value="<?=$this->input_params[$field]?$this->input_params[$field]:(isset($meta['default'])?$meta['default']:$meta['required']?date(str_replace("%", "", get_date_format())):'')?>" id="<?=$field?>" <?=Editor::set_readonly($meta['readonly'])?> />
									<?	if (!$meta['readonly']) { 
											$has_dlg = true; ?>
											<span class="cm_img_dlg">
												<a href="javascript:return false">
													<img src="images/icons/calendar_view_month.png" id="<?=$field?>_toggle" alt="Выбрать дату" title="Выбрать дату">
												</a>
											</span>
											<script>
												window.addEvent('domready', function() {
											<?	if ($this->input_params[$field] or $meta['required'])
													$date_expl = explode(DATE_SEPARATOR, isset($this->input_params[$field])?$this->input_params[$field]:date(str_replace("%", "", get_date_format())));
												else {
													$date_expl = '';
												} ?>
												new vlaDatePicker('<?=$field?>', { openWith: '<?=$field?>_toggle', startMonday: true, separator: '<?=DATE_SEPARATOR?>', prefillDate: <?=$date_expl[0]?'{ day: ' . $date_expl[DATE_MONTH_FIRST?1:0] . ', month: ' . $date_expl[DATE_MONTH_FIRST?0:1] . ', year: ' . $date_expl[2] . ' }':'false'?>, alignX: 'left', alignY: 'bottom', offset: { x: 160, y: -26 }, format: '<?=strtolower(str_replace('%', '', current(explode(" ", get_date_format()))))?>', toggleDuration: 0, filePath: 'calendar/inc/' });
												});
											</script> 
									<?	}
										break;
									case 'lookup_custom':
										$meta['sql_custom'] = "SELECT id, title, is_group_title FROM meta_table_field_option WHERE meta_table_field_id = " . $meta['field_id'] . " ORDER BY sort_num, title";
									case 'lookup':
									case 'lookup_external': 
										if (!$meta['readonly']) {
											if (!$meta['lookup_multi']) { ?>
												<select name="<?=$field?>">
	                                        <?	/*if (empty($meta['options_custom'])) {?>
												<option value="">--</option>
	                                        <?	} */?>
												<?=$lookup_res = Editor::lookup($meta['lookup_meta_table'], $meta['lookup_field'], $this->site_id, isset($this->input_params[$field])?$this->input_params[$field]:$meta['default'], $meta['lookup_filter'], $this->conn, $meta['sql_custom'], $meta['options_custom'])?>
												</select><? if ($meta['lookup_quick_add']) { ?><span class="cm_img_dlg"><a href="edit.php?type=<?=$meta['lookup_meta_table']?>&new=yes&quickadd=yes" target="_blank" onclick="window.open('edit.php?type=<?=$meta['lookup_meta_table']?>&new=yes&quickadd=yes', '_blank', 'width=600,height=500,resizable=1'); return false"><img src="images/icons/page_white_add.png" alt="Добавить" /></a></span><? } ?>
                                            <?	if ($meta['required']) { ?>
                                                <script> 
													jQuery(function() {
														if (jQuery("select[name='<?=$field?>'] option").length == 2) {
															jQuery("select[name='<?=$field?>']")[0].selectedIndex = 1;
														}
													});
                                                </script>
                                            <?	}
											} else if ($meta['type'] == 'lookup_external') { ?>
                                                <input type="hidden" name="<?=$field?>" value="<?=$this->input_params[$field]?>" id="lookup_external_total_<?=$field?>" />
                                                <div class="lookup_external_options" id="lookup_external_options_<?=$field?>">
                                                <?	$field_ids = explode(",", $this->input_params[$field]);
                                                    foreach ($field_ids as $count => &$field_id) { 
                                                        if (!$field_id) continue; ?>
                                                        <div class="lookup_external_option" id="lookup_external_option_<?=trim($field_id)?>"><span class="lookup_external_option_text"></span> <a href="javascript:;" class="lookup_external_option_delete">[x]</a></div>
                                                <?	}
                                                    unset($field_id); ?>
                                                </div>
                                                <select class="lookup_external_select" id="lookup_external_select_<?=$field?>">
                                                    <option value="">--добавить значение</option>
                                                    <?=$lookup_res = Editor::lookup($meta['lookup_meta_table'], $meta['lookup_field'], $this->site_id, NULL, $meta['lookup_filter'], $this->conn, NULL, NULL, false, NULL, true)?>
                                                </select>
										<?	} else { ?>
												<?=$lookup_res = Editor::lookup($meta['lookup_meta_table'], $meta['lookup_field'], $this->site_id, isset($this->input_params[$field])?$this->input_params[$field]:$meta['default'], $meta['lookup_filter'], $this->conn, $meta['sql_custom'], $meta['options_custom'], true, $field)?>
                                        <?	}
										} else if (!$this->is_new) { ?>
											<input type="text" name="<?=$field?>_view" value="<?=htmlspecialchars($this->record[$field . '_lookup'])?>" <?=Editor::set_readonly($meta['readonly'])?> />
											<input type="hidden" name="<?=$field?>" value="<?=$this->record[$field]?>" />
									<?	} else if (isset($this->input_params[$field])) { ?>
                                            <select name="<?=$field?>" disabled="">
                                            <?=$lookup_res = Editor::lookup($meta['lookup_meta_table'], $meta['lookup_field'], $this->site_id, $this->input_params[$field], $meta['lookup_filter'], $this->conn, $meta['sql_custom'], $meta['options_custom'])?>
                                            </select>
                                            <input type="hidden" name="<?=$field?>" value="<?=$this->input_params[$field]?>" />
									<?	} // else todo?
										break;
/*									case 'lookup_external': 
										if (!$meta['readonly']) { ?>
                                            <input type="hidden" name="<?=$field?>" value="<?=$this->input_params[$field]?>" id="lookup_external_total_<?=$field?>" />
                                            <div class="lookup_external_options" id="lookup_external_options_<?=$field?>">
                                            <?	$field_ids = explode(",", $this->input_params[$field]);
                                                foreach ($field_ids as $count => &$field_id) { 
                                                    if (!$field_id) continue; ?>
                                                    <div class="lookup_external_option" id="lookup_external_option_<?=trim($field_id)?>"><span class="lookup_external_option_text"></span> <a href="javascript:;" class="lookup_external_option_delete">[x]</a></div>
                                            <?	}
                                                unset($field_id); ?>
                                            </div>
                                            <select class="lookup_external_select" id="lookup_external_select_<?=$field?>">
                                                <option value="">--добавить значение</option>
                                                <?=$lookup_res = Editor::lookup($meta['lookup_meta_table'], $meta['lookup_field'], $this->site_id, NULL, $meta['lookup_filter'], $this->conn)?>
                                            </select>
								<?		} else { ?>
											<input type="text" name="<?=$field?>_view" value="<?=htmlspecialchars($this->record[$field . '_lookup'])?>" <?=Editor::set_readonly($meta['readonly'])?> />
											<input type="hidden" name="<?=$field?>" value="<?=$this->record[$field]?>" />
								<?		}
										break;*/
									case 'password': ?>
                                    	<input type="password" name="<?=$field?>" value="" class="text" />
								<?		break;
									case 'file': ?>
                                    	<input type="file" name="<?=$field?>" value="" class="text" style="height: 2em;" />
								<?		break;
									default: ?>
										<input type="text" name="<?=$field?>" value="<?=htmlspecialchars(isset($this->input_params[$field])?$this->input_params[$field]:$meta['default'])?>" id="field_<?=$field?>" <?=Editor::set_readonly($meta['readonly'])?><?=$meta['width']?' maxlength=' . $meta['width']:''?> />
                                    <?	if ('currency' == $meta['type']) { ?>
                                    	<div id="field_<?=$field?>_currency" class="cm-currency"></div>
                                        <script>
											jQuery(function () {
												jQuery("#field_<?=$field?>_currency").prev().addClass("cm-price-w-currency");
												var $next_line = jQuery("#field_<?=$field?>_currency").closest("tr").next();
												jQuery("#field_<?=$field?>_currency").html(jQuery(".input", $next_line).html());
												$next_line.remove();
											});
                                        </script>
									<?	} ?>
									<?	if ($meta['type'] == 'google_map') { 
											$has_dlg = true;?>
                                            <span class="cm_img_dlg">
                                                <a href="javascript:;" class="iframe" id="field_<?=$field?>_picker" onclick="inputToSetCoordinates='<?=$field?>'; window.open('map_picker.html', '_blank', 'width=800,height=600,resizable=1'); return false;"><img src="images/icons/world.png" alt="" title="Получить координаты на карте" /></a>
                                            </span>
                                    <?	} ?>
								<?	} 
									if (0 === strpos($meta['type'], 'lookup') and !(isset($lookup_res) and $lookup_res)) { ?>
										<script>
											var field_name_obj = jQuery("[name='<?=$field?>'] option:selected").attr("value", "__other").closest(".input").prev();
											field_name_obj.text(field_name_obj.text().trim().replace(/\*:$/g, ":"));
											field_name_obj.closest("tr").hide();
										</script>
							<?		}
									unset($lookup_res);
/*								if ($meta['comment'] and !$has_dlg) { // ?>
									<span class="cm_img_dlg">
										<img src="images/icons/information.png" alt="" title="<?=htmlspecialchars($meta['comment'])?>" />
									</span>
							<?	} */?>
						</td></tr>
					<?	} else { ?>
							<input type="hidden" name="<?=$field?>" value="<?=htmlspecialchars(isset($this->input_params[$field])?$this->input_params[$field]:$meta['default'])?>" />
					<?	}
						$field_group[$meta['field_group_id']] .= ob_get_clean();
						$field_group_bookmark[$meta['field_group_id']] = $meta['field_group'];
					}
					unset($meta);
					if (isset($field_group)) {
						if (count($field_group_bookmark) > 1) { ?>
                        	<div class="cm-edit-bookmarks">
							<?	$i = 0;
                                foreach ($field_group_bookmark as &$field_bookmark) { 
									if ($i != 0) { ?>
                                    <div class="cm-panel-separator"></div>
                                <?	} ?>
                                    <a href="#block<?=$i?>"><?=$field_bookmark?></a>
                            <?	 $i++;
								}
                                unset($field_bookmark); ?>
                            </div>
	                        <div style="clear: both;"></div>
					<?	}
					 	$i = 0;
						foreach ($field_group as $field_group_id => &$field_block) { ?>
                        	<div class="cm-edit-block"<?=$i != 0?' style="display: none"':''?> id="block<?=$i++?>">
                        	<table>
							<?=$field_block?>
                        	</table>
                            </div>
					<?	}
						unset($field_block); ?>
						<script>
		                jQuery(function() {
        		            jQuery(".cm-edit-bookmarks a").click(function() {
								jQuery(".cm-edit-block").hide();
								jQuery(jQuery(this).attr("href")).show();
								return false;
							});
						});
						</script>
				<?	} ?>
				 <div class="cm-edit-submit">
                    <input type="submit" value="<?=!$this->is_send?'Сохранить':'Отправить'?>" class="submit<?=!$this->is_send?'':' submit-send'?>"<?=(!$this->table_meta['editable'])?' disabled=""':''?> />
                    <input type="button" value="Отменить" onclick="window.close()" />
                    <input type="hidden" name="<?=$this->update_param_name?>" value="1" />
				 </div>
			</td></tr></table>
			</form>
		<?	}
		}
	} // function render()

	function get_init_input() {
		if ($this->record) { // get data from database record
			foreach ($this->record_meta as $field => &$meta) {
				$this->input_params[$field] = $this->record[$field];
			}
			unset($meta);
		}

		// get data from get parameters - after getting from database, that's important
		foreach ($this->get_params as $param => &$value) {
			if (strpos($param, '_id') !== false) {
//				$this->record_meta[$param]['type'] = 'hidden';
				$this->input_params[$param] = $value;
			}
		}
		unset($value);
		
		if ($this->record_meta['meta_table_id']) {
			$this->record_meta['meta_table_id']['default'] = $this->table;
		}

		$this->init_params = $this->input_params;
	}
	
	function get_form_input() { 
		foreach ($this->record_meta as $field => &$meta) {
			if (!$meta['lookup_multi'] or $meta['type'] == 'lookup_external') {
				$this->input_params[$field] = trim($this->post_params[$field]);
			} else { 
				if (is_array($this->post_params[$field])) {
					$this->input_params[$field] = implode(',', $this->post_params[$field]);
				} else {
					$this->input_params[$field] = '';
				}
			}
		}
		unset($meta);
		
		// portal: get current user
		if (isset($this->record_meta['user_id']) and empty($this->input_params['user_id'])) {
			$this->input_params['user_id'] = $_SESSION['admin_id'];
		}
		
		// languages
		// ! todo: check if 'meta_site_lang_id' field really exists
		if (is_array($this->post_params["meta_site_lang_id"])) {
			$this->input_params["meta_site_lang_id"] = implode(',', $this->post_params["meta_site_lang_id"]);
		}
	}

	function validate_input() {
		global $config;
		foreach ($this->input_params as $field => &$value) {
			if ($this->record_meta[$field]['type'] == 'file') {
				if ($this->record_meta[$field]['required'] and !$_FILES[$field]['name']) {
					$this->alert .= "Не выбран файл \"" . $this->record_meta[$field]['title'] . "\"\n";
					return false;
				} else if ($_FILES[$field]['name'] and (!$_FILES[$field]['tmp_name'] or !is_uploaded_file($_FILES[$field]['tmp_name']))) {
					$this->alert .= "Ошибка на сервере при загрузке файла \"" . $this->record_meta[$field]['title'] . "\"\n";
					return false;
				}
			} else {
				if ($this->site_langs_extra and $this->table_meta['multi_lang'] and $this->record_meta[$field]['multi_lang']) {
					if (!is_array($this->post_params['meta_site_lang_id'])) {
						$this->alert .= "Должен быть выбран хотя бы один язык\n";
						return false;
					}
					if ($this->record_meta[$field]['required'] and $value === '' and
							(!$this->record_meta[$field]['is_extra_lang'] and false !== array_search('', $this->post_params['meta_site_lang_id']) or
						 	$this->record_meta[$field]['is_extra_lang'] and false !== array_search($this->record_meta[$field]['lang_id'], $this->post_params['meta_site_lang_id']))) {
						$this->alert .= "Не заполнено обязательное поле \"" . $this->record_meta[$field]['title'] . "\"\n";
						return false;
					}
				} else {
					if ($this->record_meta[$field]['required'] and $value === '') {
						$this->alert .= "Не заполнено обязательное поле \"" . $this->record_meta[$field]['title'] . "\"\n";
						return false;
					}
				}
				if ('id' == $field and '' === $this->record_meta[$field]['type'] and '' !== $value and !preg_match("/^[a-z0-9_\-]+$/", $value)) {
					$this->alert .= "Поле \"" . $this->record_meta[$field]['title'] . "\" может содержать только строчные буквы латинского алфавита цифры, знаки _-\n";
					return false;
				}
				if (0 === strpos($this->record_meta[$field]['type'], 'image')) {
					// generate preview
					if ($this->record_meta[$field]['type'] == 'image_preview' and $this->post_params[$field . '_generate_preview'] and $this->post_params[$field] == GENERATE_PREVIEW_TEXT) {
	
						preg_match_all(SIZE_PATTERN, $this->record_meta[$field]['title'], $size, PREG_SET_ORDER);
						if ($size[0]) {
							$w = (int)$size[0][1];
							$h = (int)$size[0][3];
		
							// check image size
							if (false !== (list($image_width, $image_height) = @getimagesize($_SERVER['DOCUMENT_ROOT'] . $value)) and !((0 == $w or $image_width == $w or $image_width == $w*2) and (0 == $h or $image_height == $h or $image_height == $h*2))) {
								$this->alert .= "Неправильный размер картинки \"" . $this->record_meta[$field]['title'] . "\"" . ((0 == $w or 0 == $h)?" (? - любой размер)":'') . "\n";
								return false;
							}
						}
		
						// find field with the source image for this preview
						$record_meta_rev = array_reverse($this->record_meta, true);
						$field_is_above = false;
						foreach ($record_meta_rev as $record_field => $record_meta) {
							if ($record_meta['type'] == 'image' or $record_meta['type'] == 'image_big') {
								$image_source = $this->input_params[$record_field];
								if ($field_is_above) {
									break;
								}
							}
							if ($record_field == $field) {
								$field_is_above = true;
							}
						}
						unset($record_meta);
						
						if ($image_source) {
							$image_source = $_SERVER['DOCUMENT_ROOT'] . $image_source;
							$thumbnail_path = !$config['GALLERY_THUMBNAIL_ALT_PATH']?
								(dirname($image_source) . '/' . ($config['GALLERY_THUMBNAIL_DIR_NAME']?$config['GALLERY_THUMBNAIL_DIR_NAME']:'.resize')):
								$_SERVER['DOCUMENT_ROOT'] . $config['GALLERY_THUMBNAIL_ALT_PATH'];
							
							if (!file_exists($thumbnail_path) and !@mkdir($thumbnail_path)) {
								$this->alert .= "Ошибка при генерации превью (Error creating thumbnail directory ".$thumbnail_path .")\n";
								return false;
							} else if (false === ($this->input_params[$field] = create_thumbnail(
								$image_source,
								$thumbnail_path . '/' . basename($image_source),
								$w, $h, $w == 0?'h':($h == 0?'w':'')
								))) {
									$this->alert .= "Ошибка при генерации превью (Error creating thumbnail in ".$thumbnail_path .")\n";
									return false;
							}
						} else {
							$this->input_params[$field] = '';
						}
					}
				}
				// make link to our own host relative
				if ($this->record_meta[$field]['type'] == 'url') {
					if(count($url_split = explode($_SERVER['SERVER_NAME'], $this->input_params[$field])) > 1) {
						$this->input_params[$field] = $url_split[1];
					}
				}
				// parse google's link
				if ($this->record_meta[$field]['type'] == 'google_map') {
					if (strpos($this->input_params[$field], 'll=') !== false) {
						$this->input_params[$field] = current(explode('&', next(explode('ll=', $this->input_params[$field]))));
					}
				}
			}
		}
		unset($value);
		return true;
	}

	function insert() {
		Editor::prepare_mysql_meta($fields, $null_fields, $this->conn);
	
		// SEO
		$sef_url_rules = get_sef_url_rules($this->conn);
		
		$fields_line = "";
		$values_line = "";
		$exception = NULL;
		foreach ($this->input_params as $field => $value) {
			if (array_key_exists($field, $fields)) {
				$fields_line .= "`" . $field . "`,";
				$values_line .= Editor::prepare_field_value($value, $field, $fields, $null_fields, $exception, $this->conn) . ",";
				if ($exception !== NULL) {
					break;
				}
			}
			if ($this->record_meta[$field]['type'] == 'lookup_external') {
				$field_values = explode(",", trim($value, "'"));
				if (is_array($field_values)) {
					foreach($field_values as &$field_value) {
						if ($value and 'NULL' != $value) {
							$update_external[] = "INSERT INTO `" . $this->record_meta[$field]['lookup_external_table'] . "` (`" . $this->table_meta['table_name'] . "_id`, `" . $this->record_meta[$field]['lookup_meta_table'] . "_id`) VALUES ('{master_id}', '" . mysql_real_escape_string($field_value, $this->conn) . "');\n";
						}
					}
					unset($field_value);
				}
			}
			// SEO
			if ($sef_url_rules) {
				foreach ($sef_url_rules as $sef_param_name => &$sef_rule) {
					if ($sef_rule['values_table'] == $this->table_meta['table_name'] and $sef_rule['values_source_field'] == $field) {
					  $sef_rule_matched = $sef_rule;
					  $sef_source_value = $value;
					}
				}
				unset($sef_rule);
			}
		}
		unset($value);
		if ($exception === NULL) {
			if ($this->table_meta['depends_on_site']) {
				$fields_line .= "meta_site_id";
				$values_line .= "'" . mysql_real_escape_string($this->site_id, $this->conn) . "'";
			} else {
				$fields_line = rtrim($fields_line, ','); // remove trailing comma
				$values_line = rtrim($values_line, ',');
			}
			if ($this->table_meta['filter_data_by_meta_table'] and !preg_match("/\bmeta_table_id\b/", $fields_line)) {
				$fields_line .= ",meta_table_id";
				$values_line .= ",'" . $this->table . "'";
			}
			
			if ($update_external) {
				db_mysql_query("START TRANSACTION", $this->conn);
			}

			$res = db_mysql_query("INSERT INTO `" . $this->table_meta['table_name'] . "` (" . $fields_line . ") VALUES (" . $values_line . ")", $this->conn);
	
			// to do ! process string IDs here
//			$_SESSION["lastInsertID"] = 0;
			if ($res === true) {
				if (!$this->input_params['id']) {
					$rs_id = db_mysql_query("SELECT LAST_INSERT_ID()", $this->conn);
					if ($row = @mysql_fetch_array($rs_id))
//						$_SESSION["lastInsertID"] = $row[0];
						$this->inserted_id = $row[0];
					mysql_free_result($rs_id);
				} else {
					$this->inserted_id = $this->input_params['id'];
//					$_SESSION["lastInsertID"] = $this->input_params['id'];
				}

				if ($update_external) {
					if (true === $res) {
						foreach($update_external as &$update_external_sql) {
							if (true !== ($res = db_mysql_query(str_replace('{master_id}', $this->inserted_id, $update_external_sql), $this->conn))) {
								break;
							}
						}
						unset($update_external_sql);
					}
					if (true === $res)
						db_mysql_query("COMMIT", $this->conn);
					else
						db_mysql_query("ROLLBACK", $this->conn);
				}
				
				// SEO
				// what's on edit? nothing, i guess
				if ($sef_rule_matched) {
					if (true !== ($res = db_mysql_query("UPDATE `" . $sef_rule_matched['values_table'] . "` SET `" . $sef_rule_matched['values_target_field'] . "` = '" . mysql_real_escape_string(make_safe_url(transliterate($sef_source_value)), $this->conn) . "' WHERE id = " . $this->inserted_id, $this->conn))) {
						$res = db_mysql_query("UPDATE `" . $sef_rule_matched['values_table'] . "` SET `" . $sef_rule_matched['values_target_field'] . "` = '" . mysql_real_escape_string(make_safe_url($this->inserted_id . '-' . transliterate($sef_source_value)), $this->conn) . "' WHERE id = " . $this->inserted_id, $this->conn);
					}
				}
				
			}
		} else {
			$res = $exception;
		}
	
		return $res;
	}
	
	function update() {
		Editor::prepare_mysql_meta($fields, $null_fields, $this->conn);
		
		$update_line = "";
		$exception = NULL;
		foreach ($this->input_params as $field => $value) {
			if (array_key_exists($field, $fields)) {
				$value = Editor::prepare_field_value($value, $field, $fields, $null_fields, $exception, $this->conn);
				if ($exception !== NULL) {
					break;
				}
				$update_line .= "`" . $field . "` = " . $value . ",";
			}
			if ($this->record_meta[$field]['type'] == 'lookup_external' and $value != $this->init_params[$field]) {
				if (isset($this->init_params[$field]) and !($this->table == 'meta_table' and $field == 'section_type_id')) { // little hack for meta_table.section_type_id - it's very handy, though the meta_table2section_type link table has one extra field
					$rs = db_mysql_query("DESC `" . $this->record_meta[$field]['lookup_external_table'] . "`", $this->conn);
					while($row_desc = mysql_fetch_row($rs)) {
						// todo - update without deleting (?)
						if ($row_desc[0] != 'id' and $row_desc[0] != $this->table_meta['table_name'] . "_id" and $row_desc[0] != $this->record_meta[$field]['lookup_meta_table'] . "_id") {
							$exception = "Can't update external lookup field (" . $field . "): there are some extra data fields in the link table (" . $this->record_meta[$field]['lookup_external_table'] . ")"; 
							break;
						}
					}
					mysql_free_result($rs);
				}
				if ($exception === NULL) {
					$update_external[] = "DELETE FROM `" . $this->record_meta[$field]['lookup_external_table'] . "` WHERE `" . $this->table_meta['table_name'] . "_id` = '" . mysql_real_escape_string($this->id, $this->conn) . "';\n";
					$field_values = explode(",", trim($value, "'"));
					if (is_array($field_values)) {
						foreach($field_values as &$field_value) {
							if ($value and 'NULL' != $value) {
								$update_external[] = "INSERT INTO `" . $this->record_meta[$field]['lookup_external_table'] . "` (`" . $this->table_meta['table_name'] . "_id`, `" . $this->record_meta[$field]['lookup_meta_table'] . "_id`) VALUES ('" . mysql_real_escape_string($this->id, $this->conn) . "', '" . mysql_real_escape_string($field_value, $this->conn) . "');\n";
							}
						}
						unset($field_value);
					}
				} else {
					break;
				}
			}
		}
		unset($value);

		if ($exception === NULL) {
			$update_line = rtrim($update_line, ','); // remove trailing comma
			
			if ($update_external) {
				db_mysql_query("START TRANSACTION", $this->conn);
			}
		
			$res = db_mysql_query("UPDATE `" . $this->table_meta['table_name'] . "` SET " . $update_line . " WHERE id = '" . mysql_real_escape_string($this->id, $this->conn) . "'", $this->conn);

			if ($update_external) {
				if (true === $res) {
					foreach($update_external as &$update_external_sql) {
						if (true !== ($res = db_mysql_query($update_external_sql, $this->conn))) {
							break;
						}
					}
					unset($update_external_sql);
				}
				if (true === $res)
					db_mysql_query("COMMIT", $this->conn);
				else
					db_mysql_query("ROLLBACK", $this->conn);
			}
		} else {
			$res = $exception;
		}
		return $res;
	}

	function on_update_success($do_not_close = false) { ?>
		<script type="text/javascript">
		<?	if (!$_GET['quickadd']) {
           		if ($this->is_new and !$this->table_meta['is_many2many']) { ?>
					window.opener.location.href = "view.php?type=<?=$this->table?>&id=<?=$this->inserted_id?>&inserted=1";
				<? } else {?>
					window.opener.location.reload();
				<? }
				   if ($this->table_meta['is_in_site_tree']) { ?>
				   	if (window.opener.parent.tree.location.href.indexOf("mode=sitetree") != -1) {
						window.opener.parent.tree.location.hash = "<?=$this->inserted_id?>";
						reloadTree(true)
					}
				<? }
				if (!$do_not_close) { ?>
					window.close();
			<?	}
			} else { ?>
//				window.opener.location.reload();
				window.opener.focus();
				setTimeout("select_quick_add(); window.close();", 1000);
				
				function select_quick_add() {
					var lookup_el = window.opener.document.forms[0].elements['<?=$this->table?>_id'];
					// !! hardcode - title
					// TODO: get title from table's main field
					lookup_el.options[lookup_el.options.length] = new Option(window.document.forms[0].elements['title'].value, <?=$this->inserted_id?>);
					for (var i=0; i<lookup_el.options.length; i++) {
						if (lookup_el.options[i].value == <?=$this->inserted_id?>) {
							lookup_el.selectedIndex = i;
							break
						}
					}
				}
		<?	}  ?>
        </script>
<?	}

	function on_update_error($error_message) {
		$this->alert = handle_db_alert($error_message);
	}

	function set_title($title) { 
		$this->title = $title;
	}

	function set_alert($alert) { 
		$this->alert = $alert;
	}

	function check_constraints($sub_meta_tables = NULL) { // if parameter is defined (array) check only constraints with name in the array
		$res = true;
		foreach($this->sub_query as $sub_query) {
			if ($sub_query->rec_count and (!$sub_meta_tables or in_array($sub_query->table, $sub_meta_tables))) {
				$res = false;
				break;
			}
		}
		unset($sub_query);
		return $res;
	}

	// static functions
	function lookup($meta_table_name, $field_name, $site_id, $current_id, $sql_lookup_filter, $conn, $sql_custom = NULL, $options_custom = NULL, $is_multi = false, $master_field_name = NULL, $is_external = false) {
		$tree_lookup_table_names = array('section', 'product_folder'); // to do;
		
		// ! portal hardcode
/*		if ($meta_table_name == 'portal_object_menu') {
			$sql_lookup_filter = "CONCAT(meta_table_id, '_', portal_object_menu_type_id) = '" . $this->table . "'";
		}*/
	
		if ($options_custom) {
			return Editor::lookup_custom($options_custom, $current_id);
		} else {
			if ($sql_custom) { 
				$rs = db_mysql_query($sql_custom, $conn);
				if ($is_multi) {
					$current_ids = explode(',', $current_id);
					$options_in_col = ceil(mysql_num_rows($rs) / 3);
				}
				while ($row = mysql_fetch_row($rs)) {
					if (!$is_multi) {
						if ($row[0] === '') $no_empty_line = true;
						$res .= '<option value="'.$row[0].'"'.($row[0]==$current_id?' selected':'').'>'.htmlspecialchars($row[1]).'</option>';
					} else {
						if (0 == $i++ % $options_in_col) {
							$res .= '</div><div class="cm-checkbox-group">';
						}
//						if ($row[2]) { // group title
//							$res .= '<div class="cm-checkbox"><strong>'.htmlspecialchars($row[1])."</strong></div>";
//						} else {
							$res .= '<div class="cm-checkbox"><input type="checkbox" name="'.$master_field_name.'[]" value="'.$row[0].'"'.(in_array($row[0],$current_ids)?' checked':'').' id="'.$master_field_name.'_'.$row[0].'" /> <label for="'.$master_field_name.'_'.$row[0].'">'.($row[2]?'<strong>'.htmlspecialchars($row[1]).'</strong>':htmlspecialchars($row[1]))."</label></div>";
//						}
					}
				}
				mysql_free_result($rs);
			} else {
				$rs_meta = db_mysql_query("SELECT id, table_name, depends_on_site FROM meta_table WHERE table_name = '" . mysql_real_escape_string($meta_table_name, $conn) . "'", $conn); // WHERE id = ...
				if ($row_meta = mysql_fetch_assoc($rs_meta)) {
					$table = $row_meta['id'];
					$table_name = $row_meta['table_name'];
					$select_by_site = $row_meta['depends_on_site'];
			
					if (in_array($meta_table_name, $tree_lookup_table_names)) {
						$res = Editor::lookup_tree($table_name, $field_name, $select_by_site?$site_id:NULL, $current_id, $sql_lookup_filter, $conn);
					} else {
						if ($select_by_site) {
							$lookup_where = "meta_site_id = '" . mysql_real_escape_string($site_id, $conn) . "'";
						} else {
							$lookup_where = "1";
						}
						// todo - sort_num, is_group_title (and others, like id) are reserved names after all - handle it somehow
						// maybe sort by this field automatically everywhere if type_extra='sort' (set default_order_num=0?? 0 is just the number on top)
						$rs_is_order = db_mysql_query("SELECT 1 FROM meta_table_field WHERE meta_table_id = '" . mysql_real_escape_string($table) . "' AND field = 'sort_num' AND type_extra='sort' AND published <> 0 LIMIT 1", $conn);
						if (mysql_num_rows($rs_is_order)) {
							$sort_by_order = true;
						}
						mysql_free_result($rs_is_order);
						$rs_is_group_title = db_mysql_query("SELECT 1 FROM meta_table_field WHERE meta_table_id = '" . mysql_real_escape_string($table) . "' AND field = 'is_group_title' AND published <> 0 LIMIT 1", $conn);
						if (mysql_num_rows($rs_is_group_title)) {
							$is_group_title_field = true;
						}
						mysql_free_result($rs_is_group_title);
/*						if (false !== mysql_query("SELECT sort_num FROM `" . $table_name . "` WHERE 1 LIMIT 1", $conn)) {
							$sort_by_order = true;
						}
						if (false !== mysql_query("SELECT is_group_title FROM `" . $table_name . "` WHERE 1 LIMIT 1", $conn)) {
							$is_group_title_field = true;
						}*/
						// todo. possible security issue - unescaped $sql_lookup_filter
						$rs = db_mysql_query($sql_custom?$sql_custom:"SELECT id, `" . $field_name . "`" . ($is_group_title_field?", is_group_title":"") . " FROM `" . $table_name . "` WHERE " . $lookup_where . ($sql_lookup_filter?" AND ".$sql_lookup_filter:'') . " ORDER BY " . ($sort_by_order?'sort_num,':'') . "2", $conn);
						if ($is_multi) {
							$current_ids = explode(',', $current_id);
							$options_in_col = ceil(mysql_num_rows($rs) / 3);
						}
						while ($row = mysql_fetch_row($rs)) {
							if (!$is_multi) {
								if ($row[0] === '') $no_empty_line = true;
								$res .= '<option value="'.$row[0].'"'.($row[0]==$current_id?' selected':'').'>'.htmlspecialchars($row[1]).'</option>';
							} else {
								if (0 == $i++ % $options_in_col) {
									$res .= '</div><div class="cm-checkbox-group">';
								}
//								if ($row[2]) { // group title
//									$res .= '<div class="cm-checkbox"><strong>'.htmlspecialchars($row[1])."</strong></div>";
//								} else {
									$res .= '<div class="cm-checkbox"><input type="checkbox" name="'.$master_field_name.'[]" value="'.$row[0].'"'.(in_array($row[0],$current_ids)?' checked':'').' id="'.$master_field_name.'_'.$row[0].'" /> <label for="'.$master_field_name.'_'.$row[0].'">'.($row[2]?'<strong>'.htmlspecialchars($row[1]).'</strong>':htmlspecialchars($row[1]))."</label></div>";
//								}
							}
						}
						mysql_free_result($rs);
					}
				}
				mysql_free_result($rs_meta);
			}
			if ($res) {
				if ($is_multi) {
					$res = '<div class="cm-checkbox-group">' . $res . '</div>';
				} else if (!$is_external and !$no_empty_line) {
					$res = '<option value="">--</option>' . $res;
				}
			}
			return $res;
		}
	}
	
/*	function lookup_external($table_name, $external_table_name, $field_name, $site_id, $sql_lookup_filter, $conn) {
		// let this kind of lookup be always multy
		if ($site_id !== NULL) {
			$lookup_where = " AND meta_site_id = '" . mysql_real_escape_string($site_id, $conn) . "'";
		} else {
			$lookup_where = "";
		}
		$rs = db_mysql_query("SELECT id, `" . $field_name . "` FROM `" . $table_name . "` WHERE 1" . $lookup_where . ($sql_lookup_filter?" AND ".$sql_lookup_filter:'') . " ORDER BY 2", $conn);
		$res = '<select name="' . $field_name . '">';
		while ($row = mysql_fetch_row($rs)) {
			$res .= '<option value="'.$row[0].'">'.htmlspecialchars($row[1]).'</option>';
		}
		$res = '</select>';
		mysql_free_result($rs);
		return $res;
	}*/

	function lookup_tree($table_name, $field_name, $site_id, $current_id, $sql_lookup_filter, $conn) {
		if ($site_id !== NULL) {
			$lookup_where = " AND meta_site_id = '" . mysql_real_escape_string($site_id, $conn) . "'";
		} else {
			$lookup_where = "";
		}
		$rs = db_mysql_query("SELECT id, `" . $field_name . "` FROM `" . $table_name . "` WHERE `" . $table_name . "_id` IS NULL" . $lookup_where . ($sql_lookup_filter?" AND ".$sql_lookup_filter:'') . " ORDER BY 2", $conn);
		while ($row = mysql_fetch_row($rs)) {
			$res .= '<option value="'.$row[0].'"'.($row[0]==$current_id?' selected':'').'>'.htmlspecialchars($row[1]).'</option>';
			$res .= Editor::lookup_tree_in($table_name, $field_name, $row[0], $current_id, $sql_lookup_filter, "", $conn);
		}
		mysql_free_result($rs);
		return $res;
	}
	
	function lookup_tree_in($table_name, $field_name, $id, $current_id, $sql_lookup_filter, $level_pad, $conn) {
		$res = "";
		$rs = db_mysql_query("SELECT s.id, s.`" . $field_name . "` FROM `" . $table_name . "` s WHERE s.`" . $table_name . "_id`  = '" . mysql_real_escape_string($id, $conn) . "'" . ($sql_lookup_filter?" AND ".$sql_lookup_filter:'') . " ORDER BY 2", $conn);
		while ($row = mysql_fetch_row($rs)) {
			$res .= '<option value="'.$row[0].'"'.($row[0]==$current_id?' selected':'').'>'.$level_pad."--".htmlspecialchars($row[1]).'</option>';
			$res .= Editor::lookup_tree_in($table_name, $field_name, $row[0], $current_id, $sql_lookup_filter, $level_pad."--", $conn);
		}
		mysql_free_result($rs);
		return $res;
	}
	
	function lookup_custom($lookup_options, $current_id) {
		$res = '';
		foreach ($lookup_options as $value => $option) {
			$res .= "<option ".($value == $current_id?"selected=\"\" ":"")."value=\"".$value."\">".htmlspecialchars($option)."</option>";
		}
		unset($option);
		return $res;
	}
	
	function make_related_select($master_field_name, $detail_field_name, $detail_void_title, $detail_other_option_title, $detail_other_field_name) { ?>
        <script type="text/javascript">
			jQuery(function() {
				var master_select = jQuery('select[name="<?=$master_field_name?>"]');
				var detail_select = jQuery('select[name="<?=$detail_field_name?>"]');
				var detail_options = detail_select.clone();

				master_select
					.change(function() {
						make_related_select(master_select, detail_select, '<?=$this->input_params[$detail_field_name]?>', detail_options, '<?=$detail_void_title?>');
						if (jQuery(":selected", master_select).val() != "") {
							detail_select.append('<option value="__other"><?=htmlspecialchars($detail_other_option_title)?></option>');
						}
					})
					.each(function() {jQuery(this).triggerHandler('change')});
				
				if (jQuery.trim(jQuery('input[name="<?=$detail_other_field_name?>"]').val()) != '') {
					detail_select.val("__other");
				}
			})	

			function make_related_select(master_obj, select_obj, current_id, options_clone, empty_text) {
				jQuery('option', select_obj).remove();
				
				var master_id = jQuery(':selected', master_obj).val();
				jQuery('option', select_obj).remove();
				if (master_id) {
					select_obj.append('<option value="">--<option>');
					jQuery('option', options_clone).each(function() {
						var ids = jQuery(this).val().split('-');
						if (master_id == ids[0]) {
							select_obj.append('<option value="' + ids[1] + '"' + (current_id==ids[1]?' selected=""':'') + '>' + jQuery(this).text()+ '<option>');
						}
					})
				} else {
					select_obj.append('<option value="">--' + empty_text + '<option>');
				}
				jQuery('option:empty', select_obj).remove();
			}
			
	</script>
<?	}

	function set_readonly($readonly = false) {
		 return $readonly?" class=\"text readonly\" readonly=\"\" ":" class=\"text\" ";
	}

	function prepare_mysql_meta(&$fields, &$null_fields, $conn) {
		$rs_meta = mysql_query("DESC `" . $this->table_meta['table_name'] . "`", $conn);
		while ($row = mysql_fetch_assoc($rs_meta)) {
			$fields[$row['Field']] = $row['Type'];
//			if ("YES" == strtoupper($row['Null']))
				$null_fields[$row['Field']] = $row['Default'];
		}
		mysql_free_result($rs_meta);
	}
	
	function prepare_field_value($value, $field, &$fields, &$null_fields, &$exception, $conn) {
		$value = trim($value);
		if ($value === "" or $value == "__other") { // select.append('<option value="__other">Другой объект</option>') and so on
/*			// gonna put column's default value into the NULL columns only
			// and not to let put an empty string into the NOT NULL columns
			if (is_array($null_fields) and !array_key_exists($field, $null_fields)) {
				$exception = "Column '" . $field . "' cannot be null";
				return false;
			}*/
			return $null_fields[$field] === NULL ? "NULL" : "'" . mysql_real_escape_string($null_fields[$field], $conn) . "'";
		}
		if (false !== strpos($fields[$field], 'int(')) {
			$value = str_replace(' ', '', $value);
			if ($value != (string)(int)$value) {
				$exception = "Incorrect integer value '" . $value . "' for column '" . $field . "'";
				return false;
			}
			return (int)$value;
		}
		if ('float' === $fields[$field] or 0 === strpos($fields[$field], 'decimal(') or 'double' === $fields[$field] or 'real' === $fields[$field]) {
			// ! TODO - not tested on different server locales
			$value = str_replace(' ', '', $value);
			$value = preg_replace("/(\d+)\,(\d{1,2})$/", '\\1.\\2', $value);
			if (preg_match("/^(\d{1,3}\,)+\d{3}(\.\d+)?$/", $value)) {
				$value = str_replace(',', '', $value);
			}
			if ($value != (string)(float)$value) {
				$exception = "Incorrect decimal point value '" . $value . "' for column '" . $field . "'";
				return false;
			}
			return (float)$value;
		}
		if ($fields[$field] === 'datetime') {
			if (!valid_date($value)) {
				$exception = "Incorrect datetime value '" . $value . "' for column '" . $field . "'";
				return false;
			}
			return "STR_TO_DATE('" . $value . "', '" . get_date_format() . " %H:%i')";
		}
		if ($fields[$field] === 'date') {
			if (!valid_date($value)) {
				$exception = "Incorrect date value '" . $value . "' for column '" . $field . "'";
				return false;
			}
			return "STR_TO_DATE('" . $value . "', '" . get_date_format() . "')";
		}
		return "'" . mysql_real_escape_string($value, $conn) . "'";
	}

	function Editor($meta_table, $site_id, $id, $get_params, $post_params) {

		parent::MetaTable($meta_table, $site_id, $id);

		$this->new_param_name = 'new';
		$this->update_param_name = '__update';
		
		$this->get_params = $get_params;
		$this->post_params = $post_params;
		$this->is_new = isset($get_params[$this->new_param_name]);	
		$this->is_update = $post_params[$this->update_param_name];
		
		$this->alert = "";
	}

	var $new_param_name;
	var $update_param_name;

	var $get_params;	
	var $post_params;	

	var $init_params;	
	var $input_params;	
	var $is_new;	
	var $is_update;
	var $is_send;	
	var $inserted_id;
	
	var $table_meta;

	var $title;
	
	var $alert;
}
?>