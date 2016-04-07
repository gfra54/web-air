<?php

class WPV_Boxes {
	public function __construct() {
		add_shortcode('message_box', array(&$this, 'message'));
	}

	public function message($atts, $content=null, $code) {
		extract(shortcode_atts(array(
			'type' => '',
		), $atts));

		return '<div class="msgbox clearfix ' . $type . '">
					<div class="message-box-content">' . do_shortcode($content) . '</div>
				</div> ';
	}
}

new WPV_Boxes;