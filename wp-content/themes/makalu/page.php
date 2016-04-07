<?php
/**
 * @package WordPress
 * @subpackage makalu
 */

if(!wpv_is_reduced_response()):
	get_header();
endif;

?>

<?php if ( have_posts() ) : the_post(); ?>

<?php if(!wpv_is_reduced_response()): ?>

<div class="pane main-pane">
	<div class="row">
		<div class="page-outer-wrapper">
			<div class="clearfix page-wrapper">
<?php endif; // reduced response ?>
				<?php wpv_has_left_sidebar() ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(wpv_get_layout()); ?>>
					<?php 
					global $wpv_has_header_sidebars;
					if( $wpv_has_header_sidebars) {
						wpv_header_sidebars();
					} 
					?>
					<?php $has_image = wpv_page_image() ?>
					<div class="page-content <?php echo $has_image?>">
						<?php
							$fancy_portfolio_cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();
							$fancy_portfolio_type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'background';

							if(!empty($fancy_portfolio_cats) && $fancy_portfolio_type == 'page'):
								$data = wpv_get_fancy_portfolio_items();
								?>
								<script>
								/*<![CDATA[*/
									jQuery(function($) { $.WPV.PortfolioSlider.init(<?php echo json_encode($data)?>, { resizing: '<?php wpvge('portfolio-slider-resizing') ?>' }); });
								/*]]>*/</script>
								<?php
								echo do_shortcode('[portfolio column="3" nopaging="true" sortable="true" max="-1" cat="'.implode(',', $fancy_portfolio_cats).'" ids="" title="true" desc="true" more="" group="true" height="220" is_long="false" width="full" layout="fancy-page" engine="sortable"]');
								wp_enqueue_script('front-jquery.vamtam.portfolioslider');
							endif ?>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpv' ), 'after' => '</div>' ) ); ?>
					</div>

					<?php comments_template( '', true ); ?>
				</article>
				
				<?php wpv_has_right_sidebar() ?>
<?php if(!wpv_is_reduced_response()): ?>
				
			</div>
			<?php theme_header_share('page'); ?>
		</div>
	</div>
</div>

<?php endif;
endif;

if(!wpv_is_reduced_response()) {
	get_footer();
} else {
	wpv_reduced_footer();
}