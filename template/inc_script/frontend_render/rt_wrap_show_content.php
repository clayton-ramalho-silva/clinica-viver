<?php
// ==================================================================
// {WRAP_SHOW_CONTENT:...:class}. The same like {SHOW_CONTENT: ...
// but with a enclosed div container
// If there is/are a unfilled or unvisible CP/CPs no output is generated
// (and no div wrapper)
//
// E.g.: {WRAP_SHOW_CONTENT:CP,X}
//
// Default class: WRAP_SHOW_CONTENT
//
// file name: /template/inc_script/frontend_render/rt_wrap_show_content.php
// forum: http://forum.phpwcms.org/viewtopic.php?p=110898#p110898
//
// (c) 07.11.08 Knut Heermann (flip-flop) http://planmatrix.de
//     08.11.08 Updated for a better handling
//     11.01.11 Update parse SHOW_CONTENT a second time
// ==================================================================
// ------------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day."); }
// ------------------------------------------------------------------
 
if( strpos($content['all'], '{WRAP_SHOW_CONTENT:') !== FALSE ) {
 
 
    function func_wrap_show_content($my_param) {
 
        $my_param = str_replace(' ','',$my_param); // kill all spaces
 
        // explode parameter for SHOW_CONTENT and the optional class name
        // $my_arr[0] = SHOW_CONTENT parameter
        // $my_arr[1] = optional own class name
        $my_arr = explode(":",$my_param);
 
        if (!empty($my_arr[1])) { $my_class = $my_arr[1]; }     // custom class name = yes
        else {$my_class = 'WRAP_SHOW_CONTENT'; }                // custom class name = no -> default name
 
        // set the wrapper code
        $div_before = '<div class="'.$my_class.'">'.LF;
        $div_behind = LF.'</div>';
 
        $string = '';
        $string = showSelectedContent($my_arr[0]);     // same as SHOW_CONTENT
 
        // +KH 19.01.11 parse SHOW_CONTENT a second time
        while (strpos($string, '{SHOW_CONTENT:') != false)
           $string = preg_replace('/\{SHOW_CONTENT:(.*?)\}/e', 'showSelectedContent("$1");', $string);
 
        // include external PHP script (also normal HTML snippets) or return PHP var value +KH: 04.04.2010
        if (!empty($phpwcms["allow_cntPHP_rt"]))
            $string = render_PHPcode($string);
 
        // parses all system RTs
        $string = html_parser($string);
 
        // Special for eMail mailto:....
        if ( ($phpwcms["allow_ext_render"]) AND (strpos($string, 'mailto:') != false) ) {
 
           // try to include custom functions and replacement tags or what you want to do at this point of the script
           // default dir: "phpwcms_template/inc_script/frontend_render"; only *.php files are allowed there
           if ( is_file(PHPWCMS_TEMPLATE.'inc_script/frontend_render/makeEmailSpamSave.php') ) {
 
              include_once(PHPWCMS_TEMPLATE.'inc_script/frontend_render/makeEmailSpamSave.php');
              $string = replaceEmailAddress($string);
           }
        }
 
        // Set the wrapper around
        if (!$string == '') { $my_replace  = $div_before.$string.$div_behind; }
        else { $my_replace = ''; }
 
    return $my_replace;
}
 
// And do it ======
$content["all"] = preg_replace('/{WRAP_SHOW_CONTENT:(.*?)}/e', 'func_wrap_show_content("$1")', $content["all"]);
 
}
?>