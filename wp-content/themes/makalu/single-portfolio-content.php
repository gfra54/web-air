<?php
	$client = get_post_meta(get_the_id(), 'portfolio-client', true);
	$logo   = get_post_meta(get_the_id(), 'portfolio-logo',   true);
	
	$client = preg_replace('@</\s*([^>]+)\s*>@', '</$1>', $client);
	
	$content = apply_filters('the_content',get_the_content());
	$content = preg_replace('@</\s*([^>]+)\s*>@', '</$1>', $content);
	$content = preg_replace('@<p\b([^>])*>@', '<div$1 data-p-fix="1">', $content);
	$content = preg_replace('@</p>@', '</div>', $content);
?>

<div class="row-1">
	
	<div class="left">
		<?php if(!empty($logo)): ?>
			<div class="cell">
				<img src="<?php echo $logo ?>" alt="<?php echo esc_attr(get_the_title()) ?>"/>
				<div class="border-right"></div>
			</div>
		<?php endif ?>
		<?php if(isset($_SERVER['HTTP_X_VAMTAM']) && $_SERVER['HTTP_X_VAMTAM'] == 'ajax-portfolio'): ?>
			<div class="cell divider"></div>
			<div class="cell">
				<h3><?php echo get_the_title() ?></h3>
			</div>
		<?php endif ?>
	</div>
	
	<div class="cell right">
		<div class="cell">
			<div  class="meta-title"><?php _e('Date', 'wpv') ?></div>
			<p class="meta"><?php the_date() ?></p>
		</div>
		
		<?php if(!empty($client)): ?>
		<div class="cell divider"></div>
		<div class="cell">	
			<div  class="meta-title"><?php _e('Client', 'wpv') ?></div>
			<p class="client-details"><?php echo $client ?></p>
		</div>
		<?php endif ?>
		
		<div class="cell divider"></div>
		<div class="cell">		
			<div  class="meta-title"><?php _e('Category', 'wpv') ?></div>
			<p class="meta"><?php echo implode(', ', $terms_name); ?></p>
		</div>
	</div>
</div>
<div class="row-2">
	<?php echo $content ?>
	<?php if(isset($_SERVER['HTTP_X_VAMTAM']) && $_SERVER['HTTP_X_VAMTAM'] == 'ajax-portfolio') wpv_share('portfolio') ?>
</div>
