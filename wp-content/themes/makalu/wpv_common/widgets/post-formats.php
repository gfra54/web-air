<?php

class WPV_Widget_Post_Formats extends WP_Widget {

	function __construct() {
		$widget_ops = array( 
			'classname' => 'widget_post_formats',
			'description' => __('A list or dropdown of Post Formats', 'wpv')
		);
		$this->WP_Widget('WPV-post-formats', __('Vamtam - Post Formats', 'wpv'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Post Formats', 'wpv') : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		
		include 'tpl/post-formats-widget.php';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['tooltip'] = strip_tags($new_instance['tooltip']);

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = !empty($instance['title']) ? esc_attr( $instance['title'] ) : 'Post Formats';
		$tooltip = !empty($instance['tooltip']) ? esc_attr( $instance['tooltip'] ) : 'View all %format posts';
		
		include 'tpl/post-formats-config.php';
	}

}
register_widget('WPV_Widget_Post_Formats');
