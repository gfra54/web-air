<?php

// this *must* be included after lessphp has been initialized
// this file assumes that the lessphp instance is $l

if(!function_exists('wpv_mb_chr')) {
	// same as chr() but for unicode
	function wpv_mb_chr($char) {
		if ($char < 128)
			return chr($char);
		if ($char < 2048)
			return chr(($char >> 6) + 192) . chr(($char & 63) + 128);

		if ($char < 65536)
			return chr(($char >> 12) + 224) . chr((($char >> 6) & 63) + 128) . chr(($char & 63) + 128);

		if ($char < 2097152)
			return chr(($char >> 18) + 240) . chr((($char >> 12) & 63) + 128) . chr((($char >> 6) & 63) + 128) . chr(($char & 63) + 128);

		return '';
	}
}

if(!function_exists('wpv_get_icon_list')) {
	function wpv_get_icon_list() {
		return include(BASEPATH.'wpv_common/assets/fonts/icons/list.php');
	}

	function wpv_get_theme_icon_list() {
		return include(BASEPATH.'wpv_theme/assets/fonts/icons/list.php');
	}
}

function wpv_lessphp_icon($arg) {
	list($type, $icon) = $arg;

	$icons = wpv_get_icon_list();
	$theme_icons = wpv_get_theme_icon_list();

	if(isset($icons[$icon]))
		$icon = wpv_mb_chr($icons[$icon]);

	$theme_icon = preg_replace('/^theme-/', '', $icon, 1);
	if(isset($theme_icons[$theme_icon]))
		$icon = wpv_mb_chr($theme_icons[$theme_icon]);
	
	return array('string', '"', array($icon));
}
$l->registerFunction("icon", "wpv_lessphp_icon");
