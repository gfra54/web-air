<?php
/**
 * @package WordPress
 * @subpackage makalu
 */

 

$format = get_query_var('format_filter');
$title = $format? sprintf(__('Post format: %s', 'wpv'), $format) :
				  __('Blog', 'wpv');
get_header();
?>

<div class="pane main-pane">
	<div class="row">
		<div class="page-outer-wrapper">
			<div class="page-wrapper clearfix">
				<?php wpv_has_left_sidebar() ?>

				<article <?php post_class(wpv_get_layout()) ?>>
					<?php 
					global $wpv_has_header_sidebars;
					if( $wpv_has_header_sidebars) {
						wpv_header_sidebars();
					}
					?>
					<div class="page-content">
						<?php get_template_part( 'loop', 'index' ); ?>
					</div>
				</article>

				<?php wpv_has_right_sidebar() ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
