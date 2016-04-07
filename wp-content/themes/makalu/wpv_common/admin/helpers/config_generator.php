<?php
/**
 * Config_Generator is a meta programming helper used to generated the html code needed for a configuration page
 */

class Config_Generator {

	public $name;
	protected $options;

	/**
	 * @param string $name
	 * @param array $options definitions for the config page
	 */
	public function __construct($name, $options) {

		$this->name = $name;
		$this->options = $options;

		if(isset($_POST['save-wpv-config']))
			$this->save_config();

		$this->render();
	}

	private function save_config() {
		wpv_save_config($this->options);

		global $wpv_config_messages;

		$wpv_config_messages .= '<div class="message updated fade"><p><strong>Updated Successfully</strong></p></div>';
	}

	protected function tpl($template, $value) {
		extract($value);
		if(!isset($desc))
			$desc = '';

		if(!isset($default))
			$default = null;

		if(!isset($class))
			$class = '';

		include WPV_ADMIN_HELPERS . "config_generator/$template.php";
	}

	private function render() {
		echo '<div class="wrap wpv-config-page">';
		echo '<form method="post" action="">';
		if(isset($_GET['allowreset'])) {
			echo '<input type="hidden" name="doreset" value="true" />';
		}

		if(isset($_GET['cacheonly'])) {
			echo '<input type="hidden" name="cacheonly" value="true" />';
		}

		foreach($this->options as $option) {
			if (method_exists($this, $option['type']))
				$this->$option['type']($option);
			else
				$this->tpl($option['type'], $option);
		}

		echo '</div>'; // #theme-config

		if( !isset($this->options[0]['no-save-button']) ) {
			$this->tpl('save', array());
		}

		echo '</form>';
		echo '</div>';
	}

	public static function get_select_target_config($type) {
		return self::target_config($type);
	}

	public static function target_config($type) {
		$config = array();
        switch($type){
			case 'page':
				$entries = get_pages('title_li=&orderby=name');
				foreach($entries as $key => $entry)
					$config[$entry->ID] = $entry->post_title;
			break;
			case 'cat':
				$entries = get_categories('orderby=name&hide_empty=0');
				foreach($entries as $key => $entry)
					$config[$entry->term_id] = $entry->name;
			break;
			case 'post':
				$entries = get_posts('orderby=title&numberposts=-1&order=ASC');
				foreach($entries as $key => $entry)
					$config[$entry->ID] = $entry->post_title;
			break;
			case 'portfolio':
				$entries = get_posts('post_type=portfolio&orderby=title&numberposts=-1&order=ASC');
				foreach($entries as $key => $entry)
					$config[$entry->ID] = $entry->post_title;
			break;
			case 'portfolio_category':
				$entries = get_terms('portfolio_category','orderby=name&hide_empty=0');
				foreach($entries as $key => $entry)
					$config[$entry->slug] = $entry->name;
			break;
			case 'slideshow_category_simple':
			case 'slideshow_category':
				$entries = get_terms('slideshow_category','orderby=name&hide_empty=0');
				foreach($entries as $entry) {
					$config[$entry->slug] = $entry->name;
				}

				if($type == 'slideshow_category') {
					$config = array_merge($config, wpv_get_layer_sliders());
				}
			break;
			case 'sidebars':
				$sidebars = wpv_get_option('custom-sidebars');
				$sidebars = explode(',', $sidebars);

				foreach($sidebars as $sidebar) {
					$config[$sidebar] = str_replace('wpv_sidebar-', '', $sidebar);
				}
			break;
		}

		return $config;
	}
}

