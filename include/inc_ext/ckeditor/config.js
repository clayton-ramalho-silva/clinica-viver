/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 * 
 * Adopted for phpwcms, Oliver Georgi
 */

CKEDITOR.editorConfig = function( config ) {
        // Define changes to default configuration here.
        // For the complete reference:
        // http://docs.ckeditor.com/#!/api/CKEDITOR.config

        // The toolbar groups arrangement, optimized for two toolbar rows.
        // http://nightly.ckeditor.com/latest/ckeditor/samples/plugins/toolbar/toolbar.html
        config.toolbarGroups = [
                { name: 'document',    groups: [ 'mode', 'document' ] },
				{ name: 'clipboard',   groups: [ 'source', 'clipboard', 'undo' ] },
				{ name: 'insert' },
                { name: 'links' },
                { name: 'tools' },
                //{ name: 'forms' },
                //'/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph',   groups: [ 'align', 'list', 'indent'] },
                //{ name: 'others' },
                //'/',
                { name: 'colors' },
                { name: 'styles' }

        ];

        // Remove some buttons, provided by the standard plugins, which we don't
        // need to have in the Standard(s) toolbar.
        config.removeButtons = 'Iframe,Flash,Smiley,CreateDiv,FontSize,Search,PageBreak,Print,Format,Font,Save,NewPage,Preview';
        
        config.width = 666;
        config.height = 400;
        
        config.extraPlugins = 'magicline';
		config.extraPlugins = 'showblocks';
		config.extraPlugins = 'showborders';
        
        config.toolbarCanCollapse = true;
        config.toolbarStartupExpanded = true;

        //config.removePlugins = 'resize';
		
		config.forcePasteAsPlainText = true;
		config.pasteFromWordRemoveFontStyles = true;
		config.pasteFromWordRemoveStyles = true;
		config.pasteFromWordPromptCleanup = true;
		config.autoParagraph = config.enterMode = CKEDITOR.ENTER_BR; // inserts <br />
		config.allowedContent = true;
		//config.protectedSource.push( /<i[\s\S]*?\>/g ); //allows beginning <i> tag
		//config.protectedSource.push( /<\/i[\s\S]*?\>/g ); //allows ending </i> tag
		
		//config.contentsCss = 'template/config/ckeditor/ckeditor.custom.css';
		
};