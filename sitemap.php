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

// build Google Sitemap based on available articles

$phpwcms = array();
require_once ('config/phpwcms/conf.inc.php');

// set neccessary charset
$phpwcms["charset"] = 'utf-8';
define('CUSTOM_CONTENT_TYPE', 'Content-Type: text/xml');

require_once ('include/inc_lib/default.inc.php');
define('VISIBLE_MODE', 0);
require_once (PHPWCMS_ROOT.'/include/inc_lib/dbcon.inc.php');
require_once (PHPWCMS_ROOT.'/config/phpwcms/conf.indexpage.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_lib/general.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_front/front.func.inc.php');

// start XML
echo '<?xml version="1.0" encoding="utf-8"?>' . LF;
echo '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" ';
echo 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
echo 'xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 ';
echo 'http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">' . LF . LF;
echo '	<!-- Google Sitemap, http://www.google.com/webmasters/sitemaps/ -->' . LF . LF;

//reads complete structure as array
$struct = get_struct_data();

// fallback value when no article available
$phpwcms['sitemap_set_base'] = true;
$phpwcms['sitemap_set_default'] = true;

if(is_file(PHPWCMS_ROOT.'/config/phpwcms/sitemap.custom.php')) {
	include(PHPWCMS_ROOT.'/config/phpwcms/sitemap.custom.php');
}

if(function_exists('phpwcms_getCustomSitemap')) {
	$_addURL = phpwcms_getCustomSitemap($struct);
} else {
	$_addURL = array();
}

if($phpwcms['sitemap_set_default']) {

	// now retrieve all articles
	$sql  =	"SELECT article_id, article_cid, DATE_FORMAT(article_tstamp, '%Y-%m-%d') AS article_tstamp, ";
	$sql .= "article_title, article_redirect, article_aliasid, article_alias ";
	$sql .= "FROM ".DB_PREPEND."phpwcms_article WHERE ";
	$sql .= "article_aktiv=1 AND article_deleted=0 AND article_nosearch!='1' AND ";
	$sql .= "article_nositemap=1 AND article_begin < NOW() AND article_end > NOW() ";
	$sql .= "ORDER BY article_tstamp DESC";

	if($result = mysql_query($sql, $db)) {

		while($data = mysql_fetch_assoc($result)) {

			// first proof if this article is within an "public" structure section
			if(isset($struct[$data['article_cid']])) {
				$_CAT = $struct[$data['article_cid']];
				if($_CAT['acat_regonly'] || $_CAT['acat_nosearch']=='1' || !$_CAT['acat_nositemap']) {
					// no it is no public article - so jump to next entry
					continue;
				}

				// now add article URL to Google sitemap
				if(empty($phpwcms['rewrite_url']) || empty($data['article_alias'])) {
					$_link = PHPWCMS_URL.'index.php?'.setGetArticleAid( $data );
				} else {
					$_link = PHPWCMS_URL.rawurlencode($data['article_alias']).PHPWCMS_REWRITE_EXT;
				}
				echo '	<url>'.LF;
				echo '		<loc>'.$_link.'</loc>'.LF;
				echo '		<lastmod>'.$data["article_tstamp"].'</lastmod>'.LF;
				echo '	</url>'.LF;

				// yes we have a minimum of 1 article link
				$phpwcms['sitemap_set_base'] = false;
			}

		}
	}
}

echo LF.'	<url><loc>'.PHPWCMS_URL.'</loc><lastmod>'.date('Y-m-d').'</lastmod></url> ';

if(is_file(PHPWCMS_ROOT.'/config/phpwcms/sitemap.custom.ini')) {
	$customSitemapLinks = parse_ini_file (PHPWCMS_ROOT.'/config/phpwcms/sitemap.custom.ini', true);
	if(is_array($customSitemapLinks) && count($customSitemapLinks)) {
		$_addURL += $customSitemapLinks;
		unset($customSitemapLinks);
	}
}

if(count($_addURL)) {
	foreach($_addURL as $value) {

		$_link = empty($value['url']) ? '' : trim($value['url']);
		if(empty($_link)) {
			continue;
		}
		$_lastmod = empty($value['date']) ? '' : trim($value['date']);
		if(empty($value['date'])) {
			$_lastmod = date('Y-m-d');
		}
		echo '	<url>'.LF;
    	echo '		<loc>'.$_link.'</loc>'.LF;
		echo '		<lastmod>'.$_lastmod.'</lastmod>'.LF;
		echo '	</url>'.LF;

	}
}

if($phpwcms['sitemap_set_base']) {
	// just return the main URL
	echo '	<url>'.LF;
    echo '		<loc>'.PHPWCMS_URL.'</loc>'.LF;
	echo '		<lastmod>'.date('Y-m-d').'</lastmod>'.LF;
	echo '	</url>'.LF;
}

echo '</urlset>';

?>