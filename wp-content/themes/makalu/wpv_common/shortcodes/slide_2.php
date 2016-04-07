<?php

/*
 * slider helper shortcode
 */

function wpv_shortcode_slide_2($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'bg_color' => 'transparent',
		'bg_opacity' => 1,
		'bg_image' => '',
		'text1' => '',
		'text2' => '',
		'text3' => '',
		'add_image_1' => '',
		'add_image_2' => '',
		'class' => '',
		'icon' => '',
		'title' => '',
	), $atts));
	
	$text1 = empty($h1) ? $text1 : $h1;
	$text2 = empty($h2) ? $text2 : $h2;
	$text3 = empty($h3) ? $text3 : $h3;

	ob_start();

	include WPV_SHORTCODE_TEMPLATES . 'slide_2.php';

	return ob_get_clean();
}
add_shortcode('slide_2','wpv_shortcode_slide_2');
