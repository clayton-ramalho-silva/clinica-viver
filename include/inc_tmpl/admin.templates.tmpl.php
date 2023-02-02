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

reset($phpwcms['js_lib']); // reset $phpwcms['js_lib'] to get first element as default

$template = array("name" => '', "default" => 0, "layout" => '', "css" => array(), "htmlhead" => '', "htmlhead_ext" => '', "jsonload" => '', "headertext" => '', "maintext" => '', "footertext" => '',
    "lefttext" => '', "righttext" => '', "errortext" => '', 'feloginurl' => '',
    'jslib' => key($phpwcms['js_lib']), 'jslibload' => 0, 'frontendjs' => 0, 'googleapi' => 1);

if (!isset($_GET["s"])) {
// check if template should be edited
    ?>
    <h1 class="title"><?php echo $BL['be_admin_tmpl_title'] ?></h1>
    <!--<table width="<?php echo $phpwcms['LarguraInterna']; ?>" border="0" cellpadding="0" cellspacing="0" summary="">-->

        <?php
// loop listing available templates
        $sql = "SELECT * FROM " . DB_PREPEND . "phpwcms_template WHERE template_trash=0 ORDER BY template_default DESC, template_name"; //AND template_type=0
        if ($result = mysqli_query($db, $sql) or die("error while listing templates")) {
            $row_count = 0;
            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {

                $edit_link = 'do=admin&amp;p=11&amp;s=' . $row["template_id"] . '&amp;t=' . $row["template_type"];

                echo "<div class=\"lista-arquivos-del-linha\" " . ( ($row_count % 2) ? " bgcolor=\"#F3F5F8\"" : "" ) . ">\n"; //#F9FAFB
                echo '<span><img src="img/symbole/template_list_icon.gif" width="28" height="18">' . "\n";
                echo '<a href="phpwcms.php?' . $edit_link;
                echo '"><strong>' . html($row["template_name"]) . "</strong>";
                echo ($row["template_default"]) ? " (" . $BL['be_admin_tmpl_default'] . ")" : "";
                echo "</a></span>\n" . '';
                echo '<div class="botoes-controle-paginas"><a class="botoes bt-editar" href="phpwcms.php?' . $edit_link;
                echo '"><i class="fas fa-edit"></i> Editar</a>';

                // ERICH COPY TEMPLATE 7.6.2005
                echo '<a class="botoes bt-copiar" href="phpwcms.php?' . $edit_link . '&amp;c=1'; // c=1 -> do copy
                echo '" title="copy template"><i class="far fa-copy"></i> Duplicar </a>';
                // ERICH COPY TEMPLATE END 7.6.2005

                echo '<a class="botoes bt-delete" href="include/inc_act/act_frontendsetup.php?do=2|' . $row["template_id"] . '" ';
                echo 'title="' . $BL['be_cnt_delete'] . ': ' . html($row["template_name"]) . '" ';
                echo 'onclick="return confirm(\'' . js_singlequote($BL['be_cnt_delete'] . ': ' . html($row["template_name"])) . '\');">';
                echo '<i class="far fa-trash-alt"></i></a>';
                echo "</div></div>\n\n";
                $row_count++;
            }
            mysqli_free_result($result);
        } // end listing
        ?>
        <!--<tr><td colspan="3" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1" /></td>-->
        <!--</tr>-->
        <!--<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="8" /></td>-->
        <!--</tr>-->
        <!--<tr><td colspan="3">-->
        <div class="barra"></div>
                <form action="phpwcms.php?do=admin&amp;p=11&amp;s=0" method="post">
                    <input type="submit" value="<?php echo $BL['be_admin_tmpl_add'] ?>" class="button10" title="<?php echo $BL['be_admin_tmpl_add'] ?>" />
                </form>
            <!--</td>-->
        <!--</tr>-->
    <!--</table>-->
    <?php
} else {

// should the edit template dialog
    $template["id"] = intval($_GET["s"]);

    $createcopy = isset($_GET["c"]) ? intval($_GET["c"]) : 0;

    if (isset($_POST["template_id"])) {

        $createcopy = empty($_POST["c"]) ? 0 : intval($_POST["c"]); // ERICH COPY TEMPLATE 08.06.2005
        // read the create or edit template form data
        $template["id"] = intval($_POST["template_id"]);
        $template["default"] = empty($_POST["template_setdefault"]) ? 0 : 1;
        $template["layout"] = intval($_POST["template_layout"]);
        $template["name"] = clean_slweg($_POST["template_name"], 150);
        if (empty($template["name"])) {
            $template["name"] = "template_" . generic_string(3);
        }
        if (isset($_POST["template_css"]) && is_array($_POST["template_css"])) {
            $template["css"] = $_POST["template_css"];
        } else {
            $template["css"] = array();
        }
        $template["htmlhead"] = slweg($_POST["template_htmlhead"]);
        $template["htmlhead_ext"] = slweg($_POST["template_htmlhead_ext"]);
        $template["jsonload"] = slweg($_POST["template_jsonlfoad"]);
        //$template["headertext"]	= slweg($_POST["template_block_headerf"]);
        //$template["maintext"]	= slweg($_POST["template_block_main"]);
        //$template["footertext"]	= slweg($_POST["template_block_footer"]);
        $template["lefttext"] = slweg($_POST["template_block_left"]);
        $template["righttext"] = slweg($_POST["template_block_right"]);
        $template["errortext"] = slweg($_POST["template_block_error"]);
        $template["feloginurl"] = slweg($_POST["template_felogin_url"]);
        $template["overwrite"] = clean_slweg($_POST["template_overwrite"]);
        $template['jslib'] = clean_slweg($_POST["template_jslib"]);
        $template['jslibload'] = empty($_POST["template_jslibload"]) ? 0 : 1;
        $template['frontendjs'] = empty($_POST["template_frontendjs"]) ? 0 : 1;
        $template['googleapi'] = empty($_POST["template_googleapi"]) ? 0 : 1;
        if (isset($_POST["template_block_header"]) && is_array($_POST["template_block_header"])) {
            $template["headertext"] = $_POST["template_block_header"];
        } else {
            $template["headertext"] = array();
        }
        if (isset($_POST["template_block_main"]) && is_array($_POST["template_block_main"])) {
            $template["maintext"] = $_POST["template_block_main"];
        } else {
            $template["maintext"] = array();
        }
        if (isset($_POST["template_block_footer"]) && is_array($_POST["template_block_footer"])) {
            $template["footertext"] = $_POST["template_block_footer"];
        } else {
            $template["footertext"] = array();
        }

        // now browse custom blocks if available
        if (!empty($_POST['customblock'])) {

            $template['customblock'] = clean_slweg($_POST["customblock"]);
            $temp_customblock = explode(',', $template['customblock']);
            foreach ($temp_customblock as $value) {

                $template['customblock_' . $value] = slweg($_POST['template_customblock_' . $value]);
            }
        }

        if ($template["id"] && empty($createcopy)) {
            // if ID <> 0 then get template info from database
            $sql = "UPDATE " . DB_PREPEND . "phpwcms_template SET " .
                    "template_name='" . aporeplace($template["name"]) . "', " .
                    "template_default=" . $template["default"] . ", " .
                    "template_var='" . aporeplace(serialize($template)) . "' " .
                    "WHERE template_id=" . $template["id"];
        } else {
            // if ID = 0 then show create new template form
            $sql = "INSERT INTO " . DB_PREPEND . "phpwcms_template (" .
                    "template_name, template_default, template_var) VALUES ('" .
                    aporeplace($template["name"]) . "', " . $template["default"] . ", '" .
                    aporeplace(serialize($template)) . "')";
        }
        // update or insert data entry
        @mysqli_query($db, $sql) or die("error while updating or inserting template datas");

        if (empty($template["id"]) || $createcopy == 1) {
            $template["id"] = mysqli_insert_id($db);
        }

        //now proof for default template definition
        if ($template["default"]) {
            mysqli_query($db, "UPDATE " . DB_PREPEND . "phpwcms_template SET template_default=0 " .
                    "WHERE template_id != " . $template["id"]);
        }
        update_cache();
        headerRedirect(PHPWCMS_URL . "phpwcms.php?do=admin&p=11&s=" . $template["id"]);
    }

    if ($template["id"]) {
        // read the given template datas from db
        $sql = "SELECT * FROM " . DB_PREPEND . "phpwcms_template WHERE template_id=" . $template["id"] . " LIMIT 1";
        if ($result = mysqli_query($db, $sql)) {
            if ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                unset($template);
                $template = unserialize($row["template_var"]);
                $template["id"] = $row["template_id"];
                $template["default"] = $row["template_default"];
                // compatibility for older releases where only
                // 1 css file could be stored per template
                if (is_string($template['css'])) {
                    $template['css'] = array($template['css']);
                }
                if (empty($template['jslib'])) {
                    $template['jslib'] = key($phpwcms['js_lib']);
                }
                if (empty($template['jslibload'])) {
                    $template['jslibload'] = 0;
                }
                if (empty($template['frontendjs'])) {
                    $template['frontendjs'] = 0;
                }
                if (!isset($template['googleapi'])) {
                    $template['googleapi'] = 1;
                } elseif (empty($template['googleapi'])) {
                    $template['googleapi'] = 0;
                }
            }
            mysqli_free_result($result);
        }
    }

    // show form
    ?>
    <script type="text/javascript">
        function doPageLayoutChange() {
            if (confirm('<?php echo $BL['be_admin_template_jswarning'] ?>')) {
                document.blocks.submit();
                return true;
            } else {
                return false;
            }
        }
    </script>
    <form action="phpwcms.php?do=admin&amp;p=11&amp;s=<?php echo $template["id"] ?>" method="post" name="blocks" target="_self" id="blocks" class="dados-sumario">
        <h1 class="title"><?php echo (empty($createcopy) ? $BL['be_admin_tmpl_edit'] : $BL['be_admin_tmpl_copy']) ?>: <?php echo ($template["id"]) ? html($template["name"]) : $BL['be_admin_tmpl_new']; ?></h1>
        <input type="hidden" name="c" value="<?php echo $createcopy; ?>" />

        <div class="grid-2">

            <p>
                <b><?php echo $BL['be_admin_tmpl_name'] ?></b>




                <?php
// ERICH COPY TEMPLATE 08.06.2005
                if (empty($createcopy)) {
                    echo '<input name="template_name" type="text" id="template_name" value="' . html($template["name"]) . '" size="50" maxlength="150">';
                } else {
                    echo '<img src="img/symbole/achtung.gif" width="13" height="11" alt="" border="0" style="position:absolute; top:7px; left:110px" /><input name="template_name" type="text" class="f11b width350" id="template_name" style="color:FF3300" value="' . html($template["name"]) . '_' . generic_string(2) . '" size="50" maxlength="150">';
                }
                ?>
            </p>
            <p>
                <label class="botoes" for="template_setdefault">
                    <input name="template_setdefault" id="template_setdefault" type="checkbox" value="1" <?php is_checked(empty($createcopy) ? $template["default"] : 0, 1) ?> />
                    <?php echo $BL['be_admin_tmpl_default'] ?>
                </label>
            </p>
        </div>

        <p style="display: none;">
            <b><?php echo $BL['be_admin_tmpl_layout'] ?></b>
            <?php
// get available page layout list
            $jsOnChange = '';
            $opt = "";
            $sql = "SELECT * FROM " . DB_PREPEND . "phpwcms_pagelayout " .
                    "WHERE pagelayout_trash=0 ORDER BY pagelayout_default DESC";
            if ($result = mysqli_query($db, $sql) or die("error while listing pagelayouts")) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $opt .= '<option value="' . $row['pagelayout_id'] . '"';
                    if ($row['pagelayout_id'] == $template["layout"]) {
                        $opt .= ' selected';
                        // try to get additional custom blocks from selected page layout
                        $custom_blocks = unserialize($row['pagelayout_var']);
                        $custom_blocks = explode(', ', trim($custom_blocks['layout_customblocks']));

                        if (is_array($custom_blocks) && count($custom_blocks) && $custom_blocks[0] != '') {
                            $jsOnChange = ' onChange="doPageLayoutChange();"';
                        } else {
                            $jsOnChange = '';
                        }
                    }
                    $opt .= '>' . html($row['pagelayout_name']) . '</option>' . "\n";
                }
                mysqli_free_result($result);
            }

            if ($opt) {
                echo '<select name="template_layout" class="f11b" id="template_layout"' . $jsOnChange . ' >' . LF;
                echo $opt;
                echo '</select>';
            } else {
                echo $BL['be_admin_tmpl_nolayout'] . ' (<a href="phpwcms.php?do=admin&p=8&s=0">' . $BL['be_admin_page_add'] . '</a>)';
            }
            ?>
        </p>


        <p style="display: none;">
            <b><?php echo $BL['be_settings'] ?></b>
            <select name="template_overwrite" id="template_overwrite">
                <option value="" style="font-weight:normal;font-style:italic;"><?php echo $BL['be_admin_tmpl_default']; ?></option>
                <?php
// templates for frontend login
                $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_settings/template_default', 'php');
                if (is_array($tmpllist) && count($tmpllist)) {
                    foreach ($tmpllist as $val) {
                        $selected_val = (isset($template["overwrite"]) && $val == $template["overwrite"]) ? ' selected="selected"' : '';
                        $val = html($val);
                        echo '	<option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
                    }
                }
                ?>
            </select>
        </p>
        <p style="display: none;">
            <?php echo $BL['be_overwrite_default'] ?>
            <br  /><strong>config/phpwcms/conf.template_default.inc.php</strong>
        </p>

        <p>
            <b><?php echo $BL['be_admin_tmpl_css'] ?></b>
            <select name="template_css[]" size="3" multiple="multiple" id="template_css" class="select-templates">
                <?php
                $unselected_css = array();

// get css file list
                if (is_dir("css")) {

                    $css_handle = opendir("css");

                    // browse template CSS diretory and list all available CSS files
                    while ($css_file = readdir($css_handle)) {

                        if ($css_file != "." && $css_file != ".." && preg_match('/^[a-z0-9\. \-_]+\.css$/i', $css_file)) {

                            $unselected_css[$css_file] = $css_file;
                        }
                    }
                    closedir($css_handle);
                }

// now run the css information
                foreach ($template["css"] as $value) {
                    if (isset($unselected_css[$value])) {
                        $css_file = html($value);
                        echo '		<option value="' . $css_file . '" selected="selected" style="font-weight: bold;">' . $css_file . '&nbsp;&nbsp;</option>' . LF;
                        unset($unselected_css[$value]);
                    }
                }
                foreach ($unselected_css as $value) {
                    $css_file = html($value);
                    echo '		<option value="' . $css_file . '">' . $css_file . '&nbsp;&nbsp;</option>' . LF;
                }
                ?>
            </select>

        </p>

        <p style="display: flex;gap:5px">
            <a class="botoes"><i class="fas fa-chevron-up" onclick="moveOptionUp(document.blocks.template_css);"></i></a>
            <a class="botoes"><i class="fas fa-chevron-down" onclick="moveOptionDown(document.blocks.template_css);"></i></a>
        </p>

        <p style="display: none;">

            <b><?php echo $BL['be_admin_tmpl_head'] ?>:&nbsp;<br />&lt;head&gt; &nbsp;</b>
            <textarea name="template_htmlhead" cols="35" rows="6" class="code width440" id="template_htmlhead"><?php echo html_entities($template["htmlhead"]); ?></textarea>

        </p>
        <div class="barra"></div>
        <p>
            <b><?php echo $BL['be_admin_tmpl_head'] ?> &lt;head&gt;</b>
            <textarea name="template_htmlhead_ext" cols="35" rows="4" id="template_htmlhead_ext"><?php echo html_entities($template["htmlhead_ext"]); ?></textarea>
        </p>

        <div class="grid-2">
            <p>
                <b><?php echo $BL['js_lib'] ?></b>


                <select name="template_jslib" id="template_jslib">
                    <?php
                    foreach ($phpwcms['js_lib'] as $key => $value) {

                        echo '		<option value="' . $key . '"';
                        is_selected($template['jslib'], $key);
                        echo '>' . html($value) . '</option>' . LF;
                    }
                    ?>
                </select></p>
            <p>

                <label class="botoes" for="template_jslibload">
                    <input type="checkbox" name="template_jslibload" id="template_jslibload" value="1"<?php is_checked($template['jslibload'], 1); ?> />
                    <?php echo $BL['js_lib_alwaysload'] ?>
                </label>

                <label class="botoes" for="template_googleapi" style="margin: 0 5px">
                    <input type="checkbox" name="template_googleapi" id="template_googleapi" value="1"<?php is_checked($template['googleapi'], 1); ?> />
                    <?php echo $BL['googleapi_load'] ?>
                </label>

                <label class="botoes"for="template_frontendjs">
                    <input type="checkbox" name="template_frontendjs" id="template_frontendjs" value="1"<?php is_checked($template['frontendjs'], 1); ?> />
                    <?php echo $BL['frontendjs_load'] ?>
                </label>
            </p>
        </div>

        <p style="display: none;">
            <b><?php echo $BL['be_admin_tmpl_js'] ?></b>
            <input name="template_jsonload" type="text" id="template_jsonload" value="<?php echo html_entities($template["jsonload"]) ?>" size="50" />
        </p>

        <p style="display: none;">
            <input name="Submit" type="submit" class="button10" value="<?php echo $BL['be_admin_tmpl_button'] ?>" />
            <input type="button" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" onclick="location.href = 'phpwcms.php?do=admin&amp;p=11';" />
        </p>

        <div class="barra"></div>


        <p>
            <b><?php echo $BL['be_admin_page_header'] ?></b>


            <select name="template_block_header[]" size="5" multiple="multiple" id="template_block_header" class="select-templates">
                <?php
                $unselected_header = array();
// get css file list
                if (is_dir("template/themes")) {
                    $header_handle = opendir("template/themes");

                    // browse template HTML diretory and list all available CSS files
                    while ($header_file = readdir($header_handle)) {
                        if ($header_file != "." && $header_file != ".." && preg_match('/^[a-z0-9\. \-_]+\.html$/i', $header_file)) {
                            $unselected_header[$header_file] = $header_file;
                        }
                    }
                    closedir($header_handle);
                }

// now run the css information
                foreach ($template["headertext"] as $value) {
                    if (isset($unselected_header[$value])) {
                        $header_file = html($value);
                        echo ' <option value="' . $header_file . '" selected="selected" style="font-weight: bold;">' . $header_file . '</option>' . LF;
                        unset($unselected_header[$value]);
                    }
                }
                foreach ($unselected_header as $value) {
                    $header_file = html($value);
                    echo '		<option value="' . $header_file . '">' . $header_file . '&nbsp;&nbsp;</option>' . LF;
                }
                ?>
            </select>
        </p>


        <p><b><?php echo $BL['be_admin_page_main'] ?></b>
            <select name="template_block_main[]" size="5" multiple="multiple" id="template_block_main" class="select-templates">
                <?php
                $unselected_main = array();
// get css file list
                if (is_dir("template/themes")) {
                    $main_handle = opendir("template/themes");

                    // browse template HTML diretory and list all available CSS files
                    while ($main_file = readdir($main_handle)) {
                        if ($main_file != "." && $main_file != ".." && preg_match('/^[a-z0-9\. \-_]+\.html$/i', $main_file)) {
                            $unselected_main[$main_file] = $main_file;
                        }
                    }
                    closedir($main_handle);
                }

// now run the css information
                foreach ($template["maintext"] as $value) {
                    if (isset($unselected_main[$value])) {
                        $main_file = html($value);
                        echo ' <option value="' . $main_file . '" selected="selected" style="font-weight: bold;">' . $main_file . '</option>' . LF;
                        unset($unselected_main[$value]);
                    }
                }
                foreach ($unselected_main as $value) {
                    $main_file = html($value);
                    echo '		<option value="' . $main_file . '">' . $main_file . '&nbsp;&nbsp;</option>' . LF;
                }
                ?>
            </select>
        </p>

        <p><b><?php echo $BL['be_admin_page_footer'] ?></b>
            <select name="template_block_footer[]" size="5" multiple="multiple" id="template_block_footer" class="select-templates">
                <?php
                $unselected_footer = array();
// get css file list
                if (is_dir("template/themes")) {
                    $footer_handle = opendir("template/themes");

                    // browse template HTML diretory and list all available CSS files
                    while ($footer_file = readdir($footer_handle)) {
                        if ($footer_file != "." && $footer_file != ".." && preg_match('/^[a-z0-9\. \-_]+\.html$/i', $footer_file)) {
                            $unselected_footer[$footer_file] = $footer_file;
                        }
                    }
                    closedir($footer_handle);
                }

// now run the css information
                foreach ($template["footertext"] as $value) {
                    if (isset($unselected_footer[$value])) {
                        $footer_file = html($value);
                        echo ' <option value="' . $footer_file . '" selected="selected" style="font-weight: bold;">' . $footer_file . '</option>' . LF;
                        unset($unselected_footer[$value]);
                    }
                }
                foreach ($unselected_footer as $value) {
                    $footer_file = html($value);
                    echo '		<option value="' . $footer_file . '">' . $footer_file . '</option>' . LF;
                }
                ?>
            </select></p>


        <?php
        if (!empty($jsOnChange)) {

            echo '<tr><td colspan="2" style="display:none"><img src="img/leer.gif" width="1" height="5" alt="" /></td></tr>';
            echo '<tr><td colspan="2" style="display:none"><img src="img/lines/l538_70.gif" width="' . $phpwcms['LarguraInterna'] . '" height="1" alt="" /></td></tr>';
            echo '<tr bgcolor="#F3F5F8" style="display:none"><td colspan="2"><img src="img/leer.gif" width="1" height="8" alt="" />';
            echo '<input type="hidden" name="customblock" value="' . html(implode(',', $custom_blocks)) . '" />';
            echo "</td></tr>\n";
            // list custom blocks
            foreach ($custom_blocks as $value) {

                $custom_block = html($value);

                echo '<tr bgcolor="#F3F5F8" style="display:none"><td><img src="img/leer.gif" width="1" height="14" alt="" /></td>';
                echo '<td class="chatlist" valign="top">' . $custom_block . " {" . $custom_block . "}</td>\n</tr>\n";
                echo '<tr bgcolor="#F3F5F8" style="display:none"><td>&nbsp;</td>';
                echo '<td><textarea name="template_customblock_' . $custom_block;
                echo '" cols="35" rows="8" class="code width440">';
                echo isset($template['customblock_' . $value]) ? html_entities($template['customblock_' . $value]) : '';
                echo "</textarea></td>\n</tr>\n";
                echo '<tr bgcolor="#F3F5F8" style="display:none"><td colspan="2"><img src="img/leer.gif" width="1" height="7" alt="" /></td></tr>' . "\n";
            }

            echo '<tr bgcolor="#F3F5F8" style="display:none"><td colspan="2"><img src="img/leer.gif" width="1" height="5" alt="" /></td></tr>
	<tr><td colspan="2"><img src="img/lines/l538_70.gif" width="' . $phpwcms['LarguraInterna'] . '" height="1" alt="" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" width="1" height="8" alt="" /></td></tr>';
        }
        ?>
        <p>
            <b><?php echo $BL['be_admin_tmpl_error'] ?>:&nbsp;</b>
            <textarea name="template_block_error" cols="35" rows="5" id="template_block_error"><?php echo html_entities($template["errortext"]); ?></textarea>
        </p>

                <!--<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>-->

        <input name="template_id" type="hidden" value="<?php echo $template["id"] ?>" />

        <div class="controles-salvar">
            <div class="botoes-salvar-wrap">
                <input name="Submit" type="submit" class="button10" value="<?php echo $BL['be_admin_tmpl_button'] ?>" />
                <input type="button" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" onclick="location.href = 'phpwcms.php?do=admin&amp;p=11';" />
            </div>
        </div>

    </form><?php
}
?>