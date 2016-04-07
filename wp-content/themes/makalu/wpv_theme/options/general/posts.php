<?php
return array(
	
array(
	'name' => __('Posts', 'wpv'),
	'type' => 'start',
	
),

array(
	'name' => __('Blog and Portfolio Listing Pages and Archives', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Pagination Type', 'wpv'),
	'desc' => __('Please note that you will need WP-PageNavi plugin installed if you chose "paged" style.', 'wpv'),
	'id' => 'pagination-type',
	'type' => 'select',
	'options' => array(
		'paged' => __('Paged', 'wpv'),
		'load-more' => __('Load more button', 'wpv'),
		'infinite-scrolling' => __('Infinite scrolling', 'wpv'),
	),
	'class' => 'slim',
),

array(
	'name' => __('Portfolio Items', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Show "Related Portfolios" in Single Portfolio View', 'wpv'),
	'desc' => __('Enabling this option will show more portfolio post from the same category in the single portfolio post.', 'wpv'),
	'id' => 'show-related-portfolios',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __('"View All Portfolios" Link', 'wpv'),
	'desc' => __('In a single portfolio post view in the top you will find navigation with 3 buttons. The middle gets you to the portfolio listing view.<br>
You can place the link here.', 'wpv'),
	'id' => 'portfolio-all-items',
	'type' => 'text',
	'static' => true,
	'class' => 'slim',
),

array(
	'name' => __('Crop Images', 'wpv'),
	'desc' => __('If you enable this option you have to set the image height in the option below.<br>
This option works for the images of the standard type blog posts in blog listing view and for portfolio and blog posts in a single portfolio/blog post view. The height of the portfolio posts images in the portfolio listing is controlled from the portfolio shortcode.', 'wpv'),
	'id' => 'portfolio-crop-featured-image',
	'type' => 'toggle',
	'class' => 'slim'
),

array(
	'name' => __('Cropped Image Height', 'wpv'),
	'desc' => __("Please note that cropping doesn't work for the video and image post formats. The height of the portfolio posts images in the portfolio listing is controlled from the portfolio shortcode.", 'wpv'),
	'id' => 'portfolio-fullimage-height',
	'type' => 'range',
	'min' => 0,
	'max' => 800,
	'unit' => 'px',
	'class' => 'slim'
),

array(
	'name' => __('Blog Posts', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('"View All Posts" Link', 'wpv'),
	'desc' => __('In a single blog post view in the top you will find navigation with 3 buttons. The middle gets you to the blog listing view.<br>
You can place the link here.', 'wpv'),
	'id' => 'post-all-items',
	'type' => 'text',
	'static' => true,
	'class' => 'slim',
),

array(
	'name' => __('Crop Images', 'wpv'),
	'desc' => __('If you enable this option you have to set the image height in the option below.<br>
This option works for the images of the standard type blog posts in blog listing view and for portfolio and blog posts in a single portfolio/blog post view. The height of the portfolio posts images in the portfolio listing is controlled from the portfolio shortcode.', 'wpv'),
	'id' => 'crop-featured-image',
	'type' => 'toggle',
	'class' => 'slim'
),

array(
	'name' => __('Cropped Image Height', 'wpv'),
	'desc' => __("Please note that cropping doesn't work for the video and image post formats. The height of the portfolio posts images in the portfolio listing is controlled from the portfolio shortcode.", 'wpv'),
	'id' => 'fullimage-height',
	'type' => 'range',
	'min' => 0,
	'max' => 800,
	'unit' => 'px',
	'class' => 'slim'
),

array(
	'name' => __('Hide Post Author', 'wpv'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'wpv'),
	'id' => 'hide-post-author',
	'type' => 'toggle',
	'class' => 'slim'
),
array(
	'name' => __('Show Categories and Tags', 'wpv'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'wpv'),
	'id' => 'meta_posted_in',
	'type' => 'toggle',
	'class' => 'slim',
),
array(
	'name' => __('Show Post Timestamp', 'wpv'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'wpv'),
	'id' => 'meta_posted_on',
	'type' => 'toggle',
	'class' => 'slim',
),
array(
	'name' => __('Show Comment Count', 'wpv'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'wpv'),
	'id' => 'meta_comment_count',
	'type' => 'toggle',
	'class' => 'slim',
),
	array(
		'type' => 'end'
	),
);