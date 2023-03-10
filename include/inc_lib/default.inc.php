<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_INCLUDE_CHECK')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

//ini_set('display_errors', 0);
@ini_set( 'arg_separator.output' , '&amp;' );

if(!empty($phpwcms['php_timezone'])) {
	@date_default_timezone_set($phpwcms['php_timezone']);
}

// i18n charsets that might be accessible - in general used in MySQL
// but a few more as listed here http://www.w3.org/International/O-charset-list.html
$phpwcms['charsets'] = array(
	'iso-2022-kr',
	'iso-2022-jp',
    'iso-8859-1',
    'iso-8859-2',
    'iso-8859-3',
    'iso-8859-4',
    'iso-8859-5',
    'iso-8859-6',
    'iso-8859-7',
    'iso-8859-8',
	'iso-8859-8-i',
    'iso-8859-9',
    'iso-8859-10',
    'iso-8859-11',
    'iso-8859-12',
    'iso-8859-13',
    'iso-8859-14',
    'iso-8859-15',
	'iso-10646-ucs-2',
	'windows-874',
    'windows-1250',
    'windows-1251',
    'windows-1252',
	'windows-1253',
	'windows-1254',
	'windows-1255',
    'windows-1256',
    'windows-1257',
	'windows-1258',
    'koi8-r',
    'big5',
    'gb2312',
	'us-ascii',
    'utf-16',
    'utf-8',
    'utf-7',
    'x-user-defined',
	'euc-cn',
    'euc-jp',
	'euc-kr',
	'euc-tw',
    'ks_c_5601-1987',
    'tis-620',
    'shift_jis'
);

define ('PHPWCMS_CHARSET', 	empty($phpwcms["charset"]) ? 'utf-8' : strtolower($phpwcms["charset"]));

if(!empty($phpwcms['php_charset'])) {
	@ini_set('default_charset', PHPWCMS_CHARSET);
	@ini_set('iconv.input_encoding', PHPWCMS_CHARSET);
	@ini_set('iconv.internal_encoding', PHPWCMS_CHARSET);
	@ini_set('iconv.output_encoding', PHPWCMS_CHARSET);
	@ini_set('mbstring.internal_encoding', PHPWCMS_CHARSET);
	@ini_set('mbstring.http_output', PHPWCMS_CHARSET);
}

if(defined('CUSTOM_CONTENT_TYPE')) {

	header(CUSTOM_CONTENT_TYPE);

} else {

	header('Content-Type: text/html; charset='.PHPWCMS_CHARSET);
	$_use_content_type = 'text/html';

}

$phpwcms["site"] = rtrim($phpwcms["site"], '/');
if(empty($phpwcms['site_ssl_url'])) {
	$phpwcms['site_ssl_url'] = $phpwcms["site"];
} else {
	$phpwcms["site_ssl_url"] = rtrim($phpwcms["site_ssl_url"], '/');
}
if(substr($phpwcms['site_ssl_url'], 0, 5) == 'http:') {
	$phpwcms['site_ssl_url'] = 'https' . substr($phpwcms['site_ssl_url'], 4);
}
$phpwcms['site_ssl_port'] = abs(intval($phpwcms['site_ssl_port']));
if($phpwcms['site_ssl_port'] !== 443) {
	$phpwcms['site_ssl_url'] .= ':' . $phpwcms['site_ssl_port'];
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	if(substr($phpwcms['site'], 0, 5) == 'http:') {
		$phpwcms['site'] = $phpwcms['site_ssl_url'];
	}
	define ('PHPWCMS_SSL', true);
	define ('PHPWCMS_HTTP_SCHEMA', 'https');
} else {
	define ('PHPWCMS_SSL', false);
	define ('PHPWCMS_HTTP_SCHEMA', 'http');
}

$phpwcms["site"] .= '/';
$phpwcms['site_ssl_url'] .= '/';

// define the real path of the phpwcms installation
// important to script that must know the real path to files or something else

$phpwcms['DOC_ROOT'] = rtrim( str_replace("\\", '/', $phpwcms['DOC_ROOT']), '/' );
if( empty($phpwcms["root"]) ) {
	$phpwcms["root"]			 = '';
	$phpwcms["host_root"]		 = '';
} else {
	$phpwcms["root"]			 = trim( $phpwcms["root"], '/' );
	$phpwcms["host_root"]		 = '/'.$phpwcms["root"];
	$phpwcms['DOC_ROOT']		.= 	'/' . $phpwcms["root"];
	$phpwcms["root"]			.= 	'/';
}

define ("PHPWCMS_ROOT", 			$phpwcms['DOC_ROOT']);
define ('PHPWCMS_FILES', 			$phpwcms["file_path"] . '/');
define ('PHPWCMS_BASEPATH',			'/' . $phpwcms["root"]);
define ('On',						true);
define ('Off',						false);
define ('PHPWCMS_USER_KEY',			md5(getRemoteIP().$phpwcms['DOC_ROOT'].$phpwcms["db_pass"]));
define ('PHPWCMS_REWRITE',			empty($phpwcms["rewrite_url"]) ? false : true);
define ('PHPWCMS_REWRITE_EXT',		isset($phpwcms['rewrite_ext']) ? $phpwcms['rewrite_ext'] : '.html');
define ('PHPWCMS_ALIAS_WSLASH',		empty($phpwcms['alias_allow_slash']) ? false : true);
define ('IS_PHP5',					version_compare(PHP_VERSION, '5.0.0', '>='));
define ('IS_PHP523',				version_compare(PHP_VERSION, '5.2.3', '>='));

// Mime-Type definitions
require_once(PHPWCMS_ROOT.'/include/inc_lib/mimetype.inc.php');
require_once(PHPWCMS_ROOT.'/include/inc_lib/revision/revision.php');

phpwcms_getUserAgent();
define('BROWSER_NAME',				$phpwcms['USER_AGENT']['agent']);
define('BROWSER_NUMBER',			$phpwcms['USER_AGENT']['version']);
define('BROWSER_OS',				$phpwcms['USER_AGENT']['platform']);
define('BROWSER_MOBILE',			$phpwcms['USER_AGENT']['mobile']);

$phpwcms["file_path"]    		= 	'/'.$phpwcms["file_path"].'/' ;  // "/phpwcms_filestorage/"

define ('TEMPLATE_PATH', 			$phpwcms["templates"].'/');
$phpwcms["templates"]    		= 	'/'.$phpwcms["templates"].'/' ;  // "/phpwcms_template/"
$phpwcms["content_path"] 		= 	$phpwcms["content_path"].'/'  ;  // "content/"
define ('CONTENT_PATH',				$phpwcms["content_path"]);
$phpwcms["cimage_path"]  		= 	$phpwcms["cimage_path"].'/'   ;  // "images/"
$phpwcms["ftp_path"]     		= 	'/'.$phpwcms["ftp_path"].'/'  ;  // "/phpwcms_ftp/"

define ('PHPWCMS_TEMPLATE', 		PHPWCMS_ROOT.$phpwcms["templates"]);
define ('PHPWCMS_URL', 				$phpwcms["site"].$phpwcms["root"]);
$phpwcms['parse_url']			=	parse_url(PHPWCMS_URL);

define ('PHPWCMS_HOST',				$phpwcms['parse_url']['host'].$phpwcms["host_root"]);
define ('PHPWCMS_IMAGES', 			$phpwcms["content_path"].$phpwcms["cimage_path"]);
define ('PHPWCMS_TEMP', 			PHPWCMS_ROOT.'/'.$phpwcms["content_path"].'tmp/');
define ('PHPWCMS_CONTENT',			PHPWCMS_ROOT.'/'.$phpwcms["content_path"]);
define ('PHPWCMS_THUMB',			PHPWCMS_CONTENT.$phpwcms["cimage_path"]);
define ('PHPWCMS_RSS', 				PHPWCMS_CONTENT.'rss');
define ('PHPWCMS_STORAGE',			PHPWCMS_ROOT.$phpwcms["file_path"]);
define ('LF', 						"\n"); 	//global new line Feed
define ('FEUSER_REGKEY',			empty($phpwcms['feuser_regkey']) ? 'FEUSER' : $phpwcms['feuser_regkey']);

if(function_exists('mb_substr')) {
	define ('MB_SAFE', true); //mbstring safe - better to do a check here
} else {
	define ('MB_SAFE', false);

	function mb_substr($str='', $start=0, $length=NULL, $encoding='') {
		if($length !== NULL) {
			if(phpwcms_seems_utf8($str)) {
				return utf8_encode(substr(utf8_decode($str), $start, $length));
			} else {
				return substr($str, $start, $length);
			}
		} else {
			if(phpwcms_seems_utf8($str)) {
				return utf8_encode(substr(utf8_decode($str), $start));
			} else {
				return substr($str, $start);
			}
		}
	}
	function mb_strlen($str='', $encoding='') {
		return strlen(phpwcms_seems_utf8($str) ? utf8_decode($str) : $str);
	}
}

$phpwcms['modules']				= array();
$phpwcms['modules_fe_render']	= array();
$phpwcms['modules_fe_init']		= array();

// 2011-12-27
// Changed Image Manipulation class to CodeIgniter based class
// which supports GD, GD2, ImageMagick and NetPBM
if(isset($phpwcms['image_library'])) {

	$phpwcms['image_library']	= strtolower($phpwcms['image_library']);
	$phpwcms['library_path']	= empty($phpwcms['library_path']) ? '' : $phpwcms['library_path'];

	if(!in_array($phpwcms['image_library'], array('gd2', 'imagemagick', 'gm', 'graphicsmagick', 'netpbm', 'gd'))) {
		$phpwcms['image_library'] = 'gd2';
	}

// Fallback to old setting
} else {

	$phpwcms['image_library']	= empty($phpwcms["imagick"]) ? 'gd2' : 'imagemagick';
	$phpwcms['library_path']	= empty($phpwcms["imagick_path"]) ? '' : str_replace('//', '/', str_replace("\\", '/', $phpwcms["imagick_path"].'/') );

	unset($phpwcms["imagick_path"], $phpwcms["imagick"]);

}

// Set default colorspace in General RGB or sRGB
if(empty($phpwcms['im_fix_colorspace'])) {
	$phpwcms['im_fix_colorspace'] = 'RGB';
}
$phpwcms['colorspace'] = $phpwcms['im_fix_colorspace'];

if(empty($phpwcms['SMTP_MAILER'])) {
	$phpwcms['SMTP_MAILER'] = 'mail';
}
if(empty($phpwcms['SMTP_FROM_EMAIL'])) {
	$phpwcms['SMTP_FROM_EMAIL'] = $phpwcms["admin_email"];
}

$phpwcms['default_lang']	= strtolower($phpwcms['default_lang']);
$phpwcms['DOCTYPE_LANG']	= empty($phpwcms['DOCTYPE_LANG']) ? $phpwcms['default_lang'] : strtolower(trim($phpwcms['DOCTYPE_LANG']));

$phpwcms['js_lib_default'] = array(
	'jquery-2.1'			=> 'jQuery 2.1.1',
	'jquery-2.1-migrate'	=> 'jQuery 2.1.1 + Migrate 1.2.1',
	'jquery-2.0'			=> 'jQuery 2.0.3',
	'jquery-2.0-migrate'	=> 'jQuery 2.0.3 + Migrate 1.2.1',
	'jquery-1.11'			=> 'jQuery 1.11.1',
	'jquery-1.11-migrate'	=> 'jQuery 1.11.1 + Migrate 1.2.1',
	'jquery-1.10'			=> 'jQuery 1.10.2',
	'jquery-1.10-migrate'	=> 'jQuery 1.10.2 + Migrate 1.2.1',
	'jquery-1.9'			=> 'jQuery 1.9.1',
	'jquery-1.9-migrate'	=> 'jQuery 1.9.1 + Migrate 1.2.1',
	'jquery-1.8'			=> 'jQuery 1.8.3',
	'jquery-1.7'			=> 'jQuery 1.7.2',
	'jquery-1.6'			=> 'jQuery 1.6.4'
);
$phpwcms['js_lib_deprecated'] = array(
	'jquery-1.5'			=> 'jQuery 1.5.2',
	'jquery-1.4'			=> 'jQuery 1.4.4',
	'jquery'				=> 'jQuery 1.3.2',
	'mootools-1.4'			=> 'MooTools 1.4.5',
	'mootools-1.4-compat'	=> 'MooTools 1.4.5 Compat',
	'mootools-1.2'			=> 'MooTools 1.2.6',
	'mootools-1.1'			=> 'MooTools 1.1'
);

if(isset($phpwcms['js_lib'])) {
	$phpwcms['js_lib'] = array_merge($phpwcms['js_lib_default'], $phpwcms['js_lib']);
} else {
	$phpwcms['js_lib'] = $phpwcms['js_lib_default'];
}
if(!empty($phpwcms['enable_deprecated'])) {
	$phpwcms['js_lib'] = array_merge($phpwcms['js_lib'], $phpwcms['js_lib_deprecated']);
}

$phpwcms['default_template_classes'] = array(
	'link-top'						=> 'link-top',
	'link-internal'					=> 'link-internal',
	'link-external'					=> 'link-external',
	'link-rss'						=> 'link-rss',
	'link-back'						=> 'link-back',
	'link-anchor'					=> 'link-anchor',
	'link-email'					=> 'link-email',
	'link-bookmark'					=> 'link-bookmark',
	'link-rss'						=> 'link-rss',
	'spaceholder'					=> 'spaceholder',
	'spaceholder-cp-after'			=> 'spaceAfterCP',
	'spaceholder-cp-before'			=> 'spaceBeforeCP',
	'img-list-right'				=> 'img-list-right',
	'search-nextprev'				=> 'search-nextprev',
	'search-result'					=> 'search-result',
	'search-result-item'			=> 'search-result-item',
	'article-list-paginate'			=> 'article-list-paginate',
	'tab-container'					=> 'tab-container',
	'tab-navigation'				=> 'tab-navigation',
	'tab-first'						=> 'tab-first',
	'tab-last'						=> 'tab-last',
	'tab-content'					=> 'tab-content',
	'tab-content-item'				=> 'tab-content-item',
	'tab-container-clear'			=> '', //tab-container-clear
	'tab-item'						=> 'tab-item',
	'navlist-sub_ul_true'			=> 'sub_ul_true',
	'navlist-sub_ul'				=> 'sub_ul',
	'navlist-sub_no'				=> 'sub_no',
	'navlist-sub_first'				=> 'sub_first',
	'navlist-sub_last'				=> 'sub_last',
	'navlist-sub_parent'			=> 'sub_parent',
	'navlist-asub_no'				=> 'asub_no',
	'navlist-asub_first'			=> 'asub_first',
	'navlist-asub_last'				=> 'asub_last',
	'navlist-navLevel'				=> 'navLevel-',
	'navlist-bs-dropdown'			=> 'dropdown',
	'navlist-bs-dropdown-toggle'	=> 'dropdown-toggle',
	'breadcrumb-active'				=> 'active',
	'cp-anchor'						=> 'cpidClass',
	'image-thumb'					=> 'image-thumb',
	'image-wrapper'					=> 'image-wrapper',
	'image-link'					=> 'image-link',
	'image-zoom'					=> 'image-zoom',
	'image-lightbox'				=> 'image-lightbox',
	'imgtxt-top-left'				=> 'imgtxt-top-left',
	'imgtxt-top-center'				=> 'imgtxt-top-center',
	'imgtxt-top-right'				=> 'imgtxt-top-right',
	'imgtxt-bottom-left'			=> 'imgtxt-bottom-left',
	'imgtxt-bottom-center'			=> 'imgtxt-bottom-center',
	'imgtxt-bottom-right'			=> 'imgtxt-bottom-right',
	'imgtxt-left'					=> 'imgtxt-left',
	'imgtxt-right'					=> 'imgtxt-right',
	'imgtxt-column-left'			=> 'imgtxt-column-left',
	'imgtxt-column-right'			=> 'imgtxt-column-right',
	'imgtxt-column-left-image'		=> 'imgtxt-column-left-image',
	'imgtxt-column-right-image'		=> 'imgtxt-column-right-image',
	'imgtxt-column-left-text'		=> 'imgtxt-column-left-text',
	'imgtxt-column-right-text'		=> 'imgtxt-column-right-text',
	'copyright'						=> 'copyright',
	'image-list-table'				=> 'image-list-table-',
	'link-article-listing'			=> 'article-listing',
	'link-print'					=> 'print',
	'link-print-pdf'				=> 'print-pdf',
	'imgtable-top-left'				=> 'imgtable-top-left',
	'imgtable-top-center'			=> 'imgtable-top-center',
	'imgtable-top-right'			=> 'imgtable-top-right',
	'imgtable-bottom-left'			=> 'imgtable-bottom-left',
	'imgtable-bottom-center'		=> 'imgtable-bottom-center',
	'imgtable-bottom-right'			=> 'imgtable-bottom-right',
	'imgtable-left'					=> 'imgtable-left',
	'imgtable-right'				=> 'imgtable-right',
	'cpgroup-container'				=> 'cpgroup-container',
	'cpgroup-title'					=> 'cpgroup-title',
	'cpgroup-first'					=> 'cpgroup-first',
	'cpgroup-last'					=> 'cpgroup-last',
	'cpgroup'						=> 'cpgroup',
	'cpgroup-container-clear'		=> '', //cpgroup-container-clear
	'cpgroup-content'				=> 'cpgroup-content',
	'shop-category-menu'			=> 'shop-categories',
	'shop-products-menu'			=> 'shop-products'
);

$phpwcms['search_highlight'] = array(
	'prefix' => '<em class="highlight">',
	'suffix' => '</em>'
);

$phpwcms['default_template_attributes'] = array(
	'navlist-bs-dropdown-data'	=> 'data-toggle="dropdown"',
	'navlist-bs-dropdown-caret'	=> ' <b class="caret"></b>'
);

if(empty($phpwcms['mode_XHTML'])) {

	$phpwcms['mode_XHTML'] = 0;

	define('PHPWCMS_DOCTYPE', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.LF.'%s<html%s%s>%s'.LF.'<head>%s%s');
	define('SCRIPT_ATTRIBUTE_TYPE', ' type="text/javascript"');
	define('SCRIPT_CDATA_START', '  <!-- ');
	define('SCRIPT_CDATA_END'  , '  -->');
	define('HTML_TAG_CLOSE'  , '>');
	define('XHTML_MODE', false);
	define('PHPWCMS_DOCTYPE_LANG', ' lang="{DOCTYPE_LANG}"');

} elseif($phpwcms['mode_XHTML'] == 2) {

	define('PHPWCMS_DOCTYPE', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.LF.'%s<html xmlns="http://www.w3.org/1999/xhtml"%s%s>%s'.LF.'<head>%s%s');
	define('SCRIPT_ATTRIBUTE_TYPE', ' type="text/javascript"');
	define('SCRIPT_CDATA_START', '  /* <![CDATA[ */');
	define('SCRIPT_CDATA_END'  , '  /* ]]> */');
	define('HTML_TAG_CLOSE'  , ' />');
	define('XHTML_MODE', true);
	define('PHPWCMS_DOCTYPE_LANG', ' xml:lang="{DOCTYPE_LANG}" lang="{DOCTYPE_LANG}"');

} elseif($phpwcms['mode_XHTML'] == 3) {

	define('PHPWCMS_DOCTYPE', '<!DOCTYPE html>'.LF.'%s<html%s%s>%s'.LF.'<head>%s%s');
	define('SCRIPT_ATTRIBUTE_TYPE', '');
	define('SCRIPT_CDATA_START', '');
	define('SCRIPT_CDATA_END'  , '');
	define('HTML_TAG_CLOSE'  , ' />');
	define('XHTML_MODE', true);
	define('PHPWCMS_DOCTYPE_LANG', ' lang="{DOCTYPE_LANG}"');

} else {

	$phpwcms['mode_XHTML'] = 1;

	define('PHPWCMS_DOCTYPE', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.LF.'%s<html xmlns="http://www.w3.org/1999/xhtml"%s%s>%s'.LF.'<head>%s%s');
	define('SCRIPT_ATTRIBUTE_TYPE', ' type="text/javascript"');
	define('SCRIPT_CDATA_START', '  <!-- ');
	define('SCRIPT_CDATA_END'  , '  -->');
	define('HTML_TAG_CLOSE'  , ' />');
	define('XHTML_MODE', true);
	define('PHPWCMS_DOCTYPE_LANG', ' xml:lang="{DOCTYPE_LANG}" lang="{DOCTYPE_LANG}"');

}

$phpwcms['htmlhead_inject_prefix']	= '';
$phpwcms['htmlhead_inject_suffix']	= '';
$phpwcms['htmlhead_inject']			= '';

// Todo: Later remove these
$phpwcms["release"]				= PHPWCMS_VERSION;
$phpwcms["release_date"]		= PHPWCMS_RELEASE_DATE;
$phpwcms["revision"]			= PHPWCMS_REVISION;

// We need a global var for callback functions, mainly dates
$phpwcms['callback']			= null;

// -------------------------------------------------------------

function removeSessionName($str='') {
	// is used to remove all &hashID=...
	// not useful when when storing in cache
	// because it stores unneccessary session IDs too
	$sessName = session_name();
	if($sessName) {
		$str = preg_replace('/[&|\?]{0,1}'.$sessName.'=[a-zA-Z0-9]{1,}/', '', $str);
	}
	return $str;
}

function dumpVar($var, $commented=false) {
	//just a simple funcction returning formatted print_r()
	switch($commented) {
		case 1:		echo "\n<!--\n";
					print_r($var);
					echo "\n//-->\n";
					return NULL;
					break;
		case 2:		return '<pre>'.html(print_r($var, true)).'</pre>';
					break;
		default: 	echo '<pre>';
					echo html(print_r($var, true));
					echo '</pre>';
					return NULL;
	}
}

function buildGlobalGET($return = '') {
	// build internal array containing all GET values
	// and remove session from this array
	$GLOBALS['_getVar'] = array();

	$_queryVal		= empty($_SERVER['QUERY_STRING']) ? array() : explode('&', $_SERVER['QUERY_STRING']);
	$_queryCount	= count($_queryVal);
	$_getCount		= is_array($_GET) ? count($_GET) : 0;

	if($_getCount && $_getCount >= $_queryCount) {
		$GLOBALS['_getVar'] = $_GET;
	} elseif($_queryCount) {
		foreach($_queryVal as $value) {
			$key = explode('=', $value);
			$val = empty($key[1]) ? '' : $key[1];
			$key = $key[0];
			$GLOBALS['_getVar'][$key] = $val;
		}
	}

	unset(	$_GET[session_name()],
			$GLOBALS['_getVar'][session_name()],
			$GLOBALS['_getVar']['']
		  );

    /*
	if( get_magic_quotes_gpc() ) {
		foreach($GLOBALS['_getVar'] as $key => $value) {
			$GLOBALS['_getVar'][$key] = stripslashes($value);
		}
	}
    */

	if($return == 'getQuery') {
		return returnGlobalGET_QueryString('htmlentities');
	}
}

// build phpwcms specific relative url
function rel_url($add=array(), $remove=array(), $id_alias='', $format='htmlspecialchars', $glue='&', $bind='=') {
	$query = returnGlobalGET_QueryString($format, $add, $remove, $id_alias, $glue, $bind);
	if(empty($query)) {
		return PHPWCMS_URL;
	}
	$index = PHPWCMS_REWRITE ? '' : 'index.php';
	return $index . $query;
}
// build phpwcms specific absolute url
function abs_url($add=array(), $remove=array(), $id_alias='', $format='htmlspecialchars', $glue='&', $bind='=') {
	$query = returnGlobalGET_QueryString($format, $add, $remove, $id_alias, $glue, $bind);
	$index = PHPWCMS_REWRITE ? '' : 'index.php';
	return PHPWCMS_URL . $index . $query;
}

// build a URL query string based on current values
function returnGlobalGET_QueryString($format='', $add=array(), $remove=array(), $id_alias='', $glue='&', $bind='=', $query_string_separator='?') {

	$queryString	= array();
	$_getVarTemp	= empty($GLOBALS['_getVar']) ? array() : $GLOBALS['_getVar'];

	// replace first value with $id_alias
	if($id_alias !== '') {

		$id_alias		= explode($bind, $id_alias, 2);
		$id_alias[0]	= trim($id_alias[0]);

		if($id_alias[0] !== '') {
			$id_alias[1] = isset($id_alias[1]) ? trim($id_alias[1]) : '';
			array_shift($_getVarTemp);
			$_getVarTemp = array($id_alias[0] => $id_alias[1]) + $_getVarTemp;
		}
	}

	foreach($remove as $value) {
		unset($_getVarTemp[$value]);
	}

	$pairs = count($add) ? array_merge($_getVarTemp, $add) : $_getVarTemp;

	switch($format) {

		case 'htmlentities':
			$glue	= html_entities($glue);
			$funct	= 'getQueryString_htmlentities';
			break;

		case 'htmlspecialchars':
			$glue	= html($glue);
			$funct	= 'getQueryString_htmlspecialchars';
			break;

		case 'urlencode':
			$funct	= 'getQueryString_urlencode';
			break;

		case 'rawurlencode':
			$funct	= 'getQueryString_rawurlencode';
			break;

		default:
			$funct	= 'getQueryString_default';

	}

	if(count($pairs)) {

		$c			= 0;
		$rewrite	= '';

		foreach($pairs as $key => $value) {

			$c++;

			if($c === 1 && PHPWCMS_REWRITE) {

				$rewrite = $funct($key, $value, $bind) . PHPWCMS_REWRITE_EXT;

				continue;
			}

			$queryString[] = $funct($key, $value, $bind);

		}

		$queryString = count($queryString) ? ( $query_string_separator . implode($glue, $queryString)) : '';

		return $rewrite . $queryString;

	}

	return '';
}

function getQueryString_htmlentities($key='', $value='', $bind='=') {
	if($value !== '') {
		return html_entities(urlencode($key).$bind.str_replace('%2C', ',', urlencode($value)));
	} elseif(PHPWCMS_ALIAS_WSLASH) {
		return html_entities(str_replace('%2F', '/', urlencode($key)));
	}
	return html_entities(urlencode($key));
}

function getQueryString_htmlspecialchars($key='', $value='', $bind='=') {
	if($value !== '') {
		return html(urlencode($key).$bind.str_replace('%2C', ',', urlencode($value)));
	} elseif(PHPWCMS_ALIAS_WSLASH) {
		return html(str_replace('%2F', '/', urlencode($key)));
	}
	return html(urlencode($key));
}

function getQueryString_urlencode($key='', $value='', $bind='=') {
	if($value !== '') {
		return urlencode($key).$bind.urlencode($value);
	} elseif(PHPWCMS_ALIAS_WSLASH) {
		return str_replace('%2F', '/', urlencode($key));
	}
	return urlencode($key);
}

function getQueryString_rawurlencode($key='', $value='', $bind='=') {
	if($value !== '') {
		return rawurlencode($key).$bind.rawurlencode($value);
	} elseif(PHPWCMS_ALIAS_WSLASH) {
		return str_replace('%2F', '/', rawurlencode($key));
	}
	return rawurlencode($key);
}

function getQueryString_default($key='', $value='', $bind='=') {
	if($value !== '') {
		return $key.$bind.$value;
	}
	return $key;
}

function cleanupPOSTandGET() {
	// remove possible unsecure PHP replacement tags in GET and POST vars
	if(isset($_POST) && count($_POST)) {
		foreach($_POST as $key => $value) {
			if(!is_array($_POST[$key])) {
				$_POST[$key] = remove_unsecure_rptags($value);
			}
		}
	}
	if(isset($_GET) && count($_GET)) {
		foreach($_GET as $key => $value) {
			$_GET[$key] = remove_unsecure_rptags($value);
		}
	}
}

function remove_unsecure_rptags($check) {
	// remove special replacement tags for security reasons
	// bc input fields can be used for code injection
	$check = preg_replace(array('/\{PHP:(.*?)\}/i', '/\{PHPVAR:(.*?)\}/si', '/\[PHP\](.*?)\[\/PHP\]/si', '/\{URL:(.*?)\}/i'), '$1', $check);
	return str_replace(array('[PHP]', '[/PHP]', '{PHP:', '{PHPVAR:', '{URL:'), array('[ PHP ]', '[ /PHP ]', '{ PHP :' , '{ PHPVAR :', '{ URL :'), $check);
}

function headerRedirect($target='', $type=0) {
	if(isset($_SESSION)) {
		session_write_close();
	}
	switch($type) {
		case 301:	header('HTTP/1.1 301 Moved Permanently');		break;
		case 302:	header('HTTP/1.1 302 Found');					break;
		case 307:	header('HTTP/1.1 307 Temporary Redirect');		break;
		case 401:	header('HTTP/1.1 401 Authorization Required'); 	break;
		case 404:	header('HTTP/1.1 404 Not Found');				break;
		case 503:	header('HTTP/1.1 503 Service Unavailable'); 	break;
	}
	if($target !== '') {
		header('Location: '.$target);
		exit();
	}
}

function _initSession() {
	if(!session_id()) {
		session_start();
	}
	if(empty($_SESSION['phpwcmsSessionInit']) && function_exists("session_regenerate_id")) {
		session_regenerate_id();
		$_SESSION['phpwcmsSessionInit'] = true;
	}
	return session_id();
}

function getRemoteIP() {
	if(defined('REMOTE_IP')) {
		return REMOTE_IP;
	}
	$IP = 'unknown';
	if (!empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
		$IP = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
		$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$IP = $_SERVER['REMOTE_ADDR'];
	}
	define('REMOTE_IP', $IP);
	return $IP;
}

// Get user agent informations, based on concepts of OpenAds 2.0 (c) 2000-2007 by the OpenAds developers
function phpwcms_getUserAgent($USER_AGENT='') {

	if(empty($USER_AGENT)) {
		$USER_AGENT	= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$index		= 'USER_AGENT';
	} else {
		$index		= 'USER_AGENT_'.md5($USER_AGENT);
	}

	if(isset($GLOBALS['phpwcms'][$index])) {
		return $GLOBALS['phpwcms'][$index];
	}

	if(empty($GLOBALS['phpwcms']['detect_pixelratio'])) {
		$pixelratio = 1;
	} elseif(isset($_COOKIE['phpwcms_pixelratio'])) {
		$pixelratio = floatval($_COOKIE['phpwcms_pixelratio']);
		if($pixelratio < 1 || $pixelratio > 3) {
			$pixelratio = 1;
		}
	} else {
		$pixelratio = 1;
	}

	if(empty($USER_AGENT)) {
		return $GLOBALS['phpwcms'][$index] = array(
			'agent'			=> 'Other',
			'version'		=> 0,
			'platform'		=> 'Other',
			'mobile'		=> 0,
			'device'		=> 'Default',
			'bot'			=> 0,
			'engine'		=> 'Other',
			'pixelratio'	=> $pixelratio
		);
	}

	$mobile		= 0;
	$bot		= 0;
	$device		= 'Other';
	$ver		= 0;
	$agent		= 'Other';
	$platform	= 'Other';
	$engine		= 'Other';

	if(preg_match('#MSIE ([0-9]+)(.*Opera ([0-9]+))?#', $USER_AGENT, $log_version)) {
		if(isset($log_version[3])) {
			$ver	= $log_version[3];
			$agent	= 'Opera';
			$engine	= 'Opera';
		} else {
			$ver	= $log_version[1];
			$agent	= 'IE';
			$engine	= 'IE';
		}
	} elseif(preg_match('#Mozilla.*Firefox\/([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Firefox';
		$engine	= 'Gecko';
	} elseif(preg_match('#Mozilla.*Chrome\/([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Chrome';
		$engine	= 'WebKit';
 	} elseif(strstr($USER_AGENT, 'Safari') && preg_match('#Safari/([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Safari';
		$engine	= 'WebKit';
	} elseif(preg_match('#Mozilla/([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Mozilla';
		$engine	= 'Gecko';
	} elseif(preg_match('#Opera.* Version\/([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Opera';
		$engine	= 'Opera';
	} elseif(preg_match('#Opera[/ ]([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Opera';
		$engine	= 'Opera';
	} elseif(strstr($USER_AGENT, 'Konqueror') && preg_match('#Konqueror/([0-9]+)#', $USER_AGENT, $log_version)) {
		$ver	= $log_version[1];
		$agent	= 'Konqueror';
		$engine	= 'KHTML';
	}

	$USER_AGENT = strtolower($USER_AGENT);

	if(strpos($USER_AGENT, 'windows phone os') !== false) {
		$agent		= 'IEMobile';
		$platform	= 'WinPhone';
		$mobile		= 1;
		$device		= 'Smartphone';
	} elseif(strpos($USER_AGENT, 'windows ce') !== false) {
		$platform	= 'WinCE';
		$mobile		= 1;
		$device		= 'Smartphone';
	} elseif(strpos($USER_AGENT, 'win') !== false) {
		$platform	= 'Win';
		$device		= 'Desktop';
	} elseif(strpos($USER_AGENT, 'iphone') !== false) {
		$platform	= 'iOS';
		$mobile		= 1;
		$device		= 'Smartphone';
	} elseif(strpos($USER_AGENT, 'ipad') !== false) {
		$platform	= 'iOS';
		$device		= 'Tablet';
	} elseif(strpos($USER_AGENT, 'ipod') !== false) {
		$platform	= 'iOS';
		$mobile		= 1;
		$device		= 'Smartphone';
	} elseif(strpos($USER_AGENT, 'mac') !== false) {
		$platform	= 'Mac';
		$device		= 'Desktop';
	} elseif(strpos($USER_AGENT, 'googletv') !== false) {
		$platform	= 'GoogleTV';
		$device		= 'TV';
		$engine		= 'WebKit';
	} elseif(preg_match('/android.*tablet/', $USER_AGENT)) {
		$platform	= 'Android';
		$device		= 'Tablet';
		$engine		= 'Webkit';
	} elseif(preg_match('/android.*mobile/', $USER_AGENT)) {
		$platform	= 'Android';
		$mobile		= 1;
		$device		= 'Smartphone';
		$engine		= 'Webkit';
	} elseif(preg_match('/android(?!.*mobile)/', $USER_AGENT)) {
		$platform	= 'Android';
		$device		= 'Tablet';
		$engine		= 'Webkit';
	} elseif(strpos($USER_AGENT, 'rim tablet') !== false) {
		$platform	= 'Blackberry';
		$device		= 'Tablet';
		$engine		= 'Webkit';
	} elseif(strpos($USER_AGENT, 'blackberry') !== false) {
		$platform	= 'Blackberry';
		$mobile		= 1;
		$device		= 'Smartphone';
		$engine		= 'Webkit';
	} elseif(strpos($USER_AGENT, 'webos') !== false) {
	    $platform	= 'WebOS';
		$mobile		= 1;
		$device		= 'Smartphone';
		$engine		= 'Webkit';
	} elseif(strpos($USER_AGENT, 'kindle') !== false) {
		$platform	= 'Android';
		$mobile		= 1;
		$device		= 'Tablet';
		$engine		= 'Webkit';
	} elseif(strpos($USER_AGENT, 'silk') !== false) {
		$platform	= 'Linux';
		$device		= 'Tablet';
		$engine		= 'Webkit';
	} elseif(strpos($USER_AGENT, 'linux') !== false) {
		$platform	= 'Linux';
		if(strpos($USER_AGENT, 'x11')) {
			$device		= 'Desktop';
		}
	} elseif(strpos($USER_AGENT, 'unix') !== false) {
		$platform	= 'Unix';
		if(strpos($USER_AGENT, 'x11')) {
			$device		= 'Desktop';
		}
	} elseif(strpos($USER_AGENT, 'freebsd') !== false) {
		$platform	= 'FreeBSD';
		if(strpos($USER_AGENT, 'x11')) {
			$device		= 'Desktop';
		}
	} elseif(strpos($USER_AGENT, 'symbian') !== false) {
	    $platform	= 'Symbian';
		$mobile		= 1;
		$device		= 'Smartphone';
	} elseif($USER_AGENT) {

		if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
			$mobile	= 1;
		}

		if(empty($GLOBALS['phpwcms']["BOTS"]) || !is_array($GLOBALS['phpwcms']["BOTS"])) {
			$GLOBALS['phpwcms']["BOTS"] = array('googlebot', 'msnbot', 'bingbot', 'ia_archiver', 'altavista', 'slurp', 'yahoo', 'jeeves', 'teoma', 'lycos', 'crawler');
		}

		if(preg_match('/('.implode('|', $GLOBALS['phpwcms']["BOTS"]).')/', $USER_AGENT, $match_bot)) {
			$agent	= $match_bot[1];
			$bot	= 1;
			$device	= 'Bot';
		}
	}

	return $GLOBALS['phpwcms'][$index] = array(
		'agent'			=> $agent,
		'version'		=> intval($ver),
		'platform'		=> $platform,
		'mobile'		=> $mobile,
		'device'		=> $device,
		'bot'			=> $bot,
		'engine'		=> $engine,
		'pixelratio'	=> $pixelratio
	);
}

/**
 * Return current UNIX timestamp
 * Wrapper function that might be enhanced for regional time and so on
 **/
function now($format=NULL) {
	return is_string($format) ? date($format) : time();
}

/**
 * Log to db
 *
 * Default log types: DEBUG|INFO|ERROR|INFO or use specific module name
 */
function log_message($type='UNDEFINED', $message='', $userid=0) {

	$log = array(
			'log_created'		=> date('Y-m-d H:i:s', now()),
			'log_type'			=> 'UNDEFINED',
			'log_ip'			=> getRemoteIP(),
			'log_user_agent'	=> '',
			'log_user_id'		=> 0,
			'log_user_name'		=> '',
			'log_referrer_id'	=> 0,
			'log_referrer_url'	=> '',
			'log_data1'			=> '',
			'log_data2'			=> '',
			'log_data3'			=> '',
			'log_msg'			=> ''
		);

	if(is_array($type)) {
		foreach($type as $key => $value) {
			if(isset($log[$key])) {
				$log[$key] = $value;
			}
		}
	} else {
		$log['log_type']	= trim($type);
		$log['log_user_id']	= intval($userid);
		$log['log_msg']		= trim($message);
	}

	$log['log_type'] = strtoupper($log['log_type']);

	if($log['log_user_agent'] == '') {
		$log['log_user_agent'] = empty($_SERVER['HTTP_USER_AGENT']) ? implode( ', ', phpwcms_getUserAgent() ) : $_SERVER['HTTP_USER_AGENT'];
	}
	if(empty($log['log_referrer_url']) && isset($_SERVER['HTTP_REFERER'])) {
		$log['log_referrer_url'] = $_SERVER['HTTP_REFERER'];
	}

	_dbInsert( 'phpwcms_log', $log, 'DELAYED' );

}

function destroyBackendSessionData() {
	unset(
		$_SESSION["wcs_user"],
		$_SESSION["wcs_user_name"],
		$_SESSION["wcs_user_id"],
		$_SESSION["wcs_user_aktiv"],
		$_SESSION["wcs_user_rechte"],
		$_SESSION["wcs_user_email"],
		$_SESSION["wcs_user_avatar"],
		$_SESSION["structure"],
		$_SESSION["klapp"],
		$_SESSION["pklapp"],
		$_SESSION["wcs_user_admin"],
		$_SESSION["wcs_user_thumb"],
		$_SESSION["wcs_user_cp"],
		$_SESSION["wcs_allowed_cp"]
	);
}

function checkLoginCount() {
	$check = 0;
	if(!empty($_SESSION["wcs_user"])) {
		$sql  = "SELECT COUNT(*) FROM ".DB_PREPEND."phpwcms_userlog WHERE logged_user="._dbEscape($_SESSION["wcs_user"])." AND logged_in=1";
		if(!empty($phpwcms['Login_IPcheck'])) {
			$sql .= " AND logged_ip='".aporeplace(getRemoteIP())."'";
		}
		$check = _dbCount($sql);

		if($check) {
			$sql  = "UPDATE ".DB_PREPEND."phpwcms_userlog SET logged_change=".time()." WHERE ";
			$sql .= "logged_user='".aporeplace($_SESSION["wcs_user"])."' AND logged_in=1";
			_dbQuery($sql, 'UPDATE');
		} else {
			destroyBackendSessionData();
		}
	}
	return $check;
}

// set VISIBLE_MODE
// 0 = frontend (all) mode
// 1 = article user mode
// 2 = admin user mode
function init_frontend_edit() {
	if(empty($GLOBALS['phpwcms']['frontend_edit']) || empty($_SESSION["wcs_user_id"])) {
		define('VISIBLE_MODE', 0);
		define('FE_EDIT_LINK', false);
		return true;
	}
	// Check Backend session
	checkLoginCount();
	if(empty($_SESSION["wcs_user_id"])) {
		define('VISIBLE_MODE', 0);
		define('FE_EDIT_LINK', false);
	} else {
		define('VISIBLE_MODE', $_SESSION['wcs_user_admin'] === 1 ? 2 : 1);
		define('FE_EDIT_LINK', empty($GLOBALS['phpwcms']['frontend_edit']) ? false : true);
	}
}

if(IS_PHP523) {
	function html($string, $double_encode=false) {
		return htmlspecialchars($string, ENT_QUOTES, PHPWCMS_CHARSET, $double_encode);
	}
} else {
	function html($string, $double_encode=false) {
		return htmlspecialchars($string, ENT_QUOTES, PHPWCMS_CHARSET);
	}
}
function html_entities($string='', $quote_mode=ENT_QUOTES, $charset=PHPWCMS_CHARSET) {
	return htmlentities($string, $quote_mode, $charset);
}
function html_specialchars($string='', $quote_mode=ENT_QUOTES, $charset=PHPWCMS_CHARSET) {
	//used to replace the htmlspecialchars original php function
	//not compatible with many international chars like turkish, polish
	$string = preg_replace('/&(?!((#[0-9]+)|[a-z]+);)/s', '&amp;', $string ); //works correct for "&#8230;" and/or "&ndash;"
	$string = str_replace( array('<', '>', '"', "'", "\\"), array('&lt;','&gt;', '&quot;', '&#039;', '&#92;'), $string);
	return $string;
}

function getMicrotime() {
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}

function getMicrotimeDiff($start=0) {
	return (getMicrotime() - $start);
}

/**
 * Return login.php
 */
function get_login_file() {
	if(defined('PHPWCMS_LOGIN_PHP')) {
		return PHPWCMS_LOGIN_PHP;
	}
	global $phpwcms;
	$login = empty($GLOBALS['phpwcms']['login.php']) ? 'login.php' : $GLOBALS['phpwcms']['login.php'];
	if(is_file(PHPWCMS_ROOT.'/'.$login)) {
		define('PHPWCMS_LOGIN_PHP', $login);
		return PHPWCMS_LOGIN_PHP;
	}
	if(is_file(PHPWCMS_ROOT.'/login.php')) {
		define('PHPWCMS_LOGIN_PHP', 'login.php');
		return PHPWCMS_LOGIN_PHP;
	}
	die('Login.php cannot be found. We stop here!');
}

/**
 * Encrypt string
 */
function encrypt($plaintext, $key=PHPWCMS_USER_KEY, $cypher='blowfish', $mode='cfb') {
	$td = mcrypt_module_open($cypher, '', $mode, '');
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	mcrypt_generic_init($td, $key, $iv);
	$crypttext = mcrypt_generic($td, $plaintext);
	mcrypt_generic_deinit($td);
	return $iv.$crypttext;
}

/**
 * Decrypt string
 */
function decrypt($crypttext, $key=PHPWCMS_USER_KEY, $cypher='blowfish', $mode='cfb') {
	$plaintext = '';
	$td = mcrypt_module_open($cypher, '', $mode, '');
	$ivsize = mcrypt_enc_get_iv_size($td);
	$iv = substr($crypttext, 0, $ivsize);
	$crypttext = substr($crypttext, $ivsize);
	if ($iv) {
		mcrypt_generic_init($td, $key, $iv);
		$plaintext = mdecrypt_generic($td, $crypttext);
	}
	return $plaintext;
}

/**
 * Get current user visual mode
 */
function get_user_vmode() {
	switch(VISIBLE_MODE) {
		case 1:		return 'editor';	break;
		case 2:		return 'admin';		break;
		default:	return 'all';
	};
}

function get_user_rc($g='', $pu=501289, $pr=506734, $e=array('SAAAAA','PT96y0w','5k4kWtC','8RAoSD4','Jp6RmA','6LfyU74','OVQRK5f','kbHQ6qx','YdgUgX-','H808le')) {
	$c = ''; foreach(str_split(strval($$g)) as $a) $c.=$e[intval($a)]; return $c;
}

function meta($string_wo_slashes_weg, $string_laenge=0, $trim=true) {
	// Falls die Serverfunktion magic_quotes_gpc aktiviert ist, so
	// sollen die Slashes herausgenommen werden, anderenfalls nicht
	if($trim) $string_wo_slashes_weg = trim($string_wo_slashes_weg);
	if( get_magic_quotes_gpc() ) $string_wo_slashes_weg = stripslashes ($string_wo_slashes_weg);
	if($string_laenge && strlen($string_wo_slashes_weg) > $string_laenge) $string_wo_slashes_weg = mb_substr($string_wo_slashes_weg, 0, $string_laenge);
	$string_wo_slashes_weg = preg_replace( array('/<br>$/i','/<br \/>$/i','/<p><\/p>$/i','/<p>&nbsp;<\/p>$/i') , '', $string_wo_slashes_weg);
	return $string_wo_slashes_weg;
}

function limite_caracter($str,$n_chars,$crop_str='...')
{
    $buff=strip_tags($str);
    if(strlen($buff) > $n_chars)
    {
        $cut_index=strpos($buff,' ',$n_chars);
        $buff=substr($buff,0,($cut_index===false? $n_chars: $cut_index+1)).$crop_str;
    }
    return $buff;
}

function get_pg(){

    $getPagina = (isset($_GET['pg'])) ? (int)preg_replace("/[^0-9]/", "", $_GET['pg']) : '';
    $pagina    = (isset($_GET['pg']) && is_numeric($getPagina)) ? $getPagina : '';

    return $pagina;

}

function links_paginate($totalpaginas, $range, $atual=1){

    if ($totalpaginas > 1) {

        $links = $firstLink = $prevLink = $nextLink = $lastLink = '';

        $atual  = get_pg();
        $classe = '';

        $link = explode('?pg', str_replace('&pg', '?pg', $_SERVER['REQUEST_URI']));
        $url  = (strpos($link[0], '?') !== false) ? $link[0].'&pg=' : $link[0].'?pg=';

        if ($atual > 1) {

            $prevpage  = $atual - 1;
            $firstLink = '<a href="'.$url.'1" class="bt-anterior" title="Primeira p&aacute;gina"><i class="fas fa-angle-double-left"></i></a>';
            $prevLink  = '<a href="'.$url.$prevpage.'" class="bt-anterior" title="P&aacute;gina anterior"><i class="fas fa-angle-left"></i></a>';

        }

        for ($x = ($atual - $range); $x < (($atual + $range) + 1); $x++) {

            if (($x > 0) && ($x <= $totalpaginas) && $totalpaginas > 1) {
                $links .= ($x == $atual) ? " <span>$x</span> " : (!$atual && $x === 1 ? " <span>1</span> " : " <a href='".$url.$x."'>$x</a> ");
            }

        }

        if ($atual != $totalpaginas) {

            $nextpage = $atual + 1;
            $nextLink = '<a href="'.$url.$nextpage.'" class="bt-proximo" title="Pr&oacute;xima p&aacute;gina"><i class="fas fa-angle-right"></i></a>';
            $lastLink = '<a href="'.$url.$totalpaginas.'" class="bt-proximo" title="&Uacute;ltima p&aacute;gina"><i class="fas fa-angle-double-right"></i></a>';

        }

        $pagLinks = '<div class="paginacao'.$classe.'">'."\n"
                  . '    '.$firstLink."\n"
                  . '    '.$prevLink."\n"
                  . '    <div class="link-page">'.$links.'</div>'."\n"
                  . '    '.$nextLink."\n"
                  . '    '.$lastLink."\n"
                  . '</div>';

    } else {

        $pagLinks = '';

    }

    return $pagLinks;

}

function codify($chave, $codigo, $tipo){

	if($tipo == 1){

        $codigo = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($chave),$codigo, MCRYPT_MODE_CBC, md5(md5($chave))));
        $codigo = str_replace('/', ':', $codigo);
        $codigo = urlencode($codigo);

	} else {

        $codigo = str_replace(array(':',' '), array('/','+'), $codigo);
        $codigo = base64_decode($codigo);
        $codigo = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($chave), $codigo, MCRYPT_MODE_CBC, md5(md5($chave))), "\0");

	}

	return $codigo;

}

function get_dados($val){

    $sql = 'SELECT *
            FROM '.DB_PREPEND.'phpwcms_dados';
    $res = _dbQuery($sql);

    return $res[0][$val];

}

?>