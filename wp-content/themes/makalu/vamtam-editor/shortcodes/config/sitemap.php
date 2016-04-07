<?php
return array(
	"name" => "Sitemap",
	'icon' => array(
		'char' => WPV_Editor::get_icon('list'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value" => "sitemap",
	'controls' => 'size name clone edit delete',
	'class' => 'slim',
	"options" => array(
		array(
			'name' => __('Column Title', 'wpv') ,
			'desc' => __('The column title is placed just above the element.', 'wpv'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Column Title Type', 'wpv') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Type 1', 'wpv'),
				'double' => __('Type 2', 'wpv'),
				'no-divider' => __('No Divider', 'wpv'),
			),
		) ,
		array(
			'name' => __('General', 'wpv'),
			'type' => 'separator',
		),
			array(
				"name" => __("Filter", 'wpv') ,
				"id" => "shows",
				"default" => array(),
				"options" => array(
					"pages" => __("Pages", 'wpv') ,
					"categories" => __("Categories", 'wpv') ,
					"posts" => __("Posts", 'wpv') ,
					"portfolios" => __("Portfolios", 'wpv') ,
				) ,
				"type" => "multiselect",
			) ,

			array(
				"name" => __("Limit", 'wpv') ,
				"desc" => __("Sets the number of items to display.<br>leaving this setting as 0 displays all items.", 'wpv') ,
				"id" => "number",
				"default" => 0,
				"min" => 0,
				"max" => 200,
				"type" => "range"
			) ,

			array(
				"name" => __("Depth", 'wpv') ,
				"desc" => __("This parameter controls how many levels in the hierarchy are to be included. <br> 0: Displays pages at any depth and arranges them hierarchically in nested lists<br> -1: Displays pages at any depth and arranges them in a single, flat list<br> 1: Displays top-level Pages only<br> 2, 3 … Displays Pages to the given depth", 'wpv') ,
				"id" => "depth",
				"default" => 0,
				"min" => - 1,
				"max" => 5,
				"type" => "range"
			) ,

		array(
			'name' => __('Posts and portfolios', 'wpv'),
			'type' => 'separator',
		),
			array(
				"name" => __("Show comments", 'wpv') ,
				"id" => "show_comment",
				"desc" => '',
				"default" => true,
				"type" => "toggle"
			) ,
			array(
				"name" => __("Specific post categories", 'wpv') ,
				"id" => "post_categories",
				"default" => array() ,
				"target" => 'cat',
				"type" => "multiselect",
			) ,
			array(
				"name" => __("Specific posts", 'wpv') ,
				"desc" => __("The specific posts you want to display", 'wpv') ,
				"id" => "posts",
				"default" => array() ,
				"target" => 'post',
				"type" => "multiselect",
			) ,
			array(
				"name" => __("Specific portfolio categories", 'wpv') ,
				"id" => "portfolio_categories",
				"default" => array() ,
				"target" => 'portfolio_category',
				"type" => "multiselect",
			) ,
		
		array(
			'name' => __('Categories', 'wpv'),
			'type' => 'separator',
		),
			array(
				"name" => __("Show Count", 'wpv') ,
				"id" => "show_count",
				"desc" => __("Toggles the display of the current count of posts in each category.", 'wpv') ,
				"default" => true,
				"type" => "toggle"
			) ,
			array(
				"name" => __("Show Feed", 'wpv') ,
				"id" => "show_feed",
				"desc" => __("Display a link to each category's <a href='http://codex.wordpress.org/Glossary#RSS' target='_blank'>rss-2</a> feed.", 'wpv') ,
				"default" => true,
				"type" => "toggle"
			) ,
	) ,
);
