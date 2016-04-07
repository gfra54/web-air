<?php

/**
 * get_option wrapper
 */

function wpv_get_option($name, $default = null, $stripslashes = true) {
	global $wpv_defaults;
	if($default === null)
		$default = isset($wpv_defaults[$name]) ? $wpv_defaults[$name] : false;
	
	$option = get_option('wpv_'.$name, $default);

	if(is_string($option)) {
		if($option === 'true')
			return true;

		if($option === 'false')
			return false;

		if($stripslashes)
			return stripslashes($option);
	}
	
	return $option;
}

function wpv_get_optionb($name, $default = null, $stripslashes = true) {
	$value = wpv_get_option($name, $default, $stripslashes);

	if($value === '1' || $value === 'true')
		return true;

	if($value === '0' || $value === 'false')
		return false;
	
	return $value;
}

/**
 * echo option
 */

function wpvge($name, $default = null, $stripslashes = true, $boolean = false) {
	$opt = wpv_get_option($name, $default, $stripslashes);
	
	if($boolean === true) {
		$opt = (bool)$opt;
	}
	
	echo $opt;
}

/**
 * set option
 */

function wpv_update_option($name, $new_value) {
	update_option('wpv_' . $name, $new_value);
}

/**
 * delete option
 */

function wpv_delete_option($name) {
	delete_option('wpv_' . $name);
}