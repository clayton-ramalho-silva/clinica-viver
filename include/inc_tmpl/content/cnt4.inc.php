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
// Tabs

initMootools();

// set default values
if (empty($content['tabs']) || !is_array($content['tabs'])) {
    $content['tabs'] = array();
}
$content['tabwysiwygoff'] = empty($content['tabs']['tabwysiwygoff']) ? 0 : 1;
unset($content['tabs']['tabwysiwygoff']);

// check which WYSIWYG editor to load
// only FCKeditor is supported here
// or WYSIWYG disabled
if (!empty($_SESSION["WYSIWYG_EDITOR"]) && !$content['tabwysiwygoff']) {

    $BE['HEADER']['ckeditor.js'] = getJavaScriptSourceLink('include/inc_ext/ckeditor/ckeditor.js');
    $content['wysiwyg'] = true;
} else {

    $content['wysiwyg'] = false;
}
?>

<style>
.li-tab{
    display: inline-block;
    width: 100%;
}
</style>

<tr>
    <td colspan="2">
        <div class="espacamento"></div>
        <span class="btn_add_tab bt-add-tab" id="btn_add_tab">
            <i class="fas fa-folder-plus"></i>
            <?php echo $BL['be_tab_add'] ?>
        </span>

<!--        <p>
            <label class="botoes" for="tabwysiwygoff"><input type="checkbox" name="tabwysiwygoff" id="tabwysiwygoff" value="1"<?php is_checked(1, $content['tabwysiwygoff']) ?> /> <?php echo $BL['be_cnt_no_wysiwyg_editor'] ?></label>
        </p>-->
    </td>
</tr>

<tr>
    <td colspan="2"><ul id="tabs">

            <?php
// Sort/Up Down Title
            $x = 0;
            $sort_up_down = $BL['be_func_struct_sort_up'] . ' / ' . $BL['be_func_struct_sort_down'];

            foreach ($content['tabs'] as $key => $value) {
                ?>

                <li id="tab<?php echo $key ?>" class="li-tab" data-num="<?php echo $x ?>">
                    <div class="espacamento"></div>
                    <div class="controle-posicoes">
                        <span>
                            <!--<em title="<?= $sort_up_down; ?>" class="handle">&nbsp;</em>-->
                            <a class="botoes bt-subir" href="#"><i class="fas fa-arrow-up"></i> Subir</a>
                            <a class="botoes  bt-descer" href="#"><i class="fas fa-arrow-down"></i> Descer</a>


                            <!--<em class="handle" title="<?php echo $sort_up_down; ?>">&nbsp;</em>-->
                            <a class="botoes" href="#" onclick="return deleteTab('tab<?php echo $key ?>');"><i class="fas fa-times"></i> Excluir Bloco</a>
                        </span>
                    </div>
                    <div class="bloco-tabs bloco-card">
                        <h3>Bloco de Texto</h3>
                        <p>
                            <b>Titulo</b>
                            <!--<b><?php echo $BL['be_tab_name'] ?></b>-->
                            <input type="text" name="tabtitle[<?php echo $key ?>]" id="tabtitle<?php echo $key ?>" value="<?php echo html($value['tabtitle']) ?>"  />
                        </p>

                        <p>
                            <b>Subtitulo</b>
                                <!--<b><?php echo $BL['be_headline'] ?></b>-->
                            <input type="text" name="tabheadline[<?php echo $key ?>]" id="tabheadline<?php echo $key ?>" value="<?php echo html($value['tabheadline']) ?>" />
                        </p>

                        <p>
                            <textarea class="width540 v12" name="tabtext[<?php echo $key ?>]" id="tabtext<?php echo $key ?>" rows="10"><?php echo html($value['tabtext']) ?></textarea>
                        </p>
                    </div>

                    <div class="barra"></div>
                </li>

                <?php
                $x++;
            }
            ?>

        </ul></td>
</tr>

<tr>
    <td colspan="2">
        <script type="text/javascript">

        function mover(botao, tipo){

            var div    = botao.parents('li.li-tab'),
                id1    = div.attr('id').split('_'),
                ordem1 = div.attr('data-num'),
                prox   = (tipo === 1) ? div.prev('li.li-tab') : div.next('li.li-tab'),
                id2    = prox.attr('id'),
                ordem2 = prox.attr('data-num');

            if(id2){

                if(tipo === 1){

                    div.attr('data-num', parseInt(ordem1) - 1);
                    prox.attr('data-num', parseInt(ordem2) + 1);

                } else {

                    div.attr('data-num', parseInt(ordem1) + 1);
                    prox.attr('data-num', parseInt(ordem2) - 1);

                }

                CKEDITOR.instances['tabtext'+id1[1]].destroy(true)

                if(tipo === 1){
                    $j(div).insertBefore(prox);
                } else {
                    $j(div).insertAfter(prox);
                }

                CKEDITOR.replace('tabtext'+id1[1], {
                    width: '100%',
                    height: '400px',
                    toolbarStartupExpanded: false,
                });

                console.dir("#tab"+id1[1]);

                $j([document.documentElement, document.body]).animate({
                    scrollTop: $j(document).find("#tab"+id1[1]).offset().top - 50
                }, 700);

            }

        }

        var entries = 0;

        window.addEvent('domready', function () {

            entries = $('tabs').getChildren().length;

            $('btn_add_tab').addEvent('click', function (event) {
                event = new Event(event).stop();

                var entry = '';
                entry += '<div class="controle-posicoes"><span>';
                entry += '<a class="botoes bt-subir" href="#"><i class="fas fa-arrow-up"></i> Subir</a>';
                entry += '<a class="botoes bt-descer" href="#"><i class="fas fa-arrow-down"></i> Descer</a>';
                entry += '<a class="botoes href="#" onclick="return deleteTab(\'tab' + entries + '\');"><i class="fas fa-times"></i> Excluir Bloco<' + '/a>';
                entry += '</span></div>';
                entry += '<div class="bloco-tabs bloco-card">';
                entry += '<h3>Bloco de Texto</h3>';
                entry += '<p><b>Titulo</b>';
                entry += '<input type="text" name="tabtitle[' + entries + ']" id="tabtitle' + entries + '" value="" /' + '>';
                entry += '</p>';
                entry += '<p>';
                entry += '<b>Subtitulo</b>';
                entry += '<input type="text" name="tabheadline[' + entries + ']" id="tabheadline' + entries + '" value="" /' + '>';
                entry += '</p>';
                entry += '<p>';
                entry += '<textarea name="tabtext[' + entries + ']" id="tabtext' + entries + '" rows="10" class="width540 v12">';
                entry += '<' + '/textarea>';
                entry += '</p>';
                entry += '</div>';
                //entry += '<tr><td class="chatlist col1w" align="right"><?php echo $BL['be_tab_name'] ?>:&nbsp;<' + '/td>';
                //entry += '<td class="tdbottom2"><' + '/td>';
                //entry += '<td><' + '/td><' + '/tr>';
                //entry += '<tr><td class="chatlist col1w" align="right"><?php echo $BL['be_headline'] ?>:&nbsp;<' + '/td>';
                //entry += '<td colspan="2"><' + '/td><' + '/tr>';
                //entry += '<tr><td colspan="3" class="tdtop5">';
                entry += '';

                var tab = new Element('li', {'id': 'tab' + entries, 'class': 'tab nomove li-tab', 'data-num': entries}).setHTML(entry).injectInside($('tabs'));

<?php if ($content['wysiwyg']): ?>			EnableCKEditor(entries);<?php endif; ?>

                window.scrollTo(0, tab.getCoordinates()['top']);

                entries++;
            });

<?php if ($content['wysiwyg']): ?>
                if (entries > 0) {
                    for (x = 0; x < entries; x++) {
                        EnableCKEditor(x);
                    }
                }
<?php endif; ?>

            var s = new Sortables($('tabs'), {handles: 'em'});
        });

<?php
if ($content['wysiwyg']):

    // CKEditor Tabs configuration
    $content['ckconfig'] = array();

    if (isset($_SESSION["wcs_user_lang"])) {
        $content['ckconfig'][] = "language: '" . $_SESSION["wcs_user_lang"] . "'";
    }
    if (is_file(PHPWCMS_TEMPLATE . 'config/ckeditor/ckeditor.config-tabs.js')) {
        $content['ckconfig'][] = 'customConfig: "' . PHPWCMS_URL . TEMPLATE_PATH . 'config/ckeditor/ckeditor.config-tabs.js"';
    } else {
        $content['ckconfig'][] = "				toolbar: [
                                    {name: 'tools', items: ['Maximize', '-', 'Source', '-', 'Undo', 'Redo', '-', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Find', '-', 'ShowBlocks']},
                                    {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                                    {name: 'colors', items: ['TextColor', 'BGColor']},
                                    {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                                    {name: 'paragraph', groups: ['align', 'list', 'indent', 'blocks'], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BulletedList', 'NumberedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv']},
                                    {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Iframe', 'SpecialChar']},
                                    {name: 'styles', items: ['Styles', 'Format', 'Font']},
                                    {name: 'about', items: ['About']}
                            ]";

        $content['ckconfig'][] = "width: '100%'";
        $content['ckconfig'][] = 'height: 200';
        $content['ckconfig'][] = "extraPlugins: 'magicline'";
        $content['ckconfig'][] = 'toolbarCanCollapse: true';
        $content['ckconfig'][] = 'toolbarStartupExpanded: false';
        $content['ckconfig'][] = 'forcePasteAsPlainText: true';
        $content['ckconfig'][] = 'pasteFromWordRemoveFontStyles: true';
        $content['ckconfig'][] = 'pasteFromWordRemoveStyles: true';
        $content['ckconfig'][] = 'pasteFromWordPromptCleanup: true';
    }
    if (!empty($GLOBALS['phpwcms']['FCK_FileBrowser'])) {
        $content['ckconfig'][] = 'filebrowserBrowseUrl: "' . PHPWCMS_URL . 'filebrowser.php?opt=16"';
        $content['ckconfig'][] = 'filebrowserImageBrowseUrl: "' . PHPWCMS_URL . 'filebrowser.php?opt=17"';
        $content['ckconfig'][] = 'filebrowserWindowWidth: 640';
        $content['ckconfig'][] = 'filebrowserWindowHeight: 480';
    }

    $content['ckconfig'] = ', {' . LF . implode(',' . LF . '				', $content['ckconfig']) . LF . '			}';
    ?>
            function EnableCKEditor(x) {
                if ($('tabtext' + x)) {
                    CKEDITOR.replace('tabtext' + x<?php echo $content['ckconfig'] ?>);
                }
            }
<?php endif; ?>

        function deleteTab(e) {
            if (confirm('<?php echo $BL['be_tab_delete_js'] ?>')) {
                $(e).remove();
            }
            return false;
        }

        $j().ready(function(){

            $j(document).on('click', 'a.bt-subir', function () {

                var num = $j(this).parents('li.li-tab').attr('data-num');

                if(num !== '0'){
                    mover($j(this), 1);
                } else {
                    return false;
                }

            });

            $j(document).on('click', 'a.bt-descer', function () {

                var tot = $j('li.li-tab').length - 1,
                    num = $j(this).parents('li.li-tab').attr('data-num');

                if(num == tot){
                    return false;
                } else {
                    mover($j(this), 2);
                }

            });

        })

        </script>
    </td>
</tr>

<tr>
    <td colspan="2">


        <h2>Aparência</h2>
        <p>
            <b><?php echo $BL['be_admin_struct_template']; ?></b>
            <select name="template" id="template">
                <?php
                echo '<option value="">' . $BL['be_admin_tmpl_default'] . '</option>' . LF;

                $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/blocotexto');
                if (is_array($tmpllist) && count($tmpllist)) {
                    foreach ($tmpllist as $val) {
                        $selected_val = (isset($content["tabs_template"]) && $val == $content["tabs_template"]) ? ' selected="selected"' : '';
                        $val = html($val);
                        echo '	<option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
                    }
                }
                ?>
            </select>
        </p>
    </td>
</tr>