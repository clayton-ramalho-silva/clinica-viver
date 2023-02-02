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
//search form
// necessary JavaScript libraries
initMootools();
initMootoolsAutocompleter();


if (empty($content['search']["text_html"])) {
    $content['search']["text_html"] = 0;
}

$content['search']["search_news"] = empty($content['search']["search_news"]) ? 0 : 1;

if (!isset($content['search']["news_lang"])) {
    $content['search']["news_lang"] = array();
}
if (!isset($content['search']["news_category"])) {
    $content['search']["news_category"] = array();
}
if (!isset($content['search']["news_andor"])) {
    $content['search']["news_andor"] = 'OR';
}
if (empty($content['search']["news_url"])) {
    $content['search']["news_url"] = '';
}
if (empty($content["search"]["hide_summary"])) {
    $content["search"]["hide_summary"] = 0;
}
if (empty($content["search"]["highlight_result"])) {
    $content["search"]["highlight_result"] = 0;
}
if (empty($content["search"]["newwin"])) {
    $content["search"]["newwin"] = 0;
}
if (empty($content["search"]["no_filenames"])) {
    $content["search"]["no_filenames"] = 0;
}
if (empty($content["search"]["no_username"])) {
    $content["search"]["no_username"] = 0;
}
if (empty($content["search"]["no_caption"])) {
    $content["search"]["no_caption"] = 0;
}
if (empty($content["search"]["no_keyword"])) {
    $content["search"]["no_keyword"] = 0;
}
if (empty($content['search']['type'])) {
    $content['search']['type'] = 'OR';
}
?>


<tr>
    <td colspan="2">


        <div class="espacamento"></div>

        <h3><?php echo $BL['be_cnt_results'] ?></h3>
        <div class="grid-3">
            <p>
                <b><?php echo $BL['be_cnt_results_per_page'] ?></b>
                <input name="csearch_result_per_page" type="text" id="csearch_result_per_page" value="<?php echo isset($content["search"]["result_per_page"]) ? $content["search"]["result_per_page"] : '' ?>" />
            </p>

            <p>
                <b><?php echo $BL['be_cnt_results_wordlimit'] ?></b>
                <input name="csearch_wordlimit" type="text" id="csearch_wordlimit" value="<?php echo isset($content["search"]["wordlimit"]) ? $content["search"]["wordlimit"] : '' ?>" size="3" maxlength="5" />
            </p>

            <p>
                <b><?php echo $BL['be_cnt_results_minchar'] ?></b>
                <input name="csearch_minchar" type="text" id="csearch_minchar"  value="<?php echo isset($content["search"]["minchar"]) ? $content["search"]["minchar"] : '3' ?>" size="3" maxlength="5" />
            </p>

        </div>

<!--        <div class="li-banners">


            <p>
                <label class="botoes" for="csearch_highlight">
                    <input name="csearch_highlight" type="checkbox" id="csearch_highlight" value="1" <?php is_checked(1, $content["search"]["highlight_result"]) ?> />
                    <?php echo $BL['be_cnt_search_highlight'] ?>
                </label>

                <label class="botoes" for="csearch_newwin">
                    <input name="csearch_newwin" type="checkbox" id="csearch_newwin" value="1" <?php is_checked(1, $content["search"]["newwin"]) ?> />
                    <?php echo $BL['be_cnt_opennewwin'] ?>
                </label>

                <label class="botoes" for="csearch_hidesummary">
                    <input name="csearch_hidesummary" type="checkbox" id="csearch_hidesummary" value="1" <?php is_checked(1, $content["search"]["hide_summary"]) ?> />
                    <?php echo $BL['be_cnt_search_hidesummary'] ?>
                </label>
            </p>

        </div>-->

        <div class="barra"></div>


        <h2>
            <?php echo $BL['be_cnt_search_startlevel'] ?> 
        </h2>
        <p>

            <select name="csearch_start_at[]" size="10" multiple="multiple" id="csearch_start_at" class="optionhover">
                <?php
                if (!isset($content["search"]["start_at"]) || !is_array($content["search"]["start_at"])) {
                    $content["search"]["start_at"] = array();
                }

                echo '<option value="0"';
                if (in_array(0, $content["search"]["start_at"])) {
                    echo ' selected="selected"';
                }
                echo '>' . $BL['be_admin_struct_index'] . '</option>' . LF;
                struct_select_list(0, 0, $content["search"]["start_at"]);
                ?>
            </select>
        </p>

<!--        <p>
            <b><?php echo $BL['be_cnt_search_default_type'] ?></b>
            <select name="csearch_type">
                <option value="OR"<?php is_selected('OR', $content['search']['type']) ?>><?php echo $BL['be_fsearch_or'] ?></option>
                <option value="AND"<?php is_selected('AND', $content['search']['type']) ?>><?php echo $BL['be_fsearch_and'] ?></option>
            </select>
        </p>-->

  
        <h2>
            <?php echo $BL['be_cnt_search_searchnot'] ?>
        </h2>

        <p class="li-banners">
            <label class="botoes" for="csearch_nofilenames">
                <input name="csearch_nofilenames" type="checkbox" id="csearch_nofilenames" value="1" <?php is_checked(1, $content["search"]["no_filenames"]) ?> /> 
                <?php echo $BL['be_fprivedit_filename'] ?>
            </label>

            <label class="botoes" for="csearch_nousername">
                <input name="csearch_nousername" type="checkbox" id="csearch_nousername" value="1" <?php is_checked(1, $content["search"]["no_username"]) ?> />
                <?php echo$BL['be_article_username'] ?>
            </label>

            <label class="botoes" for="csearch_nocaption">
                <input name="csearch_nocaption" type="checkbox" id="csearch_nocaption" value="1" <?php is_checked(1, $content["search"]["no_caption"]) ?> />
                <?php echo$BL['be_cnt_caption'] ?>
            </label>

            <label class="botoes" for="csearch_nokeyword">
                <input name="csearch_nokeyword" type="checkbox" id="csearch_nokeyword" value="1" <?php is_checked(1, $content["search"]["no_keyword"]) ?> />
                <?php echo$BL['be_article_akeywords'] ?>
            </label>
        </p>

        <div class="barra"></div>

        <h3>
            <?php echo $BL['be_module_search'] ?>
        </h3>

<!--        <p>
            <label class="botoes" for="csearch_news">
                <input name="csearch_news" type="checkbox" id="csearch_news" value="1"<?php is_checked(1, $content['search']["search_news"]) ?> />
        <?php echo $BL['be_news'] ?>

            </label>
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_profile_label_lang'] ?></b>
            <input type="text" name="csearch_news_lang" id="news_lang" value="<?php echo html(implode(', ', $content['search']["news_lang"])) ?>" class="width175" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_tags'] ?></b>
            <input type="text" name="csearch_news_category" id="news_category" value="<?php echo html(implode(', ', $content['search']["news_category"])) ?>" />
        </p>-->

<!--        <p>
            <select name="csearch_news_andor" id="news_andor">

                <option value="OR"<?php is_selected('OR', $content['search']['news_andor']) ?>><?php echo $BL['be_fsearch_or'] ?></option>
                <option value="AND"<?php is_selected('AND', $content['search']['news_andor']) ?>><?php echo $BL['be_fsearch_and'] ?></option>
                <option value="NOT"<?php is_selected('NOT', $content['search']['news_andor']) ?>><?php echo $BL['be_fsearch_not'] ?></option>

            </select>
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_target'] . ' (' . $BL['be_alias'] ?>/aid=1/id=3)</b>
            <input type="text" name="csearch_news_url" id="news_url" value="<?php echo html($content['search']["news_url"]) ?>" />
        </p>-->


        <script type="text/javascript">
<!--

            window.addEvent('domready', function () {

                /* Autocompleter for categories/tags */
                var searchCategory = $('news_category');
                var indicator2 = new Element('span', {'class': 'autocompleter-loading', 'styles': {'display': 'none'}}).setHTML('').injectAfter(searchCategory);
                var completer2 = new Autocompleter.Ajax.Json(searchCategory, 'include/inc_act/ajax_connector.php', {
                    multi: true,
                    maxChoices: 30,
                    autotrim: true,
                    minLength: 0,
                    allowDupes: false,
                    postData: {action: 'newstags', method: 'json'},
                    onRequest: function (el) {
                        indicator2.setStyle('display', '');
                    },
                    onComplete: function (el) {
                        indicator2.setStyle('display', 'none');
                    }
                });

                var selectLang = $('news_lang');
                var indicator1 = new Element('span', {'class': 'autocompleter-loading', 'styles': {'display': 'none'}}).setHTML('').injectAfter(selectLang);
                var completer1 = new Autocompleter.Ajax.Json(selectLang, 'include/inc_act/ajax_connector.php', {
                    multi: true,
                    allowDupes: false,
                    autotrim: true,
                    minLength: 0,
                    maxChoices: 20,
                    postData: {action: 'lang', method: 'json'},
                    onRequest: function (el) {
                        indicator1.setStyle('display', '');
                    },
                    onComplete: function (el) {
                        indicator1.setStyle('display', 'none');
                    }
                });

                selectLang.addEvent('keyup', function () {
                    this.value = this.value.replace(/[^a-z\-\, ]/g, '');
                });

            });

            //-->
        </script>


            <p>
        <?php
        $content['search']['module_search'] = array();

// check modules for frontend search
        foreach ($phpwcms['modules'] as $value) {

            // check if module is fe searchable
            if ($value['search'] === true && is_file($value['path'] . 'frontend.search.php')) {

                $value['tr'] .= '';
                $value['tr'] = '';
                $value['tr'] .= '<label class="botoes" for="csearch_module_' . $value['name'] . '"><input name="csearch_module[' . $value['name'] . ']" type="checkbox" ';
                $value['tr'] .= 'id="csearch_module_' . $value['name'] . '" value="1"';
                if (!empty($content['search']['module'][$value['name']])) {
                    $value['tr'] .= ' checked="checked"';
                }
                $value['tr'] .= ' />';
                $value['tr'] .= $BL['be_ctype_module'] . ': ' . $BL['modules'][$value['name']]['backend_menu'] . '</label>';
                $value['tr'] .= '';

                $content['search']['module_search'][] = $value['tr'];
            }
        }

        if (count($content['search']['module_search'])) {

            echo implode(LF, $content['search']['module_search']);
        }
        ?>
        </p>

        <!--        <div class="barra"></div>-->

<!--        <p><?php echo $BL['be_cnt_searchlabeltext'] ?></p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_input'] ?></b>
            <input name="csearch_label_input" type="text" id="csearch_label_input" value="<?php echo isset($content["search"]["label_input"]) ? $content["search"]["label_input"] : '' ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_css_class'] ?></b>
            <input name="csearch_style_input" type="text" id="csearch_style_input" value="<?php echo isset($content["search"]["style_input"]) ? $content["search"]["style_input"] : '' ?>"/>
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_buttontext'] ?></b>
            <input name="csearch_label_button" type="text" id="csearch_label_button" value="<?php echo isset($content["search"]["label_button"]) ? $content["search"]["label_button"] : '' ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_css_class'] ?></b>
            <input name="csearch_style_button" type="text" id="csearch_style_button" value="<?php echo isset($content["search"]["style_button"]) ? $content["search"]["style_button"] : '' ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_result'] ?></b>
            <input name="csearch_label_result" type="text" id="csearch_label_result" value="<?php echo isset($content["search"]["label_result"]) ? html($content["search"]["label_result"]) : '' ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_css_class'] ?></b>
            <input name="csearch_style_result" type="text" id="csearch_style_result" value="<?php echo isset($content["search"]["style_result"]) ? $content["search"]["style_result"] : '' ?>"/>
        </p>-->

        <div class="barra"></div>

        <!--<h3><?php echo $BL['be_cnt_page_of_pages'] ?></h3>-->
<!--        <p>
        <?php echo $BL['be_cnt_page_of_pages_descr'] ?>
        </p>-->

        <?php
        if (!isset($content["search"]["show_always"]))
            $content["search"]["show_always"] = 1;
        if (!isset($content["search"]["show_top"]))
            $content["search"]["show_top"] = 1;
        if (!isset($content["search"]["show_bottom"]))
            $content["search"]["show_bottom"] = 1;
        if (!isset($content["search"]["show_next"]))
            $content["search"]["show_next"] = 1;
        if (!isset($content["search"]["show_prev"]))
            $content["search"]["show_prev"] = 1;
        ?>
        <!--
                <p class="li-banners">
                    <label class="botoes" for="csearch_show_always">
                        <input name="csearch_show_always" id="csearch_show_always" type="checkbox" value="1" <?php is_checked(1, $content["search"]["show_always"]) ?> />
        <?php echo $BL['be_cnt_search_show_forall'] ?>
                    </label>
           
                    <label class="botoes" for="csearch_show_top">
                        <input name="csearch_show_top" id="csearch_show_top" type="checkbox" value="1" <?php is_checked(1, $content["search"]["show_top"]) ?> />
        <?php echo $BL['be_cnt_search_show_top'] ?>
                    </label>
              
                    <label class="botoes" for="csearch_show_bottom">
                        <input name="csearch_show_bottom" id="csearch_show_bottom" type="checkbox" value="1" <?php is_checked(1, $content["search"]["show_bottom"]) ?> />
        <?php echo $BL['be_cnt_search_show_bottom'] ?>
                    </label>
             
                    <label class="botoes" for="csearch_show_prev">
                        <input name="csearch_show_prev" id="csearch_show_prev" type="checkbox" value="1" <?php is_checked(1, $content["search"]["show_prev"]) ?> />
        <?php echo $BL['be_cnt_search_show_prev'] ?>
                    </label>
                
                    <label class="botoes" for="csearch_show_next">
                        <input name="csearch_show_next" id="csearch_show_next" type="checkbox" value="1" <?php is_checked(1, $content["search"]["show_next"]) ?> />
        <?php echo $BL['be_cnt_search_show_next'] ?>
                    </label>
                </p>-->

<!--        <p>
            <textarea name="csearch_label_pages" rows="4" class="f11" id="csearch_label_pages"><?php echo isset($content["search"]["label_pages"]) ? html($content["search"]["label_pages"]) : '' ?></textarea>
        </p>-->


<!--        <p>
        <h3><?php echo $BL['be_cnt_align'] ?></h3>

    </p>-->


        <?php
        if (!isset($content["search"]["align"])) {
            $content["search"]["align"] = 0;
        }
        ?>

<!--    <p>
        <label class="botoes" for="csearch_align0">
            <input name="csearch_align" id="csearch_align0" type="radio" value="0" <?php is_checked(0, $content["search"]["align"]) ?> />
        <?php echo $BL['be_cnt_mediapos0'] ?>
        </label>
    </p>

    <p>
        <label class="botoes" for="csearch_align1">
            <input name="csearch_align" id="csearch_align1" type="radio" value="1" <?php is_checked(1, $content["search"]["align"]) ?> />
        <?php echo $BL['be_cnt_right'] ?>
        </label>
    </p>

    <p>
        <label class="botoes" for="csearch_align2">
            <input name="csearch_align" id="csearch_align2" type="radio" value="2" <?php is_checked(2, $content["search"]["align"]) ?> />
        <?php echo $BL['be_cnt_center'] ?>
        </label>
    </p>-->

        <p>
        <h3> <?php echo $BL['be_cnt_searchformtext'] ?></h3>
    </p>

    <p class="li-banners">
        <label class="botoes" for="csearch_text_html0">
            <input type="radio" name="csearch_text_html" id="csearch_text_html0" value="0"<?php echo is_checked('0', $content['search']["text_html"], 0, 0) ?> title="redirect on success" />
            Text
        </label>

        <label class="botoes" for="csearch_text_html1">
            <input type="radio" name="csearch_text_html" id="csearch_text_html1" value="1"<?php echo is_checked('1', $content['search']["text_html"], 0, 0) ?> title="redirect on success" />
            HTML
        </label>
    </p>

    <p>
        <b><?php echo $BL['be_cnt_intro'] ?></b>
        <textarea name="csearch_text_intro" rows="6" id="csearch_text_intro"><?php echo isset($content["search"]["text_intro"]) ? $content["search"]["text_intro"] : '' ?></textarea>
    </p>

    <p>
        <b><?php echo $BL['be_cnt_result'] ?></b>
        <textarea name="csearch_text_result" rows="6"  id="csearch_text_result"><?php echo isset($content["search"]["text_result"]) ? $content["search"]["text_result"] : '' ?></textarea>
    </p>

    <p>
        <b><?php echo $BL['be_cnt_noresult'] ?></b>
        <textarea name="csearch_text_noresult" rows="6"  id="csearch_text_noresult"><?php echo isset($content["search"]["text_noresult"]) ? $content["search"]["text_noresult"] : '' ?></textarea>
    </p>


    <div class="barra"></div>
    <h2>Aparência</h2>

    <p>
        <b><?php echo $BL['be_admin_struct_template']; ?></b>
        <select name="template" id="template" class="f11b">
            <?php
            echo '<option value="">' . $BL['be_admin_tmpl_default'] . '</option>' . LF;

// templates for search listing
            $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/search');
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


