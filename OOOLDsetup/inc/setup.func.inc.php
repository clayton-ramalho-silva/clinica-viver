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

//setup functions

$DOCROOT = rtrim(str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))), '/');
include($DOCROOT.'/include/inc_lib/revision/revision.php');

if(empty($_SERVER['DOCUMENT_ROOT'])) {
	$_SERVER['DOCUMENT_ROOT'] = $DOCROOT;
}

$phpwcms_version		= PHPWCMS_VERSION;
$phpwcms_release_date	= PHPWCMS_RELEASE_DATE;
$phpwcms_revision		= PHPWCMS_REVISION;

function read_textfile($filename) {
	if(is_file($filename)) {
		$fd = @fopen($filename, "rb");
		$text = fread($fd, filesize($filename));
		fclose($fd);
		return $text;
	} else {
		return false;
	}
}

function write_textfile($filename, $text) {
	if($fp = @fopen($filename, "w+b")) {;
		fwrite($fp, $text);
		fclose($fp);
		return true;
	} else {
		return false;
	}
}

function set_chmod($path, $rights, $status, $file_folder=0) {

	$Cpath = $_SERVER['DOCUMENT_ROOT'].$path;
	if(@file_exists($Cpath)) {
		if(@chmod($Cpath, $rights)) {
			$status = $file_folder ? check_path_status($path) : check_file_status($path);
		}
	}
	return $status;
}

function check_path_status($path) {
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$status = 0;
	$status += (is_dir($path)) ? 1 : 0;
	if($status) {
		$status += (is_writable($path)) ? 1 : 0;
	}
	return $status;
}

function check_file_status($path) {
	$path = $_SERVER['DOCUMENT_ROOT'].$path;
	$status = 0;
	$status += (is_file($path)) ? 1 : 0;
	if($status) {
		$status += (is_writable($path)) ? 1 : 0;
	}
	return $status;
}

function gib_bg_color($status) {
	$color = ' bgcolor="#FF3300"';
	switch($status) {
		case 2: $color = ' bgcolor="#99CC00"';
				break;
		case 1: $color = ' bgcolor="#99CC00"';
				break;
	}
	return $color;

}

function gib_status_text($status) {
	$msg = "&nbsp;<b>FALSE</b> (not existing)";
	switch($status) {
		case 2: $msg = "&nbsp;<b>OK</b> (exists + writable)";
				break;
		case 1: $msg = "&nbsp;<b>FALSE</b> (exists + not writable)";
				break;
		case 3: $msg = "&nbsp;<b>OK</b> (exists + not writable)";
				break;
	}
	return $msg;
}

function slweg($string_wo_slashes_weg, $string_laenge=0) {
	// Falls die Serverfunktion magic_quotes_gpc aktiviert ist, so
	// sollen die Slashes herausgenommen werden, anderenfalls nicht
	$string_wo_slashes_weg = trim($string_wo_slashes_weg);
	if($string_laenge) $string_wo_slashes_weg = substr($string_wo_slashes_weg, 0, $string_laenge);
	return $string_wo_slashes_weg;
}

function clean_slweg($string_wo_slashes_weg, $string_laenge=0) {
	// Falls die Serverfunktion magic_quotes_gpc aktiviert ist, so
	// sollen die Slashes herausgenommen werden, anderenfalls nicht
	$string_wo_slashes_weg = trim($string_wo_slashes_weg);
	$string_wo_slashes_weg = strip_tags($string_wo_slashes_weg);
	if($string_laenge) $string_wo_slashes_weg = substr($string_wo_slashes_weg, 0, $string_laenge);
	return $string_wo_slashes_weg;
}

function write_conf_file($val) {

	$conf_file  = '<?'."php\n\n";
	$conf_file .= "// database values\n";
	$conf_file .= "\$phpwcms['db_host']           = '".$val["db_host"]."';\n";
	$conf_file .= "\$phpwcms['db_user']           = '".$val["db_user"]."';\n";
	$conf_file .= "\$phpwcms['db_pass']           = '".$val["db_pass"]."';\n";
	$conf_file .= "\$phpwcms['db_table']          = '".$val["db_table"]."';\n";
	$conf_file .= "\$phpwcms['db_prepend']        = '".$val["db_prepend"]."';\n";
	$conf_file .= "\$phpwcms['db_pers']           = ".intval($val["db_pers"]).";\n";
	$conf_file .= "\$phpwcms['db_charset']        = '".$val["db_charset"]."';\n";
	$conf_file .= "\$phpwcms['db_collation']      = '".$val["db_collation"]."';\n";
	$conf_file .= "\$phpwcms['db_version']        = ".intval($val["db_version"]).";\n";
	$conf_file .= "\$phpwcms['db_timezone']       = '".trim($val["db_timezone"])."'; // set MySQL session time zone http://dev.mysql.com/doc/refman/5.5/en/time-zone-support.html\n";

	$conf_file .= "\n// site values\n";
	if(rtrim($val["site"], '/') == 'http://'.$_SERVER['SERVER_NAME']) {
		$conf_file .= "\$phpwcms['site']              = 'http://'.\$_SERVER['SERVER_NAME'].'/';";
	} else {
		$conf_file .= "\$phpwcms['site']              = '".$val["site"]."';";
	}
	$conf_file .= " // recommend 'http://'.\$_SERVER['SERVER_NAME'].'/'\n";
	$conf_file .= "\$phpwcms['site_ssl_mode']     = 0; // turns the SSL Support of WCMS on (1) or off (0), default value 0\n";
	$conf_file .= "\$phpwcms['site_ssl_url']      = ''; // URL assigned to the SSL Certificate. Recommend 'https://'.\$_SERVER['SERVER_NAME'].'/'\n";
	$conf_file .= "\$phpwcms['site_ssl_port']     = 443; // The Port on which you SSL Service serve the secure Sites, default SSL port is 443\n\n";

	$conf_file .= "\$phpwcms['admin_name']        = '".$val["admin_name"]."'; //default: Webmaster\n";
	$conf_file .= "\$phpwcms['admin_user']        = '".$val["admin_user"]."'; //default: admin\n";
	$conf_file .= "\$phpwcms['admin_pass']        = '".$val["admin_pass"]."'; //MD5(phpwcms)\n";
	$conf_file .= "\$phpwcms['admin_email']       = '".$val["admin_email"]."'; //default: noreplay@host\n";

	$conf_file .= "\n// paths\n";
	if(!$val['DOC_ROOT'] || $val['DOC_ROOT'] == $_SERVER['DOCUMENT_ROOT']) {
		$conf_file .= "\$phpwcms['DOC_ROOT']          = \$_SERVER['DOCUMENT_ROOT'];";
	} else {
		$conf_file .= "\$phpwcms['DOC_ROOT']          = '".$val["DOC_ROOT"]."';         //default: \$_SERVER['DOCUMENT_ROOT']";
	}

	$real_doc = str_replace('\\', '/', dirname(dirname(dirname(__FILE__))));
	if(isset($val["root"]) && $val["root"] !== '') {
		$real_doc = explode($val["root"], $real_doc);
		$real_doc = rtrim($real_doc[0], '/');
	}
	$conf_file .= "// current DOC_ROOT seems to be: '".$real_doc."' \n";
	$conf_file .= "\$phpwcms['root']         		= '".$val["root"]."';         //default: ''\n";
	$conf_file .= "\$phpwcms['file_path']         = '".$val["file_path"]."';    //default: 'filearchive'\n";
	$conf_file .= "\$phpwcms['templates']         = '".$val["templates"]."';    //default: 'template'\n";
	$conf_file .= "\$phpwcms['content_path']      = '".$val["content_path"]."'; //default: 'content'\n";
	$conf_file .= "\$phpwcms['cimage_path']       = 'images';  //default: 'images'\n";
	$conf_file .= "\$phpwcms['ftp_path']          = '".$val["ftp_path"]."';     //default: 'upload'\n";

	$conf_file .= "\n// content values\n";
	$conf_file .= "\$phpwcms['file_maxsize']      = ".intval($val["file_maxsize"])."; //Bytes (50 x 1024 x 1024)\n";
	$conf_file .= "\$phpwcms['content_width']     = ".intval($val["content_width"])."; //max width of the article content column - important for rendering multi column images\n";
	$conf_file .= "\$phpwcms['img_list_width']    = ".intval($val["img_list_width"])."; //max with of the list thumbnail image\n";
	$conf_file .= "\$phpwcms['img_list_height']   = ".intval($val["img_list_height"])."; //max height of the list thumbnail image\n";
	$conf_file .= "\$phpwcms['img_prev_width']    = ".intval($val["img_prev_width"])."; //max width of the large preview image\n";
	$conf_file .= "\$phpwcms['img_prev_height']   = ".intval($val["img_prev_height"])."; //max height of the large preview image\n";
	$conf_file .= "\$phpwcms['max_time']          = ".intval($val["max_time"])."; //logout after max_time/60 seconds\n";

	$conf_file .= "\n// other stuff\n";
	$conf_file .= "\$phpwcms['image_library']     = 'GD2';    //GD, GD2, ImageMagick, GraphicsMagick or GM, NetPBM\n";
	$conf_file .= "\$phpwcms['library_path']      = '';       //Path to ImageMagick or NetPBM\n";
	$conf_file .= "\$phpwcms['rewrite_url']       = 1; // whether URL should be rewritable\n";
	$conf_file .= "\$phpwcms['rewrite_ext']	  	  = '.html'; // The file extension used while URL is rewritten\n";
	$conf_file .= "\$phpwcms['alias_allow_slash'] = 0; // Allow slashes / in ALIAS\n";
	$conf_file .= "\$phpwcms['wysiwyg_editor']    = 1;  //0 = no wysiwyg editor, 1 = CKEditor 4\n";
	$conf_file .= "\$phpwcms['allowed_lang']      = array('en','de','fr','es');     //array of allowed languages: array('en', 'de', 'fr', 'es')\n";
	$conf_file .= "\$phpwcms['be_lang_parse']     = false; // to disable backend language parsing use false, otherwise 'BBCode' or 'BraceCode'\n";
	$conf_file .= "\$phpwcms['DOCTYPE_LANG']      = '';		  //by default same as \$phpwcms['default_lang'], but can be injected by whatever you like\n";
	$conf_file .= "\$phpwcms['default_lang']      = '".$val["default_lang"]."';  //default language\n";
	$conf_file .= "\$phpwcms['charset']           = '".$val["charset"]."';  //default charset 'utf-8'\n";
	$conf_file .= "\$phpwcms['php_charset']       = false; // set PHP default charset to $phpwcms[charset]\n";
	$conf_file .= "\$phpwcms['allow_remote_URL']  = 1;  //0 = no remote URL in {PHP:...} replacement tag allowed, 1 = allowed\n";
	$conf_file .= "\$phpwcms['jpg_quality']       = 85; //JPG Quality Range 25-100\n";
	$conf_file .= "\$phpwcms['sharpen_level']     = 1;  //Sharpen Level - only ImageMagick: 0, 1, 2, 3, 4, 5 -- 0 = no, 5 = extra sharp\n";
	$conf_file .= "\$phpwcms['allow_ext_init']    = 1;  //allow including of custom external scripts at frontend initialization\n";
	$conf_file .= "\$phpwcms['allow_ext_render']  = 1;  //allow including of custom external scripts at frontend rendering\n";
	$conf_file .= "\$phpwcms['cache_enabled']     = 0;        //cache On/Off - 1 = caching On / 0 = caching Off (default)\n";
	$conf_file .= "\$phpwcms['cache_timeout']     = 0;  //default cache timeout setting in seconds - 0 = caching Off\n";
	$conf_file .= "\$phpwcms['imgext_disabled']   = '';  //comma seperated list of imagetypes which should not be handled 'pdf,ps'\n";
	$conf_file .= "\$phpwcms['multimedia_ext']    = 'aif,aiff,mov,movie,mp3,mpeg,mpeg4,mpeg2,wav,swf,swc,ram,ra,wma,wmv,avi,au,midi,moov,rm,rpm,mid,midi'; //comma seperated list of file extensiosn allowed for multimedia\n";
	$conf_file .= "\$phpwcms['inline_download']   = 1;  //1 = try to display download documents in new window; 0 = show safe under dialog\n";
	$conf_file .= "\$phpwcms['form_tracking']     = 1; //make a db entry for each form\n";
	$conf_file .= "\$phpwcms['formmailer_set']    = array('allow_send_copy' => 0, 'global_recipient_email' => 'mail@example.com'); //for better security handling\n";
	$conf_file .= "\$phpwcms['allow_cntPHP_rt']   = 1; //allow PHP replacement tags and includes in content parts\n";
	$conf_file .= "\$phpwcms['GETparameterName']  = 'id'; //must have a minimum of 2 chars \n";
	$conf_file .= "\$phpwcms['BOTS']              = array('googlebot', 'msnbot', 'bingbot', 'ia_archiver', 'altavista', 'slurp', 'yahoo', 'jeeves', 'teoma', 'lycos', 'crawler'); //don't start session \n";
	$conf_file .= "\$phpwcms['mode_XHTML']        = 3; // Doctype: 1 = XHTML 1.0 Transitional, 0 = HTML 4.01 Transitional, 2 = XHTML 1.0 Strict, 3 = HTML5 \n";
	$conf_file .= "\$phpwcms['header_XML']        = 0; // Content Type: 1 = application/xhtml+xml, 0 = text/html \n";
	$conf_file .= "\$phpwcms['IE7-js']        	  = 0; // load IE7-js - fix for HTML/CSS/PNG bugs in IE\n";
	$conf_file .= "\$phpwcms['php_timezone']  	  = ''; // overwrite PHP default time zone http://php.net/manual/en/timezones.php\n";
	$conf_file .= "\$phpwcms['wysiwyg_template']  = array(); // deprecated\n";
	$conf_file .= "\$phpwcms['GET_pageinfo']      = 0; // will add \"&pageinfo=/cat1/cat2/page-title.htm\" based on the breadcrumb information for each site link \n";
	$conf_file .= "\$phpwcms['version_check']     = 1; // checks for current release of phpwcms online \n";
	$conf_file .= "\$phpwcms['SESSION_FEinit']    = 0; // set 1 to enable sessions in frontend, 0 to disable sessions in frontend \n";
	$conf_file .= "\$phpwcms['Login_IPcheck']     = 0; \n";
	$conf_file .= "\$phpwcms['frontend_edit']	  = 0; // enable content specific direct links - linking direct into the backend \n";
	$conf_file .= "\$phpwcms['gd_memcheck_off']   = 0; // disable GD php memory check before resize an image \n";
	$conf_file .= "\$phpwcms['enable_chat']		  = 0; // enable or disable chat function, by default it is disabled - not recommend anymore to use it \n";
	$conf_file .= "\$phpwcms['enable_messages']	  = 0; // enable or disable internal messags, by default it is disabled - not recommend anymore to use it \n";
	$conf_file .= "\$phpwcms['enable_seolog']	  = 1; // enable or disable logging of search engine referrer data \n";
	$conf_file .= "\$phpwcms['i18n_parse']	  	  = 1; // enable|disable browser based language parser - all @@Text@@ will be parsed and checked for translation/var based replacement\n";
	$conf_file .= "\$phpwcms['i18n_complex']	  = 0; // enable|disable the way browser language setting should be used, false = the easier way (always 2 chars 'en'), true - 'en-gb'...\n";
	$conf_file .= "\$phpwcms['FCK_FileBrowser']   = 1; // enable|disable phpwcms Filebrowser in FCKeditor instead of built-in FCK file bowser support\n";
	$conf_file .= "\$phpwcms['JW_FLV_License']    = ''; // insert your JW FLV Media Player License Code here - License warning will no longer displayed\n";
	$conf_file .= "\$phpwcms['feuser_regkey']	  = 'FEUSER';\n";
	$conf_file .= "\$phpwcms['login.php']	  	  = 'admin.php';\n";
	$conf_file .= "\$phpwcms['js_lib']			  = array(); // extends default lib settings array('jquery'=>'jQuery 1.3','mootools-1.4'=>'MooTools 1.4','mootools-1.1'=>'MooTools 1.1);\n";
	$conf_file .= "\$phpwcms['video-js']          = ''; // can be stored locally too 'template/lib/video-js/ (//vjs.zencdn.net/4.8/)\n";
	$conf_file .= "\$phpwcms['render_device']     = 0; // allow user agent specific rendering templates <!--if:mobile-->DoMobile<!--/if--><!--!if:mobile-->DoNotMobile<!--/!if--><!--!if:default-->Default<!--/!if-->\n";
	$conf_file .= "\$phpwcms['detect_pixelratio'] = 0; // will inject the page with JavaScript to detect Retina devices\n";
	$conf_file .= "\$phpwcms['im_fix_colorspace'] = 'RGB'; // some ImageMagick installs (on Mac) might have problems with colorspace setting, if colors are not good try SRGB\n";
	$conf_file .= "\$phpwcms['wkhtmltopdf_path']  = ''; // used for generating PDF, use full path including application name '/usr/bin/wkhtmltopdf'\n";
	$conf_file .= "\$phpwcms['render_clean_html'] = 0; // clean up HTML source a bit, experimental can have unexpected side effects\n";
	$conf_file .= "\$phpwcms['browser_check']     = array('fe'=>false, 'be'=>false, 'vs' => ''); // enable Browser Update check in frontend and/or backend, use 'vs' to which browser version, see http://www.browser-update.org/index.html#install\n";
	$conf_file .= "\$phpwcms['usergroup_support'] = false; // set true or false to support/disable this feature, is experimental\n";
	$conf_file .= "\$phpwcms['force301_id2alias'] = false; // send 301 HTTP Redirect when article/structure has alias but ID is given\n";
	$conf_file .= "\$phpwcms['force301_2struct']  = false; // send 301 HTTP Redirect to structure level when only 1 article is inside\n";
	$conf_file .= "\$phpwcms['allow_empty_alias'] = false; // do not auto-create (default) alias when alias field is empty\n";
	$conf_file .= "\$phpwcms['enable_deprecated'] = false; // enable/disable deprecated functionality, enable if you miss things\n";
	$conf_file .= "\$phpwcms['reserved_alias']    = array(); // use this to block custom alias\n";
	$conf_file .= "\$phpwcms['canonical_off']     = false; // disable canonical link tag\n";
	$conf_file .= "\$phpwcms['viewport']		  = 'width=device-width, initial-scale=1.0'; // set viewport like \"width=device-width, initial-scale=1.0\"\n";
	$conf_file .= "\$phpwcms['X-UA-Compatible']   = 'IE=Edge'; // set browser compatibility mode using meta tag X-UA-Compatible\n";
	$conf_file .= "\$phpwcms['base_href']		  = false; // set the <base href=\"\"> tag, use string (URL) or bool TRUE/FALSE\n";
	$conf_file .= "\$phpwcms['cp_default']		  = 0; // set the default CP ID here as used in structure level editor, see http://goo.gl/BVODr\n";
	$conf_file .= "\$phpwcms['js_in_body']		  = 0; // add <script> direct before </body> instead inside of <head>\n";
	$conf_file .= "\$phpwcms['set_article_active']	= 1; // activate (1) or disable (0) article by default on create\n";
	$conf_file .= "\$phpwcms['set_category_active']	= 1; // activate (1) or disable (0) category/structure level by default on create\n";
	$conf_file .= "\$phpwcms['set_file_active']		= 1; // activate (1) or disable (0) files and folders by default on create\n";
	$conf_file .= "\$phpwcms['set_news_active']		= 1; // activate (1) or disable (0) news by default on create\n";
	$conf_file .= "\$phpwcms['log_404error']		= false; // log each 404 for redirect edit\n";
	$conf_file .= "\$phpwcms['set_sociallink']		= array('article' => false, 'articlecat' => false, 'news' => false, 'shop' => false, 'render' => true); // TRUE/FALSE to enable status for article/articlecat/news/shop by default, render TRUE/FALSE to enable/disable in frontend\n";
	$conf_file .= "\$phpwcms['header_comment']		= '';\n";

	$conf_file .= "\n// Email specific settings (based on phpMailer)\n";
	$conf_file .= "\$phpwcms['SMTP_FROM_EMAIL']   = '".str_replace("'", "\\'", $val["SMTP_FROM_EMAIL"])."'; // reply/from email address\n";
	$conf_file .= "\$phpwcms['SMTP_FROM_NAME']    = '".str_replace("'", "\\'", $val["SMTP_FROM_NAME"])."'; // reply/from name\n";
	$conf_file .= "\$phpwcms['SMTP_HOST']         = '".$val["SMTP_HOST"]."'; // SMTP server (host/IP)\n";
	$conf_file .= "\$phpwcms['SMTP_PORT']         = ".intval($val["SMTP_PORT"])."; // SMTP server port (default 25)\n";
	$conf_file .= "\$phpwcms['SMTP_MAILER']       = '".$val["SMTP_MAILER"]."'; // mail method: mail (default), smtp, sendmail\n";
	$conf_file .= "\$phpwcms['SMTP_USER']         = '".str_replace("'", "\\'", $val["SMTP_USER"])."'; // default SMTP login (user) name\n";
	$conf_file .= "\$phpwcms['SMTP_PASS']         = '".str_replace("'", "\\'", $val["SMTP_PASS"])."'; // default SMTP password\n";
	$conf_file .= "\$phpwcms['SMTP_SECURE']       = '".$val["SMTP_SECURE"]."'; // secure connection, phpMailer options: '', 'ssl' or 'tls'\n";
	$conf_file .= "\$phpwcms['SMTP_AUTH']         = ".intval($val["SMTP_AUTH"])."; // SMTP authentication, ON=1/OFF=0\n";
	$conf_file .= "\$phpwcms['SMTP_AUTH_TYPE']    = '".$val["SMTP_AUTH_TYPE"]."'; // sets SMTP auth type: LOGIN (default), PLAIN, NTLM, CRAM-MD5\n";
	$conf_file .= "\$phpwcms['SMTP_REALM']        = '".$val["SMTP_REALM"]."'; // SMTP realm, used for NTLM auth type\n";
	$conf_file .= "\$phpwcms['SMTP_WORKSTATION']  = '".$val["SMTP_WORKSTATION"]."'; // SMTP workstation, used for NTLM auth type\n";

	$conf_file .= "\ndefine('PHPWCMS_INCLUDE_CHECK', true);\n";
	$conf_file .= "//Personalização da Ferramenta\n";
	$conf_file .= "\$phpwcms['palavras'] = 17; // Valor de limite de palavras de RSS Feeds\n";
	$conf_file .= "\$phpwcms['LarguraGeral'] = '100%';\n";
	$conf_file .= "\$phpwcms['LarguraInterna'] = '100%';\n";
	$conf_file .= "\$phpwcms['LarguraInterna2'] = '100%';\n";
	$conf_file .= "\$phpwcms['Modo'] = '1'; // Gerenciamento de Opções da ferramenta: 1 = Administrador, 0 = Usuário\n";
	$conf_file .= "\$phpwcms['Modulos'] = '0'; // Habilita ou Desabilita a opção Módulos\n";
	$conf_file .= "\$phpwcms['ListaEmails'] = '0'; // Habilita ou Desabilita a opção Lista de E-mails\n";
	$conf_file .= "\$phpwcms['Admin'] = '0'; // Habilita ou Desabilita a opção Administrador\n";
	$conf_file .= "\$phpwcms['divFone'] = '0'; // Habilita ou Desabilita a div em volta dos telefones\n";

	$conf_file .= "\$phpwcms['btDados'] = '1'; // Habilita ou desabilita o botão de Dados da Empresa\n";
	$conf_file .= "\$phpwcms['btPedido'] = '0'; // Habilita ou desabilita o botão de Pedido e Produtos\n";
	$conf_file .= "\$phpwcms['btBanners'] = '0'; // Habilita ou desabilita o botão de Banners ADS\n";
	$conf_file .= "\$phpwcms['btSistema'] = '0'; // Habilita ou desabilita o botão de Sistema Personalizado\n";
	$conf_file .= "\n?>";

	write_textfile("setup.conf.inc.php", $conf_file);
}

function aporeplace($string_to_convert="") {
	//Ändert die einfachen Apostrophe für SQL-Funktionen in doppelte
	$string_to_convert = str_replace("\\", "\\\\", $string_to_convert);
	$string_to_convert = str_replace("'", "''", $string_to_convert );
	return $string_to_convert;
}

function html_specialchars($h="") {
	//used to replace the htmlspecialchars original php function
	//not compatible with many internation chars like turkish, polish
	$h = preg_replace("/&(?!#[0-9]+;)/s", '&amp;', $h );
	$h = str_replace( "<", "&lt;"  , $h );
	$h = str_replace( ">", "&gt;"  , $h );
	$h = str_replace( '"', "&quot;", $h );
	$h = str_replace( "'", "&#039;", $h );
	$h = str_replace( "\\", "&#92;", $h );
	return $h;
}

// taken from http://de.php.net/manual/de/function.phpinfo.php#59573
function parsePHPModules() {
 ob_start();
 phpinfo(INFO_MODULES);
 $s = ob_get_clean();
 $s = strip_tags($s,'<h2><th><td>');
 $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$s);
 $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$s);
 $vTmp = preg_split('/(<h2>[^<]+<\/h2>)/',$s,-1,PREG_SPLIT_DELIM_CAPTURE);
 $vModules = array();
 for ($i=1;$i<count($vTmp);$i++) {
  if (preg_match('/<h2>([^<]+)<\/h2>/',$vTmp[$i],$vMat)) {
   $vName = trim($vMat[1]);
   $vTmp2 = explode("\n",$vTmp[$i+1]);
   foreach ($vTmp2 AS $vOne) {
   $vPat = '<info>([^<]+)<\/info>';
   $vPat3 = "/$vPat\s*$vPat\s*$vPat/";
   $vPat2 = "/$vPat\s*$vPat/";
   if (preg_match($vPat3,$vOne,$vMat)) { // 3cols
     $vModules[$vName][trim($vMat[1])] = array(trim($vMat[2]),trim($vMat[3]));
   } elseif (preg_match($vPat2,$vOne,$vMat)) { // 2cols
     $vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
   }
   }
  }
 }
 return $vModules;
}

function errorWarning($warning='') {
	$t  = '<p class="error"><img src="../img/famfamfam/icon_alert.gif" alt="Alert" border="0" class="icon1" /><b>';
	$t .= $warning;
	$t .= '</b></p>';
	return $t;
}

// based on definitions of phpMyAdmin
$mysql_charset_map = array(
    'iso-8859-1'   => 'latin1',

);

$available_languages = array(

    'ptbr-iso-8859-1'   => array('pt[-_]br|brazilian portuguese', 'brazilian_portuguese-iso-8859-1', 'pt-BR', 'Portugu&ecirc;s'),
    'pt-iso-8859-1'     => array('pt|portuguese', 'portuguese-iso-8859-1', 'pt', 'Portugu&ecirc;s'),
);

function _dbQuery($query='', $_queryMode='ASSOC') {

	if(empty($query)) return false;

	global $db;
	$queryResult	= array();
	$queryCount		= 0;

	if($result = @mysqli_query($db, $query)) {

		switch($_queryMode) {

			// INSERT, UPDATE, DELETE
			case 'INSERT':	$queryResult['INSERT_ID']		= mysqli_insert_id($db);
			case 'DELETE':
			case 'UPDATE':
							$queryResult['AFFECTED_ROWS']	= mysqli_affected_rows($db);
							return $queryResult;
							break;

			// SELECT Queries
			case 'ROW':		$_queryMode = 'mysqli_fetch_row';	break;
			case 'ARRAY':	$_queryMode = 'mysqli_fetch_array';	break;
			default: 		$_queryMode = 'mysqli_fetch_assoc';

		}

		while($row = $_queryMode($result)) {

			$queryResult[$queryCount] = $row;
			$queryCount++;

		}
		mysqli_free_result($result);

		return $queryResult;

	} else {
		return false;
	}
}

if(!function_exists('decode_entities')) {
	function decode_entities($string) {
		// replace numeric entities
		$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
		$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
		// replace literal entities
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($string, $trans_tbl);
	}
}

?>