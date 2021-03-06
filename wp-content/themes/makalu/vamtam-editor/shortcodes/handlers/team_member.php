<?php

class WPV_Team_Member {
	public function __construct() {
		add_shortcode('team_member', array(&$this, 'team_member'));
	}

	public function team_member($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'name' => '',
			'position' => '',
			'phone' => '',
			'email' => '',
			'picture' => '',
			'url' => '',
			'googleplus' => '',
			'facebook' => '',
			'twitter' => '',
			'linkedin' => '',
			'youtube' => '',
		), $atts));
		
		ob_start();

		include WPV_SHORTCODE_TEMPLATES . 'team_member.php';

		return ob_get_clean();
	}
}

new WPV_Team_Member;
