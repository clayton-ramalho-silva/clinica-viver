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
?><form action="phpwcms.php?do=profile" method="post" name="formprofiledetail" id="formprofiledetail" autocomplete="off">
    <h1 class="title"><?php echo $BL['be_profile_account_title'] ?></h1>



    <table border="0" cellpadding="0" cellspacing="0" summary="" class="dados-sumario" style="width: 100%">

        <tr><td colspan="2">

                <!--<p><?php echo $BL['be_profile_account_text'] ?></p>-->


<?php
//if error during login occurs
if (!empty($err)) {
    echo '<p><strong>';
    echo $BL['be_profile_label_err'];
    echo ':</strong>';
    echo nl2br(chop($err)) . '</p>';
}
?>
                <div class="grid-3">
                <p>
                    <b><?php echo $BL['be_profile_label_username'] ?></b>
                    <input name="form_loginname" type="text" id="form_loginname"  value="<?php echo html($_SESSION["wcs_user"]); ?>" autocomplete="off" />
                </p>

                <p>
                    <b><?php echo $BL['be_profile_label_newpass'] ?></b>
                    <input name="form_password" type="password" id="form_password" autocomplete="off" value="" />
                </p>

                <p>
                    <b><?php echo $BL['be_profile_label_repeatpass'] ?></b>
                    <input name="form_password2" type="password" id="form_password2" autocomplete="off" value="" />
                </p>
                
                </div>

                <p>
                    <b><?php echo $BL['be_profile_label_email'] ?></b>
                    <input name="form_useremail" type="text" id="form_useremail" value="<?php echo html($_SESSION["wcs_user_email"]); ?>" size="30" maxlength="150" autocomplete="off" />
                </p>

                <p style="display: none">
                    <b><?php echo $BL['be_profile_label_lang'] ?></b>
                    <select name="form_lang" id="form_lang">
<?php
// check available languages installed and build language selector menu
include_once PHPWCMS_ROOT . "/include/inc_lang/code.lang.inc.php";
$lang_dirs = opendir(PHPWCMS_ROOT . "/include/inc_lang/backend");
while ($lang_codes = readdir($lang_dirs)) {
    if ($lang_codes != "." && $lang_codes != ".." && file_exists(PHPWCMS_ROOT . "/include/inc_lang/backend/" . $lang_codes . "/lang.inc.php")) {
        echo '<option value="' . $lang_codes . '"';
        if ($lang_codes == $_SESSION["wcs_user_lang"]) {
            echo ' selected="selected"';
        }
        echo '>';
        echo (isset($BL[strtoupper($lang_codes)])) ? $BL[strtoupper($lang_codes)] : strtoupper($lang_codes);
        echo "</option>\n";
    }
}
closedir($lang_dirs);

$wysiwygTemplates['editor'] = empty($_SESSION["WYSIWYG_EDITOR"]) ? 0 : 1;
?>
                    </select>
                </p>

            </td></tr>

        <tr style="display: none">
            <td align="right" valign="top" class="tdtop5"><?php echo $BL['be_WYSIWYG'] ?>:&nbsp;</td>
            <td class="checkbox-list"><label>
                    <input type="checkbox" name="form_wysiwyg" value="1"<?php if (!empty($_SESSION["WYSIWYG_EDITOR"])): ?> checked="checked"<?php endif; ?> />
<?php echo $BL['be_on']; ?> (CKEditor 4.x)
                </label>
                <input type="hidden" name="form_wysiwyg_toolbar" value="" />
            </td>
        </tr>

        <tr style="display: none">
            <td align="right" valign="top" class="tdtop5 nowrap"><?php echo $BL['be_structform_select_cp'] ?>:&nbsp;</td>
            <td class="checkbox-list">
<?php
$has_selected_cp = isset($_SESSION["wcs_user_cp"]) ? count($_SESSION["wcs_user_cp"]) : 0;
$has_allowed_cp = isset($_SESSION["wcs_allowed_cp"]) ? count($_SESSION["wcs_allowed_cp"]) : 0;

foreach ($wcs_content_type as $key => $value):
    if ($has_allowed_cp && !isset($_SESSION["wcs_allowed_cp"][$key])):
        ?>
                        <label class="disabled">
                            <input type="checkbox" disabled="disabled" /> <?php echo html($value) ?>
                        </label>
        <?php
        continue;
    endif;
    ?>
                    <label>
                        <input type="checkbox" name="profile_account_cp[<?php echo $key ?>]" value="<?php echo $key ?>"<?php if (!$has_selected_cp || isset($_SESSION["wcs_user_cp"][$key])): ?> checked="checked"<?php endif; ?> />
                    <?php echo html($value) ?>
                    </label>

                    <?php endforeach; ?>
                <input type="hidden" name="profile_cp_total" value="<?php echo count($wcs_content_type) ?>" />
            </td>
        </tr>

        <tr><td colspan="2"><input name="form_aktion" type="hidden" id="form_aktion" value="update_account"></td></tr>
        <tr>
            <td colspan="2">
                <div class="espacamento"></div>
                <p><input type="submit" name="Submit" value="<?php echo $BL['be_profile_account_button'] ?>" class="button10"></p>
            </td>
        </tr>

    </table></form>