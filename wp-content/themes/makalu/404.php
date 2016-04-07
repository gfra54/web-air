<?php
/**
 * @package WordPress
 * @subpackage makalu
 */

get_header(); ?>

<div class="clearfix"> 
	<h3 class="header-404">
		<?php _e('Page not found', 'wpv') ?>
	</h3>
	<div class="page-404">
		<h3><?php _e('Please search in our site', 'wpv') ?></h3>
		<div class="sep"></div>

		<?php get_search_form(); ?>
	</div>
	
	<div class="page-404-description">
		<h4><?php _e('OR', 'wpv')?></h4>
		<?php echo do_shortcode('[button link="'.home_url().'" bgColor="accent1" icon="theme-angle-right" icon_placement="right"]'.__('Or start from the home page', 'wpv').'[/button] ') ?>
	</div>
</div> 

<?php get_footer(); ?>