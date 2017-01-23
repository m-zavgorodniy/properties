<? 
$start_time = microtime();
$start_array = explode(" ",$start_time);
$start_time = $start_array[1] + $start_array[0];

require $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';

// __originalURL stores Apache REQUEST_FILENAME variable
// we have to use it instead of $_SERVER['REQUEST_URI'] because of possibility of redirect to site directory (i.e. /en) that couldn't be traced in php -
// i see no other way to get a real path, i.e. /en/property/buy/category-residential/type-apartment/
/////$url = current(array_filter(explode($_SERVER['DOCUMENT_ROOT'], $_GET['__originalURL'])));

/////if (false !== strpos($_SERVER['REQUEST_URI'], $url)) {
	// i.e.
	// [REQUEST_URI] =>                  /property/buy/category-residential/type-apartment/
	// __originalURL == X:/home/dubai/www/property/buy/category-residential
	// it means no redirect to site's directory has been done,
	// REQUEST_FILENAME takes proper real path value only after Apache redirect
	// so:

$uri_path = $_GET[$config['SEO_URL_PATH_PARAM_NAME']]?$_GET[$config['SEO_URL_PATH_PARAM_NAME']]:current(explode('?', $_SERVER['REQUEST_URI']));

//	if (substr($uri_path, -1) != '/') $uri_path .= '/'; // trailing slash... why don't we do it instead of apache? 

/////}
// generally, what about conflict if sef parameter name is the same as some real directory name?
// we won't let it happen checking while adding a sef parameter or a site section in backend

/// !! we won't let it happen.. - to do!
/// !! figure out what to do with language in page title, it's hardcoded now
/// !! another conflict to do: parameters 'floor' and 'floor-area'
$conn = db_mysql_connect(true);

//$real_url = '';

/////if (!$config['SEO_URL_NAMED_PARAMS_MODE']) {
////	$i = 1;
	// todo!!! - find out a way without the file_exists and hack below
	// кстати - site_id должен быть известен к этому моменту (откуда? видимо из URL'а .. да. и используем это для обработки 404)
	// надо вообще переделать эту систему поиска реального пути - в sections хранить полный путь, вместе с сайтом, проиндексированный - и искать по нему $url. И отделить путь на сервере к директории от пути к ней в URLи давать изменять этот seo-путь, у любых директорий, даже с поддпиректориями, не трогая ничего на сервере
/*	while (!file_exists($_SERVER['DOCUMENT_ROOT'] . ($real_url = implode('/', explode('/', $url, -$i++)))));
	$url_params = explode('/', trim(next(explode($real_url, $url)), '/'));
	$section_type = current(explode("'", next(explode("'SECTION_TYPE', '", file_get_contents($_SERVER['DOCUMENT_ROOT'] . $real_url . '/index.php'), 2))));*/

// SITE_PATH defined in index.php
if ($site = get_site(SITE_PATH, $conn)) {
	define('SITE_ID', $site['id']);
	define('SITE_PATH_MODE', $site['own_domain']?false:true);
	define('SITE_FILES_PATH', $site['path_files']?'/' . trim($site['path_files'], '/'):SITE_PATH);

	define('SITE_LIB_PATH',  $_SERVER['DOCUMENT_ROOT'] . SITE_FILES_PATH . '/' . CMS_SITE_LIB_DIR_NAME);
	
	require SITE_LIB_PATH . '/config.php'; // override main config settings for a site

	error_reporting($config['DEBUG_ENABLED']?E_ALL:0);
	
	if (SITE_PATH_MODE and '' !== SITE_PATH) { // and !LANG_ID`
		$uri_path = next(explode(SITE_PATH, $uri_path, 2));
	}

	if ($config['LANG_ENABLED'] and $site_langs = get_site_langs($site['id'], $conn)) {
		$lang_path = next(explode('/', $uri_path));
		if (isset($site_langs[$lang_path])) {
			define('LANG_ID', $site_langs[$lang_path]['id']);
			$uri_path = next(explode(LANG_ID, $uri_path, 2));
		} else {
			define('LANG_ID', '');
		}
	} else {
		define('LANG_ID', '');
	}

	if ($section = get_section_by_path(SITE_ID, SITE_PATH_MODE, $uri_path, $config['SEO_ENABLED'], $conn)) {
	
		define('SECTION_PATH', (SITE_PATH_MODE?SITE_PATH:'') . (LANG_ID?'/' . LANG_ID:'') . $section['path_full']);
		define('SECTION_ID', $section['id']);
		define('SECTION_TYPE', $section['section_type_id']);

		if ($config['SEO_ENABLED']) {
	
			$page_title[''] = array(); 
			$page_title['en'] = array(); // ! todo. title_en is hardcoded in seo_parameter table (see also get_sef_url_rules() function). For other langs we have $page_title[$lang] = array() below
			// нужно получать список языков для каждой таблицы
			// если своя для каждого сайта - из языков текущего сайта, если общая - то из языков всех сайтов + языков самих сайтов
			// и использовать это везде - metatable.class.php, может быть где-то еще
			
		//	$real_url = $section['path_full'];
			$url_params_str = '/' . trim(next(explode($section['path_full'], $uri_path, 2)), '/') . '/'; // (SITE_PATH_MODE?SITE_PATH:'') . $section['path_full']
			$url_params_exp = array_values(array_filter(explode('/', $url_params_str)));
		/////}
			if ($sef_url_rules = get_sef_url_rules($conn, SECTION_TYPE)) { 
				if ($config['SEO_URL_NAMED_PARAMS_MODE'] or count($url_params_exp) <= count($sef_url_rules)) {
					foreach($sef_url_rules as $param_name => &$param_rule) {
						if ($config['SEO_URL_NAMED_PARAMS_MODE']) {
							if ('boolean' != $param_rule['type']) {
								$url_params = explode('/' . $param_name . $config['SEO_URL_PARAM_NAME_DELIMETER'], $url_params_str);
							} else {
								$url_params = explode('/' . $param_name . '/', $url_params_str);
							}
							if (1 == count($url_params)) {
								// name of the parameter not found in URL
								continue;
							}
							if ('boolean' != $param_rule['type']) {
								$url_params = array_filter($url_params);
							} else {
								$url_params = array(1);
							}
				/*			$real_url_pretender = array_shift($url_exp);
							if (!$real_url or strlen($real_url_pretender) < strlen($real_url)) {
								$real_url = $real_url_pretender;
							}*/
						} else {
							// $sef_url_rules is ordered by order_num
							$url_params = array($url_params_exp[$param_rule['order_num']]);
						}
						if (!isset($_GET[$param_rule['real_param_name']])) { // if the same param is in the query string and in the rewrited path the query param is stronger, it stays in _GET
							foreach($url_params as &$param_value) {
								$param_value = current(explode('/', $param_value));
								if ('boolean' != $param_rule['type'] and empty($param_value) or $config['SEO_URL_PARAM_EMPTY_VALUE'] == $param_value) continue;
								
								if ('boolean' != $param_rule['type']) {
									$real_param_value = current(explode('/', $param_value));
									if ('none' != $real_param_value) {
										if ('' == $param_rule['type']) {
											if ($param_rule['values_table']) {
												// cache ?
												// ! hardcode, kind of, to do: only two possible languages, no more: <field>, <field>_<SEO_URL_SOURCE_LANG_ID>
					/*							$rs = db_mysql_query("SELECT id, `" . $param_rule['values_source_field'] ."`" . (($param_rule['multi_lang_field'] and $config['SEO_URL_SOURCE_LANG_ID'] != '')?", `" . current(explode('_' . $config['SEO_URL_SOURCE_LANG_ID'], $param_rule['values_source_field'])) ."`":'') . " FROM `" . $param_rule['values_table'] . "` WHERE `" . $param_rule['values_target_field'] ."` = '" . mysql_real_escape_string($real_param_value, $conn) . "'", $conn);
												if ($row = mysql_fetch_row($rs)) {
													$real_param_value = $row[0];
													if ($row[2]) {
														array_unshift($page_title[''], $row[2]);
														array_unshift($page_title[$config['SEO_URL_SOURCE_LANG_ID']], $row[1]);
													} else {
														array_unshift($page_title[''], $row[1]);
													}
												}
												mysql_free_result($rs);*/
	
												// ! todo - work with locale as a language fields postfix, get list of all locales used within the site 
												$extra_langs = $extra_lang_fields = $has_published_field = false;
												$rs = db_mysql_query("DESC `" . $param_rule['values_table'] . "`", $conn); // DESC `" . $param_rule['values_table'] . "` `" . $param_rule['values_source_field_name'] ."_%`"
												while ($row = mysql_fetch_row($rs)) {
													if (0 === strpos($row[0], $param_rule['values_source_field_name'] . '_')) {
														$extra_langs[] = end(explode('_', $row[0]));
														$extra_lang_fields[] = $row[0];
													}
													if ($config['SEO_URL_PUBLISHED_FIELD_NAME'] == $row[0]) {
														$has_published_field = true;
													}
												}
												mysql_free_result($rs);
					
												$rs = db_mysql_query("SELECT id, `" . $param_rule['values_source_field_name'] ."`" . ($extra_langs?',`' . implode('`,`', $extra_lang_fields) . '`':'') . " FROM `" . $param_rule['values_table'] . "` WHERE `" . $param_rule['values_target_field'] ."` = '" . mysql_real_escape_string($real_param_value, $conn) . "'" . ($has_published_field?' AND `' . $config['SEO_URL_PUBLISHED_FIELD_NAME'] . '` <> 0':''), $conn);
												if ($row = mysql_fetch_assoc($rs)) {
													$title_url = ($config['SEO_URL_NAMED_PARAMS_MODE']?$param_name . $config['SEO_URL_PARAM_NAME_DELIMETER']:'') . $real_param_value . '/';
													
													$real_param_value = $row['id'];
													$page_title[''][$title_url] = $row[$param_rule['values_source_field_name']];
													if ($extra_langs) {
														foreach($extra_langs as &$lang) {
															if (!isset($page_title[$lang])) $page_title[$lang] = array();									
															$page_title[$lang][$title_url] = $row[$param_rule['values_source_field_name'] . '_' . $lang];
														}
														unset($lang);
													}
												} else {
													// to be processed in index.php
													// parameter's seo-value not found
													define('URL_PROCESSOR_ERROR', true);
												}
												mysql_free_result($rs);
											}
										} else if ('numeric' == $param_rule['type']) {
											if (0 === strpos($real_param_value, 'between-')) {
												// range: bedrooms-between-2-and-4
												$real_param_value = explode('-and-', next(explode('between-', $real_param_value, 2)));
												$real_param_value = $real_param_value[0] . '-' . $real_param_value[1];
											} else if (0 === strpos($real_param_value, 'not-more-than-')) {
												// range: bedrooms-not-more-than-4
												$real_param_value = '-' . next(explode('not-more-than-', $real_param_value, 2));
											} else if (0 === strpos($real_param_value, 'not-less-than-')) {
												// range: bedrooms-not-less-than-4
												$real_param_value = next(explode('not-less-than-', $real_param_value, 2)) . '-';
											} else {
												// single value: bedrooms-2
												$real_param_value = $real_param_value . '-' . $real_param_value;
											}
										}
									} else {
										$real_param_value = 0;
									}
									if (!$param_rule['multi_value_param']) {
										$_GET[$param_rule['real_param_name']] = $real_param_value;
									} else {
										$_GET[$param_rule['real_param_name']][] = $real_param_value;
									}
								} else {
									$_GET[$param_rule['real_param_name']] = '1';
								}
								if (!$param_rule['values_source_field'] and 'numeric' != $param_rule['type']) { 
									// todo! title and title_en are still hardcoded in seo_parameter table (see also get_sef_url_rules() function)
									if (!empty($param_rule['title'])) $page_title[''][] = $param_rule['title'];
									if (!empty($param_rule['title_en'])) $page_title['en'][] = $param_rule['title_en'];
								}
								// ? if 'numeric' == $param_rule['type'] - where to get russian text, what's the output format (not-more-than etc)?
							}
						}
					}
					$PAGE_TITLES = &$page_title; // we don't know current lang at the moment, handle it later
				} else {
					// http://site.com/catalog/all/novinki/too-many-parameters/
					define('URL_PROCESSOR_ERROR', true);
				}
			} else if (count($url_params_exp)) {
				define('URL_PROCESSOR_ERROR', true);
			}
		}
	} else {
		define('URL_PROCESSOR_ERROR', true);
	}
	
	// custom functions for the current site
	// here, after all, to get all the $_GET parameters enabled after the processing above
	require SITE_LIB_PATH . '/functions.php';

} else {
	header("HTTP/1.1 500 Internal Server Error");
	die("No site is set for this URL");
}

/*$rs = db_mysql_query("SELECT s.meta_site_id, site.path site_path, s.id section_id, s.section_type_id FROM section s, meta_site site WHERE s.meta_site_id = site.id AND CONCAT(site.path, s.path, s.dir) = '" . $real_url . "' AND s.published <> 0", $conn);

if ($row = mysql_fetch_assoc($rs)) {
	define('SITE_ID', $row['meta_site_id']);
	define('SITE_PATH', rtrim($row['site_path'], '/'));
	define('SECTION_ID', $row['section_id']);
	define('SECTION_TYPE', $row['section_type_id']);
	
	define('SCRIPT_REAL_PATH', $real_url);*/
	
//	$PAGE_TITLES = &$page_title; // we don't know current lang at the moment, handle it later
/*}
mysql_free_result($rs);*/

/*$end_time = microtime();
$end_array = explode(" ",$end_time);
$end_time = $end_array[1] + $end_array[0];
$sef_time = $end_time - $start_time;*/


require $_SERVER['DOCUMENT_ROOT'] .  '/lib/engine/site.php';

function get_site($site_path, $conn) {
	$res = false;
	$rs = db_mysql_query("SELECT id, own_domain, path_files FROM meta_site WHERE path = '" . $site_path . "' OR path = '" . $site_path . "/'", $conn);
	if ($row = mysql_fetch_assoc($rs)) {
		$res = $row;
	}
	mysql_free_result($rs);
	
	return $res;
}

function get_site_langs($site_id, $conn) {
	$res = false;
	$rs = db_mysql_query("SELECT id, title, domain, locale FROM meta_site_lang WHERE meta_site_id = '" . $site_id . "'", $conn);
	while ($row = mysql_fetch_assoc($rs)) {
		$res[$row['id']] = $row;
	}
	mysql_free_result($rs);
	
	return $res;
}


function get_section_by_path($site_id, $path_mode, $uri_path, $seo_url_enabled, $conn) {
	$res = false;

	$uri_path = mysql_real_escape_string($uri_path, $conn);
	// ORDER BY
	// LENGTH(path_full) - LENGTH(REPLACE(path_full, '/', '')) DESC - number of occurrences of '/' in path
	// LENGTH(path_full) DESC - to get /property before /
	$rs = db_mysql_query(
		"SELECT id, section_type_id, CONCAT(path, dir) path_full
		FROM section
		WHERE meta_site_id = '" . $site_id . "' AND section_id IS NOT NULL AND published <> 0 
		HAVING " . 
			($seo_url_enabled?"LOCATE(IF(path_full = '/', path_full, CONCAT(path_full, '/')), '" . rtrim($uri_path, '/') . "/') = 1"
			:"IF(path_full = '/', path_full, CONCAT(path_full, '/')) = '" . rtrim($uri_path, '/') . "/'") . "
		ORDER BY (LENGTH(path_full) - LENGTH(REPLACE(path_full, '/', ''))) DESC, LENGTH(path_full) DESC
		LIMIT 1", $conn);
	if ($row = mysql_fetch_assoc($rs)) {
		$res = $row;
	}
	mysql_free_result($rs);
	
	return $res;
}
?>