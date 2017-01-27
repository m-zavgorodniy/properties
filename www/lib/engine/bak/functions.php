<?
define('CMS_SITE_LIB_DIR_NAME', 'lib_site');

// encoding UTF-8
require $_SERVER['DOCUMENT_ROOT'] . "/lib/config.php";
require $_SERVER['DOCUMENT_ROOT'] . "/lib/html_content_filter.php";

error_reporting($config['DEBUG_ENABLED']?7:0);

function db_mysql_connect($close_on_shutdown = false) {
	global $config;

	if ($conn = mysql_connect($config['DB_SERVER'], $config['DB_USER'], $config['DB_PASSWORD']) and mysql_select_db($config['DB_DATABASE'], $conn)) {
		if (!$config['DB_DEFAULT_UTF8']) {
			mysql_query('SET NAMES utf8 COLLATE utf8_unicode_ci', $conn);
		}
		if ($close_on_shutdown) {
			register_shutdown_function('mysql_close', $conn);
		}
		return $conn;
	}
	header('HTTP/1.1 500 Internal Server Error');
	die($config['DEBUG_ENABLED']?'Cannot connect to MySQL server as ' .  $config['DB_USER'] . '@' . $config['DB_SERVER']:'');
} 

function db_mysql_query($query, $conn) {
	if ($res = mysql_query($query, $conn)) {
		return $res;
	}
	return mysql_error($conn);
}

function db_mysql_query_with_params($query, $params, $conn) {
	if (is_array($params)) {
		foreach ($params as $field => $value) {
			$query = str_replace('{' . $field . '}', "'" . mysql_real_escape_string($value) . "'", $query);
		}
		unset($field);

//echo $query;
		return db_mysql_query($query, $conn);
	} else {
		return false;
	}
/*	
usage:	db_mysql_query_with_params(
		"SELECT s.*, t.name section_type FROM section s, section_type t WHERE s.id = {id} AND s.section_type_id = t.id",
		array('id' => $g_id)
	)
*/
}

function db_query($query) {
	$conn = db_mysql_connect();
	$res = db_mysql_query($query, $conn);
	mysql_close($conn);
	return $res;
}

// ------
// params
function get_post($not_escape = false) {
	foreach($_POST as $param => $value) {
		if (!is_array($value)) {
			if ($value != '__other') {
				$post_params[$param] = !$not_escape?trim(htmlspecialchars($value)):trim($value);
			} else {
				 unset($_POST[$param]);
			}
		} else {
			foreach($value as &$option) {
				$option = !$not_escape?trim(htmlspecialchars($option)):trim($option);
			}
			unset($option);
			$post_params[$param] = $value;
		}
	}
	unset($value);
	return $post_params;
}

function get_params_as_array($params, &$array_params) {
	foreach ($params as $field => &$value) {
		if (is_array($value)) {
			if (implode('', $value) !== '') {
				$array_params[$field] = $value;
			}
		} else if ($value !== '') {
			$array_params[$field][] = $value;
		}
	}
	unset($value);
}


// texts
function text_date_str($date, $locale = 'ru_RU', $format = 'j M Y', $is_time = false) {
	if ($locale != 'ru_RU') {
		return date($format . ($is_time?', g:ia':''), strtotime($date));
	} else {
		if (false !== strpos($date, '.')) {
			list($day, $month, $year) = explode('.', $date);
			$date = $year . '-' . $month . '-' . $day;
		}
		$d = strtotime($date);
		$months = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
		return date("j",$d).' '.$months[date("n",$d)-1].' '.date("Y",$d) . ($is_time?', '.date('G:i',$d):'');
	}
}

function text_date_of_week($date, $locale = '') {
	if ($locale != 'ru_RU') {
		return date('l', strtotime($date));
	} else {
		$days = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
		$w = date('w', strtotime($date));
		return $days[$w];
	}
}

function text_format_quantity_ru($num, $format) {
	// usage: format_quantity_ru($cost, array('рубль', 'рубля', 'рублей')
	$a = substr($num, strlen($num)-1, 1);
	$b = substr($num, strlen($num)-2, 2);
	if ($a==1 and $b!=11) return $format[0];
	if ($a>=2 and $a<=4 and $b!=12 and $b!=13 and $b!=14) return $format[1];
	if ($a==0 or ($a>=5 and $a<=9) or ($b>=11 and $b<=14)) return $format[2]; 
}

function text_first_paragraph($str, $maxlen = 0, $encoding = 'UTF-8') {
	if (preg_match("/<p[^>]*>(.*)<\/p>/isU", $str, $matches)) {
		$str = strip_tags($matches[1]);
		if ($maxlen) return text_left_cut($str, $maxlen, $encoding);
		else return($str);
	} else {
		return false;
	}
}

function text_left_cut($str, $len, $encoding = 'UTF-8', $no_dots = false) {
	if (mb_strlen($str, $encoding) > $len) { 
		$res = mb_substr($str, 0, $len, $encoding);
		$str_init = $str;
		$str = rtrim($str);
		if ($str == $str_init) { // the last word has been cut
			$res = mb_substr($str, 0, mb_strrpos($res, ' ', $encoding), $encoding);
		}
		return $res . (!$no_dots?'...':'');
	} else {
		return $str;
	}
}

if (!function_exists('mb_ucfirst')) {
function mb_ucfirst($str, $encoding = 'UTF-8') {
	return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding); 
}
}


// output
function out_http_link($href, $with_http = false, $content = '', $class_name = '') {
	if ('' === $href) {
		if ('' !== $content) echo $content;
		else echo '';
		return;
	}
	if (0 === stripos($href, '/')) {
		$href = 'http://' . current(explode(':', $_SERVER['HTTP_HOST'])) . $href;
	} else if (0 !== stripos($href, 'http://') and 0 !== stripos($href, 'https://')) {
		$href = 'http://' . $href;
	}
	echo '<a href="' . $href . '" target="_blank"' . ($class_name?' class="' . $class_name . '"':'') . '>' . ($content?$content:($with_http?'http://':'') . current(explode('/', str_replace(array('http://', 'https://'), '', $href))) . ($with_http?'/':'')) . '</a>';
}

function out_widget($widget_name, $out_function_name, $params = NULL, $cache_life = 3600) {
	ignore_user_abort(true);
	set_time_limit(0);

	global $_SITE, $__;
	$params_str = '';
	if (is_array($params)) {
		$params = array_filter($params);
		foreach ($params as $param => &$val) {
			$params_str .= '.' . $param . '=' . $val;
		}
	}
	$cache_file = $_SERVER['DOCUMENT_ROOT'] . '/lib/cache/' . $widget_name . $params_str . '.widget';
	
	$filemtime = @filemtime($cache_file);  // returns FALSE if file does not exist
	$is_win = (false !== stripos(php_uname('s'), 'windows'));
	if (!$filemtime or ($file_age = time() - $filemtime) >= $cache_life and ($_GET['__renew_widgets'] or $is_win)) {
		@touch($cache_file, time() + 3600 * 24); // set time in future to prevent triggering of the next update instance while the current one is still running
		ob_start();
		$out_function_name($params);
		file_put_contents($cache_file, ob_get_flush());
	} else {
		echo file_get_contents($cache_file);
	}
	// async renew, only on linux
	if (!$is_win and $filemtime and ($file_age >= $cache_life)) {
		exec('wget -b -q -O /dev/null "http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . (false !== strpos($_SERVER['REQUEST_URI'], '?')?'&':'?') . '__renew_widgets=yes"');
	}
}

// forms
function input_get_checked($value, $param) {
	if (is_array($param)) {
		if(in_array($value, $param)) {
			$res = true;
		}
	} else {
		if ($value === $param) {
			$res = true;
		}
	}
	echo $res?' checked=""':'';
}

function valid_email($str) {
	return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str));
}

function valid_date($str) {
	$time = next($str_expl = explode(' ', $str));
	$str_expl = explode(DATE_SEPARATOR, $str_expl[0]);
	$str = $str_expl[2]."-".(DATE_MONTH_FIRST?$str_expl[0]."-".$str_expl[1]:$str_expl[1]."-".$str_expl[0]);
	return date('Y-m-d', strtotime($str)) == $str and ($time?valid_time($time):true);
}

function valid_time($str) {
	$str_expl = explode(":", $str);
	return (preg_match("/^[012][0-9]:[0-5][0-9]$/", $str) and (int)$str_expl[0] <= 23 and (int)$str_expl[1] <= 59);
}

function valid_url($url) {
    return preg_match('/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}((:[0-9]{1,5})?\/.*)?$/i', $url);
}

function valid_price($str) {
	return preg_match("/^([0-9\s]+((\.|\,){1}[0-9]{2})?)$/", $str);
}


// seo
function make_safe_url($str) {
    return trim(implode('-',
			array_diff(
				array_unique(explode('-', strtolower(preg_replace(array('/[^a-zA-Z0-9\s-]/', '/[\s-]+/'), array('', '-'), remove_accent(trim($str)))))),
				array('a','an','as','at','before','but','by','for','from','is','in','into','like','of','off','on','onto','per','since','than','the','this','that','to','up','via','with')
			)), '-');
}
function remove_accent($str) {
	// from http://php.dzone.com/news/generate-search-engine-friendl
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 	'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	return str_replace($a, $b, $str);
}

function get_sef_url_rules($conn, $section_type_id = '') {
	$from_backend = empty($section_type_id); // just to point the difference in sql below
	global $config;
	// Format: 'param name in SEF url' => array('real GET param name', 'table to look up for id', 'field where to get value that corredsponds with id', 'field to store sef param value', this is a multiple value parameter (boolean), 'type of the param')
	// ! hardcode: p.title, p.title_en
	$rs = db_mysql_query(
			"SELECT p.id sef_name, p.real_name, p.type_id, m.table_name, f.field, p.is_multi_value, f.multi_lang, f.type_extra field_type,
					p.title, p.title_en
				FROM " . ($section_type_id?"seo_parameter2section_type p2t,":"") . "seo_parameter p
				LEFT JOIN meta_table_field f ON p.meta_table_field_id = f.id
				LEFT JOIN meta_table m ON f.meta_table_id = m.id
				WHERE " . ($section_type_id?"p.id = p2t.seo_parameter_id AND p2t.section_type_id = '" . mysql_real_escape_string($section_type_id, $conn) . "'":"1") .
					(!$from_backend?" AND p.published <> 0 AND (p.activated <> 0 OR p.type_id <> '' OR p.meta_table_field_id IS NULL)":"") . "
				ORDER BY " . ($section_type_id?"p2t.sort_num":"p.sort_num"), $conn);
	$i = 0;
	while ($row = mysql_fetch_assoc($rs)) {
		$res[$row['sef_name']] = array(
			'real_param_name' => $row['real_name'],
			'values_table' => $row['table_name'],
			'values_source_field_name' => $row['field'],
			'values_source_field' => $row['field'] . (($row['multi_lang'] and $config['SEO_URL_SOURCE_LANG_ID'] != '')?'_' . $config['SEO_URL_SOURCE_LANG_ID']:''),
			'values_target_field' => $row['field'] . $config['SEO_URL_TARGET_FIELD_POSTFIX'],
			'multi_value_param' => $row['is_multi_value'],
			'multi_lang_field' => $row['multi_lang'],
			'type' => $row['type_id'],
			'title' => $row['title'],
			'title_en' => $row['title_en'],
			'is_lookup_custom' => ($row['field_type'] == 'lookup_custom'),
			'order_num' => $i++, // unique num, not sort_num from the table
		);
		
		if ($res[$row['sef_name']]['is_lookup_custom']) {
			$res[$row['sef_name']]['table_name'] = 'meta_table_field_option';
			$res[$row['sef_name']]['field'] = 'title';
			$res[$row['sef_name']]['options_field_name'] = 'meta_table_field_id';
		}
	}
	mysql_free_result($rs);
	return isset($res)?$res:false;
}

// others
function make_mail_recepients($str) {
	return explode(',', preg_replace("/[\,;\s]+/", ',', trim($str)));
}

function generate_password($password_length = 8) {
	$arr = '2345678923456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
	$arr_count_dec = strlen($arr) - 1;
	$pass = '';
	for($i = 0; $i < $password_length; $i++) {
		$pass .= $arr[rand(0, $arr_count_dec)];
	}
	return $pass;
}

function generate_passkey($passkey_length = 8) {
    $salt = '';
    for($i = 0; $i < $passkey_length; $i++) {
         $salt .= chr(rand(33,126));
    }
    return $salt;
}
?>