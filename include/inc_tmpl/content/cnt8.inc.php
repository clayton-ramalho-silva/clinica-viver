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
//link article

if (!isset($content['alink']['alink_id']) && isset($row["acontent_alink"])) {
    $content['alink']['alink_id'] = explode(':', $row["acontent_alink"]);
} elseif (!isset($row["acontent_alink"])) {
    $content['alink']['alink_id'] = array();
}
if (empty($content['alink']['alink_template'])) {
    $content['alink']['alink_template'] = '';
}
if (empty($content['alink']['alink_type'])) {
    $content['alink']['alink_type'] = 0;
}
if (empty($content['alink']['alink_level']) || !is_array($content['alink']['alink_level'])) {
    $content['alink']['alink_level'] = array();
}
if (empty($content['alink']['alink_unique'])) {
    $content['alink']['alink_unique'] = 0;
}
if (!isset($content['alink']['alink_allowedtags'])) {
    $content['alink']['alink_allowedtags'] = '<b><i><u><br><div><a><table><td><tr><img><font><s><strong>';
}
if (empty($content['alink']['alink_crop'])) {
    $content['alink']['alink_crop'] = 0;
}
if (empty($content['alink']['alink_prio'])) {
    $content['alink']['alink_prio'] = 0;
}
if (empty($content['alink']['alink_category']) || !is_array($content['alink']['alink_category'])) {
    $content['alink']['alink_category'] = array();
}
if (empty($content['alink']['alink_category'])) {
    $content['alink']['alink_andor'] = 'OR';
}
if (empty($content['alink']['alink_columns'])) {
    $content['alink']['alink_columns'] = '';
}
if (empty($content['alink']['alink_categoryalias'])) {
    $content['alink']['alink_categoryalias'] = 0;
}
if (empty($content['alink']['alink_hidesummary'])) {
    $content['alink']['alink_hidesummary'] = 0;
}

$BE['HEADER']['contentpart.js'] = getJavaScriptSourceLink('include/inc_js/contentpart.js');

// necessary JavaScript libraries
initMootools();
initMootoolsAutocompleter();
?>


<tr>

    <td colspan="2">
        <div class="espacamento"></div>
        <h2><?= $BL['be_cnt_ecardform_selector'] ?></h2>

        <p>
            <b>Modo</b>
            <select name="calink_type" class="f11b" id="calink_type" onchange="showHide_TeaserArticleSelection(this.options[this.selectedIndex].value)">

                <optgroup label="<?= $BL['be_sorted']; ?>">

                    <option value="0"<?php is_selected(0, $content['alink']['alink_type']) ?>><?= $BL['be_admin_struct_ordermanual'] ?></option>
                    <option value="1"<?php is_selected(1, $content['alink']['alink_type']) ?>><?= $BL['be_admin_struct_orderdate'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="2"<?php is_selected(2, $content['alink']['alink_type']) ?>><?= $BL['be_admin_struct_orderdate'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>
                    <option value="3"<?php is_selected(3, $content['alink']['alink_type']) ?>><?= $BL['be_admin_struct_orderchangedate'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="4"<?php is_selected(4, $content['alink']['alink_type']) ?>><?= $BL['be_admin_struct_orderchangedate'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>
                    <option value="5"<?php is_selected(5, $content['alink']['alink_type']) ?>><?= $BL['be_article_cnt_start'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="6"<?php is_selected(6, $content['alink']['alink_type']) ?>><?= $BL['be_article_cnt_start'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>
                    <option value="7"<?php is_selected(7, $content['alink']['alink_type']) ?>><?= $BL['be_article_cnt_end'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="8"<?php is_selected(8, $content['alink']['alink_type']) ?>><?= $BL['be_article_cnt_end'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>

                    <option value="18"<?php is_selected(18, $content['alink']['alink_type']) ?>><?= $BL['be_article_atitle'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="19"<?php is_selected(19, $content['alink']['alink_type']) ?>><?= $BL['be_article_atitle'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>

                </optgroup>

                <optgroup label="<?= $BL['be_random']; ?>">

                    <option value="9"<?php is_selected(9, $content['alink']['alink_type']) ?>><?= $BL['be_random'] ?></option>

                </optgroup>

                <optgroup label="<?= $BL['be_random'] . ', ' . $BL['be_sorted']; ?>">

                    <option value="10"<?php is_selected(10, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_admin_struct_orderdate'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="11"<?php is_selected(11, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_admin_struct_orderdate'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>
                    <option value="12"<?php is_selected(12, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_admin_struct_orderchangedate'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="13"<?php is_selected(13, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_admin_struct_orderchangedate'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>
                    <option value="14"<?php is_selected(14, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_article_cnt_start'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="15"<?php is_selected(15, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_article_cnt_start'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>
                    <option value="16"<?php is_selected(16, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_article_cnt_end'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="17"<?php is_selected(17, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_article_cnt_end'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>

                    <option value="20"<?php is_selected(20, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_article_atitle'] . ', ' . $BL['be_admin_struct_orderdesc'] ?></option>
                    <option value="21"<?php is_selected(21, $content['alink']['alink_type']) ?>><?= $BL['be_random'] . ', ' . $BL['be_article_atitle'] . ', ' . $BL['be_admin_struct_orderasc'] ?></option>


                </optgroup>

            </select>
        </p>

        <div style="display: none">
            <p bgcolor="#e7e8eb" id="prio0"><input type="checkbox" name="calink_prio" id="calink_prio" value="1"<?php is_checked(1, $content['alink']['alink_prio']) ?> /></p>
            <p bgcolor="#e7e8eb" id="prio1"><label for="calink_prio">&nbsp;<?= $BL['be_use_prio'] ?>&nbsp;&nbsp;</label></p>
        </div>

    </td>
</tr>



<tr id="calink_manual_0"<?php if ($content['alink']['alink_type']) echo ' style="display:none"'; ?>>

    <td colspan="2">
        <div class="espacamento"></div>
        <div class="espacamento"></div>
        <h3>Páginas Selecionadas</h3>
        <p><select name="calink[]" size="8" multiple="multiple" class="f11 listrow" id="calink" ondblclick="moveSelectedOptions(teaser_items, source_items, true);">
                <?php
//Auslesen der kompletten Public Artikel
                $sql = "SELECT article_id, article_title, acat_name, acat_alias, article_cid, article_aktiv ";
                $sql .= "FROM " . DB_PREPEND . "phpwcms_article ar ";
                $sql .= "LEFT JOIN " . DB_PREPEND . "phpwcms_articlecat ac ON ar.article_cid = ac.acat_id ";
                $sql .= "WHERE ar.article_deleted = 0 AND ar.article_noteaser = 0 ";
                $sql .= "GROUP BY ar.article_id, ar.article_title, ac.acat_name ";
                $sql .= "ORDER BY ar.article_title;";

                $carticle_list = '';
                $carticle_link = $content['alink']['alink_id'];
                if ($result = mysqli_query($db, $sql) or die("error while reading complete article/articlecategory list")) {
                    while ($row = mysqli_fetch_row($result)) {
                        $k = 0;
                        $k1 = $BL['be_cnt_sitelevel'] . ': ' . html($row[2]);
                        if (empty($row[4])) {
                            $row[2] = $indexpage['acat_name'];
                            $row[3] = $indexpage['acat_alias'];
                        }
                        $alias_add = ' (' . html($row[2]);
                        if (!empty($row[3])) {
                            $alias_add .= '/' . html($row[3]);
                        }
                        $alias_add .= ')';
                        foreach ($content['alink']['alink_id'] as $key => $value) {

                            if ($row[0] == $value) {
                                $carticle_link[$key] = '	<option value="' . $row[0] . '" title="' . $k1;
                                $carticle_link[$key] .= '">' . html($row[1]) . $alias_add . '</option>' . LF;
                                unset($content['alink']['alink_id'][$key]);
                                $k = 1;
                            }
                        }

                        if (!$k) {
                            $carticle_list .= '	<option value="' . $row[0] . '" title="' . $k1;
                            $carticle_list .= '">' . html($row[1]) . $alias_add . '</option>' . LF;
                        }
                    }
                }

                echo implode(LF, $carticle_link);
                ?>
            </select></p>

        <div class="botoes-controle-paginas controle-lista-paginas">
            <a class="botoes" href="#" title="<?= $BL['be_cnt_sortup'] ?>" onclick="moveOptionUp(teaser_items);return false;"><i class="fas fa-chevron-up"></i></a>

            <a class="botoes" href="#" title="<?= $BL['be_cnt_sortdown'] ?>" onclick="moveOptionDown(teaser_items);return false;"><i class="fas fa-chevron-down"></i></a>

            <a class="botoes" href="#" title="<?= $BL['be_cnt_removearticleto'] ?>" onclick="moveSelectedOptions(teaser_items, source_items, false);return false;"><i class="far fa-trash-alt"></i></a>
        </div>
    </td>
</tr>
<tr id="calink_manual_1"<?php if ($content['alink']['alink_type']) echo ' style="display:none"'; ?>>
    <td colspan="2">

        <h3>Páginas Disponíveis</h3>
        <p>
            <select name="calinklist" size="16" multiple="multiple" class="f11 listrow" id="calinklist" ondblclick="moveSelectedOptions(source_items, teaser_items, false);">
                <?= $carticle_list; ?>
            </select>
        </p>
        <div class="botoes-controle-paginas controle-lista-paginas">
            <a class="botoes" href="#" title="<?= $BL['be_cnt_movearticleto'] ?>" onclick="moveSelectedOptions(source_items, teaser_items, false);return false"><i class="fas fa-angle-double-up"></i> Selecionar Página</a>
        </div>
    </td>
</tr>


<tr id="calink_auto_0"<?php if (!$content['alink']['alink_type']) echo ' style="display:none"'; ?>>

    <td colspan="2">
        <div class="grid-4">
        <p>
            <b>Limite de Páginas</b>
            <input name="calink_max" type="text" id="calink_max" value="<?php
            echo empty($content['alink']['alink_max']) ? '' : $content['alink']['alink_max'];
            ?>" size="5" maxlength="5" />
        </p>
        </div>
    </td>
</tr>

<tr id="calink_auto_1"<?php if (!$content['alink']['alink_type']) echo ' style="display:none"'; ?>>

    <td colspan="2">
        <div class="espacamento"></div>
        <div class="espacamento"></div>
        <h3><?= $BL['be_cnt_sitelevel'] ?></h3>

        <p>
            <select name="calink_level[]" size="15" multiple="multiple" class="f11 optionhover" id="calink_level" >
                <?php
                echo '<option value="0"';
                if (in_array(0, $content['alink']['alink_level'])) {
                    echo ' selected="selected"';
                }
                echo '>' . html($indexpage['acat_name']) . '</option>' . LF;
                struct_select_list(0, 0, $content['alink']['alink_level']);
                ?>
            </select>
        </p>
    </td>
</tr>


<tr>
    <td colspan="2">
<!--        <p>
        <?= $BL['be_article_rendering'] ?>
            <label class="botoes" for="calink_unique"><input type="checkbox" name="calink_unique" id="calink_unique" value="1"<?php is_checked(1, $content['alink']['alink_unique']) ?> /> <?= $BL['be_unique_teaser_entry'] ?> </label>
        </p>-->

<!--        <p>
            <b><?= $BL['be_cnt_column'] ?></b>
            <input name="calink_columns" type="text" id="calink_columns" class="f11b" value="<?= $content['alink']['alink_columns']; ?>" size="3" maxlength="3" />
        </p>-->
<!--
        <p>
            <?= $BL['be_article_morelink'] ?>
            <label class="botoes" for="calink_categoryalias"><input type="checkbox" name="calink_categoryalias" id="calink_categoryalias" value="1"<?php is_checked(1, $content['alink']['alink_categoryalias']) ?> /><?= $BL['be_check_against_category_alias'] ?></label>
        </p>-->




<!--        <p>
            <b><?= $BL['be_tags'] ?></b>
            <input type="text" name="calink_category" id="calink_category" value="<?= html(implode(', ', $content['alink']['alink_category'])) ?>" />
        </p>-->

<!--        <p>
            <select name="calink_andor" id="calink_andor">

                <option value="OR"<?php is_selected('OR', $content['alink']['alink_andor']) ?>><?= $BL['be_fsearch_or'] ?></option>
                <option value="AND"<?php is_selected('AND', $content['alink']['alink_andor']) ?>><?= $BL['be_fsearch_and'] ?></option>
                <option value="NOT"<?php is_selected('NOT', $content['alink']['alink_andor']) ?>><?= $BL['be_fsearch_not'] ?></option>

            </select>
        </p>-->

    </td>
</tr>



<tr><td colspan="2">
        <script type="text/javascript">
            <!--

                window.addEvent('domready', function () {

                /* Autocompleter for categories/tags */
                var searchCategory = $('calink_category');
                var indicator2 = new Element('span', {'class': 'autocompleter-loading', 'styles': {'display': 'none'}}).setHTML('').injectAfter($('calink_andor'));
                var completer2 = new Autocompleter.Ajax.Json(searchCategory, 'include/inc_act/ajax_connector.php', {
                    multi: true,
                    maxChoices: 30,
                    autotrim: true,
                    minLength: 0,
                    allowDupes: false,
                    postData: {action: 'category', method: 'json'},
                    onRequest: function (el) {
                        indicator2.setStyle('display', '');
                    },
                    onComplete: function (el) {
                        indicator2.setStyle('display', 'none');
                    }
                                 });

                });

                var teaser_items = $('calink');
                var source_items = $('calinklist');

    //-->
</script></td></tr>




<tr><td colspan="2">
                <div class="barra"></div>

                <h2>Configurações Gerais</h2>

                <p>
                    <label class="botoes" for="calink_hidesummary"><input name="calink_hidesummary" type="checkbox" id="calink_hidesummary" value="1"<?php is_checked(1, $content['alink']['alink_hidesummary']); ?> /><?= $BL['be_article_nosummary'] ?></label>
                </p>

                <p>
                    <strong>Dimensões da Imagem (px)</strong>
                </p>

                <div class="grid-4">
                    <p>
                        <b><?= $BL['be_cnt_maxw'] ?></b>
                               <input name="calink_width" type="text" class="f11b" id="calink_width" size="4" maxlength="4" onkeyup="if (!parseInt(this.value))
                                    this.value = '';" value="<?= empty($content['alink']['alink_width']) ? '' : $content['alink']['alink_width']; ?>" />
                    </p>

                    <p>
                        <b><?= $BL['be_cnt_maxh'] ?></b>
                               <input name="calink_height" type="text" class="f11b" id="calink_height" size="4" maxlength="4" onkeyup="if (!parseInt(this.value))
                                    this.value = '';" value="<?= empty($content['alink']['alink_height']) ? '' : $content['alink']['alink_height']; ?>" />
                    </p>

                    <p>
                        <label class="botoes" for="calink_crop" class="checkbox">
                            <input type="checkbox" name="calink_crop" id="calink_crop" value="1" <?php is_checked(1, $content['alink']['alink_crop']); ?> />
                            <?= $BL['be_image_crop'] ?>
                        </label>
                    </p>


                    <p>
                        <b><?= $BL['be_cnt_results_wordlimit'] ?> </b>
                        <input name="calink_wordlimit" type="text" id="calink_wordlimit" class="f11b" value="<?php
                        echo empty($content['alink']['alink_wordlimit']) ? '' : $content['alink']['alink_wordlimit'];
                        ?>" size="3" maxlength="5" />
                    </p>

                </div>

                <div class="barra"></div>


                <h2 class="accordion"><i class="fas fa-sort-down"></i> Configurações Avançadas</h2>
                <div class="accordion">
                <p><?= $BL['be_article_paginate'] ?></p>

                <div class="grid-4">
                    <p>
                       <label class="botoes" for="calink_paginate"><input type="checkbox" name="calink_paginate" id="calink_paginate" value="1"<?php is_checked(1, $content['alink']['alink_paginate']) ?> /> <?= $BL['be_paginate_desc'] ?></label>
                    </p>

                    <p>
                        <b><?= $BL['be_paginate_itens'] ?></b>
                        <input name="calink_paginate_itens" type="text" id="calink_paginate_itens" class="f11b" value="<?= $content['alink']['alink_itens']; ?>" size="3" maxlength="3" />
                    </p>
                </div>

                <p>
                    <b><?= $BL['be_allowed_tags'] ?></b>
                    <input name="calink_allowedtags" type="text" id="calink_allowedtags" class="f11b" value="<?= html($content['alink']['alink_allowedtags']); ?>" size="20" />
                </p>
                </div>

                <div class="espacamento"></div>





            <h2>Aparência</h2>
            <p>
                <b><?= $BL['be_admin_struct_template'] ?></b>
                <select name="calink_template" id="calink_template">
                    <?php
                    echo '<option value="">' . $BL['be_admin_tmpl_default'] . ' &lt;ul&gt;&lt;li&gt;</option>' . LF;

// templates for forum
                    $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/teaser');
                    if (is_array($tmpllist) && count($tmpllist)) {
                        foreach ($tmpllist as $val) {
                            // do not show listmode templates
                            if (substr($val, 0, 5) == 'list.') {
                                continue;
                            }
                            $vals = ($val == $content['alink']['alink_template']) ? ' selected="selected"' : '';
                            $val = html($val);
                            echo '<option value="' . $val . '"' . $vals . '>' . $val . "</option>\n";
                        }
                    }
                    ?>
                </select>
            </p>

            <div class="barra"></div>



            <div class="li-banners">
                <h2>Links para Páginas</h2>
                <p>
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
                        <b>Páginas</b>
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
        </td></tr>

    <script>
        function hide_show(campo, select) {
            document.getElementById(campo).style.display = 'block';
            document.getElementById(select).style.display = 'none';
        }
        </script>

