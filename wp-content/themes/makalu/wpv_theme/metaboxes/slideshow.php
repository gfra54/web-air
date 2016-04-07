<?php

if(!isset($htmlslide))
	$htmlslide = false;

return apply_filters('wpv_slide_metabox', array(
array(
	'name' => __('Captions', 'wpv'),
	'type' => 'separator',
),

array(
	'name' => __('Slide Icon', 'wpv'),
	'id' => 'icon',
	'type' => 'upload',
),

array(
	'name' => __('Slide Title', 'wpv'),
	'id' => 'title',
	'type' => 'text',
),

array(
	'name' => $htmlslide ? __('Slide Content', 'wpv') : __('First Caption', 'wpv'),
	'id' => 'first-caption',
	'type' => 'textarea',
	'class' => 'no-desc',
	'rows' => $htmlslide ? 15 : 3,
),

array(
	'name' => __('Second Caption', 'wpv'),
	'id' => 'second-caption',
	'type' => 'textarea',
	'rows' => 3,
	'class' => $htmlslide ? 'hidden':'no-desc',
),
array(
	'name' => __('Third Caption', 'wpv'),
	'id' => 'third-caption',
	'type' => 'textarea',
	'rows' => 3,
	'class' => $htmlslide ? 'hidden':'no-desc',
),

array(
	'name' => __('Slide Link', 'wpv'),
	'id' => 'slide-link',
	'type' => 'text',
	'default' => '',
	'rows' => 3,
	'class' => $htmlslide ? 'hidden':'',
),

array(
	'name' => __('Slide Link Target', 'wpv'),
	'id' => 'slide-link-target',
	'type' => 'select',
	'default' => '',
	'class' => $htmlslide ? 'hidden':'',
	'options' => array(
		'' => __('Same window', 'wpv'),
		'_blank' => __('New window', 'wpv'),
	),
),
));