<?php

require_once('wpv_common/wpv_framework.php');

new Wpv_Framework(array(
	'name' => 'makalu',
	'slug' => 'makalu'
));

// FIXME remove next line when the editor is fully functional, to be packaged as a standalone module with no dependencies to the theme
define ('VAMTAM_EDITOR_IN_THEME', true); include_once WPV_DIR.'vamtam-editor/editor.php';
