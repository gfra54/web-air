<?php

echo $before_widget;

if ($title) 
	echo $before_title . $title . $after_title;

?>
<div class="social_wrap social_animation_<?php echo $animation; ?> <?php echo $package; ?>">

<?php

	if(!empty($instance['enable_sites'])):
		foreach($instance['enable_sites'] as $site):
			$path = str_replace('{:name}', strtolower($site) , $this->packages[$package]['path']);
			$link = isset($instance[$site]) ? $instance[$site] : '#';
			
			if (file_exists(WPV_THEME_DIR . 'assets/images/social/' . $path)):
				?><a href="<?php echo $link?>" rel="nofollow" target="_blank" title="<?php echo $alt.' '.$site?>"><?php 
					wpv_lazy_load(WPV_THEME_IMAGES.'social/'.$path, $alt.' '.$site);
				?></a><?php
			endif;
		endforeach;
	endif;
		
	if($custom_count > 0):
		for($i=1; $i<=$custom_count; $i++):
			$name = isset($instance["custom_name"][$i]) ? $instance["custom_name"][$i] : '';
			$icon = isset($instance["custom_icon"][$i]) ? $instance["custom_icon"][$i] : '';
			$link = isset($instance["custom_url"][$i]) ? $instance["custom_url"][$i] : '#';
			
			if(!empty($icon)) ?>
				<a href="<?php echo $link?>" rel="nofollow" target="_blank" title="<?php echo $alt.' '.$name?>">
					<?php wpv_lazy_load($icon, $alt.' '.$name)?>
				</a>
			<?php
		endfor;
	endif;
?>
</div>

<?php
	echo $after_widget;
