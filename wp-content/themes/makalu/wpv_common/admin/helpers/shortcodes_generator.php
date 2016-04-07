<?php
include_once (WPV_ADMIN_HELPERS . 'config_generator.php');
class shortcodes_generator extends Config_Generator {
	
	public function __construct($config, $shortcode){
		$this->config = $config;
		$this->shortcode = $shortcode;
	}
	
	public function render() {
		global $post;
		
		require_once WPV_ADMIN_HELPERS . 'shortcodes/render.php';
	}
	
}