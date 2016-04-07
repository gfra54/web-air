<?php

class WPV_Linkarea {
	public function __construct() {
		add_shortcode('linkarea', array(&$this, 'linkarea'));
	}

	public function linkarea($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'href' => '',
			'image' => '',
			'target' => '',
			'class' => '',
			'background_color' => '',
			'hover_color' => 'accent1',
			'hoverclass' => '',
			'activeclass' => '',
			'style' => ''
		), $atts));
		
		ob_start();

		include WPV_SHORTCODE_TEMPLATES . 'linkarea.php';

		return ob_get_clean();
	}
}

new WPV_Linkarea;
