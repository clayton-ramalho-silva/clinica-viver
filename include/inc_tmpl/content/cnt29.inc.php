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


//images

$caption_box	= array();
$img_thumbs		= '';
$imgx			= 0;

if(empty($template_default['imagegallery_default_column'])) {
	$template_default['imagegallery_default_column'] = 1;
} else {
	$template_default['imagegallery_default_column'] = intval($template_default['imagegallery_default_column']);
	if(empty($template_default['imagegallery_default_column'])) {
		$template_default['imagegallery_default_column'] = 1;
	}
}

$template_default['imagegallery_default_width']	 = isset($template_default['imagegallery_default_width']) ? $template_default['imagegallery_default_width'] : '' ;
$template_default['imagegallery_default_height'] = isset($template_default['imagegallery_default_height']) ? $template_default['imagegallery_default_height'] : '' ;
$template_default['imagegallery_default_space']	 = isset($template_default['imagegallery_default_space']) ? $template_default['imagegallery_default_space'] : '' ;

if(!isset($content['image_list']['col'])) {

	$content['image_list'] = array(

			'pos'		=> 0,
			'width'		=> $template_default['imagegallery_default_width'],
			'height'	=> $template_default['imagegallery_default_height'],
			'col'		=> $template_default['imagegallery_default_column'],
			'space'		=> $template_default['imagegallery_default_space'],
			'zoom'		=> 0,
			'caption'	=> '',
			'lightbox'	=> 0,
			'nocaption'	=> 0,
			'crop'		=> 0,
			'limit'		=> 0,
			'random'	=> 0

		);

}
if(empty($content['image_list']['center_image'])) {
	$content['image_list']['center_image'] = 0;
}

$img_count = isset($content["image_list"]['images']) && is_array($content["image_list"]['images']) ? count($content["image_list"]['images']) : 0;

?>

<!--<tr><td colspan="2" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>-->

<tr><td colspan="2">
        <div class="barra"></div> 
        <h3>Imagens</h3>
        
     
        <p class="botoes-subir-img">
    <a class="botoes bt-imagem" href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=1&amp;target=nolist');return false;">
        <i class="far fa-images"></i>
         Escolher Imagem
    </a>
    <a class="botoes" href="#" title="<?php echo $BL['be_cnt_sortup'] ?>" onclick="moveOptionUp(document.articlecontent.cimage_list);return false;">
        <i class="fas fa-chevron-up"></i>
    </a>
    <a class="botoes" href="#" title="<?php echo $BL['be_cnt_sortdown'] ?>" onclick="moveOptionDown(document.articlecontent.cimage_list);return false;">
        <i class="fas fa-chevron-down"></i>
    </a>
    <a class="botoes bt-delete" href="#" onclick="removeSelectedOptions(document.articlecontent.cimage_list);return false;" title="<?php echo $BL['be_cnt_delimage'] ?>">
                <i class="far fa-trash-alt"></i>
    </a>
</p>
        
        <p>
    <b><?php echo $BL['be_cnt_image'] ?></b>
    
    <select name="cimage_list[]" size="<?php echo $img_count+5 ?>" multiple="multiple" class="listrow" id="cimage_list">
<?php
if($img_count) {

	// browse images and list available
	// will be visible only when aceessible
	foreach($content['image_list']['images'] as $key => $value) {

		// 0   :1       :2   :3        :4    :5     :6      :7       :8
		// dbid:filename:hash:extension:width:height:caption:position:zoom
		$thumb_image = get_cached_image(array(
			"target_ext"	=>	$content['image_list']['images'][$key][3],
			"image_name"	=>	$content['image_list']['images'][$key][2] . '.' . $content['image_list']['images'][$key][3],
			"thumb_name"	=>	md5($content['image_list']['images'][$key][2].$phpwcms["img_list_width"].$phpwcms["img_list_height"].$phpwcms["sharpen_level"].$phpwcms['colorspace'])
		));

		if($thumb_image != false) {

			// image found
			echo '<option value="' . $content['image_list']['images'][$key][0] . '">';
			$img_name = html($content['image_list']['images'][$key][1]);
			echo $img_name . '</option>'.LF;

			if($imgx == 4) {
				$img_thumbs .= '';
				$imgx = 0;
			}
			if($imgx) {
				$img_thumbs .= '';
			}
			$img_thumbs .= '<figure><img src="'.PHPWCMS_IMAGES . $thumb_image[0] .'" border="0" '.$thumb_image[3].' alt="'.$img_name.'" title="'.$img_name.'" /></figure>';

			$caption_box[] = html($content['image_list']['images'][$key][6]);

			$imgx++;
		}

	}

}

?>
		  </select>
</p>    

<div class="espacamento"></div>
<div class="espacamento"></div>
<h3>Pré-visualização das Imagens</h3>
<div class="espacamento"></div>
<?php

	if($img_thumbs) {
		echo '
		<div class="grid-4">
                	'.$img_thumbs.'
		</div>';
	}

?>

<div class="barra"></div>

<p>
    A Ordem da legenda segue a mesma ordem das fotos acima (usar uma legenda por linha)
</p>

<p>
    <b><?php echo $BL['be_cnt_caption'] ?></b>
    <textarea name="cimage_caption" cols="40" rows="<?php echo $img_count+5 ?>" wrap="off" id="cimage_caption"><?php echo implode(' '.LF, $caption_box) ?></textarea>
</p>
    
<p>
    <?php echo $BL['be_cnt_caption']; ?>
			|
			<?php echo $BL['be_caption_alt']; ?>
			|
			<?php echo $BL['be_admin_page_link']; ?> <em><?php echo $BL['be_cnt_target']; ?></em>
			|
			<?php echo $BL['be_caption_title']; ?>
			|
			<?php echo $BL['be_copyright']; ?>&nbsp;&crarr;&nbsp;&hellip;
</p>
        
        
<div class="barra"></div>

<h2>Aparência</h2>

        
<p>
    <b><?php echo $BL['be_admin_struct_template']; ?></b>
    <select name="template" id="template">
<?php

	echo '<option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

	// templates for frontend login
	$tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE.'inc_cntpart/images');
	if(is_array($tmpllist) && count($tmpllist)) {
		foreach($tmpllist as $val) {
			// do not show listmode templates
			if(substr($val, 0, 5) == 'list.') {
				continue;
			}
			$selected_val = (isset($content["image_template"]) && $val == $content["image_template"]) ? ' selected="selected"' : '';
			$val = html($val);
			echo '	<option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
		}
	}

?>
		</select>
</p>

<div class="barra"></div>
<h2>Configurações</h2>

  <p>
            <strong>Dimensões da Imagem (px) </strong>
        </p>
   
        <div class="grid-6">
        
 <p style="display: none">
    <b><?php echo $BL['be_image_align'] ?></b>
    <select name="cimage_center" id="cimage_center">
				<option value="0"<?php is_selected(0, $content['image_list']['center_image']); ?>><?php echo $BL['be_cnt_imagenocenter'] ?></option>
				<option value="1"<?php is_selected(1, $content['image_list']['center_image']); ?>><?php echo $BL['be_cnt_imagecenter'] ?></option>
				<option value="2"<?php is_selected(2, $content['image_list']['center_image']); ?>><?php echo $BL['be_cnt_imagecenterh'] ?></option>
				<option value="3"<?php is_selected(3, $content['image_list']['center_image']); ?>><?php echo $BL['be_cnt_imagecenterv'] ?></option>
    </select>
</p>

<p >
    <b><?php echo $BL['be_cnt_maxw'] ?></b>
    <input name="cimage_width" type="text" id="cimage_width"  size="4" maxlength="4" onkeyup="setCimageCenterInactive();" value="<?php echo empty($content['image_list']['width']) ? $template_default['imagegallery_default_width'] : $content['image_list']['width']; ?>" />
</p>
        

<p>
    <b><?php echo $BL['be_cnt_maxh'] ?></b>
    <input name="cimage_height" type="text" id="cimage_height" size="4" maxlength="4" onkeyup="setCimageCenterInactive();" value="<?php echo empty($content['image_list']['height']) ? $template_default['imagegallery_default_height'] : $content['image_list']['height']; ?>" />
</p>



<p>
    <label for="cimage_crop" class="botoes">
    <input type="checkbox" name="cimage_crop" id="cimage_crop" value="1" <?php is_checked(1, $content['image_list']['crop']); ?> />
    <?php echo $BL['be_image_crop'] ?></label>
</p>

  


        <p style="display:none">
    <b><?php echo $BL['be_cnt_column'] ?></b>
    <select name="cimage_col"  id="cimage_col">
<?php

// list select menu for max image columns
for($max_image_col = 1; $max_image_col <= 25; $max_image_col++) {

	echo '<option value="'.$max_image_col.'" ';
	is_selected($max_image_col, $content['image_list']['col']);
	echo '>'.$max_image_col."</option>\n";

}

?>
    </select>
</p>

<p style="display:none">
    <b><?php echo $BL['be_cnt_imagespace'] ?></b>
    <input name="cimage_space" type="text" id="cimage_space" size="2" maxlength="3" onkeyup="if(!parseInt(this.value*1)) this.value='';" value="<?php echo empty($content['image_list']['space']) ? $template_default['imagegallery_default_space'] : $content['image_list']['space']; ?>" />
</p>


<p>
    <b><label for="cimage_limit"><?php echo $BL['limit_image_from_list'] ?></label></b>
    <input name="cimage_limit" type="text" id="cimage_limit" size="2" maxlength="3" onkeyup="if(!parseInt(this.value*1)) this.value='';" value="<?php echo empty($content['image_list']['limit']) ? '' : $content['image_list']['limit']; ?>" />
</p>

<p>
    
  <label for="cimage_random" class="botoes">
      <input type="checkbox" name="cimage_random" id="cimage_random" value="1" <?php is_checked(1, empty($content['image_list']['random']) ? 0 : 1); ?> />
      <?php echo $BL['random_image'] ?></label>
</p>

   <p>
                <b>Nº de Colunas (Máx. 10)</b>
                <input name="cimage_colunas" type="text" id="cimage_colunas"   maxlength="4"  value="<?php echo $content['all_link']['cimage_colunas'] ?>" />

            </p>
        </div>
<script type="text/javascript">
	<!--
	//if(!parseInt(this.value*1)) this.value='';
	function setCimageCenterInactive() {
		var cih = getObjectById('cimage_width');
		var ciw = getObjectById('cimage_height');
		var cic = getObjectById('cimage_center');
		//var cil = getObjectById('cimage_center_label');
		var ccp = getObjectById('cimage_crop');
		var dis = false;
		if(!parseInt(cih.value*1)) {
			cih.value = '';
			dis = true;
		}
		if(!parseInt(ciw.value*1)) {
			ciw.value = '';
			dis = true;
		}
		if(dis) {
			cic.disabled = true;
			ccp.disabled = true;
			//cil.className = 'checkbox inactive';
		} else {
			cic.disabled = false;
			ccp.disabled = false;
			//cil.className = 'checkbox';
		}
	}
	setCimageCenterInactive();
	//-->
	</script>

        <div class="grid-2">
            
<p>
    <label for="cimage_zoom" class="botoes">
        <input checked="checked" name="cimage_zoom" type="checkbox" id="cimage_zoom" value="1" <?php is_checked(1, $content['image_list']['zoom']); ?> />    
    <?php echo $BL['be_cnt_enlarge'] ?></label>
    
    
    <label for="cimage_lightbox" class="botoes" style="margin-left: 10px">
    <input name="cimage_lightbox" type="checkbox" id="cimage_lightbox" value="1" <?php is_checked(1, $content['image_list']['lightbox']); ?> onchange="if(this.checked){getObjectById('cimage_zoom').checked=true;}" />
    <?php echo $BL['be_cnt_lightbox'] ?></label>
    
</p>
<p style="display:none">
    <label for="cimage_nocaption" class="botoes">
    <input name="cimage_nocaption" type="checkbox" id="cimage_nocaption" value="1" <?php is_checked(1, $content['image_list']['nocaption']); ?> />
    <?php echo $BL['be_cnt_imglist_nocaption'] ?></label>
</p>
    
        </div>
<div class="barra"></div>
  
<h2>Texto de Introdução</h2>    
      
    
<p>
<?php
        $wysiwyg_editor = array(
            'value' => isset($content["image_html"]) ? $content["image_html"] : '',
            'field' => 'image_html',
            'height2' => '100',
            'width2' => '"100%"',
            'rows' => '15',
            'editor' => $_SESSION["WYSIWYG_EDITOR"],
            'lang' => 'en',
            'expanded' => '0'
        );

        include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
        ?>
</p>

<div class="barra"></div>

<h3>Slider</h3>
<p>
    <label for="cimage_slider" class="botoes">
            <input type="checkbox" name="cimage_slider" id="cimage_slider" value="1" <?php is_checked(1, $content['image_list']['slider']); ?> />
            <?php echo $BL['be_image_slider'] ?>
        </label>
</p>


<div <?php echo ($content['image_list']['slider'] === 1) ? '' : ' style="display: none"' ?>>
</div>
    
    <h2 class="accordion"><i class="fas fa-sort-down"></i> <?php echo $BL['tit_tab_slider'] ?></h2>
        <div class="accordion">

            <?php

            $codigo = '<script>'."\n"
                    . '$(document).ready(function () {'."\n"
                    . '    $(".baid{ID}").slick({'."\n"
                    . '        dots: true,'."\n"
                    . '        arrows: true,'."\n"
                    . '        infinite: true,'."\n"
                    . '        slidesToShow: 5,'."\n"
                    . '        slidesToScroll: 1,'."\n"
                    . '        responsive: ['."\n"
                    . '            {'."\n"
                    . '                breakpoint: 1024,'."\n"
                    . '                settings: {'."\n"
                    . '                    slidesToShow: 3,'."\n"
                    . '                    slidesToScroll: 1,'."\n"
                    . '                    infinite: true,'."\n"
                    . '                    dots: true'."\n"
                    . '                }'."\n"
                    . '            },'."\n"
                    . '            {'."\n"
                    . '                breakpoint: 600,'."\n"
                    . '                settings: {'."\n"
                    . '                    slidesToShow: 2,'."\n"
                    . '                    slidesToScroll: 1'."\n"
                    . '                }'."\n"
                    . '            },'."\n"
                    . '            {'."\n"
                    . '                breakpoint: 480,'."\n"
                    . '                settings: {'."\n"
                    . '                    slidesToShow: 1,'."\n"
                    . '                    slidesToScroll: 1'."\n"
                    . '                }'."\n"
                    . '            }'."\n"
                    . '        ]'."\n"
                    . '    });'."\n"
                    . '});'."\n"
                    . '</script>';

            ?>

            <?php
            /*
            ============================ OBS DANILO ============================
                TIRAR O STYLE DO TEXTAREA ABAIXO, EU SÓ COLOQUEI PARA TESTAR
            ====================================================================
            */
            ?>

            <p><textarea name="cimage_cod_slider" id="cimage_cod_slider" style="display: block; height: 500px"><?php echo ($content['image_list']['cod_slider'] !== '') ? $content['image_list']['cod_slider'] : $codigo ?></textarea></p>
        </div>
    <div class="grid-4">
        <p style="display: flex; gap:5px; grid-column-start: 1; grid-column-end: 3;">
                <label class="botoes">
                    <input type="checkbox" name="show-dots" checked="checked">
                    Mostrar Navegação
                </label>
              
                <label class="botoes">
                    <input type="checkbox" name="show-arrows" checked="checked">
                    Mostrar Setas
                </label>
                
                <label class="botoes">
                    <input type="checkbox" name="show-infinite"  checked="checked">
                    Sem Limite
                </label>
            </p>
            
          
        
            <p>
                <b>Nº de Blocos Aparentes </b>
                <input type="text">
            </p>
            
            <p>
                <b>Nº de Blocos que se Movem</b>
                <input type="text">
            </p>
    </div>


<?php
/* CONFIGURAÇÕES DO SLIDER */
?>

            </td></tr>




<script>
$j().ready(function(){

    $j('#cimage_slider').on('click', function(){

        if($j(this).is(':checked')){
            $j('h2.accordion').show(300)
        } else {
            $j('.accordion').hide(300)
        }

    });

})
</script>