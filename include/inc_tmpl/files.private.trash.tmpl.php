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


//Feststellen, ob ?berhaupt Dateien/Ordner im Papierkorb des Users vorhanden sind
$sql = "SELECT COUNT(f_id) FROM ".DB_PREPEND."phpwcms_file WHERE f_uid=".$_SESSION["wcs_user_id"]." AND f_trash=1 LIMIT 1;";
if($result = mysql_query($sql, $db) or die ("error while counting user files")) {
	if($row = mysql_fetch_row($result)) $count_user_files = $row[0];
	mysql_free_result($result);
}
//Wenn ?berhaupt Papierkorb-Dateien f?r User vorhanden, dann Listing
if(isset($count_user_files) && $count_user_files) {
	//Beginn Tabelle f?r Dateilisting
	echo "<table width=\"".$phpwcms['LarguraInterna2']."\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr><td colspan=\"2\"><img src=\"img/leer.gif\" width=\"1\" height=\"1\"></td></tr>\n";
	include_once (PHPWCMS_ROOT."/include/inc_lib/files.private-delfilelist.inc.php");
	echo "</table>\n";
	?>

	<div class="barra"></div>
        
        <p>
            <i class="far fa-trash-alt"></i>
            <?php
		
		echo "<a href=\"include/inc_act/act_file.php?trash=0|9".
	 		 "\" title=\"".$BL['be_ftrash_delall']."\" onclick=\"return confirm('". str_replace("\n", "\\n", $BL['be_ftrash_delall'])."');\">".
			 $BL['be_ftrash_delallfiles']."</a>";
			 
		?>
        </p>


<?php
	
	//Ende Tabelle
} else { //Wenn keinerlei Datensatz innerhalb Files durchlaufen wurde, dann
	echo "<p>".$BL['be_ftrash_nofiles']."</p>";
//	echo "<img src=\"img/leer.gif\" width=\"1\" height=\"6\"><br />".$BL['be_ftrash_nofiles']."&nbsp;&nbsp;";
//	echo "[<a href=\"phpwcms.php?do=files&f=0\">".$BL['be_ftrash_show']."</a>]";
//	echo "<br /><img src=\"img/leer.gif\" width=\"1\" height=\"6\">";
}
?>