<?php

class WPV_Accordion {
	public function __construct() {
		add_shortcode('accordion', array(&$this, 'accordion'));
	}

	public function accordion($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'mini' => 'true',
			'collapsible' => 'false',
		), $atts));
		
		if (!wpv_sub_shortcode('pane', $content, $params, $sub_contents))
			return do_shortcode($content);

		wp_enqueue_script('jquery-ui-accordion');

		$title_tag = apply_filters('wpv_accordion_title_tag', 'h4');

		$output = '';
		foreach($sub_contents as $i=>$sc) {
			$output .= '<'.$title_tag.' class="tab"><div class="inner">' . $params[$i]['title'] . '</div></'.$title_tag.'>'
					. '<div class="pane"><div class="inner">' . do_shortcode(trim($sc)) . '</div></div>';
		}

		return '<div class="accordion" data-collapsible="'.$collapsible.'">' . $output . '</div>';
	}
}

new WPV_Accordion;
