<?php

class WPV_Slogan {
	public function __construct() {
		add_shortcode('slogan', array(&$this, 'slogan'));
	}

	public function slogan($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'button_text' => '',
			'link' => '',
			'background' => '',
			'background_image' => '',
			'background_size' => '',
			'background_attachment' => '',
			'background_position' => '',
			'background_repeat' => '',
			'button_icon' => '',
			'button_icon_color' => '',
			'button_icon_placement' => 'left',
			'boxed' => 'false',
		), $atts));

		if(!empty($background_image)) {
			$background_image = "
				background: url('$background_image') $background_repeat $background_position;
				background-size: $background_size;
			";
		}

		$boxed = ($boxed == 'false') ? 'fullwidth' : 'boxed';
		
		ob_start();

		include WPV_SHORTCODE_TEMPLATES . 'slogan.php';

		return ob_get_clean();
	}
}

new WPV_Slogan;
