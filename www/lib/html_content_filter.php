<?
// encoding UTF-8

/* 

	from http://php.net/manual/en/function.strip-tags.php, 27-Aug-2010 12:04
	check it
	
*/

    function strip_word_html($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br>') 
     { 
         mb_regex_encoding('UTF-8'); 
         //replace MS special characters first 
         $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u'); 
         $replace = array('\'', '\'', '"', '"', '-'); 
         $text = preg_replace($search, $replace, $text); 
         //make sure _all_ html entities are converted to the plain ascii equivalents - it appears 
         //in some MS headers, some html entities are encoded and some aren't 
         $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8'); 
         //try to strip out any C style comments first, since these, embedded in html comments, seem to 
         //prevent strip_tags from removing html comments (MS Word introduced combination) 
         if(mb_stripos($text, '/*') !== FALSE){ 
             $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm'); 
         } 
         //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be 
         //'<1' becomes '< 1'(note: somewhat application specific) 
         $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text); 
         $text = strip_tags($text, $allowed_tags); 
         //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one 
         $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text); 
         //strip out inline css and simplify style tags 
         $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu'); 
         $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>'); 
         $text = preg_replace($search, $replace, $text); 
         //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears 
         //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains 
         //some MS Style Definitions - this last bit gets rid of any leftover comments */ 
         $num_matches = preg_match_all("/\<!--/u", $text, $matches); 
         if($num_matches){ 
               $text = preg_replace('/\<!--(.)*--\>/isu', '', $text); 
         } 
         return $text; 
     }
	 
	 
function user_content_filter($str) {
	
	$str = preg_replace("/<(\/)?(script|frameset|frame|meta|link|style|h1|h2|h3|h4|h5|h6|font)[^>]*>/i","", $str);
	$str = preg_replace("/<([^>]*)[ \n\r\t](lang|style|size|face|on.+)(=\"[^\"]*\"|='[^']*'|=[^>[ \n\r\t]+|[^>[ \n\r\t]]+)([^>]*)>/i", "<\\1 \\4>", $str);
	$str = preg_replace("/<([^>]*)[ \n\r\t](lang|style|size|face|on.+)(=\"[^\"]*\"|='[^']*'|=[^>[ \n\r\t]+|[^>[ \n\r\t]]+)([^>]*)>/i", "<\\1 \\4>", $str);
	
	return $str;
}


function html_content_filter($str, $vars = NULL, $no_typo = false, $locale = '') {
	
	$str = preg_replace("/<(\/)?(font|del|ins)[^>]*>/i","", $str);
	// lang|style|size|face
	$str = preg_replace("/<([^>]*)[ \n\r\t](lang|style|size|face)(=\"[^\"]*\"|='[^']*'|=[^>[ \n\r\t]+|[^>[ \n\r\t]]+)([^>]*)>/i", "<\\1 \\4>", $str);
	$str = preg_replace("/<([^>]*)[ \n\r\t](lang|style|size|face)(=\"[^\"]*\"|='[^']*'|=[^>[ \n\r\t]+|[^>[ \n\r\t]]+)([^>]*)>/i", "<\\1 \\4>", $str);
	$str = str_replace(' >', '>', $str); // \\1 \\4 - check what if just remove the space?

	$str = preg_replace("/onclick=\"window.open([^\"]*)\"/i", "rel=\"callwindow\"", $str);
	
	// ! todo: put alignment and border in a single class attribute to display them at once
	$str = preg_replace("/<(img|table)[ \n\r\t]([^>]*)align=[\"\']?(left|right)[\"\']?([^>]*)>/i", "<\\1 \\2class=\"g-content-\\3\"\\4>", $str);
	$str = preg_replace("/<(img|table)[ \n\r\t]([^>]*)border=[\"\']?1[\"\']?([^>]*)>/i", "<\\1 \\2class=\"g-bordered\"\\3>", $str);

//	$str = str_replace(array('border=1', 'border="1"'), 'class="g-bordered"', str_replace(array('align=right', 'align="right"'), 'class="g-content-right"', str_replace(array('align=left', 'align="left"'), 'class="g-content-left"', $str))); //str_replace(array('border=0', 'border="0"'), 'class="g-noborder"',
	

	 // display php vars inside the body, format: $$var_name$
	if (is_array($vars) and strpos($str, '$$') !== false) {
		$expl = explode('$$', $str);
		$str = '';
		$not_first = false;
		foreach($expl as $tok) {
			if (!$not_first and ($not_first = true)) { // skip the first
				$str .= $tok;
				continue;
			}
			if (strpos($tok, '$') === false) {
				$str .= '$$' . $tok;
			} else {
				list($param, $tail) = explode('$', $tok, 2);
				if (isset($vars[$param])) {
					$str .= $vars[$param] . $tail;
				} else {
					$str .= '$$' . $tok;
				}
			}
		}
		unset($tok);
	}

	if (strpos($str, '[#') !== false) {
		$str = html_content_pattern_parser($str);
	}
	
	return !$no_typo?typo_filter($str, $locale):$str;
}

function typo_filter($str, $locale = '') {
	switch ($locale) {
		case 'en_GB': $lq = '‘'; $rq = '’'; break;
		case 'en_US': $lq = '“'; $rq = '”'; break;
		// ... ! todo. continue with http://artefact.lib.ru/design/text_macros_05_quotes_typo.shtml
		default: $lq = '«'; $rq = '»'; // ru
	}
	
	// ! hardcode for ru/en site
	if ($lq == '«') {
		$str = str_replace(array('“', '”'), array($lq, $rq), $str);
	} else {
		$str = str_replace(array('«', '»'), array($lq, $rq), $str);
	}

	$str = preg_replace_callback("/<([^>]*)>/s", function($m) {return '<'.str_replace('"', '¬', '"' . $m[1] .'"') .'>';}, $str);
	$str = preg_replace_callback( "/<script(.*?)<\/script>/is", function($m) {return '<script'.str_replace('"', '¬', '"' . $m[1] . '"').'</script>';}, $str); // escapes single qoutes inside the script (and everywhere). todo
	$str = preg_replace("/(^|>|[(\s\"])(\")([^\"]*)([^\s\"(])(\")/", "\\1" . $lq . "\\3\\4" . $rq . "", $str); // nested quotes are not proccessed. todo
	
	$str = str_replace('¬', '"', $str);

//	$str = preg_replace("/(\d+)(-\s*|—)(\d+)/U", "\\1&ndash;\\3", $str); // what about phone numbers?
	$str = preg_replace("/\s+(-|–)(\s+|<|>)/", "&nbsp;&mdash;\\2", $str);
	$str = preg_replace(array("/\s+([.,:;!?%)]|" . $rq . ")/", "/([(]|" . $lq . ")\s+/"), "\\1", $str);

	$str = preg_replace("/\b(\d+)\s+(.+?)/", "\\1&nbsp;\\2", $str);

//	hanging quotation
//	$str = str_replace($lq, '<span class="g-laquo">' . $lq . '</span>', $str);
//	$str = str_replace(' <span class="g-laquo">', '<span class="g-laquo-pre"> </span><span class="g-laquo">', $str);

	return $str;
}

// text cut
$cut_open = false;
function handle_cut($text_more) {
	global $cut_open;
	$cut_open = true;
	define('CUT_CLOSE_TAG', '</div></div>');
	// we don't care if there's more than one cut
	return '<div class="text-cut"><div class="text-cut-control">+ <a href="javascript:;">' . ($text_more?$text_more:'read more') . '</a></div><div class="text-cut-content">';
}
function handle_cutend($text_more) {
	global $cut_open, $cut_close_tag;
	$cut_open = false;
	return CUT_CLOSE_TAG;
}

function html_content_pattern_parser($str) {
	global $cut_open;

	// define patterns to use in square brackets within html field and custom handling procedures
	// usage: [#<pattern>[-<id>]]
	$handling_patterns = array (
	//	'pattern_signature' => 'handling_procedure',
	//	'anketa' => 'handle_anketa',
		'cut' => 'handle_cut',
		'cutend' => 'handle_cutend'
	);

	// ! hack for the cut patterns
	// it have to be done with plugin, in the editor
	$str = preg_replace("/<p>(.*)\s*\[#cut/", "\\1[#cut", $str);
	
	$str_expl = explode("[", $str);
	$str = '';
	foreach ($str_expl as $i => &$tok) {
		if (strpos($tok, "#") !== 0 or strpos($tok, "]") === false) {
			if ($i > 0)
				$str .= "[";
			$str .= $tok;
		} else {
			$tok_expl = explode("]", $tok, 2);
			$pattern_expl = explode("-", $tok_expl[0], 2);
			$pattern_signature = substr($pattern_expl[0], 1);
			// ! hack for cut patterns
			// it have to be done with plugin, in the editor
			if ($pattern_signature == 'cut' or $pattern_signature == 'cutend') {
				if (substr(trim($tok_expl[1]), 0, 4) == '</p>') {
					$tok_expl[1] = substr(trim($tok_expl[1]), 4);
				}
			}
			if (array_key_exists($pattern_signature, $handling_patterns)) {
				$str .= $handling_patterns[$pattern_signature]($pattern_expl[1]).$tok_expl[1];
			}
			else {
				$str .= "[".$tok;
			}
		}
	}
	unset($tok);
	// ! hack for cut patterns
	// it have to be done with plugin, in the editor
	if ($cut_open) {
		$str .= CUT_CLOSE_TAG;
	}
	return $str;
}
?>