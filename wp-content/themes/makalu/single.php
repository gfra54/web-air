<?php
/**
 * @package WordPress
 * @subpackage makalu
 */
if(!wpv_is_reduced_response()):
	get_header();
endif;
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php 
if(!wpv_is_reduced_response()):
?>

<div class="pane main-pane">
	<div class="row">
		<div class="page-outer-wrapper">
			<div class="clearfix page-wrapper">
<?php endif; //reduced ?>
				<?php wpv_has_left_sidebar() ?>
				
				<div <?php post_class('single-post-wrapper '.wpv_get_layout())?>>
					<div class="loop-wrapper clearfix full">
						<?php 
						global $wpv_has_header_sidebars;
						if( $wpv_has_header_sidebars) {
							wpv_header_sidebars();
						} 
						?>
						<div class="page-content post-head clearfix">
							<?php get_template_part('single', 'inner'); ?>
						</div>
						<div class="clearboth">
							<?php comments_template(); ?>
						</div>
					</div>
				</div>

				<?php wpv_has_right_sidebar() ?>
<?php if(!wpv_is_reduced_response()): ?>
			</div>
			<?php theme_header_share('post'); ?>
		</div>
	</div>
</div>

<?php endif;
endwhile;

if(!wpv_is_reduced_response()) {
	get_footer();
} else {
	wpv_reduced_footer();
}
