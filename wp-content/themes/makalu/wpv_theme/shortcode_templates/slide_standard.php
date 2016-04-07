<?php
$bg_css = "opacity:$bg_opacity;background-color:$bg_color;";
if (!empty($bg_image)) {
	$bg_css .= "background-image:url('$bg_image');";
}
?>
<div style="<?php echo $bg_css?>" class="slide-bg html-slide-standart"></div>
<div class="limit-wrapper html-slide-standart scale-font <?php echo $class?>">
	<div class="table">
		<div class="cell scale-font" style="text-align:<?php echo $x_align?>;vertical-align:<?php echo $y_align?>;"><?php echo do_shortcode($content) ?></div>
	</div>
</div>