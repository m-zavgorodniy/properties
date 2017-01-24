<?
class Site {
	var $site_id;
	var $site_path;
	var $site_path_mode;
	var $site_real_path;
	var $own_domain;
//	var $custom_templates;

	var $site_title;
	var $site_keywords;
	var $site_description;
	
	var $page_title;

	var $section_id;
	var $section_type;
	var $section_path;
	var $section_title;
	var $section_protected;

	var $seo_title;
	var $seo_description;
	var $seo_keywords;
	var $seo_h1;
	var $seo_text;
	var $seo_redirect_url;

	var $section_image;

	var $menu;
	var $crumbs;
	var $section_paths;
	var $settings;

	var $root_section_id;

	var $config;

	var $conn;

	var $authorized;
	var $auth_user_id;

	var $is_index_page;
	var $is_ajax_request;
	var $http_error;
	
	var $locale;
	var $lang_id;
	var $lang_field_postfix;
	var $lang_path;
	var $html_lang;

	function Site($section_path, $section_id, $section_type, $site_id, $site_path_mode, $lang_id, $is_ajax_request, $conn, $config) {
		$this->site_id = $site_id;
		$this->site_path = '';
		$this->site_real_path = '';
		$this->site_path_mode = $site_path_mode;;

		$this->lang_id = $lang_id;
		$this->lang_field_postfix = '';
		$this->lang_path = ($this->lang_id?'/' . $this->lang_id:'');
		
		$this->is_ajax_request = $is_ajax_request;

		$this->section_path = $section_path;
		$this->section_id = $section_id;
		$this->section_type = $section_type;

//		$this->section_image = '';

		$this->config = $config;

		$this->conn = $conn;
	}
	
	function init() {
/*		if (!is_resource($conn) or 'mysql link' !== get_resource_type($conn)) {
			$this->conn = db_mysql_connect(true);
		} */
		if ($this->site_id !== NULL) {
			$this->get_site();
		}
		if (!$this->is_ajax_request) {
			$this->get_menu();
		}
		$this->get_settings();
		$this->get_section_paths();

//		$this->is_index_page = ('index' == $this->section_type);
		$this->is_index_page = ('/' == $this->section_path);

		if ($this->section_id and $this->get_crumbs()) { // get_crumbs() sets $this->site_title, $this->$section_path, $this->section_title, $this->section_image
			if ($this->config['SEO_ENABLED']) {
				// ! ORDER BY url DESC - to process absolute URLs starting with http before relative URLs starting with /
				$rs = db_mysql_query(
				"SELECT title, meta_keywords, meta_description, h1, body, redirect_url
					FROM seo_url_data
					WHERE ('" . mysqli_real_escape_string($this->conn, $_SERVER["REQUEST_URI"]) . "' REGEXP CONCAT('^', REPLACE(REPLACE(url, '?', '\\\\?'), '*', '[^\/]+'), '$')
							OR '" . mysqli_real_escape_string($this->conn, ($_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]) . "' REGEXP CONCAT('^', REPLACE(REPLACE(url, '?', '\\\\?'), '*', '[^\/]+'), '$'))
						AND published <> 0
					ORDER BY url DESC
					LIMIT 1", $this->conn);
				$row = mysqli_fetch_assoc($rs);
				mysqli_free_result($rs);
				if ($row) {
					$this->seo_title = $row['title'];
					$this->seo_description = $row['meta_description'];
					$this->seo_keywords = $row['meta_keywords'];
					$this->seo_h1 = $row['h1'];
					$this->seo_text = html_content_filter($row['body'], NULL, !$this->config['OUT_TYPO_ENABLED'], $this->locale);
					$this->seo_redirect_url = $row['redirect_url'];
				}
			}

			$this->root_section_id = key($this->crumbs);

			if ($this->config['AUTH_ENABLED']) {
				if (isset($_REQUEST[session_name()])) session_start();

				if (!isset($_SESSION['user_id'])) { // or $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
					$this->authorized = false;
					$this->auth_user_id = NULL;
				} else {
					$this->authorized = true;
					$this->auth_user_id = $_SESSION['user_id'];
				}

				session_write_close();
			}
			
			if (!$this->seo_title) {
				$this->page_title = ($this->is_index_page?'':$this->section_title . ' - ') . $this->site_title;
			} else {
				$this->page_title = $this->seo_title;
			}
			
			 // carefully, in the very end, adding trailing slash for use in templates
			$this->section_path = rtrim($this->section_path, '/') . '/';
			
			return true;
		} else { // section is not published or does not exist
			$this->page_title = $this->section_title = $this->http_error = "404";
			return false;
		}
	}
	
	function get_site() {
		$rs = db_mysql_query("SELECT path, own_domain, locale FROM meta_site WHERE id = '" . $this->site_id . "'", $this->conn); // , custom_templates
		// SELECT path, own_domain, lang_id.. - lang_id is removed
		// supposed to be one record
		$row = mysqli_fetch_assoc($rs);
		mysqli_free_result($rs);
		if ($row) {
			$this->site_real_path = rtrim($row['path'], " /");
			$this->own_domain = $row['own_domain'];
			// using it's own domain name for each site we don't put site's path into the url here and, therefore, don't make url at all 
			// uri supposed to be rewritten by mod_rewrite to get into the real site's directory
			if (!$row['own_domain']) {
				$this->site_path = $this->site_real_path;
			}
//			$this->custom_templates = $row['custom_templates'];

			$this->locale = $row['locale'];
			$this->html_lang = current(explode('_', $row['locale']));
			if ($this->config['LANG_ENABLED']) {
				// also checks if lang_id really exists
				$rs = db_mysql_query("SELECT id, locale FROM meta_site_lang WHERE id = '" . mysqli_real_escape_string($this->conn, $this->lang_id) . "'", $this->conn);
				if ($row_lang = mysqli_fetch_row($rs)) {
					$this->lang_field_postfix = '_'.$row_lang[0];
					$this->locale = $row_lang[1];
					$this->html_lang = current(explode('_', $row_lang[1]));
				} else {
/*					$this->lang_id = $row['lang_id']; // site's lang_id
					$this->lang_field_postfix = $this->lang_id?'_'.$this->lang_id:'';*/
					$this->lang_id = '';
					$this->lang_field_postfix = '';
				}
				mysqli_free_result($rs);
			} else {
				$this->lang_id = '';
			}
		}
	}

	function get_crumbs() {
		$path = array();
		$published = $this->get_back_path($path, $this->section_id, true);
//		array_shift($path);
		if ($published === false) {
			return false;
		} else {
			reset($path);
			$this->crumbs = & $path;
			return true;
		}
	}
	function get_back_path(&$path, $section_id, $is_current = false) { // private
		$rs = db_mysql_query("SELECT s.id, s.section_id, s.section_type_id, s.published, s.protected, s.path, s.dir, s.url, s.title" . $this->lang_field_postfix . " title, s.target_blank,
							 		 s.meta_title" . $this->lang_field_postfix . " meta_title, s.meta_description" . $this->lang_field_postfix . " meta_description,
									 s.img_src
							  FROM section s
							  WHERE s.id = " . $section_id, $this->conn); //, s.meta_keywords
		$row = mysqli_fetch_assoc($rs);
		mysqli_free_result($rs);
		if ($row) {
			if (!$this->section_image and $row['img_src']) { // while picture is not found
				$this->section_image = $row['img_src'];
			}
			
			if ($is_current) {
				$section_path = ($this->own_domain?'':$this->site_path) . $this->lang_path . $row['path'] . $row['dir']; // . ($row['dir']?'/':'');
/////	!!! CHECK IT
/////			if ($row['dir'] and SCRIPT_REAL_PATH != $this->site_real_path . $section_path) {
/////				return false; // section is moved
/////			} else {
					$this->section_title = $this->config['OUT_TYPO_ENABLED']?typo_filter($row['title'], $this->locale):$row['title'];
					/// all SEO data moved into the seo_url_data table
					/// so we don't do recursive search for title here (?)

/*					if (!$this->site_title and $row['meta_title']) {
						$this->site_title = $row['meta_title'];
					}
					if (!$this->site_keywords and $row['meta_keywords']) {
						$this->site_keywords = $row['meta_keywords'];
					}
					if (!$this->site_description and $row['meta_description']) {
						$this->site_description = $row['meta_description'];
					}*/
////					if ($section_path == $this->section_path) {
					if ($section_path == rtrim((($this->site_path_mode and '' !== $this->site_path)?next(explode($this->site_path, $_SERVER['REQUEST_URI'], 2)):$_SERVER['REQUEST_URI']), '/')) {
						$crumb['is_current'] = true;
					}
/////			}
			}
			if ($row['section_id'] === NULL) { // the top section has been reached
				/// all SEO data moved into the seo_url_data table
				/// so we don't do recursive search for title here (?)
				
//				if (!$this->site_title and $row['meta_title']) {
					$this->site_title = $row['meta_title'];
//				}
//				if (!$this->site_keywords and $row['meta_keywords']) {
//					$this->site_keywords = $row['meta_keywords'];
//				}
//				if (!$this->site_description and $row['meta_description']) {
					$this->site_description = $row['meta_description'];
//				}
				return;
			}
			if ($row['published'] != 0) {
				$crumb['title'] = $row['title'];
				$crumb['section_type_id'] = $row['section_type_id'];
				$this->get_menu_item_link($row, $crumb);
				$path = array($row['id'] => $crumb) + $path; // merge arrays with preserved keys
				if ($this->config['AUTH_ENABLED'] and $row['protected'] != 0) {
					$this->section_protected = true;
				}
			} else {
				return false; // section is not published
			}
			if (false === $this->get_back_path($path, $row['section_id'])) {
				return false; // ancestor section is not published
			}
		} else {
			return false; // section does not exist
		}
	}

	function get_menu() {
		$rs = db_mysql_query("SELECT s.id, s.section_type_id, IFNULL(sc.title" . $this->lang_field_postfix . ", s.title" . $this->lang_field_postfix . ") title, s.path, s.dir, s.url, s.section_id, s.target_blank,
								sc.container_id menu, sc.img_src,
								submenu.id submenu_id, submenu.section_type_id submenu_section_type_id, submenu.title" . $this->lang_field_postfix . " submenu_title, submenu.dir submenu_dir,
								submenu.url submenu_url, submenu.target_blank submenu_target_blank,
								submenu2.id submenu2_id, submenu2.section_type_id submenu2_section_type_id, submenu2.title" . $this->lang_field_postfix . " submenu2_title, submenu2.dir submenu2_dir,
								submenu2.url submenu2_url, submenu2.target_blank submenu2_target_blank
							  FROM section2container sc, section s
							  LEFT JOIN section submenu ON s.id = submenu.section_id AND submenu.published <> 0 AND submenu.hidden = 0
							  LEFT JOIN section submenu2 ON submenu.id = submenu2.section_id AND submenu2.published <> 0 AND submenu2.hidden = 0
							  WHERE s.id = sc.section_id AND s.published <> 0 AND s.hidden = 0 AND s.meta_site_id = '" . $this->site_id . "'
							  " . ($this->config['LANG_ENABLED']?"AND (s.meta_site_lang_id = '" . $this->lang_id . "' OR FIND_IN_SET('" . $this->lang_id . "', s.meta_site_lang_id))":'') . "
							  ORDER BY menu, sc.sort_num, s.sort_num, submenu.sort_num, submenu2.sort_num", $this->conn);
		while($row = mysqli_fetch_assoc($rs)) {
			if ($menu != $row['menu']) {
				$menu = $row['menu'];
				unset($menu_id);
			}
			if ($menu_id != $row['id']) { // ORDER BY menu is important
				$menu_id = $row['id'];
				
				$menu_item = &$this->menu[$row['menu']][$menu_id];
				$menu_item['title'] = $row['title'];
				$menu_item['img_src'] = $row['img_src'];
				$menu_item['section_type_id'] = $row['section_type_id'];
				$this->get_menu_item_link($row, $menu_item);
	
				if ($row['submenu_id']) {
					$submenu_id = $row['submenu_id'];
					
					$submenu_item = &$this->menu[$row['menu']][$menu_id]['submenu'][$row['submenu_id']];
					$submenu_item['title'] = $row['submenu_title'];
					$submenu_item['section_type_id'] = $row['submenu_section_type_id'];
					$this->get_menu_item_link($row, $submenu_item, 1);
				}

				if ($row['submenu2_id']) {
					$submenu2_item = &$this->menu[$row['menu']][$menu_id]['submenu'][$row['submenu_id']]['submenu'][$row['submenu2_id']];
					$submenu2_item['title'] = $row['submenu2_title'];
					$submenu2_item['section_type_id'] = $row['submenu2_section_type_id'];
					$this->get_menu_item_link($row, $submenu2_item, 1);
				}
			} else if ($submenu_id != $row['submenu_id']) { // submenu record
				$submenu_id = $row['submenu_id'];
				
				$submenu_item = &$this->menu[$row['menu']][$menu_id]['submenu'][$row['submenu_id']];
				$submenu_item['title'] = $row['submenu_title'];
				$submenu_item['section_type_id'] = $row['submenu_section_type_id'];
				$this->get_menu_item_link($row, $submenu_item, 1);

				if ($row['submenu2_id']) {
					$submenu2_item = &$this->menu[$row['menu']][$menu_id]['submenu'][$row['submenu_id']]['submenu'][$row['submenu2_id']];
					$submenu2_item['title'] = $row['submenu2_title'];
					$submenu2_item['section_type_id'] = $row['submenu2_section_type_id'];
					$this->get_menu_item_link($row, $submenu2_item, 1);
				}
			} else { // level 2 submenu record
				$submenu2_item = &$this->menu[$row['menu']][$menu_id]['submenu'][$row['submenu_id']]['submenu'][$row['submenu2_id']];
				$submenu2_item['title'] = $row['submenu2_title'];
				$submenu2_item['section_type_id'] = $row['submenu2_section_type_id'];
				$this->get_menu_item_link($row, $submenu2_item, 2);
			}
		}
		mysqli_free_result($rs);
}
	
	function get_menu_item_link($row, &$menu_item, $submenu_level = 0) {
		if ($row['section_type_id'] != 'menuitem') {
			if ($row['section_type_id'] != 'link') {
//				$menu_item['url'] =  $this->site_path . $this->lang_path . $row['path'] . $row['dir'] . ($submenu_level == 1?'/' . $row['submenu_dir']:'') . ($submenu_level == 2?'/' . $row['submenu2_dir']:'') . '/';
				$menu_item['url'] = $this->site_path . $this->lang_path . $row['path'] . $row['dir'] . ($submenu_level >= 1?'/' . $row['submenu_dir']:'') . (($row['submenu2_dir'] and ($submenu_level == 1 and $row['submenu_section_type_id'] == 'menuitem' or $submenu_level == 2))?'/' . $row['submenu2_dir']:'') . ($row['dir']?'/':'');
			} else {
				$menu_item['url'] = $row['url'];
			}
			$menu_item['target_blank'] = $row['target_blank'];
		} else if ($row['submenu_id'] and $row['submenu_section_type_id'] != 'menuitem') {
			if ($row['submenu_section_type_id'] != 'link') {
				$menu_item['url'] =  $this->site_path . $this->lang_path . $row['path'] . $row['dir'] . '/' . $row['submenu_dir'] . '/';
			} else {
				$menu_item['url'] = $row['submenu_url'];
			}
			$menu_item['target_blank'] = $row['submenu_target_blank'];
		} else if ($row['submenu2_id'] and $row['submenu2_section_type_id'] != 'menuitem') {
			if ($row['submenu2_section_type_id'] != 'link') {
				$menu_item['url'] =  $this->site_path . $this->lang_path . $row['path'] . $row['dir'] . '/' . $row['submenu_dir'] . '/' . $row['submenu2_dir'] . '/';
			} else {
				$menu_item['url'] = $row['submenu2_url'];
			}
			$menu_item['target_blank'] = $row['submenu2_target_blank'];
		} else { // !! todo - trace it, why do we get here? and ($row['submenu2_id']?$row['submenu2_id']:($row['submenu_id']?$row['submenu_id']:$row['id'])) is just a guess
			$rs = db_mysql_query("SELECT id, section_type_id, path, dir, url, section_id, target_blank
								  FROM section
								  WHERE published <> 0 AND section_id = " . ($row['submenu2_id']?$row['submenu2_id']:($row['submenu_id']?$row['submenu_id']:$row['id'])) . " ORDER BY sort_num", $this->conn);
			if ($row_link = mysqli_fetch_assoc($rs)) {
				$this->get_menu_item_link($row_link, $menu_item);
			} else {
				$menu_item['url'] = '#';
			}
			mysqli_free_result($rs);
		}
	}

/*	function get_meta() {
		$rs = db_mysql_query("SELECT title, meta_keywords keywords, meta_description description FROM section
							  WHERE section_id IS NULL and meta_site_id = '" . $this->site_id . "'", $this->conn);
		// supposed to be one record
		$row = mysqli_fetch_assoc($rs);
		mysqli_free_result($rs);
		return $row; // meta[{'title', 'keywords', 'description'}]
	}*/

	function set_page_context($page_titles) {
		if (!is_array($page_titles) or !count($page_titles)) return;
		
		if (!$this->seo_title) {
			$this->page_title = implode(' - ', array_unique($page_titles)) . ' - ' . $this->site_title;
		}

//		$this->crumbs[$this->section_id]['is_last'] = false;
		$real_path = $this->crumbs[$this->section_id]['url'];
		foreach($page_titles as $url_snippet => &$title) {
			if ($url_snippet) {
				$this->crumbs[$url_snippet] = array('title' => $title, 'url' => $real_path . $url_snippet); // normal index of crumbs is id of section - here it's an url to avoid mixing with the normals
				if ($this->crumbs[$url_snippet]['url'] == $_SERVER['REQUEST_URI']) {
					$this->crumbs[$url_snippet]['is_current'] = true;
				}
			} else {
				$this->page_title = $title . ' - ' . $this->site_title; // single item title (comes with no url) - show it instead of all others
			}
		}
		unset($title);

		end($this->crumbs);
//		if ($_SERVER['REQUEST_URI'] == $menu_item['url'])
		if ($url_snippet)
			$this->crumbs[key($this->crumbs)]['is_current'] = true; // ?
	}
		
	function get_settings() {
		$rs = db_mysql_query("SELECT id, value, value" . $this->lang_field_postfix . " value_lang, type, multi_lang FROM setting WHERE 1", $this->conn);
		while ($row = mysqli_fetch_assoc($rs)) {
			$value = $row['multi_lang']?$row['value_lang']:$row['value'];
			$res[$row['id']] = ($row['type'] != 'html')?htmlspecialchars($value):$value;
		}
		mysqli_free_result($rs);
		$this->settings = $res?$res:false;
	}
	
	function get_section_paths() {
		$rs = db_mysql_query("SELECT section_type_id, path, dir, title" . $this->lang_field_postfix . " title FROM section WHERE meta_site_id = '" . $this->site_id . "' AND published <> 0 GROUP BY section_type_id", $this->conn);
		while ($row = mysqli_fetch_row($rs)) {
			$res[$row[0]]['path'] = ($this->own_domain?'':$this->site_path) . $this->lang_path . $row[1] . $row[2] . ($row[2]?'/':'');
			$res[$row[0]]['title'] = $row[3];
		}
		mysqli_free_result($rs);
		$this->section_paths = $res?$res:false;
	}
}
?>