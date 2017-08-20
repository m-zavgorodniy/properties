<?
// a little hack - set $_GET parameters by the general direction parameter value
$_GET['city'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['city'];
$_GET['city_exclude'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['city_exclude'];
$_GET['suburbs'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['suburbs'];
$_GET['region'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['region'];
$_GET['region_exclude'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['region_exclude'];
$_GET['country'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['country'];
$_GET['country_exclude'] = $config['DIRECTION_ID_PARAMS'][$_GET['direction']]['country_exclude'];

function out_listing($listing) {
	global $_SITE, $_DATA, $__;

	$detail_link = $_SITE['section_paths']['property_detail']['path'] . '?detail=' . $listing['id']; ?>
	<div class="p-item">
    <?	if ($listing['img_src']) { ?>
		<div class="p-item-image">
			<a href="<?=$detail_link?>"><img src="<?=$listing['img_src']?>"></a>
		</div>
    <?	} ?>
        <div class="p-item-contents">
            <div class="p-item-main">
                <div class="p-item-title"><a href="<?=$detail_link?>"><?=text_left_cut(make_title($listing), $_SITE['is_index_page']?57:85)?></a></div>
           		<div class="p-item-location">
				<?	if ($listing['loc_metro_id']) { ?>
                        м. <? out_metro_w_distance($listing)?>
                <?	} else { ?>
                        <? out_location($listing)?>
                <?	} ?>
                </div>
            </div>
            <div class="p-item-extra g-clearfix">
                <div class="p-item-amenities">
                <?	if ($listing['property_type_id'] == $_SITE['config']['APARTMENT_TYPE_ID']) { ?>
                        <div class="p-item-amenities-item p-item-amenities-plan"><?=$listing['property_subtype_id'] == $_SITE['config']['ROOM_SUBTYPE_ID']?'Комната':($listing['bedrooms']?$listing['bedrooms'] . '-комнатная':'Студия')?></div>      
                <?	} else if ($listing['property_type_id'] == $_SITE['config']['HOUSE_TYPE_ID'] and $listing['floor_count']) { ?>
                        <div class="p-item-amenities-item p-item-amenities-house"><?=$listing['floor_count'] . ' ' . text_format_quantity_ru($listing['floor_count'], array('этаж', 'этажа', 'этажей'))?></div>
                <?	} ?>
                    <div class="p-item-amenities-item p-item-amenities-area"><?=$listing['area_total']?> м<sup>2</sup></div>
                </div>
                <div class="p-item-bot">
                    <div class="p-item-bot-price"><?=my_number_format($listing['price'], $_SITE['locale'])?> <span class="p-item-bot-price-currency"><?=$listing['currency_id_lookup']?></span></div>
                    <a href="<?=$detail_link?>" class="p-item-bot-more">Подробнее</a>
                </div>
             </div>
        </div>
	</div>
<?
}

function out_location($listing) { 
	global $__;
	echo !IS_DEFAULT_COUNTRY?$listing['loc_country_id_lookup'] . ', ':''?><?=!$listing['is_region_center']?$listing['loc_region_id_lookup'] . ', ':''?><?=$listing['loc_city_id']?$listing['loc_city_id_lookup'] . ', ':($listing['loc_road_id']?$listing['loc_road_id_lookup'] . ', ':'')?><?=($listing['loc_street_id']?$listing['loc_street_id_lookup'] . ($listing['address']?', ':''):'') . $listing['address']?><?=$listing['loc_metro_id']?' — м. ' . out_metro_w_distance($listing, true):'';
}

function out_metro_w_distance($listing, $return_str = false) {
	global $__;  
	$res = $listing['loc_metro_id_lookup'] . ($listing['metro_distance_walking']?', ' . $listing['metro_distance_walking'] . ' ' . text_format_quantity_ru($listing['metro_distance_walking'], array('минута', 'минуты', 'минут')) . ' пешком':($listing['metro_distance_transport']?', ' . $listing['metro_distance_transport'] . ' ' . text_format_quantity_ru($listing['metro_distance_transport'], array('минута', 'минуты', 'минут')) . ' на машине':''));
	if ($return_str) {
		return $res;
	}
	echo $res; 
}


function out_aside() {
	global $_SITE, $_DATA, $__; ?>
    <aside class="body-content-side">
    <?	if ($_DATA['listing_main']) { ?>
        <div class="side-title">Лучшие предложения</div>
        <div class="side-block properties-side g-clearfix">
            <ul> 
            <?	foreach ($_DATA['listing_main']['items'] as &$item) {
                    $detail_link = $_SITE['section_paths']['property_detail']['path'] . '?detail=' . $item['id']; ?>
                    <li class="properties-side-item g-clearfix">
                        <div class="properties-side-item-image" style="background-image: url('<?=$item['img_src_thumb']?>')">
                            <a href="<?=$detail_link?>"></a>
                        </div>
                        <div class="properties-side-item-desc">
                            <div class="properties-side-item-type"><?=$item['listing_type_id_lookup']?></div>
                            <div class="properties-side-item-title"><a href="<?=$detail_link?>"><?=text_left_cut(make_title($item), 57)?></a></div>
                            <div class="properties-side-item-price"><?=my_number_format($item['price'], $_SITE['locale'])?> <span class="p-item-bot-price-currency"><?=$item['currency_id_lookup']?></div>
                        </div>
                    </li>
            <?	}
                unset($item); ?>
            </ul>
        </div>
    <?	} ?>
    </aside>
<?
}

function make_title($listing, $details = false) {
	global $_SITE;
	return ($_SITE['config']['PROPERTY_TYPE_SALE_ID'] == $listing['listing_type_id']?'Продается':'Сдается') . ' ' .
		($_SITE['config']['APARTMENT_SUBTYPE_ID'] == $listing['property_subtype_id']?
			($listing['bedrooms']?$listing['bedrooms'] . '-комнатная квартира':'Студия'):
				mb_strtolower($listing['property_subtype_id_lookup'], 'UTF-8')
		) . ', ' .
		($listing['loc_city_id']?$listing['loc_city_id_lookup'] . (($_SITE['config']['DEFAULT_CITY_ID'] == $listing['loc_city_id'] and $listing['loc_metro_id'])?', м. ' . $listing['loc_metro_id_lookup']:''):$listing['address']) .
		(($details and $listing['loc_street_id'])?', ул. ' . $listing['loc_street_id_lookup']:'') .
		($details?', ' . preg_replace("/(\d+)\s+/", "\\1&nbsp;", my_number_format($listing['price'], 'ru_RU') . ' руб.'):''); 
}

function out_paginator($page, $items_on_page, $count, $prev_text = '<', $next_text = '>') {
	global $__;

	if (!(int)$page) $page = 1;
	if ($count > $items_on_page) {
		$pages_num = ceil($count / $items_on_page);
		$page_query = (false === strpos($_SERVER['REQUEST_URI'], '?')?'?':'&') . 'page=';
		$url = current(explode($page_query, $_SERVER['REQUEST_URI'])) . $page_query; ?>

        <div class="paginator" id="paginator1"></div>
        <div class="paginator_pages"><?=$pages_num?> <?=text_format_quantity_ru($pages_num, array('страница', 'страницы', 'страниц'))?></div>
		<div class="paginator_next">
		<?	if ($page < $pages_num) { ?>
        	<a href="<?=$url?><?=$page+1?>">Следующая</a>
        <?	} else { ?>
        	<a>Следующая</a>
        <?	} ?>
        </div>
        <script type="text/javascript">
            pag1 = new Paginator('paginator1', <?=$pages_num?>, <?=$items_on_page?>, <?=$page?>, "<?=$url?>");
        </script>

<?
/*		$uri_parts = parse_url($_SERVER['REQUEST_URI']);
		$uri_params = array();
		parse_str($uri_parts['query'], $uri_params);
		unset($uri_params['page']);
		$uri_query = http_build_query($uri_params);
		$uri_page = $uri_parts['path'] . ($uri_query?'?' . $uri_query . '&':'?') . 'page=';
		$uri_page_first = $uri_parts['path'] . ($uri_query?'?'.$uri_query:''); // this is an important thing for seo ?>
        <div class="paginator">
            <div class="paginator-prev"><a<?=$page != 1?' href="' . ($page != 2?$uri_page . ($page - 1):$uri_page_first) . '"':' class="paginator-inactive"'?>><?=$prev_text?></a></div>
            <div class="paginator-next"><a<?=$page != $pages_num?' href="' . $uri_page . ($page + 1) . '"':' class="paginator-inactive"'?>><?=$next_text?></a></div>
            <div class="paginator-pages">
            <?	for ($p = 1; $p <= $pages_num; $p++) { ?><span<?=$p == $page?' class="selected"':''?>><a href="<?=$p != 1?$uri_page . $p:$uri_page_first?>"><?=$p?></a></span><? } ?>
            </div>
            <div class="cl"></div>
        </div>
<?	*/
	}
}

function out_sharing() { ?>
<div class="addthis_toolbox addthis_default_style">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5085730966084007"></script>
<?
}

// forms
function set_checked_attr($value, $param, $is_select = false) {
	if (is_array($param)) {
		if(in_array($value, $param)) {
			$res = true;
		}
	} else {
		if ($value === $param) {
			$res = true;
		}
	}
	echo $res?($is_select?' selected=""':' checked=""'):'';
}

function out_select_range($field_name, $values_set, $field_param_value = NULL, $values_custom_titles = NULL) {
	$values_set = array_combine($values_set, $values_set);
	if (is_array($values_custom_titles)) {
		$values_set = $values_custom_titles + $values_set;
	}
	list($param_min, $param_max) = explode('-', $field_param_value); ?>
    <span class="form-field-range">
        <input type="hidden" name="<?=$field_name?>" value="<?=$field_param_value?>">
        <select name="<?=$field_name?>_min">
            <option value="">от</option>
        <?	foreach ($values_set as $val => &$title) { 
				if (($title_mill = $title / 1000000) >= 1) {
					$title = $title_mill . ' млн';
				} ?>
	            <option value="<?=$val?>"<?=(string)$val === $param_min?' selected=""':''?>><?=$title?></option>
		<?	}
			unset($title); ?>
        </select>&mdash;&nbsp;
        <select name="<?=$field_name?>_max">
            <option value="">до</option>
        <?	foreach ($values_set as $val => &$title) { ?>
    	        <option value="<?=$val?>"<?=(string)$val === $param_max?' selected=""':''?>><?=$title?></option>
		<?	}
			unset($title); ?>
        </select>
    </span>
<?
}

function out_contact_form ($listing_id = 0) { ?>
    <form action="/contacts/#map_canvas" method="post" class="form-validate" novalidate>
    <?	if ($listing_id) { ?>
        <input type="hidden" name="property_id" value="<?=$listing_id?>">
    <?	} ?>
    <? /* ---- form!    <div class="form-field-line">
            <div class="form-field-short">
                <input type="text" name="name" value="" placeholder="Ваше имя *" class="form-input-text required">
            </div>
            <div class="form-field-short">
                <input type="email" name="email" value="" placeholder="Ваш e-mail *" class="form-input-text required">
            </div>
            <div class="form-field-short">
                <input type="phone" name="phone" value="" placeholder="Контактный телефон *" class="form-input-text required">
            </div>
        </div> */?>
        <textarea name="message" placeholder="Ваше сообщение *" class="form-input-text required"></textarea>
        <button type="submit" value="1" class="form-input-submit g-button">Отправить</button>
    </form>

<?
}
?>