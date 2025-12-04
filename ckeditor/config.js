/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.language = 'es';
    // The toolbar groups arrangement, optimized for two toolbar rows.
	// config.toolbarGroups = [
	// 	{ name: 'clipboard',   groups: [ 'clipboard', 'undo', 'cleanup' ] },
	// 	{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	// 	{ name: 'links' },
	// 	{ name: 'insert' },
	// 	{ name: 'tools',       groups: [ 'doctools'] },
	// 	'/',
	// 	{ name: 'basicstyles', groups: [ 'basicstyles' ] },
	// 	{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
	// 	{ name: 'styles' },
	// 	{ name: 'colors' },
	// ];

    config.toolbar = [
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks'] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt','-', 'Templates'] },
		{ name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
        '/',
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'insert',      items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','-', 'Link','Unlink' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl','-', 'TextColor','BGColor' ] }
        
        // { name: 'colors',      items : [ 'TextColor','BGColor' ] }
    ];
    
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	// config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
