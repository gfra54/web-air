<?php

class WPV_Ajax {
	public function __construct() {
		foreach($this->actions as $hook=>$func) {
			add_action('wp_ajax_wpv-'.$hook, array(&$this, $func));
		}
	}
}