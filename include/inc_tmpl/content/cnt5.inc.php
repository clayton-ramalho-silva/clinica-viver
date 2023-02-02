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
//link list
?>





<tr>
    <td colspan="2">
        <div class="barra"></div>

        <h2>Lista de Videos</h2>
        <p>
            <textarea name="ctext" rows="20" wrap="VIRTUAL" id="ctext" ><?php echo isset($content["text"]) ? html($content["text"]) : '' ?></textarea>
        </p>
    </td>
</tr>

<tr>
    <td colspan="2">
        <div class="barra"></div>
        <h2>Aparência</h2>
        <p>
            <b><?php echo $BL['be_admin_struct_template']; ?></b>
            <select name="template" id="template" class="f11b">
                <?php
                echo '<option value="">' . $BL['be_admin_tmpl_default'] . '</option>' . LF;

// templates for frontend login
                $tmpllist = get_tmpl_files(PHPWCMS_TEMPLATE . 'inc_cntpart/linklist');
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