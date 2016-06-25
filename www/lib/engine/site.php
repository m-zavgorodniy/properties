<?
//if ($config['DEBUG_ENABLED']) {
/*	$start_time = microtime();
	$start_array = explode(" ",$start_time);
	$start_time = $start_array[1] + $start_array[0];*/
//}
//	set_include_path(get_include_path() . (SITE_PATH != '/'?PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . SITE_PATH . '/lib':'') . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/lib');

//// doesn't work on fastcgi?	set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/lib');
//// $_SERVER['DOCUMENT_ROOT'] . ...
/*	if (defined('_SITE_PATH')) {
		define('SITE_LIB_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . trim(_SITE_LIB_PATH, '/ '));
	} else {
		define('SITE_LIB_PATH', $_SERVER['DOCUMENT_ROOT'] . SITE_PATH . '/' . CMS_SITE_ASSETS_DIR_DEFAULT_NAME);
	}*/
/*	define('SITE_LIB_PATH',  $_SERVER['DOCUMENT_ROOT'] . SITE_FILES_PATH . '/' . CMS_SITE_LIB_DIR_NAME);
	
//	require_once 'functions.php'; // can be included in url_processor.php

	require SITE_LIB_PATH . '/config.php'; // override main config settings for a site
	require SITE_LIB_PATH . '/functions.php'; // site's custom functions*/
	
	require 'site.class.php';
	require 'template.class.php';
	
//	if (!isset($conn)) $conn = db_mysql_connect(true); // could be already connected in url_processor.php

/*	defined('SITE_ID') or define('SITE_ID', ''); // 404. how to find out for which site is this 404?. todo !!
	
	defined('SITE_PATH') or define('SITE_PATH', '/');
	defined('SECTION_PATH') or define('SECTION_PATH', '/');
	defined('SITE_PATH_MODE') or define('SITE_PATH_MODE', false);*/

//	defined('SCRIPT_REAL_PATH') or define('SCRIPT_REAL_PATH', dirname($_SERVER['SCRIPT_NAME'])); // if this file is included in url_processor.php, the SCRIPT_REAL_PATH is defined there
	
/*	if (!defined('SECTION_ID')) {
		// get here if url_processor.php has not been fired before
		set_section_by_path(SECTION_PATH, SITE_ID, $conn);
	}*/

	define('IS_AJAX_REQUEST', $_GET['is_ajax'] or $_GET['ajax_inner'] or isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	
	if ($config['SEO_ENABLED'] and !IS_AJAX_REQUEST) {
		if ($redirect_url = make_sef_url(SECTION_TYPE, $conn, $sef_url_error)) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // prevent browser from caching 301 only, not destination page
/*			// !! todo
			if (0 === strpos($_SERVER['REQUEST_URI'], '/en/')) {
				$redirect_url = '/en' . $redirect_url;
			}*/
			header("Location: " . $redirect_url);
			exit;
		} else if ($sef_url_error) {
			define('URL_PROCESSOR_ERROR', true);
		}
	}
	
	$site = new Site(SECTION_PATH, SECTION_ID, SECTION_TYPE, SITE_ID, SITE_PATH_MODE, LANG_ID, IS_AJAX_REQUEST, $conn, $config);
	if (!defined('URL_PROCESSOR_ERROR')) {
		$site->init();
	}
	$http_error = (defined('URL_PROCESSOR_ERROR') or $site->http_error);

	if (!$http_error and $site->seo_redirect_url) {
		send_redirect($site->seo_redirect_url);
	}

	define('TEMPLATES_DIR', SITE_LIB_PATH . '/templates/'); //$_SERVER['DOCUMENT_ROOT'] . ($site->custom_templates ? SITE_PATH : '') .
	define('OUTER_TEMPLATE', $http_error?'404.php':(IS_AJAX_REQUEST?'ajax_outer.php':'common_outer.php')); // 

	if ($do_cache = ($config['CACHE_ENABLED'] and $_SERVER['REQUEST_METHOD'] != 'POST')) {
		define('CACHE_DIR', SITE_LIB_PATH . '/cache/');
		$tpl = new CachedTemplate(TEMPLATES_DIR . OUTER_TEMPLATE); // this is the outer template
	} else {
		$tpl = new Template(TEMPLATES_DIR . OUTER_TEMPLATE);
	}

	// get common site properties
	if (!$http_error) { 
		if ($site->section_protected and !$site->authorized) {
			header("Location: " . $config['AUTH_LOGIN_PAGE'] . "?" . $config['AUTH_BACK_PATH_PARAM_NAME'] . "=" . urlencode($_SERVER['REQUEST_URI']));
			exit;
		}
		
		$body = new Template((('menuitem' != $site->section_type and 'link' != $site->section_type)?TEMPLATES_DIR:'templates/') . $site->section_type . '.php'); // This is the inner template

		if ($config['DATA_ENABLED']) {
			define('BACK_OFFICE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/admin');
			if ($data = get_data($site, $single_item_title)) {
				$tpl->set('_DATA', $data);
				$body->set('_DATA', $data);
				$GLOBALS['_DATA'] = &$data;
			}
		}
	
		// $PAGE_TITLES comes from url_processor
		// it's an array containing titles for each seo /parameter-value/ pair from url with it's url snippet as a key
		if ($single_item_title) {
			// search in $PAGE_TITLES - if the same title have already come from url_processor it has higher priority
			if (!is_array($PAGE_TITLES) or false === array_search($single_item_title, $PAGE_TITLES[$site->lang_id])) {
				// empty key here means no url for this title
				// we don't add it to the site crumbs but show only this title in page title
				$PAGE_TITLES[$site->lang_id][''] = $single_item_title;
			}
		}
		if (isset($PAGE_TITLES)) {
			$site->set_page_context($PAGE_TITLES[$site->lang_id]);
		}

	} else { // section is not published or moved
//		$body = new Template(TEMPLATES_DIR . '404.php');

		header("HTTP/1.1 404 Not Found");
	}

	if ($config['LANG_ENABLED']) {
/*		if (file_exists($lang_file = $_SERVER['DOCUMENT_ROOT'] . '/lib_site/languages/' . SITE_ID . '/common.inc.php')) {
			include ($lang_file);
			$tpl->set('__', $lang); // $lang comes from include above
		}

		if (file_exists($lang_file = $_SERVER['DOCUMENT_ROOT'] . '/lib_site/languages/' . SITE_ID . '/' . $site->section_type . '.inc.php')) {
			$lang_common = $lang;
			include ($lang_file);
			$lang = $lang_common + $lang; // $lang comes from include above
		} */
	// ! todo - language selection for 404
		if (!$site->locale) {
			if (0 === strpos($_SERVER['REQUEST_URI'], '/en/')) {
				$site->locale = 'en_GB';
				$site->lang_id = 'en';
				$site->lang_field_postfix = '_en';
				$site->html_lang = 'en';
			} else {
				$site->locale = 'ru_RU';
				$site->lang_id = '';
				$site->lang_field_postfix = '';
				$site->html_lang = 'ru';
			}
		}

		require SITE_LIB_PATH . '/' . $config['LANG_DIR_NAME'] . '/'.$site->locale.'.php';
		$tpl->set('__', $lang);
		if (!$http_error) $body->set('__', $lang);
		$GLOBALS['__'] = &$lang;
	}
	
	// pass the site object into the templates to make it's properties accessible
	$tpl->set_site($site);
	if (!$http_error) {
		$body->set_site($site);
		$tpl->set('__CMS__INNER_TEMPLATE_CONTENTS', $body);
	}

/*	if ($config['LANG_PARAM_MODE']) {
		// ? not sure. what about links in content
		// ! refine it somehow
		echo str_replace('href="/', 'href="/' . ($site->lang_id?$site->lang_id.'/':''), $do_cache?$tpl->fetch_cache(TEMPLATES_DIR . OUTER_TEMPLATE):$tpl->fetch(TEMPLATES_DIR . OUTER_TEMPLATE));
	} else {*/
	echo $do_cache?$tpl->fetch_cache(TEMPLATES_DIR . OUTER_TEMPLATE):$tpl->fetch(TEMPLATES_DIR . OUTER_TEMPLATE);
/*	}*/
		
if ($config['DEBUG_ENABLED']) {		
	$end_time = microtime();
	$end_array = explode(" ",$end_time);
	$end_time = $end_array[1] + $end_array[0];
	$time = $end_time - $start_time;
	printf("\n<!-- My dear developer, I really did my best and made this page in %f seconds. You are awesome!,) -->", $time);
//	if ($sef_time) { // from url_processor.php
//		printf("\n<!-- and spent %f precious seconds to process SEF URL -->", $sef_time);
//	}
}

// ----------

function send_redirect($redirect_url) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // ! prevents browser caching 301 only, not a destination page
	header("Location: " . $redirect_url);
	exit;
}


function get_data($site, &$single_item_title = '') {
	global $config;

	include 'data.class.php';

	define('DATA_COUNT_TAG_NAME', 'count');
	define('DATA_ITEMS_TAG_NAME', 'items');
	define('DATA_ONPAGE_TAG_NAME', 'items_on_page');
//	define('DATA_SINGLE_PARAM_TAG_NAME', 'single_param_name');
	define('DATA_IS_SINGLE_TAG_NAME', 'is_single');

	$rs = db_mysql_query("SELECT m.id meta_table, m.frontend_on_all_pages, m.frontend_id_param_name, m.frontend_onpage_num, m.frontend_act_param_name FROM meta_table m, section_type t, meta_table2section_type m2t WHERE (m.id = m2t.meta_table_id AND m2t.section_type_id = t.id AND t.id = '" . $site->section_type . "' OR m.frontend_on_all_pages <> 0) AND m.frontend_passthrough <> 0 GROUP BY m.id", $site->conn);
	while ($row = mysql_fetch_row($rs)) {
		if ($row[4]) {
			// multiple activation parameters - comma separated, condition: or
			// if frontend_act_param_name starts from ! - inverse the whole condition
			// examples: service, center (= service OR center); ! service, center (= !service AND !center)
			// todo. make it user friendly?

			$inverse_cond = false;
			if (0 === strpos($row[4], '!')) {
				$row[4] = ltrim($row[4], '! '); // note the space
				$inverse_cond = true;
			}

			if (false === strpos($row[4], ',')) {
				$not_activated = !isset($_GET[$row[4]]);
			} else {
				$act_param_names = array_flip(array_map('trim', explode(',', $row[4])));
				$act_params_in_get = array_intersect_key($act_param_names, $_GET);

				$not_activated = empty($act_params_in_get);
			}

			if ($inverse_cond) {
				$not_activated = !$not_activated;
			}
		}
		if (!($row[4] and $not_activated) or $row[2] and isset($_GET[$row[2]])) {
			$data_tables[$row[0]] = array('on_all_pages' => $row[1], 'id_param_name' => $row[2], 'onpage_num' => $row[3]);
		}
	}
	mysql_free_result($rs);

	$html_fields = array();
	
	if ($data_tables) {
		$g_page = (int)$_GET[$config['DATA_PAGE_PARAM_NAME']]?(int)$_GET[$config['DATA_PAGE_PARAM_NAME']]:1;
		
		foreach ($data_tables as $table => &$meta) {
			if (!(isset($_GET[$meta['id_param_name']]) and 0 == (int)$_GET[$meta['id_param_name']])) {
				$g_id = (int)$_GET[$meta['id_param_name']];
			} else {
				$g_id = -1; // just not to deal with 0
			}
			
			if ('news_folder' == $table or 'doc_folder' == $table) {
				if (!$meta['on_all_pages']) {
					// can't filter by published here 'cos it's a calculated field. let's do it below: if ($record['published'])..
					$data = new MetaTableSiteLink($table . '2section', $site->site_id, NULL, 'section', $site->section_id, NULL, $site->conn, $site->lang_id); 
				} else {
					$data = new MetaTableSiteLink($table, $site->site_id, NULL, NULL, NULL, NULL, $site->conn, $site->lang_id); 
				}
				if ($data->init()) {
					$table_detail = current(explode('_', $table));
					$res[$table_detail][DATA_ONPAGE_TAG_NAME] = $meta['onpage_num'];
//					$res[$table_detail][DATA_SINGLE_PARAM_TAG_NAME] = $meta['id_param_name'];
					foreach($data->records as &$record) {
						if ($record[$config['DATA_PUBLISHED_FIELD_NAME']] or !isset($record[$config['DATA_PUBLISHED_FIELD_NAME']])) { 
//							$res[$table][DATA_COUNT_TAG_NAME]++;
//							$rec_current = &$res[$table][DATA_ITEMS_TAG_NAME][];
//							$rec_current = $record;
							$data_sub = new MetaTableSiteLink($table_detail, $site->site_id, $g_id, $table, $record[$meta['on_all_pages']?'id':$table . '_id'], $g_page, $site->conn, $site->lang_id);
							if ($data_sub->init($meta['onpage_num'])) {
								$res[$table_detail][DATA_COUNT_TAG_NAME] += $data_sub->rec_count;
								if (!$has_data_sub) {
									$res[$table_detail][DATA_ITEMS_TAG_NAME] = array();
									$data_sub_title_field_name = $data_sub->title_field_name;
									$has_data_sub = true;
								}
								
								$res[$table_detail][DATA_ITEMS_TAG_NAME] = array_merge($res[$table_detail][DATA_ITEMS_TAG_NAME], $data_sub->records);
//								$rec_current[DATA_COUNT_TAG_NAME] = $data_sub->rec_count;
//								$rec_current[DATA_ITEMS_TAG_NAME] = $data_sub->records;
								data_output_filter($res[$table_detail][DATA_ITEMS_TAG_NAME], $data_sub->field_types, $site->locale);
							}
							unset($data_sub);
						}
					}
					if ($g_id and $has_data_sub) {
						$news_item_title = $res[$table_detail][DATA_ITEMS_TAG_NAME][0][$data_sub_title_field_name];
						$res[$table_detail][DATA_IS_SINGLE_TAG_NAME] = true;
					} else {
						$res[$table_detail][DATA_IS_SINGLE_TAG_NAME] = false;
					}
					unset($record);
//					data_output_filter($res[$table_detail][DATA_ITEMS_TAG_NAME], $data_sub->field_types, $site->locale);
				}
				unset($data);
			} else if ('article' == $table) {
				// supposed there's no getting of single article with $g_id
				// default article order - main articles (article_type = '') go first
				$data = new MetaTableSiteLink($table, $site->site_id, NULL, 'section', $site->section_id, $g_page, $site->conn, $site->lang_id);
				if ($data->init()) {
					$res[$table][DATA_ONPAGE_TAG_NAME] = $meta['onpage_num'];
//					$res[$table][DATA_SINGLE_PARAM_TAG_NAME] = $meta['id_param_name'];
					$res[$table][DATA_COUNT_TAG_NAME] = $data->rec_count;
					$res[$table][DATA_ITEMS_TAG_NAME] = $data->records;
					data_output_filter($res[$table][DATA_ITEMS_TAG_NAME], $data->field_types, $site->locale);
					$res[$table][DATA_IS_SINGLE_TAG_NAME] = false;
				}
				unset($data);
			} else {
				$data = new MetaTableSiteLink($table, $site->site_id, !$meta['on_all_pages']?$g_id:NULL, NULL, NULL, $g_page, $site->conn, $site->lang_id);
				if ($data->init()) {
					$res[$table][DATA_ONPAGE_TAG_NAME] = $meta['onpage_num'];
//					$res[$table][DATA_SINGLE_PARAM_TAG_NAME] = $meta['id_param_name'];
					$res[$table][DATA_COUNT_TAG_NAME] = $data->rec_count;
					$res[$table][DATA_ITEMS_TAG_NAME] = $data->records;
					data_output_filter($res[$table][DATA_ITEMS_TAG_NAME], $data->field_types, $site->locale);

					if ($g_id) {
						$record_item_title = $res[$table][DATA_ITEMS_TAG_NAME][0][$data->title_field_name];
						$res[$table][DATA_IS_SINGLE_TAG_NAME] = true;
					} else {
						$res[$table][DATA_IS_SINGLE_TAG_NAME] = false;
					}
				}
				unset($data);
			}
		}
		unset($meta);
	}
	
	$single_item_title = $news_item_title?$news_item_title:$record_item_title; // news title is stronger
	
	return $res?$res:false;
}

function data_output_filter(&$records, $field_types, $locale) {
	global $config;

	foreach ($records as &$record) {
		foreach ($record as $field => &$value) {
			if (!is_array($value)) {
				if ($field_types[$field] == 'text' or $field_types[$field] == 'textarea') {
					$value = htmlspecialchars($value, ENT_NOQUOTES);
					if ($field_types[$field] == 'textarea') {
						$value = nl2br($value);
					}
					$value = $config['OUT_TYPO_ENABLED']?typo_filter($value, $locale):$value;
				} else if ($field_types[$field] == 'html') {
					$value = html_content_filter($value, NULL, !$config['OUT_TYPO_ENABLED'], $locale);
				}
			}
		}
		unset($value);
	}
	unset($record);
}

function make_sef_url($section_type_id, $conn, &$error) {
	global $config;

	if (!($sef_url_rules = get_sef_url_rules($conn, $section_type_id))) return false;

//	print_r($sef_url_rules);
	$url = @parse_url($_SERVER['REQUEST_URI']);
	parse_str($url['query'], $get_params);
	$sef_url = '';
	foreach ($sef_url_rules as $sef_param_name => &$sef_rule) {
		$sef_params_list[$sef_param_name] = $sef_rule['real_param_name'];
	}
	unset($sef_rule);
//	print_r($sef_params_list);
//	print_r($get_params);
	$error = false;
	foreach ($get_params as $param_name => &$param_value) {
		if (empty($param_value) or $param_value == '0-0' or $param_value == '-') { // todo?
			$clear_params = true;
			unset($get_params[$param_name]);
			continue;
		}
		if ($sef_param_name = array_search($param_name, $sef_params_list)) {
			$sef_rule = &$sef_url_rules[$sef_param_name];
			if(!is_array($param_value)) {
				$param_value = array($param_value);
			}
			foreach($param_value as &$value) {
				if ('' == $sef_rule['type']) {
					if ($sef_rule['values_table']) {
						$rs = db_mysql_query("SELECT TRIM(IFNULL(`" . $sef_rule['values_target_field'] . "`, '')) `" . $sef_rule['values_target_field'] . "` FROM `" . $sef_rule['values_table'] . "` WHERE id = '" . mysql_real_escape_string($value, $conn). "'", $conn);
						if ($row = mysql_fetch_row($rs)) {
							if ('' !== $row[0]) {
								$sef_url_value = $row[0]; // values in target field is in url safe format
							} else {
								$no_value = true;
							}
						} else {
							$error = true;
						}
						mysql_free_result($rs);
					} else {
						$sef_url_value = urlencode($value);
					}
				} else if ('boolean' == $sef_rule['type']) {
					$sef_url_value = $sef_param_name;
				} else if ('numeric' == $sef_rule['type']) {
					$value = explode('-', $value);
					$value_left = $value[0];
					$value_right = $value[1];
					// '0-0' must be suppressed before
					if (count($value) == 1 or $value_left == $value_right) {
						// single value: bedrooms=2
						$sef_url_value = $value_left;
					} else if (empty($value_left)) {
						// range: bedrooms=-4
						$sef_url_value = 'not-more-than-' . $value_right;
					} else if (empty($value_right)) {
						// range: bedrooms=2-
						$sef_url_value = 'not-less-than-' . $value_left;
					} else {
						// range: bedrooms=2-4
						if ($value_left !== $value_right) {
							$sef_url_value = 'between-' . $value_left . '-and-'. $value_right;
						} else {
							$sef_url_value = $value_left;
						}
					}
				}
				if ($error or $no_value) return false;

				if (!$config['SEO_URL_NAMED_PARAMS_MODE'] or 'boolean' == $sef_rule['type']) {
					$sef_url_ordered_entries[$sef_rule['order_num']] = $sef_url_value . '/'; // nb! '=', not '.=' - only one value
				} else {
					$sef_url_value = $sef_param_name . $config['SEO_URL_PARAM_NAME_DELIMETER'] . $sef_url_value;
					$sef_url_ordered_entries[$sef_rule['order_num']] .= $sef_url_value . '/';
				}
			}
			unset($value);
		}
	}
	unset($param_value);
	if (!$config['SEO_URL_NAMED_PARAMS_MODE'] and $sef_url_ordered_entries) {
		// if some parameters are missed in ordered URL mode, we cannot break the order,
		// so add dummy values for missing parameters to the URL
		$required_params_num = max(array_keys($sef_url_ordered_entries));
		for ($i = 0; $i < $required_params_num; $i++) {
			if (!isset($sef_url_ordered_entries[$i])) {
				$sef_url_ordered_entries[$i] = $config['SEO_URL_PARAM_EMPTY_VALUE'] . '/';
			}
		}
		unset($sef_url_ordered_entry);
	}
	if ($sef_url_ordered_entries or $clear_params) {
		if ($sef_url_ordered_entries) {
			ksort($sef_url_ordered_entries);
			$sef_url = implode('', $sef_url_ordered_entries);
		}
		$script_path = $url['path'];
		// $script_path !== SCRIPT_REAL_PATH - it means mod_rewrite redirected us to site's directory
///		$res = ((SITE_PATH !== '' and $script_path !== SCRIPT_REAL_PATH)?next(explode(SITE_PATH, SCRIPT_REAL_PATH, 2)):SCRIPT_REAL_PATH) . '/' . $sef_url . '?' .
		$res = SECTION_PATH . '/' . $sef_url . '?' .
		http_build_query(
			array_diff_key(
				$get_params,
				array_fill_keys($sef_params_list, 0)
			)
		);
		// ! '-none/' - quick fix. test it
		// return str_replace('-/', '-none/', trim($res, ' ?'));
		return  str_replace('//', '/', trim($res, ' ?'));
	} else {
		return false;
	}
}

/*function set_section_by_path($section_path, $site_id, $conn) {
	$full_path_parts = explode('/', trim($section_path, '/'));
	$dir = array_pop($full_path_parts);
	$path = str_replace('//', '/', '/' . implode('/', $full_path_parts) . '/');
	
	$rs = db_mysql_query("SELECT id, section_type_id FROM section WHERE meta_site_id = '" . $site_id . "' AND path = '" . $path . "' AND dir = '" . $dir . "' AND published <> 0", $conn);
	if ($row = mysql_fetch_assoc($rs)) {
		define('SECTION_ID', $row['id']);
		define('SECTION_TYPE', $row['section_type_id']);
	}
	mysql_free_result($rs);
}*/

?>