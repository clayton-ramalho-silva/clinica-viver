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
// Be more modern here â€” we start switch to jQuery and overwrite non-used MooTools with jQuery call
initJsAutocompleter();

unset($_SESSION['filebrowser_image_target']);

$template_default['article']['image_default_width'] = isset($template_default['article']['image_default_width']) ? $template_default['article']['image_default_width'] : '';
$template_default['article']['image_default_height'] = isset($template_default['article']['image_default_height']) ? $template_default['article']['image_default_height'] : '';
$template_default['article']['imagelist_default_width'] = isset($template_default['article']['imagelist_default_width']) ? $template_default['article']['imagelist_default_width'] : '';
$template_default['article']['imagelist_default_height'] = isset($template_default['article']['imagelist_default_height']) ? $template_default['article']['imagelist_default_height'] : '';
?>
<form action="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=1&amp;id=<?php echo $article["article_id"] ?>" method="post" name="article" id="article">
    <table width="<?php echo $phpwcms['LarguraInterna']; ?>" border="0" cellpadding="0" cellspacing="0" summary="" class="dados-sumario">
        <tr><td colspan="2" class="title"><?php echo $BL['be_article_estitle'] ?></td></tr>
        <tr>
            <td width="88"><img src="img/leer.gif" alt="" width="88" height="4" /></td>
            <td width="450"><img src="img/leer.gif" alt="" width="450" height="1" /></td>
        </tr>



        <!-- Titulos-->
        <tr>
            <td colspan="2">
                <div class="espacamento"></div>
                <h2>Titulos</h2>


                <p style="display: none">
                    <b><?php echo $BL['be_article_cat'] ?></b>
                    <select name="article_cid" id="article_cid" class="f11b">
                        <?php
                        echo '<option value="0"' . ((!$article["article_catid"]) ? ' selected="selected"' : '') . ">" . $BL['be_admin_struct_index'] . "</option>\n";
                        struct_select_menu(0, 0, $article["article_catid"]);
                        ?>
                    </select>
                </p>

                <p style="display: flex;gap: 10px;align-items: center;">
                    <b><a href="#" id="cat-as-articletitle"><?php echo $BL['be_article_atitle'] ?></a></b>
                    <input name="article_title" type="text" id="article_title"  value="<?php echo html($article["article_title"]) ?>" />
                    <label class="botoes"><input name="article_notitle" id="article_notitle" type="checkbox" value="1" <?php is_checked($article["article_notitle"], 1) ?> /> Esconder Titulo</label>
                </p>

                <p>
                    <b><?php echo $BL['be_article_asubtitle'] ?></b>
                    <input name="article_subtitle" type="text" id="article_subtitle" value="<?php echo html($article["article_subtitle"]) ?>" />
                </p>

            </td>

        </tr>

        <!-- Texto-->
        <tr>
            <td colspan="2">
                <div class="espacamento"></div>
                <h2>Texto de Introdução</h2>
                <div class="espacamento"></div>
            </td>
        </tr>

        <tr>

            <td colspan="2">

                <?php
                $wysiwyg_editor = array(
                    'value' => $article["article_summary"],
                    'field' => 'article_summary',
                    'height2' => '350',
                    'width2' => '"100%"',
                    'rows' => '15',
                    'editor' => $_SESSION["WYSIWYG_EDITOR"],
                    'lang' => 'en'
                );
                include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
                ?></td>
        </tr>


        <!-- Imagem Pagina Lista-->
        <tr>
            <td colspan="2">

                <div class="espacamento"></div>
                <h2>Imagem</h2>
                <div class="bloco-card">

                    <?php
// set default list values
                    if (!isset($article['image']['list_usesummary'])) {
                        $article['image']['list_usesummary'] = 0;
                        $article['image']['list_name'] = '';
                        $article['image']['list_id'] = 0;
                        $article['image']['list_width'] = '';
                        $article['image']['list_height'] = '';
                        $article['image']['list_zoom'] = 0;
                        $article['image']['list_caption'] = '';
                    }
                    ?>
                    <h3><?php echo $BL['be_article_forlist'] ?></h3>
                    <p> 

                        <label for="cimage_usesummary" class="botoes">
                            <input name="cimage_usesummary" type="checkbox" id="cimage_usesummary" value="1" <?php is_checked(1, $article['image']['list_usesummary']); ?> />
                            <?php echo $BL['be_cnt_same_as_summary'] ?></label>
                    </p>

                    <?php
                    $_SESSION['image_browser_article'] = 1;

                    $thumb_image = false;
                    if (!empty($article["image"]["list_hash"])) {
                        $thumb_image = get_cached_image(array(
                            "target_ext" => $article['image']['list_ext'],
                            "image_name" => $article['image']['list_hash'] . '.' . $article['image']['list_ext'],
                            "thumb_name" => md5($article['image']['list_hash'] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
                        ));
                    }
                    if ($thumb_image != false) {

                        $val_width2 = empty($article['image']['list_width']) ? $template_default['article']['imagelist_default_width'] : $article['image']['list_width'];
                        $val_height2 = empty($article['image']['list_height']) ? $template_default['article']['imagelist_default_height'] : $article['image']['list_height'];
                        echo '<div class="bloco-imagem">'
                        . '<figure><img src="' . PHPWCMS_IMAGES . $thumb_image[0] . '" border="0" ' . $thumb_image[3] . ' alt="" /></figure>'
                        . '<span><strong>Dimensões da Imagem (px) </strong><p> <b>' . $BL['be_cnt_maxw'] . '</b> '
                        . '<input name="cimage_list_width" type="text" id="cimage_list" size="4" maxlength="4" onkeyup="if (!parseInt(this.value))this.value = \'\';+" value="' . $val_width2 . ' " />'
                        . '</p>'
                        . '<p><b>' . $BL['be_cnt_maxh'] . '</b> '
                        . '<input name="cimage_list_height" type="text" id="cimage_list_height" size="4" maxlength="4" onkeyup="if (!parseInt(this.value)) onkeyup="if (!parseInt(this.value)) this.value = \'\';+" value="' . $val_height2 . ' " />'
                        . '</p></span>'
                        . '</div>';
                    } else {
                        echo '';
                    }
                    ?>

                    <p>
                        <span class="botoes-subir-img">

                            <a class="botoes bt-imagem" href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=0&amp;target=list');
                                    return false;"><i class="far fa-images"></i> Escolher Imagem</a>

                            <a class="botoes bt-delete" href="#" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="document.article.cimage_list_name.value = '';
                                    document.article.cimage_list_id.value = '0';
                                    this.blur();
                                    return false;"><i class="far fa-trash-alt"></i></a>
                        </span>
                    </p>
                    <p>

                        <b>Nome da Imagem</b>
                        <input name="cimage_list_name" type="text" id="cimage_list_name" value="<?php echo html($article['image']['list_name']) ?>" size="40" maxlength="250" onfocus="this.blur()" />

                        <input name="cimage_list_id" type="hidden" value="<?php echo $article['image']['list_id'] ?>" />
                    </p>



<!--                <p>
                    <b><?php echo $BL['be_cnt_caption'] ?></b>
                    <textarea name="cimage_list_caption" cols="30" rows="3" class="f11" id="cimage_list_caption"><?php echo html($article['image']['list_caption']) ?></textarea>
                    <span class="caption width300">
                    <?php echo $BL['be_cnt_caption']; ?> | <?php echo $BL['be_caption_alt']; ?> | <?php echo $BL['be_admin_page_link']; ?> <em><?php echo $BL['be_cnt_target']; ?></em> | <?php echo $BL['be_caption_title']; ?> | <?php echo $BL['be_copyright']; ?> </span>
                </p>

                <p>
                    <input name="cimage_list_zoom" type="checkbox" id="cimage_list_zoom" value="1" <?php is_checked(1, $article['image']['list_zoom']); ?> />
                    <label for="cimage_list_zoom">&nbsp;<?php echo $BL['be_cnt_enlarge'] ?></label>

                </p>

                <p>
                    <input name="cimage_list_lightbox" type="checkbox" id="cimage_list_lightbox" value="1" <?php is_checked(1, empty($article['image']['list_lightbox']) ? 0 : 1); ?> onchange="if (this.checked) {
                                getObjectById('cimage_list_zoom').checked = true;
                            }" />
                    <label for="cimage_list_lightbox">&nbsp;<?php echo $BL['be_cnt_lightbox'] ?></label>
                </p>-->
                </div>
            </td>
        </tr>


        <!-- Imagem Pagina completa -->

        <tr>
            <td colspan="2">


                <div class="bloco-card">


                    <h3><?php echo $BL['be_article_forfull'] ?></h3>

                    <?php
                    $_SESSION['image_browser_article'] = 1;

                    $thumb_image = false;
                    if (!empty($article["image"]["hash"])) {
                        $thumb_image = get_cached_image(array(
                            "target_ext" => $article['image']['ext'],
                            "image_name" => $article['image']['hash'] . '.' . $article['image']['ext'],
                            "thumb_name" => md5($article['image']['hash'] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
                        ));
                    }
                    if ($thumb_image != false) {

                        $val_width = empty($article['image']['width']) ? $template_default['article']['image_default_width'] : $article['image']['width'];
                        $val_height = empty($article['image']['height']) ? $template_default['article']['image_default_height'] : $article['image']['height'];


                        echo '<div class="bloco-imagem">'
                        . '<figure><img src="' . PHPWCMS_IMAGES . $thumb_image[0] . '" border="0" ' . $thumb_image[3] . ' alt="" /></figure>'
                        . '<span><strong>Dimensões da Imagem (px) </strong><p> <b>' . $BL['be_cnt_maxw'] . '</b> '
                        . '<input name="cimage_width" type="text" id="cimage_width" size="4" maxlength="4" onkeyup="if (!parseInt(this.value)) this.value = \'\';+" value="' . $val_width . '" /> '
                        . '</p>'
                        . '<p><b>' . $BL['be_cnt_maxh'] . '</b> '
                        . '<input name="cimage_height" type="text" id="cimage_height" size="4" maxlength="4" onkeyup="if (!parseInt(this.value)) this.value = \'\';+" value="' . $val_height . '" /> '
                        . '</p></span>'
                        . '</div>';
                    } else {
                        echo '';
                    }
                    ?>

                    <p>
                        <span class="botoes-subir-img">
                            <a class="botoes bt-imagem" href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=0&amp;target=summary');
                                    return false;"><i class="far fa-images"></i> Escolher Imagem</a>

                            <a class="botoes bt-delete" href="#" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="document.article.cimage_name.value = '';
                                    document.article.cimage_id.value = '0';
                                    this.blur();
                                    return false;"><i class="far fa-trash-alt"></i></a>
                        </span>

                    </p>

                    <p>
                        <b>Nome da Imagem</b>
                        <input name="cimage_name" type="text" id="cimage_name" style="color: #727889;" value="<?php echo html($article['image']['name']) ?>" size="40" maxlength="250" onfocus="this.blur()" />

                        <input name="cimage_id" type="hidden" value="<?php echo $article['image']['id'] ?>" />
                    </p>





<!--                <p>
                    <b><?php echo $BL['be_cnt_caption'] ?></b>

                    <textarea name="cimage_caption" cols="30" rows="3" class="f11" id="cimage_caption"><?php echo html($article['image']['caption']) ?></textarea>
                    <span class="caption">
                    <?php echo $BL['be_cnt_caption']; ?> | <?php echo $BL['be_caption_alt']; ?> | <?php echo $BL['be_admin_page_link']; ?> <em><?php echo $BL['be_cnt_target']; ?></em> | <?php echo $BL['be_caption_title']; ?> | <?php echo $BL['be_copyright']; ?>
                    </span>
                </p>

                <p>
                    <input name="cimage_zoom" type="checkbox" id="cimage_zoom" value="1" <?php is_checked(1, $article['image']['zoom']); ?> />
                    <label for="cimage_zoom">&nbsp;<?php echo $BL['be_cnt_enlarge'] ?></label>
                </p>

                <p>
                    <input name="cimage_lightbox" type="checkbox" id="cimage_lightbox" value="1" <?php is_checked(1, empty($article['image']['lightbox']) ? 0 : 1); ?> onchange="if (this.checked) {
                                getObjectById('cimage_zoom').checked = true;
                            }" />
                    <label for="cimage_lightbox"><?php echo $BL['be_cnt_lightbox'] ?></label>
                </p>-->
                </div>
            </td>
        </tr>






        <!-- Aparencia-->    

        <tr>
            <td colspan="2">

                <div class="barra"></div>
                <h2>Aparência</h2>

                <div class="grid-3">
                    <p>
                        <b><?php echo $BL['be_article_forlist'] ?></b>
                        <select name="article_tmpllist" id="article_tmpllist">
                            <?php
// templates for article listing
                            $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/articlesummary/list');
                            if ($article['image']['tmpllist'] == 'default') {
                                $vals = ' selected="selected"';
                            } else {
                                $vals = '';
                            }
                            echo '<option value="default"' . $vals . '>' . $BL['be_cnt_default'] . "</option>\n";
                            if (count($tmpllist)) {
                                foreach ($tmpllist as $val) {
                                    $vals = '';
                                    if ($val == $article['image']['tmpllist'])
                                        $vals = ' selected="selected"';
                                    $val = htmlspecialchars($val);
                                    echo '<option value="' . $val . '"' . $vals . '>' . $val . "</option>\n";
                                }
                            }
                            ?>
                        </select>
                    </p>

                    <p>
                        <b><?php echo $BL['be_article_forfull'] ?></b>
                        <select name="article_tmplfull" id="article_tmplfull" >
                            <?php
// templates for full article
                            $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/articlesummary/article');
                            if ($article['image']['tmplfull'] == 'default')
                                $vals = ' selected="selected"';
                            echo '<option value="default"' . $vals . '>' . $BL['be_cnt_default'] . "</option>\n";
                            if (count($tmpllist)) {
                                foreach ($tmpllist as $val) {
                                    $vals = '';
                                    if ($val == $article['image']['tmplfull'])
                                        $vals = ' selected="selected"';
                                    $val = htmlspecialchars($val);
                                    echo '<option value="' . $val . '"' . $vals . '>' . $val . "</option>\n";
                                }
                            }
                            ?>
                        </select>
                    </p>

                    <p>
                        <b><?php echo $BL['be_cnt_results_wordlimit'] ?></b>
                        <input name="article_listmaxwords" type="text" id="article_listmaxwords" value="<?php echo empty($article['image']['list_maxwords']) ? '' : intval($article['image']['list_maxwords']) ?>" size="10" maxlength="6" />
                    </p>
                </div>

                <p style="display:none"> 
                    <label class="botoes">
                        <input name="article_hidesummary" type="checkbox" id="article_hidesummary" value="1"<?php is_checked(1, $article["article_hidesummary"]); ?> />
                        <?php echo $BL['be_article_nosummary'] ?>
                    </label>                    


                </p>
                <input name="article_morelink" type="hidden" id="article_morelink" value="1">
                <!--                <p style="display:none">
                                    <label class="botoes">
                                        <input name="article_morelink" type="checkbox" id="article_morelink" value="1"<?php is_checked(1, $article['article_morelink']); ?> />
                <?php echo $BL['be_article_morelink'] ?>
                                    </label>
                                </p>-->

                <p style="display:none">
                    <label class="botoes">
                        <input name="article_noteaser" type="checkbox" id="article_noteaser" value="1"<?php is_checked(1, $article['article_noteaser']); ?> />
                        <?php echo $BL['be_article_noteaser'] ?>
                    </label>
                </p>

                <p style="display:none">
                    <label class="botoes">
                        <input name="article_paginate" type="checkbox" id="article_paginate" value="1"<?php is_checked(1, $article["article_paginate"]); ?> />
                        <?php echo $BL['be_cnt_pagination'] ?>
                    </label>
                </p>

            </td>

        </tr>



        <!-- Outras ConfiguraçÕes -->
<!--        <tr>
            <td colspan="2">
                <div class="barra"></div>
                <h2>Outros</h2>

                <p>
                    <b><?php echo $BL['be_cnt_sortvalue'] ?></b>
                    <input name="article_sort" type="text" id="article_sort" value="<?php echo empty($article["article_sort"]) ? 0 : intval($article["article_sort"]) ?>" maxlength="10" onkeyup="if (!parseInt(this.value))
                                this.value = '0';" />
                </p>

                <p>
                    <b><?php echo $BL['be_priorize'] ?></b>
                    <select name="article_priorize" id="article_priorize">

        <?php
        for ($x = 30; $x >= -30; $x--) {

            echo '	<option value="' . $x . '"';
            is_selected($x, $article["article_priorize"]);
            echo '>' . ( $x == 0 ? $BL['be_cnt_default'] : $x ) . '</option>' . LF;
        }
        ?>
                    </select>
                </p>


                <p>
                    <b><?php echo $BL['be_alias_articleID'] ?></b>
                    <input name="article_aliasid" type="text" id="article_aliasid" value="<?php echo $article["article_aliasid"] ? $article["article_aliasid"] : ''; ?>"/>
                </p>

                <p>
                    <input name="article_headerdata" id="article_headerdata" type="checkbox" value="1" <?php is_checked($article["article_headerdata"], 1) ?> />
                    <label for="article_headerdata">&nbsp;<?php echo $BL['be_alias_useAll'] ?></label>
                </p>


        <?php if (count($phpwcms['allowed_lang']) > 1): ?>


                                <div style="margin:0;border:1px solid #D9DEE3;padding:5px;float:left;" class="lang-select">
            <?php echo $BL['be_profile_label_lang'] ?>

                                    <ul>
                                        <li><label><input type="radio" name="article_lang" class="lang-default" value=""<?php is_checked('', $article['article_lang']); ?> />
                                                <img src="img/famfamfam/lang/<?php echo $phpwcms['default_lang'] ?>.png" title="<?php echo get_language_name($phpwcms['default_lang']) . ' (' . $BL['be_admin_tmpl_default'] . ')' ?>" /><?php echo ' (' . $BL['be_admin_tmpl_default'] . ')' ?>
                                                &nbsp;
                                            </label>
                                        </li>


            <?php
            foreach ($phpwcms['allowed_lang'] as $key => $lang):

                $lang = strtolower($lang);

                if ($lang == $phpwcms['default_lang']) {
                    continue;
                }
                ?>
                                                        <li><label><input type="radio" name="article_lang" value="<?php echo $lang ?>"<?php is_checked($lang, $article['article_lang']) ?> class="lang-opt" />
                                                                <img src="img/famfamfam/lang/<?php echo $lang ?>.png" title="<?php echo get_language_name($lang) ?>" />
                                                                &nbsp;
                                                            </label>
                                                        </li>

            <?php endforeach; ?>

                                    </ul>


                                    <div style="margin:5px 0 0 0;border-top:1px solid #D9DEE3;padding-top:5px;<?php if ($article['article_lang'] == ''): ?>display:none;<?php endif; ?>" id="lang-id-select">
                                        <label><input type="radio" name="article_lang_type" value="category"<?php is_checked('category', $article['article_lang_type']); ?> /> <?php echo $BL['be_article_cat'] ?> ID</label>
                                        &nbsp;
                                        <label><input type="radio" name="article_lang_type" value="article"<?php is_checked('article', $article['article_lang_type']); ?> /><?php echo $BL['be_cnt_articles'] ?> ID</label>
                                        &nbsp;
                                        <img src="img/famfamfam/lang/<?php echo $phpwcms['default_lang'] ?>.png" title="<?php echo get_language_name($phpwcms['default_lang']) . ' (' . $BL['be_admin_tmpl_default'] . ')' ?>" />&nbsp;
                                        <input name="article_lang_id" type="text" class="f11b width75" value="<?php echo $article['article_lang_id'] ? $article['article_lang_id'] : ''; ?>" size="11" maxlength="11" />
                                    </div>

                                </div>

        <?php endif; ?>

            </td>
        </tr>-->

        <!-- links -->
        <tr>
            <td colspan="2">
                <div class="barra"></div>
                <h2>Links</h2>

                <p>
                    <b><?php echo $BL['be_article_aredirect'] ?></b>
                    <input name="article_redirect" type="text" id="article_redirect" class="f11" value="<?php echo html($article["article_redirect"]) ?>" size="40" />
                </p>

                <p>
                    <b>
                        <a href="#" onclick="return set_article_alias();"><?php echo $BL['be_article_urlalias'] ?></a>&nbsp;|&nbsp;
                        (+<a href="#" id="struct_alias"><?php echo $BL['be_admin_struct_title'] ?></a>)
                    </b>
                    <input name="article_alias" type="text" class="f11b" id="article_alias" value="<?php echo html($article["article_alias"]) ?>" size="40" maxlength="230"<?php if (empty($phpwcms['allow_empty_alias'])): ?> onfocus="set_article_alias(true);"<?php endif; ?> onchange="this.value = create_alias(this.value);" />
                </p>
            </td>
        </tr>



        <!-- SEO-->    
        <tr>
            <td colspan="2">

                <div class="barra"></div>

                <h2 class="accordion"><i class="fas fa-sort-down"></i> SEO</h2>
                <div class="accordion">
                    <p>
                        <b><?php echo $BL['be_admin_page_pagetitle'] ?></b>
                        <input name="article_pagetitle" type="text" id="article_pagetitle" class="f11" value="<?php echo html($article['article_pagetitle']) ?>" size="40" maxlength="125" />
                    </p>

                    <p>
                        <b><?php echo $BL['article_menu_title'] ?></b>
                        <input name="article_menutitle" type="text" id="article_menutitle" value="<?php echo html($article["article_menutitle"]) ?>" size="40" />
                    </p>

                    <p>
                        <b><?php echo $BL['be_article_akeywords'] ?></b>
                        <input type="text" id="article_keyword_autosuggest" /><input type="hidden" name="article_keyword" id="article_keyword" value="<?php echo html($article["article_keyword"]) ?>" />
                    </p>

                    <p>
                        <b><?php echo $BL['be_cnt_description'] ?></b>
                        <textarea name="article_description" rows="2" class="f11" id="article_description"><?php echo html($article["article_description"]) ?></textarea>
                    </p>

                    <p>
                        <label class="botoes" for="article_nositemap"><input name="article_nositemap" type="checkbox" id="article_nositemap" value="1"<?php is_checked(1, $article["article_nositemap"]); ?> />&nbsp;<?php echo $BL['be_ctype_sitemap'] ?></label>
                    </p>
                </div>
            </td>
        </tr>

        <!-- Agendar -->

        <tr>
            <td colspan="2">

                <h2 class="accordion"><i class="fas fa-sort-down"></i> Agendar </h2>
                <div class="accordion">
                    <ul class="grid-3">
                        <li>
                            <p>
                                <label class="botoes">
                                    <input name="set_begin" type="checkbox" id="set_begin" value="1"<?php is_checked(1, $set_begin) ?> onclick="if (!this.checked) {
                                                document.article.article_begin.value = '';
                                            } else {
                                                document.article.article_begin.value = '<?php echo $article["article_begin"] ?>';
                                            }" />
                                           <?php echo $BL['be_article_abegin'] ?>
                                </label>
                            </p>

                            <p>

                                <b>AAAA-MM-DD HH:MM:SS</b>
                                <input name="article_begin" type="text" id="article_begin" value="<?php echo $article["article_begin"] ?>" />

                                <script type="text/javascript">
                                    function aBegin(date, month, year) {
                                        document.article.article_begin.value = year + '-' + subrstr('00' + month, 2) + '-' + subrstr('00' + date, 2) + ' 00:00:00';
                                        document.article.set_begin.checked = true;
                                    }
                                    calBegin = new dynCalendar('calBegin', 'aBegin', 'img/dynCal/');
                                    calBegin.setMonthCombo(false);
                                    calBegin.setYearCombo(false);
                                </script>
                            </p>
                        </li>

                        <li>
                            <p>
                                <label class="botoes">
                                    <input name="set_end" type="checkbox" id="set_end" value="1"<?php is_checked(1, $set_end) ?> onclick="if (!this.checked) {
                                                document.article.article_end.value = '';
                                            } else {
                                                document.article.article_end.value = '<?php echo $article["article_end"] ?>';
                                            }" />
                                           <?php echo $BL['be_article_aend'] ?>
                                </label>
                            </p>

                            <p>
                                <b>AAAA-MM-DD HH:MM:SS</b>
                                <input name="article_end" type="text" id="article_end" value="<?php echo $article["article_end"] ?>" />
                                <script type="text/javascript">
                                    function aEnd(date, month, year) {
                                        document.article.article_end.value = year + '-' + subrstr('00' + month, 2) + '-' + subrstr('00' + date, 2) + ' 23:59:59';
                                        document.article.set_end.checked = true;
                                    }
                                    calEnd = new dynCalendar('calEnd', 'aEnd', 'img/dynCal/');
                                    calEnd.setMonthCombo(false);
                                    calEnd.setYearCombo(false);
                                </script>
                            </p>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>



        <!-- Configuracoes Administrador-->

<!--        <tr>
            <td colspan="2">

        <?php
        if ($_SESSION["wcs_user_admin"]) {
            ?>

                                <div class="barra"></div>
                                <h2><?php echo $BL['be_article_adminuser'] ?></h2>
                                <p>
                                    <b><?php echo $BL['be_article_articleowner'] ?></b>
                                    <select name="article_uid" id="article_uid">
            <?php
            $u_sql = "SELECT usr_id, usr_name, usr_login, usr_admin FROM " . DB_PREPEND . "phpwcms_user WHERE usr_aktiv=1 ORDER BY usr_admin DESC, usr_name";
            if ($u_result = mysql_query($u_sql, $db)) {
                while ($u_row = mysql_fetch_row($u_result)) {
                    echo '<option value="' . $u_row[0] . '"';
                    if ($u_row[0] == $article["article_uid"])
                        echo ' selected';
                    if (intval($u_row[3]))
                        echo ' style="background-color: #FFC299;"';
                    echo '>' . html(($u_row[1]) ? $u_row[1] : $u_row[2]) . '</option>' . "\n";
                }
                mysql_free_result($u_result);
            }
            ?>
                                    </select>
                                </p>

                                <p>

                                </p>

            <?php
        }
        ?>

                <p>
                    <b><?php echo $BL['be_article_username'] ?></b>
                    <input name="article_username" type="text" id="article_username" value="<?php echo html($article["article_username"]) ?>" size="40" maxlength="100" />
                </p>
            </td>
        </tr>-->

        <!-- Cache -->

<!--        <tr>
            <td colspan="2">


                <div class="barra"></div>
                <h2><?php echo $BL['be_cache'] ?></h2>
                <p class="inactive">

                    <label class="botoes" for="article_cacheoff">
                        <input name="article_cacheoff" type="checkbox" id="article_cacheoff" value="1" <?php echo "checked"; ?> />
        <?php echo $BL['be_off'] ?>
                    </label>
                </p>

                <p>
                    <b><?php echo $BL['be_cache_timeout'] ?></b>
                    <select name="article_timeout" class="f11" style="margin:1px;" onchange="document.article.article_cacheoff.checked = false;">
        <?php
        echo '<option value=" ">' . $BL['be_admin_tmpl_default'] . "</option>\n";
        echo '<option value="60"' . is_selected($article["article_timeout"], '60', 0, 0) . '>&nbsp;&nbsp;1 ' . $BL['be_date_minute'] . "</option>\n";
        echo '<option value="300"' . is_selected($article["article_timeout"], '300', 0, 0) . '>&nbsp;&nbsp;5 ' . $BL['be_date_minutes'] . "</option>\n";
        echo '<option value="900"' . is_selected($article["article_timeout"], '900', 0, 0) . '>15 ' . $BL['be_date_minutes'] . "</option>\n";
        echo '<option value="1800"' . is_selected($article["article_timeout"], '1800', 0, 0) . '>30 ' . $BL['be_date_minutes'] . "</option>\n";
        echo '<option value="3600"' . is_selected($article["article_timeout"], '3600', 0, 0) . '>&nbsp;&nbsp;1 ' . $BL['be_date_hour'] . "</option>\n";
        echo '<option value="14400"' . is_selected($article["article_timeout"], '14400', 0, 0) . '>&nbsp;&nbsp;4 ' . $BL['be_date_hours'] . "</option>\n";
        echo '<option value="43200"' . is_selected($article["article_timeout"], '43200', 0, 0) . '>12 ' . $BL['be_date_hours'] . "</option>\n";
        echo '<option value="86400"' . is_selected($article["article_timeout"], '86400', 0, 0) . '>&nbsp;&nbsp;1 ' . $BL['be_date_day'] . "</option>\n";
        echo '<option value="172800"' . is_selected($article["article_timeout"], '172800', 0, 0) . '>&nbsp;&nbsp;2 ' . $BL['be_date_days'] . "</option>\n";
        echo '<option value="604800"' . is_selected($article["article_timeout"], '604800', 0, 0) . '>&nbsp;&nbsp;1 ' . $BL['be_date_week'] . "</option>\n";
        echo '<option value="1209600"' . is_selected($article["article_timeout"], '1209600', 0, 0) . '>&nbsp;&nbsp;2 ' . $BL['be_date_weeks'] . "</option>\n";
        echo '<option value="2592000"' . is_selected($article["article_timeout"], '2592000', 0, 0) . '>&nbsp;&nbsp;1 ' . $BL['be_date_month'] . "</option>\n";
        ?>
                    </select>
                </p>
            </td>
        </tr>-->

        <!-- Status -->

        <tr style="display:none">
            <td colspan="2">
                <div class="barra"></div>
                <h2> <?php echo $BL['be_ftptakeover_status'] ?></h2>

<!--                <p>
                    <label class="botoes" for="article_nositemap"><input name="article_nositemap" type="checkbox" id="article_nositemap" value="1"<?php is_checked(1, $article["article_nositemap"]); ?> />&nbsp;<?php echo $BL['be_ctype_sitemap'] ?></label>
                </p>-->

                <p>
                    <label class="botoes" for="article_nosearch"><input name="article_nosearch" type="checkbox" id="article_nosearch" value="1" <?php is_checked(1, $article['article_nosearch']); ?> />&nbsp;<?php echo $BL['be_no_search'] ?></label>
                </p>

                <p>
                    <label class="botoes" for="article_norss"><input name="article_norss" type="checkbox" id="article_norss" value="1" <?php is_checked(1, $article['article_norss']); ?> />&nbsp;<?php echo $BL['be_no_rss'] ?></label>
                </p>

                <p>
                    <?php
                    if (!isset($_POST['article_title']) && empty($article["article_id"]) && defined('ACAT_OPENGRAPH_STATUS') && ACAT_OPENGRAPH_STATUS === false) {
                        $article['article_opengraph'] = 0;
                    }
                    ?>
                    <label class="botoes" for="article_opengraph"><input name="article_opengraph" type="checkbox" id="article_opengraph" value="1" <?php is_checked(1, $article['article_opengraph']); ?> />&nbsp;<?php echo $BL['be_opengraph_support'] ?></label>
                    &nbsp;
                </p>



<!--                <p>
                    <label class="botoes" for="article_archive"><input name="article_archive" type="checkbox" id="article_archive" value="1" <?php is_checked(1, $article['article_archive_status']); ?> />&nbsp;<?php echo $BL['be_show_archived'] ?></label>
                </p>-->

                <?php if (isset($article["article_date"])) { ?>
                    <p class="ultima-atualizacao"><?php echo $BL['be_article_eslastedit'] ?>:
                        <?php
                        echo (empty($_POST["article_update"]) || !intval($_POST["article_update"])) ? $article["article_date"] : $BL['be_article_esnoupdate'];
                        ?>
                    </p>
                <?php } ?>

            </td>

        </tr>







        <tr>
            <td colspan="2">
                <div class="controles-salvar">
                    <section>
                        <div class="botoes-salvar-wrap">
                            <input name="updatesubmit" type="submit" class="button10" value="<?php echo $article["article_id"] ? $BL['be_article_cnt_button1'] : $BL['be_article_cnt_button2'] ?>" />
                            <input name="Submit" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
                            <input name="donotsubmit" type="submit" class="button10" value="<?php echo $BL['be_newsletter_button_cancel'] ?>" onclick="return cancelEdit();" />
                        </div>

                        <label class="botoes" for="article_aktiv"><input name="article_aktiv" type="checkbox" id="article_aktiv" value="1"<?php is_checked(1, $article["article_aktiv"]); ?> />&nbsp;<?php echo $BL['be_admin_struct_visible'] ?></label>
                    </section>
                    <input name="article_update" type="hidden" id="article_update" value="1" />
                </div>

            </td>
        </tr>

    </table>
</form>

<script type="text/javascript">
    $(function () {

        $("#article_keyword_autosuggest").autoSuggest('<?php echo PHPWCMS_URL ?>include/inc_act/ajax_connector.php', {
            selectedItemProp: "cat_name",
            selectedValuesProp: 'cat_name',
            searchObjProps: "cat_name",
            queryParam: 'value',
            extraParams: '&method=json&action=category',
            startText: '',
            preFill: $("#article_keyword").val(),
            neverSubmit: true,
            asHtmlID: 'keyword-autosuggest'
        });

        $('#article').submit(function () {
            $("#article_keyword").val($('#as-values-keyword-autosuggest').val());
        });

        // Handle language switch click
        var langIdSelect = $('#lang-id-select');

        $('input.lang-opt').change(function () {
            langIdSelect.show();
        });

        $('input.lang-default').change(function () {
            langIdSelect.hide();
        });

        $('#struct_alias').click(function () {
            var struct = '<?php echo get_struct_alias($article["article_catid"]) ?>' || $('#article_cid option:selected').text();
            var title = $('#article_title').val().trim();
            var alias = $('#article_alias');

            if (struct.length) {
                struct = struct.replace(/^-+/gi, '').trim();

                if (title) {
                    struct += '<?php if ($phpwcms['alias_allow_slash']): ?>/<?php else: ?>-<?php endif; ?>' + title;
                                    }
                                }
                                ;

                                alias.val(create_alias(struct));
                            });

                            $('#cat-as-articletitle').click(function (evnt) {
                                evnt.preventDefault();
                                var currentCat = $('#article_cid option:selected').text();
                                if (currentCat) {
                                    $('#article_title').val(currentCat.replace(/^-+ /, ''));
                                }
                            });
                        });

                        function cancelEdit() {
                            document.location.href = 'phpwcms.php?do=articles<?php echo $article["article_id"] ? '&p=2&s=1&id=' . $article["article_id"] : '' ?>';
                            return false;
                        }

//                        $('h2.accordion').click(function () {
//                            $(this).parent().find('div.accordion').slideToggle("fast");
//                            $(this).toggleClass("on");
//                        });

</script>