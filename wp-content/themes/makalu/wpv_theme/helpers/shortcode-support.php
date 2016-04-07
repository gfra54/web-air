<?php

function theme_multiwidget_tab_title($title, $slug) {
	$icons = array(
		'comment_count' => 'theme-heart',
		'date' => 'theme-pencil',
		'comments' => 'theme-comment',
		'tags' => 'theme-tag',
	);

	if(isset($icons[$slug]))
		return "<span class='visuallyhidden'>$title</span>".do_shortcode('[icon name="'.$icons[$slug].'"]');

	return $title;
}
add_filter('wpv_multiwidget_tab_title', 'theme_multiwidget_tab_title', 10, 2);

function theme_multiwidget_single_title($only, $title) {
	echo $title;
}
add_action('wpv_multiwidget_single_title', 'theme_multiwidget_single_title', 10, 2);

function theme_team_member_social_icon($icon) {
	$icons = array(
		'googleplus' => 'google plus3',
		'linkedin' => 'linkedin',
		'facebook' => 'facebook2',
		'twitter' => 'twitter2',
		'youtube' => 'youtube',
	);

	return isset($icons[$icon]) ? $icons[$icon] : $icon;
}
add_filter('wpv_team_member_social_icon', 'theme_team_member_social_icon');