<?php
	wp_enqueue_script('front-jquery.vamtam.slider');
	wp_enqueue_script('front-jquery.vamtam.slider.extensions');
	wp_enqueue_script('front-jquery.easing');
	
	global $post;

	$slider_effect = wpv_post_default('slider-effect', 'header-slider-effect');
	$slider_style = theme_get_slider_design($slider_effect);

	$height = wpv_post_default('slider-height', 'header-slider-height');
	$layout = wpv_get_option('site-layout-type');
	$max_width = 960;
	$function_height = (int) wpv_get_option('header-slider-function-height');

	$style = '';
	if($function_height < 0) {
		$style = "max-height:{$height}px;";
	} else {
		$height = 0;
	}
?> 

<div id="main-slider-loading-mask" class="wpv-loading-mask"></div>
<div id="header-slider" style="<?php echo $style?>">
	<?php
		$query = array(
			'post_type' => 'slideshow',
			'posts_per_page' => -1,
			'order' => 'ASC',
			'orderby' => 'menu_order',
		);
		
		global $post;
		$cat = wpv_post_default('slider-category' , 'default-header-slider');
		$query['tax_query'] = array(
			array(
				'taxonomy' => 'slideshow_category',
				'field' => 'slug',
				'terms' => $cat,
				'operator' => 'IN',
			)
		);
		
		query_posts($query);
		$slides = array();
		while(have_posts()): the_post();
			
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
				$second_caption = get_post_meta(get_the_id(), 'second-caption', true);
				$third_caption = get_post_meta(get_the_id(), 'third-caption', true);
				if(!empty($content) || !empty($second_caption) || !empty($third_caption)) {
					$slide['captions'] = array(
						array('html' => do_shortcode($content)),
						array('html' => do_shortcode($second_caption)),
						array('html' => do_shortcode($third_caption)),
					);
				}
			}
			else {
				$slide['type'] = 'html';
				$slide['thumbUrl'] = get_post_meta(get_the_id(), 'slide-thumbnail', true);

				if($thumbnail_id == -3) {
					// the following is done only for backwards compatibility with Sintia 1 and should be removed from later themes
					$data = array_map('theme_map_slide_data', get_post_meta($post->ID, '', true));

					if(isset($data['slide-type'])) {
						$code = 'wpv_shortcode_slide_'.$data['slide-type'];
						$content = isset($data['content']) ? $data['content'] : '';

						$slide['html'] = $code($data, $content, 'slide_'.$data['slide-type']);
					}

				} else {
					$slide['html'] = do_shortcode(get_post_meta(get_the_id(), 'first-caption', true));
				}
			}
			
			$slide['shortText'] = get_post_meta(get_the_id(), 'title', true);
			$slide_icon = get_post_meta(get_the_id(), 'icon', true);

			if(!empty($slide_icon))
				$slide['shortText'] = "<img src='$slide_icon' alt='' class='tab-icon' />".$slide['shortText'];
			
			$slides[] = $slide;
		endwhile;
		wp_reset_query();
		?>
</div>
<?php if ($slider_effect == 'makalu') { ?>
<div id="makalu-tabs-bar">
	<div class="limit-wrapper">
		<div class="btn-prev"></div>
		<div class="btn-next"></div>
		<div class="tabs-view">
			<div class="tabs-container"></div>
		</div>
	</div>
</div>
<?php } ?>
<script>
/*<![CDATA[*/
	jQuery(function($) {
	    $('#header-slider').vamtamSlider({
			slides              : <?php echo json_encode($slides); ?>,
			initialHeight       : 140, // some space for the top menu area,
			minHeight           : (320/16) * 9, // 16:9 for min. site width of 320
			maintainAspectRatio : function(slider) { return $(slider.element).width() < 960; },
			<?php if((int)$max_width): ?>
				maxWidth        : <?php echo $max_width ?>,
			<?php endif ?>
			<?php if((int)$height): ?>
				height          : <?php echo $height ?>,
			<?php elseif((int) wpv_get_option('header-slider-function-height') >= 0): ?>
				height          : function() { 
					return $(window).height() - ($("#wpadminbar").height() || 0) - <?php wpvge('header-slider-function-height'); ?>;
				},
				minHeight       : <?php wpvge('header-height') ?>,
			<?php endif ?>
			pauseOnHover        : <?php echo intval(wpv_get_option('header-slider-pauseonhover'))?>,
	    	resizing            : '<?php wpvge('header-slider-resizing') ?>',
			pauseTime           : <?php wpvge('header-slider-pausetime')?>,
			animationTime       : <?php wpvge('header-slider-animationtime')?>,
			autostart           : '<?php wpvge('header-slider-direction')?>',
			effect              : '<?php echo $slider_effect?>',
	    	easing              : '<?php wpvge('header-slider-easing')?>',
			captionFxEasing     : 'easeInOutQuad', //<?php wpvge('header-slider-easing')?>',
			pager               : "auto",
			loadingMask         : "#main-slider-loading-mask",
			disableOnMobiles    : $('body').hasClass('reduce-js-on-mobiles'),
			//autoFocus           : true, // Should be true for the header slider only!
			thumbNavContainer   : "#header-gallery-slider-thumbs",
			captionQueue        : <?php echo intval(wpv_get_option('header-slider-captionqueue'))?>,
			forceNestedAnimationTimes : true,
			complexSlidesDuration     : 3000
	    });
	});
/*]]>*/
</script>