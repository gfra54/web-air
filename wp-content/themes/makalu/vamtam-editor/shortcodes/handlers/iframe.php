<?php

class WPV_Iframe {
	public function __construct() {
		add_shortcode('iframe', array(&$this, 'iframe'));
	}

	public function iframe($atts, $content = null) {
		extract(shortcode_atts(array(
			'width' => false,
			'height' => false,
			'src' => '',
		), $atts));
		
		$width = $width?' width="'.$width.'"':'';
		$height = $height?' height="'.$height.'"':'';
		
		return '<div class="frame-fl"><iframe src="'.$src.'"'.$width.$height.' seamless="seamless"></iframe></div>';
	}
}

new WPV_Iframe;
