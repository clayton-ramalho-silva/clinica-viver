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

//Funktionen zum Listen der privaten Dateien

function list_private($pid, $dbcon, $vor, $zieldatei, $userID, $cutID=0, $show_thumb=1, $phpwcms) {
	$cutID = intval($cutID);
	$pid = intval($pid);
	$sql  = "SELECT * FROM ".DB_PREPEND."phpwcms_file f ";
	$sql .= "LEFT JOIN ".DB_PREPEND."phpwcms_user u ON u.usr_id=f.f_uid ";
	$sql .= "WHERE ";
	$sql .= "f.f_pid=".intval($pid)." AND ";
	if(empty($_SESSION["wcs_user_admin"])) {
		$sql .= "f.f_uid=".intval($userID)." AND ";
	}
	$sql .= "f.f_kid=0 AND f.f_trash=0 ORDER BY f_sort, f_name";
	$result = mysqli_query($dbcon, $sql);
	while($row = mysqli_fetch_array($result)) {

		$dirname = html($row["f_name"]);

		if($_SESSION["wcs_user_id"] != $row["f_uid"]) {
			$dirname .= ' (' . html($row["usr_login"]) . ')';
		}

		//Ermitteln des Aufklappwertes
		$klapp_status = empty($_SESSION["klapp"][$row["f_id"]]) ? 1 : 0;

		//Ermitteln, ob überhaupt abhängige Dateien/Ordner existieren
		$count_sql  = "SELECT COUNT(f_id) FROM ".DB_PREPEND."phpwcms_file WHERE ";
		$count_sql .= "f_pid=".$row["f_id"]." AND ";
		if(empty($_SESSION["wcs_user_admin"])) {
			$count_sql .= "f_uid=".intval($userID)." AND ";
		}
		$count_sql .= "f_trash=0 LIMIT 1";
		if($count_result = mysqli_query($dbcon, $count_sql)) {
			if($count_row = mysqli_fetch_row($count_result)) {
				$count = ''.
						 '<a href="'.$zieldatei."&amp;klapp=".$row["f_id"].
						 '%7C'.$klapp_status.'">'.on_off($klapp_status, $dirname, 0)."</a>"; // | = %7C
				$count_wert = $count_row[0];
			}
			mysqli_free_result($count_result);
		}

		//Aufbau der Zeile
//		echo '<tr bgcolor="#EEEEEE"><td colspan="2"><img src="img/leer.gif" height="1" width="1" alt="" /></td></tr>'."\n"; //Abstand vor
//		echo "<tr>\n"; //Einleitung Tabellenzeile
		echo "<div class=\"pasta-arquivos\"><span class=\"nome-pasta\"> "; //Einleiten der Tabellenzelle
		echo $count."";

		// Gallery status
		switch($row["f_gallerystatus"]) {

			case 2:		// gallery root dir
						echo '<a  href="'.$zieldatei."&amp;klapp=".$row["f_id"].
						 '%7C'.$klapp_status.'"><img src="img/icons/folder_galleryroot.gif" border="0" alt="'.$GLOBALS['BL']['be_gallery_root'].'" title="'.$GLOBALS['BL']['be_gallery_root'].'" />';
						break;

			case 3:		// gallery subdir
						echo '<a href="'.$zieldatei."&amp;klapp=".$row["f_id"].
						 '%7C'.$klapp_status.'" ><img src="img/icons/folder_gallerysub.gif" border="0" alt="'.$GLOBALS['BL']['be_gallery_directory'].'" title="'.$GLOBALS['BL']['be_gallery_directory'].'" />';
						break;

			default:	echo "<a href=\"".$zieldatei."&amp;klapp=".$row["f_id"].
						 '%7C'.$klapp_status."\" >";
		}

		echo "<a href=\"".$zieldatei."&amp;klapp=".$row["f_id"].
						 '%7C'.$klapp_status."\"><strong>".$dirname; //Zellinhalt 1. Spalte Fortsetzung
		echo "</strong></a></span>\n"; //Schließen Zelle 1. Spalte
		echo "<div class=\"controle-botoes-imagem\">\n"; //Schließen Zelle 1. Spalte
		//Zelle 2. Spalte - vorgesehen für Buttons/Tasten Edit etc.
//		echo "<td align=\"right\" class=\"msglist\" style=\"padding:3px 8px 3px 0\">";
		//Button zum Uploaden einer Datei in dieses Verzeichnisses
		echo "<a class=\"botoes bt-imagem\" href=\"".$zieldatei."&amp;upload=".$row["f_id"]."\" title=\"".$GLOBALS['BL']['be_fprivfunc_upload'].": ".$dirname."\">";
		echo "<i class=\"fas fa-upload\"></i> Subir Arquivo</a>";
		if(!$cutID) { //Button zum Erzeugen eines Neuen Unterverzeichnisses
			echo "<a class=\"botoes bt-criar-pasta\" href=\"".$zieldatei."&amp;mkdir=".$row["f_id"]."\" title=\"".$GLOBALS['BL']['be_fprivfunc_makenew'].": ".$dirname."\">";
			echo "<i class=\"fas fa-folder-plus\"></i> Criar Nova Pasta</a>";
		} else {  //Button zum Einfügen der Clipboard-Datei in das Verzeichnis
			echo "<a class=\"botoes bt-colar\" href=\"include/inc_act/act_file.php?paste=".$cutID.'%7C'.$row["f_id"].
				 "\" title=\"".$GLOBALS['BL']['be_fprivfunc_paste'].": ".$dirname."\">";
			echo "<i class=\"fas fa-level-down-alt\"></i> Colar Aqui</a>";
		}
		//Button zum Bearbeiten des Verzeichnisses
		echo "<a class=\"botoes bt-editar\" href=\"".$zieldatei."&amp;editdir=".$row["f_id"]."\" title=\"".$GLOBALS['BL']['be_fprivfunc_edit'].": ".$dirname."\">";
		echo "<i class=\"fas fa-edit\"></i> Editar</a>";
		//Button zum Umschalten zwischen Aktiv/Inaktiv
		/*echo "<a href=\"include/inc_act/act_file.php?aktiv=".$row["f_id"].'%7C'.true_false($row["f_aktiv"]).
			 "\" title=\"".$GLOBALS['BL']['be_fprivfunc_cactive'].": ".$dirname."\">";
		echo "<img src=\"img/button/aktiv_12x13_".$row["f_aktiv"].".gif\" border=\"0\" alt=\"\" /></a>";*/

		//Button zum Umschalten zwischen Public/Non-Public
	/*	echo "<a href=\"include/inc_act/act_file.php?public=".$row["f_id"].'%7C'.true_false($row["f_public"]).
			 "\" title=\"".$GLOBALS['BL']['be_fprivfunc_cpublic'].": ".$dirname."\">";
		echo "<img src=\"img/button/public_12x13_".$row["f_public"].".gif\" border=\"0\" alt=\"\" /></a>";
		echo "<img src=\"img/leer.gif\" width=\"5\" height=\"1\">"; */ //Spacer

		//Button zum Löschen des Verzeichnisses, wenn leer
		if(!$count_wert) {
			echo "<a class=\"botoes bt-delete\" href=\"include/inc_act/act_file.php?delete=".$row["f_id"].'%7C'."9".
				 "\" title=\"".$GLOBALS['BL']['be_fprivfunc_deldir'].": ".$dirname."\" onclick=\"return confirm('".
				 $GLOBALS['BL']['be_fprivfunc_jsdeldir'] ." \\n[".$dirname."]? ');\">";
			echo "<i class=\"far fa-trash-alt\"></i></a>";
		} else {
			echo "<a class=\"botoes bt-off\"><i class=\"far fa-trash-alt\"></i></a>";
//			echo "<img src=\"img/button/trash_13x13_0.gif\" title=\"";
//			echo str_replace('{VAL}', $dirname, $GLOBALS['BL']['be_fprivfunc_notempty']).'" border="0" alt="" />';
		}
//		echo "<img src=\"img/leer.gif\" width=\"2\" height=\"1\" border=\"0\" alt=\"\" />"; //Spacer
		echo "</div></div>\n";
//		echo "</tr>\n"; //Abschluss Tabellenzeile

		//Aufbau trennende Tabellen-Zeile
//		echo "<tr bgcolor=\"#ccc\"><td colspan=\"2\"><img src=\"img/leer.gif\" border=\"0\" alt=\"\" /></td></tr>\n"; //Abstand nach
//		echo "<tr><td colspan=\"2\"><img src=\"img/leer.gif\" border=\"0\" alt=\"\" /></td></tr>\n"; //Trennlinie<img src='img/lines/line-lightgrey-dotted-538.gif'>

		//Weiter, wenn Unterstruktur
		if(!$klapp_status && $count_wert) { //$vor."<img src='img/leer.gif' height=1 width=18 border=0>"
			list_private($row["f_id"], $dbcon, $vor+18, $zieldatei, $userID, $cutID, $show_thumb, $phpwcms);

			//Listing eventuell im Verzeichnis enthaltener Dateien
			$file_sql = "SELECT * FROM ".DB_PREPEND."phpwcms_file WHERE f_pid=".$row["f_id"];
			if(empty($_SESSION["wcs_user_admin"])) {
				$file_sql .= " AND f_uid=".$userID;
			}
			$file_sql .= " AND f_kid=1 AND f_trash=0 ORDER BY f_sort, f_name";

			if($file_result = mysqli_query($dbcon, $file_sql) or die ("error while listing files")) {
				$file_durchlauf = 0;
				while($file_row = mysqli_fetch_array($file_result)) {
					$filename = html($file_row["f_name"]);

					$file_row["edit"] = '<a href="'.$zieldatei."&amp;editfile=".$file_row["f_id"].'" title="'.$GLOBALS['BL']['be_fprivfunc_editfile'].": ".$filename.'">';

					if(!$file_durchlauf) { //Aufbau der Zeile zum Einfließen der Filelisten-Tavbelle
						echo "<div class=\"lista-arquivos\"><div class=\"grid-4\">\n";
						echo "<!-- start file list: private-functions //-->\n";
					} else {
//						echo "<tr bgcolor=\"#CCCCCC\"><td colspan=\"5\"><img src=\"img/leer.gif\" border=\"0\" alt=\"\" /></td></tr>\n";
					}

//					echo "<tr>\n";
//					echo "<td width=\"".($vor+37)."\" class=\"msglist\"><img src=\"img/leer.gif\" height=\"1\" width=\"".($vor+37)."\" border=\"0\" alt=\"\" /></td>\n";
//					echo "<td width=\"13\" class=\"msglist\">";
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


//							echo "<tr>\n";
//							echo "<td width=\"".($vor+37)."\"><img src=\"img/leer.gif\" height=\"1\" width=\"".($vor+37)."\" border=\"0\" alt=\"\" /></td>\n";
//							echo "<td width=\"13\"><img src=\"img/leer.gif\" height=\"1\" width=\"1\" border=\"0\" alt=\"\" /></td>\n<td width=\"";
//							echo (388-$vor)."\"><img src=\"img/leer.gif\" height=\"1\" width=\"6\" border=\"0\" alt=\"\" />"; //<a href=\"fileinfo.php?fid=";
							//echo $file_row["f_id"]."\" target=\"_blank\" onclick=\"flevPopupLink(this.href,'filedetail','scrollbars=";
							//echo "yes,resizable=yes,width=500,height=400',1); return document.MM_returnValue;\">";
							echo $file_row["edit"];
							echo '<figure><img src="'.PHPWCMS_IMAGES . $thumb_image[0] .'" border="0" '.$thumb_image[3].' ';
							echo 'onmouseover="Tip(\'ID: '.$file_row["f_id"].'&lt;br&gt;Sort: '.$file_row["f_sort"];
							echo '&lt;br&gt;Name: '.html($file_row["f_name"]);
							if($file_row["f_copyright"]) {
								echo '&lt;br&gt;&copy;: '.html($file_row["f_copyright"]);
							}
							echo '\');" onmouseout="UnTip()" alt=""';
							echo " /></figure></a>\n";
//							echo "<td width=\"100\"><img src=\"img/leer.gif\" border=\"0\" alt=\"\" /></td>\n</tr>\n";
//							echo "<tr><td colspan=\"4\"><img src=\"img/leer.gif\" height=\"2\" width=\"1\" border=\"0\" alt=\"\" /></td>\n</tr>\n";;;;;;;

						}

					}


					$file_durchlauf++;



                                        echo "<span class=\"nome-arquivo\"><img src=\"img/icons/small_".extimg($file_row["f_ext"])."\" border=\"0\" ";
					echo 'onmouseover="Tip(\'ID: '.$file_row["f_id"].'&lt;br&gt;Sort: '.$file_row["f_sort"];
					echo '&lt;br&gt;Name: '.html($file_row["f_name"]);
					if($file_row["f_copyright"]) {
						echo '&lt;br&gt;&copy;: '.html($file_row["f_copyright"]);
					}
					echo '\');" onmouseout="UnTip()" alt=""';
					echo " />\n";

                                        echo $file_row["edit"] . $filename . "</a></span>\n";

                                        echo "<div class=\"controle-botoes-imagem\">";

//					echo "<td width=\"".(388-$vor)."\" class=\"msglist\">";
					//echo "<a href=\"fileinfo.php?fid=".$file_row["f_id"];
					//echo "\" target=\"_blank\" onclick=\"flevPopupLink(this.href,'filedetail','scrollbars=yes,resizable=yes,width=500,height=400',1);return document.MM_returnValue;\">";
//					echo $file_row["edit"] . $filename . "</a>\n";
					//Aufbauen Buttonleiste für jeweilige Datei
//					echo "<td width=\"100\" align=\"right\" class=\"msglist\" style=\" padding:4px;\">";
					//Button zum Downloaden der Datei
					echo "<a class=\"botoes\" href=\"include/inc_act/act_download.php?dl=".$file_row["f_id"].
						 "\"  target=\"_blank\" title=\"".$GLOBALS['BL']['be_fprivfunc_dlfile'].": ".$filename."\">".
						 "<i class=\"fas fa-file-download\"></i> Baixar</a>"; //target='_blank'
					//Button zum Erzeugen eines Neuen Unterverzeichnisses
					if($cutID == $file_row["f_id"]) {
						echo "<a class=\"botoes bt-off\"><i class=\"fas fa-cut\"></i></a>";
					} else {
						echo "<a class=\"botoes bt-cortar\" href=\"".$zieldatei."&amp;cut=".$file_row["f_id"]."\" title=\"".$GLOBALS['BL']['be_fprivfunc_cutfile'].": ".$filename."\">";
						echo "<i class=\"fas fa-cut\"></i></a>";
					}
					//Button zum Bearbeiten der Dateiinformationn
//					echo $file_row["edit"];
//					echo "<img src=\"img/button/edit_22x13.gif\" border=\"0\" alt=\"\" /></a>";

					//Button zum Löschen der Datei
					echo "<a class=\"botoes bt-delete\" href=\"include/inc_act/act_file.php?trash=".$file_row["f_id"].'%7C'."1".
				 		 "\" title=\"".$GLOBALS['BL']['be_fprivfunc_movetrash'].": ".$filename."\" onclick=\"return confirm('".
						 $GLOBALS['BL']['be_fprivfunc_jsmovetrash1']."\\n[".$filename."]\\n".$GLOBALS['BL']['be_fprivfunc_jsmovetrash2'].
						 "');\">".
						 "<i class=\"far fa-trash-alt\"></i></a>";
//					echo "<img src=\"img/leer.gif\" width=\"2\" height=\"1\" border=\"0\" alt=\"\" />"; //Spacer
//					echo "</td>\n";
					//Ende Aufbau
//					echo "</tr>\n";
					echo "</div></div>\n";

                                        echo "</article>\n";
				}


				if($file_durchlauf) { //Abschluss der Filelisten-Tabelle
					echo "</div></div>\n<!-- end file list: private-functions //-->\n";
//					echo "<tr><td colspan=\"2\"><img src=\"img/leer.gif\" border=\"0\" alt=\"\" /></td></tr>\n";
				}
			} //Ende Liste Dateien
		}

		//Zaehler mitführen
		$_SESSION["list_zaehler"]++;
	}
	mysql_free_result($result);
	return $vor;
}

function true_false($wert) {
	//Wechselt den Wahr/Falsch wert zum Gegenteil: 1=>0 und 0=>1
	return (intval($wert)) ? 0 : 1;
}

function on_off($wert, $string, $art = 1) {
	//Erzeugt das Status-Zeichen für Klapp-Auf/Zu
	//Wenn Art = 1 dann als Zeichen, ansonsten als Bild
	if($wert) {
		return ($art == 1) ? "+" : "<i class=\"fas fa-folder\"></i>";
	} else {
		return ($art == 1) ? "-" : "<i class=\"far fa-folder-open\"></i>";
	}
}
?>