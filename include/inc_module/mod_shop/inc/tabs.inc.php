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

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

$_entry['query']			= '';

$tabs = array(
	'orders'		=>	$BLM['tab_orders'],
	'products'		=>	$BLM['tab_products'],
	'categories'	=>	$BLM['tab_categories'],
	'fretes'		=>	$BLM['tab_fretes'],
	'users'			=>	$BLM['tab_users'],
	'preferences'	=>	$BLM['tab_preferences'],
);

if($user['admin_config_frete'] === 0){
	unset($tabs['fretes']);
}

$widthTabs = 100 / count($tabs);

?>
<h1 class="title" style="margin-bottom:10px"><?php echo $BLM['listing_title'] ?></h1>

<div class="tabs-shop">

	<ul>
    	<?php
		foreach($tabs as $key => $value){
		?>
			
           	<li<?php echo ($controller == $key) ? ' class="activeTab"' : ''; ?> style="width:<?php echo $widthTabs.'%'; ?>">
                <a href="<?php echo shop_url('controller='.$key) ?>">
                    <strong><?php echo $BLM['tab_'.$key] ?></strong>
                </a>
            </li>
            
        <?php
		}
		?>
		
	</ul>
    
	<br class="clear" />
    
</div>
