<?php


class WPV_Portfolio {
	public function __construct() {
		add_shortcode('portfolio', array(&$this, 'portfolio'));
	}

	public function portfolio($atts, $content = null, $code) {
		global $wp_filter, $post;
		$the_content_filter_backup = $wp_filter['the_content'];
		extract(shortcode_atts(array(
			'column' => 4,
			'cat' => '',
			'ids' => '',
			'max' => 8,
			'height' => 400,
			'title' => 'true',
			'desc' => 'true',
			'more' => '',
			'nopaging' => 'false',
			'sortable' => 'false',
			'group' => 'true',
			'long' => 'false',
			'layout' => '',
			'scrollable' => 'false',
			'post__not_in' => '',
			'engine' => 'isotope',
		), $atts));

		$moreText = $more;
		$more = !empty($moreText);

		// number of columns - get the css class
		$column = intval($column);
		$column_class = array('one_column', 'two_columns', 'three_columns', 'four_columns');
		$column_class = $column_class[$column-1];

		// get the overall portfolio width
		$central_width = wpv_get_central_column_width();

		$column_width = intval($central_width / $column);
		$size = array($central_width, $height);

		// set the width of a column (without blank space)
		if($column > 1)
			$size[0] = round( ($central_width * (1-0.02 * ($column-1))) /$column);

		$paging_preference = ($sortable == 'true') ? 'paged' : null;

		$rel_group = 'portfolio_'.rand(1,1000); //for lightbox group


		if($sortable == 'true' && $engine == 'isotope')
			wp_enqueue_script('front-jquery.isotope.min');

		$query = array(
			'post_type' => 'portfolio',
			'orderby' => array(
				'menu_order' => 'ASC',
				'date' => 'DESC',
			),
			'posts_per_page' => $max,
		);

		if(!empty($cat)) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => explode(',', $cat),
				)
			);
		}

		if ($nopaging == 'false') {
			$query['paged'] = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
		} else {
			$query['paged'] = 1;
		}

		if($ids && $ids != 'null')
			$query['post__in'] = explode(',',$ids);


		if(!empty($post__not_in))
			$query['post__not_in'] = explode(',',$post__not_in);

		query_posts($query);

		global $wp_query;

		if((have_posts() ? count($wp_query->posts) : 0) === 0)
			$scrollable = 'false';

		ob_start();

		include WPV_SHORTCODE_TEMPLATES . 'portfolio.php';

		$wp_filter['the_content'] = $the_content_filter_backup;

		return ob_get_clean();
	}
}

new WPV_Portfolio;
