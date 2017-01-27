<?
class CustomEditor extends Editor {

	function get_init_input() {
		global $config;

		parent::get_init_input();

		if ($this->input_params['id'] === '') {
			$this->set_record_meta('id', array('readonly' => 1, 'required' => 0));
			$this->set_record_meta('path_files', array('comment' => "'<doc_root>" . $_SESSION['site_path'] . "', если не заполнено"));
		}

	}

	function on_update_success() {
// !! TODO
// put the sites configuration into .htaccess
// show the .htaccess snippet and warn user that it will be written into .htaccess - so user can choose just copy it or confirm writing. Alert user if .htaccess is not writable.
// generate site_id.php and others
/*

	if ($this->input_params['own_domain'] and '' !== $this->input_params['path']) {
		
		...
		
# ----- added by CMS -----
# this snippet was added by CMS
# if you change manually something within the snippet you may lost the changes after modification of CMS sites configuration 

process lib/engine/htaccess.tmpl here

if path is empty 
do not put
RewriteCond %{HTTP_HOST} ^(www\.)?boo$ [OR]
RewriteCond %{HTTP_HOST} ^(www\.)?booclick.ru$
RewriteRule ^(.*)$ <empty_path/>$1
at all, it has no sence

in 'path-mode' 
just put it in the very end
RewriteCond %{HTTP_HOST} ^(www\.)?cms$
RewriteRule ^(.*)$ <empty_path/>url_processor.php

# ----- /added by CMS -----		
		
	}
*/
		if ($this->init_params['id'] == $_SESSION['site_id']) {
			session_start();
			$_SESSION['site_id'] = $this->input_params['id'];
			set_site_path($_GET['site']);
			session_write_close();
		}
		parent::on_update_success();
	}
}
?>