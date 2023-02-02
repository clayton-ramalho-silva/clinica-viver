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
//image with text


$template_default['article']['image_default_width'] = isset($template_default['article']['image_default_width']) ? $template_default['article']['image_default_width'] : '';
$template_default['article']['image_default_height'] = isset($template_default['article']['image_default_height']) ? $template_default['article']['image_default_height'] : '';

if (empty($content['cimage']['cimage_crop'])) {
    $content['cimage']['cimage_crop'] = 0;
}
?>
<!--<tr><td colspan="2" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>-->





<tr>
    <td colspan="2">
        <div class="espacamento"></div>
        <!--<h2><?php echo $BL['be_cnt_htmltext'] ?></h2>-->
        <h2>Texto</h2>
        <div class="espacamento"></div>
    </td>
</tr>
<!--<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>-->
<tr>
    <td colspan="2" align="center">
        <?php
        $wysiwyg_editor = array(
            'value' => isset($content["text"]) ? $content["text"] : '',
            'field' => 'ctext',
            'height2' => '400',
            'width2' => '"100%"',
            'rows' => '15',
            'editor' => $_SESSION["WYSIWYG_EDITOR"],
            'lang' => 'en'
        );

        include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
        ?>
    </td>
</tr>

<tr>
    <td colspan="2">
        <div class="espacamento"></div>
        <h2>Imagem</h2>
        <div class="bloco-card">
            <h3><?php echo $BL['be_cnt_image'] ?></h3>
            <p class="botoes-subir-img">
                <a class="botoes bt-imagem" href="javascript:;" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=0&amp;target=nolist')"><i class="far fa-images"></i> Escolher Imagem</a>
                <a class="botoes bt-delete" href="javascript:;" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="document.articlecontent.cimage_name.value = ''; document.articlecontent.cimage_id.value = '0'; this.blur(); return false;"><i class="far fa-trash-alt"></i></a>
            </p>
            <p>
                <b>Nome da Imagem</b>
                <input name="cimage_name" type="text" id="cimage_name" class="f11b" style="width: 300px; color: #727889;" value="<?php echo isset($content["image_name"]) ? html($content["image_name"]) : '' ?>" size="40" maxlength="250" onfocus="this.blur()" />
            </p>


            <?php
            if (isset($content["image_hash"])) {

                $thumb_image = get_cached_image(array(
                    "target_ext" => $content["image_ext"],
                    "image_name" => $content["image_hash"] . '.' . $content["image_ext"],
                    "thumb_name" => md5($content["image_hash"] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
                ));

                if ($thumb_image != false) {

                    $val_width2 = empty($content["image_width"]) ? $template_default['article']['image_default_width'] : $content["image_width"];
                    $val_height2 = empty($content["image_height"]) ? $template_default['article']['image_default_height'] : $content["image_height"];


                    echo '<div class="bloco-imagem">'
                    . '<figure><img src="' . PHPWCMS_IMAGES . $thumb_image[0] . '" border="0" ' . $thumb_image[3] . '></figure>'
                    . '<span><strong>Dimensões da Imagem (px) </strong><p> <b>' . $BL['be_cnt_maxw'] . '</b> '
                    . '<input name="cimage_width" type="text" id="cimage_width" size="4" maxlength="4" onkeyup="if (!parseInt(this.value))this.value = \'\';+" value="' . $val_width2 . ' " />'
                    . '</p>'
                    . '<p><b>' . $BL['be_cnt_maxh'] . '</b> '
                    . '<input name="cimage_height" type="text" id="cimage_height" size="4" maxlength="4" onkeyup="if (!parseInt(this.value)) onkeyup="if (!parseInt(this.value)) this.value = \'\';+" value="' . $val_height2 . ' " />'
                    . '</p>'
                    . '<div class="espacamento"></div>'
                    . '<label for="cimage_crop" class="botoes"><input type="checkbox" name="cimage_crop" id="cimage_crop" value="1" ' . is_checked(1, $content['cimage']['cimage_crop'], 0, 0) . '/> ' . $BL['be_image_crop'] . ' </label>'
                    . '</span></div>';
                }
            }
            ?>







        </div>

        <input name="cimage_id" type="hidden" value="<?php echo isset($content["image_id"]) ? $content["image_id"] : '' ?>" />

        <div class="bloco-card">
            <h3>Posição do Texto e Imagem</h3>
            <p>
                <b><?php echo $BL['be_cnt_position'] ?></b>
                <select name="cimage_pos" class="f10" id="cimage_pos" onchange="changeImagePosMenu();">
                    <option value="0" <?php
                    if (!isset($content["image_pos"]))
                        $content["image_pos"] = 0;

                    is_selected(0, $content["image_pos"])
                    ?>><?php echo $BL['be_cnt_pos0'] ?></option>
                    <option value="1" <?php is_selected(1, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos1'] ?></option>
                    <option value="2" <?php is_selected(2, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos2'] ?></option>
                    <option value="3" <?php is_selected(3, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos3'] ?></option>
                    <option value="4" <?php is_selected(4, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos4'] ?></option>
                    <option value="5" <?php is_selected(5, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos5'] ?></option>
                    <option value="6" <?php is_selected(6, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos6'] ?></option>
                    <option value="7" <?php is_selected(7, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos7'] ?></option>
                    <option value="8" <?php is_selected(8, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos8'] ?></option>
                    <option value="9" <?php is_selected(9, $content["image_pos"]) ?>><?php echo $BL['be_cnt_pos9'] ?></option>
                </select>
            </p>


            <ul class="posicao-texto">

                <li>
                    <a href="javascript:;" onclick="changeImagePos(0); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos0i'] ?>"<?php echo ($content["image_pos"] == 0) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos0.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    <a href="javascript:;" onclick="changeImagePos(1); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos1i'] ?>"<?php echo ($content["image_pos"] == 1) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos1.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    <a href="javascript:;" onclick="changeImagePos(2); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos2i'] ?>"<?php echo ($content["image_pos"] == 2) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos2.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(3); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos3i'] ?>"<?php echo ($content["image_pos"] == 3) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos3.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(4); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos4i'] ?>"<?php echo ($content["image_pos"] == 4) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos4.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(5); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos5i'] ?>"<?php echo ($content["image_pos"] == 5) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos5.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(6); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos6i'] ?>"<?php echo ($content["image_pos"] == 6) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos6.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(7); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos7i'] ?>"<?php echo ($content["image_pos"] == 7) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos7.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(8); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos8i'] ?>"<?php echo ($content["image_pos"] == 8) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos8.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>

                <li>
                    
                    <a href="javascript:;" onclick="changeImagePos(9); this.blur(); return false;" title="<?php echo $BL['be_cnt_pos9i'] ?>"<?php echo ($content["image_pos"] == 9) ? ' class="ativo"' : '' ?>>
                        <img src="img/button/pos9.png" alt="" width="50" height="45" border="0" />
                    </a>
                </li>
            </ul>

            <script type="text/javascript">
                <!--
                        changeImagePos(<?php echo intval($content["image_pos"]); ?>);
                //-->
                </script>

                </div>

                <!--
                    <h2><?php echo $BL['be_cnt_behavior'] ?></h2>
                    <p>
        <label for="cimage_zoom" class="botoes">
                   <input name="cimage_zoom" type="checkbox" id="cimage_zoom" value="1" <?php is_checked(1, empty($content["image_zoom"]) ? 0 : 1); ?> />
    <?php echo $BL['be_cnt_enlarge'] ?>
</label>
</p>

<p>
                <label for="cimage_lightbox" class="botoes">
    <input name="cimage_lightbox" type="checkbox" id="cimage_lightbox" value="1" <?php is_checked(1, empty($content['cimage']['cimage_lightbox']) ? 0 : 1); ?> onchange="if (this.checked) {
                        getObjectById('cimage_zoom').checked = tr
                ue;
            }" />
    <?php echo $BL['be_cnt_lightbox'] ?>
            </label>
            </p>

                                       <p>
            <label for="cimage_nocaption" class="botoes">
       <    input name="cimage_nocaption" type="checkbox" id="cimage_nocaption" value="1" <?php is_checked(1, empty($content['cimage']['cimage_nocaption']) ? 0 : 1); ?> />
    <?php echo $BL['be_cnt_imglist_nocaption'] ?>
        </label>
    </p>

                <p>
<b><?php echo $BL['be_cnt_caption'] ?></b>
    <textarea name="cimage_caption" cols="30" rows="4" class="f11 width300" id="cimage_caption"><?php
    if (isset($content["image_caption"])) {
        echo html($content["image_caption"]);
    }
    ?></textarea>
            
            <span>
    <?php echo $BL['be_cnt_caption']; ?>
                |
    <?php echo $BL['be_caption_alt']; ?>
                |
    <?php echo $BL['be_admin_page_link']; ?> <em><?php echo $BL['be_cnt_target']; ?></em>
                |
    <?php echo $BL['be_caption_title']; ?>
                |
    <?php echo $BL['be_copyright']; ?>
                </span>
                </p>-->
                
                </td>
                        </tr>

                        <tr>
                <td colspan="2">
                <div class="barra"></div>
                <h2>Aparência</h2>
                <p>
                <b>
                <?php echo $BL['be_admin_struct_template']; ?>
            </b>
                <select name="template" id="template" class="f11b">
                <?php
                echo '<option value="">' . $BL['be_admin_tmpl_default'] . '</option>' . LF;

// templates for frontend login
                $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/imagetext');
                if (is_array($tmpllist) && count($tmpllist)) {
                    foreach ($tmpllist as $val) {
                        $selected_val = (isset($content["template"]) && $val == $content["template"]) ? ' selected="selected"' : '';
                        $val = html($val);
                        echo '	<option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
                    }
                }
                ?>
                </select>
                </p>
                </td>
                </tr>

                        <tr><td colspan="2">
                <div class="barra"></div>
                <h2>Links para Páginas</h2>
            
            <div class="li-banners">
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
                    <b><?= $BL['be_banner_texto_botao'] ?></b>
                    <input name="all_link_botao" type="text" id="all_link_botao" value="<?= html($content['all_link']['botao']) ?>">
                    </p>
                    </div>
                    </td>
                    </tr>
                    
    <script>
                        function hide_show(campo, select) {
                            document.getElementById(campo).style.display = 'block';
                            document.getElementById(select).style.display = 'none';
                        }
                                                                                                                                        </script>
