<?php
$className = array('linkarea', $hover_color);
if (!empty($class))
	$className[] = $class;

if(!empty($background_color))
	$className[] = 'background-'.$background_color;
$className = implode(' ', $className);

$attrs = 'class="' . $className . '"';

if (!empty($hoverclass)) {
	$attrs .= ' data-hoverclass="' . $hoverclass . '"';
}
if (!empty($activeclass)) {
	$attrs .= ' data-activeclass="' . $activeclass . '"';
}
if (!empty($href)) {
	$attrs .= ' data-href="' . $href . '"';
	if (!preg_match('/^(javascript:|#)/i', $href)) {
		$attrs .= ' title="' . $href . '"';
	}
	$attrs .= ' tabindex="1"';
}
if (!empty($target)) {
	$attrs .= ' data-target="' . $target . '"';
}
if (!empty($style)) {
	$attrs .= ' style="' . $style . '"';
}
?>

<div <?php echo $attrs?>>
	<?php if (!empty($image)) { ?>
	<div class="row">
		<div class="grid-2-6 first"><img src="<?php echo $image?>" alt="" /></div>
		<div class="grid-4-6 last"><?php echo do_shortcode($content)?></div>
	</div>
	<?php } else { 
		echo do_shortcode($content);
	} ?>
</div>