<?php

/*
 * wrapper for tables
 */

function wpv_shortcode_styled_table($atts, $content = null, $code) {
	return "<div class='styled_table'>" . do_shortcode(trim($content)) . '</div>';
}
add_shortcode('styled_table','wpv_shortcode_styled_table');
