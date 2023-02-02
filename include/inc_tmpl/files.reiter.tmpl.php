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



// Files-Navigation
		
//$no_durchlauf = 0; //Definieren der Durchlauf-Variable
$files_folder = (isset($_GET["f"])) ? intval($_GET["f"]) : 0; //Ermitteln, welcher Unterreiter angezeigt wird

//Wenn Cut/Paste für Seite Aktiv, dann
$add_paste_icon = '<a class="botoes"href="phpwcms.php?do=files&f=0&mkdir=0" title="'.$BL['be_ftab_createnew'].
				  '"><i class="fas fa-folder-plus"></i> Criar Nova Pasta</a>';
if(isset($_GET["cut"])) { 
	$cutID = intval($_GET["cut"]);
	$add_paste_icon = '<a class="botoes bt-colar" href="include/inc_act/act_file.php?paste='.$cutID.'|0" title="'.$BL['be_ftab_paste'].
					  '"><i class="fas fa-level-down-alt"></i> Colar aqui</a>';
} else { $cutID=0; }

$change_thumbnail_icon = '<a href="include/inc_act/act_file.php?thumbnail=';
if($_SESSION["wcs_user_thumb"]) {
	$change_thumbnail_icon .= '0" title="'.$BL['be_ftab_disablethumb'].'">';
	$change_thumbnail_icon .= '<img src="img/button/thumbnail_13x13_0.gif" border="0" width=""></a>';
} else {
	$change_thumbnail_icon .= '1" title="'.$BL['be_ftab_enablethumb'].'">';
	$change_thumbnail_icon .= '<img src="img/button/thumbnail_13x13_1.gif" border="0"></a>';
}
		
?>
<h1 class="title"><?php echo $BL['be_ftab_title'] ?></h1>

<div class="paginas-centro-arquivos">
    <span>    
        <a class="link-carregar-arquivos button10" href="phpwcms.php?do=files&p=8">Carregar Vários Arquivos</a>
        
        <a class="button10" href="phpwcms.php?do=files&amp;f=0"><?php echo $BL['be_ftab_private'] ?></a>
       
        <a class="button10" href="phpwcms.php?do=files&p=4">Editar Arquivos</a>

        <a class="link-lixeira-arquivos button10" href="phpwcms.php?do=files&amp;f=2"><?php echo $BL['be_ftab_trash'] ?></a>
    </span> 
    
    <div class="controle-botoes-imagem">
        <a class="botoes bt-off">Pasta Raiz</a>
        <a class="botoes bt-imagem" href="phpwcms.php?do=files&amp;f=0&amp;upload=0" title="<?php echo $BL['be_ftab_upload'] ?>"><i class="fas fa-upload"></i> Subir Arquivo</a>
        <?php echo $add_paste_icon ?>
        
        <a class="botoes" href="phpwcms.php?do=files&amp;f=0&amp;all=open" title="<?php echo $BL['be_ftab_open'] ?>"><i class="far fa-folder-open"></i></a>
        <a class="botoes" href="phpwcms.php?do=files&amp;f=0&amp;all=close" title="<?php echo $BL['be_ftab_close'] ?>"><i class="fas fa-folder"></i></a>
            
    </div>
    		<?php if($files_folder == 0) { ?>
    		<?php } else { echo ''."\n"; } ?>


</div>

<div class="barra"></div>

<!--<table width="<?php echo $phpwcms['LarguraInterna'] ?>" border="0" cellpadding="0" cellspacing="0" summary="">


<tr><td>-->
        <!--<table width="<?php echo $phpwcms['LarguraInterna'] ?>" border="0" cellpadding="0" cellspacing="0" summary="">-->
	<!--<tr>-->
<!--		<td align="center" <?php which_folder_active($files_folder, 0) ?>>
                    <a href="phpwcms.php?do=files&amp;f=0" class="link-aba-arquivos"><?php echo $BL['be_ftab_private'] ?></a>
                </td>-->
        
<!--	<td align="center"  <?php which_folder_active($files_folder, 1) ?>>
            <a href="phpwcms.php?do=files&p=8" class="link-aba-arquivos">Carregar Arquivos</a>
        </td>-->
    
    <!-- Alteração-->
			<!-- <td width="90" align="center" background="img/background/bg_eckeli.gif" <?php which_folder_active($files_folder, 3) ?>><a href="phpwcms.php?do=files&amp;f=3"><?php echo $BL['be_ftab_search'] ?></a></td>-->
<!--		<td align="center" <?php which_folder_active($files_folder, 2) ?>>
                    <a href="phpwcms.php?do=files&amp;f=2" class="link-aba-arquivos"><?php echo $BL['be_ftab_trash'] ?></a>
                </td>-->
		<?php if($files_folder == 0) { ?>
                <!--<td align="right" bgcolor="#EBF2F4" class="chatlist">-->
                    <!--<a class="botoes bt-off">Pasta Raiz</a>-->
                    <!--<a class="botoes bt-imagem" href="phpwcms.php?do=files&amp;f=0&amp;upload=0" title="<?php echo $BL['be_ftab_upload'] ?>"><i class="fas fa-upload"></i> Subir Arquivo</a>-->
                        <!-- <?php echo $add_paste_icon ?> -->
                    <!--<a href="include/inc_help/filehelp.htm" target="_blank" onclick="flevPopupLink(this.href,'filehelp','scrollbars=yes,resizable=yes,width=320,height=300',0);return document.MM_returnValue" style="cursor: help;"><img src="img/button/help_22x13.gif" alt="open file help" width="22" height="13" border="0" /></a>-->
                    <!--<a href="phpwcms.php?do=files&amp;f=0&amp;all=open" title="<?php echo $BL['be_ftab_open'] ?>"><img src="img/button/alle_auf.gif" alt="" width="12" height="13" border="0" /></a>-->
                    <!--<a href="phpwcms.php?do=files&amp;f=0&amp;all=close" title="<?php echo $BL['be_ftab_close'] ?>"><img src="img/button/alle_zu.gif" alt="" width="12" height="13" border="0" /></a>-->
                    <!--<img src="img/leer.gif" alt="" width="5" height="1" />-->
                        <!-- <?php echo $change_thumbnail_icon ?> -->
                <!--</td>-->
		<?php } elseif($files_folder == 1) { ?>
		<!--<td width="162" align="right" bgcolor="#EBF2F4" class="chatlist"> <a href="include/inc_help/filehelp.htm" target="_blank" onclick="flevPopupLink(this.href,'filehelp','scrollbars=yes,resizable=yes,width=320,height=300',0);return document.MM_returnValue" style="cursor: help;"><img src="img/button/help_22x13.gif" alt="<?php echo $BL['be_ftab_filehelp'] ?>" width="22" height="13" border="0" /></a><a href="phpwcms.php?do=files&amp;f=1&amp;all=close" title="<?php echo $BL['be_ftab_close'] ?>"><img src="img/button/alle_zu.gif" alt="" width="12" height="13" border="0" /></a><img src="img/leer.gif" alt="" width="5" height="1" /><?php echo $change_thumbnail_icon ?></td>-->
		<?php } elseif($files_folder == 3) { ?>
		<!--<td width="162" align="right" background="img/background/bg_ecke_lang.gif" bgcolor="#EBF2F4" class="chatlist"> <a href="include/inc_help/filehelp.htm" target="_blank" onclick="flevPopupLink(this.href,'filehelp','scrollbars=yes,resizable=yes,width=320,height=300',0);return document.MM_returnValue" style="cursor: help;"><img src="img/button/help_22x13.gif" alt="<?php echo $BL['be_ftab_filehelp'] ?>" width="22" height="13" border="0" /></a><img src="img/leer.gif" alt="" width="5" height="1" /><?php echo $change_thumbnail_icon ?></td>-->
		<?php // } else { echo '<td width="162" class="chatlist">&nbsp;</td>'."\n"; } ?>
		<?php } else { echo ''."\n"; } ?>
	<!--</tr></table>-->
<!--    </td></tr>

</tr></table>-->
