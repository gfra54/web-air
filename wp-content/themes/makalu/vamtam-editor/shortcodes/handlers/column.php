<?php

class WPV_Columns {
	public static $in_row = 0;
	public static $last_row = -1;

	public function __construct() {
		$GLOBALS['wpv_column_stack'] = array();

		for($i=0; $i<20; $i++) {
			$suffix = ($i==0) ? '' : '_'.$i;
			add_shortcode('column'.$suffix, array(&$this, 'dispatch'));
		}
	}

	public function dispatch($atts, $content, $code) {
		extract(shortcode_atts(array(
			'width' => '1/1',
			'last' => 'false',
			'class' => '',
			'title' => '',
			'title_type' => 'single',
			'divider' => 'false',
			'nomargin' => 'false',
		), $atts));

		$GLOBALS['wpv_column_stack'][] = $width;

		$width = str_replace('/', '-', $width);
		$title = !empty($title) ? apply_filters('wpv_column_title', $title, $title_type) : '';
		$has_price = (strpos($content, '[price') !== false);

		if($nomargin == 'true' || apply_filters('wpv_nomargin_column', false, $content))
				$class .= ' nomargin';

		$last = wpv_sanitize_bool($last);
		$first = !$last;

		if($width === '1-1') {
			$first = true;
			$last = true;
		}

		$result = '';

		if($divider == 'true')
			$class .= ' border-column';

		if(self::$in_row > self::$last_row) {
			$rowclass = ($has_price) ? 'has-price' : '';

			$class .= ' first';
			$result .= '<div class="row '.$rowclass.'">';
			self::$last_row = self::$in_row;
		}

		if($last) {
			$class .= ' last';
		}

		$result .= '<div class="grid-'.$width.' '.$class.'">' . $title . $this->content($content) . '</div>';

		if($last) {
			self::$last_row--;

			$result .= '</div>';
		}

		array_pop($GLOBALS['wpv_column_stack']);

		return $result;
	}

	public function content($content) {
		self::$in_row++;
		$content = do_shortcode(trim($content));
		self::$in_row--;

		return $content;
	}
};

new WPV_Columns;
