<?php

function wpv_has_woocommerce() {
	return function_exists('is_woocommerce');
}

if(wpv_has_woocommerce()) {
	// we have woocommerce
	add_theme_support( 'woocommerce' );

	// replace the default pagination with WP-PageNavi
	if( function_exists('wp_pagenavi') ) {
		remove_action('woocommerce_pagination', 'woocommerce_pagination');
		function woocommerce_pagination() {
			wp_pagenavi();
		}
		add_action( 'woocommerce_pagination', 'wp_pagenavi');
	}

	// remove the WooCommerce breadcrumbs
	// we're still using their breadcrumbs, but a little higher in the HTML
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20,0 );

	// remove the WooCommerve sidebars
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/**
	 * Redefine woocommerce_output_related_products()
	 */
	function woocommerce_output_related_products() {
		woocommerce_related_products(
			array(
				'columns' => 4,
				'posts_per_page' => 4,
			)
		);
	}

	function wpv_woocommerce_product_review_comment_form_args( $comment_form ) {
		$comment_form['comment_field'] = '';

		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
				<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
				<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
				<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
				<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
				<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
				<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
			</select></p>';
		}

		$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

		return $comment_form;
	}
	add_filter( 'woocommerce_product_review_comment_form_args', 'wpv_woocommerce_product_review_comment_form_args' );
}