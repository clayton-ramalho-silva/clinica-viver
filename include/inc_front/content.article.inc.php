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


$sql  =	"SELECT *, UNIX_TIMESTAMP(article_tstamp) AS article_date, ";
$sql .= "UNIX_TIMESTAMP(article_begin) AS article_livedate, ";
$sql .= "UNIX_TIMESTAMP(article_end) AS article_killdate ";
$sql .=	"FROM ".DB_PREPEND."phpwcms_article ar LEFT JOIN ".DB_PREPEND."phpwcms_articlecat ac ON ";
$sql .=	"ar.article_cid = ac.acat_id WHERE ";
$sql .= "ar.article_id=".intval($aktion[1])." AND ";
// VISIBLE_MODE: 0 = frontend (all) mode, 1 = article user mode, 2 = admin user mode
switch(VISIBLE_MODE) {
	case 0: $sql .= "ar.article_aktiv=1 AND ";
			break;
	case 1: $sql .= "(ar.article_aktiv=1 OR ar.article_uid=".intval($_SESSION["wcs_user_id"]).") AND ";
			break;
}
$sql .= "ar.article_deleted=0 AND ar.article_begin<NOW() ";
$sql .= "AND IF(ac.acat_archive=1 AND ar.article_archive_status=1, 1, ar.article_end>NOW()) LIMIT 1";

if($result = mysqli_query($db, $sql) or die("error while reading article datas")) {
	if($row = mysqli_fetch_assoc($result)) {
		//Da max. 1 Datensatz -> sofort Datenbankverbindung kappen
		mysqli_free_result($result);

		// now try to retrieve alias article information
		if($row["article_aliasid"]) {
			$alias_sql  = "SELECT *, UNIX_TIMESTAMP(article_tstamp) AS article_date, ";
			$alias_sql .= "UNIX_TIMESTAMP(article_begin) AS article_livedate, ";
			$alias_sql .= "UNIX_TIMESTAMP(article_end) AS article_killdate ";
			$alias_sql .= "FROM ".DB_PREPEND."phpwcms_article ";
			$alias_sql .= "WHERE article_deleted=0 AND article_id=".intval($row["article_aliasid"]);
			if(!$row["article_headerdata"]) {
				switch(VISIBLE_MODE) {
					case 0: $alias_sql .= " AND article_aktiv=1";
								break;
					case 1: $alias_sql .= " AND (article_aktiv=1 OR article_uid=".$_SESSION["wcs_user_id"].')';
								break;
				}
				$alias_sql .= " AND article_begin < NOW() AND article_end > NOW()";
			}
			$alias_sql .= " AND article_deleted=0 LIMIT 1";
			if($alias_result = mysqli_query($db, $alias_sql)) {
				if($alias_row = mysqli_fetch_assoc($alias_result)) {
					$row["article_id"] = $alias_row["article_id"];
					// use alias article header data
					if(!$row["article_headerdata"]) {
						$row["article_title"]		= $alias_row["article_title"];
						$row["article_subtitle"]	= $alias_row["article_subtitle"];
						$row["article_keyword"]		= $alias_row["article_keyword"];
						$row["article_summary"]		= $alias_row["article_summary"];
						$row["article_redirect"]	= $alias_row["article_redirect"];
						$row["article_date"]		= $alias_row["article_date"];
						$row["article_image"]		= $alias_row["article_image"];
						$row["article_pagetitle"]	= $alias_row["article_pagetitle"];
						$row['article_description']	= $alias_row['article_description'];
						$row['article_menutitle']	= $alias_row['article_menutitle'];
					}
				}
				mysqli_free_result($alias_result);
			}
		}

		//Kategoriebezeichner
		$article['cat'] = $content['struct'][$row["article_cid"]]['acat_name'];

		//redirection definition
		if($row["article_redirect"]) {

			$row["article_redirect"]		= str_replace('{SITE}', PHPWCMS_URL, $row["article_redirect"]);
			$content["redirect"]			= explode(' ', $row["article_redirect"]);
			$content["redirect"]["link"]	= $content["redirect"][0];
			$content["redirect"]["target"]	= isset($content["redirect"][1]) ? $content["redirect"][1] : '';
			$content["redirect"]["timeout"]	= isset($content["redirect"][2]) ? intval($content["redirect"][2]) : 0;

			//check how to redirect - new window or self window
			if(	!$content["redirect"]["target"]	|| $content["redirect"]["target"] == "_self" ||	$content["redirect"]["target"] == "_top" ||	$content["redirect"]["target"] == "_parent") {
				// direct redirection in the same window
				headerRedirect($content["redirect"]["link"], 301);
			} else {
				// redirection by using a special <meta><javascript> html head part
				$content["redirect"]["code"]  = LF . '  <noscript>' . LF;
				$content["redirect"]["code"] .= '	<meta http-equiv="refresh" content="'.$content["redirect"]["timeout"].';URL=';
				$content["redirect"]["code"] .= $content["redirect"]["link"];
				$content["redirect"]["code"] .= '" />'.LF.'  </noscript>' . LF;
				$content["redirect"]["code"] .= '  <script'.SCRIPT_ATTRIBUTE_TYPE.'>' . LF;
				$content["redirect"]["code"] .= '	var redirectWin;' . LF;
				if($content["redirect"]["timeout"]) {
					$content["redirect"]["code"] .= '	window.setTimeout(\'window.open("'.$content["redirect"]["link"].'", redirectWin)\', ';
					$content["redirect"]["code"] .= $content["redirect"]["timeout"] * 1000;
					$content["redirect"]["code"] .= ');';
				} else {
					$content["redirect"]["code"] .= '	window.open("'.$content["redirect"]["link"].'", redirectWin);';
				}
				$content["redirect"]["code"] .= LF . '  </script>' . LF;
			}
		}


		// UNIQUE article ID as used for teaser content part
		if(!isset($content['UNIQUE_ALINK'])) {
			$content['UNIQUE_ALINK'] = array();
		}

		$content['UNIQUE_ALINK'][ $row["article_id"] ] = $row["article_id"];

		//set cache timeout for this article
		if($row['article_cache'] != '') {
			$phpwcms['cache_timeout'] = $row['article_cache'];
		}
		//get value for article search (on/off)
		if($row['article_nosearch'] != '') {
			$cache_searchable = '1';
		}

		$content['opengraph']['support'] = phpwcms_boolval($row["article_opengraph"]);
		$content['opengraph']['type'] = 'article'; // Open Graph type

		//check if article has custom pagetitle
		if(empty($row["article_pagetitle"])) {
			$content["pagetitle"] = setPageTitle($row["article_pagetitle"], $article['cat'], $row["article_title"]);
			$content['opengraph']['title'] = $content["pagetitle"];
		} else {
			$content["pagetitle"] = $row["article_pagetitle"];
			$content['opengraph']['title'] = $content["pagetitle"];
		}

		// check description
		if(!empty($row['article_description'])) {
			set_meta('description', $row['article_description']);
			$content['opengraph']['description'] = $row["article_description"];
		}

		$content['all_keywords'] = $row['article_keyword'];

		if(!empty($template_default['article_render_anchor'])) {
			$content["main"] .= '<a id="jump'.$row["article_id"].'" class="jump-anchor"></a>';
		}

		// enable frontend edit link
		if(FE_EDIT_LINK && ($_SESSION["wcs_user_admin"] || $_SESSION["wcs_user_id"] == $row["article_uid"])) {

			// enym add structure level frontend edit link for admins only
			if($_SESSION["wcs_user_admin"]) {
				$content["main"] .= getFrontendEditLink('structure', $content['cat_id']);
			}
			$content["main"] .= getFrontendEditLink('article', $row["article_id"]);
			$content["main"] .= getFrontendEditLink('summary', $row["article_id"]);
			$content['article_frontend_edit'] = true;

		} else {

			$content['article_frontend_edit'] = false;

		}

		// only copy the catname to a special var for multiple for use in any block
		$content["cat"]					= html_specialchars($article["cat"]);
		$content["cat_id"]				= $aktion[0] = $row["article_cid"]; //set category ID to actual category value
		$content["article_id"] 			= $row["article_id"];
		$content["summary"]				= '';
		$content['article_title']		= $row["article_title"];
		$content['article_summary']		= $row["article_summary"];
		$content['article_menutitle']	= empty($row['article_menutitle']) ? $row['article_title'] : $row['article_menutitle'];
		$content["article_date"]		= $row["article_date"]; // article date
		$content["article_created"]		= $row["article_created"]; // article created
		$content['article_livedate']	= $row['article_livedate'];
		$content['article_killdate']	= $row['article_killdate'];
		$content['article_username']	= $row["article_username"];

		//retrieve image info
		$row["article_image"] = unserialize($row["article_image"]);
		$caption = getImageCaption($row["article_image"]["caption"]);
		$row["article_image"]["caption"]	= $caption[0];
		$row["article_image"]["copyright"]	= $caption[4];

		//build image/image link
		$thumb_image = false;
		$thumb_img = '';
		$popup_img = '';

		$img_thumb_name		= '';
		$img_thumb_rel		= '';
		$img_thumb_abs		= '';
		$img_thumb_width	= 0;
		$img_thumb_height	= 0;

		$img_zoom_name		= '';
		$img_zoom_rel		= '';
		$img_zoom_abs		= '';
		$img_zoom_width		= 0;
		$img_zoom_height	= 0;
		$img_thumb_ext		= 'jpg';

		if(!empty($row["article_image"]["hash"])) {

			$thumb_image = get_cached_image(array(
				"target_ext"	=>	$row["article_image"]['ext'],
				"image_name"	=>	$row["article_image"]['hash'] . '.' . $row["article_image"]['ext'],
				"max_width"		=>	$row["article_image"]['width'],
				"max_height"	=>	$row["article_image"]['height'],
				"thumb_name"	=>	md5($row["article_image"]['hash'].$row["article_image"]['width'].$row["article_image"]['height'].$phpwcms["sharpen_level"].$phpwcms['colorspace'])
			));

			if($thumb_image != false) {

				$thumb_img  = '<img src="'.PHPWCMS_IMAGES . $thumb_image[0] .'" '.$thumb_image[3];
				$thumb_img .= ' alt="'.html_specialchars($caption[1]).'" title="'.html_specialchars($caption[3]).'"';
				$thumb_img .= ' class="'.$template_default['classes']['image-thumb'].'" />';

				$img_thumb_name		= $thumb_image[0];
				$img_thumb_rel		= PHPWCMS_IMAGES.$thumb_image[0];
				$img_thumb_abs		= PHPWCMS_URL.PHPWCMS_IMAGES.$thumb_image[0];
				$img_thumb_width	= $thumb_image[1];
				$img_thumb_height	= $thumb_image[2];
				$img_thumb_ext		= which_ext($thumb_image[0]);

				$content['images']['article'] = array(
					'name'	=> $row["article_image"]["name"],
					'hash'	=> $row["article_image"]["hash"],
					'ext'	=> $img_thumb_ext,
					'image' => array(
						'width'		=> $img_thumb_width,
						'height'	=> $img_thumb_height,
						'src'		=> $img_thumb_rel
					)
				);

				if($row["article_image"]["zoom"]) {

					$zoominfo = get_cached_image(array(
						"target_ext"	=>	$row["article_image"]['ext'],
						"image_name"	=>	$row["article_image"]['hash'] . '.' . $row["article_image"]['ext'],
						"max_width"		=>	$phpwcms["img_prev_width"],
						"max_height"	=>	$phpwcms["img_prev_height"],
						"thumb_name"	=>	md5($row["article_image"]['hash'].$phpwcms["img_prev_width"].$phpwcms["img_prev_height"].$phpwcms["sharpen_level"].$phpwcms['colorspace'])
					));

					if($zoominfo != false) {

						$img_zoom_name		= $zoominfo[0];
						$img_zoom_rel		= PHPWCMS_IMAGES.$zoominfo[0];
						$img_zoom_abs		= PHPWCMS_URL.PHPWCMS_IMAGES.$zoominfo[0];
						$img_zoom_width		= $zoominfo[1];
						$img_zoom_height	= $zoominfo[2];

						$content['images']['article']['zoom'] = array(
							'width'		=> $img_zoom_width,
							'height'	=> $img_zoom_height,
							'src'		=> $img_zoom_rel
						);

						$popup_img = 'image_zoom.php?'.getClickZoomImageParameter($zoominfo[0].'?'.$zoominfo[3]);

						if(!empty($caption[2][0])) {
							$open_link = $caption[2][0];
							$return_false = '';
						} else {
							$open_link = $popup_img;
							$return_false = 'return false;';
						}

						if(empty($row["article_image"]["lightbox"])) {
							$thumb_href  = '<a href="'.$popup_img.'" onclick="window.open(\''.$open_link;
							$thumb_href .= "','previewpic','width=".$zoominfo[1].",height=".$zoominfo[2]."');".$return_false;
							$thumb_href .= '"';
							if(!empty($caption[2][1])) {
								$thumb_href .= $caption[2][1];
							}
							$thumb_href .= ' class="'.$template_default['classes']['image-zoom'].'">';
						} else {

							//lightbox
							initSlimbox();

							$thumb_href  = '<a href="'.PHPWCMS_IMAGES . $zoominfo[0].'"';
							if($row["article_image"]["caption"]) {
								$thumb_href .= ' title="'.parseLightboxCaption($row["article_image"]["caption"]).'"';
							}
							$thumb_href .= ' rel="lightbox" class="'.$template_default['classes']['image-lightbox'].'">';
						}

						$thumb_img = $thumb_href.$thumb_img.'</a>';
						$popup_img = $thumb_img;

					}

				} elseif($caption[2][0]) {

					$thumb_img = '<a href="'.$caption[2][0].'"'.$caption[2][1].' class="'.$template_default['classes']['image-link'].'">'.$thumb_img.'</a>';

				}
			}

		} else {

			$row["article_image"]['id']		= 0;
			$row["article_image"]['hash']	= '';

		}

		// make some elementary checks regarding content part pagination
		$_CpPaginate = false;

		if($row['article_paginate'] && $aktion[2] != 1) { // no pagination in print mode

			// use an IF because acontent_paginate_page=1 is the same as acontent_paginate_page=0
			$sql_cnt  = "SELECT DISTINCT IF(acontent_paginate_page=1, 0, acontent_paginate_page) AS acontent_paginate_page, ";
			$sql_cnt .= "acontent_paginate_title ";
			$sql_cnt .= "FROM ".DB_PREPEND."phpwcms_articlecontent WHERE ";
			$sql_cnt .= "acontent_aid=".$row["article_id"]." AND acontent_visible=1 AND acontent_trash=0 ";

			if( !FEUSER_LOGIN_STATUS ) {
				$sql_cnt .= 'AND acontent_granted=0 ';
			}

			$sql_cnt .= "AND acontent_block IN ('', 'CONTENT') ORDER BY acontent_paginate_page DESC";
			$sql_cnt  = _dbQuery($sql_cnt);

			if(($paginate_count = count($sql_cnt)) > 1) {

				$content['CpPages']			= array();
				$content['CpPageTitles']	= array();
				$_CpPaginate				= true;

				foreach($sql_cnt as $crow) {

					$content['CpPages'][ $crow['acontent_paginate_page'] ] = $paginate_count; // set page numbers

					// set content part pagination title
					if(!isset($content['CpPageTitles'][ $crow['acontent_paginate_page'] ])) {

						$content['CpPageTitles'][ $crow['acontent_paginate_page'] ] = $crow['acontent_paginate_title'] == '' ? '#'.$paginate_count : $crow['acontent_paginate_title'];

					// check if content part title is set but starts with '#'
					} elseif(isset($content['CpPageTitles'][ $crow['acontent_paginate_page'] ]) && $crow['acontent_paginate_title'] != '' && $content['CpPageTitles'][ $crow['acontent_paginate_page'] ]{0} == '#') {

						$content['CpPageTitles'][ $crow['acontent_paginate_page'] ] = $crow['acontent_paginate_title'];

					}

					$paginate_count--;
				}

				$content['CpPages']			= array_reverse($content['CpPages'], true);
				$content['CpPageTitles']	= array_reverse($content['CpPageTitles'], true);

				// check if given cp paginate page is valid, and reset to page 1 (=0)
				// same happens for 1 because this will always be used like it is 0
				if(!isset($content['CpPages'][ $content['aId_CpPage'] ])) {
					$content['aId_CpPage'] = 0;
				}

			} else {

				$content['aId_CpPage'] = 0;

			}

		}

		// check for custom full article summary template
		if(!empty($row["article_image"]['tmplfull']) && $row["article_image"]['tmplfull']!='default' && is_file(PHPWCMS_TEMPLATE.'inc_cntpart/articlesummary/article/'.$row["article_image"]['tmplfull'])) {

			// try to read the template files

			if($_CpPaginate && $content['aId_CpPage'] > 1 && is_file(PHPWCMS_TEMPLATE.'inc_cntpart/articlesummary/article/paginate/'.$row["article_image"]['tmplfull'])) { // check for default cp paginate template
				$row["article_image"]['tmplfull'] = file_get_contents(PHPWCMS_TEMPLATE.'inc_cntpart/articlesummary/article/paginate/'.$row["article_image"]['tmplfull']);
			} else {
				$row["article_image"]['tmplfull'] = file_get_contents(PHPWCMS_TEMPLATE.'inc_cntpart/articlesummary/article/'.$row["article_image"]['tmplfull']);
			}

		} elseif(is_file(PHPWCMS_TEMPLATE.'inc_default/article_summary.tmpl')) {

			// load default template

			if($_CpPaginate && $content['aId_CpPage'] > 1 && is_file(PHPWCMS_TEMPLATE.'inc_default/article_summary_paginate.tmpl')) { // check for default cp paginate template
				$row["article_image"]['tmplfull'] = file_get_contents(PHPWCMS_TEMPLATE.'inc_default/article_summary_paginate.tmpl');
			} else {
				$row["article_image"]['tmplfull'] = file_get_contents(PHPWCMS_TEMPLATE.'inc_default/article_summary.tmpl');
			}

		} else {

			// template fallback
			if($_CpPaginate && $content['aId_CpPage'] > 1) {
				$row["article_image"]['tmplfull']  = '[TITLE]<div class="titulo"><h1><span>{TITLE}</span></h1></div>[/TITLE]'.LF.'<!--CP_PAGINATE_START//-->'.LF;
				$row["article_image"]['tmplfull'] .= '<div class="cpPagination">'.LF;
				$row["article_image"]['tmplfull'] .= '	[CP_PAGINATE_PREV]<a href="{CP_PAGINATE_PREV}" class="cpPaginationPrev">Previous</a>[/CP_PAGINATE_PREV]'.LF;
				$row["article_image"]['tmplfull'] .= '	[CP_PAGINATE]{CP_PAGINATE}[/CP_PAGINATE]'.LF;
				$row["article_image"]['tmplfull'] .= '	[CP_PAGINATE_NEXT]<a href="{CP_PAGINATE_NEXT}" class="cpPaginationNext">Previous</a>[/CP_PAGINATE_NEXT]'.LF;
				$row["article_image"]['tmplfull'] .= '</div><!--CP_PAGINATE_END//-->';
			} else {
				$row["article_image"]['tmplfull']  = '[TITLE]<div class="titulo"><h1><span>{TITLE}</span></h1></div>'.LF.'[/TITLE][SUB]<h3>{SUB}</h3>'.LF.'[/SUB]';
				$row["article_image"]['tmplfull'] .= '[SUMMARY][IMAGE]<span style="float:left;margin:2px 10px 5px 0;">{IMAGE}';
				$row["article_image"]['tmplfull'] .= '[CAPTION]<br />'.LF.'{CAPTION}[/CAPTION]</span>'.LF.'[/IMAGE]{SUMMARY}</div>'.LF.'[/SUMMARY]';
			}

		}

		//rendering

		// ---------------------------- Modifica??o ----------------------------
		// Gera um t?tulo H1 nas p?ginas com paginate
		if($row['acat_paginate'] == '1'){
			$content['main'] .= '<div class="titulo"><h1><span>'.$content['struct'][ $content['cat_id'] ]['acat_name'].'</span></h1></div>';
		}
		// -----------------------------------------------------------------------------

		if($row["article_image"]['tmplfull']) {

			// replace thumbnail and zoom image information
			$row["article_image"]['tmplfull'] = str_replace(
				array(
					'{THUMB_NAME}',
					'{THUMB_REL}',
					'{THUMB_ABS}',
					'{THUMB_WIDTH}',
					'{THUMB_HEIGHT}',
					'{IMAGE_NAME}',
					'{IMAGE_REL}',
					'{IMAGE_ABS}',
					'{IMAGE_WIDTH}',
					'{IMAGE_HEIGHT}',
					'{IMAGE_ID}',
					'{IMAGE_HASH}',
					'{IMAGE_EXT}'
				),
				array(
					$img_thumb_name,
					$img_thumb_rel,
					$img_thumb_abs,
					$img_thumb_width,
					$img_thumb_height,
					$img_zoom_name,
					$img_zoom_rel,
					$img_zoom_abs,
					$img_zoom_width,
					$img_zoom_height,
					$row["article_image"]['id'],
					$row["article_image"]['hash'],
					$img_thumb_ext
				),
				$row["article_image"]['tmplfull']
			);

			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'TITLE', $row["article_notitle"] ? '' : html_specialchars($row["article_title"]));
			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'SUB', html_specialchars($row["article_subtitle"]));
			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'EDITOR', html_specialchars($row["article_username"]));
			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'SUMMARY', $row["article_hidesummary"] ? '' : $row["article_summary"]);

			// Render SYSTEM
			if(strpos($row["article_image"]['tmplfull'], '[SYSTEM]') !== false) {
				// Search for all system related content parts
				$sql_cnt  = 'SELECT * FROM ' . DB_PREPEND . 'phpwcms_articlecontent WHERE acontent_aid=' . $content["article_id"] . ' ';
				$sql_cnt .= "AND acontent_visible=1 AND acontent_trash=0 AND acontent_block='SYSTEM' AND acontent_tid IN (2, 3) "; // 2 = article detail, 3 = article detail OR list
				if(!FEUSER_LOGIN_STATUS) {
					$sql_cnt .= 'AND acontent_granted=0 ';
				}
				$sql_cnt .= "ORDER BY acontent_sorting, acontent_id";
				$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'SYSTEM', showSelectedContent('CPC', $sql_cnt));
			} else {
				$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'SYSTEM', '');
			}

			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'IMAGE', $thumb_img);
			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'CAPTION', nl2br(html_specialchars($row["article_image"]["caption"])));
			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'COPYRIGHT', html_specialchars($row["article_image"]["copyright"]));
			$row["article_image"]['tmplfull'] = render_cnt_date($row["article_image"]['tmplfull'], $content["article_date"], $row['article_livedate'], $row['article_killdate']);
			$row["article_image"]['tmplfull'] = render_cnt_template($row["article_image"]['tmplfull'], 'ZOOMIMAGE', $popup_img);

			$content["summary"] .= $row["article_image"]['tmplfull'];
			$row["article_image"]['tmplfull'] = 1;

		} else {

			$row["article_image"]['tmplfull'] = 0;

		}

		if($content["summary"]) {

			$content["main"] .= $content["summary"];
			$content["main"] .= $template_default["article"]["head_after"];

		}

		// render content parts
		$sql_cnt  = "SELECT * FROM ".DB_PREPEND."phpwcms_articlecontent WHERE acontent_aid=".$row["article_id"]." ";
		$sql_cnt .=	"AND acontent_visible=1 AND acontent_trash=0 ";
		if( !FEUSER_LOGIN_STATUS ) {
			$sql_cnt .= 'AND acontent_granted=0 ';
		}
		$sql_cnt .= "ORDER BY acontent_sorting, acontent_id";
		$cresult  = _dbQuery($sql_cnt);

		$content['cptab_types'] = array(
			1 => array('id' => 'tabbox', 'item' => 'tab', 'title' => 'TabTitle'),
			2 => array('id' => 'cpgroup', 'item' => 'cpgroup', 'title' => 'ContentPartGroupTitle')
		);

		foreach($cresult as $crow) {

			// check for article content part pagination
			if($_CpPaginate && ($crow['acontent_block'] == 'CONTENT' || $crow['acontent_block'] == '')) {

				// now check which content part should be rendered...

				// first - cp page 0 OR 1 = 1st page and the same
				if(($content['aId_CpPage'] == 0 || $content['aId_CpPage'] == 1) && ($crow['acontent_paginate_page'] == 0 || $crow['acontent_paginate_page'] == 1)) {

					// then compare if selected page is same as paginate page
				} elseif($content['aId_CpPage'] == $crow['acontent_paginate_page']) {

					// hm, do not render current content part
				} else {

					continue;
				}

			}

			// if type of content part not enabled available
			if(!isset($wcs_content_type[ $crow["acontent_type"] ]) ||  ($crow["acontent_type"] == 30 && !isset($phpwcms['modules'][$crow["acontent_module"]]))) {
				continue;
			}

			// do everything neccessary for alias content part
			if($crow["acontent_type"] == 24) {
				$crow = getContentPartAlias($crow);
			}

			// every article content  will be rendered into temp var
			$CNT_TMP  = '';

			// each content part will get an anchor
			if($crow["acontent_anchor"]) {
				$CNT_TMP .= '<a name="cpid'.$crow["acontent_id"].'" id="cpid'.$crow["acontent_id"].'" class="'.$template_default['classes']['cp-anchor'].'"></a>';
			}

			// Space before
			if($crow["acontent_before"]) {
				if(!empty($template_default["article"]["div_spacer"])) {
					$CNT_TMP .= '<div style="margin-top:'.$crow["acontent_before"].'px;" class="'.$template_default['classes']['spaceholder-cp-before'].'"></div>';
				} else {
					$CNT_TMP .= '<br class="'.$template_default['classes']['spaceholder-cp-before'].'" />'.spacer(1,$crow["acontent_before"]);
				}
			}

			// set frontend edit link
			if($content['article_frontend_edit']) {
				$CNT_TMP .= getFrontendEditLink('CP', $crow['acontent_aid'], $crow['acontent_id']);
			}

			// include content part code section
			if($crow["acontent_type"] != 30) {

				include(PHPWCMS_ROOT."/include/inc_front/content/cnt".$crow["acontent_type"].".article.inc.php");

			} elseif($crow["acontent_type"] == 30 && is_file($phpwcms['modules'][$crow["acontent_module"]]['path'].'inc/cnt.article.php')) {

				if($content['article_frontend_edit']) {
					$CNT_TMP .= getFrontendEditLink('module', $phpwcms['modules'][$crow["acontent_module"]]['name'], $crow['acontent_aid']);
				}
				// now try to include module content part code
				include($phpwcms['modules'][$crow["acontent_module"]]['path'].'inc/cnt.article.php');

			}

			// check if top link should be shown
			$CNT_TMP .= getContentPartTopLink($crow["acontent_top"]);

			// Space after
			if($crow["acontent_after"]) {
				if(!empty($template_default["article"]["div_spacer"])) {
					$CNT_TMP .= '<div style="margin-bottom:'.$crow["acontent_after"].'px;" class="'.$template_default['classes']['spaceholder-cp-after'].'"></div>';
				} else {
					$CNT_TMP .= '<br class="'.$template_default['classes']['spaceholder-cp-after'].'" />'.spacer(1,$crow["acontent_after"]);
				}
			}

			// Maybe content part ID should b used inside templates or for something different
			$CNT_TMP = str_replace( array('[%CPID%]', '{CPID}'), $crow["acontent_id"], $CNT_TMP );

			// trigger content part functions
			$CNT_TMP = trigger_cp($CNT_TMP, $crow);

			//check if PHP replacent tags are allowed for content
			if(empty($phpwcms["allow_cntPHP_rt"])) {
				$CNT_TMP = remove_unsecure_rptags($CNT_TMP);
			}

			// wrap tab
			if(!empty($crow['acontent_tab'])) {

				$crow['acontent_tab']			= explode('_', $crow['acontent_tab'], 2);
				$crow['acontent_tab']['num']	= explode('|' ,$crow['acontent_tab'][0]);
				$crow['acontent_tab']['type']	= empty($crow['acontent_tab']['num'][1]) ? 1 : intval($crow['acontent_tab']['num'][1]);
				$crow['acontent_tab']['num']	= intval($crow['acontent_tab']['num'][0]);
				$crow['acontent_tab']['title']	= empty($crow['acontent_tab'][1]) ? i18n_substitute_text_token($content['cptab_types'][ $crow['acontent_tab']['type'] ]['title']) : $crow['acontent_tab'][1];

				// create a unique Tab ID based on title, content block and section
				$CNT_TAB		= $content['cptab_types'][ $crow['acontent_tab']['type'] ]['id'] . '-' . md5($crow['acontent_block'] . $crow['acontent_tab']['num']);
				$CNT_TAB_ID 	= $content['cptab_types'][ $crow['acontent_tab']['type'] ]['item'] . '-' . md5($crow['acontent_tab']['title'].$crow['acontent_block']);
				$CNT_TAB_TMP	= $CNT_TMP;

				// check if Tab ID is registered
				if(!isset($content['cptab'][$CNT_TAB])) {

					$content['cptab'][$CNT_TAB] = array();
					$content['cptab_types'][$CNT_TAB] = $crow['acontent_tab']['type'];

					// write Tab Block Replacer
					$CNT_TMP = '<!-- ' . $CNT_TAB . ' -->';

				} else {

					$CNT_TMP = '';

				}
				if(!isset($content['cptab'][$CNT_TAB][$CNT_TAB_ID])) {

					$content['cptab'][$CNT_TAB][$CNT_TAB_ID] = array(
						'title'		=> $crow['acontent_tab']['title'],
						'content'	=> ''
					);

				}

				$content['cptab'][$CNT_TAB][$CNT_TAB_ID]['content'] .= $CNT_TAB_TMP;

			}

			// now add rendered content part to right frontend content
			// var given by block -> $content['CB'][$crow['acontent_block']]
			if($crow['acontent_block'] == 'CONTENT' || $crow['acontent_block'] == '') {
				// default content block
				$content["main"] .= $CNT_TMP;
			} else {
				// check if content block var is set
				if(!isset($content['CB'][$crow['acontent_block']])) {
					$content['CB'][$crow['acontent_block']] = '';
				}
				$content['CB'][$crow['acontent_block']] .= $CNT_TMP;
			}

		}

		// render Tabs
		if(count($content['cptab'])) {

			foreach($content['cptab'] as $CNT_TAB => $trow) {

				// define helper var
				$g = array(
					'wrap'		=> array(),
					'counter' 	=> 1,
					'max'		=> count($trow)
				);

				// Behavior: Group
				if($content['cptab_types'][$CNT_TAB] === 2) {

					$g['wrap'][]	= '<div id="'.$CNT_TAB.'"' . ($template_default['classes']['cpgroup-container'] ? ' class="'.$template_default['classes']['cpgroup-container'].'"' : '') . '>';

					foreach($trow as $tabkey => $tabitem) {

						$tabitem['id']				= 'cpgroup-' . uri_sanitize(strtolower($tabitem['title'])) . '-' . $g['counter'];
						$tabitem['class']			= $template_default['classes']['cpgroup-title'] ? $template_default['classes']['cpgroup-title'] : '';
						$tabitem['content-class']	= $template_default['classes']['cpgroup'] ? $template_default['classes']['cpgroup'] . ' ' . $template_default['classes']['cpgroup'] . '-' . $g['counter'] : '';

						if($template_default['classes']['cpgroup-first'] && $g['counter'] === 1) {
							$tabitem['content-class'] .= ' '.$template_default['classes']['cpgroup-first'];
						}
						if($template_default['classes']['cpgroup-last'] && $g['counter'] === $g['max']) {
							$tabitem['content-class'] .= ' '.$template_default['classes']['cpgroup-last'];
						}

						$tabitem['class'] = trim($tabitem['class']);
						$tabitem['class'] = $tabitem['class'] ? ' class="'.$tabitem['class'].'"' : '';

						$tabitem['content-class'] = trim($tabitem['content-class']);

						if($tabitem['content-class']) {
							$tabitem['content-class'] = ' class="'.$tabitem['content-class'].'"';
						}

						$g['wrap'][]	= '	<div'.$tabitem['content-class'].'>';
						$g['wrap'][]	= '		<h3'.$tabitem['class'].'>';
						$g['wrap'][]	= '			<span data-cpgroupid="'.$tabitem['id'].'">'.html_specialchars($tabitem['title']).'</span>';
						$g['wrap'][]	= '		</h3>';
						$g['wrap'][]	= '		<div id="'.$tabitem['id'].'"'.($template_default['classes']['cpgroup-content'] ? ' class="'.$template_default['classes']['cpgroup-content'].'"' : '').'>';
						$g['wrap'][]	= '			' . $tabitem['content'];
						$g['wrap'][]	= '		</div>';
						$g['wrap'][]	= '	</div>';

						$g['counter']++;
					}

					if($template_default['classes']['cpgroup-container-clear']) {
						$g['wrap'][]	= '	<span class="'.$template_default['classes']['cpgroup-container-clear'].'"></span>';
					}
					$g['wrap'][]	= '</div>';


				// Default behavior: Tabs
				} else {

					$g['cnt']		= array();

					$g['wrap'][]	= '<div id="'.$CNT_TAB.'"' . ($template_default['classes']['tab-container'] ? ' class="'.$template_default['classes']['tab-container'].'"' : '') . '>';
					$g['wrap'][]	= '	<ul' . ($template_default['classes']['tab-navigation'] ? ' class="'.$template_default['classes']['tab-navigation'].'"' : '') . '>';

					foreach($trow as $tabkey => $tabitem) {

						$tabitem['id']				= 'tab-' . uri_sanitize(strtolower($tabitem['title'])) . '-' . $g['counter'];
						$tabitem['class']			= $template_default['classes']['tab-item'] ? $template_default['classes']['tab-item'].'-'.$g['counter'] : '';
						$tabitem['content-class']	= $template_default['classes']['tab-content'];

						if($template_default['classes']['tab-content-item']) {
							$tabitem['content-class'] = trim($tabitem['content-class'] . ' ' . $template_default['classes']['tab-content-item']) . '-' . $g['counter'];
						}
						if($tabitem['content-class']) {
							$tabitem['content-class'] = ' class="'.$tabitem['content-class'].'"';
						}

						if($template_default['classes']['tab-first'] && $g['counter'] === 1) {
							$tabitem['class'] .= ' '.$template_default['classes']['tab-first'];
						}
						if($template_default['classes']['tab-last'] && $g['counter'] === $g['max']) {
							$tabitem['class'] .= ' '.$template_default['classes']['tab-last'];
						}

						$tabitem['class'] = trim($tabitem['class']);
						$tabitem['class'] = $tabitem['class'] ? ' class="'.$tabitem['class'].'"' : '';

						$g['wrap'][]	= '		<li'.$tabitem['class'].'><a href="'.rel_url().'#'.$tabitem['id'].'">'.html_specialchars($tabitem['title']).'</a></li>';
						$g['cnt'][]		= '	<div id="'.$tabitem['id'].'"'.$tabitem['content-class'].'>' . LF . $tabitem['content'] . LF . '	</div>';

						$g['counter']++;
					}

					$g['wrap'][]	= '	</ul>';
					$g['wrap'][]	= implode(LF, $g['cnt']);
					if($template_default['classes']['tab-container-clear']) {
						$g['wrap'][]	= '	<span class="'.$template_default['classes']['tab-container-clear'].'"></span>';
					}
					$g['wrap'][]	= '</div>';

				}

				$content['cptab'][$CNT_TAB] = implode(LF, $g['wrap']);
			}

			unset($g);
		}

	}
}

if(empty($template_default["article"]["div_spacer"])) {
	$content["main"] = str_replace("</table>\n<br />", "</table>\n", $content["main"]);
	$content["main"] = str_replace("</table><br />", "</table>", $content["main"]);
	$content["main"] = str_replace("</div><br />", "</div>", $content["main"]);
}

// set canonical <link> in page <head> section to avoid lower SEO ranking
// see: http://googlewebmastercentral.blogspot.com/2009/02/specify-your-canonical.html
if($content['set_canonical'] && empty($phpwcms['canonical_off']) && empty($phpwcms['force301_2struct'])) {
	if($content['aId_CpPage']) {
		$content['set_canonical'] = 'aid='.$row["article_id"].'-'.$content['aId_CpPage'];
		if(!empty($content['struct'][ $content['cat_id'] ]['acat_alias'])) {
			$content['set_canonical'] .= '&amp;'.$content['struct'][ $content['cat_id'] ]['acat_alias'];
		}
	} else {
		// set canonical only for single article in this category
		$content['set_canonical'] = get_structurelevel_single_article_alias($content['cat_id']);
	}
	if($content['set_canonical']) {

		if($phpwcms["rewrite_url"]) {

			$block['custom_htmlhead']['canonical'] = '  <link rel="canonical" '.url_search(array(1 => 'href', 3 => $content['set_canonical'])) . ' />';

			if(PHPWCMS_REWRITE_EXT && strpos($block['custom_htmlhead']['canonical'], PHPWCMS_REWRITE_EXT.'&amp;')) {
				$block['custom_htmlhead']['canonical'] = str_replace(PHPWCMS_REWRITE_EXT.'&amp;', PHPWCMS_REWRITE_EXT.'?', $block['custom_htmlhead']['canonical']);
			};

		} else {
			$block['custom_htmlhead']['canonical'] = '  <link rel="canonical" href="' . PHPWCMS_URL . 'index.php?' . $content['set_canonical'] . '" />';
		}

	}
}

if(!defined('PHPWCMS_ALIAS') && !empty($row['article_alias'])) {
	define('PHPWCMS_ALIAS', $row['article_alias']);
}

?>