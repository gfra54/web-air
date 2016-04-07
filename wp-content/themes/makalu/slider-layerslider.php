<?php

$id = (int)str_replace('layerslider-', '', wpv_post_default('slider-category' , 'default-header-slider'));

if(empty($id)) {
	_e('You have selected LayerSlider as the header slider engine for this page. However, you haven\'t selected an appropriate slider', 'wpv');
} else {
	global $wpdb;

	$table_name = $wpdb->prefix . "layerslider";

	$slider = $wpdb->get_row("SELECT * FROM $table_name
								WHERE id = ".(int)$id." AND flag_hidden = '0'
								AND flag_deleted = '0'
								ORDER BY date_c DESC LIMIT 1" , ARRAY_A);

	if($slider !== null) {
		$slides = json_decode($slider['data'], true);

		echo "<div class='layerslider-fixed-wrapper' style='height:".layerslider_check_unit($slides['properties']['height'])."'>";
		echo do_shortcode('[layerslider id="'.$id.'"]');
		echo "</div>";
		echo '<div style="height:1px;margin-top:-1px"></div>';

	}
}

?>