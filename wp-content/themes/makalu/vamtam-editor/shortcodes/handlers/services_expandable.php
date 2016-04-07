<?php

/*
 * expandable services shortcode
 */

function wpv_shortcode_services_expandable($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'image' => '',
		'title' => '',
		'class' => '',
		'background' => '',
	), $atts));

	$before = '';
	$content = explode('[split]', $content, 2);
	if(count($content) > 1)
		$before = array_shift($content);
	$content = implode(' ', $content);
	
	ob_start();

	include WPV_SHORTCODE_TEMPLATES . 'services_expandable.php';

	return ob_get_clean();
}
add_shortcode('services_expandable', 'wpv_shortcode_services_expandable');
