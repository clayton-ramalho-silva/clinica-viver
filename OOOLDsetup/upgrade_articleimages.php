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

//used to convert old style file uploads

$phpwcms = array();

require_once ('../config/phpwcms/conf.inc.php');
require_once ('../include/inc_lib/default.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_lib/dbcon.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_lib/general.inc.php');
require_once (PHPWCMS_ROOT.'/include/inc_lib/backend.functions.inc.php');

echo '<html><body><pre>';


$sql = "SELECT * FROM ".DB_PREPEND."phpwcms_articlecontent WHERE acontent_type=1 and acontent_image != ''";
$result = mysqli_query($db, $sql);
$total = mysqli_num_rows($result);

echo 'TOTAL: '.$total." ENTRIES\n";
echo '================================================================='."\n\n";

$linenumber = 1;

while($row = mysqli_fetch_assoc($result)) {

	$error = false;
	$image = explode(':', $row['acontent_image']);

	$fsql = "SELECT * FROM ".DB_PREPEND."phpwcms_file WHERE f_id='".intval($image[0])."' LIMIT 1";
	if($fresult = mysqli_query($db, $fsql)) {

		if($frow = mysqli_fetch_assoc($fresult)) {

			// dbid:filename:hash:extension:width:height:caption:position:zoom
			$newimage  = $frow['f_id'];
			$newimage .= ':';
			$newimage .= $frow['f_name'];
			$newimage .= ':';
			$newimage .= $frow['f_hash'];
			$newimage .= ':';
			$newimage .= $frow['f_ext'];
			$newimage .= ':';
			$newimage .= $image[3];
			$newimage .= ':';
			$newimage .= $image[4];
			$newimage .= ':';
			$newimage .= $image[7];
			$newimage .= ':';
			$newimage .= $image[5];
			$newimage .= ':';
			$newimage .= (isset($image[8]) && intval($image[8])) ? 1 : 0;

			// check if this is an updated content part
			if($image[2] != $frow['f_hash'] && $image[3] != $frow['f_ext']) {
				$usql  = "UPDATE ".DB_PREPEND."phpwcms_articlecontent SET ";
				$usql .= "acontent_image='".aporeplace($newimage)."' ";
				$usql .= "WHERE acontent_id=".$row['acontent_id']." LIMIT 1";
				mysqli_query($db, $usql);
				echo 'Image '. sprintf('%05d: ', $linenumber) . html_specialchars($frow['f_name']) ."\n";
			}

		}
		mysqli_free_result($fresult);

	}

	flush();
	$linenumber++;

}

if(empty($usql)) {
	echo 'None of the content parts &quot;image with text&quot; needs to be upgraded.';
}

echo '</pre></body></html>';

?>