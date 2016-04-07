<?php

/**
 * social network icons widget
 */

class wpv_social extends WP_Widget {
	
	private $max_custom = 10;
		
	private $sites = array(
		'Facebook',
		'Flickr', 
		'Twitter',
		'Vimeo',
		'YouTube',
	);
	
	private $packages = array(
		'vamtam' => array(
			'name' => 'Vamtam 32px',
			'path' => 'vamtam_32/{:name}.png',
		) ,
		'vamtam_full' => array(
			'name' => 'Vamtam Full Logo',
			'path' => 'vamtam_full/{:name}.png',
		) ,
	);
	
	public function wpv_social() {
		$widget_ops = array(
			'classname' => 'wpv_social',
			'description' => __('Displays a list of Social Icon icons', 'wpv')
		);
		$this->WP_Widget('social', __('Vamtam - Social Icons', 'wpv') , $widget_ops);
	}

	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$alt = isset($instance['alt']) ? $instance['alt'] : '';
		$animation = isset($instance['animation']) ? $instance['animation'] : 'fade';
		$package = $instance['package'];
		$custom_count = $instance['custom_count'];
		
		require WPV_WIDGETS_TPL . 'social-widget.php';
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['alt'] = strip_tags($new_instance['alt']);
		$instance['package'] = strip_tags($new_instance['package']);
		$instance['animation'] = strip_tags($new_instance['animation']);
		$instance['enable_sites'] = $new_instance['enable_sites'];
		$instance['custom_count'] = (int)$new_instance['custom_count'];
		
		if (!empty($instance['enable_sites']))
			foreach ($instance['enable_sites'] as $site)
				$instance[$site] = isset($new_instance[$site]) ? strip_tags($new_instance[$site]) : '';

		for ($i=1; $i<=$instance['custom_count']; $i++) {
			$instance["custom_name"][$i] = strip_tags($new_instance["custom_name_$i"]);
			$instance["custom_url"][$i] = strip_tags($new_instance["custom_url_$i"]);
			$instance["custom_icon"][$i] = strip_tags($new_instance["custom_icon_$i"]);
		}
		return $instance;
	}
	
	public function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$alt = isset($instance['alt']) ? esc_attr($instance['alt']) : 'Follow Us on';
		$animation = isset($instance['animation']) ? $instance['animation'] : 'fade';
		$package = isset($instance['package']) ? $instance['package'] : '';
		$enable_sites = isset($instance['enable_sites']) ? $instance['enable_sites'] : array();
		
		foreach ($this->sites as $i=>$site)
			$sites[$i] = isset($instance[$site]) ? esc_attr($instance[$site]) : '';

		$custom_count = isset($instance['custom_count']) ? absint($instance['custom_count']) : 0;
		for ($i = 1;$i <= 10;$i++) {
			$custom_names[$i] = isset($instance['custom_name'][$i]) ? $instance['custom_name'][$i] : '';
			$custom_urls[$i] = isset($instance['custom_url'][$i]) ? $instance['custom_url'][$i] : '';
			$custom_icons[$i] = isset($instance['custom_icon'][$i]) ? $instance['custom_icon'][$i] : '';
		}
		
		require WPV_WIDGETS_TPL . 'social-config.php';
	}
}
register_widget('wpv_social');
