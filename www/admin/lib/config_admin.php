<?
define('ADMIN_LOGIN', 'admin');

define('SESSION_INACTIVITY_TIMEOUT', 28800);
define('SESSION_ID_COOKIE_NAME', session_name());
define('SESSION_BIND_TO_IP', true);
//session_save_path('/tmp');

define('DATE_FORMAT', '%d.%m.%Y');
// todo! get rid of it
define('DATE_SEPARATOR', '.');
define('DATE_MONTH_FIRST', false);

// interface
define('SITE_TREE_LEVEL_MAX', 3);
define('RECORDS_ON_PAGE_NUM', 100);
define('SHOW_BACK_BUTTON', true);
define('RESIZE_ENABLED', true);

// engine
define('ACTION_TYPE', $_GET['type']);
define('ID', $_GET['id']);

// custom
define('SIZE_UNDEFINED', ' (0x0)');

// properties
define('PROPERTY_TYPE_SALE_ID', 1);
define('PROPERTY_SUBTYPE_ID_APT', 2);
?>