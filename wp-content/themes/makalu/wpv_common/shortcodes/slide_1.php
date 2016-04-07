<?php

/*
 * slider helper shortcode
 */

function wpv_shortcode_slide_1($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'bg_color' => 'transparent',
		'bg_opacity' => 1,
		'bg_image' => '',
		'big_image' => '',
		'small_image' => '',
		'text1' => '',
		'text2' => '',
		'h1' => '',
		'h2' => '',
		'btn_text' => '',
		'btn_href' => '#',
		'btn_target' => '_self',
		'add_image_1' => '',
		'add_image_2' => '',
		'class' => '',
		'icon' => '',
		'title' => '',
	), $atts));

	$text1 = empty($h1) ? $text1 : $h1;
	$text2 = empty($h2) ? $text2 : $h2;
	
	ob_start();

	include WPV_SHORTCODE_TEMPLATES . 'slide_1.php';

	return ob_get_clean();
}
add_shortcode('slide_1','wpv_shortcode_slide_1');
