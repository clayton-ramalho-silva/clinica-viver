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

require_once(PHPWCMS_ROOT.'/include/inc_front/lib/js.mootools-1.4.default.php');

define('PHPWCMS_JSLIB', 'mootools-1.4');

/**
 * Init Mootools 1.4.x Library without compatibility
 */
function initJSLib() {
	if(empty($GLOBALS['block']['custom_htmlhead']['mootools.js'])) {
		if(PHPWCMS_USE_CDN) {
			$GLOBALS['block']['custom_htmlhead']['mootools.js'] = getJavaScriptSourceLink(PHPWCMS_HTTP_SCHEMA . '://ajax.googleapis.com/ajax/libs/mootools/1.4/mootools-yui-compressed.js');
		} else {
			$GLOBALS['block']['custom_htmlhead']['mootools.js'] = getJavaScriptSourceLink(TEMPLATE_PATH.'lib/mootools/mootools-core-1.4.x-full-nocompat.js');
		}
	}
	return TRUE;
}

?>