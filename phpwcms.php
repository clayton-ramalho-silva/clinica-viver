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
require_once('fix_mysql.inc.php');

 // ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// set page processiong start time
list($usec, $sec) = explode(' ', microtime());
$phpwcms_rendering_start = $usec + $sec;

session_start();

//define used var names
$body_onload = '';
$forward_to_message_center = false;
$wcsnav = array();
$indexpage = array();
$phpwcms = array();
$BL = array();
$BE = array('HTML' => '', 'BODY_OPEN' => array(), 'BODY_CLOSE' => array(), 'HEADER' => array(), 'LANG' => 'en');

// check against user's language
if (!empty($_SESSION["wcs_user_lang"]) && preg_match('/[a-z]{2}/i', $_SESSION["wcs_user_lang"])) {
    $BE['LANG'] = $_SESSION["wcs_user_lang"];
}

// Lista de mÃ³dulos com pÃ¡gina completa
$modulos = array('shop', 'sistema', 'comments', 'menu', 'dados_empresa');

require_once 'config/phpwcms/conf.inc.php';
require_once 'include/inc_lib/default.inc.php';
require_once PHPWCMS_ROOT . '/include/inc_lib/dbcon.inc.php';
require_once PHPWCMS_ROOT . '/include/inc_lib/general.inc.php';
checkLogin();
require_once PHPWCMS_ROOT . '/include/inc_lib/backend.functions.inc.php';
require_once PHPWCMS_ROOT . '/include/inc_lib/default.backend.inc.php';

//load default language EN
require_once PHPWCMS_ROOT . '/include/inc_lang/backend/en/lang.inc.php';
include_once PHPWCMS_ROOT . "/include/inc_lang/code.lang.inc.php";
$BL['modules'] = array();

if (!empty($_SESSION["wcs_user_lang_custom"])) {
    //use custom lang if available -> was set in login.php
    $BL['merge_lang_array'][0] = $BL['be_admin_optgroup_label'];
    $BL['merge_lang_array'][1] = $BL['be_cnt_field'];
    include PHPWCMS_ROOT . '/include/inc_lang/backend/' . $BE['LANG'] . '/lang.inc.php';
    $BL['be_admin_optgroup_label'] = array_merge($BL['merge_lang_array'][0], $BL['be_admin_optgroup_label']);
    $BL['be_cnt_field'] = array_merge($BL['merge_lang_array'][1], $BL['be_cnt_field']);
    unset($BL['merge_lang_array']);
}

require_once PHPWCMS_ROOT . '/include/inc_lib/navi_text.inc.php';
require_once PHPWCMS_ROOT . '/include/inc_lib/checkmessage.inc.php';
require_once PHPWCMS_ROOT . '/config/phpwcms/conf.template_default.inc.php';
require_once PHPWCMS_ROOT . '/config/phpwcms/conf.indexpage.inc.php';
require_once PHPWCMS_ROOT . '/include/inc_lib/imagick.convert.inc.php';

// check modules
require_once PHPWCMS_ROOT . '/include/inc_lib/modules.check.inc.php';

// load array with actual content types
include PHPWCMS_ROOT . '/include/inc_lib/article.contenttype.inc.php';

$BL['be_admin_struct_index'] = html_specialchars($indexpage['acat_name']);


$subnav = ''; //Sub Navigation
$p = isset($_GET["p"]) ? intval($_GET["p"]) : 0; //which page should be opened
$do = isset($_GET["do"]) ? $_GET["do"] : 'default'; //which backend section and which $do action
$module = isset($_GET['module']) ? clean_slweg($_GET['module']) : ''; //which module
$phpwcms['be_parse_lang_process'] = false; // limit parsing for BBCode/BraceCode languages only to some sections

switch ($do) {

    case "articles": //articles
        include(PHPWCMS_ROOT . '/include/inc_lib/admin.functions.inc.php');
        $wcsnav["articles"] = "<strong class=\"navtexta\">" . $wcsnav["articles"] . "</strong>";
        include(PHPWCMS_ROOT . '/include/inc_lib/article.functions.inc.php'); //load article funtions
        $subnav .= subnavtext($BL['be_subnav_article_center'], "phpwcms.php?do=articles", $p, "", 0);
        $subnav .= subnavtext($BL['be_subnav_article_new'], "phpwcms.php?do=articles&amp;p=1&amp;struct=0", $p, "1", 0);
        $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="5" width="1" alt="" /></td></tr>' . "\n";
        $subnav .= subnavtext($BL['be_news'], "phpwcms.php?do=articles&amp;p=3", $p, "3", 0);
        break;

    case "files":  //files
        $wcsnav["files"] = "<strong class=\"navtexta\">" . $wcsnav["files"] . "</strong>";
        $subnav .= subnavtext($BL['be_subnav_file_center'], "phpwcms.php?do=files", $p, "", 0);

        // based on pwmod by pagewerkstatt.ch 12/2012
        $subnav .= subnavtext($BL['be_subnav_file_actions'], "phpwcms.php?do=files&amp;p=4", $p, "4", 0);

        $subnav .= subnavtext($BL['be_file_multiple_upload'], "phpwcms.php?do=files&amp;p=8", $p, "8", 0);
        break;

    case "modules":  //modules
        $wcsnav["modules"] = "<strong class=\"navtexta\">" . $wcsnav["modules"] . "</strong>";

        foreach ($phpwcms['modules'] as $value) {

            if ($value['type'] == 2) {
                continue;
            }

            $subnav .= subnavtext($BL['modules'][$value['name']]['backend_menu'], 'phpwcms.php?do=modules&amp;module=' . $value['name'], $module, $value['name'], 0);
        }

        break;

    case "messages": //messages
        $wcsnav["messages"] = "<strong class=\"navtexta\">" . $wcsnav["messages"] . "</strong>";
        // ----------- Adicionada a parte "&& !empty($phpwcms['enable_messages'])" para nÃ£o mostrar as opÃ§Ãµes do lado esquerdo de "Lista de E-mails" ---------
        if (isset($_SESSION["wcs_user_admin"]) && $_SESSION["wcs_user_admin"] == 1 && !empty($phpwcms['enable_messages'])) {
            // ----------------------------------------------------------------------------------------------------
            $subnav .= subnavtext($BL['be_subnav_msg_newslettersend'], "phpwcms.php?do=messages&amp;p=3aaa", $p, "3", 0);
            $subnav .= subnavtext($BL['be_subnav_msg_subscribers'], "phpwcms.php?do=messages&amp;p=4aaa", $p, "4", 0);
            $subnav .= subnavtext($BL['be_subnav_msg_newsletter'], "phpwcms.php?do=messages&amp;p=2aaa", $p, "2", 0);

            if (!empty($phpwcms['enable_messages'])) {
                $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="5" width="1" alt="" /></td></tr>' . "\n";
            }
        }
        if (!empty($phpwcms['enable_messages'])) {
            $subnav .= subnavtext($BL['be_subnav_msg_center'], "phpwcms.php?do=messages", $p, "", 0);
            $subnav .= subnavtext($BL['be_subnav_msg_new'], "phpwcms.php?do=messages&amp;p=1", $p, "1", 0);
        }
        break;

    case "discuss":  //discuss
        $wcsnav["discuss"] = "<strong class=\"navtexta\">" . $wcsnav["discuss"] . "</strong>";
        break;

    case "chat":  //chat
        $wcsnav["chat"] = "<strong class=\"navtexta\">" . $wcsnav["chat"] . "</strong>";
        $subnav .= subnavtext($BL['be_subnav_chat_main'], "phpwcms.php?do=chat", $p, "", 0);
        $subnav .= subnavtext($BL['be_subnav_chat_internal'], "phpwcms.php?do=chat&amp;p=1", $p, "1", 0);
        break;

    case "profile":  //profile
        $wcsnav["profile"] = "<strong class=\"navtexta\">" . $wcsnav["profile"] . "</strong>";
        if (!empty($_POST["form_aktion"])) {
            switch ($_POST["form_aktion"]) { //Aktualisieren der wcs account & profile Daten
                case "update_account": include(PHPWCMS_ROOT . '/include/inc_lib/profile.updateaccount.inc.php');
                    break;
                case "update_detail": include(PHPWCMS_ROOT . '/include/inc_lib/profile.update.inc.php');
                    break;
                case "create_detail": include(PHPWCMS_ROOT . '/include/inc_lib/profile.create.inc.php');
                    break;
            }
        }
        $subnav .= subnavtext($BL['be_subnav_profile_login'], "phpwcms.php?do=profile", $p, "", 0);
        $subnav .= subnavtext($BL['be_subnav_profile_personal'], "phpwcms.php?do=profile&amp;p=1", $p, "1", 0);
        break;

    case "logout":  //Logout
        $sql = "UPDATE " . DB_PREPEND . "phpwcms_userlog SET logged_change=" . _dbEscape(time()) . ", logged_in=0 ";
        $sql .= "WHERE logged_user=" . _dbEscape($_SESSION["wcs_user"]) . " AND logged_in=1";
        _dbQuery($sql, 'UPDATE');
        session_destroy();
        headerRedirect(PHPWCMS_URL . get_login_file());
        break;

    case "admin":  //Admin
        if (!empty($_SESSION["wcs_user_admin"])) {
            include(PHPWCMS_ROOT . '/include/inc_lib/admin.functions.inc.php');
            $subnav .= subnavtext($BL['be_subnav_admin_sitestructure'], "phpwcms.php?do=admin&amp;p=6", $p, "6", 0);
            $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="5" width="1" alt="" /></td></tr>' . "\n";
            $subnav .= subnavtext($BL['be_subnav_admin_pagelayout'], "phpwcms.php?do=admin&amp;p=8", $p, "8", 0);
            $subnav .= subnavtext($BL['be_subnav_admin_templates'], "phpwcms.php?do=admin&amp;p=11", $p, "11", 0);
            $subnav .= subnavtext($BL['be_subnav_admin_css'], "phpwcms.php?do=admin&amp;p=10", $p, "10", 0);
            $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="5" width="1" alt="" /></td></tr>' . "\n";
            $subnav .= subnavtext($BL['be_subnav_admin_users'], "phpwcms.php?do=admin", $p, "", 0);
            if (!empty($phpwcms['usergroup_support'])) {
                $subnav .= subnavtext($BL['be_subnav_admin_groups'], "phpwcms.php?do=admin&amp;p=1", $p, "1", 0);
            }
            $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="15" width="1" alt="" /></td></tr>' . "\n";
            //$subnav .= subnavtext($BL['be_admin_keywords'], "phpwcms.php?do=admin&amp;p=5", $p, "5", 0);
            $subnav .= subnavtext($BL['be_subnav_admin_filecat'], "phpwcms.php?do=admin&amp;p=7", $p, "7", 0);
            $subnav .= subnavtext($BL['be_subnav_admin_starttext'], "phpwcms.php?do=admin&amp;p=12", $p, "12", 0);
            $subnav .= subnavtext($BL['be_alias'], 'phpwcms.php?do=admin&amp;p=13', $p, "13", 0);
            $subnav .= subnavtext($BL['be_link'] . ' &amp; ' . $BL['be_redirect'], 'phpwcms.php?do=admin&amp;p=14', $p, "14", 0);

            $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="15" width="1" alt="" /></td></tr>' . "\n";
            //$subnav .= subnavtext($BL['be_cnt_cache_update'], 'include/inc_act/act_cache.php', 1, 0, 0);
            //$subnav .= subnavtext($BL['be_cnt_cache_delete'], 'include/inc_act/act_cache.php?do=9', 1, 0, 0, 'onclick="return confirm(\''.$BL['be_cnt_cache_delete_msg'].'\');" ');
            $subnav .= subnavtext($BL['be_flush_image_cache'], '#', 1, 0, 0, 'onclick="return flush_image_cache(this,\'include/inc_act/ajax_connector.php?action=flush_image_cache&value=1\');" ');
            $subnav .= subnavtext($BL['be_cnt_move_deleted'], 'include/inc_act/act_file.php?movedeletedfiles=' . $_SESSION["wcs_user_id"], 1, 0, 0, 'onclick="return confirm(\'' . $BL['be_cnt_move_deleted_msg'] . '\');" ');
            $subnav .= '<tr><td colspan="2"><img src="img/leer.gif" height="15" width="1" alt="" /></td></tr>' . "\n";
            $subnav .= subnavtextext('phpinfo()', 'include/inc_act/act_phpinfo.php', '_blank', 0);
        }
        break;
}

//Subnav Wrap Text Tabelle
if ($subnav) {
    $subnav = '<table border="0" cellpadding="0" cellspacing="0" summary="">' . LF . $subnav;
    $subnav .= "<tr><td colspan=\"2\"><img src=\"img/leer.gif\" width=\"1\" height=\"15\" alt=\"\" /></td></tr>\n</table>";
}

//Wenn der User kein Admin ist, anderenfalls
if (empty($_SESSION["wcs_user_admin"])) {
    unset($wcsnav["admin"]);
} elseif ($do == "admin") {
    $wcsnav["admin"] = '<strong class="navtexta">' . $wcsnav["admin"] . '</strong>';
}

//script chaching to allow header redirect
ob_start(); //without Compression
// set correct content type for backend
header('Content-Type: text/html; charset=' . PHPWCMS_CHARSET);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $BL['be_page_title'] . ' - ' . PHPWCMS_HOST ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= PHPWCMS_CHARSET ?>">
        <link href="include/inc_css/phpwcms.css" rel="stylesheet" type="text/css">
        <link href="include/inc_css/admin.css" rel="stylesheet" type="text/css">
        <link href="include/inc_fonts/css/all.css" rel="stylesheet" type="text/css">
        <meta name="robots" content="noindex, nofollow">

        <?php
        $BE['HEADER']['alias_slah_var'] = '	<script type="text/javascript"> ' . LF . '		var aliasAllowSlashes = ' . (PHPWCMS_ALIAS_WSLASH ? 'true' : 'false') . ';' . LF . '	</script>';
        $BE['HEADER'][] = getJavaScriptSourceLink('template/lib/jquery/jquery-1.11.1.min.js');

        initMootools();
        $BE['HEADER']['phpwcms.js'] = getJavaScriptSourceLink('include/inc_js/phpwcms.js');

        if ($do == "messages" && $p == 1) {

            include(PHPWCMS_ROOT . '/include/inc_lib/message.sendjs.inc.php');
        } elseif ($do == "articles") {

            if ($p == 2 && isset($_GET["aktion"]) && intval($_GET["aktion"]) == 2) {
                initJsOptionSelect();
            }
            if (($p == 1) || ($p == 2 && isset($_GET["aktion"]) && intval($_GET["aktion"]) == 1)) {
                initJsCalendar();
            }
        } elseif ($do == 'admin' && ($p == 6 || $p == 11)) {

            // struct editor
            initJsOptionSelect();
        }

        if ($BE['LANG'] == 'ar') {
            $BE['HEADER'][] = '<style type="text/css">' . LF . '<!--' . LF . '* {direction: rtl;}' . LF . '// -->' . LF . '</style>';
        }
        ?>
        <!-- phpwcms HEADER -->
    </head>

    <body<?= $body_onload ?>>

        <!-- Menu -->
        <div class="menu-superior">
            <section>

                <a class="bt-visualizar-site button10" href="<?= PHPWCMS_URL ?>" target="_blank">Visualizar Site</a>

                <div class="busca">
                    <form action="phpwcms.php" method="POST">
                        <input type="text" name="backend_search_input" placeholder="Busca" value="<?php
                        if (isset($_POST['backend_search_input'])) {
                            $_SESSION['phpwcms_backend_search'] = clean_slweg($_POST['backend_search_input']);
                        }

                        if (!empty($_SESSION['phpwcms_backend_search'])) {
                            echo html_specialchars($_SESSION['phpwcms_backend_search']);
                        }
                        ?>">
                        <i class="fa fa-search"></i>
                    </form>
                </div>

            </section>

        </div>


        <div class="sidebar">
            <div class="logo_content">
                <div class="logo">
                    <div class="logo_name">
<!--                        <div class="empresa-logado">
                            <span>N</span>
                            Nome da Empresa
                        </div>-->
                    </div>
                </div>
                <i class="fas fa-bars" id="btn"></i>
            </div>
            <ul class="nav_list">

                <li>
                    <a href="phpwcms.php?do=articles">
                        <i class="fas fa-home"></i>
                        <span class="links_name">Home</span>
                    </a>
                    <span class="tooltip">Home</span>
                </li>

                <li>
                    <a href="phpwcms.php?do=modules&module=dados_empresa">
                        <i class="fas fa-info-circle"></i>
                        <span class="links_name">Sobre a Empresa</span>
                    </a>
                    <span class="tooltip">Sobre a Empresa</span>
                </li>
                <li>
                    <a href="phpwcms.php?do=files">
                        <i class="fas fa-file-image"></i>
                        <span class="links_name">Imagens e Arquivos</span>
                    </a>
                    <span class="tooltip">Imagens e Arquivos</span>
                </li>
                <li>
                    <a href="phpwcms.php?do=modules&module=menu">
                        <i class="fas fa-ellipsis-v"></i>
                        <span class="links_name">Menu do Site</span>
                    </a>
                    <span class="tooltip">Menu do Site</span>
                </li>
                <li>
                    <a href="phpwcms.php?do=modules">
                        <i class="fas fa-puzzle-piece"></i>
                        <span class="links_name">Módulos</span>
                    </a>
                    <span class="tooltip">Módulos</span>
                </li>
                <li>
                    <a href="phpwcms.php?do=messages&p=4">
                        <i class="fas fa-envelope"></i>
                        <span class="links_name">Newsletter</span>
                    </a>
                    <span class="tooltip">Newsletter</span>
                </li>
                <li>
                    <a href="phpwcms.php?do=profile">
                        <i class="fas fa-user"></i>
                        <span class="links_name">Perfil</span>
                    </a>
                    <span class="tooltip">Perfil</span>
                </li>
                <li>
                    <a href="phpwcms.php?do=admin&p=6">
                        <i class="fas fa-cog"></i>
                        <span class="links_name">Administrador</span>
                    </a>
                    <span class="tooltip">Administrador</span>
                </li>

                <li>
                    <a href="phpwcms.php">

                        <i class="fas fa-history"></i>
                        <span class="links_name">Histórico</span>
                    </a>
                    <span class="tooltip">Histórico</span>
                </li>

                <li>
                    <a href="#" onclick="abrirLado()" >

                        <i class="far fa-object-group"></i>
                        <span class="links_name">Mais Configurações</span>
                    </a>
                    <span class="tooltip">Mais Configurações</span>
                </li>

                <li class="bt-sair">

                    <a href="phpwcms.php?do=logout">
                        <i class="fas fa-times-circle"></i>
                        <span class="links_name">Sair</span>
                    </a>
                    <span class="tooltip">Sair</span>
                </li>
            </ul>

        </div>

        <script>
            let btn = document.querySelector("#btn");
            let sidebar = document.querySelector(".sidebar");
            let searchBtn = document.querySelector(".bx-search");

            btn.onclick = function () {
                sidebar.classList.toggle("active");
            }





        </script>

        <script>

            function abrirLado() {
                var element = document.getElementById("left-side");
                element.classList.toggle("ativo");
            }


        </script>


        <div class="container-principal">
            <!-- phpwcms BODY_OPEN -->
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" summary="main layout structure">
            <!--	<tr>
                        <td colspan="6">
                            <div style="position:relative;margin:15px 15px 10px 5px;"><a href="<?= PHPWCMS_URL ?>" class="v10" style="position:absolute;right:0;bottom:5px;color:#FFFFFF" target="_blank"><?= PHPWCMS_HOST ?></a>
                            </div>
                            </td>
                </tr>-->
                <tr style="display: none" height="40px">
                       <!--<td valign="top">&nbsp;</td>-->
                    <td colspan="6"  valign="top"><table style="width:100%;min-width:740px" border="0" cellpadding="0" cellspacing="0" summary="sub structure">

                            <tr>
                                <td valign="top" class="navtext"><?php
                                    // create backend main navigation
                                    if ($phpwcms['Modo'] == 1) {
                                        if ($do == 'default') {
                                            echo '<strong class="navtexta"><a href="phpwcms.php"><i class="fas fa-home"></i> Home</a></strong>';
                                        } else {
                                            echo '<a href="phpwcms.php"><i class="fas fa-home"></i> Home</a>';
                                        }
                                    }
                                    echo implode('', $wcsnav);
                                    ?></td>
                                <td align="right" valign="top" class="navtext botao-logout"><a href="phpwcms.php?do=logout" target="_top" style="float:right"><?= $BL['be_nav_logout'] ?></a></td>
                            </tr>
                        </table></td>
                            <!--<td valign="top" style="height:40px;">&nbsp;</td>-->
                </tr>
                <!--<tr bgcolor="#FFFFFF">-->
                <tr bgcolor="">
                    <!--<td width="15" bgcolor="#FFFFFF" style="background-image:url(img/backend/preinfo2_r7_c2.gif);background-repeat:repeat-y;"><img src="img/leer.gif" alt="" width="15" height="1"></td>-->

                    <?php
                    if (!in_array($_GET['module'], $modulos, true)) {
                        ?>


        <!--<td width="10" bgcolor="#FFFFFF"><img src="img/leer.gif" alt="" width="10" height="1"></td>-->
        <!--<td width="15" bgcolor="#FFFFFF"><img src="img/leer.gif" alt="" width="15" height="200"></td>-->
                        <?
                        } else {
                        ?>
                    <!--<td width="0" bgcolor="#FFFFFF"><img src="img/leer.gif" alt="" width="0" height="1"></td>-->
                    <!--<td width="0" bgcolor="#FFFFFF"><img src="img/leer.gif" alt="" width="0" height="1"></td>-->
                    <!--<td width="0" bgcolor="#FFFFFF"><img src="img/leer.gif" alt="" width="0" height="1"></td>-->
                        <?
                        }
                        ?>
                        <td width="100%" valign="top" id="be_main_content">{STATUS_MESSAGE}{BE_PARSE_LANG}<!--BE_MAIN_CONTENT_START//-->

                            <div id="left-side"><?php
                                echo $subnav . LF;
                                ?>
                                <!--        <hr style="margin:0 0 15px 0; width:200px; border:0; border-top:1px solid #9A9A9A">
                                        <div class="form-pesquisa" style="float:left">
                                                        <form action="phpwcms.php" method="POST" class="backend-search">
                                                                <h1 class="title" style="margin:0 0 3px 0;"><?= $BL['be_ctype_search'] ?></h1>
                                                                <input type="text" name="backend_search_input" value="<?php
                                if (isset($_POST['backend_search_input'])) {
                                    $_SESSION['phpwcms_backend_search'] = clean_slweg($_POST['backend_search_input']);
                                }

                                if (!empty($_SESSION['phpwcms_backend_search'])) {
                                    echo html_specialchars($_SESSION['phpwcms_backend_search']);
                                }
                                ?>" class="backend-search-input pesquisa-right v11" style="float:left" /><input type="image" src="img/famfamfam/magnifier.png" class="backend-search-button" style="float:left" />
                                                        </form>
                                        </div>-->

                                <div style="clear:both"></div>
                                <hr style="margin:15px 0 15px 0; width:200px; border:0; border-top:1px solid #9A9A9A">
                                <a href="#" onclick="abrirLado()" ><b>[ Fechar ]</b></a>
                                    <!--<a href="?do=modules&module=menu" style="margin:20px 0 5px 0; clear:both; display:block; text-align:center;"><img src="img/icon/bot-menu.png" width="195" height="46" border="0"/></a>-->
                                <!-- HABILITAR O BOTÃO SHOP CART-->
                                <!--<?
                                require_once 'config/phpwcms/conf.inc.php';
                                if ($phpwcms['btDados'] == 1){
                                echo '<a href="?do=modules&module=dados_empresa" style="margin:20px 0 5px 0; clear:both; display:block; text-align:center;"><img src="img/icon/dados-empresa.png" width="195" height="46" border="0"/></a>';
                                }
                                if ($phpwcms['btPedido'] == 1){
                                echo '<a href="?do=modules&module=shop" style="margin:20px 0 5px 0; clear:both; display:block; text-align:center;"><img src="img/icon/bot-shopCart.png" width="195" height="46" border="0"/></a>';
                                }
                                if ($phpwcms['btBanners'] == 1){
                                echo '<a href="?do=modules&module=ads" style="margin:20px 0 5px 0; clear:both; display:block; text-align:center;"><img src="img/icon/bot-banners.png" width="195" height="46" border="0"/></a>';
                                }
                                if ($phpwcms['btSistema'] == 1){
                                echo '<a href="?do=modules&module=sistema" style="margin:20px 0 5px 0; clear:both; display:block; text-align:center;"><img src="img/icon/bot-sistema.png" width="195" height="46" border="0"/></a>';
                                }
                                ?>-->
                                <!-- -->
                            </div>

                            <?php
                            switch ($do) {

                                case "profile": //Profile
                                    if ($p === 1) {
                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/profile.data.tmpl.php');
                                    } else {
                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/profile.account.tmpl.php');
                                    }
                                    break;

                                case "files": // File manager
                                    if ($p === 8) { //FTP File upload
                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/files.ftptakeover.tmpl.php');

                                        // based on pwmod by pagewerkstatt.ch 12/2012
                                    } elseif ($p === 4) {

                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/files.actions.tmpl.php');
                                    } else {

                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/files.reiter.tmpl.php'); //Files Navigation/Reiter
                                        switch ($files_folder) {
                                            case 0: //Listing der Privaten Dateien
                                                if (isset($_GET["mkdir"]) || (isset($_POST["dir_aktion"]) && intval($_POST["dir_aktion"]) == 1)) {
                                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/files.private.newdir.tmpl.php');
                                                }
                                                if (isset($_GET["editdir"]) || (isset($_POST["dir_aktion"]) && intval($_POST["dir_aktion"]) == 2)) {
                                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/files.private.editdir.tmpl.php');
                                                }
                                                if (isset($_GET["upload"]) || (isset($_POST["file_aktion"]) && intval($_POST["file_aktion"]) == 1)) {
                                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/files.private.upload.tmpl.php');
                                                }
                                                if (isset($_GET["editfile"]) || (isset($_POST["file_aktion"]) && intval($_POST["file_aktion"]) == 2)) {
                                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/files.private.editfile.tmpl.php');
                                                }
                                                include(PHPWCMS_ROOT . '/include/inc_lib/files.private-functions.inc.php'); //Listing-Funktionen einfÃ¼gen
                                                include(PHPWCMS_ROOT . '/include/inc_lib/files.private.additions.inc.php'); //ZusÃ¤tzliche Private Funktionen
                                                break;

                                            case 1: //Funktionen zum Listen von Public Files
                                                include(PHPWCMS_ROOT . '/include/inc_lib/files.public-functions.inc.php'); //Public Listing-Funktionen einfÃ¼gen
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/files.public.list.tmpl.php'); //Elemetares fÃ¼r Public Listing
                                                break;

                                            case 2: //Dateien im Papierkorb
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/files.private.trash.tmpl.php');
                                                break;

                                            case 3: //Dateisuche
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/files.search.tmpl.php');
                                                break;
                                        }
                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/files.abschluss.tmpl.php');
                                    }
                                    break;

                                case "chat": //Chat
                                    if ($p === 1) {
                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/chat.list.tmpl.php');
                                        break; //Chat/Listing
                                    } else {
                                        include(PHPWCMS_ROOT . '/include/inc_tmpl/chat.main.tmpl.php');
                                        break; //Chat Startseite
                                    }
                                    break;

                                case "messages": //Messages
                                    switch ($p) {
                                        case 0: include(PHPWCMS_ROOT . '/include/inc_tmpl/message.center.tmpl.php');
                                            break; //Messages Overview
                                        case 1: include(PHPWCMS_ROOT . '/include/inc_tmpl/message.send.tmpl.php');
                                            break; //New Message
                                        case 2: //Newsletter subscription
                                            if ($_SESSION["wcs_user_admin"] == 1)
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/message.subscription.tmpl.php');
                                            break;
                                        case 3: //Newsletter
                                            if ($_SESSION["wcs_user_admin"] == 1)
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/newsletter.list.tmpl.php');
                                            break;
                                        case 4: //Newsletter subscribers
                                            if ($_SESSION["wcs_user_admin"] == 1) {
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/message.subscribers.tmpl.php');
                                            }
                                            break;
                                    }
                                    break;

                                case "modules": //Modules
                                    // if a module is selected
                                    if (isset($phpwcms['modules'][$module])) {

                                        include($phpwcms['modules'][$module]['path'] . 'backend.default.php');
                                    }

                                    break;

                                case "admin": //Administration
                                    if ($_SESSION["wcs_user_admin"] == 1) {
                                        switch ($p) {
                                            case 0: //User Administration
                                                switch (!empty($_GET['s']) ? intval($_GET["s"]) : 0) {
                                                    case 1: include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.newuser.tmpl.php');
                                                        break; //New User
                                                    case 2: include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.edituser.tmpl.php');
                                                        break; //Edit User
                                                }
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.listuser.tmpl.php');
                                                break;

                                            case 1: //Users and Groups
                                                //enym new group management tool
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.groups.tmpl.php');
                                                break;

                                            case 2: //Settings
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.settings.tmpl.php');
                                                break;

                                            case 5: //Keywords
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.keyword.tmpl.php');
                                                break;

                                            case 6: //article structure

                                                include(PHPWCMS_ROOT . '/include/inc_lib/admin.structure.inc.php');
                                                if (isset($_GET["struct"])) {
                                                    //include(PHPWCMS_ROOT.'/include/inc_lib/article.contenttype.inc.php'); //loading array with actual content types
                                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.structform.tmpl.php');
                                                } else {
                                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.structlist.tmpl.php');
                                                    $phpwcms['be_parse_lang_process'] = true;
                                                }
                                                break;

                                            case 7: //File Categories
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.filecat.tmpl.php');
                                                break;

                                            case 8: //Page Layout
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.pagelayout.tmpl.php');
                                                break;

                                            case 10: //Frontend CSS
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.frontendcss.tmpl.php');
                                                break;

                                            case 11: //Templates
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.templates.tmpl.php');
                                                break;

                                            case 12: //Default backend starup HTML
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.startup.tmpl.php');
                                                break;

                                            //Default backend sitemap HTML
                                            case 13:
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.aliaslist.tmpl.php');
                                                break;

                                            //Default backend sitemap HTML
                                            case 14:
                                                include(PHPWCMS_ROOT . '/include/inc_tmpl/admin.redirect.tmpl.php');
                                                break;
                                        }
                                    }
                                    break;

                                // articles
                                case "articles":
                                    $_SESSION['image_browser_article'] = 0; //set how image file browser should work
                                    switch ($p) {

                                        // List articles
                                        case 0:
                                            include(PHPWCMS_ROOT . '/include/inc_tmpl/article.structlist.tmpl.php');
                                            $phpwcms['be_parse_lang_process'] = true;
                                            break;

                                        // Edit/create article
                                        case 1:
                                        case 2:
                                            include(PHPWCMS_ROOT . '/include/inc_lib/article.editcontent.inc.php');
                                            break;

                                        // News
                                        case 3:
                                            include(PHPWCMS_ROOT . '/include/inc_lib/news.inc.php');
                                            include(PHPWCMS_ROOT . '/include/inc_tmpl/news.tmpl.php');
                                            break;
                                    }
                                    break;

                                // about phpwcms
                                case "about":
                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/about.tmpl.php');
                                    break;

                                // start
                                default:
                                    include(PHPWCMS_ROOT . '/include/inc_tmpl/be_start.tmpl.php');
                                    include(PHPWCMS_TEMPLATE . 'inc_default/startup.php');
                                    $phpwcms['be_parse_lang_process'] = true;
                            }
                            ?>

                            <!--BE_MAIN_CONTENT_END//--></td>
                          <!--<td width="15" bgcolor="#FFFFFF" style="background-image:url(img/backend/preinfo2_r7_c7.gif);background-repeat:repeat-y;background-position:right;"><img src="img/leer.gif" alt="" width="15" height="1"></td>-->
                    </tr>
            <!--	<tr>
                      <td width="15"><img src="img/leer.gif" alt="" width="14" height="17"></td>
                      <td colspan="5" valign="bottom" class="navtext darkblue" style="padding: 8px 0 15px 0; text-align:center;">
                                    <a href="http://www.phpwcms.org" title="phpwcms">phpwcms <?= PHPWCMS_VERSION ?></a>
                                    &copy; 2002&#8212;<?= date('Y'); ?>
                                    <a href="mailto:oliver@phpwcms.de?subject=phpwcms">Oliver Georgi</a>.
                                    <a href="phpwcms.php?do=about" title="<?= $BL['be_aboutlink_title'] ?>">Licensed under GPL. Extensions are copyright	of their respective owners.</a>
                            </td>
              </tr>-->
                </table>
            </div>
            <?php
//Set Focus for chat insert filed
            set_chat_focus($do, $p);

//If new message was sent -> automatic forwarding to message center
            forward_to($forward_to_message_center, PHPWCMS_URL . "phpwcms.php?do=messages", 2500);
            ?>

            <!-- phpwcms BODY_CLOSE -->

        </body>
    </html>
    <?php
// retrieve complete processing time
    list($usec, $sec) = explode(' ', microtime());
    header('X-phpwcms-Page-Processed-In: ' . number_format(1000 * ($usec + $sec - $phpwcms_rendering_start), 3) . ' ms');

    $BE['HTML'] = ob_get_clean();

// Load ToolTip JS only when necessary
    if (strpos($BE['HTML'], '"Tip(')) {
        $BE['BODY_CLOSE']['wz_tooltip.js'] = getJavaScriptSourceLink('include/inc_js/wz_tooltip.js', '');
    }

//	parse for backend languages
    backend_language_parser();

//	replace special backend sections -> good for additional code like custom JavaScript, CSS and so on
//	<!-- phpwcms BODY_CLOSE -->
//	<!-- phpwcms BODY_OPEN -->
//	<!-- phpwcms HEADER -->
// special body onload JavaScript
    if ($body_onload) {
        $BE['HTML'] = str_replace('<body>', '<body ' . $body_onload . '>', $BE['HTML']);
    }

    $BE['HEADER'][] = '  <!--[if lte IE 7]><style type="text/css">body{behavior:url("' . TEMPLATE_PATH . 'inc_css/specific/csshover3.htc");}</style><![endif]-->';

// html head section
    $BE['HTML'] = str_replace('<!-- phpwcms HEADER -->', implode(LF, $BE['HEADER']), $BE['HTML']);

// body open area
    $BE['HTML'] = str_replace('<!-- phpwcms BODY_OPEN -->', implode(LF, $BE['BODY_OPEN']), $BE['HTML']);

// body close area
    $BE['HTML'] = str_replace('<!-- phpwcms BODY_CLOSE -->', implode(LF, $BE['BODY_CLOSE']), $BE['HTML']);

// Show global system status message
    $BE['HTML'] = str_replace('{STATUS_MESSAGE}', show_status_message(true), $BE['HTML']);

// return all
    echo $BE['HTML'];
    ?>