<?php
/**
 *******************************************************************
 * Different Browse NEXT/PREV/UP for category/article-view in
 * simple or listing article mode
 * The Link text is generated from the article title and/or subtitle
 *  or category title or own input
 * - Browse next/prev to the article if the user is in a article detail view
 *  (article listing mode set) with optional loop
 * - Browse next/prev/up to the parent category if the user is in a
 *   article detail view (simple article mode) or category view
 * - Browse up from article detail view to the category (article listing mode set)
 *
 * V1.0: 07.07.2010 K.Heerrmann http://planmatrix.de
 * TAG: {XBROWSE:NEXT/PREV:[LinkText|Link article title]:[off|on|loop]}
 * E.g. {XBROWSE:NEXT:>> | >>:2} ===> Link = ">> article title >>",
 *                                    loop = last to first article
 *  "Link Text" or | or ||
 *       =  "Link Text" or "Link article title" or or "Link article subtitle"
 *  0=off  =  no jump to the next/prev category if the article is the last/first one
 *  1=on   =  next/prev category follows last/first article
 *  2=loop =  last/first article follows first/last article in list mode
 *
 *
 * Filename: rt_xbrowse_neprup.php
 * Folder:  /template/inc_script/frontend_render/
 * Switch:  $phpwcms['allow_ext_render'] = 1; (/config/phpwcms/conf.inc.php)
 *
 * Forum:   --
 *******************************************************************/
// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day."); }
// ----------------------------------------------------------------
 
 
 
// Tag available // Tag im Content gesetzt?  Z.B. {XBROWSE:NEXT:^^^^}
 
if(strpos($content["all"],'{XBROWSE:') !== false) {
 
 
// ************ CUSTOM VAR ***********************************************
 
    $up_no_linktext       = '--';        // +KH: if no link is available
    $up_max_char_count    = 30;          // +KH: max chars in link text
    $up_max_char_affix  = '&hellip;';    // +KH: affix if > max_char_count
    $up_prefix_no_link    = '<span class="xbrowse-unolink">';
    $up_sufix_no_link     = '</span>';
 
    $next_no_linktext     = '--';        // +KH: if no link is available
    $next_max_char_count  = 30;          // +KH: max chars in link text
    $next_max_char_affix  = '&hellip;';  // +KH: affix if > max_char_count
    $next_prefix_no_link  = '<span class="xbrowse-nnolink">';
    $next_sufix_no_link   = '</span>';
 
    $prev_no_linktext     = '--';        // +KH: if no link is available
    $prev_max_char_count  = 30;          // +KH: max chars in link text
    $prev_max_char_affix  = '&hellip;';  // +KH: affix if > max_char_count
    $prev_prefix_no_link  = '<span class="xbrowse-pnolink">';
    $prev_sufix_no_link   = '</span>';
 
// ************ END CUSTOM VAR *******************************************
 
 
 
 
 
// UP ==========================================================
 
function xget_index_link_up($linktext, $no_linktext, $max_char_count, $max_char_affix,$prefix_no_link,$sufix_no_link) {
 
 
    $link = '';
    $cat_id = $GLOBALS['content']["cat_id"];
 
    if (empty($linktext)) $linktext = '^UP^';
 
    // In detail view if article listing mode is set
    // In der Detailansicht wenn Artikellisten-Modus aktiv
    if ( empty($GLOBALS['aktion']['3']) ) {
 
        // Jump to the category   // gehe zur Kategorie
        $link = $GLOBALS['content']["struct"][$GLOBALS['content']["cat_id"]]["acat_alias"];
        $link = '<a class="xbrowse-up" href="index.php?'.$link.'">';
 
    // In category view if normal article- or listing mode set
    // In der Kategorie bei infachem & Artikellisten-Modus
    }
    // Jump to parent category   // gehe zur Eltern-Kategorie
    elseif($cat_id && !$GLOBALS['content']['struct'][$cat_id]['acat_hidden']) {
        $upid = $GLOBALS['content']['struct'][$cat_id]['acat_struct'];
        $link = '<a class="xbrowse-up" href="index.php?' . ( empty($GLOBALS['content']['struct'][$upid]['acat_alias']) ? 'id='.$upid : $GLOBALS['content']['struct'][$upid]['acat_alias'] ) .'">';
        $cat_id = $upid;
    }
 
    $linktext = str_replace('||','',$linktext);    // +KH
 
    // Is there any placeholder in linktext and link available?
    if (!$link AND strpos($linktext, '|'))
        $linktext = str_replace('|',  $no_linktext, $linktext);
 
    // generate the linktext
    $cat_name = $GLOBALS['content']['struct'][$cat_id]['acat_name'];
    $linktext = str_replace('|',((strlen($cat_name) > $max_char_count)?
        substr($cat_name,0,$max_char_count).$max_char_affix:
        $cat_name),
    $linktext);    // +KH
 
 
return ($link) ? $link.$linktext.'</a>' : $prefix_no_link.$linktext.$sufix_no_link;
 
}
 
 
// NEXT ========================================================
 
function xget_index_link_next($linktext, $cat_down=0, $no_linktext, $max_char_count, $max_char_affix,$prefix_no_link,$sufix_no_link) {
 
 
    global $content;
 
    // return the link to next article in current ctageory
    $a_id = isset($content['article_id']) ? $content['article_id'] : $GLOBALS['aktion'][1];
    $linktext = trim($linktext);
    if(!$linktext) {
        $linktext = 'NEXT';
        $no_linktext = $linktext;
    }
    $link = '';
    $article = false;  // +KH: article mode
 
 
    if(count($content['articles']) > 1) {
 
        $c = 0; //temp counter
        $f = 0; //+KH: temp id for first article
        foreach($content['articles'] as $key => $value) {
            if (!$f) $f = $key;  // +KH: first article ID
            if($c || !$a_id) {
                $link          = '<a class="xbrowse-next" href="index.php?aid='.$key.'">';
                $article     = true;  // +KH: article mode
                break;
            }
            if($key == $a_id) $c++;
        }
        // +KH: loop is selected and last article in use
        if ($cat_down == 2 && !$link ) {
            $key         = $f;    // set up the right key from first article
            $article     = true;  // +KH: article mode
            $link          = '<a class="xbrowse-next xbrowse-nlast" href="index.php?aid='.$key.'">';  // +KH: last article
        }
    }
 
    if($cat_down && !$link) {
        // go cat down or to next cat above
 
        if($content['cat_id']) {
            foreach($content['struct'] as $key => $value) {
                if($content['struct'][$key]['acat_struct'] == $content['cat_id']) {
                    $link  = '<a class="xbrowse-next xbrowse-ncat" href="index.php?';
                    $link .= empty($content['struct'][$key]['acat_alias']) ? 'id='.$key : html_specialchars($content['struct'][$key]['acat_alias']);
                    $link .= '">';
                    break;
                }
            }
        } else {
            $c = 0;
            foreach($content['struct'] as $key => $value) {
                if($c) {
                    $link  = '<a class="xbrowse-next xbrowse-ncat" href="index.php?';
                    $link .= empty($content['struct'][$key]['acat_alias']) ? 'id='.$key : html_specialchars($content['struct'][$key]['acat_alias']);
                    $link .= '">';
                    break;
                }
                $c++;
            }
        }
 
        if(!$link && $content['cat_id']) {
            $c=0;
            $temp_key = array();
            foreach($content['struct'] as $key => $value) {
                if($content['struct'][$key]['acat_struct'] == $content['struct'][ $content['cat_id'] ]['acat_struct']) {
                    $temp_key[] = $key;
                }
            }
            $count_temp = count($temp_key);
            if($count_temp) {
                $c=0;
                foreach($temp_key as $value) {
                    if($value == $content['cat_id'] && $c+1 < $count_temp) {
                        //$link = '<a href="index.php?id='.$temp_key[$c+1].',0,0,1,0,0">';
 
                        $key = $temp_key[$c+1];
 
                        $link  = '<a class="xbrowse-next xbrowse-oho" href="index.php?';
                        $link .= empty($content['struct'][$key]['acat_alias']) ? 'id='.$key : html_specialchars($content['struct'][$key]['acat_alias']);
                        $link .= '">';
                        break;
                    }
                    $c++;
                }
                if($c == $count_temp && !$link) {
                    // back reverese to higher next structure level
                    $current_id = $content['cat_id'];
 
                    while($c=1) {
                        $parent_id = $content['struct'][ $current_id ]['acat_struct'];
                        $parent_struct_id = $content['struct'][ $parent_id ]['acat_struct'];
 
                        $c=0;
                        foreach($content['struct'] as $key => $value) {
                            if($content['struct'][$key]['acat_struct'] == $parent_struct_id) {
                                if($c) {
                                    $link  = '<a class="xbrowse-next xbrowse-ncat" href="index.php?';
                                    $link .= empty($content['struct'][$key]['acat_alias']) ? 'id='.$key : html_specialchars($content['struct'][$key]['acat_alias']);
                                    $link .= '">';
                                    break;
                                }
                                if($key == $parent_id) $c=1;
                            }
                        }
 
                        if(!$parent_struct_id) {
                            if(!$parent_id) $link = '';
                            break;
                        } else {
                            $current_id = $parent_id;
                        }
 
                    }
 
 
                }
            }
        }
 
    }
 
    // +KH: replace article title/subtitle if | or || is available
    if ($link) {
 
        if ($article) {
 
            $linktext = str_replace('||',((strlen($content['articles'][$key]['article_subtitle']) > $max_char_count)?
            substr($content['articles'][$key]['article_subtitle'],0,$max_char_count).$max_char_affix:
            $content['articles'][$key]['article_subtitle']),
            $linktext);    // +KH
            $linktext = str_replace('|',((strlen($content['articles'][$key]['article_title']) > $max_char_count)?
            substr($content['articles'][$key]['article_title'],0,$max_char_count).$max_char_affix:
            $content['articles'][$key]['article_title']),
            $linktext);    // +KH
        } else {
            $linktext = str_replace('||','',$linktext);    // +KH
            $linktext = str_replace('|',((strlen($content['struct'][$key]['acat_name']) > $max_char_count)?
            substr($content['struct'][$key]['acat_name'],0,$max_char_count).$max_char_affix:
            $content['struct'][$key]['acat_name']),
            $linktext);    // +KH
        }
 
    } else {
 
        // Is there any placeholder in linktext?
        if (strpos($linktext, '|')) {
            $linktext = str_replace('||', $no_linktext, $linktext);
            $linktext = str_replace('|',  $no_linktext, $linktext);
//            $linktext = $no_linktext;  // +KH: if no link is available
        }
    }
 
    return ($link) ? $link.$linktext.'</a>' : $prefix_no_link.$linktext.$sufix_no_link;
}
 
 
// PREV ====================================================
 
function xget_index_link_prev($linktext, $cat_up=0, $no_linktext, $max_char_count, $max_char_affix, $prefix_no_link,$sufix_no_link) {
 
 
    global $content;
 
    // return the link to next article in current ctageory
    $a_id = isset($GLOBALS['content']['article_id']) ? $GLOBALS['content']['article_id'] : $GLOBALS['aktion'][1];
    $linktext = trim($linktext);
    if(!$linktext) {
        $linktext = 'PREV';
        $no_linktext = $linktext;
    }
    $link = '';
    $article = false;  // +KH: article mode
 
    $c = 0; //temp counter
 
    if(count($GLOBALS['content']['articles']) > 1 && $a_id) {
 
        foreach($GLOBALS['content']['articles'] as $key => $value) {
            if($key == $a_id && $c) {
                $link      = '<a class="xbrowse-prev" href="index.php?aid='.$prev_art_id.'">';
                $article = true;  // +KH: article mode
                break;
            }
            $c++;
            $prev_cat_id = $GLOBALS['content']['articles'][$key]['article_cid'];
            $prev_art_id = $key;
        }
        $key =$prev_art_id; // +KH
 
        // +KH: loop is selected and first article in use
        if ($cat_up == 2 && !$link ) {
            foreach($GLOBALS['content']['articles'] as $key => $value) {}  // last artikle key
            $article = true;  // +KH: article mode
            $link      = '<a class="xbrowse-prev xbrowse-pfirst" href="index.php?aid='.$key.'">';  // +KH: last article link
        }
    }
    if($cat_up && $a_id && $c && !$link) {
        $link = '<a class="xbrowse-prev xbrowse-pcat" href="index.php?id='.$GLOBALS['content']['cat_id'].',0,0,1,0,0">';
    }
 
    if($cat_up && !$link) {
        // go cat down or to next cat above
        $temp_key = array();
        foreach($GLOBALS['content']['struct'] as $key => $value) {
            if($GLOBALS['content']['struct'][$key]['acat_struct'] == $GLOBALS['content']['struct'][ $GLOBALS['content']['cat_id'] ]['acat_struct']) {
                $temp_key[] = $key;
            }
        }
        if(count($temp_key) && $GLOBALS['content']['cat_id']) {
            $c = 0;
            foreach($temp_key as $value) {
                if($value == $GLOBALS['content']['cat_id']) {
                    $prev_cat_id = (!$c) ? $GLOBALS['content']['struct'][$value]['acat_struct'] : $temp_key[$c-1];
                    $link = '<a class="xbrowse-prev xbrowse-pcat" href="index.php?id='.$prev_cat_id.',0,0,1,0,0">';
                    break;
                }
                $c++;
            }
        }
    }
 
    // +KH: replace article title/subtitle if | or || is available
    if ($link) {
 
        if ($article) {
 
            $linktext = str_replace('||',((strlen($content['articles'][$key]['article_subtitle']) > $max_char_count)?
            substr($content['articles'][$key]['article_subtitle'],0,$max_char_count).$max_char_affix:
            $content['articles'][$key]['article_subtitle']),
            $linktext);    // +KH
            $linktext = str_replace('|',((strlen($content['articles'][$key]['article_title']) > $max_char_count)?
            substr($content['articles'][$key]['article_title'],0,$max_char_count).$max_char_affix:
            $content['articles'][$key]['article_title']),
            $linktext);    // +KH
        } else {
            $linktext = str_replace('||','',$linktext);    // +KH
            $linktext = str_replace('|',((strlen($content['struct'][$prev_cat_id]['acat_name']) > $max_char_count)?
            substr($content['struct'][$prev_cat_id]['acat_name'],0,$max_char_count).$max_char_affix:
            $content['struct'][$prev_cat_id]['acat_name']),
            $linktext);    // +KH
        }
 
    } else {
 
        // Is there any placeholder in linktext?
        if (strpos($linktext, '|')) {
            $linktext = str_replace('||', $no_linktext, $linktext);
            $linktext = str_replace('|',  $no_linktext, $linktext);
//            $linktext = $no_linktext;  // +KH: if no link is available
        }
    }
    return ($link) ? $link.$linktext.'</a>' : $prefix_no_link.$linktext.$sufix_no_link;
 
}
 
 
    $content["all"] = preg_replace('/\{XBROWSE:UP:(.*?)\}/e','xget_index_link_up("$1",$up_no_linktext,$up_max_char_count,$up_max_char_affix,$up_prefix_no_link,$up_sufix_no_link);',$content["all"]);
    $content["all"] = preg_replace('/\{XBROWSE:NEXT:(.*?):(0|1|2)\}/e','xget_index_link_next("$1",$2,$next_no_linktext,$next_max_char_count,$next_max_char_affix,$next_prefix_no_link,$next_sufix_no_link);',$content["all"]);
    $content["all"] = preg_replace('/\{XBROWSE:PREV:(.*?):(0|1|2)\}/e','xget_index_link_prev("$1",$2,$prev_no_linktext,$prev_max_char_count,$prev_max_char_affix,$prev_prefix_no_link,$prev_sufix_no_link);',$content["all"]);
 
 
 
 
}  // END if {XBROWSE:
 
?>