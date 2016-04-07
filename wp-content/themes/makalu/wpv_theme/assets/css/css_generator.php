<?php 
	// this file generates the admin options css cache
	
	ob_start();

	include WPV_THEME_CSS_DIR.'less_generator.php';
?>

/* -------------------------------------------------------------------------- */
/*                              Backgrounds                                   */
/* -------------------------------------------------------------------------- */

#main {
	<?php wpv_background('main-background') ?> 
}
.ie8 #main {
	<?php wpv_background_ie8('main-background') ?>
}

/* ------------------------------------------------------
	Header Sliders
------------------------------------------------------ */


#header-slider-thumbs .slider-navbar .slider-thumb-scroller .slider-thumb-wrapper .bg-thumbnail.html {
	background-image: url('<?php wpvge('htmlslide-thumbnail') ?>') !important;
}

/*****************************************************************
						Helper elements and colors
******************************************************************/

.comment-author,
.comments li,
.share-btns,
.slider-shortcode.style-2,
.widget-title:after,
.widget_categories li,
.widget_archive li,
.widget_recent_entries li,
.widget_recent_comments li,
.widget_meta li,
.loop-wrapper.news .page-content {
	border-color: <?php echo wpvge('accent-color-5') ?>;
}

.widget_categories li a,
.widget_archive li a {
	border-color: <?php echo wpvge('accent-color-3') ?> !important;
}

.wpv_posts [data-single] .icon,
.single-post-format .icon,
.post-format-pad .icon {
	color: <?php echo wpvge('accent-color-1') ?>;
}

/* buttons */

<?php

$generic_buttons = array(
	'input[type=button]',
	'input[type=submit]',
	'.slider-shortcode-wrapper .wpv-nav-prev',
	'.slider-shortcode-wrapper .wpv-nav-next',
	'#style-switcher a[name="Reset"]',
);

?>

<?php echo implode(':hover, ', $generic_buttons)?>:hover,
<?php echo implode(':focus, ', $generic_buttons)?>:focus,
<?php echo implode(':active, ', $generic_buttons)?>:active {
	text-decoration: underline;
}


/*--------------------------------------------------------------------------
	Internet Explorer
	Fixes requiring full path from html file to the used resources
--------------------------------------------------------------------------*/

.cboxIE #cboxTopLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderTopLeft.png, sizingMethod='scale');}
.cboxIE #cboxTopCenter{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderTopCenter.png, sizingMethod='scale');}
.cboxIE #cboxTopRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderTopRight.png, sizingMethod='scale');}
.cboxIE #cboxBottomLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderBottomLeft.png, sizingMethod='scale');}
.cboxIE #cboxBottomCenter{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderBottomCenter.png, sizingMethod='scale');}
.cboxIE #cboxBottomRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderBottomRight.png, sizingMethod='scale');}
.cboxIE #cboxMiddleLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderMiddleLeft.png, sizingMethod='scale');}
.cboxIE #cboxMiddleRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo WPV_THEME_IMAGES; ?>colorbox/internet_explorer/borderMiddleRight.png, sizingMethod='scale');}

<?php
	include WPV_THEME_CSS_DIR.'typography.php';
	
	return wpv_finalize_custom_css();
