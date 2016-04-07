<?php

/**
 * columnize content
 */

global $wpv_in_row, $wpv_last_row;
$wpv_in_row = 0;
$wpv_last_row = -1;

function wpv_shortcode_column($atts, $content = null, $code) {
	global $wpv_in_row, $wpv_last_row;

	$before = '';

	if(current_theme_supports('wpv-simple-grid')) {
		$has_price = (strpos($content, '[price') !== false);

		if($wpv_in_row > $wpv_last_row) {
			$rowclass = ($has_price) ? 'has-price' : '';

			$code .= ' first';
			$before = '<div class="row '.$rowclass.'">';
			$wpv_last_row = $wpv_in_row;
		}

		if($has_price || apply_filters('wpv_nomargin_column', false, $content))
			$code .= ' nomargin';

		$wpv_in_row++;
		$content = do_shortcode(trim($content));
		$wpv_in_row--;
	} else {
		$content = do_shortcode(trim($content));
	}

	if(is_array($atts))
		$code .= ' '.implode(' ', $atts);

	return $before.'<div class="'.$code.'">' . $content . '</div>';
}

function wpv_shortcode_column_last($atts, $content = null, $code) {
	$after = '<div class="clearboth"></div>';

	if(current_theme_supports('wpv-simple-grid')) {
		global $wpv_in_row, $wpv_last_row;

		if(strpos($content, '[price') !== false  || apply_filters('wpv_nomargin_column', false, $content))
			$code .= ' nomargin';

		$wpv_in_row++;
		$content = do_shortcode(trim($content));
		$wpv_in_row--;
		$wpv_last_row--;

		$after = '</div>';
	} else {
		$content = do_shortcode(trim($content));
	}

	if(is_array($atts))
		$code .= ' '.implode(' ', $atts);

	return ' <div class="'.str_replace('_last','',$code).' last"> '.$content.' </div>'.$after;
}

add_shortcode('one_half', 'wpv_shortcode_column');
add_shortcode('one_third', 'wpv_shortcode_column');
add_shortcode('one_fourth', 'wpv_shortcode_column');
add_shortcode('one_fifth', 'wpv_shortcode_column');
add_shortcode('one_sixth', 'wpv_shortcode_column');

add_shortcode('two_thirds', 'wpv_shortcode_column');
add_shortcode('three_fourths', 'wpv_shortcode_column');
add_shortcode('two_fifths', 'wpv_shortcode_column');
add_shortcode('three_fifths', 'wpv_shortcode_column');
add_shortcode('four_fifths', 'wpv_shortcode_column');
add_shortcode('five_sixths', 'wpv_shortcode_column');

add_shortcode('one_half_last', 'wpv_shortcode_column_last');
add_shortcode('one_third_last', 'wpv_shortcode_column_last');
add_shortcode('one_fourth_last', 'wpv_shortcode_column_last');
add_shortcode('one_fifth_last', 'wpv_shortcode_column_last');
add_shortcode('one_sixth_last', 'wpv_shortcode_column_last');

add_shortcode('two_thirds_last', 'wpv_shortcode_column_last');
add_shortcode('three_fourths_last', 'wpv_shortcode_column_last');
add_shortcode('two_fifths_last', 'wpv_shortcode_column_last');
add_shortcode('three_fifths_last', 'wpv_shortcode_column_last');
add_shortcode('four_fifths_last', 'wpv_shortcode_column_last');
add_shortcode('five_sixths_last', 'wpv_shortcode_column_last');