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
// Article List
$buttonAction .= '<input type="button" value="' . $BL['be_article_cnt_center'];
$buttonAction .= '" class="button10" title="' . $BL['be_article_cnt_center'] . '" onclick="';
$buttonAction .= "location.href='phpwcms.php?do=articles';return false;\">\n";
// Article Preview (new window)
$buttonActionLink = rel_url(array('phpwcms-preview' => 1), array(), empty($article["article_alias"]) ? 'aid=' . $article["article_id"] : $article["article_alias"]);
$buttonAction .= '<input type="button" value="' . $BL['be_func_struct_preview'] . '" class="button10 bt-visualizar" title="' . $BL['be_func_struct_preview'] . '" onclick="';
$buttonAction .= "window.open('" . $buttonActionLink . "', 'articlePreviewWindows');return false;\">";
?>
<form action="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=2&amp;id=<?php echo $article["article_id"] ?>" method="post" name="addcontent" id="addcontent">

    <table width="<?php echo $phpwcms['LarguraInterna']; ?>" border="0" cellpadding="0" cellspacing="0" summary="">

        <tr>
            <td colspan="3">
                <h1 class="title"><?php echo $BL['be_article_cnt_ltitle'] ?></h1>
                <div class="bloco-lista bloco-lista-sumario">
                    <h2><a href="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=1&amp;id=<?php echo $article["article_id"] ?>"><?php echo html($article["article_title"]) ?></a></h2>

                    <?php if (!empty($article["article_subtitle"])) { ?>
                        <h3><?php echo html($article["article_subtitle"]); ?></h3>
                    <?php } ?>

                    <div class="botoes-controle-lista">
                        <a class="botoes bt-editar" href="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=1&amp;id=<?php echo $article["article_id"] ?>"><i class="fas fa-edit"></i> Editar</a>
                        <a href="include/inc_act/act_articlecontent.php?do=<?php echo "3," . $article["article_id"] . ",0," . switch_on_off($article["article_aktiv"]) ?>" title="<?php echo $BL['be_article_cnt_lvisible'] ?>"><span class="bt-seta-off bt-visivel<?php echo $article["article_aktiv"] ?>"> <i class="fas fa-eye"></i></span></a>
                        <a class="botoes bt-delete" href="include/inc_act/act_articlecontent.php?do=<?php echo "1," . $article["article_id"]; ?>" title="<?php echo $BL['be_article_cnt_ldel'] ?>" onclick="return confirm('<?php echo $BL['be_article_cnt_ldeljs'] . '\n' . html($article["article_title"]); ?>  \n ');"><i class="far fa-trash-alt"></i></a>
                    </div>



                    <?php if (!empty($article["article_summary"])) { ?>
                        <div class="espacamento"></div>

                        <h4>Texto de Introdu��o</h4>
                        <p>
                            <!-- <?php echo $BL['be_article_asummary'] ?> -->
                            <?php echo html(getCleanSubString(strip_tags($article["article_summary"]), 250, '&#8230;'), false); ?>
                        </p>


                    <?php } ?>





                    <?php
                    $thumb_image = false;
                    if (!empty($article["image"]["hash"])) {
                        $thumb_image = get_cached_image(array(
                            "target_ext" => $article['image']['ext'],
                            "image_name" => $article['image']['hash'] . '.' . $article['image']['ext'],
                            "thumb_name" => md5($article['image']['hash'] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
                        ));
                    }

                    $thumb_list_image = false;
                    if (!empty($article["image"]["list_hash"])) {
                        $thumb_list_image = get_cached_image(array(
                            "target_ext" => $article['image']['list_ext'],
                            "image_name" => $article['image']['list_hash'] . '.' . $article['image']['list_ext'],
                            "thumb_name" => md5($article['image']['list_hash'] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
                        ));
                    }

                    if ($thumb_image != false || $thumb_list_image != false) {
                        ?>
                        <div class="espacamento"></div>

                        <h4><?php echo $BL['be_cnt_image'] ?></h4>
                        <div class="img-sumario">

                            <?php
                            if ($thumb_image != false) {
                                echo '<figure><b>Introdu��o da P�gina</b> <img src="' . PHPWCMS_IMAGES . $thumb_image[0] . '" border="0" ' . $thumb_image[3] . ' alt="" /></figure>';
                            }
                            if ($thumb_list_image != false) {
                                echo '<figure><b>Pagina Completa</b> <img src="' . PHPWCMS_IMAGES . $thumb_list_image[0] . '" border="0" ' . $thumb_list_image[3] . ' alt=""';
                                if (!empty($article['image']['list_usesummary'])) {
                                    echo ' class="inactive"';
                                }
                                echo ' /><figure>';
                            }
                            ?>

                        </div>
                    <?php } ?>


                    <h4 class="url-pagina">
                        <strong><?php echo $BL['be_article_urlalias'] ?></strong>
                        <?php echo html($article["article_alias"]); ?>
                    </h4>


                    <div class="mais-info">
                        <a class="botoes-lista" title="<?php echo $BL['be_article_eslastedit'] ?>">
                            <i class="fas fa-pen-square" title=""></i>

                            <?php echo phpwcms_strtotime($article["article_date"], $BL['be_longdatetime'], '') ?>
                        </a>


                        <a class="botoes-lista" title="<?php echo $BL['be_fprivedit_created'] ?>">
                            <i class="far fa-calendar-plus"></i>
                            <?php echo date($BL['be_longdatetime'], $article["article_created"]) ?>
                        </a>


                        <a class="botoes-lista" title="<?php echo $BL['be_article_cnt_start'] ?>">
                            <i class="fas fa-history" style="color:#508c02"></i>
                            <?php echo phpwcms_strtotime($article["article_begin"], $BL['be_longdatetime'], '') ?>
                        </a>

                        <a class="botoes-lista" title="<?php echo $BL['be_article_cnt_end'] ?>">
                            <i class="fas fa-history" style="color:#9f0000"></i>
                            <?php echo phpwcms_strtotime($article["article_end"], $BL['be_longdatetime'], '') ?>
                        </a>

                    </div>





<!--                    <p>
                    <?php echo $BL['be_article_cat'] ?>
                    <?php echo html($article["article_cat"]) ?>
                    </p>-->


                    <? if($phpwcms['Modo'] == 1){ ?>

<!--                    <p>
                    <?php echo $BL['be_article_akeywords'] ?>

                    <?php
                    if ($article["article_keyword"]) {
                        echo html($article["article_keyword"]);
                    } else {
                        echo "not defined/completed";
                    }
                    ?>
                    </p>-->

                    <? } else {} ?>

                    <?php
                    if ($article["article_redirect"]) {
                        ?>
                        <p>
                            <?php echo $BL['be_article_cnt_redirect'] ?>
                            <b><?php echo html($article["article_redirect"]); ?></b>
                        </p>
                    <?php } ?>






                    <!--<p><?php echo $BL['be_article_username']; ?> <?php echo $article["article_username"] ?></p>-->
                    <!--<p><?php echo $BL['be_cnt_sortvalue'] ?> <?php echo $article["article_sort"] ?></p>-->
                    <!--<p><span style="color:#727889"><?php echo $BL['be_priorize'] ?>:</span> <?php echo $article["article_priorize"] ?></p>-->
                    <!--<p><?php echo $BL['be_ftptakeover_status'] ?></p>-->
                    <!--<p><?php echo ($article["article_nositemap"] == 1 ? '&check;' : '-') . ' ' . $BL['be_ctype_sitemap'] ?></p>-->
                    <!--<p><?php echo ($article["article_nosearch"] == 1 ? '-' : '&check;') . ' ' . $BL['be_fsearch_searchlabel'] ?></p>-->
                    <!--<p><?php echo ($article["article_norss"] == 1 ? '&check;' : '-') . ' ' . $BL['be_no_rss'] ?></p>-->
                    <!--<p><?php echo ($article["article_opengraph"] == 1 ? '&check;' : '-') . ' ' . $BL['be_opengraph_support'] ?></p>-->
                    <!--<p><?php echo ($article["article_archive_status"] == 1 ? '&check;' : '-') . ' ' . $BL['be_show_archived']; ?></p>-->



                </div>
            </td>

        </tr>

<!--        <tr bgcolor="#F3F5F8">
            <td width="23" align="right"><?php if (count($phpwcms['allowed_lang']) == 0): ?>
                                                                                                                                        <img src="img/symbole/article_text.gif" alt="" width="9" height="11" border="0" style="margin-right:5px;" />
        <?php else: ?>
                                                                                                                                        <img src="img/famfamfam/lang/<?php echo ($lang = strtolower(empty($article["article_lang"]) ? $phpwcms['default_lang'] : $article["article_lang"])); ?>.png" title="<?php echo get_language_name($lang) ?>" style="margin-right:4px;" />
        <?php endif; ?></td>
            <td width="453" class="dir"></td>
            <td width="62" align="right" class="h13" style="padding-right:1px; padding-left: 100px;"></td>
        </tr>-->
        <!--
                <tr bgcolor="#F3F5F8">
                    <td><img src="img/leer.gif" alt="" width="23" height="1" /></td>
                    <td><table border="0" cellpadding="0" cellspacing="0" summary="" class="tdMorepace">





        <?php
        $thumb_image = false;
        if (!empty($article["image"]["hash"])) {
            $thumb_image = get_cached_image(array(
                "target_ext" => $article['image']['ext'],
                "image_name" => $article['image']['hash'] . '.' . $article['image']['ext'],
                "thumb_name" => md5($article['image']['hash'] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
            ));
        }

        $thumb_list_image = false;
        if (!empty($article["image"]["list_hash"])) {
            $thumb_list_image = get_cached_image(array(
                "target_ext" => $article['image']['list_ext'],
                "image_name" => $article['image']['list_hash'] . '.' . $article['image']['list_ext'],
                "thumb_name" => md5($article['image']['list_hash'] . $phpwcms["img_list_width"] . $phpwcms["img_list_height"] . $phpwcms["sharpen_level"] . $phpwcms['colorspace'])
            ));
        }

        if ($thumb_image != false || $thumb_list_image != false) {
            ?>
                                                                                                                               <tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="2" /></td><tr>
                                                                                                                                   <td valign="top" class="v10" style="color:#727889"><?php echo $BL['be_cnt_image'] ?>:&nbsp;</td>
                                                                                                                                   <td valign="top" class="v10"><?php
            if ($thumb_image != false) {
                echo '<img src="' . PHPWCMS_IMAGES . $thumb_image[0] . '" border="0" ' . $thumb_image[3] . ' alt="" style="margin-right:5px;" />';
            }
            if ($thumb_list_image != false) {
                echo '<img src="' . PHPWCMS_IMAGES . $thumb_list_image[0] . '" border="0" ' . $thumb_list_image[3] . ' alt=""';
                if (!empty($article['image']['list_usesummary'])) {
                    echo ' class="inactive"';
                }
                echo ' />';
            }
            ?></td>
                                                                                                                                                    </tr>
            <?php
        }
        ?>

                        </table></td>
                    <td>&nbsp;</td>
                </tr> -->



        <tr><td colspan="3">
                <div class="controles-salvar">
                    <?php echo $buttonAction; ?>
                </div>
            </td></tr>
        <!--<tr><td colspan="3"><?php echo $buttonAction; ?></td></tr>-->

        <!--<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>-->

<!--        <tr bgcolor="#92A1AF"><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
        <tr bgcolor="#D9DEE3"><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="8" /></td></tr>-->
        <tr><td colspan="3">

                <div class="bloco-lista add-conteudo">
                    <p>
                        <b>Tipo de Conte�do</b>
                        <select name="ctype" class="v12" id="ctype" onchange="this.form.submit();">
                            <?php
                            $temp_count = 0;
                            $user_selected_cp = isset($_SESSION["wcs_user_cp"]) && count($_SESSION["wcs_user_cp"]) ? true : false;

                            if (is_array($article["article_cntpart"]) && count($article["article_cntpart"])) {

                                // list all content parts usable for this article category
                                foreach ($article["article_cntpart"] as $value) {

                                    if ($user_selected_cp && !isset($_SESSION["wcs_user_cp"][$value])) {
                                        continue;
                                    }

                                    if (isset($wcs_content_type[$value])) {

                                        echo getContentPartOptionTag($value, $wcs_content_type[$value], $article['article_cpdefault']);
                                        $temp_count++;
                                    }
                                    $value1 = $value * (-1);
                                    if (isset($BL['be_admin_optgroup_label'][$value1]) && $value) {
                                        echo '<optgroup label="[ ' . $BL['be_admin_optgroup_label'][$value1] . ' ]" class="cntOptGroup"></optgroup>' . "\n";
                                    }
                                }
                            }
                            if (!$temp_count) {
                                //list all available content parts
                                foreach ($wcs_content_type as $key => $value) {

                                    if ($user_selected_cp && !isset($_SESSION["wcs_user_cp"][$key])) {
                                        continue;
                                    }

                                    echo getContentPartOptionTag($key, $value, $article['article_cpdefault']);
                                }
                            }
                            ?>
                        </select>
                    </p>
                    <p><button class="bt-add-conteudo" type="submit" name="image" value="" title="<?php echo $BL['be_article_cnt_addtitle'] ?>" /><i class="fas fa-plus-square"></i> <?php echo $BL['be_article_cnt_add'] ?></button></p>
                </div>
            </td>
        </tr>

        <?php
//Auslesen der Content Daten zum Zusammenstellen der Sortier-Informationen

        $sql = "SELECT acontent_id, acontent_sorting, acontent_trash, acontent_block FROM " . DB_PREPEND . "phpwcms_articlecontent ";
        $sql .= "WHERE acontent_aid=" . $article["article_id"] . " ORDER BY acontent_block, acontent_sorting, acontent_id";

        if ($result = mysqli_query($db, $sql) or die("error while listing contents for this article")) {
            $sc = 0;
            $scc = 0; //Sort-Zwischenzähler
            while ($row = mysqli_fetch_row($result)) {
                $scc++;
                if ($row[2] == 0) {
                    $sc++;
                    $sbutton[$sc]["id"] = $row[0];
                    $sbutton[$sc]["sort"] = $row[1];
                    $sbutton[$sc]["block"] = $row[3];
                }
            }
        }
        if ($sc) {
            //Jetzt aufbauen der Sortieranweisung
            foreach ($sbutton as $key => $value) {
                if ($key == 1) {
                    // if 1st content part in list
                    $sbutton[$key]["top"] = '<a class="botoes bt-off"><i class="fas fa-chevron-up"></i></a>';
                } elseif (isset($sbutton[$key - 1]["block"]) && $sbutton[$key - 1]["block"] != $sbutton[$key]["block"]) {
                    // if this content part is selected for different block than previous
                    $sbutton[$key]["top"] = '<a class="botoes bt-off"><i class="fas fa-chevron-up"></i></a>';
                } else {
                    $sbutton[$key]["top"] = "<a class=\"botoes\" href=\"include/inc_act/act_articlecontent.php?sort=" .
                            $sbutton[$key]["id"] . ":" . $sbutton[$key - 1]["sort"] . "|" .
                            $sbutton[$key - 1]["id"] . ":" . $sbutton[$key]["sort"] .
                            "\" title=\"" . $BL['be_article_cnt_up'] . "\"><i class=\"fas fa-chevron-up\"></i></a>";
                }
                if ($key == $sc) {
                    // if this is the last content part in list
                    $sbutton[$key]["bottom"] = "<a class=\"botoes bt-off\"><i class=\"fas fa-chevron-down\"></i></a>";
                } elseif (isset($sbutton[$key + 1]["block"]) && $sbutton[$key + 1]["block"] != $sbutton[$key]["block"]) {
                    // if this is the last content part in current block and next is different
                    $sbutton[$key]["bottom"] = "<a class=\"botoes bt-off\"><i class=\"fas fa-chevron-down\"></i></a>";
                } else {
                    $sbutton[$key]["bottom"] = "<a class=\"botoes\" href=\"include/inc_act/act_articlecontent.php?sort=" .
                            $sbutton[$key]["id"] . ":" . $sbutton[$key + 1]["sort"] . "|" .
                            $sbutton[$key + 1]["id"] . ":" . $sbutton[$key]["sort"] .
                            "\" title=\"" . $BL['be_article_cnt_down'] . "\"><i class=\"fas fa-chevron-down\"></i></a>";
                }
                $sbutton_string[$sbutton[$key]["id"]] = $sbutton[$key]["top"] .
                        $sbutton[$key]["bottom"];
            }
            unset($sbutton);
        }

//Listing zugehöriger Artikel Content Teile
        $sql = "SELECT *, UNIX_TIMESTAMP(acontent_tstamp) as acontent_date FROM " . DB_PREPEND . "phpwcms_articlecontent " .
                "WHERE acontent_aid=" . $article["article_id"] . " AND acontent_trash=0 " .
                "ORDER BY acontent_block, acontent_sorting, acontent_tab, acontent_id;";

        if ($result = mysqli_query($db, $sql) or die("error while listing contents for this article")) {
            $sortierwert = 1;
            $contentpart_block = ' ';
            $contentpart_block_name = '';
            $contentpart_tab = '';
            while ($row = mysqli_fetch_assoc($result)) {

                // if type of content part not enabled available
                if (!isset($wcs_content_type[$row["acontent_type"]]) || ($row["acontent_type"] == 30 && !isset($phpwcms['modules'][$row["acontent_module"]]))) {
                    continue;
                }

                // now show current block name
                if ($contentpart_block != $row['acontent_block']) {
                    $contentpart_block = $row['acontent_block'];
                    $contentpart_block_name = html(' {' . $row['acontent_block'] . '}');
                    $contentpart_block_color = ' #E0D6EB';

                    switch ($contentpart_block) {
                        case '':
                        case 'CONTENT':
                            $contentpart_block_name = $BL['be_main_content'] . $contentpart_block_name;
                            if ($article['article_paginate']) {
                                $contentpart_block_name .= ' / <img src="img/symbole/content_cppaginate.gif" alt="" style="margin-right:2px;" />';
                                $contentpart_block_name .= $BL['be_cnt_pagination'];
                            }
                            $contentpart_block_color = ' #F5CCCC';
                            break;

                        case 'LEFT':
                            $contentpart_block_name = $BL['be_cnt_left'] . $contentpart_block_name;
                            $contentpart_block_color = ' #E0EBD6';
                            break;

                        case 'RIGHT':
                            $contentpart_block_name = $BL['be_cnt_right'] . $contentpart_block_name;
                            $contentpart_block_color = ' #FFF5CC';
                            break;

                        case 'HEADER':
                            $contentpart_block_name = $BL['be_admin_page_header'] . $contentpart_block_name;
                            $contentpart_block_color = ' #EBEBD6';
                            break;

                        case 'FOOTER':
                            $contentpart_block_name = $BL['be_admin_page_footer'] . $contentpart_block_name;
                            $contentpart_block_color = ' #E1E8F7';
                            break;

                        case 'BANNER':
                            $contentpart_block_name = $BL['be_admin_page_banner'] . $contentpart_block_name;
                            $contentpart_block_color = '#ECF7C1"';
                            break;

                        case 'SERVICOS':
                            $contentpart_block_name = $BL['be_admin_page_servicos'] . $contentpart_block_name;
                            $contentpart_block_color = ' #FFE28A';
                            break;

                        case 'PRODUTOS':
                            $contentpart_block_name = $BL['be_admin_page_produtos'] . $contentpart_block_name;
                            $contentpart_block_color = ' #99D7EB';
                            break;

                        case 'MAPA':
                            $contentpart_block_name = $BL['be_admin_page_mapa'] . $contentpart_block_name;
                            $contentpart_block_color = ' #C8E1F0';
                            break;

                        case 'CLIENTES':
                            $contentpart_block_name = $BL['be_admin_page_clientes'] . $contentpart_block_name;
                            $contentpart_block_color = ' #F0F0F0';
                            break;

                        case 'CPSET':
                            $contentpart_block_name = $BL['be_settings'] . ' <span style="font-weight:normal">(' . $BL['be_system_container_norender'] . ')</span>';
                            $contentpart_block_color = ' #cceaf5';
                            break;

                        case 'SYSTEM':
                            $contentpart_block_name = $BL['be_system_container'] . ' <span style="font-weight:normal">(' . $BL['be_system_container_norender'] . ')</span>';
                            $contentpart_block_color = ' #ffdc9d';
                            break;
                    }
                    ?>
                    <tr>

                        <td colspan="3"><span class="bloco-display" style="background-color:<?php echo $contentpart_block_color ?>"><?php echo $contentpart_block_name ?></span></td>

                    </tr>

                    <?php
                }

                // now check if content part is tabbed
                if ($row['acontent_tab'] && $contentpart_tab != $row['acontent_tab']) {
                    $contentpart_tab = $row['acontent_tab'];
                    $contentpart_tabbed = explode('_', $contentpart_tab, 2);
                    $contentpart_tab_title = empty($contentpart_tabbed[1]) ? '' : $contentpart_tabbed[1];
                    $contentpart_tab_number = explode('|', $contentpart_tabbed[0]);
                    $contentpart_tab_type = empty($contentpart_tab_number[1]) ? 1 : intval($contentpart_tab_number[1]);
                    $contentpart_tab_number = intval($contentpart_tab_number[0]);
                    ?>
                    <tr<?php echo $contentpart_block_color ?>>

                        <td colspan="3" style="font-size:11px;"><?php
                            echo $contentpart_tab_type === 2 ? $BL['be_ctype_accordion'] : $BL['be_ctype_tabs'];
                            echo ' / ' . $BL['be_cnt_paginate_subsection'] . ': ';
                            echo empty($contentpart_tab_title) ? '[' . $contentpart_tab_number . ']' : html($contentpart_tab_title);
                            ?>&nbsp;</td>

                    </tr>

                    <?php
                } elseif ($contentpart_tab && empty($row['acontent_tab'])) {

                    // not the same tab but following cp is not tabbed
                    $contentpart_tab = '';
                    ?>
                    <tr<?php echo $contentpart_block_color ?>><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="3" /></td></tr>
                    <tr><td colspan="3" bgcolor="#D9DEE3"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
                    <?php
                }
                ?>

                <tr>
                    <td colspan="3">
                        <div class="bloco-lista bloco-lista-cp">
                            <h3>
                                <?php
                                $cntpart_title = $wcs_content_type[$row["acontent_type"]];
                                if (!empty($row["acontent_module"])) {

                                    $cntpart_title .= ': ' . $BL['modules'][$row["acontent_module"]]['listing_title'];
                                }
                                echo $cntpart_title;
                                ?>
                            </h3>





                            <div class="botoes-controle-lista">

                                <a class="botoes bt-editar"href="phpwcms.php?do=articles&amp;p=2&amp;s=1&amp;aktion=2&amp;id=<?php
                                echo $article["article_id"] . "&amp;acid=" . $row["acontent_id"];
                                ?>" title="<?php echo $BL['be_article_cnt_edit'] ?>"><i class="fas fa-edit"></i> Editar</a><?php
                                   // duplicate content part
                                   echo '<a class="botoes bt-copiar" href="include/inc_act/act_structure.php?do=8%7C' . $row["acontent_id"] . '%7C' . $article["article_id"] . '%7C' . ($row["acontent_sorting"] + 5) . '" ';
                                   echo 'title="' . $BL['be_func_content_copy'] . ' [ID:' . $row["acontent_id"] . ']" ';
                                   echo 'onclick="return confirm(\'' . js_singlequote($BL['be_func_content_copy']) . ': \n' . js_singlequote($cntpart_title . ' [ID:' . $row["acontent_id"] . ']') . '\');">';
                                   echo '<i class="far fa-copy"></i> Duplicar</a>';
                                   ?>
                                   <?php echo $sbutton_string[$row["acontent_id"]]; ?>


                                <a class="botoes bt-visivel<?php echo $row["acontent_visible"] ?>" href="include/inc_act/act_articlecontent.php?do=<?php
                                echo "2," . $article["article_id"] . "," . $row["acontent_id"] . "," . switch_on_off($row["acontent_visible"])
                                ?>" title="<?php
                                   echo $BL['be_article_cnt_lvisible']
                                   ?>"><i class="fas fa-eye"></i></a><a class="botoes bt-delete" href="include/inc_act/act_articlecontent.php?do=<?php
                                   echo "9," . $article["article_id"] . "," . $row["acontent_id"]
                                   ?>" title="<?php echo $BL['be_article_cnt_delpart'] ?>" onclick="return confirm('<?php echo $BL['be_article_cnt_delpartjs'] ?> \n[ID: <?php echo $row["acontent_id"]
                                   ?>]\n ');"><i class="far fa-trash-alt"></i></a>

                            </div>

                            <?php if ($row["acontent_block"] === 'SYSTEM'): ?>


                                <?php
                                echo '<span class="greyed">', $BL['be_article_rendering'], ':</span> <span class="tool-title">';

                                if (empty($row["acontent_tid"])) {
                                    echo $BL['be_custom_scriptlogic'];
                                } elseif ($row["acontent_tid"] == 3) {
                                    echo $BL['be_article_forlist'] . ' + ' . $BL['be_article_forfull'];
                                } elseif ($row["acontent_tid"] == 2) {
                                    echo $BL['be_article_forfull'];
                                } else { // == 1
                                    echo $BL['be_article_forlist'];
                                }

                                echo '</span>';
                                ?>

                                <?php
                            endif;

                            // list content type overview
                            $cinfo = NULL;

                            //$row["acontent_type"] = intval($row["acontent_type"]); -> it is always INT because coming from db INT field
                            // check default content parts (system internals
                            if ($row['acontent_type'] != 30 && file_exists('include/inc_tmpl/content/cnt' . $row['acontent_type'] . '.list.inc.php')) {

                                include(PHPWCMS_ROOT . '/include/inc_tmpl/content/cnt' . $row['acontent_type'] . '.list.inc.php');
                            } elseif ($row['acontent_type'] == 30 && file_exists($phpwcms['modules'][$row['acontent_module']]['path'] . 'inc/cnt.list.php')) {

                                // custom module
                                include($phpwcms['modules'][$row['acontent_module']]['path'] . 'inc/cnt.list.php');
                            } else {

                                // default fallback
                                include(PHPWCMS_ROOT . '/include/inc_tmpl/content/cnt0.list.inc.php');
                            }
                            // end list
                            ?>
                            <div class="cp-info">
                                <a class="botoes-lista bt-id">ID:<?php echo $row["acontent_id"] ?></a>

                                �ltima atualiza��o: <strong>
                                    <?php
                                    echo date($BL['be_shortdatetime'], $row["acontent_date"]) . '&nbsp;';
                                    ?>
                                </strong>

                                <span>
                                    <?php
                                    if ($contentpart_block != 'CPSET') {

                                        //Display cp paginate page number
                                        if ($article["article_paginate"]) {

                                            echo '<img src="img/symbole/content_cppaginate.gif" alt="subsection" title="subsection" />';
                                            echo $row["acontent_paginate_page"] == 0 ? 1 : $row["acontent_paginate_page"];
                                        }

                                        //Anzeigen der Space Before/After Info
                                        if (intval($row["acontent_before"])) {
                                            echo '<a class="botoes-lista"><i class="fas fa-arrow-up"></i>' . $row["acontent_before"] . ' </a>';
                                        }
                                        if (intval($row["acontent_after"])) {
                                            echo '<a class="botoes-lista"><i class="fas fa-arrow-down"></i>' . $row["acontent_after"] . ' </a>';
                                        }
                                        if ($row["acontent_top"]) {
                                            echo '<img src="img/symbole/content_top.gif" alt="TOP" title="TOP" />';
                                        }
                                        if ($row["acontent_anchor"]) {
                                            echo '<a class="botoes-lista"><i class="fas fa-anchor"></i></a>';
                                        }
                                        if ($row["acontent_granted"]) {
                                            echo '<a class="botoes-lista"><i class="fas fa-lock"></i></a>';
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>


                <?php
            }
        } //Ende Listing Artikel Content Teile
        ?>


    </table>
    <input name="csorting" type="hidden" id="csorting" value="<?php echo ($scc * 10); ?>" />
</form>


<!-- <?php echo $buttonAction; ?> -->