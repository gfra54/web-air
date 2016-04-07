<?php

/*
 * sets the columns when viewing slideshows in wp-admin
 */

function edit_slideshow_columns($slideshow_columns) {
	$columns = array(
		"cb" => '<input type="checkbox" />',
		"title" => _x('Excerpt', 'column name', 'wpv' ),
		"slideshow_category" => __('Categories', 'wpv' ),
		"author" => __('Author', 'wpv' ),
		"date" => __('Date', 'wpv' ),
		"thumbnail" => __('Thumbnail', 'wpv' )
	);

	return $columns;
}
add_filter('manage_edit-slideshow_columns', 'edit_slideshow_columns');

function manage_slideshow_columns($column) {
	global $post;
	
	if ($post->post_type == "slideshow") {
		switch($column) {
			
			case 'thumbnail':
				echo the_post_thumbnail('thumbnail');
			break;
			
			case "slideshow_category":
				
				$terms = get_the_terms($post->ID, 'slideshow_category');				
				if ( !empty($terms) ) {
					foreach($terms as $t)
						$output[] = "<a href='edit.php?post_type=slideshow&slideshow_category={$t->slug}'> " . esc_html(sanitize_term_field('name', $t->name, $t->term_id, 'slideshow_category', 'display')) . "</a>";
					$output = implode(', ', $output);
				} else {
					$t = get_taxonomy('slideshow_category');
					$output = "---";
				}
				
				echo $output;
			break;
		}
	}
}
add_action('manage_posts_custom_column', 'manage_slideshow_columns', 10, 2);
