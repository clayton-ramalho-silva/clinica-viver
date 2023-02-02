<?php
/* ================================================================
03.03.2008 (KH) flip-flop
Output: <link rel="canonical" href="index.php?{CATEGORY_ALIAS}" />

Filename: rt_canonical_alias.php
Folder: /template/inc_script/frontend_render/
Switch: $phpwcms['allow_ext_render'] = 1; (/config/phpwcms/conf.inc.php)

Forum: http://forum.phpwcms.org/viewtopic.php?p=114327#p114327
================================================================ */
// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
die("You Cannot Access This Script Directly, Have a Nice Day."); }
// ----------------------------------------------------------------

// canonical url
if(!empty($GLOBALS['alias'])){
   $canurl = ($phpwcms["rewrite_url"])?$GLOBALS['alias'].'.'.PHPWCMS_REWRITE_EXT:'index.php?'.$GLOBALS['alias'];
}else{
   $canurl = ($phpwcms["rewrite_url"])?setGetArticleAid($content['articles'][$content["article_id"]]).'.'.PHPWCMS_REWRITE_EXT:'index.php?'.setGetArticleAid($content['articles'][$content["article_id"]]);
}

$amigavel = '<link rel="canonical" href="'.PHPWCMS_URL.setGetArticleAid($content['articles'][$content["article_id"]]).".html".'" />';
$url_site = PHPWCMS_URL;
$url_produtos = $GLOBALS['alias'];

if (setGetArticleAid($content['articles'][$content["article_id"]]) == 'pagina-inicial' ) {
	$block['custom_htmlhead']["canonical"] = "<link rel=\"canonical\" href=\"$url_site\" />";
	}else {
    $block['custom_htmlhead']["canonical"] = "$amigavel";
		}

if (setGetArticleAid($content['articles'][$content["article_id"]]) == '' ) {
	$block['custom_htmlhead']["canonical"] = "<link rel=\"canonical\" href=\"$url_site$url_produtos.html\" />";
	}

if ($_GET['listpage'] != null ){
	$block['custom_htmlhead']["canonical"] = "<link rel=\"canonical\" href=\"$url_site$url_produtos-pag-$listpage.html\" />";
	}


// -----------[ CLOSE ]----------------
?>