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


// Content Type Images Special
$content["image_html"]		= slweg($_POST['image_html']);
$content["image_template"]	= clean_slweg($_POST['template']);

$content['all_link'] = array();
$content['all_link']['botao'] = clean_slweg($_POST['all_link_botao']);
$content['all_link']['tipo'] = clean_slweg($_POST['all_link_url_tipo']);
$content['all_link']['link'] = clean_slweg($_POST['all_link_url']);
$content['all_link']['pag'] = clean_slweg($_POST['all_link_url_pag']);
$content['all_link']['cimage_colunas'] = clean_slweg($_POST['cimage_colunas']);

$content['c_extra'] = array();
$content['c_extra']['campo_clonar'] = clean_slweg($_POST['campo_clonar']);




$content['image_special']	= array(

			'pos'				=> empty($_POST['cimage_pos']) ? 0 : intval($_POST['cimage_pos']),
			'width'				=> empty($_POST['cimage_width']) ? '' : intval($_POST['cimage_width']),
			'height'			=> empty($_POST['cimage_height']) ? '' : intval($_POST['cimage_height']),
			'width_zoom'		=> empty($_POST['cimage_width_zoom']) ? $phpwcms['img_prev_width'] : intval($_POST['cimage_width_zoom']),
			'height_zoom'		=> empty($_POST['cimage_height_zoom']) ? $phpwcms['img_prev_height'] : intval($_POST['cimage_height_zoom']),
			'col'				=> empty($_POST['cimage_col']) ? 1 : intval($_POST['cimage_col']),
			'space'				=> empty($_POST['cimage_space']) ? 0 : intval($_POST['cimage_space']),
			'zoom'				=> empty($_POST['cimage_zoom']) ? 0 : 1,
			'lightbox'			=> empty($_POST['cimage_lightbox']) ? 0 : 1,
			'nocaption'			=> empty($_POST['cimage_nocaption']) ? 0 : 1,
			'center'			=> empty($_POST['cimage_center']) ? 0 : intval($_POST['cimage_center']),
			'crop'				=> empty($_POST['cimage_crop']) ? 0 : 1,
			'crop_zoom'			=> empty($_POST['cimage_crop_zoom']) ? 0 : 1,
			'fx1'				=> empty($_POST['cimage_fx1']) ? 0 : 1,
			'fx2'				=> empty($_POST['cimage_fx2']) ? 0 : 1,
			'fx3'				=> empty($_POST['cimage_fx3']) ? 0 : 1,
			'addclassemulti'	=> empty($_POST['calink_addclasse_multi']) ? 0 : 1,
			'numeromulti'		=> intval($_POST['calink_numero_multi']),
			'classemulti'		=> $_POST['calink_classe_multi'],
			'addclasse'			=> empty($_POST['calink_addclasse']) ? 0 : 1,
			'numeroclasse'		=> intval($_POST['calink_numero']),
			'addclasse_classe'	=> $_POST['calink_classe'],
			'images'		=> array()

		);

// get image entry POST values
if(isset($_POST['cimage_id_thumb']) && is_array($_POST['cimage_id_thumb']) && count($_POST['cimage_id_thumb'])) {
	
	$x = 0;
	
	foreach($_POST['cimage_id_thumb'] as $key => $value) {
	
		$image_entry = array();
		
		$image_entry['thumb_id']	= intval($_POST['cimage_id_thumb'][$key]);
		$image_entry['zoom_id']		= intval($_POST['cimage_id_zoom'][$key]);
		
		if(!$image_entry['thumb_id'] && !$image_entry['zoom_id']) {
			continue;
		}
		
		$image_entry['thumb_name']	= clean_slweg($_POST['cimage_name_thumb'][$key]);
		$image_entry['zoom_name']	= clean_slweg($_POST['cimage_name_zoom'][$key]);
		$image_entry['sort']		= $x;
		$image_entry['caption']		= clean_slweg($_POST['cimage_caption'][$key]);
		$image_entry['freetext']	= slweg($_POST['cimage_freetext'][$key]);
		$image_entry['url']			= clean_slweg($_POST['cimage_url'][$key]);
	        $image_entry['tipo'] = clean_slweg($_POST['cimage_url_tipo'][$key]);
                $image_entry['pagina'] = clean_slweg($_POST['cimage_url_pag'][$key]);
                $image_entry['botao'] = clean_slweg($_POST['cimage_botao'][$key]);
        
		if(!$image_entry['thumb_id']) {
			$image_entry['thumb_id']	= '';
			$image_entry['thumb_name']	= '';
			$image_entry['thumb_hash']	= '';
			$image_entry['thumb_ext']	= '';
		} else {
			$sql   = 'SELECT f_hash, f_ext FROM '.DB_PREPEND.'phpwcms_file WHERE ';
			$sql  .= 'f_id='.$image_entry['thumb_id'].' AND ';
			$sql  .= 'f_trash=0 AND f_aktiv=1 AND f_public=1';
			$image_data = _dbQuery($sql);
			if(isset($image_data[0]['f_hash'])) {
				$image_entry['thumb_hash']	= $image_data[0]['f_hash'];
				$image_entry['thumb_ext']	= $image_data[0]['f_ext'];
			}
		}
		if(!$image_entry['zoom_id']) {
			$image_entry['zoom_id']		= '';
			$image_entry['zoom_name']	= '';
			$image_entry['zoom_hash']	= '';
			$image_entry['zoom_ext']	= '';
		} else {
			$sql   = 'SELECT f_hash, f_ext FROM '.DB_PREPEND.'phpwcms_file WHERE ';
			$sql  .= 'f_id='.$image_entry['zoom_id'].' AND ';
			$sql  .= 'f_trash=0 AND f_aktiv=1 AND f_public=1';
			$image_data = _dbQuery($sql);
			if(isset($image_data[0]['f_hash'])) {
				$image_entry['zoom_hash']	= $image_data[0]['f_hash'];
				$image_entry['zoom_ext']	= $image_data[0]['f_ext'];
			}
		}

		$content['image_special']['images'][$x] = $image_entry;
		
		$x++;
	
	}

}


?>