<div id="sub-header">
	<?php

	/*
	 * some pages may not have a slider enabled, check for that
	 */
	if( theme_has_header_slider() ):
		$slider_effect = wpv_post_default('slider-effect', 'header-slider-effect', false, false);
		$slider_style = theme_get_slider_design($slider_effect);
		$slider_engine = $slider_effect != 'layerslider' ? 'vamtam' : 'layerslider';
		?>
		<div class="clearfix">
			<div id="header-slider-container" class="<?php echo $slider_engine?>">
				<div class="header-slider-wrapper animation-<?php echo $slider_effect?> style-<?php echo $slider_style?>">
					<?php
						get_template_part('slider', $slider_engine);
					?>
				</div>
			</div>
		</div>
		<?php 
	endif;  
	
	// Page header
	global $title;
	if(!is_404()) {
		if(wpv_has_woocommerce() && is_woocommerce() && !is_single()) {
			if(is_product_category()) {
				$title = single_cat_title( '', false );
			} elseif(is_product_tag()) {
				$title = single_tag_title( '', false );
			} else {
				$title = woocommerce_get_page_id( 'shop' ) ? get_the_title(woocommerce_get_page_id( 'shop' )) : '';
			}
		}

		wpv_page_header(0, $title); 
	}
	?>
	<div class="meta-header">
		<div class="limit-wrapper"><?php theme_breadcrumbs(); ?></div>
	</div>
</div>