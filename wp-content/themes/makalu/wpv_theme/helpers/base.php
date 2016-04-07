<?php
define('WPV_RESPONSIVE', wpv_get_optionb('is-responsive'));
define('WPV_MAX_WIDTH', 940);  // the max content width the css is built for
							   // should equal the actual content width,
							   // for example, the width of the text of a page without sidebars

global $wpv_hsidebars_widths, $wpv_slider_shortcode_styles, $content_width;

if( ! isset( $content_width ) ) $content_width = WPV_MAX_WIDTH;

include 'shortcode-support.php';

add_theme_support('wpv-reduced-ajax-single-response');
add_theme_support('wpv-ajax-siblings');
add_theme_support('wpv-simple-grid');
add_theme_support('wpv-page-title-style');
add_theme_support('wpv-vamtam-slider-shortcode');
add_theme_support('wpv-sintia-slider');
add_theme_support('wpv-enabled-widgets',
	'authors',
	'advertisement',
	'flickr',
	'icon-link',
	'subpages',
	'contactinfo',
	'gmap',
	'posts',
	'post-formats'
);

$wpv_hsidebars_widths = array(
	'full' => 'Full',
	'cell-1-2' => '1/2',
	'cell-1-3' => '1/3',
	'cell-1-4' => '1/4',
	'cell-1-5' => '1/5',
	'cell-1-6' => '1/6',
	'cell-2-3' => '2/3',
	'cell-3-4' => '3/4',
	'cell-2-5' => '2/5',
	'cell-3-5' => '3/5',
	'cell-4-5' => '4/5',
	'cell-5-6' => '5/6',
);

$wpv_slider_shortcode_styles = array(
	'1' => __('Style 1', 'wpv') ,
	'2' => __('Style 2', 'wpv') ,
);

function klt_sidebar_class($class, $layout_type) {
	if($layout_type == 'left-only' || $layout_type == 'right-only') {
		$class .= ' single';
	} elseif ($layout_type == 'left-right') {
		$class .= ' double';
	}

	return $class;
}
add_filter('wpv_left_sidebar_class', 'klt_sidebar_class', 10, 2);
add_filter('wpv_right_sidebar_class', 'klt_sidebar_class', 10, 2);

function theme_posts_widget_img_size($img_size, $args) {
	if(strpos($args['id'], 'footer-sidebar') !== false)
		return 43;

	return 350;
}
add_filter('wpv_posts_widget_img_size', 'theme_posts_widget_img_size', 10, 2);


function theme_posts_widget_thumbnail_name($img_size, $args) {
	if(strpos($args['id'], 'footer-sidebar') !== false)
		return 'posts-widget-thumb-small';

	return 'posts-widget-thumb';
}
add_filter('wpv_posts_widget_thumbnail_name', 'theme_posts_widget_thumbnail_name', 10, 2);

function theme_lmbtn_class($class) {
	return $class.' button full clearboth';
}
add_filter('wpv_lmbtn_class', 'theme_lmbtn_class');

function theme_get_slider_design($animation) {
	$groups = array(
		'fade' => 'navigation-preview',
		'fadeMultipleCaptions' => 'navigation-preview',
		'slide' => 'navigation-preview',
		'slideMultipleCaptions' => 'navigation-preview',
		'zoomIn' => 'caption-center',
		'apple' => 'apple',
		'modern' => 'modern',
		'sintia' => 'sintia',
	);
	
	if(isset($groups[$animation]))
		return $groups[$animation];

	return '';
}

function theme_excerpt_length($length) {
	global $wpv_loop_vars;

	if(isset($wpv_loop_vars) && isset($wpv_loop_vars['news']) && $wpv_loop_vars['news'] == 'true') {
		return 15;
	}

	return $length;
}
add_filter('excerpt_length', 'theme_excerpt_length');

function theme_has_header_slider() {
	return !is_404() && wpv_post_default('show_header_slider', 'has-header-slider');
}

function theme_multiwidget_item_title_tag($tag) {
	return 'h5';
}
add_filter('wpv_multiwidget_item_title_tag', 'theme_multiwidget_item_title_tag');

function theme_multiwidget_item_meta_tag($tag) {
	return 'h6';
}
add_filter('wpv_multiwidget_item_meta_tag', 'theme_multiwidget_item_meta_tag');

function theme_image_average_color($file, $granularity = 5) {
	$key = md5($file);

	if(false === ($result = get_transient('wpv_ac'.$key))) {
		$granularity = max(1, abs((int)$granularity)); 
		$size = @getimagesize($file); 
		if($size === false) 
			return false;

		$img = @imagecreatefromstring(file_get_contents($file));

		if(!$img)
			return $false;

		$r = $g = $b = $cnt = 0;

		for($x = 0; $x < $size[0]; $x += $granularity) {
			for($y = 0; $y < $size[1]; $y += $granularity) { 
				$cnt++;
				$color = imagecolorat($img, $x, $y);
				$r += ($rgb >> 16) & 0xFF;
				$g += ($rgb >> 8) & 0xFF;
				$b += $rgb & 0xFF;
			}
		}

		$result = array(round($r/$cnt), round($g/$cnt), round($b/$cnt));

		set_transtient('wpv_ac'.$key, $result, 7*24*3600);
	}
	
	return $result; 
}

function theme_version_check() {
	$last_version = (int)wpv_get_option('theme_installed_version');
	
	if(empty($last_version))
		$last_version = 1;

	if($last_version < (int)THEME_VERSION) {
		theme_prepare_update($last_version + 1);
		wpv_update_option('theme_installed_version', (int)THEME_VERSION);
	}
}
add_action('admin_init', 'theme_version_check');

function theme_prepare_update($at) {
}

function theme_map_slide_data($meta) {
	return is_array($meta) ? $meta[0] : $meta;
}

function theme_get_post_format_icon($format) {
	$formats = array(
		'aside' => 'notebook',
		'audio' => 'theme-audio',
		'video' => 'theme-video',
		'quote' => 'theme-quote',
		'standard' => 'theme-pencil',
		'gallery' => 'theme-gallery',
		'image' => 'theme-camera',
		'link' => 'link',
	);

	if(isset($formats[$format]))
		return $formats[$format];

	return 'theme-pencil';
}

function theme_post_fullimage_width($width) {
	if(!is_single())
		return ceil($width*0.7);

	return $width;
}
add_filter('wpv_post_fullimage_width', 'theme_post_fullimage_width');

function theme_background_styles() {
	global $post;

	if(is_object($post) && get_post_meta($post->ID, 'use-global-options', true) === 'false') {
		$bgcolor = get_post_meta($post->ID, 'background-color', true);
		$bgimage = get_post_meta($post->ID, 'background-image', true);
		$bgrepeat = get_post_meta($post->ID, 'background-repeat', true);
		$bgattachment = get_post_meta($post->ID, 'background-attachment', true);
		$bgposition = get_post_meta($post->ID, 'background-position', true);
		$bgsize = get_post_meta($post->ID, 'background-size', true);
		
		$page_style = '';
		if(!empty($bgcolor))
			$page_style .= "background-color:$bgcolor;";
		if(!empty($bgimage)) {
			$page_style .= "background-image:url('$bgimage');";
			if(!empty($bgrepeat))
				$page_style .= "background-repeat:$bgrepeat;";
			if(!empty($bgattachment))
				$page_style .= "background-attachment:$bgattachment;";
			if(!empty($bgsize))
				$page_style .= "background-size:$bgsize;";
		}
		
		if(!empty($page_style) && (is_single() || is_page())) {
			echo "<style>html{ $page_style }</style>";
		} 
	}
}
add_action('wp_head', 'theme_background_styles');

function theme_body_classes($body_class) {
	global $wpv_has_header_sidebars, $post;
	
	$has_header_slider = theme_has_header_slider();
	$wpv_has_header_sidebars = wpv_post_default('show_header_sidebars', 'has-header-sidebars');
	$has_page_header = is_singular(array('post', 'portfolio')) || (is_page() && wpv_post_default('show_page_header', 'has-page-header') || is_category() || is_archive() || is_search() || is_home());

	$fancy_portfolio_cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();
	$fancy_portfolio_type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'background';
	$full_bg_slider = !empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'background';
	
	$has_sortable_portfolio = is_object($post) && 
	                          preg_match('/\[portfolio[^\]]+sortable="true"/i', trim($post->post_content), $pmatches, PREG_OFFSET_CAPTURE) &&
	                          $pmatches[0][1] === 0;

	$body_class[] = $full_bg_slider ? 'full' : wpv_get_option('site-layout-type');
	$body_class[] = 'pagination-'.wpv_get_option('pagination-type');
	
	$body_class_conditions = array(
		'no-page-header' => !$has_page_header,
		'has-page-header' => $has_page_header, 
		'cbox-share-twitter' => wpv_get_optionb('share-lightbox-twitter'),
		'cbox-share-facebook' => wpv_get_optionb('share-lightbox-facebook'),
		'cbox-share-gplus' => wpv_get_optionb('share-lightbox-gplus'),
		'cbox-share-pinterest' => wpv_get_optionb('share-lightbox-pinterest'),
		'fixed-header' => wpv_get_optionb('fixed-header'),
		'has-header-slider' => $has_header_slider,
		'has-header-sidebars' => $wpv_has_header_sidebars,
		'no-header-slider' => !$has_header_slider,
		'no-header-sidebars' => !$wpv_has_header_sidebars,
		'no-footer-sidebars' => !wpv_get_optionb('has-footer-sidebars'),
		'responsive-layout' => WPV_RESPONSIVE,
		'fixed-layout' => WPV_RESPONSIVE,
		'full-bg-slider' => $full_bg_slider,
		'fast-slider' => $full_bg_slider,
		'has-ajax-portfolio' => !empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'page',
		'has-portfolio-listing' => $has_sortable_portfolio,
		'has-breadcrumbs' => wpv_get_optionb('enable-breadcrumbs'),
		'no-breadcrumbs' => !wpv_get_optionb('enable-breadcrumbs'),
		'no-slider-button-thumbnails' => !wpv_get_optionb('header-slider-button-thumbnails'),
	);
	
	foreach($body_class_conditions as $class=>$cond) {
		if($cond) {
			$body_class[] = $class;
		}
	}

	if(is_archive() || is_search() || get_query_var('format_filter'))
		define('WPV_ARCHIVE_TEMPLATE', true);

	return $body_class;
}
add_filter('body_class', 'theme_body_classes');