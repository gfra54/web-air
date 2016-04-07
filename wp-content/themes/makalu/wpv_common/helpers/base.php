<?php

global $wpv_slider_effects, $wpv_shortcode_slider_effects;

$wpv_slider_effects = apply_filters('wpv_slider_effects', array(
	'fade' => 'fade',
	'slide' => 'slide',
	'zoomIn' => 'zoom in',
	'makalu' => __('Makalu', 'wpv'),
	'layerslider' => __('LayerSlider', 'wpv'),
));

$wpv_shortcode_slider_effects = apply_filters('wpv_shortcode_slider_effects', array(
	'fade' => 'fade',
	'slide' => 'slide',
));

function wpv_icon_type($icon) {
	echo wpv_get_icon_type($icon);
}

function wpv_get_icon_type($icon) {
	if(strpos($icon, 'theme-') === 0)
		return 'theme';

	return '';
}

function wpv_icon($key) {
	echo wpv_get_icon($key);
}

function wpv_get_icon($key) {
	$icons = wpv_get_icon_list();
	$theme_icons = wpv_get_theme_icon_list();

	if(isset($icons[$key]))
		return wpv_mb_chr($icons[$key]);

	$theme_key = preg_replace('/^theme-/', '', $key, 1);
	if(isset($theme_icons[$theme_key]))
		return wpv_mb_chr($theme_icons[$theme_key]);

	return $key;
}

function wpv_get_icon_list() {
	return include(WPV_ASSETS_DIR . 'fonts/icons/list.php');
}

function wpv_get_theme_icon_list() {
	return include(WPV_THEME_ASSETS_DIR . 'fonts/icons/list.php');
}

function wpv_get_icons_extended() {
	$result = array();
	$icons = wpv_get_icon_list();
	$theme_icons = wpv_get_theme_icon_list();
	ksort($icons);
	ksort($theme_icons);

	foreach($icons as $key=>$num) {
		$result[$key] = $key;
	}

	foreach($theme_icons as $key=>$num) {
		$result['theme-'.$key] = 'theme-'.$key;
	}

	return $result;
}

// same as chr() but for unicode
function wpv_mb_chr($char) {
	if ($char < 128)
		return chr($char);
	if ($char < 2048)
		return chr(($char >> 6) + 192) . chr(($char & 63) + 128);

	if ($char < 65536)
		return chr(($char >> 12) + 224) . chr((($char >> 6) & 63) + 128) . chr(($char & 63) + 128);

	if ($char < 2097152)
		return chr(($char >> 18) + 240) . chr((($char >> 12) & 63) + 128) . chr((($char >> 6) & 63) + 128) . chr(($char & 63) + 128);

	return '';
}

/**
 * gets either a post meta value or a blog option
 *
 * $prefer_default - boolean - if this is true and $local is empty(), then return $default
 */

function wpv_post_default($meta, $default, $default_is_value = false, $prefer_default = false, $post_id = null) {
	if(is_null($post_id)) {
		global $post;

		$post_id = (wpv_has_woocommerce() && is_woocommerce() && !is_singular(array('page', 'product'))) ? woocommerce_get_page_id( 'shop' ) : (isset($post) ? $post->ID : null);
	}

	// if the meta key is not set - $prefer_default should be true
	$has_post_meta = get_post_meta($post_id, $meta);
	$has_post_meta = !empty($has_post_meta);
	$prefer_default = $prefer_default || !$has_post_meta;

	if(!$default_is_value)
		$default = wpv_sanitize_bool(wpv_get_option($default));

	if(is_null($post_id))
		return apply_filters('wpv_post_default_'.$meta, false);

	$local = wpv_sanitize_bool(get_post_meta($post_id, $meta, true));

	if($prefer_default && empty($local))
		$local = $default;

	return apply_filters('wpv_post_default_'.$meta, (
		((!is_singular(array('post', 'page', 'portfolio', 'slideshow', 'product')) && (!wpv_has_woocommerce() || !is_woocommerce())) ||
			(wpv_sanitize_bool(get_post_meta($post_id, 'use-global-options', true)) === true)) ? $default : $local));
}

function wpv_sanitize_bool($value) {
	if($value === '1' || $value === 'true') {
		$value = true;
	} else if($value === '0' || $value === 'false') {
		$value = false;
	}
	return $value;
}

/**
 * slider width
 */

function wpv_get_slider_width() {
	$width = (int)wpv_get_option('content-width');

	return $width;
}

function wpv_slider_width() {
	echo wpv_get_slider_width();
}

/**
 * helper function - returns second argument when the first is empty, otherwise returns the first
 */

function wpv_default($value, $default) {
	if(empty($value))
		return $default;
	return $value;
}

/*
 * checks if current page is the blog page set in Settings->Reading
 */

function is_blog() {
	global $post;

	return $post->ID == get_option('page_for_posts');
}

/*
 * gets the width in px of the central column depending on current post settings
 */

if(!function_exists('wpv_get_central_column_width')):
function wpv_get_central_column_width() {
	global $post;

	if(defined('WPV_LAYOUT')) {
		$layout_type = WPV_LAYOUT;
	} else if(is_single()){
		$layout_type = get_post_meta($post->ID, 'layout-type', 'left-only');
	} else {
		$layout_type = 'full';
	}

	$central_width = WPV_MAX_WIDTH;
	$left_sidebar = (int)wpv_get_option('left-sidebar-width');
	$right_sidebar = (int)wpv_get_option('right-sidebar-width');
	switch($layout_type) {
		case 'left-only':
		case 'left-sidebar':
			$central_width = floor((100-$left_sidebar)/100*$central_width);
		break;

		case 'right-only':
		case 'right-sidebar':
			$central_width = floor((100-$right_sidebar)/100*$central_width);
		break;

		case 'left-right':
		case 'two-sidebars':
			$central_width = floor((100-$left_sidebar-$right_sidebar)/100*$central_width);
		break;
	}

	$column = array(1,1);

	if(isset($GLOBALS['wpv_column_stack']) && is_array($GLOBALS['wpv_column_stack'])) {
		foreach($GLOBALS['wpv_column_stack'] as $c) {
			$c = explode('/', $c);
			$column[0] *= $c[0];
			$column[1] *= $c[1];
		}
	}

	$column = $column[0]/$column[1];

	return round($central_width * $column);
}
endif;

// turns a string as four_fifths to a value in pixels, works only for the central column
if(!function_exists('wpv_str_to_width')):
function wpv_str_to_width($frac = 'full') {
	$width = wpv_get_central_column_width();
	if($frac != 'full') {
		$frac = explode('_', $frac);
		$map = array(
			'one' => 1,
			'two' => 2,
			'half' => 2,
			'three' => 3,
			'third' => 3,
			'thirds' => 3,
			'four' => 4,
			'fourth' => 4,
			'fourths' => 4,
			'five' => 5,
			'fifth' => 5,
			'fifths' => 5,
			'six' => 6,
			'sixth' => 6,
			'sixths' => 6,
		);

		$frac[0] = $map[$frac[0]];
		$frac[1] = $map[$frac[1]];

		$width = ($width - ($frac[1]-1)*20)/$frac[1]*$frac[0] + ($frac[0]-1)*20;
	}

	return $width;
}
endif;

/*
 * gets the correct post template depending on the post format
 */

if(!function_exists('wpv_post_template')):
function wpv_post_template($post_formats = null) {
	global $wpv_post_formats;
	if(is_null($post_formats)) {
		$post_formats = $wpv_post_formats;
	}

	$standard_post_format = true;
	foreach($post_formats as $post_format) {
		if(has_post_format($post_format)) {
			$standard_post_format = false;
			get_template_part('single', $post_format);
		}
	}

	if($standard_post_format) {
		get_template_part('single', 'standard');
	}
}
endif;

/*
 * gets basic post settings
 */

if(!function_exists('wpv_post_info')):
function wpv_post_info() {
	global $wpv_loop_vars, $post;

	$result = array();

	if(is_array($wpv_loop_vars)) {
		extract($wpv_loop_vars);
		$result['show_image'] = ($image == 'true');
		$result['img_style'] = $img_style;
		$result['show_content'] = ($show_content == 'true');
		$result['width'] = $width;
		$result['news'] = $news;
		$result['column'] = $column;
	} else {
		$result['img_style'] = wpv_post_default('img_style', 'single-featured-image-position');
		$result['show_image'] = true;
		$result['show_content'] = true;
		$result['width'] = 'full';
		$result['news'] = 'false';
		$result['column'] = 1;
	}

	return $result;
}
endif;

/*
 * echoes the post video for the video post type
 */

if(!function_exists('wpv_post_video')):
function wpv_post_video($width, $height = null, $link = null) {
	global $post;

	if(!isset($link)) {
		$link = get_post_meta($post->ID, 'post-link', true);
	}
	$type = 'html5';

	if(isset($height)) {
		$height = 'height="'.$height.'"';
	}

	echo do_shortcode('[video type="" src="'.$link.'" width="'.$width.'" '.$height.']');
}
endif;

// lazy load images
if(!function_exists('wpv_lazy_load')):
function wpv_lazy_load($url, $alt='', $atts = array()) {
	echo wpv_get_lazy_load($url, $alt, $atts);
}

function wpv_get_lazy_load($url, $alt='', $atts = array()) {
	$disabled = true; //wpv_get_option('disable-lazy-load');
	$atts['class'] = isset($atts['class']) ? explode(' ', $atts['class']) : array();

	if(!$disabled) {
		$atts['class'][] = 'lazy';

		if(isset($atts['height']) && (int)$atts['height'] < 40 &&
		   isset($atts['width']) && (int)$atts['width'] < 40)
			$atts['class'][] = 'no-animation';
	}

	if(isset($atts['height']) && empty($atts['height'])) {
		unset($atts['height']);
	}

	if(isset($atts['width']) && empty($atts['width'])) {
		unset($atts['width']);
	}

	$atts['class'] = implode(' ', $atts['class']);

	$extended_atts = array();
	foreach($atts as $att=>$val) {
		$extended_atts[] = "$att='$val'";
	}
	$atts = implode(' ', $extended_atts);

	ob_start();
?>
	<img src="<?php echo $url?>" alt="<?php echo $alt?>" <?php echo $atts?> />
<?php
	$clean = ob_get_clean();

	ob_start();
?>
	<img src="<?php echo WPV_IMAGES ?>blank.gif" alt="<?php echo $alt?>" data-href="<?php echo $url?>" <?php echo $atts?> />
	<noscript><?php echo $clean ?></noscript>
<?php
	$lazy = ob_get_clean();
	return $disabled ? $clean : $lazy;
}
endif;

// Remove empty paragraph tags from the_content
function wpv_remove_empty_p($content) {
    return preg_replace("/<p[^>]*>\s*<\\/p[^>]*>/", '', $content);
}
add_filter('the_content', 'wpv_remove_empty_p', 100000);

function wpv_get_portfolio_options($group, $rel_group) {
	$res = array();

	$res['image'] = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'full', true);

	$res['type'] = wpv_default(get_post_meta(get_the_id(), 'portfolio_type', true), 'image');

	$res['width'] = '';
	$res['height'] = '';
	$res['iframe'] = '';
	$res['link_target'] = '_self';

	// calculate some options depending on the portfolio item's type
	if($res['type'] == 'image' || $res['type'] == 'html') {
		$res['href'] =  $res['image'][0];
		$res['lightbox'] = ' lightbox';
		$res['rel'] = ($group == 'true')? ' rel="'.$rel_group.'"' : '';

	} elseif($res['type'] == 'video') {
		$res['href'] = get_post_meta(get_the_id(), 'portfolio_data_url', true);
		if(empty($res['href'])) {
			$res['href'] = $res['image'][0];
		}

		$res['video_width'] = 800;
		$res['video_height'] = 450;

		$res['width'] = ' data-width="'.$res['video_width'].'"';
		$res['height'] = ' data-height="'.$res['video_height'].'"';
		$res['iframe'] = ' data-iframe="true"';

		$res['lightbox'] = ' lightbox';
		$res['rel'] = ($group == 'true')? ' rel="'.$rel_group.'"' : '';

	} elseif($res['type'] == 'link') {
		$res['href'] = get_post_meta(get_the_ID(), 'portfolio_data_url', true);

		$res['link_target'] = get_post_meta(get_the_ID(), '_link_target', true);
		$res['link_target'] = $res['link_target'] ? $res['link_target'] : '_self';

		$res['lightbox'] = ' no-lightbox';
		$res['rel'] = '';

	} elseif($res['type'] == 'gallery') {
		$res['image_ids'] = array_keys(get_children(get_the_ID()));
		$res['rel'] = ($group == 'true')? ' rel="'.$rel_group.'"' : '';

		if(!empty($res['image_ids'])) {
			$res['rel'] = 'rel="gallery-'.get_the_ID().'"';
			$res['href'] = $res['image'][0];
		}

		$res['lightbox'] = ' lightbox';

	} elseif($res['type'] == 'document') {
		if(is_single()) {
			$res['href'] = $res['image'][0];
			$res['lightbox'] = ' lightbox';
		} else {
			$res['href'] = get_permalink();
			$res['lightbox'] = ' no-lightbox';
		}
		$res['rel'] = '';
	}

	return $res;
}

/* standard post format filter */
function wpv_format_filter_query_var() {
    global $wp;
    $wp->add_query_var('format_filter');
}
add_filter('init', 'wpv_format_filter_query_var');

function wpv_format_filter_rewrite_rule() {
    add_rewrite_rule('format_filter/(\w+)$', 'index.php?format_filter=$matches[1]', 'top');
}

add_action('init','wpv_format_filter_rewrite_rule');

add_filter('body_class', 'wpv_format_filter_body_class');
function wpv_format_filter_body_class($classes) {
	if(get_query_var('format_filter'))
		$classes[] = 'archive';
	return $classes;
}

function wpv_format_filter_query() {
	$format = get_query_var('format_filter');

	if($format) {
		global $wpv_post_formats;

		$post_formats_longname = array();

		$query = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
				)
			),
			'paged' => get_query_var('paged') ? get_query_var('paged') :
						(get_query_var('page') ? get_query_var('page') : 1),
			'format_filter' => $format,
		);

		if($format == 'standard') {
			foreach($wpv_post_formats as $f) {
				$post_formats_longname[] = 'post-format-'.$f;
			}

			$query['tax_query'][0]['terms'] = $post_formats_longname;
			$query['tax_query'][0]['operator'] = 'NOT IN';
		} else {
			$query['tax_query'][0]['terms'] = array('post-format-'.$format);
			$query['tax_query'][0]['operator'] = 'IN';
		}

		query_posts($query);
		unset($GLOBALS['wp_the_query']);
		$GLOBALS['wp_the_query'] =& $GLOBALS['wp_query'];

		if(count($GLOBALS['wp_query']->posts) == 0) {
			$GLOBALS['wp_query']->set_404();
			header("HTTP/1.0 404 Not Found");
		}
	}

	return;
}
add_action('wp', 'wpv_format_filter_query');

function wpv_static($option) {
	if(isset($option['static']) && $option['static']) {
		echo 'static';
	}
}

function wpv_custom_js() {
	$custom_js = wpv_get_option('custom_js');

	if(!empty($custom_js)):
?>
	<script>/*<![CDATA[*/<?php echo $custom_js; ?>/*]]>*/</script>
<?php
	endif;
}
add_action('wp_footer', 'wpv_custom_js', 10000);

function wpv_ga_script() {
	$an_key = wpv_get_option('analytics_key');
	if($an_key):
?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo $an_key?>', 'auto');
		ga('require', 'displayfeatures');
		ga('send', 'pageview');
	</script>
<?php
	endif;
}
add_action('wp_head', 'wpv_ga_script', 10000);

function wpv_sub_shortcode($name, $content, &$params, &$sub_contents) {
	if(!preg_match_all("/\[$name\b(?P<params>.*?)(?:\/)?\](?:(?P<contents>.*?)\[\/$name\])?/s", $content, $matches)) {
		return false;
	}

	$params = array();
	$sub_contents = $matches['contents'];

	// this is from wp-includes/formatting.php
	/* translators: opening curly double quote */
	$opening_quote = _x( '&#8220;', 'opening curly double quote', 'default' );
	/* translators: closing curly double quote */
	$closing_quote = _x( '&#8221;', 'closing curly double quote', 'default' );
	/* translators: double prime, for example in 9" (nine inches) */
	$double_prime = _x( '&#8243;', 'double prime', 'default' );

	foreach($matches['params'] as $param_str) {
		$param_str = str_replace( array( $opening_quote, $closing_quote, $double_prime ), '"', $param_str );
		$params[]  = shortcode_parse_atts($param_str);
	}

	return true;
}

function wpv_is_login() {
	return strpos($_SERVER['PHP_SELF'], 'wp-login.php') !== false;
}

/**
 * @see http://wordpress.stackexchange.com/a/7094/8344
 */
function wpv_get_attachment_id( $url ) {
	$dir = wp_upload_dir();
	$dir = trailingslashit($dir['baseurl']);

	if( false === strpos( $url, $dir ) )
		return false;

	$file = basename($url);

	$query = array(
		'post_type' => 'attachment',
		'fields' => 'ids',
		'meta_query' => array(
			array(
				'value' => $file,
				'compare' => 'LIKE',
			)
		)
	);

	$query['meta_query'][0]['key'] = '_wp_attached_file';
	$ids = get_posts( $query );

	foreach( $ids as $id ) {
		$attachment = wp_get_attachment_image_src($id, 'full');
		if( $url == array_shift( $attachment ) )
			return $id;
	}

	$query['meta_query'][0]['key'] = '_wp_attachment_metadata';
	$ids = get_posts( $query );

	foreach( $ids as $id ) {

		$meta = wp_get_attachment_metadata($id);

		if(isset($meta['sizes']) && is_array($meta['sizes'])) {
			foreach( $meta['sizes'] as $size => $values ) {
				if( $values['file'] == $file && $url == array_shift( wp_get_attachment_image_src($id, $size) ) ) {

					$this->attachment_size = $size;
					return $id;
				}
			}
		}
	}

	return false;
}

/**
 * This function check whether a given url is an image attachment and resizes it to $width x $height
 */
function wpv_resize_image($src, $width, $height, $quality=80, $top=true, $double=true) {
	$file = wpv_get_attachment_file($src);
	if( $file !== $src ) {
		$uploads = wp_upload_dir();
		$new_image = wp_get_image_editor($file);

		if(is_wp_error($new_image))
			return $src;

		$size = $new_image->get_size();

		if($double && $width*2 <= $size['width'] && $height*2 <= $size['height']) {
			$width *= 2;
			$height *= 2;
		} elseif($size['width'] < $width) {
			$height = round($height*$size['width']/$width);
			$width = $size['width'];
		}
		$thumbnail = wpv_thumbnail_path($file, $width, $height);

		if(is_wp_error($thumbnail)) {
			return $src;
		} else {
			if(!file_exists($thumbnail)) {
				$dims = image_resize_dimensions($size['width'], $size['height'], $width, $height, true);
				if(!$dims)
					return $src;

				list( $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h ) = $dims;
				$new_image->crop( $src_x, ($top ? 0 : $src_y), $src_w, $src_h, $dst_w, $dst_h );
				$new_image->set_quality($quality);
				$new_image->save($thumbnail);
			}

			return str_replace($uploads['basedir'], $uploads['baseurl'], $thumbnail);
		}
	}

	return $src; // not an image attachment, will not be resized
}

function wpv_get_attachment_file($src) {
	$attachment_id = wpv_get_attachment_id($src);
	if( $attachment_id !== false && wp_attachment_is_image($attachment_id) ) {
		return get_attached_file($attachment_id);
	}

	return $src;
}

/**
 * Returns the possible file path for a scaled down version of an image
 *
 * Most of the code matches the parts of the image_resize() function, since it doesn't check if the file exists before overwriting it.
 *
 * @param string $file Image file path.
 * @param int $max_w Maximum width to resize to.
 * @param int $max_h Maximum height to resize to.
 * @return string Thumbnail file path
 */
function wpv_thumbnail_path($file, $max_w, $max_h) {
	$size = @getimagesize( $file );
	if ( !$size )
		return new WP_Error('invalid_image', __('Could not read image size', 'wpv'), $file);
	list($orig_w, $orig_h, $orig_type) = $size;

	$dims = image_resize_dimensions($orig_w, $orig_h, $max_w, $max_h, true);
	if ( !$dims )
		return new WP_Error( 'error_getting_dimensions', __('Could not calculate resized image dimensions', 'wpv') );
	list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = $dims;

	$info = pathinfo($file);
	$dir = $info['dirname'];
	$ext = $info['extension'];
	$name = wp_basename($file, ".$ext");

	return "{$dir}/{$name}-{$dst_w}x{$dst_h}.{$ext}";
}

function wpv_prepare_url($url) {
	while(preg_match('#/[-\w]+/\.\./#', $url)) {
		$url = preg_replace('#/[-\w]+/\.\./#', '/', $url);
	}

	return $url;
}

function wpv_ajaxed_post_portfolio() {
	if(wpv_is_reduced_response()) {
		echo 'title|';
		wpv_title();
			wpv_reduced_delim();
		echo 'hsidebars|';
		$header_placed = wpv_get_header_sidebars();
			wpv_reduced_delim();
		echo 'ptitle|';
		wpv_page_header($header_placed);
			wpv_reduced_delim();
		if(function_exists('theme_breadcrumbs')) {
			echo 'breadcrumbs|';
			theme_breadcrumbs();
				wpv_reduced_delim();
		}
		echo 'content|';
	}
}
add_action('wp', 'wpv_ajaxed_post_portfolio');

function wpv_is_reduced_response() {
	return current_theme_supports('wpv-reduced-ajax-single-response') &&
			is_singular(array('post', 'portfolio', 'page')) &&
			isset($_SERVER['HTTP_X_VAMTAM']) &&
			$_SERVER['HTTP_X_VAMTAM'] == 'reduced-response';
}

function wpv_reduced_footer() {
	wpv_reduced_delim();
	echo 'scripts|';
	print_footer_scripts();
}

function wpv_reduced_delim() {
	echo '-----VAMTAM-----SPLIT-----';
}

class WpvFancyPortfolio {
	public static function json() {
		global $post;

		$cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();
		$type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'background';

		$query = array(
			'post_type' => 'portfolio',
			'orderby'=>'menu_order',
			'order'=>'ASC',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $cats,
				)
			),
		);

		$items = get_posts($query);

		return self::$type($cats, $items);
	}

	private static function background($cats, $items) {
		$data = array();

		foreach($items as $p) {
			$img = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
			if(isset($img[3]))
				unset($img[3]);

			$gallery = array();

			if(get_post_meta($p->ID, 'portfolio_type', true) == 'gallery') {
				$image_ids = array_keys(get_children(array(
					'post_parent' => $p->ID,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
				)));

				array_unshift($image_ids, get_post_thumbnail_id());
				$image_ids = array_values(array_unique($image_ids));
				unset($image_ids[0]);

				foreach($image_ids as $image_id) {
					$sub_img = wp_get_attachment_image_src($image_id,'full');
					if(isset($sub_img[3]))
						unset($sub_img[3]);
					$gallery[] = $sub_img;
				}
			}

			$item = array(
				'href' => get_permalink($p->ID),
				'img' => $img,
				'title' => get_the_title($p->ID),
			);

			if (!empty($gallery)) {
				$item['img'] = array($item['img']);
				foreach($gallery as $galleryImage) {
					if ($galleryImage[0] != $item['img'][0][0]) {
						$item['img'][] = $galleryImage;
					}
				}
			}

			$data[] = $item;
		}

		return $data;
	}

	private static function page($cats, $items) {
		$data = array();

		foreach($items as $p) {
			$portfolio_type = get_post_meta($p->ID, 'portfolio_type', true);

			$item = array(
				'id' => $p->ID,
			);

			$img = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');

			if($portfolio_type != 'video') {
				$first_child = array(
					'pageUrl' => get_permalink($p->ID),
					'title' => get_the_title($p->ID),
					'type' => 'image',
					'url' => $img[0],
				);
			}

			if($portfolio_type == 'gallery') {
				$children = array($first_child);

				$parent = array( $p->ID );

				if ( array_key_exists( 'sitepress', $GLOBALS ) ) {
					$default_lang = $GLOBALS['sitepress']->get_default_language();

					if ( ICL_LANGUAGE_CODE !== $default_lang ) {
						$parent[] = (int)icl_object_id( $p->ID, 'portfolio', true, $default_lang );
					}
				}

				$image_ids = array_map( create_function( '$image', 'return $image->ID;' ), get_posts( array(
					'post_parent__in' => $parent,
					'post_status'     => 'inherit',
					'post_type'       => 'attachment',
					'post_mime_type'  => 'image',
					'posts_per_page'  => -1,
				) ) );

				$image_ids = array_diff( $image_ids, array( get_post_thumbnail_id( $p->ID ) ) );

				foreach($image_ids as $image_id) {
					$sub_img = wp_get_attachment_image_src($image_id,'full');
					$child = array(
						'pageUrl' => get_permalink($p->ID),
						'title' => get_the_title($p->ID),
						'url' => $sub_img[0],
						'type' => 'image',
					);

					if($sub_img[0] != $img[0]);
						$children[] = $child;
				}

				$item['children'] = $children;
				$item['type'] = $portfolio_type;

			} elseif($portfolio_type == 'video') {
				$item = array_merge($item, array(
					'html' => do_shortcode('[video src="'. get_post_meta($p->ID, 'portfolio_data_url', true).'" wrapper="video-wrapper"]'),
					'pageUrl' => get_permalink($p->ID),
					'title' => get_the_title($p->ID),
					'type' => 'html',
				));
			} else {
				$item = array_merge($item, $first_child);
				$item['type'] = apply_filters('wpv_fancy_portfolio_item_type', $portfolio_type);
			}

			$data[] = $item;
		}

		return $data;
	}
}

function wpv_get_fancy_portfolio_items() {
	return WpvFancyPortfolio::json();
}

function wpv_sanitize_portfolio_item_type($type) {
	if($type == 'gallery' || $type == 'video' || $type == 'image')
		return $type;

	return 'image';
}
add_filter('wpv_fancy_portfolio_item_type', 'wpv_sanitize_portfolio_item_type');

function wpv_fix_shortcodes($content){
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		'<p> [' => '[',
		'] </p>' => ']',
		']<br />' => ']'
	);

	return strtr($content, $array);
}
add_filter('the_content', 'wpv_fix_shortcodes');

function wpv_fix_br($content){
	$content = preg_replace('#(<[^>]+>)\s*<\s*br\s*/?\s*>#', '$1', $content);
	$content = preg_replace('#<\s*br\s*/?\s*>\s*(</[^>]+>)#', '$1', $content);

    return $content;
}
add_filter('the_content', 'wpv_fix_br', 1000);

function wpv_featured_image_height() {
	$prefix = (get_post_type() == 'portfolio') ? 'portfolio-' : '';

	return wpv_get_optionb($prefix.'crop-featured-image') ?
		(isset($GLOBALS['wpv_blog_image_height']) ? $GLOBALS['wpv_blog_image_height'] : wpv_get_option($prefix.'fullimage-height')) :
		false;
}

function wpv_featured_image_atts($width) {
	return wpv_get_optionb('crop-featured-image') ? array(
				'width' => $width,
				'height' => wpv_get_option('fullimage-height')
			) :
			array('width' => $width);
}

function wpv_get_portfolio_terms() {
	$terms = get_the_terms(get_the_id(), 'portfolio_category');
	$terms_slug = $terms_name = array();
	if (is_array($terms)) {
		foreach($terms as $term) {
			$terms_slug[] = preg_replace('/[\pZ\pC]+/u', '-', $term->slug);
			$terms_name[] = $term->name;
		}
	}

	return array($terms_slug, $terms_name);
}

function wpv_get_layer_sliders() {
	global $wpdb;

	// Table name
	$table_name = $wpdb->prefix . "layerslider";

	// Get sliders
	$sliders = $wpdb->get_results("SELECT id, name FROM $table_name
										WHERE flag_hidden = '0' AND flag_deleted = '0'
										ORDER BY date_c ASC LIMIT 100" );

	$result = array();
	if(is_array($sliders) && !empty($sliders)) {
		foreach($sliders as $item) {
			$result["layerslider-{$item->id}"] = "LayerSlider - {$item->name}";
		}
	}

	return $result;
}

function wpv_get_sample_slides() {
	$slides = include WPV_SAMPLES_DIR . 'sample-slides.php';

	return $slides;
}