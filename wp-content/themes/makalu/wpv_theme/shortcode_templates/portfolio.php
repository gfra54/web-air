<?php

$scrollable = wpv_sanitize_bool($scrollable);

$colWidth    = 100;
$colPad      = 0;
$clientWidth = 890;

if ($column > 1) {
	$colWidth = (100 - 2*($column-1))/$column;
	$colPad = 0.02;
}

if ($sortable != 'false'):
?>
	<section class="portfolios <?php echo $engine ?>">
		<nav class="sort_by_cat">
			<span>
				<span class="cat"><a data-value="all" href="#" class="active"><?php _e('All', 'wpv')?></a></span>
				<?php
					// show the categories present in this listing
					$terms = array();
					if ($cat != '' && $cat != 'null') {
						foreach(explode(',', $cat) as $term_slug) {
							$term = get_term_by('slug', $term_slug, 'portfolio_category');
							if($term)
								$terms[] = $term;
						}
					} else {
						$terms = get_terms('portfolio_category', 'hide_empty=1');
					}
				?>
				<?php foreach($terms as $term): ?>
						 <span class="cat"><a data-value="<?php echo preg_replace('/[\pZ\pC]+/u', '-', $term->slug)?>" href="#"><?php echo $term->name?></a></span>
				<?php endforeach ?>
			</span>
		</nav>	
		<div class="clearboth"></div>
<?php else: ?>
	<section class="portfolios <?php if ($scrollable) echo 'scroll-x'; ?>">
<?php endif ?>

		
		<?php
			
			ob_start();
		
			// get the portfolio items
	
	if($column)
	
	$i = 0;
	while(have_posts()): the_post(); $i++;
		
		list($terms_slug, $terms_name) = wpv_get_portfolio_terms();
		
		$last = $clear = $style = '';

		if(!$scrollable) {
			if($i % $column == 0)
				$last = 'last';

			if (($i-1) % $column == 0)
				$clear = ' clearboth';
		}
		else {
			$style = ' style="width:' . (($clientWidth/$column)-($clientWidth*$colPad)) . 'px;margin-right:' . ($clientWidth*$colPad) . 'px"';
		}
		?>
		
		<li data-id="<?php the_id()?>" data-type="<?php echo implode(' ', $terms_slug)?>" class="<?php echo $last.$clear?> grid-1-<?php echo $column ?>"<?php echo $style;?>>
		
		<?php
		if (has_post_thumbnail()):
			extract(wpv_get_portfolio_options($group, $rel_group));

			$video_url = ($type === 'video' and !empty($href)) ? $href : '';

			if($layout === 'fancy-page' || $type === 'html' || $title != 'true' || (!empty($video_url) && has_post_thumbnail())) {
				$lightbox = '';
				$href = ($type=='link' ? $href : get_permalink());
			}
?>
			<div class="portfolio_image">
				<div class="thumbnail" style="max-height:<?php echo $size[1]?>px">
					<?php if($type=='gallery' && $layout != 'fancy-page' && $title == 'true'): ?>
						<?php echo do_shortcode('[gallery style="gallery featured" height="'.$size[1].'" width="'.$size[0].'" slider="true"]');?>
					<?php else: ?>
						<a class="<?php echo $lightbox?> thumbnail-url <?php echo $type?>" <?php if(isset($link_target)) echo 'target="'.$link_target.'"'; ?> href="<?php echo $href?>" <?php echo $rel.$width.$height.$iframe?>>
							<?php
								if(!$scrollable && !$sortable) {
									wpv_lazy_load( wpv_resize_image($image[0], $size[0], $size[1]), get_the_title(), array(
										'width' => (int)$size[0],
										'height' => (int)$size[1],
									));
								} else {
									echo "<img src='".wpv_resize_image($image[0], $size[0], $size[1])."' alt='".get_the_title()."' width='{$size[0]}' height='{$size[1]}' />";
								}
							?>
							<span class="thumbnail-overlay">
								<span class="meta">
									<?php if($title != 'true'): ?>
										<span class="title"><?php the_title()?></span>
									<?php endif ?>
									<span class="btn"><span></span></span>
								</span>
								<?php if(sizeof($terms_name) > 0):?>
									<span class="label"><?php echo implode(', ', $terms_name)?></span>
								<?php endif ?>
							</span>
						</a>
						
					<?php endif ?>
				</div><!-- / .thumbnail -->
			</div>
	<?php endif ?>

		<?php if($title == 'true' || $desc == 'true'): ?>
			<div class="portfolio_details project-info-pad folio">
				<?php if($title == 'true'): ?>
					<h3><a href="<?php the_permalink() ?>"><?php the_title()?></a></h3>
				<?php endif ?>
				<?php if($desc === 'true'):?>
					<div class="excerpt"><?php the_excerpt() ?></div>
					<?php if($more): ?>
						<a href="<?php the_permalink() ?>" class="read-more-button icon-a theme" data-icon="<?php wpv_icon('theme-angle-right')?>"><?php echo $moreText ?></a>
					<?php endif ?>
				<?php endif ?>
			</div>
		<?php endif ?>

	</li>
		
	<?php endwhile ?>
	
	<?php 
	$items = ob_get_clean();
	$style = '';
	if ($scrollable) {
		$listWidth = (($i / $column) * 100) + $colPad;
		$style = " style=\"width:$listWidth%\"";
	}
	?>
	<ul class="portfolio_<?php echo $column_class?> clearfix" data-columns="<?php echo $column ?>"<?php echo $style?>>
	<?php echo $items?>
	</ul>
	<?php if ($nopaging == 'false' && function_exists('wpv_load_more'))	wpv_load_more($paging_preference); ?>
</section>
<?php if ($scrollable) { ?>
<div class="scrollbar-horizontal"><div class="scrollbar-scrollarea"><div class="scrollbar-btn-main"><div></div></div></div><div class="scrollbar-btn-left"><div></div></div><div class="scrollbar-btn-right"><div></div></div></div>
<?php } ?>
<?php wp_reset_query(); ?>
