<?php

/**
 * displays blog posts in a page/post
 */

class WPV_Blog {
	public function __construct() {
		add_shortcode('blog', array(&$this, 'blog'));
	}

	public function blog($atts, $content = null, $code) {
		global $wp_filter;
		
		$the_content_filter_backup = $wp_filter['the_content'];
		extract(shortcode_atts(array(
			'count' => 3,
			'column' => 1,
			'cat' => '',
			'posts' => '',
			'image' => 'false',
			'show_content' => 'false',
			'nopaging' => 'true',
			'paged' => '',
			'img_style' => 'full',
			'width' => 'full',
			'news' => 'false',
			'image_height' => 400,
		), $atts));
		
		$query = array(
			'posts_per_page' => (int)$count,
			'post_type'=>'post',
		);
		
		if($paged)
			$query['paged'] = $paged;
			
		if($cat)
			$query['cat'] = $cat;
			
		if($posts)
			$query['post__in'] = explode(',',$posts);

		if ($nopaging == 'false') {
			$query['paged'] = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
		}
			
		$called_from_shortcode = true;

		$column = (int)$column;
		if($column > 1) {
			$denominator = array('','', 'half', 'third', 'fourth', 'fifth', 'sixth');	
			
			$width = 'one_'.$denominator[$column];
		}

		// this is necessary so that we can use the same code for single and looped thumbnails
		$GLOBALS['wpv_blog_image_height'] = $image_height;
		
		ob_start();
		query_posts($query);
		
		include locate_template(array('loop.php'));
		
		$output = ob_get_contents();
		ob_end_clean();

		wp_reset_query();
		wp_reset_postdata();
		$wp_filter['the_content'] = $the_content_filter_backup;

		unset($GLOBALS['wpv_blog_image_height']);
		return $output;
	}
}

new WPV_Blog;
