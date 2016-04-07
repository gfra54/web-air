<?php
	$has_image   = !empty($image);
	$has_icon    = !empty($icon);
	$has_button  = !empty($button_link);
	
	$className[] = 'services clearfix';
	$className[] = $fullimage == 'true' ? 'fullimage'  : 'smallimage';
	$className[] = $has_image           ? 'has-image'  : 'no-image';
	$className[] = $has_icon            ? 'has-icon'   : 'no-icon';
	$className[] = $has_button          ? 'has-button' : 'no-button';
	$className[] = $class;
	$className   = implode(' ', $className);
	
?>
<div class="<?php echo $className?>" style="text-align:<?php echo $text_align?>;">
	<div class="services-inside">
		<?php if($has_image || $has_icon): ?>
			<?php if($fullimage == 'true'): ?>
				<div class="thumbnail">
					<?php if($has_button): ?>
						<a href="<?php echo $button_link?>" title="<?php echo $title ?>"><?php wpv_lazy_load($image, '') ?></a>
					<?php else: ?>
						<?php wpv_lazy_load($image, '') ?>
					<?php endif ?>
				</div>
			<?php else: ?>
				<div class="shrinking-outer clearfix">
					<div class="shrinking">
						<div><div>
							<?php if($has_button): ?>
								<a href="<?php echo $button_link?>" title="<?php echo $title ?>">
							<?php endif ?>
							<?php
								if($has_icon) {
									echo do_shortcode('[icon name="'.$icon.'" size="20"]');
								} else {
									wpv_lazy_load($image, '');
								}
							?>
							<?php if($has_button): ?>
								</a>
							<?php endif ?>
						</div></div>
					</div>
					<div class="shrinking-button">
						<div><div>
							<h5><a href="<?php echo $button_link?>"><?php echo $button_text?></a></h5>
						</div></div>
					</div>
				</div>
			<?php endif ?>
		<?php endif ?>
		<?php if($title != ''):?>
			<h3 class="services-title">
				<?php if( !empty($button_link)): ?>
					<a href="<?php echo $button_link?>" title="<?php echo $title ?>"><?php echo $title?></a>
				<?php else: ?>
					<?php echo $title ?>
				<?php endif ?>
			</h3>
		<?php endif ?>
	</div>
	<?php if(!empty($content)): ?>
		<div class="services-content"><?php echo do_shortcode($content)?></div>
	<?php endif ?>
	<?php if($button_text != '' && $has_button && !(($has_image || $has_icon) && $fullimage != 'true')): ?>
		<div class="services-button-wrap">
			<a href="<?php echo $button_link?>" class="read-more-button icon-a theme" data-icon="<?php wpv_icon('theme-angle-right')?>"><?php echo $button_text?></a>
		</div>
	<?php endif ?>
</div>
 