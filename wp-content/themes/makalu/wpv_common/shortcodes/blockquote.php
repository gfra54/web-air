<?php

function wpv_shortcode_blockquote($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'align' => false,
		'cite' => false,
	), $atts));
	
	$align = $align? "class='align$align'" : '';
	$cite = $cite? "<span class='cite'>$cite</span>" : '';
	
	ob_start();
?>
	<blockquote <?php echo $align?>><div><?php echo do_shortcode($content).$cite ?></div></blockquote>
<?php

	return ob_get_clean();
}
add_shortcode('blockquote', 'wpv_shortcode_blockquote');