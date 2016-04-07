<?php

class WPV_Price {
	public function __construct() {
		add_shortcode('price', array(&$this, 'price'));
	}

	public function price($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'text_align' => 'justify',
			'price' => '',
			'currency' => '',
			'duration' => '',
			'summary' => '',
			'price_size' => '',
			'price_background' => '',
			'price_color' => '',
			'title' => '',
			'title_background' => '',
			'title_color' => '',
			'title_size' => '18',
			'description' => '',
			'description_background' => '',
			'description_color' => '',
			'button_text' => '',
			'button_link' => '',
			'featured' => 'false',
		), $atts));
		
		ob_start();

		include WPV_SHORTCODE_TEMPLATES . 'price.php';

		return ob_get_clean();
	}
}

new WPV_Price;
