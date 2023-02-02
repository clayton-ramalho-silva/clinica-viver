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

ini_set('display_errors', 0);

session_start();

$phpwcms = array();
$BL = array();

require_once ('./config/phpwcms/conf.inc.php');
require_once ('./include/inc_lib/default.inc.php');
require_once (PHPWCMS_ROOT . '/include/inc_lib/dbcon.inc.php');

require_once (PHPWCMS_ROOT . '/include/inc_lib/general.inc.php');
require_once (PHPWCMS_ROOT . '/include/inc_lib/backend.functions.inc.php');
require_once (PHPWCMS_ROOT . '/include/inc_lang/code.lang.inc.php');

$_SESSION['REFERER_URL'] = PHPWCMS_URL . get_login_file();

// make compatibility check
if (phpwcms_revision_check_temp($phpwcms["revision"]) !== true) {
    _dbQuery('SET storage_engine=MYISAM', 'SET');
    $revision_status = phpwcms_revision_check($phpwcms["revision"]);
}

// define vars
$err = 0;
$wcs_user = '';

// where user should be redirected too after login
if (!empty($_POST['ref_url'])) {
    $ref_url = xss_clean($_POST['ref_url']);
} elseif (!empty($_GET['ref'])) {
    $ref_url = xss_clean(rawurldecode($_GET['ref']));
} else {
    $ref_url = '';
}


// reset all inactive users
$sql = "UPDATE " . DB_PREPEND . "phpwcms_userlog SET ";
$sql .= "logged_in = 0, logged_change = '" . time() . "' ";
$sql .= "WHERE logged_in = 1 AND ( " . time() . " - logged_change ) > " . intval($phpwcms["max_time"]);
mysqli_query($db, $sql);


//load default language EN
require_once (PHPWCMS_ROOT . '/include/inc_lang/backend/en/lang.inc.php');

//define language and check if language file is available
if (isset($_COOKIE['phpwcmsBELang'])) {
    $temp_lang = strtoupper(substr(trim($_COOKIE['phpwcmsBELang']), 0, 2));
    if (isset($BL[$temp_lang])) {
        $_SESSION["wcs_user_lang"] = strtolower($temp_lang);
    } else {
        setcookie('phpwcmsBELang', '', time() - 3600);
    }
}
if (isset($_POST['form_lang'])) {
    $_SESSION["wcs_user_lang"] = strtolower(substr(clean_slweg($_POST['form_lang']), 0, 2));
    set_language_cookie();
}
if (empty($_SESSION["wcs_user_lang"])) {
    $_SESSION["wcs_user_lang"] = strtolower(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : $phpwcms["default_lang"]);
} else {
    $_SESSION["wcs_user_lang"] = strtolower(substr($_SESSION["wcs_user_lang"], 0, 2));
}
if (isset($BL[strtoupper($_SESSION["wcs_user_lang"])]) && is_file(PHPWCMS_ROOT . '/include/inc_lang/backend/' . $_SESSION["wcs_user_lang"] . '/lang.inc.php')) {
    $_SESSION["wcs_user_lang_custom"] = 1;
} else {
    $_SESSION["wcs_user_lang"] = 'en'; //by ono
    $_SESSION["wcs_user_lang_custom"] = 0;
}
if (!empty($_SESSION["wcs_user_lang_custom"])) {
    //use custom lang if available -> was set in login.php
    $BL['merge_lang_array'][0] = $BL['be_admin_optgroup_label'];
    $BL['merge_lang_array'][1] = $BL['be_cnt_field'];
    include_once (PHPWCMS_ROOT . '/include/inc_lang/backend/' . $_SESSION["wcs_user_lang"] . '/lang.inc.php');
    $BL['be_admin_optgroup_label'] = array_merge($BL['merge_lang_array'][0], $BL['be_admin_optgroup_label']);
    $BL['be_cnt_field'] = array_merge($BL['merge_lang_array'][1], $BL['be_cnt_field']);
}

//WYSIWYG EDITOR:
//0 = no wysiwyg editor (default)
//1 = CKEditor
$phpwcms["wysiwyg_editor"] = empty($phpwcms["wysiwyg_editor"]) ? 0 : 1;
$_SESSION["WYSIWYG_EDITOR"] = $phpwcms["wysiwyg_editor"];


if (isset($_POST['form_aktion']) && $_POST['form_aktion'] == 'login' && isset($_POST['json']) && $_POST['json'] == '1') {

    $login_passed = 0;
    $wysiwyg_template = '';
    $wcs_user = slweg($_POST['form_loginname']);
    $wcs_pass = slweg($_POST['md5pass']);

    $sql_query = "SELECT * FROM " . DB_PREPEND . "phpwcms_user WHERE usr_login='" .
            aporeplace($wcs_user) . "' AND usr_pass='" .
            aporeplace($wcs_pass) . "' AND usr_aktiv=1 AND (usr_fe=1 OR usr_fe=2)";

    if ($result = mysqli_query($db, $sql_query)) {
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["wcs_user"] = $wcs_user;
            $_SESSION["wcs_user_name"] = ($row["usr_name"]) ? $row["usr_name"] : $wcs_user;
            $_SESSION["wcs_user_id"] = $row["usr_id"];
            $_SESSION["wcs_user_aktiv"] = $row["usr_aktiv"];
            $_SESSION["wcs_user_rechte"] = $row["usr_rechte"];
            $_SESSION["wcs_user_email"] = $row["usr_email"];
            $_SESSION["wcs_user_avatar"] = $row["usr_avatar"];
            $_SESSION["wcs_user_logtime"] = time();
            $_SESSION["wcs_user_admin"] = intval($row["usr_admin"]);
            $_SESSION["wcs_user_thumb"] = 1;
            if ($row["usr_lang"]) {
                $_SESSION["wcs_user_lang"] = $row["usr_lang"];
            }

            set_language_cookie();

            $_SESSION["structure"] = @unserialize($row["usr_var_structure"]);
            $_SESSION["klapp"] = @unserialize($row["usr_var_privatefile"]);
            $_SESSION["pklapp"] = @unserialize($row["usr_var_publicfile"]);
            $row["usr_vars"] = @unserialize($row["usr_vars"]);

            // Fallback to CKeditor?
            $_SESSION["WYSIWYG_EDITOR"] = empty($row["usr_wysiwyg"]) ? false : true;

            /*
              if(!empty($phpwcms['wysiwyg_template']['FCKeditor']) && $_SESSION["WYSIWYG_EDITOR"] == 2) {
              $wysiwyg_template = convertStringToArray($phpwcms['wysiwyg_template']['FCKeditor']);
              } elseif(!empty($phpwcms['wysiwyg_template']['CKEditor']) && $_SESSION["WYSIWYG_EDITOR"] == 1) {
              $wysiwyg_template = convertStringToArray($phpwcms['wysiwyg_template']['CKEditor']);
              }
              if(empty($wysiwyg_template) || count($wysiwyg_template) == 0) {
              $wysiwyg_template = array('Basic');
              }

              $_SESSION["WYSIWYG_TEMPLATE"] = empty($row["usr_vars"]['template']) || !in_array($row["usr_vars"]['template'], $wysiwyg_template) ? $wysiwyg_template[0] : $row["usr_vars"]['template'];
             */

            $_SESSION["wcs_user_cp"] = isset($row["usr_vars"]['selected_cp']) && is_array($row["usr_vars"]['selected_cp']) ? $row["usr_vars"]['selected_cp'] : array();
            $_SESSION["wcs_allowed_cp"] = isset($row["usr_vars"]['allowed_cp']) && is_array($row["usr_vars"]['allowed_cp']) ? $row["usr_vars"]['allowed_cp'] : array();

            // Test if there are CPs that use had choosen but no longer available for
            if (count($_SESSION["wcs_allowed_cp"])) {
                if (count($_SESSION["wcs_user_cp"])) {
                    // Remove selected CP if not allowed CP
                    foreach ($_SESSION["wcs_user_cp"] as $key => $value) {
                        if (!isset($_SESSION["wcs_allowed_cp"][$key])) {
                            unset($_SESSION["wcs_user_cp"][$key]);
                        }
                    }
                } else {
                    $_SESSION["wcs_user_cp"] = $_SESSION["wcs_allowed_cp"];
                }
            }

            $login_passed = 1;
        }
        mysqli_free_result($result);
    }

    if ($login_passed) {
        // Store login information in DB
        $check = mysqli_query($db, "SELECT COUNT(*) FROM " . DB_PREPEND . "phpwcms_userlog WHERE logged_user='" .
                aporeplace($wcs_user) . "' AND logged_in=1");
        if ($row = mysqli_fetch_row($check)) {
            if (!$row[0]) {
                // User not yet logged in, create new
                mysqli_query($db, "INSERT INTO " . DB_PREPEND . "phpwcms_userlog " .
                        "(logged_user, logged_username, logged_start, logged_change, " .
                        "logged_in, logged_ip) VALUES ('" .
                        aporeplace($wcs_user) . "', '" . aporeplace($_SESSION["wcs_user_name"]) . "', " . time() . ", " .
                        time() . ", 1, '" . aporeplace(getRemoteIP()) . "')");
            }
        }
        mysqli_free_result($check);
        $_SESSION['PHPWCMS_ROOT'] = PHPWCMS_ROOT;
        set_status_message('Welcome ' . $wcs_user . '!');

        if ($ref_url) {
            headerRedirect($ref_url . '&' . session_name() . '=' . session_id());
        } else {
            headerRedirect(PHPWCMS_URL . "phpwcms.php?do=articles&" . session_name() . '=' . session_id());
        }
    } else {
        $err = 1;
    }
} elseif (isset($_POST['json']) && intval($_POST['json']) != 1) {

    $err = 1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title><?php echo $BL['be_page_title'] . ' - ' . PHPWCMS_HOST ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo PHPWCMS_CHARSET ?>" />
        <meta name="robots" content="noindex, nofollow" />
        <link href="include/inc_css/login.css" rel="stylesheet" type="text/css" />
        <link href="include/inc_fonts/css/all.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="include/inc_js/phpwcms.js"></script>
        <script type="text/javascript" src="include/inc_js/md5.js"></script>
        <?php
        if ((isset($_SESSION["wcs_user_lang"]) && $_SESSION["wcs_user_lang"] == 'ar') || strtolower($phpwcms['default_lang']) == 'ar') {
            echo '  <style type="text/css">' . LF . '<!--' . LF . '* {direction: rtl;}' . LF . '// -->' . LF . '</style>';
        }
        ?>
    </head>
    <body>
        <script>
            function mouseoverPass(obj) {
                var obj = document.getElementById('form_password');
                obj.type = "text";
            }
            function mouseoutPass(obj) {
                var obj = document.getElementById('form_password');
                obj.type = "password";
            }
        </script>
        <div id="loginFormArea" class="bloco-login">

            <div class="error"><?php
                echo $BL['be_login_jsinfo'];
                ?></div>
        </div>
        <?php
// get whole login form and keep in buffer
        ob_start();
        ?>
        <div class="logo"></div>

        <form action="<?php echo PHPWCMS_URL . get_login_file() ?>" method="post" name="login_formular" id="login_formular" onsubmit="return login(this);" autocomplete="off">
            <input type="hidden" name="json" id="json" value="0" />
            <input type="hidden" name="md5pass" id="md5pass" value="" autocomplete="off" />
            <input type="hidden" name="ref_url" value="<?php echo html_specialchars($ref_url) ?>" />
            <input name="form_aktion" type="hidden" id="form_aktion" value="login" />
            <?php
            if (file_exists(PHPWCMS_ROOT . '/setup')) {
                echo '<div class="error alerta">Delete a pasta SETUP!</div>';
            }
            if (file_exists(PHPWCMS_ROOT . '/phpwcms_code_snippets')) {
                echo '<div class="error">Delete a pasta SETUP!</div>';
            }

            if (isset($_POST['json']) && $_POST['json'] == 2)
                $err = 0;

            if ($err) {
                echo '<div class="error">' . $BL["login_error"] . '</div>';
            }

            echo '<div class="error" style="display:none;" id="jserr">' . $BL["login_error"] . '</div>';
            ?>

            <p>
                <i class="fas fa-user"></i>
                <input name="form_loginname" type="text" id="form_loginname"  value="<?php echo html_specialchars($wcs_user); ?>" placeholder="Usu&aacute;rio"/>
            </p>

            <p>
                <i class="fas fa-key"></i>
                <i class="fas fa-eye" onclick="mouseoverPass();" onmouseout="mouseoutPass();"  id="olho" style="position: absolute; top:0; left:83%; color: #ff3881"></i>
                <input name="form_password" type="password" id="form_password"  placeholder="Senha" />
            </p>

            <p class="submit">
                <input name="submit_form" type="submit" value="Entrar" />
            </p>
        </form>
        <?php
        $formAll = str_replace(array("'", "\r", "\n", '<'), array("\'", '', " ", "<'+'"), ob_get_clean());
        ?><script type="text/javascript">
            getObjectById('loginFormArea').innerHTML = '<?php echo $formAll ?>';
            getObjectById('form_loginname').focus();
        </script>
        <?php if (!empty($phpwcms['browser_check']['be'])): ?>
            <script type="text/javascript">
                $buoop = {<?php
        if (!empty($phpwcms['browser_check']['vs'])) {
            echo 'vs:' . $phpwcms['browser_check']['vs'];
        }
        ?>};
            </script>
            <script type="text/javascript" src="http://browser-update.org/update.js"></script>
        <?php endif; ?>
    </body>
</html>