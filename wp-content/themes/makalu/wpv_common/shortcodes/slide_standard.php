<?php

/*
 * slider helper shortcode
 */

function wpv_shortcode_slide_standard($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'bg_color' => 'transparent',
		'bg_opacity' => 1,
		'bg_image' => '',
		'x_align' => 'center',
		'y_align' => 'middle',
		'class' => '',
		'icon' => '',
		'title' => '',
	), $atts));
	
	ob_start();

	include WPV_SHORTCODE_TEMPLATES . 'slide_standard.php';

	return ob_get_clean();
}
add_shortcode('slide_standard','wpv_shortcode_slide_standard');
