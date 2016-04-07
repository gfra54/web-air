<?php
/**
 * @package WordPress
 * @subpackage makalu
 */

if(isset($_SERVER['HTTP_X_VAMTAM']) && $_SERVER['HTTP_X_VAMTAM'] == 'ajax-portfolio' && have_posts()) {
	the_post();
	
	list($terms_slug, $terms_name) = wpv_get_portfolio_terms();
	include 'single-portfolio-content.php';
	exit;
}

if(!wpv_is_reduced_response()):

get_header(); ?>

<div class="pane main-pane">
	<div class="row">
		<div class="page-outer-wrapper">
			<div class="clearfix page-wrapper">
<?php endif; // reduced response ?>
				<?php wpv_has_left_sidebar() ?>
					
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php
						$rel_group = 'portfolio_'.get_the_ID();
						extract(wpv_get_portfolio_options('true', $rel_group));

						list($terms_slug, $terms_name) = wpv_get_portfolio_terms();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(wpv_get_layout().' '.$type); ?>>
						<?php 
							global $wpv_has_header_sidebars;
							if( $wpv_has_header_sidebars)
								wpv_header_sidebars();
						
							$column_width = wpv_get_central_column_width();
							$size = $column_width;
						?>
						
						<div class="row">
						<?php if($type != 'document'): ?>
							<div class="portfolio_image_wrapper fullwidth-folio">
								<?php
									if($type == 'gallery'):
										echo do_shortcode('[gallery style="1 featured" height="0" width="'.$size.'" slider="true"]');
									elseif($type == 'video'):
										wpv_post_video($size, null, $href);
									elseif($type == 'html'):
										echo do_shortcode(get_post_meta(get_the_ID(), 'portfolio-top-html', true));
								 	else:
								 		wpv_lazy_load( wpv_resize_image($image[0], $size, wpv_featured_image_height()), get_the_title(), wpv_featured_image_atts($size));
									endif;
								?>
							</div>
						<?php endif ?>
						</div>
						
						<div class="portfolio-text-content">
							<?php include 'single-portfolio-content.php' ?>

							<?php if(wpv_get_optionb('show-related-portfolios')): ?>
								<div class="row">
									<div class="sep"></div>
									<?php echo do_shortcode('[portfolio column="3" nopaging="true" sortable="false" max="3" cat="'.implode(',', $terms_slug).'" ids="" title="true" desc="true" more="" group="true" height="150" long="false" scrollable="false" post__not_in="'.get_the_ID().'"]') ?>
								</div>
							<?php endif ?>
						</div>
						
						<div class="clearboth">
							<?php comments_template(); ?>
						</div>
					</article>
					
				<?php endwhile ?>
				
				<?php wpv_has_right_sidebar() ?>
<?php if(!wpv_is_reduced_response()): ?>
			</div>
			<?php theme_header_share('portfolio'); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
<?php else: wpv_reduced_footer(); ?>
<?php endif; // reduced ?>