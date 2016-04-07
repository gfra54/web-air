<?php

/**
 * wpv theme framework base class
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package wpv
 */

/**
 * This is the first loaded framework file
 *
 * Wpv_Framework does the following (in this order):
 *  - sets constants for the frequently used paths
 *  - loads translations
 *  - loads the plugins bundled with the theme
 *  - loads some functions and helpers used in various places
 *  - sets the custom post types
 *  - loads the shortcode library for the framework
 *  - if this is wp-admin, load admin files
 *
 * This class also loads the custom widgets and sets what the theme supports (+ custom menus)
 */

class Wpv_Framework {

	/**
	 * Cache the result of some operations in memory
	 *
	 * @var array
	 */
	private static $cache = array();

	public function __construct($options) {
		$this->set_constants($options);
		$this->load_languages();
		$this->load_functions();
		$this->load_plugins();
		$this->load_types();
		$this->load_shortcodes();
		$this->load_admin();

		add_action('after_setup_theme', array(&$this, 'theme_supports'));
		add_action('widgets_init', array(&$this, 'load_widgets'));
		add_action('wp_before_admin_bar_render', array(&$this, 'setup_adminbar'));
	}

	private function set_constants($options) {
		define('THEME_NAME', $options['name']);
		define('THEME_SLUG', $options['slug']);

        // theme dir and uri
		define('WPV_DIR', get_template_directory() . '/');
		define('WPV_URI', get_template_directory_uri() .'/');

		define('THEME_VERSION', self::get_version());

        // framework dir and uri
		define('WPV_COMMON_DIR', WPV_DIR . 'wpv_common/');
		define('WPV_COMMON_URI', WPV_URI . 'wpv_common/');

        // theme-specific assets dir and uri
		define('WPV_THEME_DIR', WPV_DIR . 'wpv_theme/');
		define('WPV_THEME_URI', WPV_URI . 'wpv_theme/');

        // common assets dir and uri
        define('WPV_ASSETS_DIR', WPV_COMMON_DIR . 'assets/');
        define('WPV_ASSETS_URI', WPV_COMMON_URI . 'assets/');

        // common file paths
		define('WPV_HELPERS', WPV_COMMON_DIR . 'helpers/');
		define('WPV_PLUGINS', WPV_COMMON_DIR . 'plugins/');
		define('WPV_PLUGINS_URI', WPV_COMMON_URI . 'plugins/');
		define('WPV_TYPES', WPV_COMMON_DIR . 'types/');
		define('WPV_WIDGETS', WPV_COMMON_DIR . 'widgets/');
		define('WPV_WIDGETS_TPL', WPV_WIDGETS . 'tpl/');
		define('WPV_WIDGETS_ASSETS', WPV_WIDGETS . 'assets/');
		define('WPV_SHORTCODES', WPV_COMMON_DIR . 'shortcodes/');
		define('WPV_SHORTCODES_GENERATOR', WPV_SHORTCODES . 'generator/');
        define('WPV_FONTS_URI', WPV_ASSETS_URI . 'fonts/');
        define('WPV_INCLUDES', WPV_ASSETS_URI . 'includes/');
        define('WPV_JS', WPV_ASSETS_URI . 'js/');
		define('WPV_SWF', WPV_ASSETS_URI . 'swf/');
		define('WPV_IMAGES', WPV_ASSETS_URI . 'images/');

        // theme-specific file paths
		define('WPV_THEME_ASSETS_DIR', WPV_THEME_DIR . 'assets/');
		define('WPV_THEME_ASSETS_URI', WPV_THEME_URI . 'assets/');
		define('WPV_THEME_OPTIONS', WPV_THEME_DIR . 'options/');
		define('WPV_THEME_HELPERS', WPV_THEME_DIR . 'helpers/');
		define('WPV_THEME_METABOXES', WPV_THEME_DIR . 'metaboxes/');
		define('WPV_SHORTCODE_TEMPLATES', WPV_THEME_DIR . 'shortcode_templates/');
		define('WPV_THEME_IMAGES', WPV_THEME_ASSETS_URI . 'images/');
		define('WPV_THEME_JS', WPV_THEME_ASSETS_URI . 'js/');
		define('WPV_THEME_JS_DIR', WPV_THEME_ASSETS_DIR . 'js/');
        define('WPV_THEME_CSS', WPV_THEME_ASSETS_URI . 'css/');
		define('WPV_THEME_CSS_DIR', WPV_THEME_ASSETS_DIR . 'css/');

		// sample content
		define('WPV_SAMPLES_DIR', WPV_DIR . 'samples/');
		define('WPV_SAMPLES_URI', WPV_URI . 'samples/');
		define('WPV_SAVED_OPTIONS', WPV_SAMPLES_DIR . 'saved_skins/');
		define('WPV_SAVED_OPTIONS_URI', WPV_SAMPLES_URI . 'saved_skins/');
		define('WPV_TEMPLATES_DIR', WPV_SAMPLES_DIR . 'templates/');
		define('WPV_TEMPLATES_URI', WPV_SAMPLES_URI . 'templates/');
		define('WPV_THEME_SAMPLE_CONTENT', WPV_SAMPLES_DIR . 'content.xml');
		define('WPV_THEME_SAMPLE_WIDGETS', WPV_SAMPLES_DIR . 'sidebars');
		define('WPV_WOOCOMMERCE_SAMPLE_CONTENT', WPV_SAMPLES_DIR . 'woocommerce.xml');

        // cache
        define('WPV_CACHE_DIR', WPV_DIR . 'cache/');
		define('WPV_CACHE_URI', WPV_URI . 'cache/');

        // admin
		define('WPV_ADMIN', WPV_COMMON_DIR . 'admin/');
		define('WPV_ADMIN_URI', WPV_COMMON_URI . 'admin/');
		define('WPV_ADMIN_TYPES', WPV_ADMIN . 'types/');
		define('WPV_ADMIN_AJAX_DIR', WPV_ADMIN . 'ajax/');
		define('WPV_ADMIN_AJAX', WPV_ADMIN_URI . 'ajax/');
		define('WPV_ADMIN_ASSETS_URI', WPV_ADMIN_URI . 'assets/');
		define('WPV_ADMIN_HELPERS', WPV_ADMIN . 'helpers/');
		define('WPV_ADMIN_OPTIONS', WPV_ADMIN . 'options/');
		define('WPV_ADMIN_METABOXES', WPV_ADMIN . 'metaboxes/');
	}

	public static function get_version() {
		if(isset(self::$cache['version']))
			return self::$cache['version'];

		$the_theme = wp_get_theme();
		if($the_theme->parent()) {
			$the_theme = $the_theme->parent();
		}

		self::$cache['version'] = $the_theme->get('Version');

		return self::$cache['version'];
	}

	public function theme_supports() {
		global $wpv_post_formats;
		$wpv_post_formats = apply_filters('wpv_post_formats', array('aside', 'link', 'image', 'video', 'audio', 'quote', 'gallery'));

		ini_set('pcre.backtrack_limit','200000');

		if (function_exists('add_theme_support')) {
			add_theme_support('post-thumbnails');

			add_theme_support('automatic-feed-links');

			add_theme_support('post-formats', $wpv_post_formats);
		}

		if(function_exists('register_nav_menus')) {
			register_nav_menus(array(
				'menu-header' => __('Menu Header', 'wpv'),
				'menu-top' => __('Menu Top', 'wpv'),
				'menu-footer' => __('Sub-footer', 'wpv'),
			));
		}

		add_image_size('posts-widget-thumb', 400, 400, true);
		add_image_size('posts-widget-thumb-small', 43, 43, true);
	}

	private function load_languages() {
		load_theme_textdomain('wpv', WPV_DIR . 'languages');
	}

	private function load_functions() {
		global $wpv_defaults, $wpv_fonts;
		$wpv_defaults = include WPV_SAMPLES_DIR . 'default-options.php';
		$wpv_fonts    = include WPV_HELPERS . 'fonts.php';

		require_once WPV_HELPERS . 'init.php';

		$custom_fonts = wpv_get_option( 'custom-font-families' );
		if ( ! empty( $custom_fonts ) ) {
			$custom_fonts = explode( "\n", $custom_fonts );

			$wpv_fonts['-- Custom fonts --'] = array( 'family' => '' );

			foreach ( $custom_fonts as $font ) {
				$font = preg_replace( '/["\']+/', '', $font );

				$wpv_fonts[$font] = array(
					'family' => '"' . $font . '"',
					'weights' => array('300', '300 italic', 'normal', 'italic', '600', '600 italic', 'bold', 'bold italic', '800', '800 italic'),
				);
			}
		}

		require_once WPV_HELPERS . 'woocommerce-integration.php';

		include WPV_THEME_HELPERS . 'base.php';

		require_once WPV_HELPERS . 'base.php';
		require_once WPV_HELPERS . 'template.php';
		require_once WPV_HELPERS . 'css.php';
		require_once WPV_HELPERS . 'sidebars.php';
		require_once WPV_HELPERS . 'dimox-breadcrumbs.php';
		require_once WPV_HELPERS . 'tgm-plugin-activation.php';


		include WPV_THEME_HELPERS . 'template.php';

		require_once WPV_PLUGINS . 'dependencies.php';

		require_once WPV_HELPERS . 'head.php';
	}

	private function load_plugins() {
		require WPV_PLUGINS . 'importer/importer.php';
		require WPV_PLUGINS . 'widget-importer/importer.php';
		require WPV_PLUGINS . 'layerslider/layerslider.php';

		// Activate the plugin if necessary
	    if(wpv_get_option('layerslider_activated', '0') !== '1') {
	        layerslider_activation_scripts();
	        wpv_update_option('layerslider_activated', '1');
	    }
	}

	private function load_types() {
		// slides
		register_post_type('slideshow', array(
			'labels' => array(
				'name' => __('Slides', 'wpv'),
				'singular_name' => __('Slide', 'wpv'),
				'add_new' => __('Add New', 'wpv' ),
				'add_new_item' => __('Add New Slide', 'wpv' ),
				'edit_item' => __('Edit Slide', 'wpv' ),
				'new_item' => __('New Slide', 'wpv' ),
				'view_item' => __('View Slide', 'wpv' ),
				'search_items' => __('Search Slides', 'wpv' ),
				'not_found' =>  __('No slides found', 'wpv' ),
				'not_found_in_trash' => __('No slides found in Trash', 'wpv' ),
			),
			'public' => false,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
				'page-attributes',
			),
		));

		register_taxonomy('slideshow_category', 'slideshow', array(
			'hierarchical' => false,
			'labels' => array(
				'name' => __( 'Categories', 'wpv' ),
				'singular_name' => __( 'Slideshow Category', 'wpv' ),
				'search_items' =>  __( 'Search Categories', 'wpv' ),
				'popular_items' => __( 'Popular Categories', 'wpv' ),
				'all_items' => __( 'All Categories', 'wpv' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Slideshow Category', 'wpv' ),
				'update_item' => __( 'Update Slideshow Category', 'wpv' ),
				'add_new_item' => __( 'Add New Slideshow Category', 'wpv' ),
				'new_item_name' => __( 'New Slideshow Category Name', 'wpv' ),
				'separate_items_with_commas' => __( 'Separate Slideshow categories with commas', 'wpv' ),
				'add_or_remove_items' => __( 'Add or remove Slideshow category', 'wpv' ),
				'choose_from_most_used' => __( 'Choose from the most used Slideshow categories', 'wpv' )
			),
			'show_ui' => false,
			'query_var' => false,
			'rewrite' => false,
		));

		// portfolios
		register_post_type('portfolio', array(
			'labels' => array(
				'name' => __('Portfolios', 'wpv' ),
				'singular_name' => __('Portfolio', 'wpv' ),
				'add_new' => __('Add New', 'wpv' ),
				'add_new_item' => __('Add New Portfolio', 'wpv' ),
				'edit_item' => __('Edit Portfolio', 'wpv' ),
				'new_item' => __('New Portfolio', 'wpv' ),
				'view_item' => __('View Portfolio', 'wpv' ),
				'search_items' => __('Search Portfolios', 'wpv' ),
				'not_found' =>  __('No portfolios found', 'wpv' ),
				'not_found_in_trash' => __('No portfolios found in Trash', 'wpv' ),
				'parent_item_colon' => '',
			),
			'singular_label' => __('portfolio', 'wpv' ),
			'public' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array( 'with_front' => false ),
			'query_var' => false,
			'menu_position' => 21,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'comments',
				'page-attributes'
			)
		));

		register_taxonomy('portfolio_category','portfolio',array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Categories', 'wpv' ),
				'singular_name' => __( 'Portfolio Category', 'wpv' ),
				'search_items' =>  __( 'Search Categories', 'wpv' ),
				'popular_items' => __( 'Popular Categories', 'wpv' ),
				'all_items' => __( 'All Categories', 'wpv' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Portfolio Category', 'wpv' ),
				'update_item' => __( 'Update Portfolio Category', 'wpv' ),
				'add_new_item' => __( 'Add New Portfolio Category', 'wpv' ),
				'new_item_name' => __( 'New Portfolio Category Name', 'wpv' ),
				'separate_items_with_commas' => __( 'Separate Portfolio category with commas', 'wpv' ),
				'add_or_remove_items' => __( 'Add or remove portfolio category', 'wpv' ),
				'choose_from_most_used' => __( 'Choose from the most used portfolio category', 'wpv' )
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => false,
		));
	}

	private function load_shortcodes() {
		include WPV_SHORTCODES . 'gallery.php';
		include WPV_SHORTCODES . 'columns.php';
		include WPV_SHORTCODES . 'slide_1.php';
		include WPV_SHORTCODES . 'slide_2.php';
		include WPV_SHORTCODES . 'slide_standard.php';

		$shortcodes = include WPV_THEME_METABOXES . 'shortcode.php';

		foreach($shortcodes as $name) {
			$longname = WPV_SHORTCODES . $name . '.php';

			if(file_exists($longname))
				require_once $longname;
		}
	}

	public function load_widgets() {
		add_filter('widget_text', 'do_shortcode');

		$widgets = array(
			'authors',
			'advertisement',
			'flickr',
			'social',
			'subpages',
			'contactinfo',
			'gmap',
			'posts',
			'post-formats',
		);

		$enabled = get_theme_support('wpv-enabled-widgets');
		if(is_array($enabled))
			$widgets = $enabled;

		foreach($widgets as $name) {
			require_once WPV_WIDGETS . "/$name.php";
		}
	}

	private function load_admin() {
		if(is_admin()) {
			require_once WPV_ADMIN . 'wpv_admin.php';
			$admin = new Wpv_Admin;
		}
	}

	public function setup_adminbar() {
		if(!current_user_can('edit_theme_options')) return;

		global $wp_admin_bar;

		$wp_admin_bar->add_menu( array(
			'parent' => false,
			'id' => 'wpv-settings',
			'title' => __('Vamtam', 'wpv'),
			'href' => admin_url( 'admin.php?page=wpv_general'),
			'meta' => false
		));

		$adv_name = __('Theme options', 'wpv');

		$pages = array(
			'general' => __('General Settings', 'wpv'),
			'layout' => __('Layout', 'wpv'),
			'styles' => __('Styles', 'wpv'),
			'sliders' => __('Sliders', 'wpv'),
			'import' => __('Quick Import', 'wpv'),
			'help' => __('Help', 'wpv'),
		);

		foreach($pages as $id => $name) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpv-settings',
				'id' => "wpv-$id",
				'title' => $name,
				'href' => admin_url("admin.php?page=wpv_$id"),
				'meta' => false
			));
		}
	}
}
