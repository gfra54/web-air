<?php

/**
 * icon-link widget
 */

class wpv_icon_link extends WP_Widget {
	
	private $max_custom = 30;
		
	public function wpv_icon_link() {
		$widget_ops = array(
			'classname' => 'wpv_icon_link',
			'description' => __('Displays a list of links preceded by an icon', 'wpv')
		);
		$this->WP_Widget('icon-link', __('Vamtam - Links with icons', 'wpv') , $widget_ops);
	}

	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		$custom_count = $instance['custom_count'];
		
		require WPV_WIDGETS_TPL . 'icon-link-widget.php';
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['custom_count'] = (int)$new_instance['custom_count'];
		
		for ($i=1; $i<=$instance['custom_count']; $i++) {
			$instance["custom_name"][$i] = strip_tags($new_instance["custom_name_$i"]);
			$instance["custom_url"][$i] = strip_tags($new_instance["custom_url_$i"]);
			$instance["custom_icon"][$i] = strip_tags($new_instance["custom_icon_$i"]);
		}
		return $instance;
	}
	
	public function form($instance) {
		$icons = wpv_get_icons_extended();
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$alt = isset($instance['alt']) ? esc_attr($instance['alt']) : 'Follow Us on';
		$animation = isset($instance['animation']) ? $instance['animation'] : 'fade';
		$package = isset($instance['package']) ? $instance['package'] : '';
		$enable_sites = isset($instance['enable_sites']) ? $instance['enable_sites'] : array();
		
		$custom_count = isset($instance['custom_count']) ? absint($instance['custom_count']) : 0;

		for ($i = 1;$i <= $this->max_custom; $i++) {
			$custom_names[$i] = isset($instance['custom_name'][$i]) ? $instance['custom_name'][$i] : '';
			$custom_urls[$i] = isset($instance['custom_url'][$i]) ? $instance['custom_url'][$i] : '';
			$custom_icons[$i] = isset($instance['custom_icon'][$i]) ? $instance['custom_icon'][$i] : '';
		}
		
		require WPV_WIDGETS_TPL . 'icon-link-config.php';
	}
}
register_widget('wpv_icon_link');
// exit;