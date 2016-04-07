<?php
$bg_css = "opacity:$bg_opacity;background-color:$bg_color;";
if (!empty($bg_image)) {
	$bg_css .= "background-image:url('$bg_image');";
}
?>
<div style="<?php echo $bg_css?>" class="slide-bg html-slide-2"></div>
<div class="limit-wrapper html-slide-2 <?php echo $class?>">
	<div class="table">
		<div class="cell column-1">
			<?php if (!empty($text1)) {?>
				<div duration="500" delay="0" easing="easeInOutSine" cssfrom="opacity:0;top:10px" style="opacity:1;top:0;" class="transition h1 scale-font"><?php echo do_shortcode($text1) ?></div>
			<?php  } if (!empty($text2)) {?>
				<div duration="500" delay="100" easing="easeInOutSine" cssfrom="opacity:0;top:-10px" style="opacity:1;top:0;" class="transition h2 scale-font"><?php echo do_shortcode($text2) ?></div>
			<?php } ?>
			<?php echo do_shortcode($content) ?>
		</div>
		<div class="cell column-2">
			<div class="cell-content">
			<?php if (!empty($add_image_1)) { ?>
				<img src="<?php echo $add_image_1?>" class="transition img1" easing="easeInOutBack" duration="1200" delay="0" style="opacity:1;bottom:-47px;" cssfrom="opacity:0;bottom:-200px" />
			<?php  } if (!empty($add_image_2)) {?>
				<img src="<?php echo $add_image_2?>" class="transition img2" easing="swing" duration="600" delay="1300" style="opacity:1;bottom:0;" cssfrom="opacity:0;bottom:-200px" />
			<?php } if (!empty($text3)) {?>
				<div class="h3 transition" duration="400" delay="2000" style="opacity:1" cssfrom="opacity:0"><?php echo do_shortcode($text3) ?></div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>