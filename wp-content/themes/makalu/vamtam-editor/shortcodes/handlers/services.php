<?php

class WPV_Services {
	public function __construct() {
		add_shortcode('services', array(&$this, 'services'));
	}

	public function services($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'text_align' => 'justify',
			'icon' => '',
			'image' => '',
			'title' => '',
			'title_size' => '30',
			'description_size' => '12',
			'button_text' => '',
			'button_link' => '',
			'fullimage' => 'true',
			'class' => '',
		), $atts));
		
		ob_start();

		$has_more = $before = $after = false;
		$content_split = explode('[moreinfo]', $content);
		if(count($content_split) == 2) {
			$has_more = true;
			$before = $content_split[0];
			$content = $content_split[1];
		} elseif(count($content_split) >= 3) {
			$has_more = true;
			$before = array_shift($content_split);
			$content = array_shift($content_split);
			$after = implode('[divider_2]', $content_split);
		}

		include WPV_SHORTCODE_TEMPLATES . 'services.php';

		return ob_get_clean();
	}
}

new WPV_Services;
