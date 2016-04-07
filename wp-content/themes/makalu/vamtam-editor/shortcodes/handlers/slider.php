<?php

function wpv_shortcode_slider($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'name' => '',
		'width' => 400,
		'height' => 0,
		'effect' => 'fade',
		'animspeed' => 400,
		'pausetime' => 5000,
		'pauseonhover' => 'true',
		'style' => '',
		'direction' => 'right',
		'maintain_aspect_ratio' => 'true',
	), $atts));

	wp_enqueue_script('front-jquery.vamtam.slider');

	$id = md5(uniqid('', true));

	$slides = array();
	if(empty($name)) {
		$slides = json_decode(trim($content));
	} else {
		$query = array(
			'post_type' => 'slideshow',
			'posts_per_page' => -1,
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'tax_query' => array(
				array(
					'taxonomy' => 'slideshow_category',
					'field' => 'slug',
					'terms' => $name,
					'operator' => 'IN',
				)
			)
		);
		
		$q = new WP_Query($query);
		$slides = array();
		while($q->have_posts()): $q->the_post();
			
			$thumbnail_id = get_post_thumbnail_id();
			$html_slide = $thumbnail_id <= 0;
			
			$slide = array();

			$image = '';
			if(!$html_slide) {
				$slide['type'] = 'img';
				$image = wp_get_attachment_image_src( $thumbnail_id, 'full');
				$slide['url'] = $image[0];
				
				$slide['href'] = get_post_meta(get_the_id(), 'slide-link', true);
				$slide['hrefTarget'] = get_post_meta(get_the_id(), 'slide-link-target', true);
				
				// Captions
				$content = get_post_meta(get_the_id(), 'first-caption', true);
				if(!empty($content)) {
					$slide['captions'] = array(
						array('html' => do_shortcode($content)),
						array('html' => do_shortcode(get_post_meta(get_the_id(), 'second-caption', true))),
						array('html' => do_shortcode(get_post_meta(get_the_id(), 'third-caption', true))),
					);
				}
			} else {
				$slide['type'] = 'html';
				$slide['thumbUrl'] = get_post_meta(get_the_id(), 'slide-thumbnail', true);

				$slide['html'] = do_shortcode(get_post_meta(get_the_id(), 'first-caption', true));
			}
			
			$slide['shortText'] = get_post_meta(get_the_id(), 'thumbnail-title', true);
			
			$slides[] = $slide;
		endwhile;

		wp_reset_query();
		wp_reset_postdata();
	}
	
	ob_start();
	
	if((int)$height === 0)
		$height = '"auto"';
?>
	<div class="slider-shortcode-wrapper for-<?php echo $id?> style-<?php echo $style?>"<?php if ($width > 0) { echo ' style="max-width: ' . $width . 'px;"'; }?>>
		<div class="slider-shortcode-wrapper-inner">
			<div id="slider-<?php echo $id?>" class="slider-shortcode"></div>
		</div>
		<?php if($style == '2'):	?>
			<div class="controls">
				<div class="inner">
					<span class="prev icon theme"><b><?php wpv_icon('theme-angle-left') ?></b></span>
					<span class="next icon theme"><b><?php wpv_icon('theme-angle-right') ?></b></span>
				</div>
			</div>
		<?php endif ?>
		<script>
			jQuery(function($) {
				$('#slider-<?php echo $id?>').vamtamSlider({
					slides: <?php echo json_encode($slides) ?>,
					height: <?php echo $height?>,
					<?php if(is_numeric($height)): ?>
						initialHeight: <?php echo $height?>,
						minHeight: <?php echo min($height, 20)?>,
					<?php else: ?>
						initialHeight: 20,
						minHeight: 20,
					<?php endif ?>
					maxWidth: <?php echo apply_filters('wpv_shortcode_slider_width', $width, $style)?>,
					maintainAspectRatio : <?php echo $maintain_aspect_ratio ?>,
					pauseTime: <?php echo $pausetime?>,
					animationTime: <?php echo $animspeed?>,
					effect: '<?php echo $effect?>',
					autostart: '<?php echo $direction?>',
					pauseOnHover: <?php echo $pauseonhover?>
					<?php if($style == '2'):	?>
					,prevButton: '.for-<?php echo $id?> .controls .prev'
					,nextButton: '.for-<?php echo $id?> .controls .next'
					<?php endif ?>
				});
			});
		</script>
	</div>
 
<?php
	return ob_get_clean();
}
add_shortcode('slider', 'wpv_shortcode_slider');
