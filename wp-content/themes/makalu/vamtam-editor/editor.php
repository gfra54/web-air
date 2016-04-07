<?php
/*
Plugin Name: Vamtam visual editor
Plugin URI: http://vamtam.com
Description: A drag and drop content editor
Version: 1
Author: Vamtam
Author URI: http://vamtam.com
License: 
*/

/**
 * @package wpv
 * @subpackage editor
 */

if ( !defined('ABSPATH') ) die('Move along, nothing to see here.');

class WPV_Editor {
	private $shortcodes = array(
		'accordion',
		'blank',
		'blog',
		'column',
		'contact_info',
		'divider',
		'flickr',
		'gmap',
		'iframe',
		'linkarea',
		'message_box',
		'portfolio',
		'price',
		'services',
		'services_expandable',
		'sitemap',
		'slider',
		'slogan',
		'tabs',
		'team_member',
		'text',
		'text_divider',
		'video',
	);

	private $handlers = array(
		'accordion',
		'blank',
		'blog',
		'boxes',
		'column',
		'contact_info',
		'divider',
		'flickr',
		'gmap',
		'iframe',
		'linkarea',
		'portfolio',
		'price',
		'services',
		'services_expandable',
		'sitemap',
		'slider',
		'slogan',
		'tabs',
		'team_member',
		'text',
		'text_divider',
		'video',
	);

	public function __construct() {
		$this->is_plugin = !defined('VAMTAM_EDITOR_IN_THEME');

		if ($this->is_plugin && !load_plugin_textdomain('editor', false, '../languages/'))
			load_plugin_textdomain('editor', false, dirname( plugin_basename( __FILE__ ) ) . '/po/');

		$this->url = $this->is_plugin ? plugin_dir_url( __FILE__ ) : WPV_URI.'vamtam-editor/';
		$this->dir = realpath(dirname(__FILE__)).'/';
		$this->generators_dir = $this->dir . 'shortcodes/config/';
		$this->handlers_dir = $this->dir . 'shortcodes/handlers/';
		define('WPV_EDITOR_ASSETS', $this->url . 'assets/');
		define('WPV_EDITOR_ASSETS_DIR', $this->dir . 'assets/');

		add_action('admin_init', array(&$this, 'admin_init'));

		$this->setup_shortcodes();

		require_once 'ajax.php';
	}

	private function setup_shortcodes() {
		foreach($this->handlers as $h) {
			require_once "{$this->handlers_dir}{$h}.php";
		}
	}

	public function admin_init() {
		// add_action('after_setup_theme', array(&$this, 'map_shortcodes'));
		add_action('edit_post', array(&$this, 'save_meta'));

		// for now, you must explicitly set which post types can use the editor
		$post_types = array('post', 'page', 'portfolio');
		foreach ($post_types as $type) {
			add_meta_box('wpv_visual_editor', __('Visual Editor', 'wpv'), array(&$this, 'editor'), $type, 'advanced', 'low');
		}

		$this->enqueues();
		$this->map_shortcodes();
	}

	private function enqueues() {
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-draggable');
		
		wp_enqueue_script('wpv-editor', $this->url . 'assets/js/editor.js', array('jquery'), false, true);

		wp_enqueue_style('wpv-editor', $this->url . 'assets/css/editor.css');

		wp_localize_script('wpv-editor', 'WPVED_LANG', array(
			'empty_notice' => __('Please drag  any element you want here.', 'wpv'),
		));
	}

	/**
	 * outputs the basic html code for the editor in a meta box
	 */
	public function editor($post, $metabox) {
		include 'editor-tpl.php';
	}

	/**
	 * save some meta fields which are used to preserve the state of the editor
	 */
	public function save_meta($post_id) {
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		
		$fields = array('_wpv_ed_js_status');

		foreach($fields as $f) {
			if(isset($_POST[$f]) && !empty($_POST[$f])) {
				update_post_meta($post_id, $f, trim($_POST[$f]));
			} else {
				delete_post_meta($post_id, $f);
			}
		}
	}

	/**
	 * map the shortcode configuration generator files to $wpv_sc and $wpv_sc_menus
	 */

	public function map_shortcodes() {
		global $wpv_sc, $wpv_sc_menus;
		$wpv_sc = array();
		$wpv_sc_menus = array();

		$available_shortcodes = include 'available-shortcodes.php';
		
		$sorted = array();

		foreach($this->shortcodes as $slug) {
			if(isset($available_shortcodes[$slug])) {
				$shortcode_options = include $this->generators_dir . $slug . '.php'; 
				$wpv_sc[$slug] = $shortcode_options;

				$sorted[$slug] = $shortcode_options['name'];
			}
		}

		asort($sorted);

		foreach($sorted as $slug=>$name) {
			$wpv_sc_menus[$available_shortcodes[$slug]][] = $slug;
		}
	}

	private function complex_elements() {
		global $wpv_sc, $wpv_sc_menus;

		foreach($wpv_sc_menus as $menu_name=>$menu_codes): ?>
			<li class='<?php echo esc_attr($menu_name)?>'>
				<ul>
					<?php foreach ($menu_codes as $slug): ?>
						<?php
							$id = "shortcode-$slug";
							$class = '';

							if($slug === 'column') {
								$id = $class = 'column-11';
							}
						?>
						<li>
							<a id="<?php echo $id ?>" class="<?php echo $class ?> droppable_source clickable_action" href="javascript:void(0)">
								<?php if(isset($wpv_sc[$slug]['icon'])): $icon = $wpv_sc[$slug]['icon']; ?>
									<span class="shortcode-icon" style="font-size:<?php echo $icon['size']?>;font-family:<?php echo $icon['family']?>;line-height:<?php echo $icon['lheight'] ?>"><?php echo $icon['char'] ?></span>
								<?php endif ?>
								<span class="title"><?php echo $wpv_sc[$slug]['name'] ?></span>
							</a>
							<?php if(isset($wpv_sc[$slug]['desc'])): ?>
								<div class="description">
									<span class="description-trigger va-icon va-icon-info"></span>
									<div>
										<section class="content"><?php echo $wpv_sc[$slug]['desc'] ?></section>
										<footer><a href="<?php echo admin_url('admin.php?page=wpv_help') ?>" title="<?php _e('Read more in our documentation', 'wpv') ?>"><?php _e('Read more in our documentation', 'wpv') ?></a></footer>
									</div>
								</div>
							<?php endif ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</li>
		<?php endforeach;
	}

	public static function get_icon($key) {
		$icons = include(WPV_EDITOR_ASSETS_DIR . 'fonts/icomoon/list.php');

		if(isset($icons[$key]))
			return wpv_mb_chr($icons[$key]);

		return $key;
	}
}

new WPV_Editor;
