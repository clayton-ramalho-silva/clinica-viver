<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// **************************************************************************
// 25.07.07 horizontal drop-down with ID output -> NAVI HORIZONTAL DROP-DOWN
// Oliver Georgi
// http://www.phpwcms.de/forum/viewtopic.php?p=89743#89743
// 08.11.07 KH (flip-flop) Enhanced: Start[ID] {NAV_HORIZ_DD:ID}
// 28.04.08 KH (flip-flop) Enhanced: Level depth {NAV_HORIZ_DD:ID,Depth}
// http://www.phpwcms.de/forum/viewtopic.php?p=94688#94688
//
// TAG:      {NAV_HORIZ_DD:ID,Level depth}
// Location: Put it into the file e.g.:
//           /template/inc_script/frontend_render/rt_nav_horiz_drop_down.php
// Switch in conf.inc.php: $phpwcms['allow_ext_render']  = 1;
// **************************************************************************

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

if( ! ( strpos($content["all"],'{MENU')==false ) ) {

    $content["all"] = str_replace('{MENU}','{MENU:0,100}',$content["all"]);
    $content["all"] = preg_replace('/\{MENU:(.*?)\}/i','{MENU:$1,100}', $content["all"]);
    $content["all"] = preg_replace_callback('/\{MENU:(.*?),(.*?)\}/',function($matches){
        return buildNavi_horiz($matches[1],"0",$matches[2]);
     }, $content["all"]);
    // $content["all"] = preg_replace('/\{MENU:(.*?),(.*?)\}/e','buildNavi_horiz("$1","0","$2");', $content["all"]);
    // $content["all"] = preg_replace('/\{MENU:(.*?),(.*?)\}/e','buildNavi_horiz("$1","0","$2"-1);', $content["all"]);

}

//   $content['all'] = str_replace('{NAVI}', buildNavi(), $content['all']);

function buildNavi_horiz($start=0, $counter=0, $depth=0) {

    // Verifica se o item 'Home' est� desativado
    $skip_home = (_getConfig('homeMenu') === 1)     ? 1 : 0;
    $show_news = (_getConfig('noticiasMenu') == '1') ? 1 : 0;

    $t = array();

    $struct = getStructureChildData($start);  // Catch structure

    usort($struct, function($a, $b) {
        return $a['acat_sort'] - $b['acat_sort'];
    });

    // echo '<pre>';
    // var_dump($struct);
    // echo '</pre>';

    if($counter == 0) {
        $last = count($struct) - 1;
    } else {
        $last = 0;
    }

    $x = 0;

    foreach($struct as $value) {

        if($value['acat_menu'] !== '1'){

            continue;

        } else {

            if($skip_home === 1 && $value['acat_name'] === 'Home' ){

                continue;

            } else {

                // Is it a active path ? ========
                if( isset($GLOBALS['LEVEL_KEY'][ $value['acat_id'] ]) ) {

                    $p1 = 'ativo';
                } else {
                    $s  = ''; // Reset $struct
                    $p1 = '';
                }

                // Only if there is a sub level ========
                if($GLOBALS['content']['cat_id'] == $value['acat_id']) {
                    $a1 = 'ativo'; // Only for a direct call (FirstLevel active)
                    $a3 = '';      // Not in use
                } else {           // If first level isn´t active
                    $a1 = $p1;
                    $a3 = '';
                }
                // ==========================

                // -- <D01> -------------------------------------------------------------------
                // Preset level depth added
                // $s = buildNavi_horiz($value['acat_id'], $counter+1);
                if (($counter) < $depth) {
                    $s = buildNavi_horiz($value['acat_id'], $counter+1, $depth);
                } else {
                    $s = '';
                }

                // -- <D01> -------------------------------------------------------------------
                if($s) {

                    $g  = '<!--[if IE 7]><!--></a><!--<![endif]-->';
                    $g .= $s;
                    $g .= LF . str_repeat('   ', $counter);

                    // $class = $counter ? (' class="fly_ul '.$a1.'"') : (' class="drop_ul '.$a1.'"');
                    // Second level with active category
                    $class = $counter ? (' class="fly_ul"') : (' class="'.$a1.'"');

                    $close_li = str_repeat('   ', $counter+1);

                } else {

                    $g  = '</a>';
                    $class = ' class="sub_no"'; // If you don´t use the sub_no please change to: $class = '';
                    // -- <P01> -------------------------------------------------------------------
                    // Only the first level if there is no sub level
                    if ($counter == 0) {
                        $class = ' class="sub_no'.$a1.'"';  // Set it, it is active or not
                    // -- <P01> -------------------------------------------------------------------
                    }

                    $close_li = '';

                }

                //    first li in block          =======
                //    Erstes li im letzten Block =======
                if( $last && $last == $x ) {
                    $enclose = ' class="horiz_enclose"';
                    $class = ' class="'.$a1.' cat-id_' . $value['acat_id'] . ' ultimo-link"';
                } elseif( $x || ($counter == 0 && $x == 0) ) {
                    $enclose = '';
                    $class = ' class="'.$a1.' cat-id_' . $value['acat_id'] . '"';
                } else {
                    $enclose = ' class="horiz_enclose"';
                    $class = ' class="'.$a1.' cat-id_' . $value['acat_id'] . ' ultimo-link"';
                }

                //    IDs for every li  ======= If you need the ID class, please uncomment/comment
                $l  = str_repeat('   ', $counter+1) . '<li'. $class . '>';
                // $l  = str_repeat('   ', $counter+1) . '<li'. $li_enclose . '>';

                $l .= get_level_ahref($value['acat_id'], $enclose) . html_specialchars($value['acat_name']);
                $l .= $g;

                $l .=  $close_li . '</li>';

                $t[] = $l;

                $x++;

            }

        }

   }

    if($counter) {

        $A = LF . str_repeat('   ', $counter) . '<!--[if lte IE 6]><table><tr><td><![endif]-->';
        $B = LF . str_repeat('   ', $counter) . '<!--[if lte IE 6]></td></tr></table></a><![endif]-->';

    } else {

        $A = '';
        $B = '';

    }

    $t = implode(LF, $t);

    if($t) {
        $t =   $A . LF . str_repeat('   ', $counter) .   '<ul'.($counter?' class="psubmenu"':' class="pmenu"').'>' . LF . $t . LF . str_repeat('   ', $counter) . '</ul>'.   $B ;
    }

    /*
    // -- <E01> -------------------------------------------------------------------
    // EDIT: 07/11/25 KH. (flip-flop) including simple Tags in category headline from the file
    //  /include/inc_front/front.func.inc.php  and the function html_parser($string)
    // you can copy&paste what you want.

    // ========== copy&paste ===========

    // typical html formattings
    $search[18]      = '/\[i\](.*?)\[\/i\]/is';         $replace[18]   = '<i>$1</i>';
    $search[19]      = '/\[u\](.*?)\[\/u\]/is';         $replace[19]   = '<u>$1</u>';
    $search[20]      = '/\[s\](.*?)\[\/s\]/is';         $replace[20]   = '<strike>$1</strike>';
    $search[21]      = '/\[b\](.*?)\[\/b\]/is';         $replace[21]   = '<strong>$1</strong>';

    // ========== end copy&paste ========

    $t = preg_replace($search, $replace, $t);

    // -- <E01> -------------------------------------------------------------------
    */

    return $t;

}

// EOF