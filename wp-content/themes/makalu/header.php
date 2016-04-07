<?php
/**
* @package WordPress
* @subpackage makalu
*/
?><!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-ie no-js"> <!--<![endif]-->
	
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php if(WPV_RESPONSIVE): ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php endif; ?>
	<title><?php wpv_title() ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php wpvge('favicon_url')?>"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<a name="top"></a>
	<?php do_action('wpv_body') ?>
	<div id="container" class="main-container">
		
		<?php include(locate_template('header-box.php'));?>
		<?php include(locate_template('sub-header.php'));?>
		
		<!-- Ajax Portfolio Viewer -->
		<div id="portfolio-viewer">
			<div class="slider-wrapper">
				<div id="ajax-portfolio-slider-big"></div>
				<div class="vamtam-slider-loading-mask"></div>
				<div id="thumbs-bar">
					<div class="prev"></div>
					<div class="next"></div>
					<div class="scroller"></div>
				</div>
			</div>
			<div class="portfolio-viewer-wrap">
				<div class="content row"></div>
			</div>
		</div>
		
		<div class="boxed-layout">
			<div class="page-dash-wrapper">
				<div class="pane-wrapper clearfix">
					<!-- #main (do not remove this comment) -->
					<div id="main" role="main">
						<div class="limit-wrapper">
