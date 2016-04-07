<?php

class wpv_contactinfo extends WP_Widget {
	private $fields = array();
	
	function wpv_contactinfo() {
		$widget_ops = array(
			'classname' => 'wpv_contactinfo',
			'description' => __('Display contact information.', 'wpv')
		);
		$this->WP_Widget('wpv_contactinfo', __('Vamtam - Contact Info', 'wpv') , $widget_ops);
		
		$this->fields = array(
			'title' => array('description' => __('Title:', 'wpv')),
			'name' => array('description' => __('Name:', 'wpv')),
			'text' => array('description' => __('Introduction text:', 'wpv')),
			'phone' => array('description' => __('Phone:', 'wpv')),
			'cellphone' => array('description' => __('Cell phone:', 'wpv')),
			'mail' => array('description' => __('Email:', 'wpv')),
			'address' => array('description' => __('Address:', 'wpv')),
		);
	}
	
	public function widget($args, $instance) {
		extract($args);
		foreach($this->fields as $name=>&$field)
			$field['value'] = isset($instance[$name]) ? $instance[$name] : '';
		unset($field);
		
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		$color = $instance['color'];
		
		require WPV_WIDGETS_TPL . 'contactinfo-widget.php';
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		foreach($this->fields as $name=>$field)
			$instance[$name] = strip_tags($new_instance[$name]);
		
		$instance['color'] = $new_instance['color'];
		
		return $instance;
	}
	
	public function form($instance) {
		foreach($this->fields as $name=>&$field)
			$field['value'] = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
		unset($field);
		
		$color = $instance['color'];
		
		require WPV_WIDGETS_TPL . 'contactinfo-config.php';
	}
}
register_widget('wpv_contactinfo');
