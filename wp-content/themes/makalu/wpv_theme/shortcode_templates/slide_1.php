<?php
$bg_css = "opacity:$bg_opacity;background-color:$bg_color;";
if (!empty($bg_image)) {
	$bg_css .= "background-image:url('$bg_image');";
}
?>
<div style="<?php echo $bg_css?>" class="slide-bg html-slide-1"></div>
<div class="limit-wrapper html-slide-1 <?php echo $class?>">
	<div class="table">
		<div class="cell column-1">
			<?php if (!empty($text1)) {?>
				<div duration="500" delay="0" easing="easeInOutSine" cssfrom="opacity:0;top:10px" style="opacity:1;top:0;" class="transition h1 scale-font"><?php echo do_shortcode($text1) ?></div>
			<?php  } if (!empty($text2)) {?>
				<div duration="500" delay="100" easing="easeInOutSine" cssfrom="opacity:0;top:-10px" style="opacity:1;top:0;" class="transition h2 scale-font"><?php echo do_shortcode($text2) ?></div>
			<?php  } if (!empty($content)) {?>
				<div duration="800" delay="100" easing="swing" cssfrom="opacity:0;" style="opacity:1;" class="transition scale-font"><?php echo do_shortcode($content) ?></div>
			<?php } if (!empty($btn_text)) {?>
				<div duration="1000" delay="800" easing="easeInOutSine" cssfrom="opacity:0" style="opacity:1" class="transition scale-font">
					<a class="button medium accent1 transition" href="<?php echo $btn_href?>" target="<?php echo $btn_target?>" easing="easeInOutBack" duration="900" delay="800" cssto="transform: scale(1);" cssfrom="transform: scale(0.1);"><span><?php echo do_shortcode($btn_text) ?></span></a>
				</div>
			<?php } ?>
		</div>
		<div class="cell column-2">
			<div class="cell-content">
			<?php if (!empty($small_image)) {?>
				<img src="<?php echo $small_image?>" class="small-image transition" duration="600" delay="400" easing="easeInOutBack" cssto="opacity:1;transform:scale(1)" cssfrom="opacity:0;transform:scale(0.3)" />
			<?php }?>
			<?php if (!empty($big_image)) { ?>			
				<img src="<?php echo $big_image?>"   class="big-image transition"   duration="750" delay="0"   easing="easeInOutSine" cssto="bottom:0;opacity:1"           cssfrom="opacity:0;bottom:-200px" />
			<?php }?>
			</div>
		</div>
	</div>
</div>