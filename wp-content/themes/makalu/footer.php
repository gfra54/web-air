<?php
/**
 * @package WordPress
 * @subpackage makalu
 */
?>

<?php if(!defined('WPV_NO_PAGE_CONTENT')): ?>
					</div> <!-- .limit-wrapper -->
					
				</div><!-- / #main (do not remove this comment) -->
				
				<footer class="main-footer">
					
					<?php 
					$phone = wpv_get_option('footer-phone');
					if (!empty($phone)) {
						?>
						<div class="footer-phone">
							<div class="limit-wrapper">
							<?php echo do_shortcode($phone); ?>
							</div>
						</div>
					<?php } ?>
					
					<?php if(wpv_get_optionb('has-footer-sidebars')): ?>
						<div class="footer-sidebars-wrapper">
							<?php wpv_footer_sidebars(); ?>
						</div>
					<?php endif ?>
					
				</footer>
				
				<?php do_action('wpv_before_sub_footer') ?>
				
				<div class="copyrights">
					<div class="limit-wrapper">
						<div class="row">
							<?php if(has_nav_menu('menu-footer')): ?>
								<div class="grid-1-2 clearfix" id="sub-footer-menu">
									<?php wp_nav_menu(array('theme_location' => 'menu-footer', 'fallback_cb' => '', 'depth' => 1)); ?>
								</div>
								<div class="grid-1-2 last">
									<?php echo do_shortcode(wpv_get_option( 'credits' )); ?>
								</div>
							<?php else: ?>
								<?php echo do_shortcode(wpv_get_option( 'credits' )); ?>
							<?php endif ?>
						</div>
					</div>
				</div>
			
			</div><!-- / .pane-wrapper -->
			
		</div><!-- / .page-dash-wrapper -->

<?php endif // WPV_NO_PAGE_CONTENT ?>
	</div><!-- / .boxed-layout -->
</div><!-- / #container -->

<?php wp_footer(); ?>
<!-- W3TC-include-js-head -->
</body>
</html>
