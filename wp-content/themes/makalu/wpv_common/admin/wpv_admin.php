<?php

/**
 * Framework admin enhancements
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package wpv
 */

class Wpv_Admin {

	public function __construct() {
		$this->option_pages = array(
			'general' => array(
				__('Vamtam | General Settings', 'wpv'),
				__('General Settings', 'wpv'),
			),

			'layout' => array(
				__('Vamtam | Layout', 'wpv'),
				__('Layout', 'wpv'),
			),

			'styles' => array(
				__('Vamtam | Styles', 'wpv'),
				__('Styles', 'wpv'),
			),

			'sliders' => array(
				__('Vamtam | Sliders', 'wpv'),
				__('Sliders', 'wpv'),
			),

			'import' => array(
				__('Vamtam | Quick Import', 'wpv'),
				__('Quick Import', 'wpv'),
			),

			'help' => array(
				__('Vamtam | help', 'wpv'),
				__('Help', 'wpv'),
			),
		);

		add_action('admin_menu', array(&$this, 'load_menus'));

		$this->load_metaboxes();

		$this->load_functions();

		require_once WPV_ADMIN_HELPERS . 'updates/version-checker.php';
	}

	public function load_menus() {
		$main = 'wpv_general';

		add_menu_page(__('Vamtam', 'wpv'), __('Vamtam', 'wpv'), 'edit_theme_options', $main, array(&$this, 'load_options_page'), WPV_THEME_IMAGES .'vamtam_16.png', 23);

		foreach($this->option_pages as $id => $tr) {
			add_submenu_page($main, $tr[0], $tr[1], 'edit_theme_options', "wpv_$id", array(&$this, 'load_options_page'));
		}
	}

	public function load_options_page() {
		require_once WPV_ADMIN_HELPERS . 'config_generator.php';
		$page_str = str_replace('wpv_', '', $_GET['page']);
		$page = WPV_ADMIN_OPTIONS . $page_str . '.php';

		if(file_exists($page)) {
			$options = include $page;
		} else {
			$name = $this->option_pages[$page_str][0];

			$options = array(
				'name' => $name,
				'auto' => true,
				'config' => array(
					array(
						'name' => $name,
						'type' => 'title',
						'desc' => '',
					)
				)
			);

			$tabs = include WPV_THEME_OPTIONS . $page_str . '/list.php';

			foreach($tabs as $tab) {
				$tab_contents = include WPV_THEME_OPTIONS.$page_str."/$tab.php";

				$options['config'] = array_merge($options['config'], $tab_contents);
			}
		}

		if($options['auto'])
			new Config_Generator($options['name'], $options['config']);
	}

	private function load_metaboxes() {
		require_once WPV_ADMIN_METABOXES . 'shortcode.php';
		require_once WPV_ADMIN_METABOXES . 'general.php';
		// require_once WPV_ADMIN_METABOXES . 'template.php';
	}

	private function load_functions() {
		require_once WPV_ADMIN_HELPERS . 'base.php';
		require_once WPV_ADMIN_AJAX_DIR . 'base.php';
		require_once WPV_ADMIN_AJAX_DIR . 'class.wpv-ajax.php';
		require_once WPV_ADMIN_AJAX_DIR . 'slider-editor.php';
		require_once WPV_ADMIN_AJAX_DIR . 'skin-management.php';

		if( isset($_GET['media_image_upload']) || isset($_POST['media_image_upload']) ||
			(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'media_image_upload'))
		) {
			require_once WPV_ADMIN_HELPERS . 'upload-common.php';
			require_once WPV_ADMIN_HELPERS . 'media-upload.php';
		}

		require_once WPV_ADMIN_TYPES . 'slideshow.php';
		require_once WPV_ADMIN_TYPES . 'portfolio.php';
	}
}
