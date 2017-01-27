<?
$config['DEBUG_ENABLED'] = false; // error reporting

$config['DB_SERVER'] = 'localhost';
$config['DB_USER'] = 'root';
$config['DB_PASSWORD'] = '';
$config['DB_DATABASE'] = 'moscowkey';
$config['DB_TABLE_PREFIX'] = '';
$config['DB_DEFAULT_UTF8'] = true;

$config['CACHE_ENABLED'] = false;

$config['TEMPLATE_OUTER_FILE_NAME'] = 'common_outer.php';
$config['TEMPLATE_OUTER_AJAX_FILE_NAME'] = 'ajax_outer.php';
$config['TEMPLATE_404_FILE_NAME'] = '404.php';

$config['CONTENT_CSS_FILE_PATH'] = '/css/content.css';
$config['CONTENT_CSS_CLASS_NAME'] = 'text-content';

$config['LANG_ENABLED'] = true;
$config['LANG_DIR_NAME'] = 'languages';
/*$config['LANG_PARAM_MODE'] = true;
$config['LANG_PARAM_NAME'] = 'l';*/

$config['AUTH_ENABLED'] = false;
$config['AUTH_LOGIN_PAGE'] = '/login/';
$config['AUTH_BACK_PATH_PARAM_NAME'] = 'back_path';

$config['DATA_ENABLED'] = true;	// pass data into the templates in $_DATA variable 
$config['DATA_PAGE_PARAM_NAME'] = 'page';
$config['DATA_PUBLISHED_FIELD_NAME'] = 'published';

$config['OUT_TYPO_ENABLED'] = true;

$config['SEO_ENABLED'] = true;
$config['SEO_URL_NAMED_PARAMS_MODE'] = true; // if true, include name of parameter in url, otherwise get the parameter values strictly by the order of appearance in url
$config['SEO_URL_PARAM_NAME_DELIMETER'] = '/'; // using '-' may cause collision betweeen 'news' and 'news-tag' parameter names
$config['SEO_URL_PARAM_EMPTY_VALUE'] = '-';
$config['SEO_URL_SOURCE_LANG_ID'] = '';
$config['SEO_URL_TARGET_FIELD_POSTFIX'] = '_seo';
$config['SEO_URL_PUBLISHED_FIELD_NAME'] = 'published';
$config['SEO_URL_PATH_PARAM_NAME'] = '$'; // only if mod_rewrite is not available

$config['GALLERY_THUMBNAIL_DIR_NAME'] = '.resize';
$config['GALLERY_THUMBNAIL_ALT_PATH'] = ''; // if not empty, overrides <image_path>/GALLERY_THUMBNAIL_DIR_NAME
$config['GALLERY_THUMBNAIL_CROP_METHOD'] = 'wh'; // w = width | h = height | c = square by width | wh, default = exact width and height
$config['GALLERY_THUMBNAIL_WIDTH'] = 450;
$config['GALLERY_THUMBNAIL_HEIGHT'] = 300;

$config['MAIL_FROM_NAME'] = 'МСК Ключ';
$config['MAIL_FROM_EMAIL'] = 'no-replay@mskkey.ru';
$config['MAIL_SMTP_HOST'] = 'localhost';
$config['MAIL_SMTP_PORT'] = 25;
$config['MAIL_SMTP_AUTH'] = false;
$config['MAIL_SMTP_USERNAME'] = 'free';
$config['MAIL_SMTP_PASSWORD'] = 'pass';

$config['MAIL_CONTENT_HTTP_HOST'] = 'http://www.mskkey.ru';
$config['MAIL_CONTENT_EMAIL_PARAM_NAME'] = 'email';
$config['MAIL_CONTENT_EMBED_IMAGES'] = false;

global $config;
?>