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


$startup_default = read_textfile(PHPWCMS_TEMPLATE."inc_default/startup.php"); //reads the css template
$startup_default = ($startup_default) ? html($startup_default) : "";
		
?><form action="include/inc_act/act_startuptext.php" method="post" name="startup" target="_self"><table width="<?php echo $phpwcms['LarguraInterna']; ?>" border="0" cellpadding="0" cellspacing="0" summary="">
	
	<tr>
	  <td colspan="2" class="title"><?php echo $BL['be_admin_startup_title'] ?></td>
	</tr>
	<tr>
		<td width="35"><img src="img/leer.gif" alt="" width="35" height="4"></td>
		<td width="503"><img src="img/leer.gif" alt="" width="1" height="1"></td>
	</tr>
	<tr><td colspan="2"><img src="img/lines/l538_70.gif" alt="" width="<?php echo $phpwcms['LarguraInterna']; ?>" height="1"></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10"></td></tr>
	<tr><td colspan="2" class="chatlist"><?php echo $BL['be_admin_startup_text'] ?>:&nbsp;</td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="2"></td></tr>
	<tr>
		<td colspan="2"><textarea name="startup_default" cols="35" rows="25" wrap="OFF" class="msgtext" id="startup_default" style="width:735px"><?php echo $startup_default; ?></textarea></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15"></td></tr>
	<tr>
		<td>&nbsp;</td>
		<td><input name="Submit" type="submit" class="button10" value="<?php echo $BL['be_admin_startup_button'] ?>"></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15"></td></tr>
	
</table></form>
