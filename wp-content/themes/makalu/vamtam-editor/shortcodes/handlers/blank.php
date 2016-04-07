<?php 

class WPV_Blank {
	public function __construct() {
		add_shortcode('blank', array(&$this, 'blank'));
		add_shortcode('push', array(&$this, 'blank'));
	}

	public function blank($atts, $content = null) {
		extract(shortcode_atts(array(
			'h' => false,
		), $atts));
		
		$style = $h? "style='height:{$h}px'" : '';
		
		return '<div class="push" '.$style.'></div>';
	}
}

new WPV_blank;
