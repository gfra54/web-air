<?php

$config = array(
	'id' => 'wpv_templates',
	'title' => __('Vamtam Templates', 'wpv'),
	'pages' => array('page', 'post', 'portfolio'),
	'context' => 'side',
	'priority' => 'low',
);


require_once WPV_ADMIN_HELPERS . 'metaboxes_generator.php';
$options = include WPV_ADMIN_METABOXES . 'template_options.php';
new metaboxes_generator($config, $options);
