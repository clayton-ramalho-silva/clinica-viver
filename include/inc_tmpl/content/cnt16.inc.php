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
    'tempo' => 0,
    'images' => array()
);

$content['image_special'] = isset($content['image_special']) ? array_merge($content['image_default'], $content['image_special']) : $content['image_default'];
?>

<tr style="display: none;">
    <td colspan="2">
        <p>
            <b><?= $BL['be_admin_struct_template']; ?>:&nbsp;</b>
            <select name="template" id="template">
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
    </td>
</tr>




<tr>
    <td colspan="2" >
        <div class="espacamento"></div>
        <!--        <div class="barra"></div>
                <h2>Imagens</h2>-->

        <span id="add-top" class="btn_image_add banner-add add-top"><i class="fas fa-folder-plus"></i> Novo Bloco de Imagem</span>
    </td>
</tr>

<tr>
    <td colspan="2">

        <ul id="images">

            <?php
// Sort/Up Down Title
            $sort_up_down = $BL['be_func_struct_sort_up'] . ' / ' . $BL['be_func_struct_sort_down'];

// loop available image entries
            foreach ($content['image_special']['images'] as $key => $value) {
                ?>

                <li id="image_<?= $key ?>" class="li-banners">

                <div class="controle-banner">
                    <span>
                        <!--<em title="<?= $sort_up_down; ?>" class="handle">&nbsp;</em>-->
                        <a class="botoes bt-subir" href="#"><i class="fas fa-arrow-up"></i> Subir</a>
                        <a class="botoes  bt-descer" href="#"><i class="fas fa-arrow-down"></i> Descer</a>
                        <a class="botoes" href="#" onclick="return deleteImgElement('image_<?= $key ?>');"><i class="fas fa-times"></i> Excluir Bloco</a>
                    </span>
                </div>
                    
                    <div id="accordion" class="bloco-card">
                        <input name="cimage_id_thumb[<?= $key ?>]" id="cimage_id_thumb_<?= $key ?>" type="hidden" value="<?= $value['thumb_id'] ?>">
                        <input name="cimage_sort[<?= $key ?>]" id="cimage_sort_<?= $key ?>" type="hidden" value="<?= $value['sort'] ?>">

                        <h3>Imagem</h3>

                        <span class="bloco-img-banner">
                            <figure id="img_preview_<?= $key ?>" class="backend_preview_img"></figure>

                            <span >
                                <p class="botoes-subir-img" style="margin:0">
                                    <a class="botoes bt-imagem" href="#" title="<?= $BL['be_cnt_openimagebrowser'] ?>" onclick="return openImageFileBrowser('thumb_<?= $key ?>');">
                                        <i class="far fa-images"></i> Escolher Imagem
                                    </a>

                                    <a class="botoes bt-delete" href="#" title="<?= $BL['be_cnt_delimage'] ?>" onclick="return deleteImageData('thumb_<?= $key ?>', this);">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </p>

                                <p>
                                    <b>Nome da Imagem</b>
                                    <input name="cimage_name_thumb[<?= $key ?>]" type="text" id="cimage_name_thumb_<?= $key ?>" class="imagename" value="<?= html($value['thumb_name']) ?>" size="30" onfocus="this.blur();">
                                </p>
                            </span>
                        </span>


                        <div class="espacamento"></div>

                            <h3>Título do Banner</h3>
                            <p>

                                <?php
                                $wysiwyg_editor = array(
                                    'value' => empty($value['caption']) ? '' : $value['caption'],
                                    'field' => 'cimage_caption[' . $key . ']',
                                    'height2' => '80',
                                    'width2' => '"100%"',
                                    'rows' => '2',
                                    'editor' => $_SESSION["WYSIWYG_EDITOR"],
                                    'lang' => 'en',
                                    'expanded' => '0'
                                );
                                include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
                                ?>

                            </p>


                            <div class="espacamento"></div>
                            <h3>Subtítulo do Banner</h3>
                            <p>

                                <?php
                                $wysiwyg_editor = array(
                                    'value' => empty($value['freetext']) ? '' : $value['freetext'],
                                    'field' => 'cimage_freetext[' . $key . ']',
                                    'height2' => '80',
                                    'width2' => '"100%"',
                                    'rows' => '2',
                                    'editor' => $_SESSION["WYSIWYG_EDITOR"],
                                    'lang' => 'en',
                                    'expanded' => '0'
                                );
                                include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
                                ?>
                            </p>

                        <div class="barra"></div>
                        <h2 class="accordion"><i class="fas fa-sort-down"></i> Links para Páginas</h2>
<div class="accordion">
                        <div class="li-banners">
                            <p>
                                <strong>Modo</strong>
                                <label class="botoes" for="cimage_url_tipo1_<?= $key ?>">
                                    <input type="radio" name="cimage_url_tipo[<?= $key ?>]" id="cimage_url_tipo1_<?= $key ?>" value="1"<?php is_checked(1, $value['tipo']); ?> onClick="hide_show('link-<?= $key ?>', 'pagina-<?= $key ?>')">Link
                                </label>

                                <label class="botoes" for="cimage_url_tipo2_<?= $key ?>">
                                    <input type="radio" name="cimage_url_tipo[<?= $key ?>]" id="cimage_url_tipo2_<?= $key ?>" value="2"<?php is_checked(2, $value['tipo']); ?> onClick="hide_show('pagina-<?= $key ?>', 'link-<?= $key ?>')">Página do Site
                                </label>

                            </p>

                            <p>



                                <span class="url-link" id="link-<?= $key ?>"<?= $value['tipo'] === '1' ? '' : ' style="display: none"' ?>>
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
                </div>
                    
                    <div class="espacamento"></div>

             

            </li>

                <?php
            }
// close image entry looping
            ?>

        </ul>

    </td>
</tr>

<?php
// second button to add images at bottom of list
//if (count($content['image_special']['images'])){
?>

<tr>
    <td colspan="2">
        <div class="espacamento"></div>
        <span id="add-bottom" class="btn_image_add banner-add add-bottom"><i class="fas fa-folder-plus"></i> Novo Bloco de Imagem</span>
    </td>

</tr>
<?php
//}
?>
<!--<tr>
    <td colspan="2" class="rowspacer0x10">
        <img src="img/leer.gif" alt="" width="1" height="1" />
    </td>
</tr>-->

<!--<tr><td colspan="2" align="center"><?php
$wysiwyg_editor = array(
    'value' => isset($content["image_html"]) ? $content["image_html"] : '',
    'field' => 'image_html',
    'height' => '300px',
    'width' => '536px',
    'rows' => '15',
    'editor' => $_SESSION["WYSIWYG_EDITOR"],
    'lang' => 'en'
);

include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
?></td></tr>-->

<tr>
    <td colspan="2">
        <script type="text/javascript" src="include/inc_ext/ckeditor/ckeditor.js"></script>
        <script>
        // document.getElementById("add-top").addEventListener("click", function () {
        //     return addNewImage('top');
        // });
        // document.getElementById("add-bottom").addEventListener("click", function () {
        //     return addNewImage('bottom');
        // });
        document.getElementById("add-top").addEventListener("click", function () {
            return addNewImage('top');
        });
        document.getElementById("add-bottom").addEventListener("click", function () {
            return addNewImage('bottom');
        });
        var site_url = '<?= PHPWCMS_URL; ?>';
        var max_img_w = <?= $phpwcms['img_list_width']; ?>;
        var max_img_h = <?= $phpwcms['img_list_height']; ?>;
        var image_entry = new Array();
        var urlLink = document.getElementById('cimage_url_tipo1');
        var urlPag = document.getElementById('cimage_url_tipo2');

        function hide_show(campo, select) {
            document.getElementById(campo).style.display = 'block';
            document.getElementById(select).style.display = 'none';
        }

        function setCimageCenterInactive() {
            var cih = $('cimage_width');
            var ciw = $('cimage_height');
            //var cic = $('cimage_center');
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
                //cic.disabled = true;
                ccp.disabled = true;
            } else {
                //cic.disabled = false;
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
            /*
                if($('cimage_id_zoom_'+image_number)) {
                var image_file_id = $('cimage_id_zoom_'+image_number).value;
                preview += getBackendImgSrc( image_file_id );
                }
                */
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

            var num = image_entry.length;

            var new_entry = '';

              new_entry += '<' + 'div class="controle-banner">';
            new_entry += '<' + 'span>';
            // new_entry += '<' + 'em title="<?= $sort_up_down; ?>" class="handle">&nbsp;<' + '/em>';
            new_entry += '<' + 'a class="botoes bt-subir" href="#"><i class="fas fa-arrow-up"></i> Subir</a>';
            new_entry += '<' + 'a class="botoes bt-descer" href="#"><i class="fas fa-arrow-up"></i> Descer</a>';
            new_entry += '<' + 'a class="botoes" href="#" onclick="return deleteImgElement(\'image_'+num+'\');" style="margin: 0"><i class="fas fa-times"></i> Excluir Bloco<' + '/a>';
            new_entry += '<' + '/span>';
            new_entry += '<' + '/div>';
            new_entry += '<' + 'div id="accordion" class="bloco-card">';
            new_entry += '<' + 'input name="cimage_id_thumb['+num+']" id="cimage_id_thumb_'+num+'" type="hidden" value="" /' + '>';
            new_entry += '<' + 'input name="cimage_sort['+num+']" id="cimage_sort_'+num+'" type="hidden" value="'+num+'" /' + '>';
            new_entry += '<' + 'h3>Imagem<' + '/h3' + '>';
            new_entry += '<' + 'span class="bloco-img-banner"' + '>';
            new_entry += '<' + 'figure id="img_preview_'+num+'" class="backend_preview_img"></figure' + '>';
            new_entry += '<' + 'span' + '>';
            new_entry += '<' + 'p class="botoes-subir-img" style="margin:0"' + '>';
            new_entry += '<' + 'a class="botoes bt-imagem" href="#" title="<?= $BL['be_cnt_openimagebrowser'] ?>" onclick="return openImageFileBrowser(\'thumb_'+num+'\');"><i class="far fa-images"></i> Escolher Imagem<' + '/a>';
            new_entry += '<' + 'a class="botoes bt-delete" href="#" title="<?= $BL['be_cnt_delimage'] ?>" onclick="return deleteImageData(\'thumb_'+num+'\', this);"><i class="far fa-trash-alt"></i><' + '/a>';
            new_entry += '<' + '/p' + '>';
            new_entry += '<' + 'p' + '>';
            new_entry += '<' + 'b>Nome da Imagem</b' + '>';
            new_entry += '<' + 'input name="cimage_name_thumb['+num+']" type="text" id="cimage_name_thumb_'+num+'" class="imagename" value="" size="30" onfocus="this.blur();"' + '>';
            new_entry += '<' + 'span id="img_preview_'+num+'" class="backend_preview_img"></span' + '>';
            new_entry += '<' + '/p' + '>';
            new_entry += '<' + '/span' + '>';
            new_entry += '<' + '/span' + '>';
            new_entry += '<' + 'div class="espacamento"></div' + '>';
            new_entry += '<' + 'h3>Título do Banner<' + '/h3' + '>';
            new_entry += '<' + 'p' + '>';
            new_entry += '<' + 'textarea name="cimage_caption['+num+']" id="cimage_caption['+num+']"><' + '/textarea>';
            //new_entry += '<span class="caption"><?= $BL['be_cnt_caption']; ?> | <?= $BL['be_caption_alt']; ?> | <?= $BL['be_admin_page_link']; ?> <em><?= $BL['be_cnt_target']; ?></em> | <?= $BL['be_caption_title']; ?> | <?= $BL['be_copyright']; ?></span>';
            new_entry += '<' + '/p>';
            new_entry += '<' + 'div class="espacamento"></div' + '>';
            new_entry += '<' + 'h3>Subtítulo do Banner<' + '/h3' + '>';
            new_entry += '<' + 'p>';
            new_entry += '<' + 'textarea name="cimage_freetext['+num+']" id="cimage_freetext['+num+']"><' + '/textarea>';
            new_entry += '<' + '/p>';
            new_entry += '<' + 'div class="barra"></div' + '>';
            new_entry += '<' + 'h2 class="accordion"><i class="fas fa-sort-down"></i> Links para Páginas</h2' + '>';
            new_entry += '<' + 'div class="accordion">';
            new_entry += '<' + 'div class="li-banners">';
            new_entry += '<' + 'p>';
            new_entry += '<' + 'strong>Modo<' + '/strong>';
            new_entry += '<' + 'label class="botoes" for="cimage_url_tipo1_'+num+'">';
            new_entry += '<' + 'input checked="checked" type="radio" name="cimage_url_tipo['+num+']" id="cimage_url_tipo1_'+num+'" value="1" onClick="hide_show(\'link-'+num+'\', \'pagina-'+num+'\')">Link';
            new_entry += '<' + '/label>';
            new_entry += '<' + 'label class="botoes" for="cimage_url_tipo2_'+num+'">';
            new_entry += '<' + 'input type="radio" name="cimage_url_tipo['+num+']" id="cimage_url_tipo2_'+num+'" value="2" onClick="hide_show(\'pagina-'+num+'\', \'link-'+num+'\')">Página do Site';
            new_entry += '<' + '/label>';
            new_entry += '<' + '/p>';
            new_entry += '<' + 'p>';
            new_entry += '<' + 'span class="url-link" id="link-'+num+'">';
            new_entry += '<' + 'b><?= $BL['be_profile_label_website'] ?></b>';
            new_entry += '<' + 'input type="text" name="cimage_url['+num+']" id="cimage_url_'+num+'">';
            new_entry += '<' + '/span>';
            new_entry += '<' + 'span class="url-pagina" id="pagina-'+num+'" style="display: none">';
            new_entry += '<' + 'b>Página</b>';
            new_entry += '<' + 'select name="cimage_url_pag['+num+']" id="cimage_url_pag_'+num+'">';
            new_entry += '<?= get_pages() ?>';
            new_entry += '<' + '/select>';
            new_entry += '<' + '/span>';
            new_entry += '<' + '/p>';
            new_entry += '<' + 'p>';
            new_entry += '<' + 'b><?= $BL['be_banner_texto_botao'] ?>:&nbsp;</b>';
            new_entry += '<' + 'input name="cimage_botao['+num+']" type="text" id="cimage_botao_'+num+'" value="">';
            new_entry += '<' + '/p>';
            new_entry += '<' + '/div>';
            new_entry += '<' + '/div>';
            new_entry += '<' + '/div>';
          
            new_entry += '<' + '/li>';

            var new_element = new Element('li', {'id': 'image_' + num, 'class': 'nomove li-banners'}).inject($('images'), where);
            new_element.innerHTML = new_entry;
            window.location.hash = 'image_' + num;

            CKEDITOR.replace('cimage_caption['+num+']', {
                width: '100%',
                height: '80',
                toolbarStartupExpanded: false,
            });

            CKEDITOR.replace('cimage_freetext['+num+']', {
                width: '100%',
                height: '80',
                toolbarStartupExpanded: false,
            });

            return false;
        }
        ;

        function deleteImgElement(e) {
            if (confirm('<?= $BL['be_image_delete_js'] ?>')) {
                $(e).remove();
            }
            return false;
        }

        window.addEvent('domready', function () {

            setCimageCenterInactive();
            updatePreviewImageAll();

            new Sortables($('images'), {
                handles: 'em.handle'
            });

        });
        </script>
    </td>
</tr>

    <tr>
        <td colspan="2">
            <h2>Configurações Gerais</h2>

            <p>
                <strong>Dimensões da Imagem (px) </strong>
            </p>

            <div class="grid-4">
                <p>
                    <b><?= $BL['be_cnt_maxw'] ?></b>
                    <input name="cimage_width" type="text" id="cimage_width" onkeyup="setCimageCenterInactive();" value="<?= $content['image_special']['width']; ?>">
                </p>

                <p>
                    <b><?= $BL['be_cnt_maxh'] ?></b>
                    <input name="cimage_height" type="text" id="cimage_height" onkeyup="setCimageCenterInactive();" value="<?= $content['image_special']['height']; ?>">
                </p>
                <p>
                    <label for="cimage_crop" class="botoes">
                        <input type="checkbox" name="cimage_crop" id="cimage_crop" value="1" <?php is_checked(1, $content['image_special']['crop']); ?>>
                        <?= $BL['be_image_crop'] ?>
                    </label>
                </p>

                <p>
                    <b><?= $BL['be_banner_tempo'] ?></b>
                    <input name="cimage_tempo" type="text" id="cimage_tempo" value="<?= $content['image_special']['tempo']; ?>"></p>
            </div>

            <script>
            function mover(botao, tipo){

                var div    = botao.parents('li.li-banners'),
                    id1    = div.attr('id').split('_'),
                    input1 = div.find('input[name^=cimage_sort]'),
                    ordem1 = input1.val(),
                    prox   = (tipo === 1) ? div.prev('li.li-banners') : div.next('li.li-banners'),
                    id2    = prox.attr('id'),
                    input2 = prox.find('input[name^=cimage_sort]'),
                    ordem2 = input2.val();

                if(id2){

                    // Ordenação
                    input1.val(parseInt(ordem1) - 1);
                    input2.val(parseInt(ordem2) + 1);

                    // Destroi o ckeditor antigo
                    CKEDITOR.instances['cimage_caption['+id1[1]+']'].destroy(true);
                    CKEDITOR.instances['cimage_freetext['+id1[1]+']'].destroy(true)

                    if(tipo === 1){
                        $j(div).insertBefore(prox);
                    } else {
                        $j(div).insertAfter(prox);
                    }

                    // CKEditor
                    CKEDITOR.replace('cimage_caption['+id1[1]+']', {
                        width: '100%',
                        height: '150px',
                        toolbarStartupExpanded: true,
                    });

                    CKEDITOR.replace('cimage_freetext['+id1[1]+']', {
                        width: '100%',
                        height: '400px',
                        toolbarStartupExpanded: false,
                    });

                    $j([document.documentElement, document.body]).animate({
                        scrollTop: $j(document).find("#image_"+id1[1]).offset().top
                    }, 700);

                }

            }


            $j().ready(function(){

//                $j(document).on('click', 'h2.accordion', function () {
//                    $j(this).parent().find('div.accordion').slideToggle("fast");
//                    $j(this).toggleClass("on");
//                });

                $j(document).on('click', 'a.bt-subir', function () {
                    mover($j(this), 1);
                });

                $j(document).on('click', 'a.bt-descer', function () {
                    mover($j(this), 2);
                });

            })
            </script>
        </td>
    </tr>