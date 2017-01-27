<?
//print_r($_DATA);
global $config;

if (!$_GET['type']) {
	$search_init = true;
}
?>
<script>
	var DIRECTION_ID_PARAMS = [];
<?	foreach ($config['DIRECTION_ID_PARAMS'] as $direcion_id => &$direcion_param) { ?>
		DIRECTION_ID_PARAMS[<?=$direcion_id?>] = <?=preg_replace("/:(\d+)}/", ':"\\1"}', json_encode($direcion_param))?>;
<?	}
	unset($direcion_param); ?>
</script>
<script src="/js/search.js?r=3"></script>
<div class="body-content-search property-search"<?=$search_init?'':' style="display: none"'?>>
    <section role="search">
    	<ul class="property-search-bookmarks g-clearfix">
		<?	$status_active = $_GET['status'];
            $is_first = true;
            foreach ($_DATA['listing_type']['items'] as &$listing_type) { 
                if ($is_first and !isset($status_active)) {
                    $status_active = $listing_type['id'];
                    $is_first = false;
                }
				$is_current = false;
				if ($status_active == $listing_type['id']) {
					$is_current = true;
					$search_params_str['status'] = $listing_type['title'];
				} ?>
                <li class="property-search-bookmarks-item<?=$status_active == $listing_type['id']?' active':''?>">
                	<a href="?status=<?=$listing_type['id']?>"><?=$listing_type['title']?></a>
                </li>
        <?	}
            unset($listing_type); ?>
        </ul>
        <div class="property-search-form">
	    	<form action="" method="get">
                <ul class="property-search-form-tabs g-clearfix">
                <?	$type_active = $_GET['type'];
                    $is_first = true;
                    foreach ($_DATA['property_type']['items'] as &$property_type) { ?>
					<?	if ($is_first and !isset($type_active)) {
                            $type_active = $property_type['id'];
                            $is_first = false;
                        } 
						$is_current = false;
						if ($type_active == $property_type['id']) {
							$is_current = true;
							$search_params_str['type'] = $property_type['title'];
						} ?>
                    	<li class="property-search-form-tab<?=$is_current?' active':''?>" id="tab_<?=$property_type['id']?>">
                            <a href="javascript:;"><?=$property_type['title']?></a>
                        </li> 
                <?	}
                    unset($property_type); ?>
                </ul>
                <input type="hidden" name="status" value="<?=$status_active?>">
                <input type="hidden" name="type" value="<?=$type_active?>">
                <div class="property-search-form-box">
                    <div class="property-search-form-section">
                <?  foreach ($_DATA['property_type']['items'] as &$property_type) { ?>
                        <div id="pad_<?=$property_type['id']?>" class="property-search-form-pad<?=$type_active == $property_type['id']?' active':''?> g-clearfix" style="display: none;">
                        <?	$i = 0; ?>
                        	<div class="form-field-col-box g-clearfix">
							<?	foreach ($_DATA['property_subtype']['items'] as &$property_subtype) {
                                    if ($property_subtype['property_type_id'] == $property_type['id']) { 
                                        $i++;
                                        $is_apartment = ($config['APARTMENT_SUBTYPE_ID'] == $property_subtype['id']); ?>
                                        <div class="form-field form-field-checkbox<?=$is_apartment?' property-search-field-apartment':''?>">
                                            <input type="checkbox" name="subtype[]" value="<?=$property_subtype['id']?>" id="property_subtype_<?=$property_subtype['id']?>"<?=set_checked_attr($property_subtype['id'], $_GET['subtype'])?>>
                                            <label for="property_subtype_<?=$property_subtype['id']?>"><?=$property_subtype['title']?></label>
                                            
                                        <?	if ($is_apartment) {
                                                $i = 0; ?>
                                                <i class="fa fa-angle-right"></i>&nbsp;&nbsp; <span class="form-field-title">Комнат</span>
                                                <?=out_select_range(
                                                    'bedrooms',
                                                    array(0, 1, 2, 3, 4, 5, 6),
                                                    $_GET['bedrooms'],
                                                    array(0 => 'Студия'))?>
                                        <?	} ?>
                                        </div>
									<?	if (is_array($_GET['subtype']) and in_array($property_subtype['id'], $_GET['subtype'])) {
											$search_params_str['subtype'] .= $property_subtype['title'] . ', ';
										}
                                    } 
									if ($is_apartment or $i % 3 == 0) { ?>
                                    	<div class="g-clearfix"></div>
                            	<?	}
								}
                                unset($property_subtype);
								// page title
								if ($search_params_str['subtype']) {
									$search_params_str['subtype'] = rtrim($search_params_str['subtype'], ', ');
									unset($search_params_str['type']);
								} ?>
                            </div>
						<?	if ($config['APARTMENT_TYPE_ID'] == $property_type['id']) { ?>
                                <div class="property-search-markettype">
                                    <div class="form-field">
                                        <div class="form-field-title">Тип недвижимости</div>
                                        <select name="market_type">
                                            <option value="">Любой</option>
                                        <?	foreach ($_DATA['market_type']['items'] as &$market_type) { ?>
                                                <option value="<?=$market_type['id']?>"<?=set_checked_attr($market_type['id'], $_GET['market_type'], true)?>><?=$market_type['title']?></option>
                                        <?	}
                                            unset($market_type); ?>
                                        </select>
                                    </div>
                                </div>
                        <?	} ?>
                        </div>
                <?	}
                    unset($property_type); ?>
                    </div>
                    <div class="property-search-form-section">
                        <div class="form-field">
                            <span class="form-field-title">Цена</span>
                            <span class="form-field-range">
								<input type="hidden" name="price" value="<?=$_GET['price']?>">
                            <?	list($price_min, $price_max) = explode('-', $_GET['price']); ?>
	                            <input type="text" name="price_min" value="<?=$price_min?number_format($price_min, 0, ",", " "):''?>" placeholder="от">
                                —&nbsp;
	                            <input type="text" name="price_max" value="<?=$price_min?number_format($price_max, 0, ",", " "):''?>" placeholder="до">
                            </span>
                            &nbsp;
                            <select name="currency">
                            <?	foreach ($_DATA['currency']['items'] as &$currency) { ?>
                                    <option value="<?=$currency['id']?>"<?=set_checked_attr($currency['id'], $_GET['currency'], true)?>><?=$currency['title']?></option>
                            <?	}
                                unset($currency); ?>
                            </select>
                            <? /*=out_select_range(
                                'price',
                                array(1000000, 3000000, 5000000, 7000000, 10000000, 12000000, 15000000, 20000000, 30000000, 100000000, 500000000),
                                $_GET['price']) */ ?>
                        </div>
                    </div>
                    <div class="property-search-form-section">
                        <div class="property-search-form-section-title">Расположение</div>
                        <ul class="property-search-direction g-clearfix">
                        <?	// ! nb - direction id by default is 1
                            $direction_id = $_GET['direction'];
                            foreach ($_DATA['loc_direction']['items'] as &$direction) {
                                $is_current = false;
                                if (isset($direction_id) and $direction_id == $direction['id']) {
                                    $is_current = true;
                                    $search_params_str['direction'] = $direction['title'];
                                } ?>
                                <li class="property-search-direction-item<?=$is_current?' active':''?>"><a href="javascript:;" id="direction_<?=$direction['id']?>"><?=$direction['title']?></a></li>
                        <?	}
                            unset($direction); ?>
                        </ul>
                        <? // for direction IDs see site config ?>
                        <div id="direction_area_1" class="property-search-direction-pad"<?=1 != $_GET['direction']?' style="display: none;"':''?>>
                        	<div class="property-search-direction-tabs g-clearfix">
	                        	<ul>
	                            	<li><a href="javascript:;"<?=$_GET['metro']?' class="active"':''?> id="direction-tab-metro">Метро</a></li>
	                            	<li><a href="javascript:;"<?=$_GET['street']?' class="active"':''?> id="direction-tab-street">Улицы</a></li>
	                            </ul>
                            </div>
                        <?	foreach ($_DATA['loc_metro']['items'] as &$metro) {
								$lines_for_station = explode(',', $metro['loc_metro_line_id']);
								foreach ($lines_for_station as &$line) {
									$_DATA['loc_metro_line']['items'][$line]['stations'][] = $metro;
								}
								unset($line);
							}
							unset($metro);
							$i = 0;
							$col_num = 4;
							// ! todo - metro_line count is for all regions, not for the default only
							$metro_line_in_col_num = ceil(count($_DATA['loc_metro_line']['items']) / $col_num); ?>
                            <div class="direction-type-box" id="direction-metro"<?=$_GET['metro']?'':' style="display: none"'?>>
                            <?	if (is_array($_GET['metro']) and $count_metro = count($_GET['metro'])) { ?>
                            		<div class="direction-count">
	                            		<span class="direction-count-title">Выбрано станций:</span> <span class="direction-count-num"><?=$count_metro?></span>
                                        <span class="direction-count-control"><a href="javascript:;">Сбросить</a></span>
                                    </div>
							<?	} ?>
                                <div class="form-field-col4">
                                <?	foreach ($_DATA['loc_metro_line']['items'] as &$metro_line) {
										if ($config['DEFAULT_CITY_ID'] == $metro_line['loc_city_id']) { ?>
                                            <div class="property-search-metro-section">
                                                <div class="property-search-metroline">
                                                    <i class="fa fa-circle" style="color: <?=$metro_line['color']?>"></i><a href="javascript:;" title="Выбрать всю ветку"><?=$metro_line['title']?></a>
                                                </div>
                                                <ul class="property-search-metro">
                                            <?	foreach ($metro_line['stations'] as &$metro) { ?>
                                                    <li><label><input type="checkbox" name="metro[]" value="<?=$metro['id']?>"<?=set_checked_attr($metro['id'], $_GET['metro'])?>><?=$metro['title']?></label></li>
                                            <?	}
                                                unset($metro); ?>
                                                </ul>
                                            </div>
                                        <?	if (++$i % $metro_line_in_col_num == 0) { ?>
                                                </div><div class="form-field-col4">
                                        <?	}
										}
                                    }
                                    unset($metro_line); ?>
                                </div>
                                <div class="g-clearfix"></div>
                            </div>
                            <div class="direction-type-box" id="direction-street"<?=$_GET['street']?'':' style="display: none"'?>>
                            	<select>
                                	<option value="">Выберите улицу --</option>
								<?	$streets_selected = array();
									foreach ($_DATA['loc_street']['items'] as &$street) {
                                        if ($config['DEFAULT_CITY_ID'] == $street['loc_city_id']) { ?>
                                            <option value="<?=$street['id']?>"><?=$street['title']?></option>
                                <?		}
										if (is_array($_GET['street']) and in_array($street['id'], $_GET['street'])) {
											$streets_selected[] = $street;
										}
                                    }
                                    unset($street); ?>
                                </select>
                                <div class="property-search-locations-box" id="direction-street-items">
                                <?	foreach ($streets_selected as &$street) { ?>
                                		<div class="property-search-street-line"><label><input type="checkbox" name="street[]" value="<?=$street['id']?>" checked><?=$street['title']?></label></div>
                                <?	}
									unset($street); ?>
                                </div>
                            </div>
                        </div>
                    <?	/*

						// !!!! DO NOT DELETE!!
						// !!!! THIS ALL WORKS VERY OK!!!

						// roads and cities in moscow region 
						// disabed because of a very few properties in this direction

                        <div id="direction_area_2" class="property-search-direction-pad"<?=2 != $_GET['direction']?' style="display: none;"':''?>>
							<div class="form-field-col4">
							<?	$i = 0;
								$col_num = 4;
                                // ! todo - roads count is for all regions, not for the default only
                                $road_in_col_num = ceil(count($_DATA['loc_road']['items']) / $col_num);
                                foreach ($_DATA['loc_road']['items'] as &$road) {
                                    if ($config['DEFAULT_REGION_ID'] == $road['loc_region_id']) { ?>
                                        <div class="property-search-road">
                                            <label><input type="checkbox" name="road[]" value="<?=$road['id']?>"<?=set_checked_attr($road['id'], $_GET['road'])?>><?=$road['title']?></label>
                                        </div>
                                    <?	if (++$i % $road_in_col_num == 0) { ?>
                                            </div><div class="form-field-col4">
                                    <?	}
                                    }
                                }
                                unset($road); ?>
                            </div>
                            <div class="g-clearfix"></div>
                        </div>

                        <div id="direction_area_3" class="property-search-direction-pad"<?=3 != $_GET['direction']?' style="display: none;"':''?>>
                            <div id="direction-city">
								<script>
                                    $(function() {
                                        $("#direction-city select").change(function() {
											var $city = $(":selected", $(this));
											if ($("#direction-city-items input[value=" + $city.val() + "]").length) {
												$("#direction-city-items input[value=" + $city.val() + "]").prop("checked", true);
											} else {
												var $append_city = $('<div class="property-search-city-line" style="display: none;"><label><input type="checkbox" name="city[]" value="' + $city.val() + '" checked>' + $city.text() + ' </label></div>');
												$("#direction-city-items").append($append_city);
												$append_city.show('fast');
											}
											this.selectedIndex = 0;
											g_set_default_param("city");
                                            return false;
                                        });
										
										$("body").on("change", ".property-search-city-line :checkbox", function() {
											if (!$(this).prop("checked")) {
												var $city_line = $(this).closest(".property-search-city-line");
												$city_line.fadeOut(function() {
													$city_line.remove();
												});
											}
											g_set_default_param("city");
										});
                                    });
									function g_set_default_param(param_name) {
										if ($(".property-search-" + param_name + "-line :checked").length) {
											$("[name='" + param_name + "']").prop("disabled", true);
										} else {
											$("[name='" + param_name + "']").prop("disabled", false);
										}
									}
                                </script>
                            	<select>
                                	<option value="">Выберите город --</option>
								<?	$cities_selected = array();
									foreach ($_DATA['loc_city']['items'] as &$city) {
                                        if ($config['DEFAULT_REGION_ID'] == $city['loc_region_id'] and $config['DEFAULT_CITY_ID'] != $city['id']) { ?>
                                            <option value="<?=$city['id']?>"><?=$city['title']?></option>
                                <?		}
										if (is_array($_GET['city']) and in_array($city['id'], $_GET['city'])) {
											$cities_selected[] = $city;
										}
                                    }
                                    unset($city); ?>
                                </select>
                                <div class="property-search-locations-box" id="direction-city-items">
                                <?	foreach ($cities_selected as &$city) { ?>
                                		<div class="property-search-city-line"><label><input type="checkbox" name="city[]" value="<?=$city['id']?>" checked><?=$city['title']?></label></div>
                                <?	}
									unset($city); ?>
                                </div>
                            </div>
                        </div>
						*/ ?>
                        <input type="hidden" name="direction" value="<?=$direction_id?>">
                        <? /* !! ok but we did the little hack in functions.php
						<span id="direction_params">
                        <input type="hidden" name="city" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['city']?>">
                        <input type="hidden" name="city_exclude" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['city_exclude']?>">
                        <input type="hidden" name="suburbs" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['suburbs']?>">
                        <input type="hidden" name="region" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['region']?>">
                        <input type="hidden" name="region_exclude" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['region_exclude']?>">
                        <input type="hidden" name="country" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['country']?>">
                        <input type="hidden" name="country_exclude" value="<?=$config['DIRECTION_ID_PARAMS'][$direction_id]['country_exclude']?>">
                        </span>*/ ?>
                    </div>
				</div>
                <div class="property-search-form-submit">
                	<button type="submit" class="g-button"><i class="fa fa-search"></i>&nbsp; Показать предложения</button>
                </div>
	        </form>
        </div>
    </section>
</div>
<?
if ($search_init) { ?>
<div class="body-content-wide">
<?	if ($_DATA['listing_main']) { ?>
        <div class="g-line"></div>
        <div class="properties-grid g-clearfix">
            <h2>Лучшие предложения продажи</h2>
        <?	$i = 0;
            foreach ($_DATA['listing_main']['items'] as &$listing) {
                out_listing($listing);
            }
            unset($listing); ?>
    
        </div>
<?	} ?>
</div>
<?
} else { ?>
<div class="body-content-main">
	<h1><?=$title = implode(' — ', $search_params_str) . ($_GET['market_type']?' — ' . $_DATA['market_type']['items'][$_GET['market_type']]['title']:'')?></h1>
    <?	define('SEO_PAGE_TITLE', $title); ?>
<?	if ($_DATA['listing']) { ?>
	    <div class="properties-found">
			<?=$_DATA['listing']['count']?> <?=text_format_quantity_ru($_DATA['listing']['count'], array('предложение', 'предложения', 'предложений'))?>
            <? out_newsearch(); ?>
        </div>
        <div class="properties-list g-clearfix">
        <?	$i = 0;
            foreach ($_DATA['listing']['items'] as &$listing) {
                out_listing($listing);
            }
            unset($listing); ?>
        </div>
    <?	out_paginator((int)$_GET[$_SITE['config']['DATA_PAGE_PARAM_NAME']], $_DATA['listing']['items_on_page'], $_DATA['listing']['count'], 'Предыдущая страница', 'Следующая страница');
	} else { 
		define('SEO_PAGE_NOINDEX', true); ?>
    	<div class="properties-found">
        	Не найдено предложений, удовлетворяющих вашему запросу.
        </div>
        <?	out_newsearch(); ?>
        <div class="properties-contact-message">Вы можете оставить нам заявку на подбор недвижимости по указанным вами параметрам:</div>
        <?	out_contact_form($listing['id']); ?>
<?	} ?>
</div>
<?
out_aside();
}

function out_newsearch() { ?>
    <span class="properties-found-search"><a href="javascript:;">Изменить условия поиска</a></span>
<?
}
?>
