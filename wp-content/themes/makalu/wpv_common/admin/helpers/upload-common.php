<?php

/*
 * remove some tabs from the upload page
 */

function image_upload_tabs ($tabs) {
	unset($tabs['type_url'], $tabs['media']);
    return $tabs;
}

/*
 * disable multiple files upload
 */

function disable_flash_uploader($flash){
	return false;
}

if(isset($_REQUEST['media_image_upload'])) {
	function wpv_plupload_add_param_media($opts) {
		$opts['url'] = $opts['url'] . '?media_image_upload=1';
		return $opts;
	}
	add_filter('plupload_init', 'wpv_plupload_add_param_media');
}

if(isset($_REQUEST['gallery_image_upload'])) {
	function wpv_plupload_add_param_gallery($opts) {
		$opts['url'] = $opts['url'] . '?gallery_image_upload=1';
		return $opts;
	}
	add_filter('plupload_init', 'wpv_plupload_add_param_gallery');
}
