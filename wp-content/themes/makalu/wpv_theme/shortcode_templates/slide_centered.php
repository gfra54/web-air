<?php
$bg_css = 'background:';
if (!empty($bg_image)) {
	$bg_css .= "url('$bg_image') center bottom no-repeat scroll ";
}
$bg_css .= $bg_color;
?>
<div style="<?php echo $bg_css?>" class="slide-bg transition" cssfrom="opacity:0" cssto="opacity:<?php echo $bg_opacity?>"></div>
<div class="limit-wrapper html-slide-centered <?php echo $class?>">
	<div class="table">
		<div class="cell scale-font"><?php echo $content?></div>
	</div>
</div>