<?php

/*
 * media upload
 */

function media_get_image_action_callback() {
	$image = & get_post($_POST['id']);
	if($image)
		echo $image->guid;
	else
		echo '0';
	exit;
}
add_action('wp_ajax_wpv-media-get-image', 'media_get_image_action_callback');

function save_theme_last_config_callback() {
	wpv_update_option('last-active-skin', $_POST['name']);
	
	echo '<span class="success">The changes are temporary, you have to click "Save options".</span>';
	
	exit;
}
add_action('wp_ajax_save_last_theme_config', 'save_theme_last_config_callback');


// gets the stylesheet for the font preview
function wpv_font_preview_callback() {
	global $available_fonts;
	
	$url = wpv_get_font_url($_POST['face'], $_POST['weight']);
	
	if(!empty($url)) {
		echo $url;
	}
	
	exit;
}
add_action('wp_ajax_wpv-font-preview', 'wpv_font_preview_callback');

// lists available templates
function wpv_available_templates_callback() {
	$templates_dir = opendir(WPV_TEMPLATES_DIR);

	echo '<option value="">'.__('Available templates', 'wpv').'</option>';
	while($file = readdir($templates_dir)):
		if($file != "." && $file != ".." && strpos($file, THEME_SLUG) == 0):
	?>
			<option value="<?php echo WPV_TEMPLATES_URI.$file?>"><?php echo str_replace(THEME_SLUG, '', $file) ?></option>
	<?php 
		endif;
	endwhile;
				
	closedir($templates_dir);
	
	exit;
}
add_action('wp_ajax_wpv-available-templates', 'wpv_available_templates_callback');

// saves a template
function wpv_save_template_callback() {
	foreach($_POST['template'] as &$opt) {
		if(is_string($opt)) {
			$opt = stripslashes($opt);
		}
	}
	unset($opt);
	
	$output = json_encode($_POST['template']);
	$_POST['file'] = trim($_POST['file']);
	
	if(file_put_contents(WPV_TEMPLATES_DIR.THEME_SLUG.$_POST['file'], $output)) {
		echo '<span class="success">'. __('Success.', 'wpv') . '</span>';
	} else {
		echo '<span class="error">'. __('Cannot save file.', 'wpv') . '</span>';
	}
	exit;
}
add_action('wp_ajax_wpv-save-template', 'wpv_save_template_callback');

// deletes a template
function wpv_delete_template_callback() {
	$file = WPV_TEMPLATES_DIR.THEME_SLUG.$_POST['file'];
	
	if(@unlink($file)) {
		echo '<span class="success">'. __('Deleted.', 'wpv') . '</span>';
	} else {
		echo '<span class="error">'. __('Cannot delete file.', 'wpv') . '</span>';
	}
	
	exit;
}
add_action('wp_ajax_wpv-delete-template', 'wpv_delete_template_callback');

// saves the theme/framework options
function wpv_save_options_callback() {
	$page_str = str_replace('wpv_', '', $_POST['page']);

	$options = array();

	$tabs = include WPV_THEME_OPTIONS . $page_str . '/list.php';

	foreach($tabs as $tab) {
		$tab_contents = include WPV_THEME_OPTIONS.$page_str."/$tab.php";
		
		$options = array_merge($options, $tab_contents);
	}
	
	if(!isset($_POST['cacheonly'])) {
		wpv_save_config($options);
	} else {
		wpv_update_generated_css();
	}
	
	wpv_update_option('css-cache-timestamp', time());

	_e('Saved', 'wpv');
	
	exit;
}
add_action('wp_ajax_wpv-save-options', 'wpv_save_options_callback');
