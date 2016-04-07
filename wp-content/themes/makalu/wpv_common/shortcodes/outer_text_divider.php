<?php

/*
 * outer text divider shortcode
 */

function wpv_shortcode_outer_text_divider($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'background' => '',
		'icon' => '',
	), $atts));

	if(!empty($icon))
		$icon = "<img src='$icon' alt='' class='icon'/>";

	$style = array();

	if(!empty($background)) {
		$bgdata = (array)json_decode('{'.str_replace("'", '"', $background).'}');
		foreach($bgdata as $prop=>$value) {
			if(!empty($value)) {
				if($prop == 'icon')
					$value = "url($value)";

				$style[] = "background-$prop:$value";
			}
		}
	}

	$style = 'style="'.implode(';', $style).'"';

	return " 
				<div class='full-width-divider'>
					<div class='divider-content' $style>{$icon}
			 
						{$content}
			 
					</div>
				</div>
			 ";
}
add_shortcode('outer_text_divider','wpv_shortcode_outer_text_divider');
