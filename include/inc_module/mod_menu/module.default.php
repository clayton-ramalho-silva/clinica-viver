<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2012, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/

// register module name
//DO NOT USE SPECIAL CHARS HERE, NO WHITE SPACES, USE LOWER CASE!!!
$_module_name                   = 'menu';

// module type - defines where used
// 0 = BE and FE, 1 = BE only, 2 = FE only
$_module_type                   = 1;

// Set if it should be listed as content part
// has content part: true or false
$_module_contentpart   	= true;

$_module_fe_render		= true;
$_module_fe_init		= false;
$_module_fe_search		= true;

?>