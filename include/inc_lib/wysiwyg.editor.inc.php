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

// wysiwyg editor

if(empty($wysiwyg_editor['value']))		$wysiwyg_editor['value']	= '';
if(!isset($wysiwyg_editor['field']))	$wysiwyg_editor['field']	= 'wysiwyg_editor';
if(empty($wysiwyg_editor['rows']))		$wysiwyg_editor['rows']		= '15';

if(empty($wysiwyg_editor['width']) && empty($wysiwyg_editor['width2'])){

	$wysiwyg_editor['width']	= '440px';
    $width = '440px';

} else {

	if(empty($wysiwyg_editor['width2'])){

		$wysiwyg_editor['width']	= '440px';
        $width = '732';

	} else {

        $wysiwyg_editor['width']	= $wysiwyg_editor['width2'];
		$width = $wysiwyg_editor['width2'];

    }

}

if(empty($wysiwyg_editor['height']) && empty($wysiwyg_editor['height2'])){
	$wysiwyg_editor['height']	= '400px';
	$height = '400px';
} else {
	if(empty($wysiwyg_editor['height2'])){
		$wysiwyg_editor['height']	= '400px';
		$height = '400';
	} else {
		$wysiwyg_editor['height']	= $wysiwyg_editor['height2'];
		$height = $wysiwyg_editor['height2'];
	}
}


if(!isset($wysiwyg_editor['editor'])) {
	$wysiwyg_editor['editor'] = 1;
	if(isset($_SESSION["WYSIWYG_EDITOR"])) {
		$wysiwyg_editor['editor'] = $_SESSION["WYSIWYG_EDITOR"];
	}
}

if(isset($wysiwyg_editor['expanded'])) {

    $expand = $wysiwyg_editor['expanded'] === '1' ? 'true' : 'false';

} else {

    $expand = 'true';

}

$wysiwyg_editor['lang']	= isset($_SESSION["wcs_user_lang"]) ? $_SESSION["wcs_user_lang"] : 'en';

if($wysiwyg_editor['editor']) {

	$BE['HEADER']['ckeditor.js'] = getJavaScriptSourceLink('include/inc_ext/ckeditor/ckeditor.js');

	// simple textarea - no WYSIWYG editor
	echo '<textarea class="ckeditor" name="'.$wysiwyg_editor['field'].'" rows="'.$wysiwyg_editor['rows'].'" id="'.$wysiwyg_editor['field'].'">';
	echo html($wysiwyg_editor['value'], true).'</textarea>';

	echo '<script type="text/javascript">' . LF;
	echo '	CKEDITOR.replace("'.$wysiwyg_editor['field'].'", {';

	if(is_file(PHPWCMS_TEMPLATE.'config/ckeditor/ckeditor.config.js')) {

		echo '		customConfig: "'.PHPWCMS_URL.TEMPLATE_PATH.'config/ckeditor/ckeditor.config.js"';

	} else {

		echo "
		toolbar: [
			{name: 'tools', items: ['Maximize', '-', 'Source', '-', 'Undo', 'Redo', '-', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Find', '-', 'ShowBlocks']},
			{name: 'links', items: ['Link', 'Unlink', 'Anchor']},
			{name: 'colors', items: ['TextColor', 'BGColor']},
			{name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
			{name: 'paragraph', groups: ['align', 'list', 'indent', 'blocks'], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BulletedList', 'NumberedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv']},
			{name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Iframe', 'SpecialChar']},
			{name: 'styles', items: ['Styles', 'Format', 'Font']},
			{name: 'about', items: ['About']}
		],
		width: ".$width.",
		height: ".$height.",
		extraPlugins: 'magicline',
		toolbarCanCollapse: true,
		toolbarStartupExpanded: ".$expand.",
		forcePasteAsPlainText: true,
		pasteFromWordRemoveFontStyles: true,
		pasteFromWordRemoveStyles: true,
		pasteFromWordPromptCleanup: true,
		language: '".$wysiwyg_editor['lang']."'";

	}

	if (!empty($phpwcms['FCK_FileBrowser'])) {
		echo ',' . LF;
		echo '		filebrowserBrowseUrl: "'.PHPWCMS_URL.'filebrowser.php?opt=16",' . LF;
		echo '		filebrowserImageBrowseUrl : "'.PHPWCMS_URL.'filebrowser.php?opt=17",' . LF;
		echo '		filebrowserWindowWidth: "640",' . LF;
		echo '		filebrowserWindowHeight: "480"';
	}
	echo LF . '	});' . LF;
	echo '</script>';

} else {

	// simple textarea - no WYSIWYG editor
	echo '<textarea name="'.$wysiwyg_editor['field'].'" rows="'.$wysiwyg_editor['rows'];
	echo '" class="v12 editor-textarea" id="'.$wysiwyg_editor['field'].'" ';
	echo 'style="width:'.$wysiwyg_editor['width'].';height:'.$wysiwyg_editor['height'].';">';
	echo html($wysiwyg_editor['value'], true).'</textarea>';

}

?>