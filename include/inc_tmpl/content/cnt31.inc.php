<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 * */
// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
    die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------
//images special

initMootools();

// some predefinitions
if (empty($template_default['imagegallery_default_column'])) {
    $template_default['imagegallery_default_column'] = 1;
} else {
    $template_default['imagegallery_default_column'] = intval($template_default['imagegallery_default_column']);
    if (empty($template_default['imagegallery_default_column'])) {
        $template_default['imagegallery_default_column'] = 1;
    }
}
$template_default['imagegallery_default_width'] = isset($template_default['imagegallery_default_width']) ? $template_default['imagegallery_default_width'] : '';
$template_default['imagegallery_default_height'] = isset($template_default['imagegallery_default_height']) ? $template_default['imagegallery_default_height'] : '';
$template_default['imagegallery_default_space'] = isset($template_default['imagegallery_default_space']) ? $template_default['imagegallery_default_space'] : '';


$content['image_default'] = array(
    'pos' => 0,
    'width' => $template_default['imagegallery_default_width'],
    'height' => $template_default['imagegallery_default_height'],
    'width_zoom' => $phpwcms['img_prev_width'],
    'height_zoom' => $phpwcms['img_prev_height'],
    'col' => $template_default['imagegallery_default_column'],
    'space' => $template_default['imagegallery_default_space'],
    'zoom' => 0,
    'caption' => '',
    'lightbox' => 0,
    'nocaption' => 0,
    'center' => 0,
    'crop' => 0,
    'crop_zoom' => 0,
    'fx1' => 0,
    'fx2' => 0,
    'fx3' => 0,
    'freetext' => '',
    'images' => array()
);

$content['image_special'] = isset($content['image_special']) ? array_merge($content['image_default'], $content['image_special']) : $content['image_default'];
?>




<tr>
    <td colspan="2">
        <div class="barra"></div>
        <span id="add-top" class="btn_image_add banner-add"> <i class="fas fa-folder-plus"></i><?= $BL['be_article_cnt_add'] ?></span>
    </td>
</tr>

<tr>
    <td colspan="2">


        <ul id="images">

            <?php
// Sort/Up Down Title
            $x = 0;
            $sort_up_down = $BL['be_func_struct_sort_up'] . ' / ' . $BL['be_func_struct_sort_down'];

// loop available image entries
            foreach ($content['image_special']['images'] as $key => $value) {
                ?>

                    <li id="image_<?php echo $key ?>" class="li-banners" data-num="<?php echo $x ?>">

                        <div class="controle-banner">
                            <span>
                                <!--<em title="<?= $sort_up_down; ?>" class="handle">&nbsp;</em>-->
                                <a class="botoes bt-subir" href="#"><i class="fas fa-arrow-up"></i> Subir</a>
                                <a class="botoes  bt-descer" href="#"><i class="fas fa-arrow-down"></i> Descer</a>
                                <a class="botoes" href="#" onclick="return deleteImgElement('image_<?= $key ?>');"><i class="fas fa-times"></i> Excluir Bloco</a>
                            </span>
                        </div>

                        <div id="accordion" class="bloco-card">

                            <input name="cimage_id_thumb[<?php echo $key ?>]" id="cimage_id_thumb_<?php echo $key ?>" type="hidden" value="<?php echo $value['thumb_id'] ?>" />
                            <input name="cimage_sort[<?php echo $key ?>]" id="cimage_sort_<?php echo $key ?>" type="hidden" value="<?php echo $value['sort'] ?>" />

                            <h3>Imagem</h3>

                            <span class="bloco-img-banner">

                                <figure id="img_preview_<?php echo $key ?>" colspan="3" class="backend_preview_img"></figure>
                                <span>
                                    <p class="botoes-subir-img" style="margin:0">
                                        <a class="botoes bt-imagem" href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="return openImageFileBrowser('thumb_<?php echo $key ?>');">
                                            <i class="far fa-images"></i> Escolher Imagem
                                        </a>
                                        <a class="botoes bt-delete" href="#" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="return deleteImageData('thumb_<?php echo $key ?>', this);">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </p>

                                    <p>
                                        <b>Nome da Imagem</b>
                                        <input name="cimage_name_thumb[<?php echo $key ?>]" type="text" id="cimage_name_thumb_<?php echo $key ?>"  value="<?php echo html($value['thumb_name']) ?>" size="30" onfocus="this.blur();" />
                                    </p>

                                    <!--
                                    <strong><?php echo $BL['be_image_zoom'] ?></strong>
                                                                    <p>
                                                                        <a class="botoes bt-imagem" href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="return openImageFileBrowser('zoom_<?php echo $key ?>');"><i class="far fa-images"></i> Escolher Imagem</a>
                                                                        <a class="botoes bt-delete" href="#" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="return deleteImageData('zoom_<?php echo $key ?>', this);"><i class="far fa-trash-alt"></i></a>
                                                                    </p>

                                                                    <p>
                                                                        <b>Nome da Imagem</b>
                                                                        <input name="cimage_id_zoom[<?php echo $key ?>]" id="cimage_id_zoom_<?php echo $key ?>" type="hidden" value="<?php echo $value['zoom_id'] ?>" />

                                                                        <input name="cimage_name_zoom[<?php echo $key ?>]" type="text" id="cimage_name_zoom_<?php echo $key ?>" class="f11b imagename" value="<?php echo html($value['zoom_name']) ?>" size="30" onfocus="this.blur();" />
                                                                    </p>
                                    -->
                                </span>

                            </span>

                            <div class="espacamento"></div>

                            <h3><?php echo $BL['be_cnt_caption'] ?></h3>
                            <p>
                                <textarea name="cimage_caption[<?php echo $key ?>]" id="cimage_caption_<?php echo $key ?>" rows="2" style="width:100%"><?php echo html($value['caption']) ?></textarea>
                            </p>

                            <div class="espacamento"></div>
                            <h3><?php echo $BL['be_cnt_infotext'] ?></h3>
                            <p>
                                <textarea name="cimage_freetext[<?php echo $key ?>]" id="cimage_freetext_<?php echo $key ?>" style="width:100%" rows="2"><?php echo html(empty($value['freetext']) ? '' : $value['freetext']) ?></textarea>
                            </p>

                            <div class="espacamento"></div>
                            <h2 class="accordion"><i class="fas fa-sort-down"></i> Links para Páginas</h2>
                            <div class="accordion">
                                <div class="li-banners">
                                    <p>
                                        <strong>Modo</strong>
                                        <label class="botoes">
                                            <input checked="checked" type="radio" name="cimage_url_tipo[<?= $key ?>]" id="cimage_url_tipo1_<?= $key ?>" value="1"<?php is_checked(1, $value['tipo']); ?> onClick="hide_show('link-<?= $key ?>', 'pagina-<?= $key ?>')">Link
                                        </label>

                                        <label class="botoes">
                                            <input type="radio" name="cimage_url_tipo[<?= $key ?>]" id="cimage_url_tipo2_<?= $key ?>" value="2"<?php is_checked(2, $value['tipo']); ?> onClick="hide_show('pagina-<?= $key ?>', 'link-<?= $key ?>')">Página do Site
                                        </label>
                                    </p>

                                    <p>
                                        <span class="url-link" id="link-<?= $key ?>"<?= $value['tipo'] === '1' || !$value['tipo'] ? '' : ' style="display: none"' ?>>
                                            <b><?= $BL['be_profile_label_website'] ?></b>
                                            <input type="text" name="cimage_url[<?= $key ?>]" id="cimage_url_<?= $key ?>" value="<?= html($value['url']) ?>">
                                        </span>

                                        <span class="url-pagina" id="pagina-<?= $key ?>"<?= $value['tipo'] === '2' ? '' : ' style="display: none"' ?>>
                                            <b>Página</b>
                                            <select name="cimage_url_pag[<?= $key ?>]" id="cimage_url_pag_<?= $key ?>">
                                            <?= get_pages(html($value['pagina'])) ?>
                                            </select>
                                        </span>
                                    </p>
                                    <p>
                                        <b><?= $BL['be_banner_texto_botao'] ?>:&nbsp;</b>
                                        <input name="cimage_botao[<?= $key ?>]" type="text" id="cimage_botao_<?= $key ?>" value="<?= html($value['botao']) ?>">
                                    </p>
                                </div>
                            </div>

                                                            <!--                        <p class="li-opcoes">
                                                                                        <span>
                                                                                            <em title="<?php echo $sort_up_down; ?>" class="handle">&nbsp;</em>
                                                                                            <a href="#" onclick="return deleteImgElement('image_<?php echo $key ?>');"><img src="img/famfamfam/image_delete.gif" alt="" border="" /></a>
                                                                                        </span>
                                                                                    </p>-->

                        </div>


                    </li>

                <?php
                $x++;
            }
            // close image entry looping
            ?>

        </ul>

    </td>
</tr>

<?php
// second button to add images at bottom of list
if (count($content['image_special']['images'])) {
    ?>
        <tr>
            <td colspan="2">
                <div class="espacamento"></div>
                <span id="add-bottom" class="btn_image_add banner-add"><i class="fas fa-folder-plus"></i> <?= $BL['be_article_cnt_add'] ?></span>
            </td>
        </tr>
    <?php
}
?>


<tr>

    <td colspan="2">
<script type="text/javascript">
        function ShowHideDiv() {
            var ddlPassport = document.getElementById("template");
            var dvPassport = document.getElementById("dvPassport");
            dvPassport.style.display = ddlPassport.value == "clone.html" ? "block" : "none";
        }
    </script>
 
        <h2>Aparência</h2>

        <p>
            <b><?php echo $BL['be_admin_struct_template']; ?></b>
            <select name="template" id="template" onchange="ShowHideDiv()">
                <?php
                echo '<option value="">' . $BL['be_admin_tmpl_default'] . '</option>' . LF;

                $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/imagespecial');
                if (is_array($tmpllist) && count($tmpllist)) {
                    foreach ($tmpllist as $val) {
                        // do not show listmode templates
                        if (substr($val, 0, 5) == 'list.') {
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
        
        <?php 
        $clone = 'clone.html' ;
        
        ?>
        
        <div class="grid-4">
        <p id="dvPassport" <?php echo ($content["image_template"] === $clone) ? '' : ' style="display: none"' ?>> 
            <b>ID da parte para Clonar <?php echo $content["image_template"] ?></b>
            <input name="campo_clonar" type="text" id="campo_clonar" size="4" maxlength="4" value="<?php echo $content['c_extra']['campo_clonar'] ?>" />
        </p>
        </div>
        <div class="barra"></div>


        <h2>Configurações Gerais</h2>

        <p>
            <strong>Dimensões da Imagem (px) </strong>
        </p>

        <div class="grid-4">
            <p>
                <b><?= $BL['be_cnt_maxw'] ?></b>
                <input name="cimage_width" type="text" id="cimage_width" size="4" maxlength="4" onkeyup="setCimageCenterInactive();" value="<?php echo $content['image_special']['width']; ?>" />
            </p>

            <p>
                <b><?= $BL['be_cnt_maxh'] ?></b>
                <input name="cimage_height" type="text" id="cimage_height"  size="4" maxlength="4" onkeyup="setCimageCenterInactive();" value="<?php echo $content['image_special']['height']; ?>" />
            </p>
            <p>
                <label for="cimage_crop" class="botoes">
                    <input type="checkbox" name="cimage_crop" id="cimage_crop" value="1" <?php is_checked(1, $content['image_special']['crop']); ?> /> <?php echo $BL['be_image_crop'] ?>
                </label>

            </p>
            <p style="display:none">
                <b><?php echo $BL['be_image_align'] ?></b>
                <select name="cimage_center" id="cimage_center">

                    <option value="0"<?php is_selected(0, $content['image_special']['center']); ?>><?php echo $BL['be_cnt_imagenocenter'] ?></option>
                    <option value="1"<?php is_selected(1, $content['image_special']['center']); ?>><?php echo $BL['be_cnt_imagecenter'] ?></option>
                    <option value="2"<?php is_selected(2, $content['image_special']['center']); ?>><?php echo $BL['be_cnt_imagecenterh'] ?></option>
                    <option value="3"<?php is_selected(3, $content['image_special']['center']); ?>><?php echo $BL['be_cnt_imagecenterv'] ?></option>

                </select>
            </p>

            <p>
                <b>Nº de Colunas (Máx. 10)</b>
                <input name="cimage_colunas" type="text" id="cimage_columas"   maxlength="4"  value="<?php echo $content['all_link']['cimage_colunas'] ?>" />

            </p>

<!--            <p>
                <b><?php echo $BL['be_cnt_column'] ?></b>
                <select name="cimage_col" id="cimage_col">
            <?php
// list select menu for max image columns
            for ($max_image_col = 1; $max_image_col <= 25; $max_image_col++) {

                echo '<option value="' . $max_image_col . '" ';
                is_selected($max_image_col, $content['image_special']['col']);
                echo '>' . $max_image_col . '</option>' . LF;
            }
            ?>
                </select>
            </p>-->

<!--            <p>
                <b><?php echo $BL['be_cnt_imagespace'] ?> (px)</b>
                <input name="cimage_space" type="text" id="cimage_space" size="2" maxlength="3" onkeyup="if (!parseInt(this.value * 1))
                            this.value = '';" value="<?php echo $content['image_special']['space']; ?>" />
            </p>-->


        </div>
        <div class="barra"></div>

        <!--        <div class="barra"></div>

                <p>
                    <strong><?php echo $BL['be_cnt_reference_zoom'] ?></strong>
                </p>-->
        <!--        <div class="grid-4">
                    <p>
                        <b><?= $BL['be_cnt_maxw'] ?></b>
                        <input name="cimage_width_zoom" type="text" id="cimage_width_zoom" size="4" maxlength="4" value="<?php echo $content['image_special']['width_zoom']; ?>" />
                    </p>
                    <p>
                        <b><?= $BL['be_cnt_maxh'] ?></b>
                        <input name="cimage_height_zoom" type="text" id="cimage_height_zoom" size="4" maxlength="4" value="<?php echo $content['image_special']['height_zoom']; ?>" />
                    </p>
                    <p><label for="cimage_crop_zoom" class="botoes"><input type="checkbox" name="cimage_crop_zoom" id="cimage_crop_zoom" value="1" <?php is_checked(1, $content['image_special']['crop_zoom']); ?> /><?php echo $BL['be_image_crop'] ?></label></p>

                </div>-->

<!--        <p>
            <strong><?php echo $BL['be_cnt_behavior'] ?></strong>
        </p>-->

        <!--        <div class="grid-4">
                    <p><label for="cimage_zoom" class="botoes"><input name="cimage_zoom" type="checkbox" id="cimage_zoom" value="1" <?php is_checked(1, $content['image_special']['zoom']); ?> /><?php echo $BL['be_cnt_enlarge'] ?></label></p>
                    <p>
                        <label for="cimage_lightbox" class="botoes">
                            <input name="cimage_lightbox" type="checkbox" id="cimage_lightbox" value="1" <?php is_checked(1, $content['image_special']['lightbox']); ?> onchange="if (this.checked) {
                                        getObjectById('cimage_zoom').checked = true;
                                    }" /> <?php echo $BL['be_cnt_lightbox'] ?></label>
                    </p>
                    <p>
                        <label for="cimage_nocaption" class="botoes">
                            <input name="cimage_nocaption" type="checkbox" id="cimage_nocaption" value="1" <?php is_checked(1, $content['image_special']['nocaption']); ?> /> <?php echo $BL['be_cnt_imglist_nocaption'] ?>
                        </label>
                    </p>
                    <p>
                        <label for="cimage_fx1" class="botoes">
                            <input name="cimage_fx1" type="checkbox" id="cimage_fx1" value="1" <?php is_checked(1, $content['image_special']['fx1']); ?> /><?php echo $BL['be_fx_1'] ?>
                        </label>
                    </p>
                    <p>
                        <label for="cimage_fx2" class="botoes">
                            <input name="cimage_fx2" type="checkbox" id="cimage_fx2" value="1" <?php is_checked(1, $content['image_special']['fx2']); ?> onchange="if (this.checked) {
                                        getObjectById('cimage_zoom').checked = true;
                                    }" />
        <?php echo $BL['be_fx_2'] ?>
                        </label>
                    </p>
                    <p>
                        <label for="cimage_fx3" class="botoes">
                            <input name="cimage_fx3" type="checkbox" id="cimage_fx3" value="1" <?php is_checked(1, $content['image_special']['fx3']); ?> />
        <?php echo $BL['be_fx_3'] ?>
                        </label>
                    </p>

                </div>-->


    </td>

</tr>


<tr><td colspan="2">
        <div class="li-banners">
            <h2>Links para Páginas</h2>

            <p>
                <strong>Modo</strong>
                <label class="botoes" for="all_link_url_tipo1">
                    <input checked="checked" type="radio" name="all_link_url_tipo" id="all_link_url_tipo1" value="1"<?php is_checked(1, $content['all_link']['tipo']); ?> onClick="hide_show('link', 'pagina')">Link
                </label>

                <label class="botoes" for="all_link_url_tipo2">
                    <input type="radio" name="all_link_url_tipo" id="all_link_url_tipo2" value="2"<?php is_checked(2, $content['all_link']['tipo']); ?> onClick="hide_show('pagina', 'link')">Página do Site
                </label>
            </p>

            <p>
                <span class="url-link" id="link"<?= $content['all_link']['tipo'] === '1' || !$content['all_link']['tipo'] ? '' : ' style="display: none"' ?>>
                    <b><?= $BL['be_profile_label_website'] ?></b>
                    <input type="text" name="all_link_url" id="all_link_url" value="<?= html($content['all_link']['link']) ?>">
                </span>

                <span class="url-pagina" id="pagina"<?= $content['all_link']['tipo'] === '2' ? '' : ' style="display: none"' ?>>
                    <b>Página</b>
                    <select name="all_link_url_pag" id="all_link_url_pag">
                        <?= get_pages(html($content['all_link']['pag'])) ?>
                    </select>
                </span>
            </p>

            <p>
                <b><?= $BL['be_banner_texto_botao'] ?>:&nbsp;</b>
                <input name="all_link_botao" type="text" id="all_link_botao" value="<?= html($content['all_link']['botao']) ?>">
            </p>
        </div>


        <div class="barra"></div>
        <h2>Texto de Introdução</h2>
        <div class="espacamento"></div>

    </td></tr>

<tr><td colspan="2" align="center">



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
        ?></td></tr>






<tr>
    <td colspan="2">
        <script type="text/javascript">

            function mover(botao, tipo) {

                var div = botao.parents('li.li-banners'),
                        id1 = div.attr('id').split('_'),
                        input1 = div.find('input[name^=cimage_sort]'),
                        ordem1 = input1.val(),
                        num1 = div.attr('data-num'),
                        prox = (tipo === 1) ? div.prev('li.li-banners') : div.next('li.li-banners'),
                        id2 = prox.attr('id'),
                        input2 = prox.find('input[name^=cimage_sort]'),
                        ordem2 = input2.val(),
                        num2 = prox.attr('data-num');

                if (id2) {

                    if (tipo === 1) {

                        div.attr('data-num', parseInt(num1) - 1);
                        prox.attr('data-num', parseInt(num2) + 1);

                    } else {

                        div.attr('data-num', parseInt(num1) + 1);
                        prox.attr('data-num', parseInt(num2) - 1);

                    }

                    // Ordenação
                    input1.val(parseInt(ordem1) - 1);
                    input2.val(parseInt(ordem2) + 1);

                    if (tipo === 1) {
                        $j(div).insertBefore(prox);
                    } else {
                        $j(div).insertAfter(prox);
                    }

                    $j([document.documentElement, document.body]).animate({
                                        scrollTop: $j(document).find("#image_" + id1[1]).offset().top
                                    }, 700);

                                }

                            }
                            <!--
            
document.getElementById("add-top").addEventListener("click", function () {
                                    return addNewImage('t                        op');
                            return false;
            });
            
<?php
// second button to add images at bottom of list
if (count($content['image_special']['images'])) {
    ?>
                
                    document.getElementById("add-bottom").addEventListener("click", function () 
                    
                                {
                                        return addNewImage('bottom');
                                return false;
                                });
                                
    <?php
}
?>
                            
                            var site_url = '<?php echo PHPWCMS_URL; ?>';
                            var max_img_w = <?php echo $phpwcms['img_list_width']; ?>;
                            var max_img_h = <?php echo $phpwcms['img_list_height']; ?>;
                            var image_entry = new Array();
                            var urlLink = document.getElementById('cimage_url_tipo1');
                    var urlPag = document.getElementById('cimage_url_tipo2');
                    
                        function hide_show(campo, select) 
                        
                            {
                                    document.getElementById(campo).style.display = 'block';
                            document.getElementById(select).style.display = 'none';
                        }
                            
                        
                        
                        
                            function setCimageCenterInactive() {
                                    var cih = $('cimage_width');
                            var ciw = $('cimage_height');
                            var cic = $('cimage_center');
                            var ccp = $('cimage_crop');
                            var dis = false;
                            if (!parseInt(cih.value * 1)) {
                                cih.value = '';
                                dis = true;
                }
                if (!parseInt(ciw.value * 1)) {
                    ciw.value = '';
                    dis = true;
                }
                if (dis) {
                    cic.disabled = true;
                    ccp.disabled = true;
                } else {
                            cic.disabled = false;
                            ccp.disabled = false;
                        }
                                    }
                        
                                    
                                    
                                    function openImageFileBrowser(image_number) {
                                openFileBrowser('filebrowser.php?opt=8&target=nolist&entry_id=' + image_number);
                        return false;
                                }
                        
                                
                                function setImgIdName(image_number, file_id, file_name) {
                                if (file_id == null || file_name == null)
                            return null;
                        $('cimage_id_' + image_number).value = file_id;
                        $('cimage_name_' + image_number).value = file_name;
                        image_number = image_number.split('_');
                        if (image_number[1]) {
                                updatePreviewImage(image_number[1]);
                    }
                                                                }
                    
                                                                
                                                                function deleteImageData(image_number, e) {
                            $('cimage_name_' + image_number).value = '';
                    $('cimage_id_' + image_number).value = '0';
                    e.blur();
                    image_number = image_number.split('_');
                    if (image_number[1]) {
                            updatePreviewImage(image_number[1]);
                    }
                    return false;
                                                                    }
                    
                                                                    
                                                                
                            function updatePreviewImage(image_number) {
                            var preview = '';
                    if ($('cimage_id_thumb_' + image_number)) {
                        var image_file_id = $('cimage_id_thumb_' + image_number).value;
                        preview += getBackendImgSrc(image_file_id);
                }
                if ($('cimage_id_zoom_' + image_number)) {
                        var image_file_id = $('cimage_id_zoom_' + image_number).value;
                        preview += getBackendImgSrc(image_file_id);
                    }
                    $('img_preview_' + image_number).setHTML(preview);
                            }
                    
                            
                            
                            function getBackendImgSrc(image_file_id) {
                            var image_file_id = parseInt(image_file_id);
                    if (image_file_id) {
                            return '<' + 'img src="' + site_url + 'img/cmsimage.php/' + max_img_w + 'x' + max_img_h + '/' + image_file_id + '" border="0" alt="" /' + '> ';
                    }
                    return '';
                                    }
                    
                                    
                                        
                                        function updatePreviewImageAll() {
                            var all_images = $('images').getElements('li[id^=image_]');
                    if (all_images.length > 0) {
                        all_images.each(function (e) {
                            image_number = e.id.split('_');
                            if (image_number[1]) {
                                    updatePreviewImage(image_number[1]);
                                    image_entry[ image_number[1] ] = $('cimage_sort_' + image_number[1]).value;
                            }
                        });
                    }
                                }
                    
                                    
                                    
                                    function addNewImage(where) {

                            updatePreviewImageAll();

                    var entry_number = image_entry.length;

                    var new_entry = '';


                    new_entry += '<' + 'div id="accordion" class="bloco-card">';

                    new_entry += '<' + 'input name="cimage_id_thumb[' + entry_number + ']" id="cimage_id_thumb_' + entry_number + '" type="hidden" value="" /' + '>';
                    new_entry += '<' + 'input name="cimage_sort[' + entry_number + ']" id="cimage_sort_' + entry_number + '" type="hidden" value="' + entry_number + '" /' + '>';
                    new_entry += '<' + 'h3>Imagem<' + '/h3' + '>';
                    new_entry += '<' + 'span class="bloco-img-banner"' + '>';
                    new_entry += '<' + 'figure id="img_preview_' + entry_number + '" class="backend_preview_img"></figure' + '>';
                    new_entry += '<' + 'span' + '>';
                    new_entry += '<' + 'p class="botoes-subir-img" style="margin:0"' + '>';
                    new_entry += '<' + 'a class="botoes bt-imagem" href="#" title="<?= $BL['be_cnt_openimagebrowser'] ?>" onclick="return openImageFileBrowser(\'thumb_' + entry_number + '\');"><i class="far fa-images"></i> Escolher Imagem<' + '/a>';
                    new_entry += '<' + 'a class="botoes bt-delete" href="#" title="<?= $BL['be_cnt_delimage'] ?>" onclick="return deleteImageData(\'thumb_' + entry_number + '\', this);"><i class="far fa-trash-alt"></i><' + '/a>';
                    new_entry += '<' + '/p' + '>';
                    new_entry += '<' + 'p' + '>';
                    new_entry += '<' + 'b>Nome da Imagem</b' + '>';
                    new_entry += '<' + 'input name="cimage_name_thumb[' + entry_number + ']" type="text" id="cimage_name_thumb_' + entry_number + '" class="f11b imagename" value="" size="30" onfocus="this.blur();"' + '>';
                    new_entry += '<' + '/p' + '>';
                    new_entry += '<' + '/span' + '>';
                    new_entry += '<' + '/span' + '>';
                    new_entry += '<' + 'div class="espacamento"></div' + '>';
                    new_entry += '<' + 'h3><?= $BL['be_cnt_caption'] ?><' + '/h3' + '>';
                    new_entry += '<' + 'p>';
                    new_entry += '<' + 'textarea name="cimage_caption[' + entry_number + ']" id="cimage_caption_' + entry_number + '" style="width:100%"><' + '/textarea>';
                    new_entry += '<' + '/p>';
                    new_entry += '<' + 'div class="espacamento"></div' + '>';

                    new_entry += '<' + 'h3><?php echo $BL['be_cnt_infotext'] ?><' + '/h3' + '>';
                    new_entry += '<' + 'p>';
                    new_entry += '<' + 'textarea name="cimage_freetext[' + entry_number + ']" id="cimage_freetext_' + entry_number + '" style="width:100%"><' + '/textarea>';
                    new_entry += '<' + '/p>';
                    new_entry += '<' + 'div class="barra"></div' + '>';
                    new_entry += '<' + 'h2 class="accordion"><i class="fas fa-sort-down"></i> Links para Páginas</h2' + '>';
                    new_entry += '<' + 'div class="accordion" style="display:block">';
                    new_entry += '<' + 'div class="li-banners">';
                    new_entry += '<' + 'p>';
                    new_entry += '<' + 'strong>Modo<' + '/strong>';
                    new_entry += '<' + 'label class="botoes" for="cimage_url_tipo1_' + entry_number + '">';
                    new_entry += '<' + 'input checked="checked" type="radio" name="cimage_url_tipo[' + entry_number + ']" id="cimage_url_tipo1_' + entry_number + '" value="1">Link';
                    new_entry += '<' + '/label>';
                    new_entry += '<' + 'label class="botoes" for="cimage_url_tipo2_' + entry_number + '">';
                    new_entry += '<' + 'input type="radio" name="cimage_url_tipo[' + entry_number + ']" id="cimage_url_tipo2_' + entry_number + '" value="2">Página do Site';
                    new_entry += '<' + '/label>';
                    new_entry += '<' + '/p>';
                    new_entry += '<' + 'p>';
                    new_entry += '<' + 'span class="url-link">';
                    new_entry += '<' + 'b><?= $BL['be_profile_label_website'] ?>:&nbsp;<' + '/b>';
                    new_entry += '<' + 'input type="text" name="cimage_url[' + entry_number + ']" id="cimage_url_' + entry_number + '" id="v11 w300" size="30" value="">';
                    new_entry += '<' + '/span>';
                    new_entry += '<' + '/p>';
                    new_entry += '<' + 'p>';
                    new_entry += '<' + 'span class="url-pagina">';
                    new_entry += '<' + 'b>Página</b>';
                    new_entry += '<' + 'select name="cimage_url_pag[' + entry_number + ']" id="cimage_url_pag_' + entry_number + '">';
                    new_entry += '<?= get_pages() ?>';
                    new_entry += '<' + '/select>';
                    new_entry += '<' + '/span>';
                    new_entry += '<' + '/p>';
                    new_entry += '<' + 'p>';
                    new_entry += '<' + 'b><?= $BL['be_banner_texto_botao'] ?>:&nbsp;</b>';
                    new_entry += '<' + 'input name="cimage_botao[' + entry_number + ']" type="text" id="cimage_botao_' + entry_number + '" value="">';
                    new_entry += '<' + '/p>';
                    new_entry += '<' + '/div>';
                    new_entry += '<' + '/div>';

//                new_entry += '<' + 'p class="li-opcoes">';
//                new_entry += '<' + 'span>';
//                new_entry += '<' + 'em title="<?= $sort_up_down; ?>" class="handle">&nbsp;<' + '/em>';
//                new_entry += '<' + 'a href="#" onclick="return deleteImgElement(\'image_' + entry_number + '\');"><' + 'img src="img/famfamfam/image_delete.gif" alt="" border=""><' + '/a>';
//                new_entry += '<' + '/span>';
                    new_entry += '<' + '/div>';

                    var new_element = new Element('li', {'id': 'image_' + entry_number, 'class': 'nomove li-banners', 'data-num': entry_number}).inject($('images'), where);
                    new_element.innerHTML = new_entry;
                    window.location.hash = 'image_' + entry_number;
                    return false;
                }
                    
                
                ;
                
                function deleteImgElement(e) 

                    {
                            if (confirm('<?php echo $BL['be_image_delete_js'] ?>')) {
                            $(e).remove();
                    }
                    return false;
            }
                    


            window.addEvent('domready', function () {

                            setCimageCenterInactive();
                    updatePreviewImageAll();

                    new Sortables($('images'), {
                            handles: 'em'
                    });

                });
            
$j().ready(function()
                
                    {

                            $j(document).on('click', 'a.bt-subir', function () {

                        var num = $j(this).parents('li.li-banners').attr('data-num');

                        if (num !== '0') {
                            mover($j(this), 1);
                    } else {
                        return false;
                    }

                });

                $j(document).on('click', 'a.bt-descer', function () {

                    var tot = $j('li.li-banners').length - 1,
                            num = $j(this).parents('li.li-banners').attr('data-num');

                    if (num == tot) {
                        return false;
                    } else {
                        mover($j(this), 2);
                    }

                });

                        })
                    
                    //-->
                    </script>
    </td>
</tr>
