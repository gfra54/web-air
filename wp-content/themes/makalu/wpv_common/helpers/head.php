<?php

// put all javascript that has to be included in a separate <script> tag here
// everything else put in combine.php
function wpv_enqueue_scripts() {
	$move_bottom = true;

	$fancy_portfolio_cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();
	$fancy_portfolio_type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'background';

	$sometimes_load = (is_singular(array('post', 'portfolio')) || (!empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'page'));

	if(is_admin() || wpv_is_login()) return;

	// modernizr should be on top
	wp_enqueue_script( 'modernizr', WPV_JS .'modernizr.min.js');

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-migrate');

	if(wpv_get_option('gmap_api_key')) {
		wp_enqueue_script('gmap-api', 'http://maps.googleapis.com/maps/api/js?sensor=false&amp;key=' . wpv_get_option('gmap_api_key'), array(), false, $move_bottom);
		wp_enqueue_script('jquery-gmap', WPV_JS .'jquery.gmap.js', array('jquery', 'gmap-api'), THEME_VERSION, $move_bottom);
	}

	if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply', false, false, false, $move_bottom );
		}

	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-ui-widget');

	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-tabs');

	wp_register_script('froogaloop', 'http://a.vimeocdn.com/js/froogaloop2.min.js', array('jquery'), 2, $move_bottom);
	wp_register_script('youtube-api', 'http://www.youtube.com/player_api', array('jquery'), THEME_VERSION, $move_bottom);

	$wpv_js = array(
		'jquery.plugins' => array(
			false,
			array('jquery'),
		),
		'jquery.easing' => array(
			false,
			array('jquery')
		),
		'wpvbgslider' => array(
			false,
			array('jquery')
		),
		'jquery.colorbox' => array(
			true,
			array('jquery'),
		),
		'validator' => array(
			true,
			array('jquery'),
		),
		'jail' => array(
			true,
			array('jquery'),
		),
		'wpv_common' => array(
			true,
			array('jquery', 'front-jquery.plugins'),
		),
		'jquery.vamtam.slider' => array(
			true,
			array('jquery', 'front-jquery.plugins'),
		),
		'jquery.ui.tabs.rotate' => array(
			$sometimes_load,
			array('jquery', 'jquery-ui-tabs'),
		),
		'jquery.isotope.min' => array(
			true,
			array('jquery', 'jquery-ui-tabs'),
		),
	);

	foreach($wpv_js as $file=>$opts) {
		if($opts[0]) {
			wp_enqueue_script( 'front-'.$file, WPV_JS .$file.'.js', $opts[1], THEME_VERSION, $move_bottom);
		} else {
			wp_register_script( 'front-'.$file, WPV_JS .$file.'.js', $opts[1], THEME_VERSION, $move_bottom);
		}
	}

	$wpv_theme_js = array(
		'jquery.vamtam.slider.extensions' => array(
			false,
			array('jquery', 'front-jquery.vamtam.slider'),
		),
		'wpv_theme' => array(
			true,
			apply_filters('wpv_theme_js_deps', array('jquery', 'front-wpv_common', 'front-jquery.plugins')),
		),
		'jquery.vamtam.portfolioslider' => array(
			false,
			array('jquery', 'front-jquery.vamtam.slider', 'front-jquery.plugins'),
		),
	);

	foreach($wpv_theme_js as $file=>$opts) {
		if($opts[0]) {
			wp_enqueue_script( 'front-'.$file, WPV_THEME_JS .$file.'.js', $opts[1], THEME_VERSION, $move_bottom);
		} else {
			wp_register_script( 'front-'.$file, WPV_THEME_JS .$file.'.js', $opts[1], THEME_VERSION, $move_bottom);
		}
	}
}
add_action('init', 'wpv_enqueue_scripts');

function wpv_admin_enqueue_scripts() {
	$move_bottom = true;

	wp_enqueue_script( 'jquery-colorbox', WPV_JS .'jquery.colorbox.js', array('jquery'), THEME_VERSION, $move_bottom);

	wp_enqueue_script( 'common');
	wp_enqueue_script( 'editor');
	wp_enqueue_script( 'jquery-ui-sortable');
	wp_enqueue_script( 'jquery-ui-draggable');
	wp_enqueue_script( 'jquery-ui-tabs');
	wp_enqueue_script( 'jquery-ui-range', WPV_ADMIN_ASSETS_URI .'js/jquery.ui.range.js', array('jquery'), THEME_VERSION, $move_bottom);
	wp_enqueue_script( 'jquery-ui-slider');
	wp_enqueue_script( 'thickbox');
		wp_enqueue_script( 'farbtastic' );

		wp_enqueue_media();

	wp_enqueue_script( 'wpv_admin', WPV_ADMIN_ASSETS_URI .'js/wpv_admin.js', array('jquery'), THEME_VERSION, $move_bottom);
	wp_enqueue_script( 'wpv-shortcode', WPV_ADMIN_ASSETS_URI . 'js/shortcode.js', array('jquery'), THEME_VERSION, $move_bottom);
}
add_action('admin_enqueue_scripts', 'wpv_admin_enqueue_scripts');

// put all css that has to be included in a separate <link> tag here
// everything else put in combine.php
function wpv_enqueue_styles() {
	if(!is_admin()) {
		if(!wpv_is_login()) {
			$external_fonts = maybe_unserialize(wpv_get_option('external-fonts'));
			if(is_array($external_fonts) && !empty($external_fonts)) {
				foreach($external_fonts as $name=>$url) {
					wp_enqueue_style( 'wpv-'.$name, $url, array(), THEME_VERSION);
				}
			}

			$css_files = include WPV_THEME_CSS_DIR . 'list.php';
			$cache_timestamp = wpv_get_option('css-cache-timestamp');

			$generated_deps = array();

			if(wpv_has_woocommerce())
				$generated_deps[] = 'woocommerce-general';

			foreach($css_files as $file) {
				if(is_multisite() && (basename($file) === 'configurable' || basename($file) === 'all'))
					$file .= $GLOBALS['blog_id'];

				wp_enqueue_style( 'front-'.basename($file), wpv_prepare_url(WPV_THEME_CSS . $file . '.css'), $generated_deps, $cache_timestamp);
			}
		}
	}
	else {
		wp_enqueue_style( 'thickbox');
		wp_enqueue_style( 'colorbox', WPV_ADMIN_ASSETS_URI . 'css/colorbox.css');
		wp_enqueue_style( 'wpv_admin', WPV_ADMIN_ASSETS_URI . 'css/wpv_admin.css');
		wp_enqueue_style( 'farbtastic' );

		if(stristr($_SERVER['HTTP_USER_AGENT'], "msie 7") || stristr($_SERVER['HTTP_USER_AGENT'], "msie 8") ) {
			wp_enqueue_style( 'wpv-ie78', WPV_ADMIN_ASSETS_URI . 'css/ie78.css');
		}
	}

}
add_action('init', 'wpv_enqueue_styles');
