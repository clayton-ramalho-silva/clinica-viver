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
//file list

if (empty($content["file_descr"]))
    $content["file_descr"] = '';
$content['file']['direct_download'] = empty($content['file']['direct_download']) ? 0 : 1;
?>




<tr>

    <td colspan="2">
        <div class="barra"></div>

        <h2>Lista de Arquivos</h2>

        <p class="botoes-subir-img">
            <a class="botoes bt-imagem" href="javascript:;" title="<?php echo $BL['be_cnt_openfilebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=4&amp;target=nolist')"><i class="fas fa-file-upload"></i> Escolher Arquivos</a>
            <a class="botoes" href="javascript:;" title="<?php echo $BL['be_cnt_sortup'] ?>" onclick="moveOptionUp(document.articlecontent.cfile_list);"><i class="fas fa-chevron-up"></i></a>
            <a class="botoes" href="javascript:;" title="<?php echo $BL['be_cnt_sortdown'] ?>" onclick="moveOptionDown(document.articlecontent.cfile_list);"><i class="fas fa-chevron-down"></i></a>
            <a class="botoes bt-delete" href="javascript:;" onclick="removeSelectedOptions(document.articlecontent.cfile_list);" title="<?php echo $BL['be_cnt_delfile'] ?>"><i class="far fa-trash-alt"></i></a>
        </p>

        <p>
            <select name="cfile_list[]" size="8" multiple class="lista-downloads" id="cfile_list">
                <?php
                if (isset($content["file_list"]) && is_array($content["file_list"]) && count($content["file_list"])) {
                    $fx = 0;
                    $fxa = "";
                    $fxb = array();
                    foreach ($content["file_list"] as $key => $value) {
                        if ($fx)
                            $fxa .= " OR ";
                        $fxa .= "f_id=" . intval($value);
                        $fxb[$key]["fid"] = intval($value);
                        $fx++;
                    }
                    if ($fx) {
                        $file_sql = "SELECT f_id, f_name FROM " . DB_PREPEND . "phpwcms_file WHERE f_public=1 AND f_aktiv=1" .
                                " AND f_kid=1 AND f_trash=0 AND (" . $fxa . ");"; //f_uid=".$_SESSION["wcs_user_id"]
                        if ($file_result = mysqli_query($db, $file_sql) or die("error while retrieving file list file's info")) {
                            while ($file_row = mysqli_fetch_row($file_result)) {
                                foreach ($fxb as $key => $value) {
                                    if ($fxb[$key]["fid"] == $file_row[0]) {
                                        $fxb[$key]["fname"] = html($file_row[1]);
                                    }
                                }
                            }
                        }
                        foreach ($fxb as $key => $value) {
                            if (!empty($fxb[$key]["fname"])) {
                                echo "<option value=\"" . $fxb[$key]["fid"] . "\">" . $fxb[$key]["fname"] . "</option>\n";
                            }
                        }
                        unset($fxb);
                        unset($content["file_list"]);
                    }
                }
                ?>
            </select>
        </p>

        <h2>Descrição</h2>
        <p>
            <textarea name="cfile_descr" cols="40" rows="8"  id="cfile_descr"><?php
                if (!empty($content["file_descr"]) && ($content["file_descr"]{0} == "\r" || $content["file_descr"]{0} == "\n")) {
                    echo ' ';
                }
                echo html($content["file_descr"]);
                ?>
            </textarea>
        </p>

        <p>
            <span class="caption">
                <?php echo $BL['be_cnt_description']; ?>
                |
                <?php echo $BL['be_fprivedit_filename']; ?>
                |
                <?php echo $BL['be_caption_file_title']; ?>
                |
                <?php echo $BL['be_cnt_target']; ?>
                |
                <?php echo $BL['be_caption_file_imagesize']; ?>
                |
                <?php echo $BL['be_copyright']; ?>&nbsp;&crarr;&nbsp;&hellip;
            </span>
        </p>

    </td>
</tr>


<tr>
    <td>
        <p>
            <label class="botoes" for="cfile_direct"><input name="cfile_direct" id="cfile_direct" type="checkbox" value="1" <?php is_checked(1, $content['file']['direct_download']); ?>> <?php echo $BL['be_cnt_download_direct'] ?> </label>
        </p>
    </td>
</tr>

<tr>
    <td colspan="2">
        <div class="barra"></div>
        <h2>Texto de Introdução</h2>
        <div class="espacamento"></div>
    </td>
</tr>

<tr><td colspan="2" align="center"><?php
        $wysiwyg_editor = array(
            'value' => isset($content["html"]) ? $content["html"] : '',
            'field' => 'chtml',
            'height2' => '100',
            'width2' => '"100%"',
            'rows' => '15',
            'editor' => $_SESSION["WYSIWYG_EDITOR"],
            'expanded' => '0',
            'lang' => 'en'
        );

        include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
        ?></td></tr>



<tr>

    <td colspan="2">
        <div class="barra"></div>

        <h2>Aparência</h2>
        <p>
            <b><?php echo $BL['be_admin_struct_template'] ?></b>
            <select name="cfile_template" id="cfile_template" class="f11b">

                <?php
                echo '<option value="">' . $BL['be_admin_tmpl_default'] . '</option>' . LF;

// templates for recipes
                $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/filelist');
                if (is_array($tmpllist) && count($tmpllist)) {
                    foreach ($tmpllist as $val) {
                        if (isset($content['file_template']) && $val == $content['file_template']) {
                            $selected_val = ' selected="selected"';
                        } else {
                            $selected_val = '';
                        }
                        $val = htmlspecialchars($val);
                        echo '	<option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
                    }
                }
                ?>
            </select>
        </p>
    </td>
</tr>