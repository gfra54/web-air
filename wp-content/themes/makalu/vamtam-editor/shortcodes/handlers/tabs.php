<?php

class WPV_Tabs {
	public function __construct() {
		add_shortcode('tabs', array(&$this, 'tabs'));
	}

	public function tabs($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'delay' => '0',
			'vertical' => 'false'
		), $atts));


		if (!wpv_sub_shortcode('tab', $content, $params, $sub_contents))
			return 'error parsing slider shortcode';

		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('front-jquery.ui.tabs.rotate');
			
		global $tabs_shown;
		if($tabs_shown) {
			$tabs_shown++;
		} else {
			$tabs_shown = 1;
		}
		
		if($vertical == 'true') {
			$vertical = 'vertical';
		} else {
			$vertival = '';
		}
		
		$id = 'tabs-'.$tabs_shown.rand(0,10000);

		$output = '<ul class="ui-tabs-nav">';
		foreach($params as $i=>$p) {
			$class = isset($p['class']) ? " class='tab-{$p['class']}'" : '';
			$output .= '<li'.$class.'><a href="#'.$id.$i.'">' . $p['title'] . '</a></li>';
		}
		$output .= '</ul>';
		
		foreach($sub_contents as $i=>$c) {
			$class = isset($params[$i]['class']) ? ' tab-'.$params[$i]['class'] : '';
			$class .= ' ui-tabs-hide';
			$output .= '<div class="pane'.$class.'" id="'.$id.$i.'">' . do_shortcode(trim($c)) . '</div>';
		}
			
		return '<div class="wpv-tabs '.$vertical.'" data-delay="'.$delay.'">' . $output . '</div>';
	}
}

new WPV_Tabs;
