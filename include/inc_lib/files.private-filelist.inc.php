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


// List available files
$file_sql = "SELECT * FROM ".DB_PREPEND."phpwcms_file WHERE f_pid=0 ";
if(empty($_SESSION["wcs_user_admin"])) {
	$file_sql .= "AND f_uid=".$_SESSION["wcs_user_id"].' ';
}
$file_sql .= "AND f_kid=1 AND f_trash=0 ORDER BY f_sort, f_name";

if($file_result = mysqli_query($db, $file_sql) or die ("error while listing files")) {
	$file_durchlauf = 0;
	$zieldatei = "phpwcms.php?do=files&amp;f=0";
	while($file_row = mysqli_fetch_array($file_result)) {
		$filename = html($file_row["f_name"]);

		$file_row['edit'] = '<a href="'.$zieldatei.'&amp;editfile='.$file_row["f_id"].'" title="'.$BL['be_fprivfunc_editfile'].": ".$filename.'">';

		if(!$file_durchlauf) {
//			echo "<tr><td colspan=\"2\">\n";
			echo "<ul class=\"dados-sumario\"><li>\n";
			echo "<div class=\"barra\"></div><h3>Arquivos na pasta raiz</h3>\n";
        		echo "<div class=\"lista-arquivos-pasta-raiz\"><div class=\"grid-4\">";
		} else {
			echo "\n";
		}

		echo "<article><div class=\"bloco-centro-imagem\">";




		if($_SESSION["wcs_user_thumb"]) {

			// now try to get existing thumbnails or if not exists
			// build new based on default thumbnail listing sizes

			// build thumbnail image name
			$thumb_image = get_cached_image(array(
				"target_ext"	=>	$file_row["f_ext"],
				"image_name"	=>	$file_row["f_hash"] . '.' . $file_row["f_ext"],
				"thumb_name"	=>	md5($file_row["f_hash"].$phpwcms["img_list_width"].$phpwcms["img_list_height"].$phpwcms["sharpen_level"].$phpwcms['colorspace'])
        	));

			if($thumb_image != false) {

				echo $file_row['edit'];
				echo '<figure><img src="'.PHPWCMS_IMAGES . $thumb_image[0] .'" border="0" '.$thumb_image[3].'></figure></a>'."\n";

			}

		}
		$file_durchlauf++;

                	echo "<span class=\"nome-arquivo\">";

                echo "<img src=\"img/icons/small_".extimg($file_row["f_ext"])."\" border=\"0\" ";
		echo 'onmouseover="Tip(\'ID: '.$file_row["f_id"].'&lt;br&gt;Sort: '.$file_row["f_sort"];
		echo '&lt;br&gt;Name: '.html($file_row["f_name"]);
		if($file_row["f_copyright"]) {
			echo '&lt;br&gt;&copy;: '.html($file_row["f_copyright"]);
		}
		echo '\');" onmouseout="UnTip()" alt=""';
		echo " />\n";
                echo $file_row['edit'] . $filename."</a>\n";

		echo "</span>";

                echo "<div class=\"controle-botoes-imagem\">";

                echo "<a class=\"botoes\" href=\"include/inc_act/act_download.php?dl=".$file_row["f_id"].
			 "\" target=\"_blank\" title=\"".$BL['be_fprivfunc_dlfile'].": ".$filename."\">".
			 "<i class=\"fas fa-file-download\"></i> Baixar</a>";
		//Button zum Erzeugen eines Neuen Unterverzeichnisses
		if($cutID == $file_row["f_id"]) {
			echo "<a class=\"botoes bt-off\"><i class=\"fas fa-cut\"></i></a>";
		} else {
			echo "<a class=\"botoes bt-cortar\" href=\"".$zieldatei."&cut=".$file_row["f_id"]."\" title=\"".$BL['be_fprivfunc_cutfile'].": ".$filename."\">";
			echo "<i class=\"fas fa-cut\"></i></a>";
		}

                echo "<a class=\"botoes bt-delete\" href=\"include/inc_act/act_file.php?trash=".$file_row["f_id"].'%7C'."1".
	 		 "\" title=\"".$BL['be_fprivfunc_movetrash'].": ".$filename."\" onclick=\"return confirm('".$BL['be_fprivfunc_jsmovetrash1'].
			 "\\n[".$filename."]  \\n".$BL['be_fprivfunc_jsmovetrash2']."');\">".
			 "<i class=\"far fa-trash-alt\"></i></a>";

                echo "</div></div>";

                	echo "</article>";

	}
	if($file_durchlauf) { //Abschluss der Filelisten-Tabelle
		echo "</div></div>";
		echo "</li></ul>";
	}
} //Ende Liste Dateien
?>