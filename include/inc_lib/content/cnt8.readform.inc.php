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
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------



// Content Type Link Articles

$content['alink']['alink_template']		= clean_slweg($_POST["calink_template"]);
$content['alink']['alink_allowedtags']	= slweg($_POST["calink_allowedtags"]);
$content['alink']['alink_id']			= (isset($_POST["calink"]) && is_array($_POST["calink"])) ? $_POST["calink"] : array();
$content['alink']['alink_level']		= (isset($_POST["calink_level"]) && is_array($_POST["calink_level"])) ? $_POST["calink_level"] : array();

$content['all_link'] = array();
$content['all_link']['botao'] = clean_slweg($_POST['all_link_botao']);
$content['all_link']['tipo'] = clean_slweg($_POST['all_link_url_tipo']);
$content['all_link']['link'] = clean_slweg($_POST['all_link_url']);
$content['all_link']['pag'] = clean_slweg($_POST['all_link_url_pag']);

// article select type
$content['alink']['alink_type']			= intval($_POST['calink_type']);
if($content['alink']['alink_type'] > 21) $content['alink']['alink_type'] = 0;

// summary wordlimit
$content['alink']['alink_wordlimit']	= intval($_POST['calink_wordlimit']);
$content['alink']['alink_hidesummary']	= empty($_POST['calink_hidesummary']) ? 0 : 1;

// handle teaser for columns
$content['alink']['alink_columns']		= empty($_POST['calink_columns']) ? 0 : intval($_POST['calink_columns']);

// link against structure level link for single articles
$content['alink']['alink_categoryalias'] = empty($_POST['calink_categoryalias']) ? 0 : 1;

// max auto article
$content['alink']['alink_max']			= intval($_POST['calink_max']);

// image settings
$content['alink']['alink_width']		= intval($_POST['calink_width']);
$content['alink']['alink_height']		= intval($_POST['calink_height']);
$content['alink']['alink_zoom']			= empty($_POST['calink_zoom']) ? 0 : 1;
$content['alink']['alink_unique']		= empty($_POST['calink_unique']) ? 0 : 1;
$content['alink']['alink_crop']			= empty($_POST['calink_crop']) ? 0 : 1;
$content['alink']['alink_prio']			= empty($_POST['calink_prio']) ? 0 : 1;

// Paginate
$content['alink']['alink_paginate']		= empty($_POST['calink_paginate']) ? 0 : 1;

if($content['alink']['alink_paginate'] === 1){
    $content['alink']['alink_itens']		= empty($_POST['calink_paginate_itens']) ? 10 : intval($_POST['calink_paginate_itens']);
} else {
    $content['alink']['alink_itens']		= '';
}

// Adicionar classes
$content['alink']['addclassemulti']		= empty($_POST['calink_addclasse_multi']) ? 0 : 1;
$content['alink']['numeromulti']		= intval($_POST['calink_numero_multi']);
$content['alink']['classemulti']		= $_POST['calink_classe_multi'];

$content['alink']['addclasse']			= empty($_POST['calink_addclasse']) ? 0 : 1;
$content['alink']['numeroclasse']		= intval($_POST['calink_numero']);
$content['alink']['addclasse_classe']			= $_POST['calink_classe'];

if( empty($_POST['calink_andor']) ) {
	$content['alink']['alink_andor'] = 'OR';
} else {
	$content['alink']['alink_andor'] = in_array($_POST['calink_andor'], array('OR', 'AND', 'NOT') ) ? $_POST['calink_andor'] : 'OR';
}

$content['alink']['alink_category']		= convertStringToArray( clean_slweg($_POST['calink_category']) );

if(empty($content['alink']['alink_width'])) $content['alink']['alink_width'] = '';
if(empty($content['alink']['alink_height'])) $content['alink']['alink_height'] = '';
if(empty($content['alink']['alink_wordlimit'])) $content['alink']['alink_wordlimit'] = '';
if(empty($content['alink']['alink_max'])) $content['alink']['alink_max'] = '';


foreach($content['alink']['alink_id'] as $key => $value) {
	$value = intval($value);
	if($value) {
		$content['alink']['alink_id'][$key] = $value;
	} else {
		unset($content['alink']['alink_id'][$key]);
	}
}

?>