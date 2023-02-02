<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/

// Main Backend Nav Definition

$wcsnav = array();

$pag = $_GET['do'];
$mod = $_GET['module'];

switch ($pag){
case 'articles': $check1 = ' class="ativo"'; break;
case 'files': $check2 = ' class="ativo"'; break;
case 'modules': if($mod == 'dados_empresa'){$check7 = ' class="ativo"';} else {$check3 = ' class="ativo"';} break;
case 'messages': $check4 = ' class="ativo"'; break;
case 'profile': $check5 = ' class="ativo"'; break;
case 'admin': $check6 = ' class="ativo"'; break; 
}

$wcsnav["articles"]		= '<a href="phpwcms.php?do=articles"'.$check1.'>'.$BL['be_nav_articles'].'</a>';
$wcsnav["dados"]		= '<a href="phpwcms.php?do=modules&module=dados_empresa"'.$check7.'>'.$BL['be_nav_dados'].'</a>';
$wcsnav["files"]		= '<a href="phpwcms.php?do=files"'.$check2.'>'.$BL['be_nav_files'].'</a>';
if($phpwcms['Modo'] == 1){
$wcsnav["modules"]		= '<a href="phpwcms.php?do=modules"'.$check3.'>'.$BL['be_nav_modules'].'</a>';
$wcsnav["messages"]		= '<a href="phpwcms.php?do=messages&amp;p=4"'.$check4.'>'.$BL['be_nav_messages'].'</a>';
} else {
	if($phpwcms['Modulos'] == 1){
		$wcsnav["modules"]		= '<a href="phpwcms.php?do=modules"'.$check3.'>'.$BL['be_nav_modules'].'</a>';
	} else {
		$wcsnav["modules"]		= '';
	}
	if($phpwcms['ListaEmails'] == 1){
		$wcsnav["messages"]		= '<a href="phpwcms.php?do=messages&amp;p=4"'.$check4.'>'.$BL['be_nav_messages'].'</a>';
	} else {
		$wcsnav["messages"]		= '';
	}
}

if(!empty($phpwcms['enable_chat'])) {
	$wcsnav["chat"]			= '<a href="phpwcms.php?do=chat">'.$BL['be_nav_chat'].'</a>';
}

if($phpwcms['Modo'] == 1){
$wcsnav["profile"]		= '<a href="phpwcms.php?do=profile"'.$check5.'>'.$BL['be_nav_profile'].'</a>';
} else {
$wcsnav["profile"]		= '';
}

if($phpwcms['Modo'] == 1){
$wcsnav["admin"]		= '<a href="phpwcms.php?do=admin&amp;p=6"'.$check6.'>'.$BL['be_nav_admin'].'</a>';
} else {
	if($phpwcms['Admin'] == 1){
		$wcsnav["admin"]		= '<a href="phpwcms.php?do=admin&amp;p=6"'.$check6.'>'.$BL['be_nav_admin'].'</a>';
	} else {
		$wcsnav["admin"]		= '';
	}
}
$wcsnav["navspace1"]	= '';

?>