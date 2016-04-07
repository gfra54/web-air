<?php

return array(

array(
	'name' => __('Manage Custom Sidebars', 'wpv'),
	'type' => 'start',
),

array(
	'name' => __('How to use', 'wpv'),
	'desc' => sprintf(__("Please note that you have default sidebars for blog posts, portfolio items and pages that are found in <a href='%s' title='Manage widgets'>Appearance/Widgets</a>. There is no point using custom sidebars if you haven't used the default yet.<br>
Once you create the custom sidebar, it will appear in <a href='%s' title='Manage widgets'>Appearance/Widgets</a> and you can insert widgets into it.", 'wpv'), admin_url('widgets.php'), admin_url('widgets.php')),
	'type' => 'info',
),

array(
	'name' => __('Current Sidebars', 'wpv'),
	'id' => 'custom-sidebars',
	'type' => 'sidebar_management',
	'static' => true,
),
	array(
		'type' => 'end'
	),

);
