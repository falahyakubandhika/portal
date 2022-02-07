/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	 config.filebrowserBrowseUrl = 'filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
 	 config.filebrowserImageBrowseUrl = 'filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
 	 config.filebrowserUploadUrl = 'filemanager/dialog.php?type=2&editor=ckeditor&fldr='; 
	 config.filebrowserImageBrowseLinkUrl = "filemanager/dialog.php?type=2&editor=ckeditor&fldr=";

};
